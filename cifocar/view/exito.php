<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta charset="UTF-8">
		<title>CIFOCAR EXITO</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

		if($usuario) Template::logout($usuario); //pone el formulario de login
		
		Template::header(); //pone el header
		Template::menu($usuario); //pone el menu
		?>
		
		<section id="content" class="exito">
			<h2>Exito</h2>
			<?php echo '<p>'.$mensaje.'</p><br/>'; ?>
			<input class="boton" type="button" name="inicio" value="Inicio" onclick="history.back()"/><br/>
		</section>
		
		<?php Template::footer();?>
    </body>
</html>