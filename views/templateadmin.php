<!DOCTYPE html>
<html lang="fr">
<head>		

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="index,follow" />
	<title></title>
	<link rel="shortcut icon" 
	href="https://scontent-fra3-1.xx.fbcdn.net/v/	t1.0-9/552345_420640654657180_1666928990_n.jpg?oh=7e0262fb4fa4671e45c13bfefcbfc4ef&oe=58C27523" 
	type="image/x-icon"
	>
	<meta name="description" content=''>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/general-stylesheet.css">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/bootstrap.min.css">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/template.css" media="screen">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/lib/DataTables/datatables.min.css">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/datepicker.min.css">';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/jquery.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/lib/DataTables/datatables.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap-datepicker.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/datepicker-fr.js"></script>';?>
	<?php //echo '<script src="'.WEBPATH.'/web/js/bootstrap.colorpickersliders.js"></script>';?>
	<link href="https://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet">
	<?php echo '<script src="'.WEBPATH.'/web/js/jscolor.js"></script>';?>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

	<?php echo (isset($css)) ? '<link rel="stylesheet" href="'.WEBPATH.'/web/css/'.$css.'-stylesheet.css">' : '';?>
	
</head>

<body>

	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8&appId=1804945786451180";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<nav class="navbar navbar-inverse">
		<div id="navbar" class="navbar-fluid">
			<ul class="nav navbar-nav text-center">
				<li class="col-xs-3 col-sm-2 col-md-2 ">
					<a href="<?php echo WEBPATH; ?>">Accueil</a>
				</li>
				<li class="hidden-xs col-sm-2 col-md-2">
					<a href="<?php echo WEBPATH; ?>/gallery">Galerie</a>
				</li>
				<li class="hidden-xs col-sm-2 col-md-2 <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/admin') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/admin">Concours</a>
				</li>
				<li class="col-xs-2 hidden-sm hidden-md hidden-lg <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/admin') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/admin">Gestion</a>
				</li>
				<li class="col-xs-2 col-sm-2 col-md-2 <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/design') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/design">Design</a>
				</li>
				<li class="col-xs-2 col-sm-2 col-md-2 <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/export') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/export">Export</a>
				</li>
				<li class="hidden-xs col-sm-2 col-md-2 <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/setting') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/setting">Règlement et CGU</a>
				</li>
				<li class="col-xs-2 hidden-sm hidden-md hidden-lg <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/setting') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/setting">Droits</a>
				</li>
			</ul>
		</div>
	</nav>
</header>
</div>
<div id="content" class="container">
	<input type="hidden" name="webpath" value="<?php echo WEBPATH; ?>">
	<?php include $this->view; ?>
</div>


<!-- Footer des pages -->
<footer class="footer col-md-12">
	<a href="<?php echo WEBPATH; ?>/rules" class="footer-link">Règlement du concours</a> | 
	<a href="<?php echo WEBPATH; ?>/cgu" class="footer-link">Conditions d'utilisations</a> 
	<?php if(isset($isAdmin) && $isAdmin==1) :?>
		<p>
			<a href="<?php echo WEBPATH;?>/admin" class="footer-link">Administration</a>
			| <a href="<?php echo WEBPATH;?>/noCompetition" class="footer-link">Aperçu sans concours</a>
		</p>
	<?php endif; ?>
	<p>
		<div class="fb-share-button" data-href="https://egl.fbdev.fr/Facebook/" data-layout="button" data-size="large" data-mobile-iframe="false"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fegl.fbdev.fr%2FFacebook%2F&amp;src=sdkpreparse">Partager</a></div>
	</p>
</footer>

<?php 
if(isset($js)){ 
	if(is_array($js)){
		foreach ($js as $key => $value)
			echo '<script src="'.WEBPATH.'/web/js/'.$value.'.js"></script>';
	}
	else 
		echo '<script src="'.WEBPATH.'/web/js/'.$js.'.js"></script>';
}
?>
</body>
</html>
