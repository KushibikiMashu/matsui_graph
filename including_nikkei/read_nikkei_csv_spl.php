<?php

$csv = [];

$file = new SplFileObject('N225.csv');
$file->setFlags(SplFileObject::READ_CSV);

$timestamp = [];
$nikkei    = [];

foreach($file as $line){

	// NULLがある行はスキップする
	// $line[4] === 'null'が使えない
	if(count($line[4]) === 4){
		return;
	}

	$timestamp = strtotime($line[0]) . '000';

	$nikkei[]  = [(int)$timestamp, (float)substr($line[4], 0, 8)];
}

var_dump(count($nikkei));

$nikkei = json_encode($nikkei);

file_put_contents('json/nikkei.json', $nikkei);

