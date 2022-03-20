<?php
    set_time_limit(99999);
	ini_set('max_execution_time', 99999);
    $timer_start = microtime(true);


function produce_XML_object_tree($raw_XML) {
    libxml_use_internal_errors(true);
    try {
        $xmlTree = new SimpleXMLElement($raw_XML);
    } catch (Exception $e) {
        // Something went wrong.
        $error_message = 'SimpleXMLElement threw an exception.';
        foreach(libxml_get_errors() as $error_line) {
            $error_message .= "\t" . $error_line->message;
        }
        trigger_error($error_message);
        return false;
    }
    return $xmlTree;
}



	$remember = '';
	$keepinmem = '';

	$link = urlencode($_GET['d']);
	print_r($link . '<p>');
	$link2 = explode ("qqqq", $link);  /*This is an array split into 4 sections from the url. part one is the encrypted base url, part two is the movie title, part three is the movie release year, and part four is the plex token. */
	print_r($link2 . '<p>');
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



print_r($link4 . '<p>');
print_r($link5 . '<p>');
print_r($link55 . '<p>');
print_r($link6 . '<p>');
print_r($link7 . '<p>');
print_r($link8 . '<p>');



/* This will determine if the plex server is online or has been shutdown or just restarting/offline. */
        $handle4 = curl_init(substr($link7, 0, -13) . '?' . substr($link8, 1));
        curl_setopt($handle4,  CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($handle4, CURLOPT_TIMEOUT, 10);

        $response4 = curl_exec($handle4);
        $httpCode4 = curl_getinfo($handle4, CURLINFO_HTTP_CODE);
        curl_close($handle4);

        if($httpCode4 >= 200 && $httpCode4 <= 400) {
       



	/*This combines the pieces together to create the plex url for searching for the movie. */
	$link9 =  ($link7 . $link5 . $link8);
       
	   print_r($link9 . '<P>');   
            
     
          
      $xml11 = file_get_contents($link9);
      file_put_contents("./temp/yourxml.xml", $xml11); 
          
          
          
            
	   $xml_feed_url = $link9;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $xml_feed_url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$xml = curl_exec($ch);
curl_close($ch);

$cont = produce_XML_object_tree($xml);

	   print_r($cont . '<P>');	
	   
	   	
		
	}	
		
		

?>
