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

$input2 = [
	['position_id' => 1, 'order_date_from' => '2018-08-01', 'delivery_date_from' => '2018-08-01', 'price' => 300],
	['position_id' => 1, 'order_date_from' => '2018-09-01', 'delivery_date_from' => '2018-09-01', 'price' => 140],
	['position_id' => 1, 'order_date_from' => '2018-09-01', 'delivery_date_from' => '2019-06-10', 'price' => 170],
	['position_id' => 1, 'order_date_from' => '2018-12-25', 'delivery_date_from' => '2018-12-25', 'price' => 315],
	['position_id' => 1, 'order_date_from' => '2019-05-01', 'delivery_date_from' => '2019-05-01', 'price' => 315],
	['position_id' => 1, 'order_date_from' => '2019-05-01', 'delivery_date_from' => '2019-05-06', 'price' => 170],
	['position_id' => 1, 'order_date_from' => '2019-05-01', 'delivery_date_from' => '2019-06-02', 'price' => 170],
	['position_id' => 1, 'order_date_from' => '2019-05-01', 'delivery_date_from' => '2019-07-22', 'price' => 140]
];

$converter = new \App\Converter($input);
//$converter = new \App\Converter($input2);



$ouput = $converter->getOutput();











function echoTr($row)
{
	echo '<tr>';
	echo '<td>' . $row['position_id'] .         '</td>';
	echo '<td>' . $row['order_date_from'] .     '</td>';
	echo '<td>' . $row['order_date_to'] .       '</td>';
	echo '<td>' . $row['delivery_date_from'] .  '</td>';
	echo '<td>' . $row['delivery_date_to'] .    '</td>';
	echo '<td>' . $row['price'] .               '</td>';
	echo '</tr>';
}

echo ' (order_date, delivery_date) 2018-08-01 и 2019-06-10';
echo '<table border="1">';
echoTr([
	'position_id' => 'ID',
	'order_date_from' => 'order_date_from',
	'order_date_to' => 'order_date_to',
	'delivery_date_from' => 'delivery_date_from',
	'delivery_date_to' => 'delivery_date_to',
	'price' => 'price',
]);
foreach ($converter->getOutput() as $row) {
	echoTr($row);
}
echo '</table>';

