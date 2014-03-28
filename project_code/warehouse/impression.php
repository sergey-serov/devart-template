<?php

/**
 * Proportional resize
 */
function impression_resample($im, $max_size, $original_width, $original_height) {
  
  $width = $height = $max_size;
   
  $original_ratio = $original_width/$original_height;
  
  if ($width / $height > $original_ratio) {
    $width = $height * $original_ratio;
  }
  else {
    $height = $width / $original_ratio;
  }
  
  $new_image = imagecreatetruecolor($width, $height);
  imagecopyresampled($new_image, $im, 0, 0, 0, 0, $width, $height, $original_width, $original_height);
  
  return $new_image;
}

/**
 * Get colors from prepared file list with images
 */
function impression_get_colors($files, $max_size) {
  $colors = array();
  
  foreach ($files as $file) {
  
    list($width, $height) = getimagesize($file);
    $image = imagecreatefromjpeg($file);
  
    if ($width > 100 || $height > 100) {
      $image = impression_resample($image, $max_size, $width, $height);
      $height = imagesy($image);
      $width = imagesx($image);
    }
  
    for ($row = 0; $row < $height; $row++) {
      for ($col = 0; $col < $width; $col++) {
        $colors/* [$file][$row] */[] = imagecolorat($image, $col, $row);
      }
    }
  
    imagedestroy($image);
  }
  return $colors;
}

/**
 * Create big image from total colors
 * 
 * for prototype only
 * @todo - move all manipulations to browser (dart?)
 */
function impression_create_total_image($colors) {
  $count_colors = count($colors);
  $width = $height = floor(sqrt($count_colors));
  $diff = $count_colors - ($width * $height);
  
  if ($diff > 0) {
    $colors = array_slice($colors, 0, $width * $height);
  }
   
  
  $image = imagecreatetruecolor($width, $height);
  // @todo
  
  
  
}















