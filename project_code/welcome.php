<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>First screen</title>
<link type="text/css" rel="stylesheet" href="/stylesheets/style.css" />
</head>

<body>

<?php 
cookie
if (isset($_POST['hosting']) && $_POST['hosting'] == 'flickr') {
  
  include_once 'warehouse/oauth.php';
  
  $oauth_base_url = 'https://www.flickr.com/services/oauth/';
  $oauth_secret_key = '8598c21654da2885';
  $oauth_action = array(
    'request_token' => 'request_token',
    'authorize' => 'authorize',
    'access_token' => 'access_token',
  );
  $request_options = array(
    'oauth_nonce' => md5(microtime() . mt_rand()),
    'oauth_timestamp' => time(),
    'oauth_consumer_key' => 'a53f0fe85e9b8c1515514f2359d7922e',
    'oauth_signature_method' => 'HMAC-SHA1',
    'oauth_version' => '1.0',
//  'oauth_callback' => 'http://impression-through-time.appspot.com/oauth/flickr.php',
    'oauth_callback' => 'http://localhost:8080/',
  );
 
  $request_options['oauth_signature'] = create_signature($oauth_base_url, $oauth_action['request_token'], $request_options, $oauth_secret_key);
 
  $url = create_url($oauth_base_url, $oauth_action['request_token'], $request_options, $oauth_secret_key);
  
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $r = curl_exec($ch);
  parse_str($r, $r);
  curl_close($ch);
  
  if ($r['oauth_callback_confirmed'] == 'true') {

    // ok, first step done and we have tokens
    // send user to flickr authorisation page
    $oauth_token = $r['oauth_token'];
    $oauth_token_secret = $r['oauth_token_secret'];
    
    header('Location: ' . $oauth_base_url . $oauth_action['authorize'] . '?oauth_token=' . $oauth_token);    
    
  }
}

if (isset($_GET['oauth_verifier']) && isset($_POST['oauth_token'])) { // @todo add check === oauth_token from storage
  // ok, second step done
  // no we need exchanging the 'request token' for an 'access token'
  
  // @todo!!! mysql, billing, table with sid
  
}


// @todo ajax request instead of submit button

?>

<h3>Your photo hosting</h3>

 <form action="/" method="post">
	<div class="form-radio-row"><input type="radio" name="hosting" value="flickr" checked="checked">Flickr</div>
	<div class="form-radio-row"><input type="radio" name="hosting" value="instagram" disabled="disabled">Instagram <i>(will be soon)</i></div>
	<div class="form-submit-row"><input type="submit" value="Connect"/></div>
</form>

</body>

<pre>
<?php 
  print '<h3>$r:</h3>';
  var_dump($r);

  print '<h3>$request_options:</h3>';
  var_dump($request_options);
  
  print '<h3>$_SESSION:</h3>';
  var_dump($_SESSION);
  
  print '<h3>$_GET:</h3>';
  var_dump($_GET);
  
  print '<h3>$_POST:</h3>';
  var_dump($_POST);
  
  print '<h3>$_SERVER:</h3>';
  var_dump($_SERVER);
?>
</pre>







