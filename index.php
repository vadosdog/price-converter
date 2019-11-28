<?php

require_once 'vendor/autoload.php';

$input = [
	[
		'position_id' => 1,
		'order_date_from' => '2019-02-01',
		'delivery_date_from' => '2019-03-01',
		'price' => 100
	],
	[
		'position_id' => 1,
		'order_date_from' => '2019-02-10',
		'delivery_date_from' => '2019-03-10',
		'price' => 200
	],
	[
		'position_id' => 1,
		'order_date_from' => '2019-02-20',
		'delivery_date_from' => '2019-02-25',
		'price' => 130
	],
];

$converter = new \App\Converter($input);

var_dump($converter->getOutput());die;

