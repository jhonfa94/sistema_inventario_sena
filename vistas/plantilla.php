<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?= $_ENV['APP_NAME'] ?></title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="<?= $_ENV['APP_URL'] ?>/vistas/img/plantilla/icono-negro.ico">

  <!--=====================================
  PLUGINS DE CSS
  ======================================-->

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/dist/css/AdminLTE.css">

  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/dist/css/estilob.css?v=<?= time(); ?>">

  <!-- Google Font -->
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/dist/css/google_font.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/plugins/iCheck/all.css">

  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <!-- Morris chart -->
  <link rel="stylesheet" href="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/morris.js/morris.css">

  <!--=====================================
  PLUGINS DE JAVASCRIPT
  ======================================-->

  <!-- jQuery 3 -->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Bootstrap 3.3.7 -->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- FastClick -->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/fastclick/lib/fastclick.js"></script>

  <!-- AdminLTE App -->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/dist/js/adminlte.min.js"></script>

  <!-- DataTables -->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>

  <!-- SweetAlert 2 -->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
  <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

  <!-- iCheck 1.0.1 -->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/plugins/iCheck/icheck.min.js"></script>

  <!-- InputMask -->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>

  <!-- jQuery Number -->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>

  <!-- daterangepicker http://www.daterangepicker.com/-->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/morris.js/morris.min.js"></script>

  <!-- ChartJS http://www.chartjs.org/-->
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/bower_components/Chart.js/Chart.min.js"></script>




</head>

<!--=====================================
CUERPO DOCUMENTO
======================================-->

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">

  <?php

  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

    echo '<div class="wrapper">';

    /*=============================================
    CABEZOTE
    =============================================*/

    include "includes/cabezote.php";

    /*=============================================
    MENU
    =============================================*/

    include "includes/menu.php";

    /*=============================================
    CONTENIDO
    =============================================*/

    if (isset($_GET["ruta"])) {

      if (
        $_GET["ruta"] == "inicio" ||
        $_GET["ruta"] == "usuarios" ||
        $_GET["ruta"] == "categorias" ||
        $_GET["ruta"] == "productos" ||
        $_GET["ruta"] == "instructores" ||
        $_GET["ruta"] == "prestamos" ||
        $_GET["ruta"] == "prestamo-devolucion" ||
        $_GET["ruta"] == "crear-prestamo" ||
        $_GET["ruta"] == "editar-prestamo" ||
        //movimiento
        $_GET["ruta"] == "movimiento" ||
        $_GET["ruta"] == "adicionar-movimiento" ||
        //movimiento
        $_GET["ruta"] == "reportes" ||
        $_GET["ruta"] == "salir"
      ) {

        include "modulos/" . $_GET["ruta"] . ".php";
      } else {

        include "includes/404.php";
      }
    } else {

      include "modulos/inicio.php";
    }

    /*=============================================
    FOOTER
    =============================================*/

    include "includes/footer.php";

    echo '</div>';
  } else {

    include "modulos/login.php";
  }

  ?>


  <script src="<?= $_ENV['APP_URL'] ?>/vistas/js/plantilla.js?v=<?= time(); ?>"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/js/usuarios.js?v=<?= time(); ?>"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/js/categorias.js?v=<?= time(); ?>"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/js/productos.js?v=<?= time(); ?>"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/js/instructores.js?v=<?= time(); ?>"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/js/prestamos.js?v=<?= time(); ?>"></script>
  <script src="<?= $_ENV['APP_URL'] ?>/vistas/js/reportes.js?v=<?= time(); ?>"></script>

</body>

</html>