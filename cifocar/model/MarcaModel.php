<?php
	class MarcaModel{
		//PROPIEDADES
		public $marca;
			
		//METODOS
		//Guarda nueva marca en la BDD
		public function nueva(){
			$consulta = "INSERT INTO marcas (marca) VALUES ('$this->marca');";
			return Database::get()->query($consulta);
		}
		
		//Modificar marca en la BDD
		public static function actualizar($marcaNueva, $marcaAntigua){
			$consulta = "UPDATE marcas SET marca='$marcaNueva' WHERE marca='$marcaAntigua';";
			return Database::get()->query($consulta);
		}
		
		//eliminar marca en la BDD
		public function borrar(){
			$consulta = "DELETE FROM marcas WHERE marca='$this->marca';";
			return Database::get()->query($consulta);
		}
		
		//Listar una marca de la BDD
		public static function getMarca($m){
		    $consulta = "SELECT * FROM marcas WHERE marca=$m;";
		    $resultado = Database::get()->query($consulta);
		    $marca = $resultado->fetch_object('MarcaModel');
		    //Liberar memoria
		    $resultado->free();
		    return $marca;
		}
		
		//Listar todas las marcas de la BDD
		public function getMarcas(){
		    $consulta = "SELECT * FROM marcas;";
		    $resultado = Database::get()->query($consulta);
		    $listaMarcas = array();
		    while ($marca = $listaMarcas->fetch_object('MarcaModel'))
		        $listaMarcas[]=$marca;
		    //Liberar memoria
		    $resultado->free();
		    //Retornar array (MarcaModel) con las marcas encontradas
		    return $listaMarcas;
		}
	}
?>