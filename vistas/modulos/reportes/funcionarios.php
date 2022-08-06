<?php

$item = null;
$valor = null;

$prestamos = ControladorPrestamos::ctrMostrarPrestamos($item, $valor);
$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

$arrayFuncionarioes = array();
$arraylistaFuncionarioes = array();

foreach ($prestamos as $key => $valuePrestamos) {

  foreach ($usuarios as $key => $valueUsuarios) {

    if($valueUsuarios["id"] == $valuePrestamos["id_funcionario"]){

        #Capturamos los funcionarioes en un array
        array_push($arrayFuncionarioes, $valueUsuarios["nombre"]);

        #Capturamos las nombres y los valores netos en un mismo array
        $arraylistaFuncionarioes = array($valueUsuarios["nombre"] => $valuePrestamos["neto"]);

         #Sumamos los netos de cada funcionario

        foreach ($arraylistaFuncionarioes as $key => $value) {

            $sumaTotalFuncionarioes[$key] += $value;

         }

    }
  
  }

}

#Evitamos repetir nombre
$noRepetirNombres = array_unique($arrayFuncionarioes);

?>


<!--=====================================
FUNCIONARIOS
======================================-->

<div class="box box-success">
	
	<div class="box-header with-border">
    
    	<h3 class="box-title">Funcionarioes</h3>
  
  	</div>

  	<div class="box-body">
  		
		<div class="chart-responsive">
			
			<div class="chart" id="bar-chart1" style="height: 300px;"></div>

		</div>

  	</div>

</div>

<script>
	
//BAR CHART
var bar = new Morris.Bar({
  element: 'bar-chart1',
  resize: true,
  data: [

  <?php
    
    foreach($noRepetirNombres as $value){

      echo "{y: '".$value."', a: '".$sumaTotalFuncionarioes[$value]."'},";

    }

  ?>
  ],
  barColors: ['#0af'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['prestamos'],
  preUnits: '$',
  hideHover: 'auto'
});


</script>