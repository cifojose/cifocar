<?php
require_once '../../../config/Config.php';
require_once '../../../libraries/database_library.php';
require_once '../../../model/VehiculoModel.php';


var_dump(VehiculoModel::getVehiculos());
echo "se carga?";