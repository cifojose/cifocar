<?php
require_once '../../../config/Config.php';
require_once '../../../libraries/database_library.php';
require_once '../../../model/MarcaModel.php';

$marca= new MarcaModel();
$marca->marca="Seat";
$marca->nueva();
echo "se carga?";