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
		
		<?php echo (isset($css)) ? '<link rel="stylesheet" href="'.WEBPATH.'/web/css/'.$css.'-stylesheet.css">' : '';?>

	</head>

	<body>
		<header class="col-md-12">
			<nav class="col-md-offset-3 col-md-6 navbar navbar-default no-padding">
		      <ul class="nav navbar-nav">
		        <li class="active"><a href="#">Liste des concours</a></li>
		        <li><a href="<?php echo WEBPATH ?>/admin/design">Design</a></li>
		        <li><a href="#">Export des données</a></li>
		        <li><a href="#">Reglement et CGU</a></li>
		      </ul>
			</nav>
		</header>

		<div id="content">
			<input type="hidden" name="webpath" value="<?php echo WEBPATH; ?>">
			<?php include $this->view; ?>
		</div>


		<!-- Footer des pages -->
		<footer>
			<a href="<?php echo WEBPATH; ?>/reglement">Règlement du concours</a>
			<a href="<?php echo WEBPATH; ?>/CGU">Conditions d'utilisations</a>
			<a href="<?php echo WEBPATH; ?>/admin">Administration (à afficher si admin de la page)</a>
		</footer>

		<?php echo '<script src="'.WEBPATH.'/web/js/jquery.js"></script>';?>
		<?php echo '<script src="'.WEBPATH.'/web/js/bootstrap.min.js"></script>';?>
		<?php echo '<script src="'.WEBPATH.'/web/lib/DataTables/datatables.min.js"></script>';?>
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
