<?php

  require_once('facebook.php');
  
$appapikey = '166931483460587';  
$appsecret = '9d933c44f3793a4a2b6012f2efeb69be';  
$facebook = new Facebook($appapikey, $appsecret);  
$user_id = $facebook->require_login();  
$callbackurl = 'http://www.techwikasta.com/app_test/';  
 
 
 
 //initialize an array of quotes  
$quotes= array("Only those who dare to fail greatly can ever achieve greatly.", "Take my wife. Please!", "I believe what doesn't kill you only makes you... STRANGER");  
  
//Select a Random one.  
$i= rand(0, sizeof($quotes)-1);  
  
//print the CSS  
print ('  
<style type="text/css">  
 h1{ margin: 10px; font-size: 24pt; }  
 h2{ margin: 15px; font-size: 20pt; }  
</style>  
');  
  
print "<h1>Nettuts Quotes</h1>";  
print "<h2>". $quotes[$i] ."</h2>";  
?> 