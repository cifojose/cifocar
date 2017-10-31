<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Portada CIFOCAR</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			
			//if(!$usuario) Template::login(); //pone el formulario de login
			//else Template::logout($usuario); //pone el formulario de logout
		?>

		<div class="centrar">
			<figure>
    			<img src="images/logos/logo.png" />
    		</figure>
 
			<h1>Área de login</h1>
  
			<form class="form" method="post" autocomplete="off">
				<p>Introduzca su nombre de usuario.</p>
			<input type="text" name="user"  placeholder="usuario" required="required">
			<div>
      
			</div>
			<p>Introduzca su clave de acceso.</p>
			<input type="password" name="password" placeholder="clave" required="required">
			<div>
      
			</div>
			<input type="submit" name="login" class="botonPersonalizado" value="Acceder">
			</form>
		</div>
		
		
    </body> 
</html>