<?php

if (isset($_GET["fechaInicial"])) {
    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];
} else {

    $fechaInicial = date('Y-m-') . '01';
    $fechaFinal = date('Y-m-d');
}

$datos = ControladorPrestamos::ctrRangoFechasTop10Prestamos($fechaInicial, $fechaFinal);
/**
 * labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
data: [2478, 5267, 734, 784, 433]
 */
$labels = '[';
$data = '[';
foreach ($datos as $dato) {
    $labels .= "'{$dato['instructor']}',";
    $data .= $dato['total'] . ',';
}
$labels .= ']';
$data .= ']';

?>

<!--=====================================
Tipos de Prestamos
======================================-->

<div class="box box-default">

    <div class="box-header with-border">

        <!-- <h3 class="box-title">Tipos de Prestamos</h3> -->

    </div>

    <div class="box-body">

        <div class="row">

            <div class="col-md-12">

                <div class="chart-responsive">

                    
                    
                    <canvas id="bar-chart-horizontal-top-10-instructores"  width = "800"  height = "450" > </canvas>


                </div>

            </div>



        </div>

    </div>



</div>

<script>
    
    new Chart(document.getElementById("bar-chart-horizontal-top-10-instructores"), {
        type: 'horizontalBar',
        data: {
            labels: <?=$labels?>,
            datasets: [{
                label: "Instructor",
                backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850","#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",],
                data: <?=$data?>,
            }]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Top 10 instructores con mayor número de prestamos'
            }
        }
    });
</script>