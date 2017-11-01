<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Modificación estado del vehiculo</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

			if($usuario) Template::logout($usuario); //pone el formulario de logout
			Template::header(); //pone el header
			Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
						
			<h2 style="text-align: center; color:blue">Modificación estado del vehiculo</h2>
			
			<form method="post" enctype="multipart/form-data" autocomplete="off">
				
				<figure>
					<img class="imagenactual" src="<?php echo $vehiculo->imagen;?>" 
						alt="<?php echo  $vehiculo->modelo;?>" />
				</figure>
				<label>Matricula:</label>
				<input type="text" name="matricula" readonly="readonly" value="<?php echo  $vehiculo->matricula;?>"/><br/>
				
				<label>Marca:</label>
				<input type="text" name="marca" readonly="readonly" value="<?php echo  $vehiculo->marca;?>"/><br/>
				
				<label>Modelo:</label>
				<input type="text" name="modelo" readonly="readonly" value="<?php echo  $vehiculo->modelo;?>"/><br/>
				<label>Estado:</label>
				<?php
				switch ($vehiculo->estado){
				    case 0:echo "<select style='margin-top:7px' name='estado'>
					                   <option value=0 selected='selected'>Venta</option>
					                   <option value=1>Reservado</option>
					                   <option value=2>Vendido</option>
                                       <option value=3>Devolución</option>
                                       <option value=4>Baja</option>
				                </select>";
				            break;
				    case 1:echo "<select style='margin-top:7px' name='estado'>
					                   <option value=0>Venta</option>
					                   <option value=1 selected='selected'>Reservado</option>
					                   <option value=2>Vendido</option>
                                       <option value=3>Devolución</option>
                                       <option value=4>Baja</option>
				                </select>";
				            break;
				    case 2:echo "<select style='margin-top:7px' name='estado'>
					                   <option value=0>Venta</option>
					                   <option value=1>Reservado</option>
					                   <option value=2 selected='selected'>Vendido</option>
                                       <option value=3>Devolución</option>
                                       <option value=4>Baja</option>
				                </select>";
                            break;
				    case 3:echo "<select style='margin-top:7px' name='estado'>
					                   <option value=0>Venta</option>
					                   <option value=1>Reservado</option>
					                   <option value=2>Vendido</option>
                                       <option value=3 selected='selected'>Devolución</option>
                                       <option value=4>Baja</option>
				                </select>";
				            break;
				    case 4:echo "<select style='margin-top:7px' name='estado'>
					                   <option value=0>Venta</option>
					                   <option value=1>Reservado</option>
					                   <option value=2>Vendido</option>
                                       <option value=3>Devolución</option>
                                       <option value=4 selected='selected'>Baja</option>
				                </select>";
				                break;
				}?>
				<br/>								
				<input class="boton" type="submit" name="modificar" value="Modificar"/>
				<input class="boton" type="button" name="cancelar" value="Cancelar" onclick='history.back();'/><br/>
			</form>
			
				
		</section>
		
		<?php Template::footer();?>
    </body>
</html>