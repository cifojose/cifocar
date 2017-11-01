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
			

			if($usuario) Template::logout($usuario); //pone el formulario de logout
			Template::header(); //pone el header
			Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
						
			<h2 style="text-align: center; color:blue">Formulario de modificación de privilegios de usuario</h2>
			
			<form method="post" enctype="multipart/form-data" autocomplete="off">
				
				<figure>
					<img class="imagenactual" src="<?php echo $usuarioM->imagen;?>" 
						alt="<?php echo  $usuarioM->user;?>" />
				</figure>
				
				
				<label>User:</label>
				<input type="text" name="user" 
					readonly="readonly" value="<?php echo $usuarioM->user;?>" /><br/>
				
				<label>Privilegio:</label>
				<?php
				switch ($usuarioM->privilegio){
				    case 0:echo "<select style='margin-top:7px' name='privilegio'>
					                   <option value=0 selected='selected'>Sistemas</option>
					                   <option value=1>Compras</option>
					                   <option value=2>Ventas</option>
				                </select>";
				            break;
				    case 1:echo "<select style='margin-top:7px' name='privilegio'>
					                   <option value=0 >Sistemas</option>
					                   <option value=1 selected='selected'>Compras</option>
					                   <option value=2>Ventas</option>
				                </select>";
				            break;
				    case 2:echo "<select style='margin-top:7px' name='privilegio'>
					                   <option value=0>Sistemas</option>
					                   <option value=1>Compras</option>
					                   <option value=2 selected='selected';>Ventas</option>
				                </select>";
                            break;
				}?>
				<br/>								
				<label>Email:</label>
				<input type="email" name="email"  
					value="<?php echo $usuarioM->email;?>"/><br/>
				
				<label>Es Admin:</label>
				<input type="checkbox" name="admin" value="1" <?php if($usuarioM->admin) echo "checked='checked'"; ?> /><br/>
								
				<input class="boton" type="submit" name="modificar" value="Modificar"/>
				<input class="boton" type="button" name="cancelar" value="Cancelar" onclick='history.back();'/><br/>
			</form>
			
				
		</section>
		
		<?php Template::footer();?>
    </body>
</html>