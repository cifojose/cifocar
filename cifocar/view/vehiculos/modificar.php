<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Modificar vehículo <?php echo $vehiculo->matricula;?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

			if($usuario) Template::logout($usuario); //pone el formulario de logout
			Template::header(); //pone el header
			Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
			
			
			<h2>Modificar vehículo <span style="color: blue;"><?php echo $vehiculo->matricula;?></span></h2>
			
			<form class="formulario" method="post" enctype="multipart/form-data" autocomplete="off">
				<figure style="float: right" >
					<img class="imagenactual" src="<?php echo $vehiculo->imagen;?>" 
					alt="Imagen actual del vehiculo" />
					<figcaption><?php echo  $vehiculo->marca." ".$vehiculo->modelo;?></figcaption>
				</figure>
    			
    			<label>Matricula:</label>
    			<input readonly="readonly" style="color: black;" value="<?php echo $vehiculo->matricula;?>"/>Solo lectura<br/>        			
    			
    			<label>Marca:</label>
    			<input type="text" name="marca" style="color: blue;" value="<?php echo $vehiculo->marca;?>"/><br/>
    			
    			<label>Modelo: </label>
    			<input type="text" name="modelo" style="color: blue;" value="<?php echo $vehiculo->modelo;?>"/><br/>
                
                <label>Color: </label>
    			<input type="text" name="color" style="color: blue;" value="<?php echo $vehiculo->color;?>"/><br/>
                
                <label>Kms: </label>
    			<input type="number" name="kms" style="color: blue;" value="<?php echo $vehiculo->kms;?>"/><br/>
                
                <label>Caballos: </label>
    			<input type="number" name="caballos" style="color: blue;" value="<?php echo $vehiculo->caballos;?>"/><br/>
                
                <label>P.Compra: </label>
    			<input type="number" name="precio_compra" style="color: blue;" value="<?php echo $vehiculo->precio_compra;?>"/><br/>      			
                
                <label>Matriculación: </label>
    			<input type="number" name="any_matriculacion" style="color: blue;" value="<?php echo $vehiculo->any_matriculacion;?>"/><br/>
                
                <label>Detalles: </label>
    			<textarea name="detalles" style="color: blue;"><?php echo $vehiculo->detalles;?></textarea><br/>
                
                <label>F.Venta: </label>
    			<input readonly="readonly" style="color: black;" value="<?php echo $vehiculo->fecha_venta;?>"/>Solo lectura<br/>
                
                <label>Estado actual: </label>
                <input readonly="readonly" style="color: black;"  value="<?php switch ($vehiculo->estado){
                                                    case 0:echo "Venta";
                                                            break;
                                                    case 1:echo "Reservado";
                                                            break;
                                                    case 2:echo "Vendido";
                                                            break;
                                                    case 3:echo "Devolución";
                                                            break;
                                                    case 4:echo "Baja";
                                                            break;
                                                }?>"/>Solo lectura<br/>
				<input class="boton" type="submit" name="modificar" value="Modificar"/>
				<input class="boton" type="button" name="cancelar" value="Cancelar" onclick='history.back();'/><br/>
        	</form>
    		<br/>	
		</section>
		<?php Template::footer();?>
    </body>
</html>