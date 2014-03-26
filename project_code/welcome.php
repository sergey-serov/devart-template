<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>First screen</title>
<link type="text/css" rel="stylesheet" href="/stylesheets/style.css" />
</head>

<body>

<?php 
if (isset($_POST['hosting']) && $_POST['hosting'] == 'flickr') {
  
}

// @todo ajax request instead of submit button
?>

<h3>Your photo hosting</h3>

 <form action="/sign" method="post">
	<div class="form-radio-row"><input type="radio" name="hosting" value="flickr">Flickr</div>
	<div class="form-radio-row"><input type="radio" name="hosting" value="instagram">Instagram</div>
	<div class="form-submit-row"><input type="submit" value="Connect"/></div>
</form>

</body>

<pre>
<?php print_r($_SERVER); ?>
<?php print_r($_POST); ?>
<?php print_r($_GET); ?>
</pre>