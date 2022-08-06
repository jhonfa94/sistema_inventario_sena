<?php



class ModeloMovimiento{

	static public function mdlMostrarproductos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
	
	}
	/*=============================================
	MOSTRAR Inveentario mdlMostrarMovimiento
	=============================================*/

	static public function mdlMostrarMovimiento($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();
			$stmt -> closeCursor();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fechaMovimiento ASC");

			$stmt -> execute();

			return $stmt -> fetchAll(); 
			$stmt -> closeCursor();

		}
		
		

		$stmt = null;

	}

	/*=============================================
	MOSTRAR Inveentario mdlMostrarMovimiento con producto
	=============================================*/

	static public function mdlMostrarMovimientoProd(){

		
			$sql ="select productos.descripcion, 
			CASE WHEN inventario.tipoMovimiento = 1 THEN 'Entrada' 
			     WHEN inventario.tipoMovimiento = 2 THEN 'Salida' 
			ELSE 'ninguno' END as tipoMovimiento, 
			inventario.cantidad, 
			inventario.fechaMovimiento,inventario.observacion
			from inventario inner join productos on productos.id = inventario.codProducto";
       
			
			$stmt = Conexion::conectar()->prepare($sql);
            //dump(sql);

            
			$stmt -> execute();

			return $stmt -> fetchAll();
		
		$stmt -> closeCursor();

		$stmt = null;

	}


	/*=============================================
	REGISTRO DE inventario
	=============================================*/

	static public function mdlAdicionarMovimiento($datos){

		$conexion = Conexion::conectar();
		
	    //var_dump($sql);
		$stmt = $conexion->prepare("INSERT INTO inventario(tipoMovimiento,cantidad,codProducto, observacion) 
            VALUES (:tipoMovimiento,:cantidad,:codProducto,:observacion)
		");

		$stmt->bindParam(":tipoMovimiento", $datos["tipoMovimiento"], PDO::PARAM_INT);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
		$stmt->bindParam(":codProducto", $datos["codProducto"], PDO::PARAM_STR);
		$stmt->bindParam(":observacion", $datos["observacion"], PDO::PARAM_STR);
		$stmt->execute();
		$idInsert =  $conexion->lastInsertId();
		$retorno = $idInsert > 0 ? 'ok' : 'error';	
		$stmt->closeCursor();
		return $retorno;

		/* if(){

			return "ok";

		}else{

			return "error";
		
		} */

		

	}

	/*=============================================
	EDITAR PRESTAMO
	=============================================*/

	static public function mdlEditarPrestamo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_Instructor = :id_instructor, id_funcionario = :id_funcionario, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago WHERE codigo = :codigo");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_instructor", $datos["id_instructor"], PDO::PARAM_INT);
		$stmt->bindParam(":id_funcionario", $datos["id_funcionario"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->closeCursor();
		$stmt = null;

	}

	/*=============================================
	ELIMINAR PRESTAMO
	=============================================*/

	static public function mdlEliminarPrestamo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> closeCursor();

		$stmt = null;

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasPrestamos($tabla, $fechaInicial, $fechaFinal){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();	 


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");

			}else{


				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");

			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	/*=============================================
	SUMAR EL TOTAL DE PRESTAMOS
	=============================================*/

	static public function mdlSumaTotalPrestamos($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> closeCursor();

		$stmt = null;

	}

	
}