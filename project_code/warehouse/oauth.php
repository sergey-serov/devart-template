<?php

/**
 * Create signature for request to flickr
 *
 * @param string
 *   Flickr base oauth page
 *   
 * @param string
 *   What to do
 * 
 * @param array
 *   Parameters for request: keys, protocol and so on.
 *   
 * @param string
 *   Secret key, permanent for app, from flickr control panel
 *   
 * @param string
 *   Secret token from first request to flickr, new every time
 * 
 * @return string
 *   Ready for use in request signature
 */
function create_signature($oauth_base_url, $oauth_action, $request_options, $oauth_secret_key, $oauth_token_secret = '') {
  
  ksort($request_options);
  $s = array();
  foreach($request_options as $name => $value){
    $s[] = $name . '=' . rawurlencode($value);
  }

  $text = 'GET&' . rawurlencode($oauth_base_url . $oauth_action) . '&' . rawurlencode(implode('&', $s));
  
  return base64_encode(hash_hmac('sha1', $text, $oauth_secret_key . '&' . $oauth_token_secret, true));
}

/**
 * Create url for request
 *
 * @param string
 *   Flickr base oauth page
 *   
 * @param string
 *   What to do
 * 
 * @param array
 *   Parameters for request: keys, protocol and so on.
 *   
 * @param string
 *   Secret key, permanent for app, from flickr control panel
 *   
 * @param string
 *   Secret token from first request to flickr, new every time
 * 
 * @return string
 *   url for request to flickr
 */
function create_url($oauth_base_url, $oauth_action, $request_options, $oauth_secret_key, $oauth_token_secret = '') { 
  
  $url = '';

  $s = array();
  foreach($request_options as $name => $value){
    $s[] = $name . '=' . rawurlencode($value);
  }
  
  return $oauth_base_url . $oauth_action . '?' . implode('&', $s);
}












