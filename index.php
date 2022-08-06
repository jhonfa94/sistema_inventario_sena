<?php
# OCULTAMOS LOS ERRORES 
// error_reporting(0);

require_once __DIR__.'/config.php';



$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();