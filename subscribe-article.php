<?php

$source_url = $_SERVER['HTTP_REFERER'];
$client_ip = $_SERVER['REMOTE_ADDR'];

$rows = file("track-subscribe-article.csv");
$last_row = array_pop($rows);
$last_data = str_getcsv($last_row);
$message_version = $_GET['msg'];
$date = date("F j, Y, H:i:s");

$source_url = (strrpos($source_url, 'www.denverpost.com') == FALSE) ? '(Referrer data unavailable)' : $source_url;

if ( ! ($message_version == $last_data[1] && $client_ip == $last_data[3] ) ) {
	$line = array($date,$message_version,$source_url,$client_ip);
	if (($handle = fopen("track-subscribe-article.csv", "a")) !== FALSE) {
		fputcsv($handle, $line);
		fclose($handle);
	}
}

header("Location: http://dpo.st/subscribe-article");
exit();