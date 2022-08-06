<?php

if ($_SESSION["perfil"] == "Especial") {

  echo '<script>

    window.location = "inicio";

  </script>';

  return;
}

$xml = ControladorPrestamos::ctrDescargarXML();

if ($xml) {

  rename($_GET["xml"] . ".xml", "xml/" . $_GET["xml"] . ".xml");

  echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/' . $_GET["xml"] . '.xml" href="prestamos">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';
}

# LISTAR PRESTAMOS
$prestamos = ControladorPrestamos::ctrListarPrestamos();

?>
<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar Prestamos

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar Prestamos</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <a href="crear-prestamo">

          <button class="btn btn-primary">

            Agregar Prestamo

          </button>

        </a>

        <button type="button" class="btn btn-default pull-right" id="daterange-btn">

          <span>
            <i class="fa fa-calendar"></i>

            <?php

            if (isset($_GET["fechaInicial"])) {

              echo $_GET["fechaInicial"] . " - " . $_GET["fechaFinal"];
            } else {

              echo 'Rango de fecha';
            }

            ?>
          </span>

          <i class="fa fa-caret-down"></i>

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

          <thead>

            <tr>

              <th style="width:10px">#</th>
              <th>Código Prestamo</th>
              <th>Ficha</th>
              <th>Instructor</th>
              <th>Funcionario</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Tipo Prestamo</th>
              <th>Fecha</th>
              <th>Fecha Devolucion</th>
              <th>Acciones</th>

            </tr>

          </thead>

          <tbody>

            <?php if (sizeof($prestamos) > 0) : ?>
              <?php foreach ($prestamos as $key =>  $prestamo) : ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td><?= $prestamo['id'] ?></td>
                  <td><?= $prestamo['ficha'] ?></td>
                  <td><?= $prestamo['instructor'] ?></td>
                  <td><?= $prestamo['funcionario'] ?></td>
                  <td><?= $prestamo['producto'] ?></td>
                  <td><?= $prestamo['cantidad'] ?></td>
                  <td><?= $prestamo['tipo_prestamo'] ?></td>
                  <td><?= $prestamo['fecha'] ?></td>
                  <td><?= $prestamo['fecha_devolucion'] ?></td>
                  <td>

                    <div class="btn-group">

                      <button class="btn btn-info btnModalInfo" data-toggle="modal" data-target="#modalInfoPrenstamo" data-dismiss="modal" idprestamo="<?= $prestamo['id'] ?>" ">
                        <i class=" fa fa-info"></i> Info
                      </button>

                      <?php if ($prestamo['tipo_prestamo'] == 'Devolutivo' && $prestamo['fecha_devolucion'] == NULL) : ?>

                        <button class="btn btn-success btnModalDevolucion" data-toggle="modal" data-target="#modalDevolucionPrestamo" data-dismiss="modal" idprestamo="<?= $prestamo['id'] ?>" instructor="<?= $prestamo['instructor'] ?>" producto="<?= $prestamo['producto'] ?>" cantidad="<?= $prestamo['cantidad'] ?>" idProducto=<?= $prestamo['producto_id'] ?> stock="<?= $prestamo['stock'] ?>">
                          <i class="fa fa-user"></i> Devolución
                        </button>

                      <?php endif; ?>



                      <?php if ($_SESSION["perfil"] == "Administrador") : ?>

                        <!-- <button class="btn btn-warning btnEditarPrestamo" idPrestamo="<?= $prestamo['id'] ?>"><i class="fa fa-pencil"></i></button>

                        <button class="btn btn-danger btnEliminarPrestamo" idPrestamo="<?= $prestamo['id'] ?>"><i class="fa fa-times"></i></button> -->

                      <?php endif; ?>

                    </div>

                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="9">No se tienen prestamos registrados</td>
              </tr>
            <?php endif; ?>


          </tbody>

        </table>

        <?php

        $eliminarPrestamo = new ControladorPrestamos();
        $eliminarPrestamo->ctrEliminarPrestamo();

        ?>


      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL Agregar Instructor
======================================-->

<div id="modalDevolucionPrestamo" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">
        <input type="hidden" name="idPrestamo" id="idPrestamo">
        <input type="hidden" name="idProducto" id="idProducto">
        <input type="hidden" name="stock" id="stock">
        <input type="hidden" name="devolucionPrestamo" id="devolucionPrestamo" value="ok">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" id="titleModalDevolucion">Devolucion</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg" id="nombreInstructor" name="nombreInstructor" placeholder="Ingresar nombre" readonly>

              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-calculator"></i></span>

                <input type="number" min="0" class="form-control input-lg" id="cantidadDevolucion" name="cantidadDevolucion" readonly>

              </div>

            </div>



            <!-- FECHA DEVOLUCIÓN -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                <input type="date" class="form-control input-lg" id="fechaDevolucion" name="fechaDevolucion" max="<?= date('Y-m-d') ?>" required>

              </div>

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Devolución</button>

        </div>

        <?php
        ControladorPrestamos::ctrDevolverPrestamo();
        ?>

      </form>



    </div>

  </div>

</div>

<!-- ===================== 
  MODAL DETALLE DE LA INFORMACION QUE SE TIENE 
========================= -->
<div id="modalInfoPrenstamo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="titleModalInfoPrestamo">Info Prestamo</h4>
      </div>

      <div class="modal-body">
        <div class="box-body">


          <div id="bodyModalDetallePrestamo">
            <table class="table table-sm table-bordered table-hover" style="width:100%;">
              <thead class="thead-light">
                <tr>
                  <th>Tipo Prestamo</th>
                  <th>Fecha</th>
                  <th>Fecha Devolución</th>
                  <th>Ficha</th>
                  <th>Producto</th>
                  <th>Categoría</th>
                  <th>Cantidad</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>

          

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
      </div>

    </div>

  </div>

</div>