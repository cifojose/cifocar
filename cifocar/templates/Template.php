<?php
	class Template{	
		
		//PONE EL HEADER DE LA PAGINA
		public static function header(){	?>
			<header>
				<figure>
					<a href="index.php">
						<img alt="Robs Micro Framework logo" src="images/logos/logo.png" />
					</a>
				</figure>
				<hgroup>
					<h1>Cifocar v 0.1</h1>
					<h2>Gestión de un concesionario de compra y venta de coches</h2>
				</hgroup>
			</header>
		<?php }
		
		
		//PONE EL FORMULARIO DE LOGIN
		public static function login(){?>
			<form method="post" id="login" autocomplete="off">
				<input type="text" placeholder="usuario" name="user" required="required" />
				<input type="password" placeholder="clave" name="password" required="required"/>
				<input type="submit" name="login" value="Login" />
			</form>
		<?php }
		
		
		//PONE LA INFO DEL USUARIO IDENTIFICADO Y EL FORMULARIOD E LOGOUT
		public static function logout($usuario){	?>
			<div id="logout">
				<span>
					Hola 
					<a href="index.php?controlador=Usuario&operacion=modificacion" title="modificar datos">
						<?php echo $usuario->nombre;?>
					</a><?php if($usuario->admin) echo ', eres administrador';?>
				</span>
								
				<form method="post">
					<input type="submit" name="logout" value="Logout" />
				</form>
			</div>
		<?php }
		
		
		//PONE EL MENU DE LA PAGINA
		public static function menu($usuario){ ?>
			<nav>
				<?php if($usuario && $usuario->privilegio==1){ //poner el menu del responsable de compras?>
				<ul class="menu">
					<li><a href="index.php?controlador=Vehiculos&operacion=listar">Listar vehiculos</a></li>
					<li><a href="index.php?controlador=Vehiculos&operacion=nueva">Nuevo vehículo</a></li>
					<li><a href="index.php?controlador=Vehiculos&operacion=modificarEstado">Modificar estado del vehículo</a></li>
					<li><a href="index.php?controlador=Vehiculos&operacion=ver">Detalles del vehículo</a></li>
				</ul>
				<?php }?>
				
				<?php if($usuario && $usuario->privilegio==2){ //poner el menu del vendedor?>
				<ul class="menu">
					<li><a href="index.php?controlador=Vehiculos&operacion=listar">Listar vehiculos</a></li>
					<li><a href="index.php?controlador=Vehiculos&operacion=modificarEstado">Modificar estado del vehículo</a></li>
					<li><a href="index.php?controlador=Vehiculos&operacion=ver">Detalles del vehículo</a></li>
				</ul>
				<?php }?>
				
				<?php if($usuario && $usuario->admin){	//pone el menú del administrador?>
				<ul class="menu">
					<li><a href="index.php?controlador=Usuario&operacion=registro">Nuevo usuario</a></li>
					<li><a href="index.php?controlador=Usuario&operacion=listar">Listar usuarios</a></li>
				</ul>
				<?php }	?>
			</nav>
		<?php }
		
		//PONE EL PIE DE PAGINA
		public static function footer(){	?>
			<footer>
				<p>
					<a href="http://recursos.robertsallent.com/mvc/robs_micro_fw_1.0.zip">
						RobS micro Framework</a> - solo para fines docentes
				</p>
				<p> 
					<a rel="author" href="http://www.robertsallent.com">Robert Sallent</a>
					<a href="http://www.twitter.com/robertsallent">
         				<img class="logo" alt="twitter logo" src="images/logos/twitter.png" />
					</a> -  
					<a href="https://www.facebook.com/cifovalles">CIFO del Vallès'16</a>. 
         		</p>
			</footer>
		<?php }
	}
?>