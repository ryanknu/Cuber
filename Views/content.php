<?php 

// **
// * Content View
// * Describes the main container.
// **

// * Include the proper javascript file, cuber_e for cuber:dev,
// * cuber for cuber.
$dev    = App::Obj()->IsDev()? "_e":"";
$jsPath = "Views/js/cuber{$dev}.js";

?><!DOCTYPE html>
<html>
  <head>
  	<title><?php echo $title?$title:"Cuber by Ryan Knuesel";?></title>
  	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  	
  	<link rel="stylesheet" type="text/css" href="Views/css/cuber.css" media="screen" />
  	<?php if (!App::Obj()->IsOffline()) { ?>
  	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
  	<?php } ?>
  	<script type="text/javascript" src="<?php echo $jsPath; ?>"></script>
  </head>
  <body>
  	
  	<?php View::Obj()->View($view->Get("view")); ?>
  	
  </body>
</html>