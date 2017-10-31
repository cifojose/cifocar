<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Modificación datos de usuario registrado</title>
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
						
			<h2>Formulario de modificación datos del usuario registrado</h2>
			
			<form class="formulario" method="post" enctype="multipart/form-data" autocomplete="off">
				
				<figure>
					<img class="imagenactual" src="<?php echo $usuario->imagen;?>" 
						alt="<?php echo  $usuario->user;?>" />
				</figure>
				<a class="derecha" href="index.php?controlador=Usuario&operacion=baja">
					<img src="images/buttons/delete.png" alt="darse de baja" class="logo" />
					Darse de baja
				</a>
				
				<label>User:</label>
				<input type="text" name="user" required="required" 
					readonly="readonly" value="<?php echo $usuario->user;?>" /><br/>
				
				<label>Password actual:</label>
				<input type="password" name="password" required="required" /><br/>
				
				<label>Nuevo password:</label>
				<input type="password" name="newpassword" pattern=".{4,16}" title="4 a 16 caracteres"/>
				<span class="mini">En blanco para no modificar el actual</span><br/>
				
				
				<label>Nombre usuario:</label>
				<input type="text" name="nombre" required="required" 
					value="<?php echo $usuario->nombre;?>"/><br/>
				
				<label>Email:</label>
				<input type="email" name="email" required="required" 
					value="<?php echo $usuario->email;?>"/><br/>
				
				<label>Nueva imagen:</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_image_size;?>" />		
				<input type="file" accept="image/*" name="imagen" />
				<span class="mini">max <?php echo intval($max_image_size/1024);?>kb</span><br />
				
				<label></label>
				<input class="boton" type="submit" name="modificar" value="Modificar"/>
				<input class="boton" type="button" name="cancelar" value="Cancelar" onclick="location.href='index.php';"/><br/>
			</form>
			
				
		</section>
		
		<?php Template::footer();?>
    </body>
</html>