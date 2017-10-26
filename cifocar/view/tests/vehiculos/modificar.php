<?php
require_once '../../../config/Config.php';
require_once '../../../libraries/database_library.php';
require_once '../../../model/VehiculoModel.php';


$vehiculo=VehiculoModel::getVehiculo(2);
var_dump($vehiculo);
echo "  ";
$vehiculo->id=intval($vehiculo->id);
$vehiculo->matricula="5679aBC";
$vehiculo->modelo='Corsario';
$vehiculo->color='Amarillo fuego metalizado';
$vehiculo->precio_venta=8750;
$vehiculo->precio_compra=2970;
$vehiculo->kms=204500;
$vehiculo->caballos=87;
$vehiculo->estado=2;
$vehiculo->any_matriculacion=2008;
$vehiculo->detalles='Presenta algunos desperfectos lateral derecho, varios propietarios';
$vehiculo->imagen='aqui la ruta de la imagen';
$vehiculo->marca='Renault';
//var_dump($vehiculo);
$va=$vehiculo->modificar();
var_dump($va);
echo " se carga?";
