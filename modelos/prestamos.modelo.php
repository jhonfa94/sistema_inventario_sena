<?php



class ModeloPrestamos
{

	/*=============================================
	MOSTRAR PRESTAMOS
	=============================================*/

	static public function mdlMostrarPrestamos($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt->execute();

			return $stmt->fetchAll();

			$stmt->closeCursor();
		}



		$stmt = null;
	}

	/*=============================================
	REGISTRO DE PRESTAMO
	=============================================*/

	static public function mdlIngresarPrestamo($datos)
	{

		$conexion = Conexion::conectar();

		$stmt = $conexion->prepare("INSERT INTO prestamos(id_instructor, id_usuario,  tipo_prestamo, fecha_devolucion, fecha, ficha, observaciones) 
			VALUES (:id_instructor, :id_usuario,  :tipo_prestamo, :fecha_devolucion, :fecha, :ficha, :observaciones)
		");

		$stmt->bindParam(":id_instructor", $datos["id_instructor"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

		$stmt->bindParam(":tipo_prestamo", $datos["tipo_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_devolucion", $datos["fecha_devolucion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":ficha", $datos["ficha"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt->execute();
		$retorno = $conexion->lastInsertId() > 0 ? $conexion->lastInsertId() : 'error';
		$stmt->closeCursor();

		return $retorno;
	}

	/**
	 * Guardar prestamos detalle
	 *
	 * @param array $datos
	 * @return integer
	 */
	public static function guardarPrestamoDetalle(array $datos): int
	{
		$conexion = Conexion::conectar();

		$stmt = $conexion->prepare("INSERT INTO prestamo_detalle(prestamo_id, producto_id,  cantidad) 
			VALUES (:prestamo_id, :producto_id,  :cantidad)
		");

		$stmt->bindParam(":prestamo_id", $datos["prestamo_id"], PDO::PARAM_INT);
		$stmt->bindParam(":producto_id", $datos["producto_id"], PDO::PARAM_INT);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
		$stmt->execute();
		$retorno = $conexion->lastInsertId() > 0 ? $conexion->lastInsertId() : 0;
		$stmt->closeCursor();

		return $retorno;
	}

	/*=============================================
	EDITAR PRESTAMO
	=============================================*/

	static public function mdlEditarPrestamo($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_Instructor = :id_instructor, id_funcionario = :id_funcionario, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago WHERE codigo = :codigo");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_instructor", $datos["id_instructor"], PDO::PARAM_INT);
		$stmt->bindParam(":id_funcionario", $datos["id_funcionario"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->closeCursor();
		$stmt = null;
	}

	/*=============================================
	ELIMINAR PRESTAMO
	=============================================*/

	static public function mdlEliminarPrestamo($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->closeCursor();

		$stmt = null;
	}

	/**
	 * LISTAR PRESTAMOS 
	 *
	 * @return array
	 */
	public static function mdlListarPrestamos(): array
	{
		$stmt = Conexion::conectar()->prepare("SELECT p.id, i.nombre AS instructor,  p.tipo_prestamo, 
				p.fecha, p.fecha_devolucion,   f_lista_productos(p.id) AS producto, SUM(d.cantidad) AS cantidad, d.producto_id,
				u.nombre AS funcionario, pr.stock, p.ficha
			FROM prestamos p
			INNER JOIN prestamo_detalle d ON p.id = d.prestamo_id
			INNER JOIN instructores i ON p.id_instructor = i.id
			INNER JOIN productos pr ON d.producto_id = pr.id
			INNER JOIN usuarios u ON p.id_usuario = u.id
			GROUP BY p.id
			ORDER BY fecha DESC 
	 	");
		$stmt->execute();
		$retorno = $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
		$stmt->closeCursor();
		return $retorno;
	}

	/**
	 * DETALLE DEL PRESTAMO QUE SE TIENE
	 *
	 * @param integer $idPrestamo
	 * @return array
	 */
	public static function detallePrestamo(int $idPrestamo): array
	{
		$stmt = Conexion::conectar()->prepare("SELECT dt.prestamo_id, p.tipo_prestamo, p.fecha, p.fecha_devolucion, p.ficha, p.observaciones,
				dt.producto_id, pr.descripcion, c.categoria, dt.cantidad
			FROM prestamo_detalle dt
			JOIN prestamos p ON p.id = dt.prestamo_id
			JOIN productos pr ON pr.id = dt.producto_id
			JOIN categorias c ON pr.id_categoria = c.id
			WHERE dt.prestamo_id = :idPrestamo
	 	");
		$stmt->bindParam(':idPrestamo', $idPrestamo, PDO::PARAM_INT);
		$stmt->execute();
		$retorno = $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
		$stmt->closeCursor();
		return $retorno;
	}

	/**
	 * GRAFICO DE FECHAS
	 *
	 * @param string $fecha1
	 * @param string $fecha2
	 * @return array
	 */
	public static function graficoPrestamos(string $fecha1, string $fecha2): array
	{
		$stmt = Conexion::conectar()->prepare("SELECT DISTINCT  DATE(p.fecha) AS fecha, COUNT(p.id) AS total  
				FROM prestamos p 
			WHERE DATE(p.fecha) BETWEEN :fecha1 AND :fecha2
			GROUP BY DATE(p.fecha)
		
		");
		$stmt->bindParam(':fecha1', $fecha1, PDO::PARAM_STR);
		$stmt->bindParam(':fecha2', $fecha2, PDO::PARAM_STR);
		$stmt->execute();
		$retorno = $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
		$stmt->closeCursor();
		return $retorno;
	}

	/**
	 * GRAFICO DE PIE
	 *
	 * @param string $fecha1
	 * @param string $fecha2
	 * @return array
	 */
	public static function graficoPrestamosPie(string $fecha1, string $fecha2): array
	{
		$stmt = Conexion::conectar()->prepare("SELECT DISTINCT  DATE(p.fecha) AS fecha, tipo_prestamo, COUNT(p.id) AS total  FROM prestamos p 
			WHERE DATE(p.fecha) BETWEEN :fecha1 AND :fecha2
			GROUP BY p.tipo_prestamo		
		");
		$stmt->bindParam(':fecha1', $fecha1, PDO::PARAM_STR);
		$stmt->bindParam(':fecha2', $fecha2, PDO::PARAM_STR);
		$stmt->execute();
		$retorno = $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
		$stmt->closeCursor();
		return $retorno;
	}

	/**
	 * GRAFICO DE TOP 10 DE INSTRUCTORES
	 *
	 * @param string $fecha1
	 * @param string $fecha2
	 * @return array
	 */
	public static function graficoPrestamosTop10(string $fecha1, string $fecha2): array
	{
		$stmt = Conexion::conectar()->prepare("SELECT i.nombre AS instructor, COUNT(p.id_instructor) AS total from prestamos p
			JOIN instructores i ON p.id_instructor = i.id
			WHERE DATE(p.fecha) BETWEEN :fecha1 AND :fecha2
			GROUP BY p.id_instructor	
		");
		$stmt->bindParam(':fecha1', $fecha1, PDO::PARAM_STR);
		$stmt->bindParam(':fecha2', $fecha2, PDO::PARAM_STR);
		$stmt->execute();
		$retorno = $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
		$stmt->closeCursor();
		return $retorno;
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/

	static public function mdlRangoFechasPrestamos($tabla, $fechaInicial, $fechaFinal)
	{

		if ($fechaInicial == null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt->execute();

			return $stmt->fetchAll();
		} else if ($fechaInicial == $fechaFinal) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");

			$stmt->bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll();
		} else {

			$fechaActual = new DateTime();
			$fechaActual->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if ($fechaFinalMasUno == $fechaActualMasUno) {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE DATE(fecha) BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
			} else {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE DATE(fecha) BETWEEN '$fechaInicial' AND '$fechaFinal'");
			}

			$stmt->execute();

			return $stmt->fetchAll();
		}
	}

	/*=============================================
	SUMAR EL TOTAL DE PRESTAMOS
	=============================================*/

	static public function mdlSumaTotalPrestamos($tabla)
	{

		$stmt = Conexion::conectar()->prepare("SELECT count(*) as total FROM $tabla");

		$stmt->execute();

		return $stmt->fetch();

		$stmt->closeCursor();

		$stmt = null;
	}

	/**
	 * ACTUALIZACION DE PRESTAMO
	 *
	 * @param integer $id
	 * @param string $fecha
	 * @return void
	 */
	static public function mdlUpdatePrestamo(int $id, string $fecha)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE prestamos
			SET fecha_devolucion = :fecha
			WHERE id = :id
		");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
		$stmt->execute();
		$retorno = $stmt->rowCount() > 0 ? 'ok' : 'error';
		$stmt->closeCursor();
		return $retorno;
	}


	/**
	 * REPORTE DE PRESTAMOS
	 *
	 * @param  string $fecha1
	 * @param  string $fecha2
	 * @return array
	 */
	public static function reportePrestamoGeneral(string $fecha1, string $fecha2): array
	{
		$stmt = Conexion::conectar()->prepare("SELECT dt.prestamo_id, 
				i.nombre as instructor, u.nombre AS usuario, p.tipo_prestamo, p.fecha, p.fecha_devolucion, p.ficha,
				p.observaciones,
				pr.descripcion AS producto, c.categoria
			FROM prestamo_detalle dt
			JOIN prestamos p ON p.id = dt.prestamo_id
			JOIN productos pr ON pr.id = dt.producto_id
			JOIN usuarios u ON p.id_usuario = u.id
			JOIN instructores i ON i.id = p.id_instructor
			JOIN categorias c ON pr.id_categoria = c.id
			WHERE DATE(p.fecha) BETWEEN :fecha1 AND :fecha2
		");
		$stmt->bindParam(':fecha1', $fecha1, PDO::PARAM_STR);
		$stmt->bindParam(':fecha2', $fecha2, PDO::PARAM_STR);
		$stmt->execute();
		$retorno = $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
		$stmt->closeCursor();
		return $retorno;
	}

	/**
	 * DATOS DEL PRESTAMO PARA EL PDF 
	 *
	 * @param integer $prestamo_id
	 * @return array
	 */
	public static function datosPdf(int $prestamo_id): array
	{
		$stmt = Conexion::conectar()->prepare("SELECT pd.prestamo_id, pd.producto_id, pd.cantidad, 
				IF(p.tipo_prestamo = 'Devolutivo', 'X', '') AS devolutivo,
				IF(p.tipo_prestamo = 'Consumible', 'X', '') AS consumible,
				u.nombre AS usuario, 
				i.nombre AS instructor,
				DATE(p.fecha) AS fecha,
				pr.descripcion AS producto
			FROM prestamo_detalle pd
			JOIN prestamos p ON pd.prestamo_id = p.id
			JOIN usuarios u ON p.id_usuario = u.id
			JOIN instructores i ON p.id_instructor = i.id
			JOIN productos pr ON pr.id = pd.producto_id
			WHERE pd.prestamo_id = :prestamo_id
		");
		$stmt->bindParam(':prestamo_id', $prestamo_id, PDO::PARAM_INT);
		$stmt->execute();
		$retorno = $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
		$stmt->closeCursor();
		return $retorno;
	}
}
