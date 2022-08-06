<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

$xml = ControladorPrestamos::ctrDescargarXML();

if($xml){

  rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");

  echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="prestamos">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';

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

                if(isset($_GET["fechaInicial"])){

                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                
                }else{
                 
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

        <?php if (sizeof($prestamos)>0) :?>
          <?php foreach ($prestamos as $key =>  $prestamo) :?>
            <tr>
              <td><?= $key+1 ?></td>
              <td><?= $prestamo['id'] ?></td>
              <td><?= $prestamo['instructor'] ?></td>
              <td><?= $prestamo['funcionario'] ?></td>
              <td><?= $prestamo['producto'] ?></td>
              <td><?= $prestamo['cantidad'] ?></td>
              <td><?= $prestamo['tipo_prestamo'] ?></td>
              <td><?= $prestamo['fecha'] ?></td>
              <td><?= $prestamo['fecha_devolucion'] ?></td>
              <td>

              <div class="btn-group">

                <button class="btn btn-success btnImprimirTicket" codigoPrestamo="<?= $prestamo['id'] ?>">

                  <i class="fa fa-print">Ticket</i>

                </button>
                        
                  <button class="btn btn-info btnImprimirFactura" codigoPrestamo="<?= $prestamo['id'] ?>">

                    <i class="fa fa-print"></i>PDF

                  </button>

                     <?php  if($_SESSION["perfil"] == "Administrador"): ?>

                      <button class="btn btn-warning btnEditarPrestamo" idPrestamo="<?= $prestamo['id'] ?>"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger btnEliminarPrestamo" idPrestamo="<?= $prestamo['id'] ?>"><i class="fa fa-times"></i></button>

                    <?php endif;?>

                </div> 

              </td>
            </tr>
          <?php endforeach;?>
        <?php else:?>
          <tr>
            <td colspan="9">No se tienen prestamos registrados</td>
          </tr>
        <?php endif;?>
        
               
        </tbody>

       </table>

       <?php

      $eliminarPrestamo = new ControladorPrestamos();
      $eliminarPrestamo -> ctrEliminarPrestamo();

      ?>
       

      </div>

    </div>

  </section>

</div>




