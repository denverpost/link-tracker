<?php

$source_url = $_SERVER['HTTP_REFERER'];

if (! $source_url ) {
	echo 'Sorry, I don\'t know how to do that.';
	die;
}
$message_version = $_GET['msg'];
$date = date("D M d, Y G:i");

if ($message_version) {
	$line = array($date,$message_version,$source_url);
	var_dump($line);
	if (($handle = fopen("track-subscribe-article.csv", "a")) !== FALSE) {
		fputcsv($handle, $line);
	}
	fclose($handle);
}

header("Location: http://dpo.st/subscribe-article");
exit();