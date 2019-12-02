<?php

/**
 * Класс конвертер данных
 */

namespace App;

use App\LinkedList\DateListFactory;
use App\LinkedList\LinkedList;
use App\LinkedList\Node;
use App\Output\CollectionResource;
use App\Output\PriceResource;
use App\Price\PriceInput;
use App\Price\PriceNode;
use Exception;

class Converter
{
	/**
	 * Отсортированные связанные списки дат начала заказа, группированные по position_id
	 * @var LinkedList[]
	 */
	protected $lists_by_order_date = [];

	/**
	 * Отсортированные связанные списки дат начала доставки, группированные по position_id
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
		/*
		 * Проходим по всем строкам входящего массива и подготавливаем данные, группируем по position_id
		 */
		foreach ($rows as $row) {
			$price = new PriceInput($row['position_id'], $row['order_date_from'], $row['delivery_date_from'], $row['price']);
			$priceNode = new PriceNode($price);


			$lists_by_order_date[$row['position_id']][] = $priceNode;
			$lists_by_delivery_date[$row['position_id']][] = $priceNode;

			$position_ids[$row['position_id']] = 1;
		}

		$this->position_ids = array_keys($position_ids);

		/*
		 * Создаем отсортированные связанные списки дат начала, группированные по position_id
		 */
		foreach ($this->position_ids as $position_id) {
			$list_by_order_date = $lists_by_order_date[$position_id];
			$list_by_delivery_date = $lists_by_delivery_date[$position_id];

			usort($list_by_order_date, function (PriceNode $a_node, PriceNode $b_node) {
				$a = $a_node->getPrice();
				$b = $b_node->getPrice();
				$a_order_date = $a->order_date_from;
				$b_order_date = $b->order_date_from;
				$a_delivery_date = $a->delivery_date_from;
				$b_delivery_date = $b->delivery_date_from;

				if ($a_order_date === $b_order_date) {
					return $a_delivery_date > $b_delivery_date ? -1 : 1;
				}
				return $a_order_date > $b_order_date ? -1 : 1;

			});

			usort($list_by_delivery_date, function (PriceNode $a_node, PriceNode $b_node) {
				$a = $a_node->getPrice();
				$b = $b_node->getPrice();
				$a_order_date = $a->order_date_from;
				$b_order_date = $b->order_date_from;
				$a_delivery_date = $a->delivery_date_from;
				$b_delivery_date = $b->delivery_date_from;

				if ($a_delivery_date === $b_delivery_date) {
					return $a_order_date > $b_order_date ? 1 : -1;
				}
				return $a_delivery_date > $b_delivery_date ? 1 : -1;

			});

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
		/*
		 * Работаем отдельно с каждой position_id
		 */
		foreach ($this->position_ids as $position_id) {
			$list_by_delivery_date = $this->lists_by_delivery_date[$position_id];
			/*
			 * берем по порядку даты доставки
			 */
			foreach ($list_by_delivery_date as $node) {
				/** @var Node $node */
				/** @var PriceNode $currentPriceNode */

				$currentPriceNode = $node->getValue();
				$currentPrice = $currentPriceNode->getPrice();
				$row = PriceResource::createByInput($currentPrice);

				/*
				 * Если есть еще элемент, устанавливаем delivery_date_to
				 */
				if ($next = $node->next()) {
					/** @var PriceNode $nextDeliveryDateNode */
					$nextDeliveryDateNode = $next->getValue();
					if ($nextDeliveryDateNode) {
						$nextDeliveryDate = $nextDeliveryDateNode->getPrice();
						$row->setDeliveryDateTo($nextDeliveryDate->delivery_date_from);
					}
				}

				$result->add($row);

				$prev = $node;
				while ($prev = $prev->findPrev(function (Node $prevNode) use ($currentPrice) {
					/** @var PriceNode $priceNode */
					$priceNode = $prevNode->getValue();
					/** @var PriceNode $orderNode */
					$orderNode = $priceNode->getNode('order')->getValue();
					$prevOrderPrice = $orderNode->getPrice();
					return $prevOrderPrice->order_date_from < $currentPrice->order_date_from;
				})) {
					/** @var PriceNode $priceNode */
					$priceNode = $prev->getValue();
					/** @var PriceNode $orderNode */
					$orderNode = $priceNode->getNode('order')->getValue();
					$prevOrderPrice = $orderNode->getPrice();

					$additionalRow = new PriceResource(
						$position_id,
						$prevOrderPrice->price,
						$prevOrderPrice->order_date_from,
						$row->getDeliveryDateFrom(),
						$currentPrice->order_date_from,
						null
					);

					if ($row->getDeliveryDateTo()) {
						$additionalRow->setConvertedDeliveryDateTo($row->getDeliveryDateTo());
					}
					$result->add($additionalRow);
					$currentPrice = $prevOrderPrice;
				}
			}
		}

		return $result->toArray();
	}
}

