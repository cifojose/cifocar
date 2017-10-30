0<?php
	class VehiculoModel{
		//PROPIEDADES
		public $id, $matricula, $modelo, $color, $precio_venta, $precio_compra, $kms, $caballos, $fecha_venta, $estado, $any_matriculacion;
		public $detalles, $imagen, $vendedor, $marca;
			
		//METODOS
		//guarda un nuevo vehiculo en la BDD
		public function nuevo(){
			$consulta = "INSERT INTO vehiculos (id, matricula, modelo, color, precio_venta, precio_compra,
                                      kms, caballos, estado, any_matriculacion,
                                      detalles, imagen, marca)
			             VALUES (DEFAULT,'$this->matricula','$this->modelo','$this->color',
			                     $this->precio_venta,$this->precio_compra,$this->kms,$this->caballos,
                                 $this->estado,$this->any_matriculacion,'$this->detalles','$this->imagen','$this->marca');";
				
			return Database::get()->query($consulta);
		}
		
		
		//modificar datos del vehiculo en la BDD
		public function modificar(){
			$consulta = "UPDATE vehiculos
   					     SET matricula='$this->matricula', 
						     modelo='$this->modelo', 
							 color='$this->color', 
                             precio_venta=$this->precio_venta, 
						     precio_compra=$this->precio_compra, 
							 kms=$this->kms,
                             caballos=$this->caballos,                             
                             estado=$this->estado,
                             any_matriculacion=$this->any_matriculacion,
                             detalles='$this->detalles',
                             imagen='$this->imagen',                             
                             marca='$this->marca'
			             WHERE id=$this->id;";
			return Database::get()->query($consulta);
		}
		
		
		//elimina el vehiculo de la BDD
		public static function borrar($id){
			$consulta = "DELETE FROM vehiculos WHERE id=$id;";
			return Database::get()->query($consulta);
		}
		
		
		//recupera un vehiculo por su ID de la BDD (o NULL si no existe)
		public static function getVehiculo($id){
			$consulta = "SELECT * FROM vehiculos WHERE id=$id;";
			$resultado = Database::get()->query($consulta);
			$vehiculo = $resultado->fetch_object('VehiculoModel');
			$resultado->free();
			return $vehiculo;
		}
		
				
		//método que me recupera el total de registros (incluso con filtros)
		public static function getTotal($t='', $c='modelo'){
		    $consulta = "SELECT * FROM vehiculos
                         WHERE $c LIKE '%$t%'";
		    
		    $conexion = Database::get();
		    $resultados = $conexion->query($consulta);
		    $total = $resultados->num_rows;
		    $resultados->free();
		    return $total;
		}
		
		//método que me recupera todos las vehiculos de la BDD
		//PROTOTIPO: public static array<VehiculoModel> getVehiculos(int limite)
		public static function getVehiculos($l=10, $o=0, $t='', $c='modelo', $co='id', $so='ASC'){
		    //preparar la consulta
		    $consulta = "SELECT * FROM vehiculos
                         WHERE $c LIKE '%$t%'
                         ORDER BY $co $so
		                 LIMIT $l
		                 OFFSET $o;";
		    
		    //conecto a la BDD y ejecuto la consulta
		    $conexion = Database::get();
		    $resultados = $conexion->query($consulta);
		    
		    //creo la lista de VehiculoModel
		    $lista = array();
		    while($vehiculo = $resultados->fetch_object('VehiculoModel'))
		        $lista[] = $vehiculo;
		        
		        //liberar memoria
		        $resultados->free();
		        
		        //retornar la lista de VehiculoModel
		        return $lista;
		}
		
		//metodo para vender vehiculos (modifica estado a vendido)
		public function vender($vendedor=NULL){
		    $consulta = "UPDATE vehiculos
   					     SET precio_venta=$this->precio_venta,
						     fecha_venta=$this->fecha_venta,
							 estado=$this->estado,
                             vendedor=intval($vendedor)
			             WHERE id=$this->id;";
		    return Database::get()->query($consulta);
		}
	}
?>