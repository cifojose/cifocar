<?php
	//CONTROLADOR VEHICULO 
	class Vehiculo extends Controller{

		//PROCEDIMIENTO PARA GUARDAR UN NUEVO VEHICULO
		public function nueva(){
		    //comprobar si el usuario es responsable de compras
		    if(Login::getUsuario()->privilegio !=1)
		        throw new Exception('Debe ser Responsable de compras para crear un nuevo vehiculo');

			//si no llegan los datos a guardar
			if(empty($_POST['guardar'])){
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$this->load_view('view/vehiculos/nueva.php', $datos);
			
			//si llegan los datos por POST
			}else{
				//crear una instancia del Vehiculo
				$this->load('model/VehiculoModel.php');
				$vehiculo = new VehiculoModel();
				$conexion = Database::get();
				
				//tomar los datos que vienen por POST
				//real_escape_string evita las SQL Injections
				$vehiculo->matricula = $conexion->real_escape_string($_POST['matricula']);
				$vehiculo->modelo = $conexion->real_escape_string($_POST['modelo']);
				$vehiculo->color = $conexion->real_escape_string($_POST['color']);
				$vehiculo->precio_venta = $_POST['precio_venta'];
				$vehiculo->precio_compra = $_POST['precio_compra'];
				$vehiculo->kms = $_POST['kms'];
				$vehiculo->caballos = $_POST['caballos'];
				$vehiculo->estado = $_POST['estado'];
				$vehiculo->any_matriculacion = $_POST['any_matriculacion'];
				$vehiculo->detalles = $conexion->real_escape_string($_POST['detalles']);
				$vehiculo->imagen = $conexion->real_escape_string($_POST['imagen']);
				$vehiculo->marca = $_POST['marca'];
				
			
				//recuperar el fichero
				$fichero = $_FILES['imagen'];
				
				$destino = 'images/vehiculos/';
				$tam_maximo = 2000000; //2MB aprox
				$renombrar = true;
				
				$upload = new Upload($fichero, $destino, $tam_maximo, $renombrar);
				$vehiculo->imagen = $upload->upload_image();
							
				//guardar la vehiculo en BDD
				if(!$vehiculo->nuevo()){
				    unlink($vehiculo->imagen);
					throw new Exception('No se pudo guardar la vehiculo');
				}
				
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Se ha creado el nuevo vehiculo correctamente';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		
		//PROCEDIMINETO PARA MODIFICAR EL ESTADO DE UN VEHICULO
		public static function modificarEstado($id){
		    //comprobar si el usuario es vendedor
		    if(Login::getUsuario()->privilegio !=2)
		        throw new Exception('Debe ser Vendedor para modificar el estado de un vehiculo');
		    
		    //Verificamos si llega la ID
		    if(!$id)
		      throw new Exception('No se ha seleccionado una ID valida');
		    //recuperamos el vehiculo
		    $this->load('model/VehiculoModel.php');
		    $vehiculo = VehiculoModel::getVehiculo($id);
		    //Verificamos si existe la ID
		    if(!$vehiculo)
		        throw new Exception('No existe el vehiculo con la id '.$id);
		    
	        //si no me están enviando el formulario
	        if(empty($_POST['modificar'])){
	            //poner el formulario
	            $datos = array();
	            $datos['usuario'] = Login::getUsuario();
	            $datos['vehiculo'] = $vehiculo;
	            $this->load_view('view/vehiculos/modificar_estados.php', $datos);
	            
	        }else{
	            //en caso contrario
	            $conexion = Database::get();
	            //actualizar el estado del vehiculo con los datos POST
	            $vehiculo->estado = $_POST['estado'];
	            //actualizar la BDD
	            if (!$vehiculo->modificar())
	                throw new Exception('No se ha podido modificar el estado del vehiculo con id '.$id);
	            //enviar datos vista de exito
	            $datos = array();
	            $datos = ['usuario'] = Login::getUsuario();
	            $datos = ['mensaje'] = "La modificacion del estado del vehiculo con id $id se ha realizado correctamente";
	            $this->load_view('view/exito.php', $datos);
	        }
		}
		
		
		//PROCEDIMIENTO PARA LISTAR LAS VEHICULOS
		public function listar($pagina){
		    $this->load('model/VehiculoModel.php');
		    
		    //si me piden APLICAR un filtro
		    if(!empty($_POST['filtrar'])){
		        //recupera el filtro a aplicar
		        $f = new stdClass(); //filtro
		        $f->texto = htmlspecialchars($_POST['texto']);
		        $f->campo = htmlspecialchars($_POST['campo']);
		        $f->campoOrden = htmlspecialchars($_POST['campoOrden']);
		        $f->sentidoOrden = htmlspecialchars($_POST['sentidoOrden']);
		        
		        //guarda el filtro en un var de sesión
		        $_SESSION['filtroVehiculos'] = serialize($f);
		    }
		  
		    //si me piden QUITAR un filtro
		    if(!empty($_POST['quitarFiltro']))
		        unset($_SESSION['filtroVehiculos']);
		    
		    
	        //comprobar si hay filtro
	        $filtro = empty($_SESSION['filtroVehiculos'])? false : unserialize($_SESSION['filtroVehiculos']);
		        
		    //para la paginación
		    $num = 7; //numero de resultados por página
		    $pagina = abs(intval($pagina)); //para evitar cosas raras por url
		    $pagina = empty($pagina)? 1 : $pagina; //página a mostrar
		    $offset = $num*($pagina-1); //offset
		    
		    //si no hay que filtrar los resultados...
		    if(!$filtro){
		      //recupera todos las vehiculos
		      $vehiculos = VehiculoModel::getVehiculos($num, $offset);
		      //total de registros (para paginación)
		      $totalRegistros = VehiculoModel::getTotal();
		    }else{
		      //recupera las vehiculos con el filtro aplicado
		      $vehiculos = VehiculoModel::getVehiculos($num, $offset, $filtro->texto, $filtro->campo, $filtro->campoOrden, $filtro->sentidoOrden);
		      //total de registros (para paginación)
		      $totalRegistros = VehiculoModel::getTotal($filtro->texto, $filtro->campo);
		    }
		    
		    //cargar la vista del listado
		    $datos = array();
		    $datos['usuario'] = Login::getUsuario();
		    $datos['vehiculos'] = $vehiculos;
		    $datos['filtro'] = $filtro;
		    $datos['paginaActual'] = $pagina;
		    $datos['paginas'] = ceil($totalRegistros/$num); //total de páginas (para paginación)
		    $datos['totalRegistros'] = $totalRegistros;
		    $datos['regPorPagina'] = $num;
		    
		    if(Login::isAdmin()){
		        $this->load_view('view/vehiculos/lista_admin.php', $datos);
		    }else{
		      if(Login::getUsuario()->privilegio ==1){
		          $this->load_view('view/vehiculos/lista_compras.php', $datos);
		      }else{
		          $this->load_view('view/vehiculos/lista.php', $datos);
		      }
		    }		      
		}
		
		//PROCEDIMIENTO PARA VER LOS DETALLES DE UN VEHICULO
		public function ver($id=0){
		    //comprobar que llega la ID
		    if(!$id) 
		        throw new Exception('No se ha indicado la ID del vehiculo');
		    
		    //recuperar el vehiculo con la ID seleccionada
		    $this->load('model/VehiculoModel.php');
		    $vehiculo = VehiculoModel::getVehiculo($id);
		    
		    //comprobar que el vehiculo existe
		    if(!$vehiculo)
		        throw new Exception('No existe el vehiculo con código '.$id);
		    
		    //cargar la vista de detalles
		    $datos = array();
		    $datos['usuario'] = Login::getUsuario();
		    $datos['vehiculo'] = $vehiculo;
		    $this->load_view('view/vehiculos/detalles.php', $datos);
		}
		
		
		//PROCEDIMIENTO PARA EDITAR UN VEHICULO
		public function editar($id=0){
		    //comprobar si el usuario es responsable de compras
		    if(Login::getUsuario()->privilegio !=1)
		        throw new Exception('Debe ser Responsable de compras para modificar un vehiculo');
		    
		    //comprobar que me llega un id
		    if(!$id)
		        throw new Exception('No se indicó la id del vehiculo');
		        
		    //recuperar la vehiculo con esa id
		    $this->load('model/VehiculoModel.php');
		    $vehiculo = VehiculoModel::getVehiculo($id);
		    
		    //comprobar que existe la vehiculo
		    if(!$vehiculo)
		        throw new Exception('No existe el vehiculo '.$id);   
		    
		    //si no me están enviando el formulario
		    if(empty($_POST['modificar'])){
		      //poner el formulario
		        $datos = array();
		        $datos['usuario'] = Login::getUsuario();
		        $datos['vehiculo'] = $vehiculo;
		        $this->load_view('view/vehiculos/modificar.php', $datos);

		    }else{
		    //en caso contrario
		      $conexion = Database::get();
		      //actualizar los campos de la vehiculo con los datos POST
		      $vehiculo->matricula = $conexion->real_escape_string($_POST['matricula']);
		      $vehiculo->modelo = $conexion->real_escape_string($_POST['modelo']);
		      $vehiculo->color = $conexion->real_escape_string($_POST['color']);
		      $vehiculo->precio_venta = $_POST['precio_venta'];
		      $vehiculo->precio_compra = $_POST['precio_compra'];
		      $vehiculo->kms = $_POST['kms'];
		      $vehiculo->caballos = $_POST['caballos'];
		      $vehiculo->estado = $_POST['estado'];
		      $vehiculo->any_matriculacion = $_POST['any_matriculacion'];
		      $vehiculo->detalles = $conexion->real_escape_string($_POST['detalles']);
		      $vehiculo->imagen = $conexion->real_escape_string($_POST['imagen']);
		      $vehiculo->marca = $_POST['marca'];
		      		      
		      //tratamiento de la imagen
		      $fichero = $_FILES['imagen'];
		      
		      //si me indican una nueva imagen
		      if($fichero['error']!=UPLOAD_ERR_NO_FILE){
		          $fotoAntigua = $vehiculo->imagen;
		          
		          //subir la nueva imagen
		          $destino = 'images/vehiculos/';
		          $tam_maximo = 2000000;
		          $renombrar = true;
		          
		          $upload = new Upload($fichero, $destino , $tam_maximo, $renombrar);
		          $vehiculo->imagen = $upload->upload_image();
		          $fotoNueva = $vehiculo->imagen;
		      }
		      
		      //modificar el vehiculo en la BDD
		      if(!$vehiculo->actualizar()){
		          //borrar la foto nueva
		          unlink($fotoNueva);
		          throw new Exception('No se pudo actualizar las modificaciones en el vehiculo con id '.$id);
		      }else{
		          //borrar la foto antigua
		          unlink($fotoAntigua);
		      }
		      
		      //cargar la vista de éxito 
	          $datos = array();
	          $datos['usuario'] = Login::getUsuario();
	          $datos['mensaje'] = "Datos del vehiculo <b><a href='index.php?controlador=Vehiculo&operacion=ver&parametro=$vehiculo->id'></a></b> actualizados correctamente.";
	          $this->load_view('view/exito.php', $datos);
		    }
		}
		
		//PROCEDIMIENTO PARA BORRAR UN VEHICULO
		public function borrar($id=0){
		    //comprobar si el usuario es responsable de compras
		    if(!Login::isAdmin())
		        throw new Exception('Debe ser Administrador para borrar un vehiculo');
		   
	       //comprobar que se ha indicado un id
	       if(!$id)
	           throw new Exception('No se indicó el vehiculo a borrar');
		       
	       //recuperar la vehiculo con esa id
	       $this->load('model/VehiculoModel.php');
	       $vehiculo = VehiculoModel::getVehiculo($id);
	       
	       //comprobar que existe dicho vehiculo
	       if(!$vehiculo)
	           throw new Exception('No existe el vehiculo con id '.$id);
	           
	       
		   //si no me envian el formulario de confirmación
		   if(empty($_POST['confirmarborrado'])){
		      //mostrar el formularion de confirmación junto con los datos del vehiculo
		      $datos = array();
		      $datos['usuario'] = Login::getUsuario();
		      $datos['vehiculo'] = $vehiculo; 
		      $this->load_view('view/vehiculos/confirmarborrado.php', $datos);
		   
		   //si me envian el formulario...
		   }else{
		      //borramos la vehiculo de la BDD
		      if(!VehiculoModel::borrar($id))
		          throw new Exception('No se pudo borrar el vehiculo');
		      
		      //borra la imagen de la vehiculo del servidor
		      unlink($vehiculo->imagen);    
		      
		      //cargar la vista de éxito
	          $datos = array();
	          $datos['usuario'] = Login::getUsuario();
	          $datos['mensaje'] = 'Operación de borrado ejecutada con éxito.';
	          $this->load_view('view/exito.php', $datos);
		          
		   }
		}

	}
?>