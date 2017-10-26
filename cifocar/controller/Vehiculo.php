<?php
	//CONTROLADOR RECETA 
	class Vehiculo extends Controller{

		//PROCEDIMIENTO PARA GUARDAR UNA NUEVA RECETA
		public function nueva(){
		    //comprobar si eres administrador
		    if(!Login::isAdmin())
		        throw new Exception('Debes ser ADMIN');

			//si no llegan los datos a guardar
			if(empty($_POST['guardar'])){
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$this->load_view('view/recetas/nueva.php', $datos);
			
			//si llegan los datos por POST
			}else{
				//crear una instancia de Receta
				$this->load('model/RecetaModel.php');
				$receta = new RecetaModel();
				$conexion = Database::get();
				
				//tomar los datos que vienen por POST
				//real_escape_string evita las SQL Injections
				$receta->nombre = $conexion->real_escape_string($_POST['nombre']);
				$receta->descripcion = $conexion->real_escape_string($_POST['descripcion']);
				$receta->ingredientes = $conexion->real_escape_string($_POST['ingredientes']);
				$receta->dificultad = $conexion->real_escape_string($_POST['dificultad']);
				$receta->tiempo = $conexion->real_escape_string($_POST['tiempo']);
			
				//recuperar el fichero
				$fichero = $_FILES['imagen'];
				
				$destino = 'images/recetas/';
				$tam_maximo = 1000000; //1MB aprox
				$renombrar = true;
				
				$upload = new Upload($fichero, $destino, $tam_maximo, $renombrar);
				$receta->imagen = $upload->upload_image();
							
				//guardar la receta en BDD
				if(!$receta->guardar()){
				    unlink($receta->imagen);
					throw new Exception('No se pudo guardar la receta');
				}
				
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Operación de guardado completada con éxito';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		
		//PROCEDIMIENTO PARA LISTAR LAS RECETAS
		public function listar($pagina){
		    $this->load('model/RecetaModel.php');
		    
		    //si me piden APLICAR un filtro
		    if(!empty($_POST['filtrar'])){
		        //recupera el filtro a aplicar
		        $f = new stdClass(); //filtro
		        $f->texto = htmlspecialchars($_POST['texto']);
		        $f->campo = htmlspecialchars($_POST['campo']);
		        $f->campoOrden = htmlspecialchars($_POST['campoOrden']);
		        $f->sentidoOrden = htmlspecialchars($_POST['sentidoOrden']);
		        
		        //guarda el filtro en un var de sesión
		        $_SESSION['filtroRecetas'] = serialize($f);
		    }
		  
		    //si me piden QUITAR un filtro
		    if(!empty($_POST['quitarFiltro']))
		        unset($_SESSION['filtroRecetas']);
		    
		    
	        //comprobar si hay filtro
	        $filtro = empty($_SESSION['filtroRecetas'])? false : unserialize($_SESSION['filtroRecetas']);
		        
		    //para la paginación
		    $num = 5; //numero de resultados por página
		    $pagina = abs(intval($pagina)); //para evitar cosas raras por url
		    $pagina = empty($pagina)? 1 : $pagina; //página a mostrar
		    $offset = $num*($pagina-1); //offset
		    
		    //si no hay que filtrar los resultados...
		    if(!$filtro){
		      //recupera todas las recetas
		      $recetas = RecetaModel::getRecetas($num, $offset);
		      //total de registros (para paginación)
		      $totalRegistros = RecetaModel::getTotal();
		    }else{
		      //recupera las recetas con el filtro aplicado
		      $recetas = RecetaModel::getRecetas($num, $offset, $filtro->texto, $filtro->campo, $filtro->campoOrden, $filtro->sentidoOrden);
		      //total de registros (para paginación)
		      $totalRegistros = RecetaModel::getTotal($filtro->texto, $filtro->campo);
		    }
		    
		    //cargar la vista del listado
		    $datos = array();
		    $datos['usuario'] = Login::getUsuario();
		    $datos['recetas'] = $recetas;
		    $datos['filtro'] = $filtro;
		    $datos['paginaActual'] = $pagina;
		    $datos['paginas'] = ceil($totalRegistros/$num); //total de páginas (para paginación)
		    $datos['totalRegistros'] = $totalRegistros;
		    $datos['regPorPagina'] = $num;
		    
		    if(Login::isAdmin())
		      $this->load_view('view/recetas/lista_admin.php', $datos);
		    else
		      $this->load_view('view/recetas/lista.php', $datos);
		}
		
		
		
		//PROCEDIMIENTO PARA VER LOS DETALLES DE UNA RECETA
		public function ver($id=0){
		    //comprobar que llega la ID
		    if(!$id) 
		        throw new Exception('No se ha indicado la ID de la receta');
		    
		    //recuperar la receta con la ID seleccionada
		    $this->load('model/RecetaModel.php');
		    $receta = RecetaModel::getReceta($id);
		    
		    //comprobar que la receta existe
		    if(!$receta)
		        throw new Exception('No existe la receta con código '.$id);
		    
		    //cargar la vista de detalles
		    $datos = array();
		    $datos['usuario'] = Login::getUsuario();
		    $datos['receta'] = $receta;
		    $this->load_view('view/recetas/detalles.php', $datos);
		}
		
		
		//PROCEDIMIENTO PARA EDITAR UNA RECETA
		public function editar($id=0){
		    //comprobar que el usuario es admin
		    if(!Login::isAdmin())
		        throw new Exception('Debes ser admin');
		    
		    //comprobar que me llega un id
		    if(!$id)
		        throw new Exception('No se indicó la id de la receta');
		        
		    //recuperar la receta con esa id
		    $this->load('model/RecetaModel.php');
		    $receta = RecetaModel::getReceta($id);
		    
		    //comprobar que existe la receta
		    if(!$receta)
		        throw new Exception('No existe la receta');   
		    
		    //si no me están enviando el formulario
		    if(empty($_POST['modificar'])){
		      //poner el formulario
		        $datos = array();
		        $datos['usuario'] = Login::getUsuario();
		        $datos['receta'] = $receta;
		        $this->load_view('view/recetas/modificar.php', $datos);

		    }else{
		    //en caso contrario
		      $conexion = Database::get();
		      //actualizar los campos de la receta con los datos POST
		      $receta->nombre = $conexion->real_escape_string($_POST['nombre']);
		      $receta->descripcion = $conexion->real_escape_string($_POST['descripcion']);
		      $receta->ingredientes = $conexion->real_escape_string($_POST['ingredientes']);
		      $receta->dificultad = $conexion->real_escape_string($_POST['dificultad']);
		      $receta->tiempo = intval($_POST['tiempo']);
		      
		      //tratamiento de la imagen
		      $fichero = $_FILES['imagen'];
		      
		      //si me indican una nueva imagen
		      if($fichero['error']!=UPLOAD_ERR_NO_FILE){
		          $fotoAntigua = $receta->imagen;
		          
		          //subir la nueva imagen
		          $destino = 'images/recetas/';
		          $tam_maximo = 1000000;
		          $renombrar = true;
		          
		          $upload = new Upload($fichero, $destino , $tam_maximo, $renombrar);
		          $receta->imagen = $upload->upload_image();
		          
		          //borrar la antigua
		          unlink($fotoAntigua);
		      }
		      
		      
		      //modificar la receta en la BDD
		      if(!$receta->actualizar())
		          throw new Exception('No se pudo actualizar');
		      
		      //cargar la vista de éxito 
	          $datos = array();
	          $datos['usuario'] = Login::getUsuario();
	          $datos['mensaje'] = "Datos de la receta <a href='index.php?controlador=Receta&operacion=ver&parametro=$receta->id'>'$receta->nombre'</a> actualizados correctamente.";
	          $this->load_view('view/exito.php', $datos);
		    }
		}
		
		//PROCEDIMIENTO PARA BORRAR UNA RECETA
		public function borrar($id=0){
		   //comprobar que el usuario sea admin
		   if(!Login::isAdmin())
		       throw new Exception('Debes ser ADMIN');
		   
	       //comprobar que se ha indicado un id
	       if(!$id)
	           throw new Exception('No se indicó la receta a borrar');
		       
	       //recuperar la receta con esa id
	       $this->load('model/RecetaModel.php');
	       $receta = RecetaModel::getReceta($id);
	       
	       //comprobar que existe dicha receta
	       if(!$receta)
	           throw new Exception('No existe la receta con id '.$id);
	           
	       
		   //si no me envian el formulario de confirmación
		   if(empty($_POST['confirmarborrado'])){
		      //mostrar el formularion de confirmación junto con los datos de la receta
		      $datos = array();
		      $datos['usuario'] = Login::getUsuario();
		      $datos['receta'] = $receta; 
		      $this->load_view('view/recetas/confirmarborrado.php', $datos);
		   
		   //si me envian el formulario...
		   }else{
		      //borramos la receta de la BDD
		      if(!RecetaModel::borrar($id))
		          throw new Exception('No se pudo borrar, es posible que se haya borrado ya.');
		      
		      //borra la imagen de la receta del servidor
		      unlink($receta->imagen);    
		      
		      //cargar la vista de éxito
	          $datos = array();
	          $datos['usuario'] = Login::getUsuario();
	          $datos['mensaje'] = 'Operación de borrado ejecutada con éxito.';
	          $this->load_view('view/exito.php', $datos);
		          
		   }
		}

	}
?>