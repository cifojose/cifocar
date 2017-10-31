<?php if(empty ($GLOBALS['index_access'])) die('no se puede acceder directamente a una vista.'); ?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Config::get()->url_base;?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Listado de Marcas</title>
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
			<h2>Listado de marcas</h2>
			
			<p class="infolista">Hay <?php echo $totalRegistros; ?> registros<?php echo $filtro? ' para el filtro indicado':'';?>, 
			mostrando del <?php echo ($paginaActual-1)*$regPorPagina+1;?> al <?php echo ($paginaActual-1)*$regPorPagina+sizeof($marcas);?>.</p>
			
			<?php if(!$filtro){?>
			<form method="post" class="filtro" action="index.php?controlador=Marca&operacion=listar&parametro=1">
				<label>Filtro:</label>
				<input type="text" name="texto" placeholder="buscar..."/>
				<input type="submit" name="filtrar" value="Buscar"/>
				<label>Orden:</label>
				<select name="sentidoOrden">
					<option value="ASC" select="select" >ascendente</option>
					<option value="DESC">descendente</option>
				</select>
				<input type="submit" name="filtrar" value="Filtrar"/>
				
			</form>
			<?php }else{ ?>
			    <form method="post" class="filtro" action="index.php?controlador=Marca&operacion=listar&parametro=1">
			    	<input type="submit" name="quitarFiltro" value="Quitar filtro" />
			    	<label>(<?php echo $filtro->texto." orden: ".$filtro->sentidoOrden;?>)</label>
			    	
			    </form>
			<?php }?>
			
			<table>
				<tr>
					<th>Marca</th>
					<th>Operaciones</th>
				</tr>
				<?php
				foreach($marcas as $marca){
				    echo "<tr>";
				        echo "<td class='celda'>$marca</td>";
				        echo "<td class='foto celda'><a href='index.php?controlador=Marca&operacion=editar&parametro=$marca'><img class='icono' src='images/buttons/edit.png' alt='editar marca' title='editar marca'/></a></td>";
				    echo "</tr>";
				}
				?>
			</table>
			<ul class="paginacion">
				<?php
    				//poner enlace a la página anterior
    				if($paginaActual>1){
    				    echo "<li><a href='index.php?controlador=Receta&operacion=listar&parametro=1'>Primera</a></li>";
    				}
				
				    //poner enlace a la página anterior
    				if($paginaActual>2){
    				    echo "<li><a href='index.php?controlador=Receta&operacion=listar&parametro=".($paginaActual-1)."'>Anterior</a></li>";
    				}
				    //poner enlace a la página siguiente
    				if($paginaActual<$paginas-1){
    				    echo "<li><a href='index.php?controlador=Receta&operacion=listar&parametro=".($paginaActual+1)."'>Siguiente</a></li>";
    				}
    				
				    //Poner enlace a la última página
				    if($paginas>1 && $paginaActual<$paginas){
				        echo "<li><a href='index.php?controlador=Receta&operacion=listar&parametro=$paginas'>Ultima</a></li>";
				    }
				?>
			</ul>
			<p class="infolista">Viendo la página <?php echo $paginaActual.' de '.$paginas; ?> páginas de resultados</p>
			
			
			<p class="volver" onclick="history.back();">Atrás</p>
		
		</section>
		
		<?php Template::footer();?>
    </body>
</html>