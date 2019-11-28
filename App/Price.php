<?php


namespace App;


class Price
{
	public $position_id;
	public $order_date_from;
	public $order_date_to;
	public $delivery_date_from;
	public $delivery_date_to;
	public $price;

	public function __construct($position_id, $order_date_from, $delivery_date_from, $price)
	{
		$this->position_id = $position_id;
		$this->order_date_from = $order_date_from;
		$this->delivery_date_from = $delivery_date_from;
		$this->price = $price;
	}
}
