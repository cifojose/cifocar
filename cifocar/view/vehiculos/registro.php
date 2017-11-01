<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Registro de vehículos</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

			if($usuario) Template::logout($usuario); //pone el formulario de logout
			Template::header(); //pone el header
			Template::menu($usuario); //pone el menú
		?>
		
		<section id="content">
			
			
			<h1 style='text-align:center; color:blue'>Nuevo vehículo</h1>
			
			<form class="formulario" method="post" enctype="multipart/form-data" autocomplete="off">
				
    			<label>Matrícula:</label>
    			<input type="number" name="matricula" required="required"/><br/>        			
    			
    			<label>Marca:</label>
    			<input type="text" name="marca" required="required"/><br/>
    			
    			<label>Modelo: </label>
    			<input type="text" name="modelo" required="required"/><br/>
                
                <label>Color: </label>
    			<input type="text" name="color" /><br/>
                
                <label>Kms: </label>
    			<input type="number" name="kms" required="required"/><br/>
                
                <label>Caballos: </label>
    			<input type="number" name="caballos"/><br/>
                
                <label>P.Compra: </label>
    			<input type="number" name="precio_compra" required="required"/><br/>      			
                
                <label>P.Venta: </label>
    			<input type="number" name="precio_venta" required="required"/><br/>
                
                <label>Matriculación: </label>
    			<input type="number" name="any_matriculacion" required="required"/><br/>
                
                <label>Detalles: </label>
    			<textarea name="detalles" rows="5" cols="50"></textarea><br/>
                
                <label>Estado actual: </label>
                <select name="estado" required="required">
                       <option value=0 selected="selected" >Venta</option>
                       <option value=1>Reservado</option>
                       <option value=2>Vendido
	                   <option value=3>Devolución</option>
	                   <option value=4>Baja</option>
                </select><br/>
                
                <label>Imagen:</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_image_size;?>" />		
				<input type="file" accept="image/*" name="imagen" />
				<span>max <?php echo intval($max_image_size/1024);?>kb</span><br />
                
				<input class="boton" type="submit" name="modificar" value="Modificar"/>
				<input class="boton" type="button" name="cancelar" value="Cancelar" onclick='history.back();'/><br/>
        	</form>
    		<br/>	
		</section>
		
		<?php Template::footer();?>
    </body>
</html>