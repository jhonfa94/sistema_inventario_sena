<?php

if ($_SESSION["perfil"] == "Especial") {

  echo '<script>

    window.location = "inicio";

  </script>';

  return;
}

?>

<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Crear Prestamo

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Crear Prestamo</li>

    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->

      <div class="col-lg-5 col-xs-12">

        <div class="box box-success">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioPrestamo">
            <input type="hidden" name="guardarPrestamo" value="ok">

            <div class="box-body">

              <div class="box">

                <!--=====================================
                ENTRADA DEL FUNCIONARIO
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control" id="nuevoFuncionario" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idFuncionario" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div>

                <!-- ===================== 
                  METODO DE PRESTAMOS 
                ========================= --> 
                <div class="form-group row">

                  <div class="col-xs-12" style="padding-right:0px">

                    <div class="input-group">

                      <select class="form-control" id="nuevoTipoPrestamo" name="nuevoTipoPrestamo" required>
                        <option value="">Seleccione método de prestamos</option>
                        <option value="Devolutivo">Devolutivo</option>
                        <option value="Consumible">Consumible</option>
                      </select>

                    </div>

                  </div>
                </div>

                <!--=====================================
                ENTRADA DEL INSTRUCTOR
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-users"></i></span>

                    <select class="form-control" id="seleccionarInstructor" name="seleccionarInstructor" required>

                      <option value="">Seleccionar Instructor</option>

                      <?php

                      $item = null;
                      $valor = null;

                      $instructores = ControladorInstructores::ctrMostrarInstructores($item, $valor);

                      foreach ($instructores as $key => $value) {

                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
                      }

                      ?>

                    </select>

                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarInstructor" data-dismiss="modal">Agregar Instructor</button></span>

                  </div>

                </div><!-- SELECT INSTRUCTOR -->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-edit"></i></span>

                    <input class="form-control" type="text" name="ficha" id="ficha" placeholder="Número de la ficha" required>

                  </div>

                </div><!-- FICHA -->


                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================-->
                <input type="hidden" id="idProducto" name="idProducto">

                <div class="text-center">
                  <p>Artículos de préstamos</p>
                </div>

                <div class="form-group row nuevoProducto">

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                  <!--=====================================
                  FECHA PARA LA DEVOLUCION
                  ======================================-->
                  <!-- <div class="form-group mt-2" id="divInputFechaDevolucion" style="display: none;">
                
                    <label for="nuevaFechaDevolucion">Fecha de devolución</label>
                    <div class="input-group">

                    
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                      <input type="date" class="form-control input-lg" id="nuevaFechaDevolucion" name="nuevaFechaDevolucion" placeholder="Ingresar fecha Devoluciòn">

                    </div>

                  </div> -->
                <br>
                <div class="form-group">
                  <label for="observaciones">Observaciones</label>
                  <textarea id="observaciones" class="form-control" name="observaciones" rows="2" placeholder="Observaciones generales del prestamo"></textarea>
                </div>

              </div><!-- div box -->

            </div>

            <div class="box-footer">

              <button type="submit" id="guardarPrestamo" class="btn btn-primary pull-right">Guardar Prestamo</button>

              <?php

              $guardarPrestamo = ControladorPrestamos::ctrCrearprestamo();


              ?>


            </div>

          </form>


        </div>

      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">

        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">

            <table class="table table-bordered table-striped dt-responsive tablaPrestamos">

              <thead>

                <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripcion</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                </tr>

              </thead>

            </table>

          </div>

        </div>


      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL Agregar Instructor
======================================-->

<div id="modalAgregarInstructor" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Instructor</h4>

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

                <input type="text" class="form-control input-lg" name="nuevoInstructor" placeholder="Ingresar nombre" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="number" min="0" class="form-control input-lg" name="nuevoDocumentoId" placeholder="Ingresar documento" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL EMAIL -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha nacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

              </div>

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Instructor</button>

        </div>

      </form>

      <?php

      $crearInstructor = new ControladorInstructores();
      $crearInstructor->ctrCrearInstructor();

      ?>

    </div>

  </div>

</div>