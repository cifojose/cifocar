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
		public static function modificar($marcaNueva, $marcaAntigua){
			$consulta = "UPDATE marcas SET marca='$marcaNueva' WHERE marca='$marcaAntigua';";
			return Database::get()->query($consulta);
		}
		
		//eliminar marca en la BDD
		public static function borrar($marca){
			$consulta = "DELETE FROM marcas WHERE marca='$marca';";
			return Database::get()->query($consulta);
		}
		
		//Listar todas las marcas de la BDD
		public static function getMarcas(){
		    $consulta = "SELECT * FROM marcas;";
		    $resultado = Database::get()->query($consulta);
		    $lista = array();
		    while ($marca = $resultado->fetch_object('MarcaModel'))
		        $listaMarcas[]=$marca;
		    //Liberar memoria
		    $resultado->free();
		    //Retornar array (MarcaModel) con las marcas encontradas
		    return $listaMarcas;
		}
	}
?>