<?php
	//CONTROLADOR MARCAS 
	// implementa las operaciones que se pueden realizar con las marcas
	class Marca extends Controller{

	    //PROCEDIMIENTO PARA LISTAR LAS MARCAS
	    public function listar($pagina){
	        $this->load('model/MarcaModel.php');
	        
	        //si me piden APLICAR un filtro
	        if(!empty($_POST['filtrar'])){
	            //recupera el filtro a aplicar
	            $f = new stdClass(); //filtro
	            $f->texto = htmlspecialchars($_POST['texto']);
	            $f->sentidoOrden = htmlspecialchars($_POST['sentidoOrden']);
	            
	            //guarda el filtro en un var de sesión
	            $_SESSION['filtroMarcas'] = serialize($f);
	        }
	        
	        //si me piden QUITAR un filtro
	        if(!empty($_POST['quitarFiltro']))
	            unset($_SESSION['filtroMarcas']);
	            
	            
	            //comprobar si hay filtro
	            $filtro = empty($_SESSION['filtroMarcas'])? false : unserialize($_SESSION['filtroMarcas']);
	            
	            //para la paginación
	            $num = 10; //numero de resultados por página
	            $pagina = abs(intval($pagina)); //para evitar cosas raras por url
	            $pagina = empty($pagina)? 1 : $pagina; //página a mostrar
	            $offset = $num*($pagina-1); //offset
	            
	            //si no hay que filtrar los resultados...
	            if(!$filtro){
	                //recupera todas las marcas
	                $marcas = MarcaModel::getMarcas($num, $offset);
	                //total de registros (para paginación)
	                $totalRegistros = MarcaModel::getTotal();
	            }else{
	                //recupera las marcas con el filtro aplicado
	                $marcas = MarcaModel::getMarcas($num, $offset, $filtro->texto, $filtro->sentidoOrden);
	                //total de registros (para paginación)
	                $totalRegistros = MarcaModel::getTotal($filtro->texto);
	            }
	            
	            //cargar la vista del listado
	            $datos = array();
	            $datos['usuario'] = Login::getUsuario();
	            $datos['marcas'] = $marcas;
	            $datos['filtro'] = $filtro;
	            $datos['paginaActual'] = $pagina;
	            $datos['paginas'] = ceil($totalRegistros/$num); //total de páginas (para paginación)
	            $datos['totalRegistros'] = $totalRegistros;
	            $datos['regPorPagina'] = $num;
	            //Carga la vista de lista de marcas
	            $this->load_view('view/marcas/listar.php', $datos);
	            
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
				$conexion = Database::get();
				
				//tomar los datos que vienen por POST
				//real_escape_string evita las SQL Injections
				$marca = $conexion->real_escape_string($_POST['marca']);
															
				//guardar la marca en BDD
				if(!MarcaModel::nueva($conexion->real_escape_string($_POST['marca'])))
					throw new Exception('No se pudo agregar la nueva marca '.$marca);
				
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Se ha guardado correctamente la nueva marca '.$marca;
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		//PROCEDIMIENTO PARA MODIFICAR UNA MARCA
		public function editar($marcaAntigua){
		    //Si no es responsable de compras
		    if(Login::getUsuario()->privilegio !=1)
		        throw new Exception('Debe ser Responsable de compras para modificar una marca');
			
		    $this->load('model/MarcaModel.php');
		    $conexion=Database::get();
		    
			//si no llegan los datos a modificar
			if(empty($_POST['modificar'])){
				
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['marcaAntigua'] = $marcaAntigua;
				$this->load_view('view/marcas/editar.php', $datos);
					
				//si llegan los datos por POST
			}else{
												
				//recupera el nuevo nombre de la marca
				$marcaNueva = $conexion->real_escape_string($_POST['marcaNueva']);
														
				//modificar el usuario en BDD
				if(!MarcaModel::editar($marcaNueva,$marcaAntigua))
					throw new Exception('No se pudo modificar la marca '.$marcaAntigua.' por la nueva marca '.$marcaNueva);
		
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Modificación de la marca OK';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		//PROCEDIMIENTO PARA ELIMINAR UNA MARCA
		//solicita confirmación
		public function borrar($marca){		
		    //Si no es responsable de compras
		    if(Login::getUsuario()->privilegio !=1)
		        throw new Exception('Debe ser Responsable de compras para eliminar una marca');
			
		    $this->load('model/MarcaModel.php');
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