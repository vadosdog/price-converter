<?php

/**
 * Преобразование цены на выдачу
 */

namespace App\Output;


use App\Interfaces\ResourceInterface;
use App\Price\PriceInput;
use Exception;

class PriceResource implements ResourceInterface
{
	protected $position_id;
	protected $order_date_from;
	protected $order_date_to;
	protected $delivery_date_from;
	protected $delivery_date_to;
	protected $price;

	/**
	 * PriceResource constructor.
	 * @param $position_id
	 * @param $price
	 * @param $order_date_from
	 * @param $delivery_date_from
	 * @param null $order_date_to
	 * @param null $delivery_date_to
	 * @throws Exception
	 */
	public function __construct(
		$position_id,
		$price,
		$order_date_from,
		$delivery_date_from,
		$order_date_to = null,
		$delivery_date_to = null
	)
	{
		$this->position_id = $position_id;
		$this->order_date_from = $order_date_from;
		$this->delivery_date_from = $delivery_date_from;
		if ($order_date_to) {
			$this->setOrderDateTo($order_date_to);
		}
		if ($delivery_date_to) {
			$this->setDeliveryDateTo($delivery_date_to);
		}
		$this->price = $price;
	}

	/**
	 * @param PriceInput $input
	 * @return PriceResource
	 * @throws Exception
	 */
	public static function createByInput(PriceInput $input): PriceResource
	{
		return new self(
			$input->position_id,
			$input->price,
			$input->order_date_from,
			$input->delivery_date_from
		);
	}

	/**
	 * @param string $dateTo
	 * @return string
	 * @throws Exception
	 */
	private function convertDateTo(string $dateTo)
	{
		$dateTime = new \DateTime($dateTo);
		$dateTime->sub(new \DateInterval('P1D'));
		return $dateTime->format('Y-m-d');
	}

	/**
	 * @param string $dateTo
	 * @throws Exception
	 */
	public function setOrderDateTo(string $dateTo)
	{
		$this->order_date_to = $this->convertDateTo($dateTo);
	}

	/**
	 * @param string $dateTo
	 * @throws Exception
	 */
	public function setDeliveryDateTo(string $dateTo)
	{
		$this->delivery_date_to = $this->convertDateTo($dateTo);
	}


	/**
	 * @return string
	 */
	public function getDeliveryDateFrom()
	{
		return $this->delivery_date_from;
	}

	/**
	 * @return string
	 */
	public function getDeliveryDateTo()
	{
		return $this->delivery_date_to;
	}

	//setOrderDateFrom
	//setDeliveryDateFrom
	//getOrderDateFrom
	//getOrderDateTo

	public function toArray(): array
	{
		return [
			'position_id' => $this->position_id,
			'order_date_from' => $this->order_date_from,
			'order_date_to' => $this->order_date_to,
			'delivery_date_from' => $this->delivery_date_from,
			'delivery_date_to' => $this->delivery_date_to,
			'price' => $this->price,
		];
	}
}
