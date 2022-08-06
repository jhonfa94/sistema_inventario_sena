<?php 
include '../../config.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class ReportePrestamo
{
    public static function generarExcel($fecha1, $fecha2)
    {
        # SOLICITO LA RESPUESTA AL MODELO DE LA PETCIÓN QUE SE MANDA POR EL CONTROLADOR
        $fecha1 = strlen($fecha1) > 0 ? $fecha1 : date('Y-m-') . '01';
        $fecha2 = strlen($fecha2) > 0 ? $fecha2 : date('Y-m-d');
        $respuesta = ModeloPrestamos::reportePrestamoGeneral($fecha1, $fecha2);

        // var_dump($respuesta);       


        $documento = new Spreadsheet();
        $documento
            ->getProperties()
            ->setCreator("JFCM")
            ->setLastModifiedBy('JFCM') // última vez modificado por
            ->setTitle('INVENTARIO')
            ->setSubject('Reporte ')
            ->setDescription('SIO ')
            ->setKeywords('ac coytex CRM EXCEL SIO php')
            ->setCategory('SIO');

        $documento->getActiveSheet()->setTitle('PRESTAMOS'); // NOMBRE A LA HOJA
        $rangoColumnas = 'A1:J1';
        $documento->getActiveSheet()->getStyle($rangoColumnas)->getFont()->setBold(true)->setSize(16); # LA PRIMERA FILA EN NEGRITA

        //APLICAMOS AUTOFILTER
        $documento->getActiveSheet()->setAutoFilter($rangoColumnas);
        $sheet = $documento->getActiveSheet();

        $sheet->setTitle("PRESTAMOS");



        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->setCellValue('A1', '# PRESTAMO');

        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->setCellValue('B1', 'INSTRUCTOR');

        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->setCellValue('C1', 'USUARIO');

        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->setCellValue('D1', 'TIPO PRESTAMO');

        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->setCellValue('E1', 'FECHA REGISTRO');

        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->setCellValue('F1', 'FECHA DEVOLUCIÓN');

        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->setCellValue('G1', 'FICHA');

        $sheet->getColumnDimension('H')->setWidth(40);
        $sheet->setCellValue('H1', 'PRODUCTO');

        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->setCellValue('I1', 'CATEGORIA');

        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->setCellValue('J1', 'OBSERVACIONES');




        $fila = 2; //fila en donde se incia a mostrar los datos en excel
        if (sizeof($respuesta) > 0) {
            foreach ($respuesta as $key => $value) {
                $sheet->setCellValue('A' . $fila, $value['prestamo_id']);
                $sheet->setCellValue('B' . $fila, $value['instructor']);
                $sheet->setCellValue('C' . $fila, $value['usuario']);
                $sheet->setCellValue('D' . $fila, $value['tipo_prestamo']);
                $sheet->setCellValue('E' . $fila, $value['fecha']);
                $sheet->setCellValue('F' . $fila, $value['fecha_devolucion']);
                $sheet->setCellValue('G' . $fila, $value['ficha']);
                $sheet->setCellValue('H' . $fila, $value['producto']);
                $sheet->setCellValue('I' . $fila, $value['categoria']);
                $sheet->setCellValue('J' . $fila, $value['observaciones']);
                $fila++;
            }
        } else {
            $sheet->setCellValue('A' . $fila, 'SIN INFORMACIÓN');
            $sheet->setCellValue('B' . $fila, 'SIN INFORMACIÓN');
            $sheet->setCellValue('C' . $fila, 'SIN INFORMACIÓN');
            $sheet->setCellValue('D' . $fila, 'SIN INFORMACIÓN');
            $sheet->setCellValue('E' . $fila, 'SIN INFORMACIÓN');
            $sheet->setCellValue('F' . $fila, 'SIN INFORMACIÓN');
            $sheet->setCellValue('G' . $fila, 'SIN INFORMACIÓN');
            $sheet->setCellValue('H' . $fila, 'SIN INFORMACIÓN');
            $sheet->setCellValue('I' . $fila, 'SIN INFORMACIÓN');
            $sheet->setCellValue('J' . $fila, 'SIN INFORMACIÓN');
        }



        $nombre_reporte = "REPORTE_PRESTAMOS_" . date('Y-m-d g:i A') . ".xlsx";
        /*
            * Los siguientes encabezados son necesarios para que
            * el navegador entienda que no le estamos mandando
            * simple HTML
            * Por cierto: no hagas ningún echo ni cosas de esas; es decir, no imprimas nada
        */
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_reporte . '"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}

if (isset($_REQUEST['reportePrestamos']) && $_REQUEST['reportePrestamos'] == 'ok') {
     ReportePrestamo::generarExcel($_REQUEST['fechaInicial'], $_REQUEST['fechaFinal']);
}
