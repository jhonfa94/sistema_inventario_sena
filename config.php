<?php
# CARGAMOS LAS DEPENDENCIAS DE PHP
require_once __DIR__ . '/vendor/autoload.php';

# IMPLEMENTAMOS EL PAQUETE DE VARIALES DE ENTORNO PARA EL PROYECTO
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

# ZONA HORARIA
date_default_timezone_set('America/Bogota');

/* ===================== 
  IGNORAMOS LOS ERRORES PARA EL AMBIENTE PRODUCTIVO
========================= */
if ($_ENV['APP_ENV'] == 'produccion') {
  error_reporting(0);
}

/* ===================== 
  VARIABLES GLOBALES 
========================= */
define('URL', $_ENV['APP_URL']);
define('URL_INVENTARIO', $_ENV['APP_URL']);
define('DIR_PROYECT', $_ENV['APP_DIR_INVENTARIO']);
define('HASH_PASSWORD', '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

/* ===================== 
  CONFIUGRACION DE SESIONES DEL PROYECTO 
========================= */
# NOMBRE DE LA SESION
session_name('INVENTARIO_SENA');
$duracion_sesion = 172800; // 28800 7200 => 2 HORAS TRANSFORMADAS EN SEGUNDOS
ini_set("session.use_cookies", 1);
ini_set("session.use_only_cookies", 1);
ini_set("session.cookie_lifetime", $duracion_sesion);
ini_set('session.gc_maxlifetime', $duracion_sesion);
session_cache_expire($duracion_sesion);
session_set_cookie_params($duracion_sesion);

# ruta de la sesion 
if (!is_dir(DIR_PROYECT . '/sessions')) {
  mkdir(DIR_PROYECT . '/sessions', 0777);
}

session_save_path(DIR_PROYECT . '/sessions');

session_start();

/**
 * FUNCION PARA VALIDAR SI EL USUARIO TIENE ACTIVA  LA SESIÓN EN EL SIO
 * @return void
 */
function validarSesion()
{
  if (!isset($_SESSION['id_usuario'])) {
    $url = URL;
    if (!strpos($_SERVER['REQUEST_URI'], 'ingreso')) {
      header("Location: {$url}/ingreso");
    }
  }
}

validarSesion();




# CONTROLADORES
require_once "controladores/HelperController.php";
require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/instructores.controlador.php";
require_once "controladores/prestamos.controlador.php";
require_once "controladores/movimiento.controlador.php";

# MODELOS
require_once "modelos/conexion.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/instructores.modelo.php";
require_once "modelos/prestamos.modelo.php";
require_once "modelos/movimiento.modelo.php";


// phpinfo();
// var_dump($_SERVER);
