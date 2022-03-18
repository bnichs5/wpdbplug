<?php
    set_time_limit(99999);
	ini_set('max_execution_time', 99999);
    $timer_start = microtime(true);


	$remember = '';
	$keepinmem = '';

	$link = urlencode($_GET['d']);
	$link2 = explode ("qqqq", $link);  /*This is an array split into 4 sections from the url. part one is the encrypted base url, part two is the movie title, part three is the movie release year, and part four is the plex token. */
	
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
       
	   print_r($link9);   
	/*   echo '<P>';   */
						
						/*The below function will scan the plex search url and insert the findings onto this page. */
                   
           
            		$cont = @simplexml_load_file($link9);
					/*  echo 'test1';  */
					if((($cont->attributes()-size) != 4) && (!empty($cont))){
	foreach($cont as $a=>$b){
         
        if($b->attributes()->type == 'movie'){  /* Make sure that the item is a movie before scanning further. if its an episode it will be skipped.  */
            $d = $b->attributes()->title;   /*  $d is the Original Title the way that plex has it listed in their database.   */
            
            $dd = $b->attributes()->year;  /*  $dd is the year the movie was released according to Plex's database.   */
         
            if(strtolower(preg_replace('/[^ \w]+/', '', $d)) == strtolower(preg_replace('/[^ \w]+/', '', urldecode($link5)))){  
            
          
            if(($dd == $link55)){
            $e = $b->attributes()->key;
            
            foreach($b as $ween=>$peen){
                $bitrate = $peen->attributes()->bitrate;
               
                $videoResolution = $peen->attributes()->videoResolution;
                
                $videoCodec = $peen->attributes()->videoCodec;
                
                foreach($peen as $yeet=>$yeet2){    
                	
                    if($yeet2->attributes()->key != ''){
                        $key2 = $yeet2->attributes()->key; $newarr[2] = $key2;
                    };
                    if($yeet2->attributes()->duration){
                        $duration = $yeet2->attributes()->duration; 
                        $newarr[3] = $duration;
                    };
                    if($yeet2->attributes()->file != ''){
                        $fileName = $yeet2->attributes()->file; 
                        /* $fileName = trim(substr($fileName, strrpos($fileName, '\\') + 1)); */   
                        $fileName = trim(substr($fileName, strrpos($fileName, '/') + 1));   
                        $newarr[0] = $fileName;
                    }
                    if($yeet2->attributes()->size != ''){
                        $fileSize = $yeet2->attributes()->size; 
                        $newarr[1] = $fileSize;
                    }
                    if(($yeet2->attributes()->size < 22548578304)){
                        $final = ('<p> <a href="nplayer-https://plex3.herokuapp.com/cdn/' . substr($link7, 0, -13) . substr($newarr[2], 1) . '?' . substr($link8, 1) . '" style="color:orange;">' . $newarr[0]  . '</a>   || <p  style="color:orange;">     FileSize: ' . round($newarr[1]/1024/1024/1024, 2) . 'GB  ||  Duration:  '. round($duration/60000) . ' mins   ||  BitRate: ' . round($bitrate/1000, 2)  . ' Mb/s || Video Codec: ' . $videoCodec . ' ||  Video Resolution: ' . $videoResolution . '</p>');
                        print_r($final);
                        $remember = $final;
                    }
                }
            }
        }     
        }     
        }    
    }
 }
              
                        
                        
                        
 }else{
            
        }

?>
