<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorPrestamos
{

	/*=============================================
	MOSTRAR PRESTAMO
	=============================================*/

	static public function ctrMostrarPrestamos($item, $valor)
	{

		$tabla = "prestamos";

		$respuesta = ModeloPrestamos::mdlMostrarPrestamos($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	CREAR PRESTAMO
	=============================================*/
	static public function ctrCrearprestamo()
	{
		if (isset($_POST['guardarPrestamo']) && $_POST['guardarPrestamo'] == 'ok') {
			// var_dump($_POST);
			// die();
			/*=============================================
			GUARDAR LA ENTRADA
			=============================================*/
			$tipo_prestamo = $_POST['nuevoTipoPrestamo'];
			// $idProducto = $_POST["idProducto"];
			// $cantidad = $_POST["nuevaCantidadProducto"];
			$fecha_devolucion =  NULL;
			$datos = array(
				"id_usuario" => $_SESSION["id_usuario"],
				"id_instructor" => $_POST["seleccionarInstructor"],
				"tipo_prestamo" => $tipo_prestamo,
				"fecha" => date("Y-m-d H:i"),
				"fecha_devolucion" => $fecha_devolucion,
				"ficha" => $_POST['ficha'],
				"observaciones" => $_POST['observaciones'],
			);

			// var_dump($datos);

			$idPrestamo = ModeloPrestamos::mdlIngresarprestamo($datos);
			// var_dump($idPrestamo);

			if ($idPrestamo != "error") {
				# SE OBTIENE EL VALOR DEL STOCK DEL PRODUCTO SELECCIONADO
				// listaProductos
				//'listaProductos' => string '[{"id":"62","descripcion":"Video Bean","cantidad":"1","stock":"2"},{"id":"61","descripcion":"Boligrafos","cantidad":"1","stock":"84"}]' (length=134)
				$listaProductos = json_decode($_POST['listaProductos'], true);
				/** EJEMPLO DE ARRAY DE JSON QUE SE TIENE DE LOS PRODUCTOS QUE SE AGREGAN 
					array (size=3)
						0 => 
							array (size=4)
							'id' => string '62' (length=2)
							'descripcion' => string 'Video Bean' (length=10)
							'cantidad' => string '1' (length=1)
							'stock' => string '2' (length=1)
						1 => 
							array (size=4)
							'id' => string '61' (length=2)
							'descripcion' => string 'Boligrafos' (length=10)
							'cantidad' => string '10' (length=2)
							'stock' => string '75' (length=2)
						2 => 
							array (size=4)
							'id' => string '2' (length=1)
							'descripcion' => string 'Computador Hp Pavilion' (length=22)
							'cantidad' => string '1' (length=1)
							'stock' => string '10' (length=2)
				 */

				foreach ($listaProductos as $key => $listaProducto) {

					$idProducto = $listaProducto['id'];
					$cantidad = $listaProducto['cantidad'];
					$datosDetalle = [
						'prestamo_id' => $idPrestamo,
						'producto_id' => $idProducto,
						'cantidad' => $cantidad
					];

					$guardarDetalle = ModeloPrestamos::guardarPrestamoDetalle($datosDetalle);

					$respuestaDetalle = '';
					if ($guardarDetalle > 0) {
						#OBTENEMOS LA INFORMACION DEL PRODUCTO
						$producto = ModeloProductos::mdlMostrarProductos('productos', 'id', $idProducto, 'desc');
						$stockProducto = $producto['stock'];

						# SE HACE LA ACTUALIZACION DEL STOCK DEL PRODUCTO		
						$updateStock = $stockProducto - $cantidad;
						$respuestaUP = ModeloProductos::mdlActualizarProducto('productos', 'stock', $updateStock, $idProducto);
						$respuestaDetalle = $respuestaUP;
					} else {
						$respuestaDetalle = 'error';
					}
				}



				if ($respuestaDetalle == 'ok') {
					echo '<script>
						swal({
							type: "success",
							title: "El prestamo ha sido guardada correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
							}).then(function(result){
							if (result.value) {
							window.location = "prestamos";
							}
						})

					</script>';
				}
			}
		}
	}


	/*=============================================
	DEVOLVER PRESTAMO
	=============================================*/
	static public function ctrDevolverPrestamo()
	{
		if (isset($_POST['devolucionPrestamo']) && $_POST['devolucionPrestamo'] == 'ok') {
			$idPrestamo = $_POST['idPrestamo'];
			$idProducto = $_POST['idProducto'];
			$stock = $_POST['stock'];
			$cantidadDevolucion = $_POST['cantidadDevolucion'];
			$cantidad = $stock + $cantidadDevolucion;
			$fechaDevolucion = $_POST['fechaDevolucion'];

			$respuesta = ModeloPrestamos::mdlUpdatePrestamo($idPrestamo, $fechaDevolucion);
			if ($respuesta == 'ok') {
				HelperController::clearDataFormJs();

				//ACTUALIZAMOS EL PRODUCTO
				$updateProductov = ModeloProductos::mdlActualizarProducto('productos', 'stock', $cantidad, $idProducto);
				if ($updateProductov == 'ok') {
					echo '
						<script>
							swal({
								type: "success",
								title: "La devolución se realizo correctamente",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
								}).then((result) => {
									if (result.value) {
										window.location = "prestamos";
									}
								})
						</script>
					';
					HelperController::reloadPage(3000);
				}
			}
		}
	}





	/*=============================================
	EDITAR PRESTAMO
	=============================================*/

	public static function ctrEditarprestamo()
	{

		if (isset($_POST["editarprestamo"])) {

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CINSTRUCTORES
			=============================================*/
			$tabla = "prestamos";

			$item = "codigo";
			$valor = $_POST["editarprestamo"];

			$traerprestamo = ModeloPrestamos::mdlMostrarPrestamos($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/

			if ($_POST["listaProductos"] == "") {

				$listaProductos = $traerprestamo["productos"];
				$cambioProducto = false;
			} else {

				$listaProductos = $_POST["listaProductos"];
				$cambioProducto = true;
			}

			if ($cambioProducto) {

				$productos =  json_decode($traerprestamo["productos"], true);

				$totalProductosComprados = array();

				foreach ($productos as $key => $value) {

					array_push($totalProductosComprados, $value["cantidad"]);

					$tablaProductos = "productos";

					$item = "id";
					$valor = $value["id"];
					$orden = "id";

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

					$item1a = "prestamos";
					$valor1a = $traerProducto["prestamos"] - $value["cantidad"];

					$nuevasPrestamos = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

					$item1b = "stock";
					$valor1b = $value["cantidad"] + $traerProducto["stock"];

					$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
				}

				$tablaInstructores = "instructores";

				$itemInstructor = "id";
				$valorInstructor = $_POST["seleccionarInstructor"];

				$traerInstructor = ModeloInstructores::mdlMostrarInstructores($tablaInstructores, $itemInstructor, $valorInstructor);

				$item1a = "compras";
				$valor1a = $traerInstructor["compras"] - array_sum($totalProductosComprados);

				$comprasInstructor = ModeloInstructores::mdlActualizarInstructor($tablaInstructores, $item1a, $valor1a, $valorInstructor);

				/*=============================================
				ACTUALIZAR LAS ENTRADAS DEL INSTRUCTOR Y REDUCIR EL STOCK Y AUMENTAR LAS PRESTAMO DE LOS PRODUCTOS
				=============================================*/

				$listaProductos_2 = json_decode($listaProductos, true);

				$totalProductosComprados_2 = array();

				foreach ($listaProductos_2 as $key => $value) {

					array_push($totalProductosComprados_2, $value["cantidad"]);

					$tablaProductos_2 = "productos";

					$item_2 = "id";
					$valor_2 = $value["id"];
					$orden = "id";

					$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2, $orden);

					$item1a_2 = "prestamos";
					$valor1a_2 = $value["cantidad"] + $traerProducto_2["prestamos"];

					$nuevasPrestamos_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);

					$item1b_2 = "stock";
					$valor1b_2 = $value["stock"];

					$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
				}

				$tablaInstructores_2 = "instructores";

				$item_2 = "id";
				$valor_2 = $_POST["seleccionarInstructor"];

				$traerInstructor_2 = ModeloInstructores::mdlMostrarInstructores($tablaInstructores_2, $item_2, $valor_2);

				$item1a_2 = "compras";

				$valor1a_2 = array_sum($totalProductosComprados_2) + $traerInstructor_2["compras"];

				$comprasInstructor_2 = ModeloInstructores::mdlActualizarInstructor($tablaInstructores_2, $item1a_2, $valor1a_2, $valor_2);

				$item1b_2 = "ultima_entrada";

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha . ' ' . $hora;

				$fechaInstructor_2 = ModeloInstructores::mdlActualizarInstructor($tablaInstructores_2, $item1b_2, $valor1b_2, $valor_2);
			}

			/*=============================================
			GUARDAR CAMBIOS DE LA ENTRADA
			=============================================*/

			$datos = array(
				"id_funcionario" => $_POST["idFuncionario"],
				"id_instructor" => $_POST["seleccionarInstructor"],
				"codigo" => $_POST["editarPrestamo"],
				"productos" => $listaProductos,
				"impuesto" => $_POST["nuevoPrecioImpuesto"],
				"neto" => $_POST["nuevoPrecioNeto"],
				"total" => $_POST["totalPrestamo"],
				"metodo_pago" => $_POST["listaMetodoPago"]
			);


			$respuesta = ModeloPrestamos::mdlEditarPrestamo($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "El prestamo ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "prestamos";

								}
							})

				</script>';
			}
		}
	}


	/*=============================================
	ELIMINAR PRESTAMO
	=============================================*/

	static public function ctrEliminarPrestamo()
	{

		if (isset($_GET["idPrestamo"])) {

			$tabla = "prestamos";

			$item = "id";
			$valor = $_GET["idPrestamo"];

			$traerPrestamo = ModeloPrestamos::mdlMostrarPrestamos($tabla, $item, $valor);

			/*=============================================
			ACTUALIZAR FECHA Guardar Instructor
			=============================================*/

			$tablaInstructores = "instructores";

			$itemPrestamos = null;
			$valorPrestamos = null;

			$traerPrestamos = ModeloPrestamos::mdlMostrarPrestamos($tabla, $itemPrestamos, $valorPrestamos);

			$guardarFechas = array();

			foreach ($traerPrestamos as $key => $value) {

				if ($value["id_instructor"] == $traerPrestamo["id_instructor"]) {

					array_push($guardarFechas, $value["fecha"]);
				}
			}

			if (count($guardarFechas) > 1) {

				if ($traerPrestamo["fecha"] > $guardarFechas[count($guardarFechas) - 2]) {

					$item = "ultima_entrada";
					$valor = $guardarFechas[count($guardarFechas) - 2];
					$valorIdInstructor = $traerPrestamo["id_instructor"];

					$comprasInstructor = ModeloInstructores::mdlActualizarInstructor($tablaInstructores, $item, $valor, $valorIdInstructor);
				} else {

					$item = "ultima_entrada";
					$valor = $guardarFechas[count($guardarFechas) - 1];
					$valorIdInstructor = $traerPrestamo["id_Instructor"];

					$comprasInstructor = ModeloInstructores::mdlActualizarInstructor($tablaInstructores, $item, $valor, $valorIdInstructor);
				}
			} else {

				$item = "ultima_entrada";
				$valor = "0000-00-00 00:00:00";
				$valorIdInstructor = $traerPrestamo["id_Instructor"];

				$entradasInstructor = ModeloInstructores::mdlActualizarInstructor($tablaInstructores, $item, $valor, $valorIdInstructor);
			}

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CINSTRUCTORES
			=============================================*/

			$productos =  json_decode($traerPrestamo["productos"], true);

			$totalProductosComprados = array();

			foreach ($productos as $key => $value) {

				array_push($totalProductosComprados, $value["cantidad"]);

				$tablaProductos = "productos";

				$item = "id";
				$valor = $value["id"];
				$orden = "id";

				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

				$item1a = "prestamos";
				$valor1a = $traerProducto["prestamos"] - $value["cantidad"];

				$nuevasPrestamos = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				$item1b = "stock";
				$valor1b = $value["cantidad"] + $traerProducto["stock"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
			}

			$tablaInstructores = "instructores";

			$itemInstructor = "id";
			$valorInstructor = $traerPrestamo["id_instructor"];

			$traerInstructor = ModeloInstructores::mdlMostrarInstructores($tablaInstructores, $itemInstructor, $valorInstructor);

			$item1a = "entradas";
			$valor1a = $traerInstructor["compras"] - array_sum($totalProductosComprados);

			$comprasInstructor = ModeloInstructores::mdlActualizarInstructor($tablaInstructores, $item1a, $valor1a, $valorInstructor);

			/*=============================================
			ELIMINAR PRESTAMO
			=============================================*/

			$respuesta = ModeloPrestamos::mdlEliminarPrestamo($tabla, $_GET["idPrestamo"]);

			if ($respuesta == "ok") {

				echo '<script>

				swal({
					  type: "success",
					  title: "El prestamo ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "prestamos";

								}
							})

				</script>';
			}
		}
	}

	public static function ctrListarPrestamos()
	{
		return ModeloPrestamos::mdlListarPrestamos();
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/
	static public function ctrRangoFechasPrestamos($fechaInicial, $fechaFinal)
	{
		// $tabla = "prestamos";
		// 		$respuesta = ModeloPrestamos::mdlRangoFechasPrestamos($tabla, $fechaInicial, $fechaFinal);
		$respuesta = ModeloPrestamos::graficoPrestamos($fechaInicial, $fechaFinal);

		return $respuesta;
	}

	static public function ctrRangoFechasPrestamosPie($fechaInicial, $fechaFinal)
	{
		$respuesta = ModeloPrestamos::graficoPrestamosPie($fechaInicial, $fechaFinal);

		return $respuesta;
	}

	static public function ctrRangoFechasTop10Prestamos($fechaInicial, $fechaFinal)
	{
		$respuesta = ModeloPrestamos::graficoPrestamosTop10($fechaInicial, $fechaFinal);

		return $respuesta;
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte()
	{

		if (isset($_GET["reporte"])) {

			$tabla = "prestamos";

			if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

				$prestamos = ModeloPrestamos::mdlRangoFechasPrestamos($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);
			} else {

				$item = null;
				$valor = null;

				$prestamos = ModeloPrestamos::mdlMostrarPrestamos($tabla, $item, $valor);
			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"] . '.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate");
			header('Content-Description: File Transfer');
			header('Last-Modified: ' . date('D, d M Y H:i:s'));
			header("Pragma: public");
			header('Content-Disposition:; filename="' . $Name . '"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>INSTRUCTOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FUNCIONARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($prestamos as $row => $item) {

				$instructor = ControladorInstructores::ctrMostrarInstructores("id", $item["id_instructor"]);
				$funcionario = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_funcionario"]);

				echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>" . $item["codigo"] . "</td> 
			 			<td style='border:1px solid #eee;'>" . $instructor["nombre"] . "</td>
			 			<td style='border:1px solid #eee;'>" . $funcionario["nombre"] . "</td>
			 			<td style='border:1px solid #eee;'>");

				$productos =  json_decode($item["productos"], true);

				foreach ($productos as $key => $valueProductos) {

					echo utf8_decode($valueProductos["cantidad"] . "<br>");
				}

				echo utf8_decode("</td><td style='border:1px solid #eee;'>");

				foreach ($productos as $key => $valueProductos) {

					echo utf8_decode($valueProductos["descripcion"] . "<br>");
				}

				echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ " . number_format($item["impuesto"], 2) . "</td>
					<td style='border:1px solid #eee;'>$ " . number_format($item["neto"], 2) . "</td>	
					<td style='border:1px solid #eee;'>$ " . number_format($item["total"], 2) . "</td>
					<td style='border:1px solid #eee;'>" . $item["metodo_pago"] . "</td>
					<td style='border:1px solid #eee;'>" . substr($item["fecha"], 0, 10) . "</td>		
		 			</tr>");
			}


			echo "</table>";
		}
	}


	/*=============================================
	SUMA TOTAL PRESTAMOS
	=============================================*/

	public static function ctrSumaTotalPrestamos()
	{

		$tabla = "prestamos";

		$respuesta = ModeloPrestamos::mdlSumaTotalPrestamos($tabla);

		return $respuesta;
	}

	/*=============================================
	DESCARGAR XML
	=============================================*/

	static public function ctrDescargarXML()
	{

		if (isset($_GET["xml"])) {


			$tabla = "prestamos";
			$item = "codigo";
			$valor = $_GET["xml"];

			$prestamos = ModeloPrestamos::mdlMostrarPrestamos($tabla, $item, $valor);

			// PRODUCTOS

			$listaProductos = json_decode($prestamos["productos"], true);

			// INSTRUCTOR

			$tablaInstructores = "instructores";
			$item = "id";
			$valor = $prestamos["id_instructor"];

			$traerInstructor = ModeloInstructores::mdlMostrarInstructores($tablaInstructores, $item, $valor);

			// FUNCIONARIO

			$tablaFuncionario = "usuarios";
			$item = "id";
			$valor = $prestamos["id_funcionario"];

			$traerFuncionario = ModeloUsuarios::mdlMostrarUsuarios($tablaFuncionario, $item, $valor);

			//http://php.net/manual/es/book.xmlwriter.php

			$objetoXML = new XMLWriter();

			$objetoXML->openURI($_GET["xml"] . ".xml"); //Creación del archivo XML

			$objetoXML->setIndent(true); //recibe un valor booleano para establecer si los distintos niveles de nodos XML deben quedar indentados o no.

			$objetoXML->setIndentString("\t"); // carácter \t, que corresponde a una tabulación

			$objetoXML->startDocument('1.0', 'utf-8'); // Inicio del documento

			// $objetoXML->startElement("etiquetaPrincipal");// Inicio del nodo raíz

			// $objetoXML->writeAttribute("atributoEtiquetaPPal", "valor atributo etiqueta PPal"); // Atributo etiqueta principal

			// 	$objetoXML->startElement("etiquetaInterna");// Inicio del nodo hijo

			// 		$objetoXML->writeAttribute("atributoEtiquetaInterna", "valor atributo etiqueta Interna"); // Atributo etiqueta interna

			// 		$objetoXML->text("Texto interno");// Inicio del nodo hijo

			// 	$objetoXML->endElement(); // Final del nodo hijo

			// $objetoXML->endElement(); // Final del nodo raíz


			$objetoXML->writeRaw('<fe:Invoice xmlns:fe="http://www.dian.gov.co/contratos/facturaelectronica/v1" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:clm54217="urn:un:unece:uncefact:codelist:specification:54217:2001" xmlns:clm66411="urn:un:unece:uncefact:codelist:specification:66411:2001" xmlns:clmIANAMIMEMediaType="urn:un:unece:uncefact:codelist:specification:IANAMIMEMediaType:2003" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:sts="http://www.dian.gov.co/contratos/facturaelectronica/v1/Structures" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dian.gov.co/contratos/facturaelectronica/v1 ../xsd/DIAN_UBL.xsd urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2 ../../ubl2/common/UnqualifiedDataTypeSchemaModule-2.0.xsd urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2 ../../ubl2/common/UBL-QualifiedDatatypes-2.0.xsd">');

			$objetoXML->writeRaw('<ext:UBLExtensions>');

			foreach ($listaProductos as $key => $value) {

				$objetoXML->text($value["descripcion"] . ", ");
			}



			$objetoXML->writeRaw('</ext:UBLExtensions>');

			$objetoXML->writeRaw('</fe:Invoice>');

			$objetoXML->endDocument(); // Final del documento

			return true;
		}
	}
}
