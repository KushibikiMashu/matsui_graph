<?php

$csv = [];

$file = new SplFileObject('import_test_sinyou_0501.csv');
$file->setFlags(SplFileObject::READ_CSV);

$timestamp = [];
$date  = [];
$sell  = [];
$buy   = [];

foreach($file as $line){

	$timestamp = strtotime($line[0]) . '000';

	$sell[] = [(int)$timestamp, (float)$line[1]];
	$buy[]  = [(int)$timestamp, (float)$line[2]];

}

$sell  = json_encode($sell);
$buy   = json_encode($buy);

file_put_contents('json_csv/sell.json', $sell);
file_put_contents('json_csv/buy.json', $buy);

fclose($fp);
