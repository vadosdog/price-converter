<?php

namespace App;

use App\LinkedList\DateListFactory;
use App\LinkedList\LinkedList;
use App\Output\CollectionResource;
use App\Output\PriceResource;
use App\Price\PriceInput;
use App\Price\PriceNode;
use Exception;

class Converter
{
	/**
	 * @var LinkedList[]
	 */
	protected $lists_by_order_date = [];

	/**
	 * @var LinkedList[]
	 */
	protected $lists_by_delivery_date = [];

	/**
	 * @var array
	 */
	protected $position_ids = [];


	/**
	 * Принимает массив согласно ТЗ
	 *
	 * @param array $rows
	 */
	public function __construct(array $rows)
	{
		$lists_by_order_date = [];
		$lists_by_delivery_date = [];
		$position_ids = [];
		foreach ($rows as $row) {
			$price = new PriceInput($row['position_id'], $row['order_date_from'], $row['delivery_date_from'], $row['price']);
			$priceNode = new PriceNode($price);


			$lists_by_order_date[$row['position_id']][$row['order_date_from']] = $priceNode;
			$lists_by_delivery_date[$row['position_id']][$row['delivery_date_from']] = $priceNode;

			$position_ids[$row['position_id']] = 1;
		}

		$this->position_ids = array_keys($position_ids);

		foreach ($this->position_ids as $position_id) {
			$list_by_order_date = $lists_by_order_date[$position_id];
			$list_by_delivery_date = $lists_by_delivery_date[$position_id];

			krsort($list_by_order_date);
			ksort($list_by_delivery_date);

			$this->lists_by_order_date[$position_id] = DateListFactory::build('order', $list_by_order_date);
			$this->lists_by_delivery_date[$position_id] = DateListFactory::build('delivery', $list_by_delivery_date);
		}
	}

	/**
	 *
	 * Метод конвертирует данные в вид согласно ТЗ
	 *
	 * @return array
	 * @throws Exception
	 */
	public function getOutput(): array
	{
		$result = new CollectionResource();
		foreach ($this->position_ids as $position_id) {
			$list_by_delivery_date = $this->lists_by_delivery_date[$position_id];
			foreach ($list_by_delivery_date as $node) {
				/** @var PriceNode $currentPriceNode */
				$currentPriceNode = $node->getValue();
				$currentPrice = $currentPriceNode->getPrice();
				$row = PriceResource::createByInput($currentPrice);


				if ($next = $node->next()) {
					/** @var PriceNode $nextDeliveryDateNode */
					$nextDeliveryDateNode = $next->getValue();
					if ($nextDeliveryDateNode) {
						$nextDeliveryDate = $nextDeliveryDateNode->getPrice();
						$row->setDeliveryDateTo($nextDeliveryDate->delivery_date_from);
					}
				}

				$result->add($row);

				if ($currentOrderNode = $currentPriceNode->getNode('order')) {
					$nextOrderNode = $currentOrderNode;
					while ($nextOrderNode = $nextOrderNode->next()) {
						/** @var PriceNode $nextOrderPriceNode */
						$nextOrderPriceNode = $nextOrderNode->getValue();
						$nextOrderPrice = $nextOrderPriceNode->getPrice();
						if ($nextOrderPrice->delivery_date_from < $currentPrice->delivery_date_from) {
							$row = new PriceResource(
								$currentPrice->position_id,
								$nextOrderPrice->price,
								$nextOrderPrice->order_date_from,
								$currentPrice->delivery_date_from,
								$currentPrice->order_date_from,
								$currentPrice->delivery_date_to
							);
							$result->add($row);
						}
					}
				}
			}
		}

		return $result->toArray();
	}

	protected function generateRow(PriceInput $price)
	{
		return [
			'position_id' => $price->position_id,
			'order_date_from' => $price->order_date_from,
			'order_date_to' => $price->order_date_to,
			'delivery_date_from' => $price->delivery_date_from,
			'delivery_date_to' => $price->order_date_to,
			'price' => $price->price,
		];
	}

}

