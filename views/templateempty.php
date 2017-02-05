<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="index,follow" />
		<title><?php if(isset($title)) echo $title; ?></title>
		<link rel="shortcut icon" 
			href="<?php echo WEBPATH.'/web/img/logo.jpg'; ?>" 
			type="image/x-icon"
		>
		<meta name="description" content="Erreur d'accès à la page">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/bootstrap.min.css">';?>
		<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/general-stylesheet.css">';?>
		<?php echo '<link rel="stylesheet" href="' . WEBPATH . '/web/css/templateempty.css" media="screen">';?>
		<?php echo (isset($css)) ? '<link rel="stylesheet" href="'.WEBPATH.'/web/css/'.$css.'-stylesheet.css">' : '';?>	
		<link href="https://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet">

		<meta property="og:url"           content="https://egl.fbdev.fr/Facebook/" />
		<meta property="og:type"          content="website" />
		<meta property="og:title"         content="Concours Pardon-Maman" />
		<meta property="og:description"   content="Participez vous aussi au concours de Pardon Maman ! " />
		<meta property="og:image"         content="<?php echo WEBPATH.'/web/img/logo.jpg'; ?>" />
	
	</head>
	<body>
		<?php 
			if(isset($noCompetition) && $noCompetition==1)
				echo "<script>window.location = '".WEBPATH."/noCompetition';</script>"; 
		?>
		<input type="hidden" name="webpath" value="<?php echo WEBPATH; ?>">
		<?php include $this->view; ?>
		<?php 
			echo '<script src="'.WEBPATH.'/web/js/jquery.js"></script>';
			echo '<script src="'.WEBPATH.'/web/js/bootstrap.min.js"></script>';
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
