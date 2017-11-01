<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Listado de usuarios</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Config::get()->css;?>" />
	</head>
	
	<body>
		<?php 
			

		if($usuario) Template::logout($usuario); //pone el formulario de login
		
		Template::header(); //pone el header
		Template::menu($usuario); //pone el menu
		?>
	
		<section id="content">
			<h1 style="text-align: center; color:blue">Listado de usuarios</h1>
								
			<table>
				<tr>
					<th>Imagen</th>
					<th>Nombre</th>
					<th>Departamento</th>
					<th>Administrador</th>
					<th>Email</th>					
					<th colspan="3">Operaciones</th>
				</tr>
				<?php 
				foreach($usuarios as $usuario){
				    echo "<tr>";
				        echo "<td class='foto celda'><img class='miniatura' src='$usuario->imagen' alt='Avatar del user $usuario->user' title='Avatar del user $usuario->user'/></td>";
				        echo "<td>$usuario->nombre</td>";
				        switch ($usuario->privilegio){
				            case 0: echo"<td class='celda'>Sistemas</td>";break;
				            case 1: echo"<td class='celda'>Compras</td>";break;
				            case 2: echo"<td class='celda'>Ventas</td>";break;}
				        echo ($usuario->admin)? "<td class='celda'>Si</td>" : "<td class='celda'>No</td>";
				        echo "<td>$usuario->email</td>";
				        echo "<td class='operaciones celda'><a href='index.php?controlador=Usuario&operacion=ver&parametro=$usuario->user'><img class='icono' src='images/buttons/view.png' alt='ver detalles' title='Detalles del usuario'/></a></td>";
				        echo "<td class='operaciones celda'><a href='index.php?controlador=Usuario&operacion=editar&parametro=$usuario->user'><img class='icono' src='images/buttons/edit.png' alt='editar' title='Editar privilegios'/></a></td>";
				        echo "<td class='operaciones celda'><a href='index.php?controlador=Usuario&operacion=baja&parametro=$usuario->user'><img class='icono' src='images/buttons/delete.png' alt='borrar' title='Borrar usuario'/></a></td>";
				        echo "</tr>";
				}
				?>
			</table>
			
		
		</section>
		
		<?php Template::footer();?>
    </body>
</html>