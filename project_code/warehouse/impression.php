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
  $rating_colors = array();
  
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
        
        $rgb = imagecolorat($image, $col, $row);
        
        $rating_colors[] = $rgb; // here int
        $colors[] = imagecolorsforindex($image, $rgb); // here array with rgba
      }
    }
  
    imagedestroy($image);
  }
  
  $rating_colors = array_count_values($rating_colors);
  arsort($rating_colors);
  
  return array($colors, $rating_colors);
}

/**
 * Create big image from total colors
 * 
 * First way to display
 *  
 * @todo - move all manipulations with images to browser (dart?)
 */
function impression_create_total_image($colors) {
  
  $count_colors = count($colors);
  $width = $height = floor(sqrt($count_colors));
  $diff = $count_colors - ($width * $height);
  
  if ($diff > 0) {
    $colors = array_slice($colors, 0, $width * $height);
  }
//   usort($colors, 'impression_sort_colors');
  
  $image = imagecreatetruecolor($width, $height);
  
  $color_index = 0;
  for ($row = 0; $row < $height; $row++) {
    for ($col = 0; $col < $width; $col++) {
      $color = $colors[$color_index];
      imagesetpixel($image, $col, $row, imagecolorallocate($image, $color['red'], $color['green'], $color['blue']));
      $color_index++;
    }
  }
  
  imagepng($image, 'interface/web/images/art.png');
  imagedestroy($image);
  
}


/**
 * Sort colors
 */
function impression_sort_colors($a, $b) {
  
  // just to try @todo find several good ways here
  $r = 0;
  
  if ($a['red'] == $b['red']) {
    if ($a['green'] == $b['green']) {
      if ($a['green'] == $b['green']) {
        // @todo
      } 
    }
  }
  
  return $r;  
}


/**
 * Create palette
 * 
 * Second way to display.
 */
function impression_create_palette($rating_colors, $item_size) {
  
  // @todo more popular color - bigger rectangle
  $rating_colors = array_keys($rating_colors);
  
  $count_colors = count($rating_colors);
  $items_per_row = ceil(sqrt($count_colors));
  $width = $height = $items_per_row * $item_size;
 
  $image = imagecreatetruecolor($width, $height);
  
  $color_index = 0;
  
  // square for prototype - $items_per_row = $items_per_column
  for ($col = 0; $col < $items_per_row; $col++) {
    for ($row = 0; $row < $items_per_row; $row++) {
      $x1 = $row * $item_size;
      $y1 = $col * $item_size;
      $x2 = $row * $item_size + $item_size;
      $y2 = $col * $item_size + $item_size;
      imagefilledrectangle($image, $x1, $y1, $x2, $y2, $rating_colors[$color_index]);
      $color_index++;
    }    
  }
  
  imagepng($image, 'interface/web/images/personal-palette.png');
  imagedestroy($image);
} 






