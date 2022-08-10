<?php
include '../../config.php';
// $file =  __DIR__ . '/../../../inventario_sena/vistas/img/plantilla/logo.jpg';
// var_dump(is_file($file));
// die();
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {
        // Logo
        // $image_file = K_PATH_IMAGES . 'logo_example.jpg';
        $image_file =  __DIR__ . '/../../../inventario_sena/vistas/img/plantilla/logo.png';
        // $image_file = LOGO;
        // $image_file = "http://localhost/inventario_sena/vistas/img/plantilla/logo.jpg";
        $this->Image($image_file, 10, 10, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->setFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 20, "Centro De Servicios y Gestión Empresarial ", 0, 2, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 20, "Complejo Central  SENA", 0, 4, 'C', 0, '', 0, false, 'M', 'M');
        

        // Set font
        $this->setFont('helvetica', 'B', 10);
        $this->Cell(0, 9, "Dirección: Cra. 57 #51-83, Medellín, La Candelaria, Medellín, Antioquia", 0, 4, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 9, "Teléfono: 45760000", 0, 4, 'C', 0, '', 0, false, 'M', 'M');

       
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->setY(-15);
        // Set font
        $this->setFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


class PrestamoPdf
{

    public static function generarPdf(int $prestamo_id, string $download = '')
    {
        $datosPrestamo = ModeloPrestamos::datosPdf($prestamo_id);
        $instructor = $datosPrestamo[0]['instructor'];
        $funcionario = $datosPrestamo[0]['usuario'];
        $fecha = $datosPrestamo[0]['fecha'];
        // var_dump($datosPrestamo);
        

        // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->setCreator(PDF_CREATOR);
        $pdf->setAuthor('Nicola Asuni');
        $pdf->setTitle('TCPDF Example 003');
        $pdf->setSubject('TCPDF Tutorial');
        $pdf->setKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->setFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        

        // ---------------------------------------------------------

        // $pdf->SetY(20);
        // set font
        $pdf->setFont('helvetica', '', 12);
        // $pdf->setFont('helvetica', 'I', 8);

        // add a page
        $pdf->AddPage();

        // set some text to print
        // $txt = <<<EOD
        //     TCPDF Example 003

        //     Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
        // EOD;

        // // print a block of text using Write()
        // $pdf->Write(15, "", '', 0, 'C', true, 0, false, false, 0);
        // $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
        $pdf->Write(15, "", '', 0, 'C', true, 0, false, false, 0);
        // $fecha = date("Y-m-d");
        $tbl = <<<EOD
            <div style="text-align:center">
                <h3>PEDIDO N°. $prestamo_id</h3>
            </div>
            <table cellspacing="0" cellpadding="1" border="1">
                <tr>
                    <td colspan="2">Funcionario que recibe: $instructor </td>
                    <td align="right">Fecha: $fecha</td>
                </tr>
                <tr>
                    <td colspan="3">Funcionario que entrega: $funcionario</td>                    
                </tr>
               
            </table>
        EOD;

        $pdf->writeHTML($tbl, true, false, false, false, 'L');


        $trPrestamo = '';
        $totalCantidad = 0;
        foreach ($datosPrestamo as $dato) {
            $trPrestamo .= <<<EOD
                <tr align="center">
                    <td>{$dato['producto']}</td>
                    <td>{$dato['cantidad']}</td>
                    <td>{$dato['devolutivo']}</td>
                    <td>{$dato['consumible']}</td>                    
                </tr>
            EOD;
            $totalCantidad += $dato['cantidad'];

        }

        $tbl2 = <<<EOD
            <table cellspacing="0" cellpadding="1" border="1">
                <tr align="center">
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Devolutivo</th>
                    <th>Consumible</th>
                </tr>
                $trPrestamo
                
               
            </table>
        EOD;

        $pdf->writeHTML($tbl2, true, false, false, false, 'L');

        
        $div = <<<EOD
            <div>
                <table cellspacing="0" cellpadding="1" border="1">
                    <tr align="">
                        <th>Cantidad</th>
                        <td align="center">$totalCantidad</td>
                    </tr>               
                    <tr align="">
                        <th>Verficado</th>
                        <td></td>
                    </tr>               
                    <tr align="">
                        <th>Vo.Bo</th>
                        <td></td>
                    </tr>
                </table>
            </div>
        EOD;

        $pdf->writeHTML($div, true, false, false, false, 'L');


        // ---------------------------------------------------------

        //Close and output PDF document
        if ($download != '') {
            $pdf->Output("Prestamo_$prestamo_id.pdf", 'D');
            
        } else {
            $pdf->Output("Prestamo_$prestamo_id.pdf", 'I');
           
        }

        //============================================================+
        // END OF FILE
        //============================================================+
    }
}

if (isset($_REQUEST['reportepdf']) && $_REQUEST['reportepdf'] == 'ok') {
    $download = isset($_REQUEST['download']) ? $_REQUEST['download'] : '';
    PrestamoPdf::generarPdf(intval($_REQUEST['prestamo_id']), $download);
     
}
