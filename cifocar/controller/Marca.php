<?php
	//CONTROLADOR MARCAS 
	// implementa las operaciones que se pueden realizar con las marcas
	class Marca extends Controller{

	    //PROCEDIMIENTO PARA LISTAR TODAS LAS MARCAS
	    public function listar(){
	        //si no es responsable de compras
	        if(Login::getUsuario()->privilegio !=1)
	            throw new Exception('Debe ser Responsable de compras para ver listado de Marcas');
	            
	            //recuperar las marcas
	            $this->load('model/MarcaModel.php');
	            $marcas = MarcaModel::getMarcas();
	            
	            //cargar la vista del listado
	            $datos = array();
	            $datos['usuario'] = Login::getUsuario();
	            $datos['marcas'] = $marcas;
	            $this->load_view('view/marcas/lista.php', $datos);
	    }
	    
		//PROCEDIMIENTO PARA REGISTRAR UNA NUEVA MARCA
		public function nueva(){
            //Si no es responsable de compras
		    if(Login::getUsuario()->privilegio !=1)
		        throw new Exception('Debe ser Responsable de compras para agregar una nueva marca');
		    
			//si no llegan los datos a guardar
			if(empty($_POST['guardar'])){
				
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$this->load_view('view/marcas/registro.php', $datos);
			
			//si llegan los datos por POST
			}else{
				//crear una instancia de Marca
			    $this->load('model/MarcaModel.php');
				$marca = new MarcaModel();
				$conexion = Database::get();
				
				//tomar los datos que vienen por POST
				//real_escape_string evita las SQL Injections
				$marca->marca = $conexion->real_escape_string($_POST['marca']);
															
				//guardar la marca en BDD
				if(!$marca->nueva())
					throw new Exception('No se pudo agregar la nueva marca '.$marca);
				
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Se ha guardado correctamente la nueva marca '.$marca;
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		//PROCEDIMIENTO PARA MODIFICAR UNA MARCA
		public function modificar($marcaAntigua){
		    //Si no es responsable de compras
		    if(Login::getUsuario()->privilegio !=1)
		        throw new Exception('Debe ser Responsable de compras para modificar una marca');
			
		    
			//si no llegan los datos a modificar
			if(empty($_POST['modificar'])){
				
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['marca'] = $marcaAntigua;
				$this->load_view('view/marcas/modificacion.php', $datos);
					
				//si llegan los datos por POST
			}else{
												
				//recupera el nuevo nombre de la marca
				$marcaNueva = $conexion->real_escape_string($_POST['nombre']);
								
				}
						
				//modificar el usuario en BDD
				if(!MarcaModel::modificar($marcaNueva,$marcaAntigua))
					throw new Exception('No se pudo modificar la marca '.$marcaAntigua.' por la nueva marca '.$marcaNueva);
		
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Modificación de la marca OK';
				$this->load_view('view/exito.php', $datos);
			}
		
		//PROCEDIMIENTO PARA ELIMINAR UNA MARCA
		//solicita confirmación
		public function borrar($marca){		
		    //Si no es responsable de compras
		    if(Login::getUsuario()->privilegio !=1)
		        throw new Exception('Debe ser Responsable de compras para eliminar una marca');
			
			//si no nos están enviando la conformación de baja
			//cargamos el formulario de confirmación
			if(empty($_POST['confirmar'])){	
				//carga el formulario de confirmación
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['marca'] = $marca;
				$this->load_view('view/marcas/eliminar.php', $datos);
		
			//si nos están enviando la confirmación de baja
			}else{
				//Eliminamos la marca de la BDD
				if(!MarcaModel::borrar($marca))
					throw new Exception('No se pudo eliminar la marca '.$marca);
				
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Eliminada la marca correctamente';
				$this->load_view('view/exito.php', $datos);
			}
	   }
	}
?>