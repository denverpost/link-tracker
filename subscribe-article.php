<?php

function _bot_detected() {

  return (
    isset($_SERVER['HTTP_USER_AGENT'])
    && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
  );
}

if (!_bot_detected()){
    function getIP($ip = null, $deep_detect = TRUE){
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        return $ip;
    }
    $client_ip = getIP(null,true);

    $source_url = $_SERVER['HTTP_REFERER'];

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
}

header("Location: http://dpo.st/subscribe-article");
exit();