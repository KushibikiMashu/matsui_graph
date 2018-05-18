<?php

$csv = [];

$file = 'import_test_sinyou_0501.csv';
$fp = fopen($file, 'r');

$timestamp = [];
$date  = [];
$sell  = [];
$buy   = [];

while (( $csv_data = fgetcsv( $fp, 0, "," )) !== false ){

	$timestamp = strtotime($csv_data[0]) . '000';

	$sell[] = [(int)$timestamp, (float)$csv_data[1]];
	$buy[]  = [(int)$timestamp, (float)$csv_data[2]];

}

$sell  = json_encode($sell);
$buy   = json_encode($buy);

file_put_contents('json_csv/sell.json', $sell);
file_put_contents('json_csv/buy.json', $buy);