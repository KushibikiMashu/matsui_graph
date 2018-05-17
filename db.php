<?php

header('Content-Type: text/html; charset=UTF-8');

// ビットコインの現在価格をデータベースから取得する
try
{
$dsn='mysql:host=127.0.0.1;dbname=stock;charset=utf8';
$user='root';
$password='root';
$pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
}
catch (Exception $e)
{
	print 'データーベース接続エラー発生';
	print '現在、復旧作業中です。しばらくお待ちください。';
	exit();
}

// 最高値のデータ（カラム名をキーにした連想配列）	
$sql = 'SELECT * FROM stock';

$stmt = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$date_data  = [];
$sell_data  = [];
$buy_data   = [];

foreach($stmt as $key => $value) {
	$date_data[]  = $value['date'];
	$sell_data[]  = $value['sell'];
	$buy_data[]   = $value['buy'];
}

$timestamp = [];
$date  = [];
$sell  = [];
$buy   = [];

for($i=0, $len = count($date_data); $i < $len; $i++){

	$timestamp[] = strtotime($date_data[$i]) . '000';

	$sell[] = [(int)$timestamp[$i], (int)$sell_data[$i]];
	$buy[]  = [(int)$timestamp[$i], (int)$buy_data[$i]];
}


$sell  = json_encode($sell);
$buy   = json_encode($buy);

file_put_contents('json/sell.json', $sell);
file_put_contents('json/buy.json', $buy);