<?php

require_once "../../controladores/prestamos.controlador.php";
require_once "../../modelos/prestamos.modelo.php";
require_once "../../controladores/instructores.controlador.php";
require_once "../../modelos/instructores.modelo.php";
require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";

$reporte = new ControladorPrestamos();
$reporte -> ctrDescargarReporte();