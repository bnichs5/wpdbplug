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
	$link9 = 'https://plex3.herokuapp.com/cdn/' . ($link7 . $link5 . $link8);
       
	/*   print_r($link9);   */
	/*   echo '<P>';   */
						
						/*The below function will scan the plex search url and insert the findings onto this page. */
                   
            /*		function produce_XML_object_tree($raw_XML) {
                        	
                            $xmlTree = new SimpleXMLElement($raw_XML, LIBXML_NOWARNING & LIBXML_NOERROR);
                        
                        return $xmlTree;
                    }

                    $xml_feed_url = $link9;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $xml_feed_url);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $xml = curl_exec($ch);
                    curl_close($ch);

                    $cont = produce_XML_object_tree($xml);   */
            		$cont = @simplexml_load_file($link9);
					/*  echo 'test1';  */
					if((($cont->attributes()-size) != 4) && (!empty($cont))){
	foreach($cont as $a=>$b){
         
        if($b->attributes()->type == 'movie'){  /* Make sure that the item is a movie before scanning further. if its an episode it will be skipped.  */
            $d = $b->attributes()->title;   /*  $d is the Original Title the way that plex has it listed in their database.   */
            
            $dd = $b->attributes()->year;  /*  $dd is the year the movie was released according to Plex's database.   */
           /*  echo '<P> D=' . $d . ' link5=' . $link5 . '<P> ';  */  /* $link5 has pluses (+) instead of spaces.   */
          /*  echo '<P> D= ' . preg_replace('/[^ \w]+/', '', $d) . ' link5=' . preg_replace('/[^ \w]+/', '', urldecode($link5)) . '<P>';   */
            if(strtolower(preg_replace('/[^ \w]+/', '', $d)) == strtolower(preg_replace('/[^ \w]+/', '', urldecode($link5)))){  
            
          /*  if(($dd == $link55) or ($dd ==($link55+1)) or ($dd ==($link55-1))){    */      /* this line compares the years also plus or minus one year   -  remove this becase Movie House 2008 is showing American Pie Beta House 2007 movie - instead the line below just compares the plex release year to tmdb release year. No plus or minus one year. */   
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
            if($remember == ''){
      /*    echo urldecode($link5);   */
       
       $newlink=explode("+", $link5);
       if($newlink[0] != 'at' || 'and' || 'the' || 'an' || 'a' || 'of' || 'or' ){$newlink2 = $newlink[0];}else{$newlink2 = $newlink[1];} 
       /* if(strlen($newlink[0]) > 3){$newlink2 = $newlink[0];}else{$newlink2 = $newlink[1];}      */           
                     
       if(strpos(urldecode($newlink2), '!') !== FALSE){$newlink2 = str_replace('!','',urldecode($newlink2));}; 
       if(strpos(urldecode($newlink2), '?') !== FALSE){$newlink2 = str_replace('?','',urldecode($newlink2));};
       if(strpos(urldecode($newlink2), '@') !== FALSE){$newlink2 = str_replace('@','',urldecode($newlink2));}; 
       if(strpos(urldecode($newlink2), '#') !== FALSE){$newlink2 = str_replace('#','',urldecode($newlink2));};   
       if(strpos(urldecode($newlink2), '$') !== FALSE){$newlink2 = str_replace('$','',urldecode($newlink2));}; 
       if(strpos(urldecode($newlink2), '%') !== FALSE){$newlink2 = str_replace('%','',urldecode($newlink2));}; 
       if(strpos(urldecode($newlink2), '^') !== FALSE){$newlink2 = str_replace('^','',urldecode($newlink2));}; 
       if(strpos(urldecode($newlink2), '&') !== FALSE){$newlink2 = str_replace('&','',urldecode($newlink2));}; 
       if(strpos(urldecode($newlink2), '*') !== FALSE){$newlink2 = str_replace('*','',urldecode($newlink2));}; 
                        
                        
                        
                        
       /*  echo $newlink2;   */
       $link10 =   'https://plex3.herokuapp.com/cdn/' . ($link7 . $newlink2 . $link8);               
                    /*   echo $link10;  */
                        
                    
                        
                /*    $xml_feed_url2 = $link10;
                    $ch2 = curl_init();
                    curl_setopt($ch2, CURLOPT_URL, $xml_feed_url2);
                    curl_setopt($ch2, CURLOPT_HEADER, false);
                    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                    $xml2 = curl_exec($ch2);
                    curl_close($ch2);

                    $cont2 = produce_XML_object_tree($xml2);   */
					$cont2 = @simplexml_load_file($link10);
                if(!empty($cont2)){
	foreach($cont2 as $a2=>$b2){
        
        if($b2->attributes()->type == 'movie'){
            
            $d2 = $b2->attributes()->title;
            $dd2 = $b2->attributes()->year;
            $link555 = str_replace('+', ' ', $link5);
        /*    echo '<p>link555 = ' . urldecode($link555) . '<p>'; 
            echo '<P>D2= ' . preg_replace('/[^ \w]+/', '', $d2) . '<P>';
            echo '<P>link5= ' . preg_replace('/[^ \w]+/', '', urldecode($link5)) . '<P>';
            echo '<P>newlink2 = ' . preg_replace('/[^ \w]+/', '', urldecode($newlink2)) . '<P>';   */
            
            
         /*     echo '<P>D2 = ' . $d2 . '<P>';   
            echo '<P> D2 = ' . str_replace(' ', '', preg_replace('/[^ \w]+/', '', $d2)); 
            echo '<p> link5 = ' . str_replace(' ', '', preg_replace('/[^ \w]+/', '', urldecode($link5)));   */
            
            
            /* Check if space exists in either titles to indicate that the title has more than one word  */
         /*   if(strpos(preg_replace('/[^ \w]+/', '', $d2), ' ') !== FALSE ){echo '<P> D2 contains a space<P>';}
            if(strpos(preg_replace('/[^ \w]+/', '', urldecode($link5)), ' ') !== FALSE ){echo '<P>link5 contains a space<P>';}     */
            $removeSpaceAndSpecialFrom_d2 = strtolower(str_replace(' ', '', preg_replace('/[^ \w]+/', '', $d2)));
            $removeSpaceAndSpecialFrom_link5 = strtolower(str_replace(' ', '', preg_replace('/[^ \w]+/', '', urldecode($link5))));
          /*  echo 'compare1 = ' . $removeSpaceAndSpecialFrom_d2 . '<P>'; echo  'compare2 = ' . $removeSpaceAndSpecialFrom_link5 . '<P>';   */
            
            if((((strpos($removeSpaceAndSpecialFrom_d2, $removeSpaceAndSpecialFrom_link5) !== false) || (strpos($removeSpaceAndSpecialFrom_link5, $removeSpaceAndSpecialFrom_d2) !== false)) && (!empty($newlink[1]))) || (strtolower(str_replace(' ', '', preg_replace('/[^ \w]+/', '', $d2))) == strtolower(str_replace(' ', '', preg_replace('/[^ \w]+/', '', urldecode($link5)))))){
            
            /* if((strpos(preg_replace('/[^ \w]+/', '', $d2), strpos(preg_replace('/[^ \w]+/', '', urldecode($link5))) !== false)){}  */
            
            /*  if(strtolower(str_replace(' ', '', preg_replace('/[^ \w]+/', '', $d2))) == strtolower(str_replace(' ', '', preg_replace('/[^ \w]+/', '', urldecode($link5))))){  */
            /*   echo 'd2 and link5 are the same here';   */
            if(($dd2 == $link55) or ($dd2 == ($link55 + 1)) or ($dd2 == ($link55 - 1))){          /*compares the year from plex with tmdb*/
             /*   if($dd2 == $link55){   */
            /*   echo '<p> D2(2)= ' . preg_replace('/[^A-Za-z0-9\-]/', '', $d2) . '<P>';
            echo '<p> D2(2) = ' .  preg_replace('/[^ \w]+/', '', $d2) . '<P>';
            echo '<p> link5(2) = ' .  preg_replace('/[^ \w]+/', '', urldecode($link5)) . '<P>';  */
            
            $e2 = $b2->attributes()->key;
            
            foreach($b2 as $ween2=>$peen2){
                $bitrate2 = $peen2->attributes()->bitrate;
               
                $videoResolution2 = $peen2->attributes()->videoResolution;
                
                $videoCodec2 = $peen2->attributes()->videoCodec;
                
                foreach($peen2 as $yeet2=>$yeet22){    
                	
                    if($yeet22->attributes()->key != ''){
                        $key22 = $yeet22->attributes()->key; $newarr[2] = $key22;
                    };
                    if($yeet22->attributes()->duration){
                        $duration2 = $yeet22->attributes()->duration; 
                        $newarr[3] = $duration2;
                    };
                    if($yeet22->attributes()->file != ''){
                        $fileName2 = $yeet22->attributes()->file; 
                        /* $fileName2 = trim(substr($fileName2, strrpos($fileName2, '\\') + 1)); */   
                        $fileName2 = trim(substr($fileName2, strrpos($fileName2, '/') + 1));   
                        $newarr[0] = $fileName2;
                    }
                    if($yeet22->attributes()->size != ''){
                        $fileSize2 = $yeet22->attributes()->size; 
                        $newarr[1] = $fileSize2;
                    }
                    if(($yeet22->attributes()->size < 22548578304)){
                        $final2 = ('<p> <a href="nplayer-https://plex3.herokuapp.com/cdn/' . substr($link7, 0, -13) . substr($newarr[2], 1) . '?' . substr($link8, 1) . '" style="color:orange;">' . $newarr[0]  . '</a>   || <p style="color:orange;">     FileSize: ' . round($newarr[1]/1024/1024/1024, 2) . 'GB  ||  Duration:  '. round($duration2/60000) . ' mins   ||  BitRate: ' . round($bitrate2/1000, 2)  . ' Mb/s || Video Codec: ' . $videoCodec2 . ' ||  Video Resolution: ' . $videoResolution2 . '</p>');
                        
                        $final3 = ('<p> <a href="nplayer-' . substr($link7, 0, -13)  . 'video/:/transcode/universal/start.mp4?X-Plex-Platform=Chrome&directPlay=1&copyts=1&protocol=dash&fastSeek=1&mediaIndex=0&offset=0&path=' . $e2 . '&' . substr($link8, 1) .'">Link2</a>'); /*  %2Flibrary%2Fmetadata%2F  */
                        print_r($final2);
                        /* print_r($final3);   This is a test. but make sure it doesnt get picked up by Tautulli    */      
                        $keepinmem = $final2;
                    }
                }
            }
        }}    }   
    }               } 
                        
                        if($keepinmem == ''){ /*   This only runs if the above two do not find any results even when there should be. Fo instance, searching for die, hard, or vengence will not show up in the search results. but if you search for 'die hard' specifically, it shows up. Thererfore this function will search for the first two words of the title      */
                        
                        
                         /*    echo urldecode($link5);  */
       
                               $newlink3=explode("+", $link5);
                               if(!empty($newlink3[1])){
                               $newlink4 = $newlink3[0] . ' ' . $newlink3[1]; 
                               
                               if(strpos(urldecode($newlink4), '!') !== FALSE){$newlink4 = str_replace('!','',urldecode($newlink4));}; 
                               if(strpos(urldecode($newlink4), '?') !== FALSE){$newlink4 = str_replace('?','',urldecode($newlink4));};
                               if(strpos(urldecode($newlink4), '@') !== FALSE){$newlink4 = str_replace('@','',urldecode($newlink4));}; 
                               if(strpos(urldecode($newlink4), '#') !== FALSE){$newlink4 = str_replace('#','',urldecode($newlink4));};   
                               if(strpos(urldecode($newlink4), '$') !== FALSE){$newlink4 = str_replace('$','',urldecode($newlink4));}; 
                               if(strpos(urldecode($newlink4), '%') !== FALSE){$newlink4 = str_replace('%','',urldecode($newlink4));}; 
                               if(strpos(urldecode($newlink4), '^') !== FALSE){$newlink4 = str_replace('^','',urldecode($newlink4));}; 
                               if(strpos(urldecode($newlink4), '&') !== FALSE){$newlink4 = str_replace('&','',urldecode($newlink4));}; 
                               if(strpos(urldecode($newlink4), '*') !== FALSE){$newlink4 = str_replace('*','',urldecode($newlink4));}; 
                               if(strpos(urldecode($newlink4), ':') !== FALSE){$newlink4 = str_replace(':','',urldecode($newlink4));}; 
                            




                               /*  echo $newlink2;   */
                               $link11 =   'https://plex3.herokuapp.com/cdn/' . ($link7 . str_replace(' ','%20',$newlink4) . $link8);               
                                              /*  echo $link11;  */



                                      /*      $xml_feed_url3 = $link11;
                                            $ch3 = curl_init();
                                            curl_setopt($ch3, CURLOPT_URL, $xml_feed_url3);
                                            curl_setopt($ch3, CURLOPT_HEADER, false);
                                            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                                            $xml3 = curl_exec($ch3);
                                            curl_close($ch3);

                                            $cont3 = produce_XML_object_tree($xml3);   */
											$cont3 = $cont = @simplexml_load_file($link11);
											if(!empty($cont3)){
                                            foreach($cont3 as $a3=>$b3){

                                                    if($b3->attributes()->type == 'movie'){

                                                        $d3 = $b3->attributes()->title;
                                                        $dd3 = $b3->attributes()->year;
                                                        $link555 = str_replace('+', ' ', $link5);
                                                     /*   echo '<p>link555 = ' . urldecode($link555) . '<p>'; 
                                                        echo '<P>D3= ' . preg_replace('/[^ \w]+/', '', $d3) . '<P>';
                                                        echo '<P>link5= ' . preg_replace('/[^ \w]+/', '', urldecode($link5)) . '<P>';
                                                        echo '<P>newlink4 = ' . preg_replace('/[^ \w]+/', '', urldecode($newlink4)) . '<P>';   */


                                                        /* echo '<P>' . $d2 . '<P>';   */
                                                     /*   echo 'remove colon and space from D3 = ' . str_replace(' ', '', preg_replace('/[^ \w]+/', '', $d3)); 
                                                        echo 'remove colon and space from link5 = ' . str_replace(' ', '', preg_replace('/[^ \w]+/', '', urldecode($link5)));   */

                                                        $removeSpaceAndSpecialFrom_d3 = strtolower(str_replace(' ', '', preg_replace('/[^ \w]+/', '', $d3)));
                                                        $removeSpaceAndSpecialFrom_link5 = strtolower(str_replace(' ', '', preg_replace('/[^ \w]+/', '', urldecode($link5))));
                                                    /*    echo 'compare1 = ' . $removeSpaceAndSpecialFrom_d3 . '<P>'; echo  'compare2 = ' . $removeSpaceAndSpecialFrom_link5 . '<P>';
                                                        if(strpos('hithere','hi') !== false){echo 'bitch';}
                                                        if(((strpos($removeSpaceAndSpecialFrom_d3, $removeSpaceAndSpecialFrom_link5)) !== false) || ((strpos($removeSpaceAndSpecialFrom_link5, $removeSpaceAndSpecialFrom_d3)) !== false)){ echo 'test indiana jones raiders of lost ark';}   
                                                        if((strpos($removeSpaceAndSpecialFrom_d3, $removeSpaceAndSpecialFrom_link5) !== false) || (strpos($removeSpaceAndSpecialFrom_link5, $removeSpaceAndSpecialFrom_d3) !== false)){echo 'test indiana jones raiders of lost ark';}    */     
                                                        if((strpos($removeSpaceAndSpecialFrom_d3, $removeSpaceAndSpecialFrom_link5) !== false) || (strpos($removeSpaceAndSpecialFrom_link5, $removeSpaceAndSpecialFrom_d3) !== false) || (strtolower(str_replace(' ', '', preg_replace('/[^ \w]+/', '', $d3))) == strtolower(str_replace(' ', '', preg_replace('/[^ \w]+/', '', urldecode($link5)))))){
                                                        
                                                            
                                                            
                                                        
                                                     /*   if(strtolower(str_replace(':', '', preg_replace(str_replace(' ', '', preg_replace('/[^ \w]+/', '', $d3))))) == strtolower(str_replace(':', '', preg_replace(str_replace(' ', '', preg_replace('/[^ \w]+/', '', urldecode($link5))))))){   */
/* echo 'compare d3 and link5';   */
                                                        if(($dd3 == $link55) or ($dd3 == ($link55 + 1)) or ($dd3 == ($link55 - 1))){   
                                                     /*       if($dd3 == $link55){   */
                                                      /*     echo '<p>' . preg_replace('/[^A-Za-z0-9\-]/', '', $d2) . '<P>';
                                                        echo '<p>' .  preg_replace('/[^ \w]+/', '', $d2) . '<P>';
                                                        echo '<p>' .  preg_replace('/[^ \w]+/', '', urldecode($link5)) . '<P>';  */

                                                        $e3 = $b3->attributes()->key;

                                                        foreach($b3 as $ween3=>$peen3){
                                                            $bitrate3 = $peen3->attributes()->bitrate;

                                                            $videoResolution3 = $peen3->attributes()->videoResolution;

                                                            $videoCodec3 = $peen3->attributes()->videoCodec;

                                                            foreach($peen3 as $yeet3=>$yeet33){    

                                                                if($yeet33->attributes()->key != ''){
                                                                    $key33 = $yeet33->attributes()->key; $newarr[2] = $key33;
                                                                    
                                                                };
                                                                if($yeet33->attributes()->duration){
                                                                    $duration3 = $yeet33->attributes()->duration; 
                                                                    $newarr[3] = $duration3;
                                                                };
                                                                if($yeet33->attributes()->file != ''){
                                                                    $fileName3 = $yeet33->attributes()->file; 
                                                                    /* $fileName3 = trim(substr($fileName3, strrpos($fileName3, '\\') + 1)); */   
                                                                    $fileName3 = trim(substr($fileName3, strrpos($fileName3, '/') + 1));   
                                                                    $newarr[0] = $fileName3;
                                                                }
                                                                if($yeet33->attributes()->size != ''){
                                                                    $fileSize3 = $yeet33->attributes()->size; 
                                                                    $newarr[1] = $fileSize3;
                                                                }
                                                                if(($yeet33->attributes()->size < 22548578304)){
                                                                    $final4 = ('<p> <a href="nplayer-https://plex3.herokuapp.com/cdn/' . substr($link7, 0, -13) . substr($newarr[2], 1) . '?' . substr($link8, 1) . '" style="color:orange;">' . $newarr[0]  . '</a>   || <p style="color:orange;">     FileSize: ' . round($newarr[1]/1024/1024/1024, 2) . 'GB  ||  Duration:  '. round($duration3/60000) . ' mins   ||  BitRate: ' . round($bitrate3/1000, 2)  . ' Mb/s || Video Codec: ' . $videoCodec3 . ' ||  Video Resolution: ' . $videoResolution3 . '</p>');
                                                                    $final3 = ('<p> <a href="nplayer-' . substr($link7, 0, -13)  . 'video/:/transcode/universal/start.mp4?X-Plex-Platform=Chrome&directPlay=1&copyts=1&protocol=dash&fastSeek=1&mediaIndex=0&offset=0&path=' . $e3 . '&' . substr($link8, 1) .'">Link2</a>'); /*  %2Flibrary%2Fmetadata%2F  */
                                                                    print_r($final4);
                                                                    
                                                                }
                                                            }
                                                        }
                                                    }}      }
                                                }      
                            
                               }
                               }
                            
                            
                            
                            
                            
                            
                            
                            
                            
                        }
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                        
                        
                        
                    }            
                        
                        
                        
                        
                        
 }else{
            
        }

?>
