<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Listado de vehiculos</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

		if($usuario) Template::logout($usuario); //pone el formulario de login
		
		Template::header(); //pone el header
		Template::menu($usuario); //pone el menu
		?>
	
		<section id="content">
			<h1 style="text-align: center; color:blue">Listado de vehiculos</h1>
								
			<table>
				<tr>
					<th>Imagen</th>
					<th>Matricula</th>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Color</th>
					<th>Estado</th>					
					<th colspan="2">Operaciones</th>
				</tr>
				<?php 
				foreach($vehiculos as $vehiculo){
				    echo "<tr>";
				        echo "<td class='foto celda'><img class='miniatura' src='$vehiculo->imagen' alt='Avatar del user $vehiculo->modelo' title='Avatar del user $vehiculo->modelo'/></td>";
				        echo "<td>$vehiculo->matricula</td>";
				        echo "<td>$vehiculo->marca</td>";
				        echo "<td>$vehiculo->modelo</td>";
				        echo "<td>$vehiculo->color</td>";
				        switch ($vehiculo->estado){
				            case 0: echo"<td class='celda'>Venta</td>";break;
				            case 1: echo"<td class='celda'>Reservado</td>";break;
				            case 2: echo"<td class='celda'>Vendido</td>";break;
				            case 3: echo"<td class='celda'>Devolución</td>";break;
                            case 4: echo"<td class='celda'>Baja</td>";break;}
				        echo "<td class='operaciones celda'><a href='index.php?controlador=Vehiculo&operacion=ver&parametro=$vehiculo->id'><img class='icono' src='images/buttons/view.png' alt='ver detalles' title='Detalles del vehiculo'/></a></td>";
				        echo "<td class='operaciones celda'><a href='index.php?controlador=Vehiculo&operacion=editar&parametro=$vehiculo->id'><img class='icono' src='images/buttons/edit.png' alt='editar' title='Editar vehiculo'/></a></td>";
				        echo "</tr>";
				}
				?>
			</table>
			
		
		</section>
		
		<?php Template::footer();?>
    </body>
</html>