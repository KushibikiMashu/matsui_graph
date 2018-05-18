<?php

$csv = [];

$file = new SplFileObject('N225.csv');
$file->setFlags(SplFileObject::READ_CSV);

$timestamp = [];
$nikkei    = [];

$count = [];

foreach($file as $line){

	// NULLがある行はスキップする
	// $line[4] === 'null'が使えない
	if(strlen($line[4]) === 4){
		continue;
	}

	// 日付が2017-11-03は祝日なのに、日経平均データには数字が入っているため除外
	if($line[0] === '2017-11-03'){
		continue;
	}

	$timestamp = strtotime($line[0]) . '000';

	// 配列$nikkeiの要素の個数は1307
	$nikkei[]  = [(int)$timestamp, (float)substr($line[4], 0, 8)];
}



$file = new SplFileObject('import_test_sinyou_0501.csv');
$file->setFlags(SplFileObject::READ_CSV);

$timestamp = [];
$sell  = [];
$buy   = [];

foreach($file as $line){

	$timestamp = strtotime($line[0]) . '000';

	// 配列$buy, $sellの要素の個数は1305
	$sell[] = [(int)$timestamp, (float)$line[1]];
	$buy[]  = [(int)$timestamp, (float)$line[2]];

}


// $nikkeiと$buy/$sellの配列の日付を一致させる

$nikkei_date = [];
$buy_date = [];

// $nikkeiの時間を配列に入れる

foreach($nikkei as $key => $value){
	$nikkei_date[] = $value[0];
}

// $buyの時間を配列に入れる

foreach($buy as $key => $value){
	$buy_date[] = $value[0];
}

// array_diffとる
$diff = array_diff($nikkei_date, $buy_date);

var_dump($diff);


$sell  = json_encode($sell);
$buy   = json_encode($buy);

$nikkei = json_encode($nikkei);

file_put_contents('json/nikkei.json', $nikkei);

file_put_contents('json/sell.json', $sell);
file_put_contents('json/buy.json', $buy);
