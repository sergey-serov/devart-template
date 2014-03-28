<?php 
$start = microtime(TRUE);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>First screen</title>
<link type="text/css" rel="stylesheet" href="/stylesheets/style.css" />
</head>

<body>

<?php 

include_once 'warehouse/impression.php';

// perfomance reason - we randomly take only part of images. @todo find good value here
// 800x600 - image in browser. 480 000 px
// ratio 1.3333333 usually
// 480000/50 = 9600px|colors from each photo
// for example 60 * 45 = 2700
// 1 x 4
$max_files = 50;
$max_size = 60;

$files = glob("forge/*.jpg");
shuffle($files);
if (count($files) > $max_files) {
  $files = array_slice($files, 0, 50);
}

list($colors, $rating_colors) = impression_get_colors($files, $max_size);


// we send to browser about 1 MB @todo find good value
// 345x345
if (count($colors) > 119025) {
  $colors = array_slice($colors, 0, 119025);
}


// for develop we save to disk @todo transfer json with colors from server to browser
// and then render with dart, js, css, html

// $colors = json_encode($colors);
// file_put_contents('entrepot', $colors);
impression_create_total_image($colors);
impression_create_palette(array_slice($rating_colors, 0, 100), 40);


?>

<?php 

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
  // http://impression-through-time.appspot.com/oauth/flickr.php?
  // oauth_token=72157642963798474-cfdbe260d0cd5ea0
  // oauth_verifier=1506097afa8184ef
  
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

<?php 
print microtime(TRUE) - $start;
?>





