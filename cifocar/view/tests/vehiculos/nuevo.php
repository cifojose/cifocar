<?php
require_once '../../../config/Config.php';
require_once '../../../libraries/database_library.php';
require_once '../../../model/VehiculoModel.php';


$vehiculo=new VehiculoModel();
$vehiculo->matricula='9101ABC';
$vehiculo->modelo='Corsa';
$vehiculo->color='Negro metalizado';
$vehiculo->precio_venta=10750;
$vehiculo->precio_compra=4700;
$vehiculo->kms=124950;
$vehiculo->caballos=90;
$vehiculo->estado=2;
$vehiculo->any_matriculacion=2008;
$vehiculo->detalles='Presenta algunos desperfectos lateral derecho, varios propietarios';
$vehiculo->imagen='aqui la ruta de la imagen';
$vehiculo->marca='Opel';
var_dump($vehiculo);
$vehiculo->nuevo();
echo "se carga?";