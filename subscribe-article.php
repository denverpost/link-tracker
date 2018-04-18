<?php

$source_url = $_SERVER['HTTP_REFERER'];
$message_version = $_GET['msg'];
$date = date("D M d, Y G:i");

if ($message_version) {
	$line = array($date,$message_version,$source_url);
	var_dump($line);
	$handle = fopen("track-subscribe-article.csv", "a");
	fputcsv($handle, $line);
	fclose($handle);
}

header("Location: http://dpo.st/subscribe-article");
exit();