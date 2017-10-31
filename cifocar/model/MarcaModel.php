<?php
	class MarcaModel{
		//PROPIEDADES
		public $marca;
			
		//METODOS
		//Guarda nueva marca en la BDD
		public static function nueva($marca){
			$consulta = "INSERT INTO marcas (marca) VALUES ('$marca');";
			return Database::get()->query($consulta);
		}
		
		//Modificar marca en la BDD
		public static function editar($marcaNueva, $marcaAntigua){
			$consulta = "UPDATE marcas SET marca='$marcaNueva' WHERE marca='$marcaAntigua';";
			//ejecutar la consulta
			Database::get()->query($consulta);
			//retornar el numero de filas afectadas 1 se hizo bien, 0 no se modifico nada
			return Database::get()->affected_rows;
		}
		
		//eliminar marca en la BDD
		public static function borrar($marca){
			//preparar la consulta
		    $consulta = "DELETE FROM marcas WHERE marca='$marca';";
			//ejecutar la consulta
			Database::get()->query($consulta);
			//retornar el numero de filas afectadas 1 se hizo bien, 0 no se modifico nada
			return Database::get()->affected_rows();
		}
		
		//método que me recupera el total de registros (incluso con filtros)
		public static function getTotal($t=''){
		    $consulta = "SELECT * FROM marcas
                         WHERE marca LIKE '%$t%'";
		    
		    $conexion = Database::get();
		    $resultados = $conexion->query($consulta);
		    $total = $resultados->num_rows;
		    $resultados->free();
		    return $total;
		}
		
		//Listar todas las marcas de la BDD (con filtros)
		public static function getMarcas($l=0, $o=0, $texto='', $sentido='ASC'){
		    $consulta = "SELECT * FROM marcas
                         WHERE marca LIKE '%$texto%'
                         ORDER BY marca $sentido ";
		    if($l>0) $consulta.="LIMIT $l ";
		    if($o>0) $consulta.="OFFSET $o ";
		    
		    $resultado = Database::get()->query($consulta);
		    $lista = array();
		   
		    while($m = $resultado->fetch_object())
		        $lista[]=$m->marca;
		    //Liberar memoria
		    $resultado->free();
		    //Retornar array (MarcaModel) con las marcas encontradas
		    return $lista;
		}
	}
?>