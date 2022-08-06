<?php

$item = null;
$valor = null;

$prestamos = ControladorPrestamos::ctrMostrarPrestamos($item, $valor);
$instructores = ControladorInstructores::ctrMostrarInstructores($item, $valor);

$arrayInstructores = array();
$arraylistaInstructores = array();

foreach ($prestamos as $key => $valuePrestamos) {
  
  foreach ($instructores as $key => $valueInstructores) {
    
      if($valueInstructores["id"] == $valuePrestamos["id_instructor"]){

        #Capturamos los Instructores en un array
        array_push($arrayInstructores, $valueInstructores["nombre"]);

        #Capturamos las nombres y los valores netos en un mismo array
        $arraylistaInstructores = array($valueInstructores["nombre"] => $valuePrestamos["neto"]);

        #Sumamos los netos de cada instructor
        foreach ($arraylistaInstructores as $key => $value) {
          
          $sumaTotalInstructores[$key] += $value;
        
        }

      }   
  }

}

#Evitamos repetir nombre
$noRepetirNombres = array_unique($arrayInstructores);

?>

<!--=====================================
FUNCIONARIOS
======================================-->

<div class="box box-primary">
	
	<div class="box-header with-border">
    
    	<h3 class="box-title">Compradores</h3>
  
  	</div>

  	<div class="box-body">
  		
		<div class="chart-responsive">
			
			<div class="chart" id="bar-chart2" style="height: 300px;"></div>

		</div>

  	</div>

</div>

<script>
	
//BAR CHART
var bar = new Morris.Bar({
  element: 'bar-chart2',
  resize: true,
  data: [
     <?php
    
    foreach($noRepetirNombres as $value){

      echo "{y: '".$value."', a: '".$sumaTotalInstructores[$value]."'},";

    }

  ?>
  ],
  barColors: ['#f6a'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['prestamos'],
  preUnits: '$',
  hideHover: 'auto'
});


</script>