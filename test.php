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

$input3 = [
	['position_id' => 1, 'order_date_from' => '2018-08-01', 'delivery_date_from' => '2018-08-01', 'price' => 300],
	['position_id' => 1, 'order_date_from' => '2018-08-03', 'delivery_date_from' => '2018-08-03', 'price' => 140],
	['position_id' => 1, 'order_date_from' => '2018-08-05', 'delivery_date_from' => '2018-08-05', 'price' => 315],
	['position_id' => 1, 'order_date_from' => '2018-08-07', 'delivery_date_from' => '2018-08-07', 'price' => 315],
	['position_id' => 1, 'order_date_from' => '2018-08-07', 'delivery_date_from' => '2018-08-09', 'price' => 170],
	['position_id' => 1, 'order_date_from' => '2018-08-07', 'delivery_date_from' => '2018-08-11', 'price' => 170],
	['position_id' => 1, 'order_date_from' => '2018-08-03', 'delivery_date_from' => '2018-08-13', 'price' => 170],
	['position_id' => 1, 'order_date_from' => '2018-08-07', 'delivery_date_from' => '2018-08-15', 'price' => 140]
];

//$converter = new \App\Converter($input);
//$converter = new \App\Converter($input2);
$converter = new \App\Converter($input3);


$ouput = $converter->getOutput();


$duplicate = [];
$notfound = [];
$orderEnd = new DateTime('2018-08-08');
$deliveryEnd = new DateTime('2018-08-15');
$interval = DateInterval::createfromdatestring('+1 day');
for ($orderDate = new DateTime('2018-08-01'); $orderDate <= $orderEnd; $orderDate->add($interval)) {
	for ($deliveryDate = new DateTime('2018-08-01'); $deliveryDate <= $deliveryEnd; $deliveryDate->add($interval)) {
		$orderDateFormatted = $orderDate->format('Y-m-d');
		$deliveryDateFormatted = $deliveryDate->format('Y-m-d');
		$result = array_filter($ouput, function ($item) use ($orderDateFormatted, $deliveryDateFormatted) {
			return $item['order_date_from'] <= $orderDateFormatted
				&& (!$item['order_date_to'] || $item['order_date_to'] >= $orderDateFormatted)
				&& $item['delivery_date_from'] <= $deliveryDateFormatted
				&& (!$item['delivery_date_to'] || $item['delivery_date_to'] >= $deliveryDateFormatted)
				;
		});
		if (count($result) === 1) {
			continue;
		}

		if (!$result) {
			$notfound[] = [$orderDateFormatted, $deliveryDateFormatted];
		} else {
			$duplicate[] = [$orderDateFormatted, $deliveryDateFormatted];
		}
	}
}
var_dump($notfound, $duplicate);









function echoTr($row)
{
	echo '<tr>';
	echo '<td>' . $row['position_id'] . '</td>';
	echo '<td>' . $row['order_date_from'] . '</td>';
	echo '<td>' . $row['order_date_to'] . '</td>';
	echo '<td>' . $row['delivery_date_from'] . '</td>';
	echo '<td>' . $row['delivery_date_to'] . '</td>';
	echo '<td>' . $row['price'] . '</td>';
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

