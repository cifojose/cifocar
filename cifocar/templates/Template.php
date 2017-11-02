<?php
	class Template{	
		
		//PONE EL HEADER DE LA PAGINA
		public static function header(){	?>
			<header>
				<figure class="imagenLogo">
    				<img src="images/logos/logo.png" />
    			</figure>
				<hgroup>
					<h1>Cifocar v 1.1</h1>
					<h2>Practica para la gestión de un concesionario de compra y venta de vehículos</h2>
				</hgroup>
			</header>
		<?php }
		
		
		//PONE EL FORMULARIO DE LOGIN
		public static function login(){?>
			<form method="post" id="login" autocomplete="off">
				<input type="text" placeholder="usuario" name="user" required="required" />
				<input type="password" placeholder="clave" name="password" required="required"/>
				<input class="boton" type="submit" name="login" value="Login" />
			</form>
		<?php }
		
		
		//PONE LA INFO DEL USUARIO IDENTIFICADO Y EL FORMULARIOD E LOGOUT
		public static function logout($usuario){	?>
			<div id="logout">
				<span>
					Hola 
					<a href="index.php?controlador=Usuario&operacion=modificacion" title="modificar mis datos">
						<?php echo $usuario->nombre;?>
					</a>
						<?php if($usuario->privilegio==0) echo ', usuario administrador del sistema';?>
						<?php if($usuario->privilegio==1) echo ', usuario del Dpto. de Compras';?>
						<?php if($usuario->privilegio==2) echo ', usuario del Dpto. de Ventas';?>
				</span>
								
				<form method="post">
					<input class="boton" type="submit" name="logout" value="Logout" />
				</form>
			</div>
		<?php }
		
		
		//PONE EL MENU DE LA PAGINA
		public static function menu($usuario){ ?>
			<nav>
				<?php if($usuario && $usuario->privilegio==1){ //poner el menu del responsable de compras?>
				<ul class="menu">
					<li><a href="index.php?controlador=Vehiculo&operacion=listar">Listar vehiculos</a></li>
					<li><a href="index.php?controlador=Vehiculo&operacion=nuevo">Nuevo vehículo</a></li>
					<li><a href="index.php?controlador=Marca&operacion=listar">Listar marcas</a></li>
					<li><a href="index.php?controlador=Marca&operacion=nueva">Nueva marca</a></li>
				</ul>
				<?php }?>
				
				<?php if($usuario && $usuario->privilegio==2){ //poner el menu del vendedor?>
				<ul class="menu">
					<li><a href="index.php?controlador=Vehiculo&operacion=listar">Listar vehiculos</a></li>
				</ul>
				<?php }?>
				
				<?php if($usuario && $usuario->admin){	//pone el menú del administrador?>
				<ul class="menu">
					<li><a href="index.php?controlador=Usuario&operacion=listar">Listar usuarios</a></li>
					<li><a href="index.php?controlador=Usuario&operacion=registro">Nuevo usuario</a></li>
					<li><a href="index.php?controlador=Vehiculo&operacion=listar">Listar vehiculos</a></li>
				</ul>
				<?php }	?>
				
				<?php if($usuario){ //en todos los usuarios registrados ?>
				<ul class="menu">
					<li><a href="index.php?controlador=Usuario&operacion=modificacion">Modificar mis datos</a></li>
				</ul>
				
				<?php }	?>
			</nav>
				
		<?php }
		
		//PONE EL PIE DE PAGINA
		public static function footer(){	?>
			<footer>
				<p>(c)2017 Web programada por: Jose Montes & Juan Javier Ligero Rambla</p>
			</footer>
		<?php }
	}
?>