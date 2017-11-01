<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Registro de usuarios</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

		if($usuario)Template::logout($usuario); //pone el formulario de login
			
		Template::header(); //pone el header
		Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
			<h2 style='text-align:center; color:blue'>Nueva marca</h2>
			<form class="formulario" method="post" enctype="multipart/form-data" autocomplete="off">
				<label>Marca:</label>
				<input type="text" name="marca" required="required" /><br/>
				
				<input class="boton" type="submit" name="guardar" value="Guardar"/>
				<input class="boton" type="button" name="cancelar" value="Cancelar" onclick="location.href='index.php';"/><br/>
			
			</form>
		</section>
		
		<?php Template::footer();?>
    </body>
</html>