<!DOCTYPE html>
<html lang="fr">
	<head>

		<!-- J'en rajouterais plutard -->
		<!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'"> -->
		<!-- Fin Security -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="index,follow" />
			<title></title>
			<?php echo '<link rel="shortcut icon" href="' . WEBPATH . '/web/img/icon/logo-full.ico" type="image/x-icon">';?>
			<meta name="description" content="Erreur d'accès à la page">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
			<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/template.css" media="screen">';?>

			<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/general-stylesheet.css">';?>

			
			<?php echo (isset($css)) ? '<link rel="stylesheet" href="'.WEBPATH.'/web/css/'.$css.'-stylesheet.css">' : '';?>

	</head>

	<body>
		<header>		 
		</header>
			<div id="content">
				<?php include $this->view; ?>
			</div>
		<footer>
			
		</footer>
	</body>
</html>
