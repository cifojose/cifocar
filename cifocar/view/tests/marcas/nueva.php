<?php
require_once '../../../config/Config.php';
require_once '../../../libraries/database_library.php';
require_once '../../../model/MarcaModel.php';

MarcaModel::nueva('Ford');
echo "se carga?";