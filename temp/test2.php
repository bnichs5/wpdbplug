<?php
    set_time_limit(99999);
	ini_set('max_execution_time', 99999);
    $timer_start = microtime(true);


	$remember = '';
	$keepinmem = '';

	$link = urlencode($_GET['d']);
	print_r($link);
	$link2 = explode ("qqqq", $link);  /*This is an array split into 4 sections from the url. part one is the encrypted base url, part two is the movie title, part three is the movie release year, and part four is the plex token. */
	print_r($link2);
	$newarr = array();


	$link4 = $link2[0];
	$link5 = $link2[1];
	$link55 = $link2[2];
	$link6 = $link2[3];
	

	/*The below decrypts the first and last part of the URL but only once.  */
	$link7 = base64_decode($link4);
	$link8 = base64_decode($link6);

	/*The below function removess the cipher associated with the second base64 decryption.  */
	function test($s, $n) {
   		return substr($s,0,$n).substr($s,$n+1,strlen($s)-$n);
	};

	$link7 = test($link7, 5);
	$link7 =  test($link7, 9);
	$link7 =  test($link7, 12);
	$link7 =  test($link7, 14);
	$link7 =  test($link7, 15);
	$link7 =  test($link7, 15);

	$link8 = test($link8, 5);
	$link8 =  test($link8, 9);
	$link8 =  test($link8, 12);
	$link8 =  test($link8, 14);
	$link8 =  test($link8, 15);
	$link8 =  test($link8, 15);

	/*This decodes base64 one more time to get the usually Base URL and Plex TOken. */
	$link7 = base64_decode($link7);
	$link8 = base64_decode($link8);



print_r($link4);
print_r($link5);
print_r($link55);
print_r($link6);
print_r($link7);
print_r($link8);
print_r($link8);


?>
