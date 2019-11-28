<?php

require_once 'vendor/autoload.php';

$input = [
	[
		'position_id' => 1,
		'order_date_from' => '2019-02-01',
		'delivery_date_from' => '2019-03-01',
//		'order_date_from' => '1A1',
//		'delivery_date_from' => '2A2',
		'price' => 100
	],
	[
		'position_id' => 1,
		'order_date_from' => '2019-02-10',
		'delivery_date_from' => '2019-03-10',
//		'order_date_from' => '2B1',
//		'delivery_date_from' => '3B2',
		'price' => 200
	],
	[
		'position_id' => 1,
		'order_date_from' => '2019-02-20',
		'delivery_date_from' => '2019-02-25',
//		'order_date_from' => '3C1',
//		'delivery_date_from' => '1C2',
		'price' => 130
	],
];

$converter = new \App\Converter($input);

var_dump($converter->getOutput());die;

