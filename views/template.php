<!DOCTYPE html>
<html lang="fr">
<head>		

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="index,follow" />
	<title>Pardon Maman</title>
	<link rel="shortcut icon" 
			href="<?php echo WEBPATH.'/web/img/logo.jpg'; ?>" 
			type="image/x-icon"
	>
	<meta name="description" content=''>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/general-stylesheet.css">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/bootstrap.css">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/datepicker.min.css">';?>
	<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/template.css" media="screen">';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/jquery.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap-datepicker.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/datepicker-fr.js"></script>';?>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

	<?php echo (isset($css)) ? '<link rel="stylesheet" href="'.WEBPATH.'/web/css/'.$css.'-stylesheet.css">' : '';?>

	<meta property="og:url"           content="https://egl.fbdev.fr/Facebook/" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="Concours Pardon-Maman" />
	<meta property="og:description"   content="Participez vous aussi au concours de Pardon Maman ! " />
	<meta property="og:image"         content="<?php echo 'https://'.$_SERVER['HTTP_HOST'].WEBPATH.'/web/img/logo.jpg'; ?>" />

</head>

<body>
	<?php 
		if(isset($noCompetition) && $noCompetition==1)
			echo "<script>window.location = '".WEBPATH."/noCompetition';</script>"; 
	?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8&appId=1804945786451180";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<div id="content" class="container">
		<div class="row">
			<header class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
				<nav>
					<ul class="col-md-12 nav nav-tabs text-center">
						<li class="col-xs-4 col-md-3 menu-li">
							<a href="<?php echo WEBPATH; ?>">Accueil</a>
						</li>
						<li class="col-xs-4 col-sm-4 col-md-3 menu-li <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/gallery') echo "active"; ?>">
							<a href="<?php echo WEBPATH; ?>/gallery">Galerie</a>
						</li>
						<li class="col-xs-4 col-sm-4 col-md-3 menu-li <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/rules') echo "active"; ?>">
							<a href="<?php echo WEBPATH; ?>/rules">Règlement</a>
						</li>
						<li class="col-xs-4 col-sm-4 col-md-3">
							<div class="fb-share-button" data-href="https://egl.fbdev.fr/Facebook/" data-layout="button" data-size="large" data-mobile-iframe="false"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fegl.fbdev.fr%2FFacebook%2F&amp;src=sdkpreparse">Partager</a></div>
						</li>
					</ul>
				</nav>	
			</header>
		</div>
		<input type="hidden" name="webpath" value="<?php echo WEBPATH; ?>">
		<?php include $this->view; ?>
	</div>


	<!-- Footer des pages -->
	<footer class="footer col-md-12">
		<a href="<?php echo WEBPATH; ?>/rules">Règlement du concours</a> | 
		<a href="<?php echo WEBPATH; ?>/cgu">Conditions d'utilisations</a> 
		<?php if(isset($isAdmin) && $isAdmin==1) :?>
			| <a href="<?php echo WEBPATH;?>/admin">Administration</a>
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
