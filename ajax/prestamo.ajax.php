<?php
require '../config.php';

class PrestamoAjax
{
    /**
     * detalle del prestamo
     *
     * @param integer $idPrestamo
     * @return void
     */
    public static function ajaxDetallePrestamo(int $idPrestamo)
    {
        $datos = ModeloPrestamos::detallePrestamo($idPrestamo);
        $htmlTable = "
            <table class='table table-sm table-bordered table-hover' style='width:100%;'>
              <thead class='thead-light'>
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
        ";

        foreach ($datos as $dato) {
            $htmlTable .="
                <tr>
                    <td>{$dato['tipo_prestamo']}</td>
                    <td>{$dato['fecha']}</td>
                    <td>{$dato['fecha_devolucion']}</td>
                    <td>{$dato['ficha']}</td>
                    <td>{$dato['descripcion']}</td>
                    <td>{$dato['categoria']}</td>
                    <td>{$dato['cantidad']}</td>
                </tr>
            ";
        }
        // var_dump($datos);
        $htmlTable .="</tbody>
            </table>
        ";
        $observaciones = strlen($datos[0]['observaciones']) > 0 ? $datos[0]['observaciones'] : 'No se registra observaciones del prestamo';
        $htmlTable .="
            <div>
                <b>Observaciones: </b> $observaciones
            </div>
        ";

        echo $htmlTable;
    }
}

if (isset($_REQUEST['detallePrestamo']) && $_REQUEST['detallePrestamo'] == 'ok') {
     PrestamoAjax::ajaxDetallePrestamo($_REQUEST['idprestamo']);
}
