<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Detalles del usuario <?php echo $usuarioM->nombre;?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

			if(!$usuario) Template::login(); //pone el formulario de login
			else Template::logout($usuario); //pone el formulario de logout
			Template::header(); //pone el header
			Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
			
			<h2>Detalles del usuario <span style="color: blue;"><?php echo $usuarioM->user;?></span></h2>
			
			<div class="contenedor">
    			<article class="texto">
    				<figure style="float: right" >
						<img class="imagenactual" src="<?php echo $usuario->imagen;?>" 
						alt="<?php echo  $usuarioM->user;?>" />
						<figcaption>Imagen actual del perfíl/avatar</figcaption>
					</figure>
        			<h3>ID:</h3>
        			<h4 style="color: blue;"><?php echo $usuarioM->id;?></h4>        			
        			<h3>Usuario:</h3>
        			<h4 style="color: blue;"><?php echo $usuarioM->user;?></h4>
        			<h3>Nombre del usuario: </h3>
        			<h4 style="color: blue;"><?php echo $usuarioM->nombre;?></h4>
                    <h3>Departamento: </h3>
                    <h4 style="color: blue;"><?php switch ($usuarioM->privilegio){
                                                        case 0:echo "Sistemas";
                                                                break;
                                                        case 1:echo "Compras";
                                                                break;
                                                        case 2:echo "Ventas";
                                                                break;}?></h4>
                    <h3>Es administrador:</h3>
                    <h4 style="color: blue;"><?php echo ($usuarioM->admin)? "Si" : "No";?></h4>
                    <h3>Correo electronico (Email): </h3>
                    <h4 style="color: blue;"><?php echo $usuarioM->email;?></h4>
                    <h3>Fecha de registro: </h3>
                    <h4 style="color: blue;"><?php echo $usuarioM->fecha;?></h4>
                </article>
    		</div>
    		<br/>	
    		<button class="boton" onclick="history.back();">Volver</button>
		</section>
		<?php Template::footer();?>
    </body>
</html>