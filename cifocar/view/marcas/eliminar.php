<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Baja de usuarios</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

			if(!$usuario) Template::login(); //pone el formulario de login
			else Template::logout($usuario); //pone el formulario de logout
			Template::header(); //pone el header
			//Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
			<h2 style="text-align:center; color:blue">Borrar marca</h2>
			
		
			<form class="formulario" method="post" autocomplete="off">
				<label>Marca:</label>
				<input type="text" readonly="readonly" value="<?php echo $marca;?>" /><br/>
				
				<input class="boton" type="submit" name="confirmar" value="Confirmar"/>
				<input class="boton" type="button" name="cancelar" value="Cancelar" onclick="history.back();"/><br/>
			</form>
		</section>
		
		<?php Template::footer();?>
    </body>
</html>