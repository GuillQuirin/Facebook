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
	<?php echo '<script src="'.WEBPATH.'/web/js/jquery.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/lib/DataTables/datatables.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap-datepicker.min.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/datepicker-fr.js"></script>';?>
	<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap.colorpickersliders.js"></script>';?>
	<link href="https://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet">
	<?php echo '<script src="'.WEBPATH.'/web/js/jscolor.js"></script>';?>

	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

	<?php echo (isset($css)) ? '<link rel="stylesheet" href="'.WEBPATH.'/web/css/'.$css.'-stylesheet.css">' : '';?>

</head>

<body>
	<header class="col-md-10 col-md-offset-1">
		<nav class="navbar navbar-default no-padding">
			<ul class="nav navbar-nav">
				<li class="col-md-2 menu-li <?php if($_SERVER['REQUEST_URI'] == WEBPATH) echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>">Participer</a>
				</li>
				<li class="col-md-2 menu-li <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/gallery') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/gallery">Galerie</a>
				</li>
				<li class="col-md-2 menu-li <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/admin') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/admin">Liste des concours</a>
				</li>
				<li class="col-md-2 menu-li <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/design') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/design">Design</a>
				</li>
				<li class="col-md-2 menu-li <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/export') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/export">Export des données</a>
				</li>
				<li class="col-md-2 <?php if($_SERVER['REQUEST_URI'] == WEBPATH.'/setting') echo "active"; ?>">
					<a href="<?php echo WEBPATH; ?>/setting">Reglement et CGU</a>

				</li>
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
		<?php if(isset($isAdmin) && $isAdmin==1) :?>
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
