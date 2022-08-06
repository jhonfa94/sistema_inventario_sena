<?php
require '../config.php';

class AjaxInstructores{

	/*=============================================
	EDITAR INSTRUCTOR
	=============================================*/	

	public $idInstructor;

	public function ajaxEditarInstructor(){

		$item = "id";
		$valor = $this->idInstructor;

		$respuesta = ControladorInstructores::ctrMostrarInstructores($item, $valor);

		echo json_encode($respuesta);


	}

}

/*=============================================
EDITAR INSTRUCTOR
=============================================*/	

if(isset($_POST["idInstructor"])){

	$instructor = new AjaxInstructores();
	$instructor -> idInstructor = $_POST["idInstructor"];
	$instructor -> ajaxEditarInstructor();

}