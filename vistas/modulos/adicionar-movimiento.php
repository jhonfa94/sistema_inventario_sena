<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

$productos = ControladorProductos::ctrMostrarProductos(NULL, NULL, 'stock');

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Adicionar Movimiento
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Adicionar Movimiento</li>
    
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

          <form role="form" method="post" class="formularioMovimiento">

            <div class="box-body">
  
              <div class="box">

                <!--=====================================
                ENTRADA DEL FUNCIONARIO
               
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoFuncionario" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idFuncionario" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div>
                 ======================================--> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <?php

                    $item = null;
                    $valor = null;

                    $prestamos = ControladorPrestamos::ctrMostrarPrestamos($item, $valor);

                    if(!$prestamos){

                      echo '<input type="text" class="form-control" id="nuevaPrestamo" name="nuevaPrestamo" value="10001" readonly>';
                  

                    }else{

                      foreach ($prestamos as $key => $value) {
                        
                        
                      
                      }

                      $codigo = $value["codigo"] + 1;



                      echo '<input type="text" class="form-control" id="nuevaPrestamo" name="nuevaPrestamo" value="'.$codigo.'" readonly>';
                  

                    }

                    ?>
                    
                    
                  </div>
                
                </div>
                ======================================--> 
                <!--=====================================
                ENTRADA DEL Producto
                ======================================--> 
                
                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    
                    <select class="form-control" id="seleccionarArticulo" name="seleccionarArticulo" required>

                    <option value="">Seleccionar Articulo</option>

                    <?php
                    
                      $item = null;
                      $valor = null;
                      

                      $categorias = ControladorMovimiento::ctrMostrarProductos($item, $valor);
                      

                       foreach ($categorias as $key => $value) {

                         echo '<option value="'.$value["id"].'">'.$value["descripcion"].'</option>';

                       }

                    ?>

                    </select>
                     <!--=====================================
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarInstructor" data-dismiss="modal">Agregar producto</button></span>
                   ======================================-->
                  </div>
                
                </div>
                <!--=====================================
                ENTRADA TIPO MOVIMIENTO
                ======================================-->

                <div class="form-group row">                  
                  
                  <div class="col-xs-6" style="padding-right:0px">
                    
                     <div class="input-group">
                  
                      <select class="form-control" id="nuevoTipoMovimiento" name="nuevoTipoMovimiento" required>
                        <option value="">Seleccione el tipo de movimiento</option>
                        <option value="1">Entrada</option>
                        <option value="2">Salida</option>
                        </select>    

                    </div>

                  </div>

              
                <!--=====================================
                ENTRADA PARA EL VALOR DEL MOVIMIENTO
                ======================================--> 
                 
                       
            
             
                
              
                 <div class="input-group">
              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  
                  <input type=""number" class="form-control" name="nuevaCantidad" placeholder="Ingresar la cantidad" required>

                </div>
                
                <!--=====================================
                ENTRADA PARA LA OBSERVACION
                ======================================--> 
                 
                       
            
               
              
                <div class="input-group">
              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                  <input type="text" class="form-control " name="nuevaObservacion" placeholder="Ingresar la observación">

                </div>
               

              
  
          

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <hr>

                <div class="row">

                 
                </div>

                <hr>

                

                  <div class="cajasMetodoPago"></div>

                 

                </div>

                <br>
      
              </div>

          </div>

          <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right">Guardar Movimiento</button>

          </div>

        </form>

        <?php
          
          ControladorMovimiento::ctrAdicionarMovimiento();
          
        ?>

        </div>
            
      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        
        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">
            
            <table class="table table-bordered table-striped dt-responsive tablaPrestamos tablas">
              
               <thead>

                 <tr>
                  <th style="width: 10px">#</th>                  
                  <th>Código</th>
                  <th>Descripcion</th>
                  <th>Stock</th>                  
                </tr>

              </thead>

              <tbody>
                <?php  if(sizeof($productos)>0) :?>
                  <?php 
                    foreach ($productos as  $producto): 
                  ?> 
                    <tr>
                      <td><?=$producto['id']?></td>
                      <td><?=$producto['codigo']?></td>
                      <td><?=$producto['descripcion']?></td>
                      <td><?=$producto['stock']?></td>
                    </tr>
                  <?php endforeach; ?>


                <?php endif; ?>
              </tbody>

            </table>

          </div>

        </div>


      </div>

    </div>
   
  </section>

</div>

<!--=====================================
MODAL Agregar Instructor


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
        $crearInstructor -> ctrCrearInstructor();

      ?>

    </div>

  </div>

</div>
