<!DOCTYPE html>
<html lang="fr">
<head>		

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="index,follow" />
	<title></title>
	<?php echo '<link rel="shortcut icon" href="' . WEBPATH . '/web/img/icon/logo-full.ico" type="image/x-icon">';?>
	<meta name="description" content=''>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/template.css" media="screen">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/general-stylesheet.css">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/bootstrap.min.css">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/lib/DataTables/datatables.min.css">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/datepicker.min.css">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/bootstrap.colopickersliders.css">';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/jquery.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/lib/DataTables/datatables.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap-datepicker.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/datepicker-fr.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap.colorpickersliders.js"></script>';?>

	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

	<?php echo (isset($css)) ? '<link rel="stylesheet" href="'.WEBPATH.'/web/css/'.$css.'-stylesheet.css">' : '';?>

</head>

<body>
	<header class="col-md-12">
		<!--<nav class="container">
			<ul class="nav nav-tabs">
				<li><a href="<?php echo WEBPATH; ?>">Participer</a></li>
				<li><a href="<?php echo WEBPATH; ?>/gallery">Galerie</a></li>
				<li><!--<div class="fb-share-button" data-href="http://egl.fbdev.fr/EGL/" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fegl.fbdev.fr%2FEGL%2F&amp;src=sdkpreparse">Partager</a><!--</div></li>
			</ul>
		</nav>-->
		<nav class="col-md-offset-3 col-md-6 navbar navbar-default no-padding">
			<ul class="nav navbar-nav">
				<li class="active"><a href="<?php echo WEBPATH ?>/admin">Liste des concours</a></li>
				<li><a href="<?php echo WEBPATH ?>/design">Design</a></li>
				<li><a href="<?php echo WEBPATH ?>/export">Export des données</a></li>
				<li><a href="#">Reglement et CGU</a></li>
			</ul>
		</nav>
	</header>

	<div id="content">
		<input type="hidden" name="webpath" value="<?php echo WEBPATH; ?>">
		<?php include $this->view; ?>
	</div>


	<!-- Footer des pages -->
	<footer class="footer col-md-12">
		<a href="<?php echo WEBPATH; ?>/reglement">Règlement du concours</a> | 
		<a href="<?php echo WEBPATH; ?>/CGU">Conditions d'utilisations</a> | 
		<?php 
		if(isset($user) && isset($listAdmins) && in_array($user->getId(),$listAdmins)) :?>
			<a href="<?php echo WEBPATH;?>/admin">Administration</a>
		<?php endif; ?>
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
