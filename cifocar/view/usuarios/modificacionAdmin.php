<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Modificación de privilegios de usuario</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			Template::header(); //pone el header

			if(!$usuario) Template::login(); //pone el formulario de login
			else Template::logout($usuario); //pone el formulario de logout
			
			Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
						
			<h2>Formulario de modificación de privilegios de usuario</h2>
			
			<form method="post" enctype="multipart/form-data" autocomplete="off">
				
				<figure>
					<img class="imagenactual" src="<?php echo $usuario->imagen;?>" 
						alt="<?php echo  $usuario->user;?>" />
				</figure>
				
				
				<label>User:</label>
				<input type="text" name="user" 
					readonly="readonly" value="<?php echo $usuario->user;?>" /><br/>
				
				<label>Privilegio:</label>
				<input type="number" name="privilegio"
					value="<?php echo $usuario->privilegio;?>"/><br/>
				
				<label>Email:</label>
				<input type="email" name="email"  
					value="<?php echo $usuario->email;?>"/><br/>
				
				<label>Es Admin:</label>
				<input type="checkbox" name="admin" 
					value="1" checked=<?php echo empty($usuario->admin)? "":"checked";?>"/><br/>
				
				<input type="submit" name="modificar" value="modificar"/><br/>
			</form>
			
				
		</section>
		
		<?php Template::footer();?>
    </body>
</html>