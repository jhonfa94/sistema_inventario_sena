<?php

class ControladorInstructores
{

	/*=============================================
	CREAR CINSTRUCTORES
	=============================================*/

	public static function ctrCrearInstructor()
	{

		if (isset($_POST["nuevoInstructor"])) {

			if (
				
				is_string($_POST['nuevoInstructor']) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoDocumentoId"]) &&
				filter_var($_POST['nuevoEmail'], FILTER_VALIDATE_EMAIL) &&
				is_string($_POST['nuevoTelefono']) &&
				is_string($_POST['nuevaDireccion']) 				
				// preg_match('/^[0-9]+$/', $_POST["nuevoDocumentoId"]) &&
				// preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"]) &&
				// preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoTelefono"]) &&
				// preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevaDireccion"])
			) {
				// var_dump($_POST);

				$tabla = "instructores";

				$datos = array(
					"nombre" => $_POST["nuevoInstructor"],
					"documento" => $_POST["nuevoDocumentoId"],
					"email" => $_POST["nuevoEmail"],
					"telefono" => $_POST["nuevoTelefono"],
					"direccion" => $_POST["nuevaDireccion"],
					"fecha_nacimiento" => $_POST["nuevaFechaNacimiento"]
				);

				$respuesta = ModeloInstructores::mdlIngresarInstructor($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

					swal({
						  type: "success",
						  title: "El instructor ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "instructores";

									}
								})

					</script>';
				}
			} else {

				echo '<script>

					swal({
						  type: "error",
						  title: "¡El instructor no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "instructores";

							}
						})

			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR CINSTRUCTORES
	=============================================*/

	static public function ctrMostrarInstructores($item, $valor)
	{

		$tabla = "instructores";

		$respuesta = ModeloInstructores::mdlMostrarInstructores($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	EDITAR INSTRUCTOR
	=============================================*/

	static public function ctrEditarInstructor()
	{

		if (isset($_POST["editarInstructor"])) {

			if (
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarInstructor"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarDocumentoId"]) &&
				preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editarEmail"]) &&
				preg_match('/^[()\-0-9 ]+$/', $_POST["editarTelefono"]) &&
				preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["editarDireccion"])
			) {

				$tabla = "instructores";

				$datos = array(
					"id" => $_POST["idInstructor"],
					"nombre" => $_POST["editarInstructor"],
					"documento" => $_POST["editarDocumentoId"],
					"email" => $_POST["editarEmail"],
					"telefono" => $_POST["editarTelefono"],
					"direccion" => $_POST["editarDireccion"],
					"fecha_nacimiento" => $_POST["editarFechaNacimiento"]
				);

				$respuesta = ModeloInstructores::mdlEditarInstructor($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

					swal({
						  type: "success",
						  title: "El instructor ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "instructores";

									}
								})

					</script>';
				}
			} else {

				echo '<script>

					swal({
						  type: "error",
						  title: "¡El instructor no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "instructores";

							}
						})

			  	</script>';
			}
		}
	}

	/*=============================================
	ELIMINAR INSTRUCTOR
	=============================================*/

	static public function ctrEliminarInstructor()
	{

		if (isset($_GET["idInstructor"])) {

			$tabla = "instructores";
			$datos = $_GET["idInstructor"];

			$respuesta = ModeloInstructores::mdlEliminarInstructor($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

				swal({
					  type: "success",
					  title: "El instructor ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {

								window.location = "instructores";

								}
							})

				</script>';
			}
		}
	}
}
