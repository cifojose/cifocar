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
			

			if($usuario) Template::logout($usuario); //pone el formulario de logout
			Template::header(); //pone el header
			Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
			<h1 style='text-align:center; color:blue'>Nuevo usuario</h1>
			<form class="formulario" method="post" enctype="multipart/form-data" autocomplete="off">
				<label>User:</label>
				<input type="text" name="user" required="required" 
					pattern="^[a-zA-Z]\w{2,9}" title="3 a 10 caracteres (numeros, letras o guión bajo), comenzando por letra"/><br/>
				
				<label>Password:</label>
				<input type="password" name="password" required="required" 
					pattern=".{4,16}" title="4 a 16 caracteres"/><br/>
				
				<label>Nombre:</label>
				<input type="text" name="nombre" required="required"/><br/>
				
				<label>Email:</label>
				<input type="email" name="email" required="required"/><br/>
											
				<label>Departamento:</label>
				<select style='margin-top:7px' name="privilegio">
					<option value=0>Sistemas</option>
					<option value=1>Compras</option>
					<option value=2 selected="selected">Ventas</option>
				</select><br/>
				
				<label>Administrador:</label>
				<input style='margin-top:5px' type="checkbox" name="admin" value="1"/><br/>
				
				<label>Imagen:</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_image_size;?>" />		
				<input type="file" accept="image/*" name="imagen" />
				<span>max <?php echo intval($max_image_size/1024);?>kb</span><br />
				
				<label></label>
				<input class="boton" type="submit" name="guardar" value="Guardar"/>
				<input class="boton" type="button" name="cancelar" value="Cancelar" onclick="location.href='index.php';"/><br/>
			
			</form>
		</section>
		
		<?php Template::footer();?>
    </body>
</html>