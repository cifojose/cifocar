<?php
require_once '../../../config/Config.php';
require_once '../../../libraries/database_library.php';
require_once '../../../model/VehiculoModel.php';


VehiculoModel::borrar(7);
echo "se carga?";