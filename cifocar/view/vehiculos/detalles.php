<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Detalles del vehículo <?php echo $vehiculo->matricula;?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

			if($usuario) Template::logout($usuario); //pone el formulario de logout
			Template::header(); //pone el header
			Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
			
			<h2>Detalles del vehiculo <span style="color: blue;"><?php echo $vehiculo->matricula;?></span></h2>
			
			<div class="contenedor">
    			<article class="texto">
    				<figure style="float: right" >
						<img class="imagenactual" src="<?php echo $vehiculo->imagen;?>" 
						alt="<?php echo  $vehiculo->modelo;?>" />
						<figcaption>Imagen actual del vehiculo</figcaption>
					</figure>
        			<h3>Matricula:</h3>
        			<h4 style="color: blue;"><?php echo $vehiculo->matricula;?></h4>        			
        			<h3>Marca:</h3>
        			<h4 style="color: blue;"><?php echo $vehiculo->marca;?></h4>
        			<h3>Modelo: </h3>
        			<h4 style="color: blue;"><?php echo $vehiculo->modelo;?></h4>
                    <h3>Color: </h3>
        			<h4 style="color: blue;"><?php echo $vehiculo->color;?></h4>
                    <h3>Kms: </h3>
        			<h4 style="color: blue;"><?php echo $vehiculo->kms;?>Kms</h4>
                    <h3>Caballos: </h3>
        			<h4 style="color: blue;"><?php echo $vehiculo->caballos;?>c.v.</h4>
                    <h3>P.Compra: </h3>
        			<h4 style="color: blue;"><?php echo $vehiculo->precio_compra;?>€</h4>
                    <h3>Matriculación: </h3>
        			<h4 style="color: blue;"><?php echo $vehiculo->any_matriculacion;?></h4>
                    <h3>Detalles: </h3>
        			<h4 style="color: blue;"><?php echo $vehiculo->detalles;?></h4>
                    <h3>F.Venta: </h3>
        			<h4 style="color: blue;"><?php echo $vehiculo->fecha_venta;?></h4>
                    <h3>Estado actual: </h3>
                    <h4 style="color: blue;"><?php switch ($vehiculo->estado){
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
                                                    }?></h4>
            	</article>
    		</div>
    		<br/>	
    		<button class="boton" onclick="history.back();">Volver</button>
		</section>
		<?php Template::footer();?>
    </body>
</html>