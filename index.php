<?php
  $app_id = '166931483460587';
  $app_secret = '9d933c44f3793a4a2b6012f2efeb69be';
  $my_url = 'http://www.techwikasta.com/app_test/';

  $code = $_REQUEST["code"];

 // auth user
 if(empty($code)) {
    $dialog_url = 'https://www.facebook.com/dialog/oauth?client_id=' 
    . $app_id . '&redirect_uri=' . urlencode($my_url).'&scope=email,read_stream' ;
    echo("<script>top.location.href='" . $dialog_url . "'</script>");
  }

  // get user access_token
  $token_url = 'https://graph.facebook.com/oauth/access_token?client_id='
    . $app_id . '&redirect_uri=' . urlencode($my_url) 
    . '&client_secret=' . $app_secret 
    . '&code=' . $code;

  // response is of the format "access_token=AAAC..."
  $access_token = substr(file_get_contents($token_url), 13);

  // run fql query
  $fql_query_url = 'https://graph.facebook.com/'
    . 'fql?q=SELECT+name+,+friend_count+FROM+user+where+uid+IN+(+SELECT+uid2+FROM+friend+WHERE+uid1=me()+)+ORDER+BY+friend_count+DESC'
    . '&access_token=' . $access_token;
  $fql_query_result = file_get_contents($fql_query_url);
  $fql_query_obj = json_decode($fql_query_result, true);
  

  // display results of fql query
  echo '<pre>';
  print_r("query results for No.of Friends of your friends (sorted):");
  print_r($fql_query_obj);
  echo '</pre>';
  
  
  // run fql query
 /* $fql_query_url2 = 'https://graph.facebook.com/'
    . 'fql?q=SELECT+user_id+FROM+like+where+object_id+IN+(+SELECT+object_id+FROM+like+WHERE+user_id=me()+)'
    . '&access_token=' . $access_token;
  */
  $fql_query_url2 = 'https://graph.facebook.com/'
    . 'fql?q=SELECT+url+,+total_count+FROM+link_stat+where+url+IN+(+SELECT+url+FROM+url_like+WHERE+user_id+IN+(+SELECT+uid2+FROM+friend+Where+uid1=me()+)+)+ORDER+BY+total_count+DESC'
    . '&access_token=' . $access_token;
	$fql_query_result2 = file_get_contents($fql_query_url2);
  $fql_query_obj2 = json_decode($fql_query_result2, true);
  
  
  // display results of fql query
  echo '<pre>';
  print_r("query results for the maximum likes/shares/comments (actually the sum of these three) and any of the link liked/shared/commentd by any of immediate friend in your social circle :");
  print_r($fql_query_obj2);
  echo '</pre>';
  
?>