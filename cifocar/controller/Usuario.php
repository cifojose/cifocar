<?php
	//CONTROLADOR USUARIO 
	// implementa las operaciones que puede realizar el usuario
	class Usuario extends Controller{

		//PROCEDIMIENTO PARA REGISTRAR UN USUARIO
		public function registro(){
            //verificar si el usuario es administrador
            if(!Login::isAdmin())
                throw new Exception('Debe tener permisos de administrador para crear un nuevo usuario');
             
			//si no llegan los datos a guardar
			if(empty($_POST['guardar'])){
				
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['max_image_size'] = Config::get()->user_image_max_size;
				$this->load_view('view/usuarios/registro.php', $datos);
			
			//si llegan los datos por POST
			}else{
				//crear una instancia de Usuario
				$u = new UsuarioModel();
				$conexion = Database::get();
				
				//tomar los datos que vienen por POST
				//real_escape_string evita las SQL Injections
				$u->user = $conexion->real_escape_string($_POST['user']);
				$u->password = MD5($conexion->real_escape_string($_POST['password']));
				$u->nombre = $conexion->real_escape_string($_POST['nombre']);
				$u->privilegio = intval($_POST['privilegio']);
				$u->admin = empty($_POST['admin'])? 0 : 1;
				$u->email = $conexion->real_escape_string($_POST['email']);
				$u->imagen = Config::get()->default_user_image;
				
				//recuperar y guardar la imagen (solamente si ha sido enviada)
				if($_FILES['imagen']['error']!=4){
					//el directorio y el tam_maximo se configuran en el fichero config.php
					$dir = Config::get()->user_image_directory;
					$tam = Config::get()->user_image_max_size;
					
					$upload = new Upload($_FILES['imagen'], $dir, $tam);
					$u->imagen = $upload->upload_image();
				}
								
				//guardar el usuario en BDD
				if(!$u->guardar())
					throw new Exception('No se pudo registrar el usuario');
				
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Operación de registro completada con éxito';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		
		//PROCEDIMIENTO PARA LISTAR TODOS LOS USUARIOS
	    public function listar(){
	        //verificar si el usuario es administrador
	        if(!Login::isAdmin())
	            throw new Exception('Debe tener permisos de administrador para listar usuarios');
	        //recuperar las recetas
	        $this->load('model/UsuarioModel.php');
	        $usuarios = UsuarioModel::getUsuarios();
	        
	        //cargar la vista del listado
	        $datos = array();
	        $datos['usuario'] = Login::getUsuario();
	        $datos['usuarios'] = $usuarios;
	        $this->load_view('view/usuarios/lista.php', $datos);
	    }
		

	    //PROCEDIMIENTO PARA MODIFICAR PRIVILEGIOS DE USUARIOS
	    public function editar($u=""){
	        //comprobar que el usuario es admin
	        if(!Login::isAdmin())
	            throw new Exception('Debes ser administrador');
	            
	        //comprobar que me llega un id
	        if(!$u)
	           throw new Exception('No se indicó el user del usuario');
	                
            //recuperar la receta con esa id
            $this->load('model/UsuarioModel.php');
            $usuarioM = UsuarioModel::getUsuario($u);
            
            //comprobar que existe el usuario
            if(!$usuarioM)
                throw new Exception('No existe el usuario');
	                    
            //si no me están enviando el formulario
            if(empty($_POST['modificar'])){
                //poner el formulario
                $datos = array();
                $datos['usuario'] = Login::getUsuario();
                $datos['usuarioM'] = $usuarioM;
                $this->load_view('view/usuarios/modificacionAdmin.php', $datos);
                
            }else{
                //en caso contrario
                $conexion = Database::get();
                //actualizar los campos del usuario con los datos POST
                $usuarioM->email=$conexion->real_escape_string($_POST['email']);
                $usuarioM->privilegio= $_POST['privilegio'];
                $usuarioM->admin = empty($_POST['admin'])? 0 : 1;
                	                        
                //modificar el usuario en la BDD
                if(!$usuarioM->actualizarPrivi())
                    throw new Exception('No se pudo actualizar');
                    //cargar la vista de éxito
                    $datos = array();
                    $datos['usuario'] = Login::getUsuario();
                    $datos['mensaje'] = "Datos del usuario <a href='index.php?controlador=Usuario&operacion=ver&parametro=$usuarioM->user'>'$usuarioM->user'</a> actualizados correctamente.";
                    $this->load_view('view/exito.php', $datos);
            }
	    }
	    
	    
		//PROCEDIMIENTO PARA MODIFICAR UN USUARIO
		public function modificacion(){
			//si no hay usuario identificado... error
			if(!Login::getUsuario())
				throw new Exception('Debes estar identificado para poder modificar tus datos');
				
			//si no llegan los datos a modificar
			if(empty($_POST['modificar'])){
				
				//mostramos la vista del formulario
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['max_image_size'] = Config::get()->user_image_max_size;
				$this->load_view('view/usuarios/modificacion.php', $datos);
					
				//si llegan los datos por POST
			}else{
				//recuperar los datos actuales del usuario
				$u = Login::getUsuario();
				$conexion = Database::get();
				
				//comprueba que el usuario se valide correctamente
				$p = MD5($conexion->real_escape_string($_POST['password']));
				if($u->password != $p)
					throw new Exception('El password no coincide, no se puede procesar la modificación');
								
				//recupera el nuevo password (si se desea cambiar)
				if(!empty($_POST['newpassword']))
					$u->password = MD5($conexion->real_escape_string($_POST['newpassword']));
				
				//recupera el nuevo nombre y el nuevo email
				$u->nombre = $conexion->real_escape_string($_POST['nombre']);
				$u->email = $conexion->real_escape_string($_POST['email']);
						
				//TRATAMIENTO DE LA NUEVA IMAGEN DE PERFIL (si se indicó)
				if($_FILES['imagen']['error']!=4){
					//el directorio y el tam_maximo se configuran en el fichero config.php
					$dir = Config::get()->user_image_directory;
					$tam = Config::get()->user_image_max_size;
					
					//prepara la carga de nueva imagen
					$upload = new Upload($_FILES['imagen'], $dir, $tam);
					
					//guarda la imagen antigua en una var para borrarla 
					//después si todo ha funcionado correctamente
					$old_img = $u->imagen;
					
					//sube la nueva imagen
					$u->imagen = $upload->upload_image();
				}
				
				//modificar el usuario en BDD
				if(!$u->actualizar())
					throw new Exception('No se pudo modificar');
		
				//borrado de la imagen antigua (si se cambió)
				//hay que evitar que se borre la imagen por defecto
				if(!empty($old_img) && $old_img!= Config::get()->default_user_image)
					@unlink($old_img);
						
				//hace de nuevo "login" para actualizar los datos del usuario
				//desde la BDD a la variable de sesión.
				Login::log_in($u->user, $u->password);
					
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Modificación OK';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		
		//PROCEDIMIENTO PARA DAR DE BAJA UN USUARIO
		//solicita confirmación
		public function baja($user){		
		    //verificar si el usuario es administrador
		    if(!Login::isAdmin())
		        throw new Exception('Debe tener permisos de administrador para eliminar un usuario');
			
			//recuperar usuario
			$u = UsuarioModel::getUsuario($user);
			
					
			//si no nos están enviando la conformación de baja
			if(empty($_POST['confirmar'])){	
				//carga el formulario de confirmación
				$datos = array();
				$datos['usuario'] = $u;
				$this->load_view('view/usuarios/baja.php', $datos);
		
			//si nos están enviando la confirmación de baja
			}else{
				//borrar el usuario seleccionado de la lista
				if(!$u->borrar())
					throw new Exception('No se pudo dar de baja');
						
				//borra la imagen (solamente en caso que no sea imagen por defecto)
				if($u->imagen!=Config::get()->default_user_image)
					@unlink($u->imagen); 
											
				//mostrar la vista de éxito
				$datos = array();
				$datos['usuario'] = Login::getUsuario();
				$datos['mensaje'] = 'Eliminado OK';
				$this->load_view('view/exito.php', $datos);
			}
		}
		
		//PROCEDIMIENTO PARA VER LOS DETALLES DE UN USUARIO
		public function ver($user=''){
		    //comprobar que llega la ID
		    if(!$user)
		        throw new Exception('No se ha indicado el User del usuario');
		        
		        //recuperar la receta con la ID seleccionada
		        $this->load('model/UsuarioModel.php');
		        $usuarioM = UsuarioModel::getUsuario($user);
		        
		        //comprobar que la receta existe
		        if(!$usuarioM)
		            throw new Exception('No existe el usuario con el User '.$user);
		            
		            //cargar la vista de detalles
		            $datos = array();
		            $datos['usuario'] = Login::getUsuario();
		            $datos['usuarioM'] = $usuarioM;
		            $this->load_view('view/usuarios/detalles.php', $datos);
		}
		
	}
?>