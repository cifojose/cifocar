<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>CIFOCAR ERROR</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

		if($usuario) Template::logout($usuario); //pone el formulario de login
		
		Template::header(); //pone el header
		Template::menu($usuario); //pone el menú
		?>
		
		<section id="content" class="error">
			<h2>Error</h2>
			<?php echo '<p>'.$mensaje.'</p>'; ?>
			<input type="button" class="boton" name="inicio" value="Inicio" onclick="location.href='index.php';"/>
		</section>
		
		<?php Template::footer();?>
    </body>   
</html>