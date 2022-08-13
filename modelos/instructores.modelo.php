<?php



class ModeloInstructores
{

	/*=============================================
	CREAR INSTRUCTOR
	=============================================*/

	static public function mdlIngresarInstructor($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, documento, email, telefono, direccion, fecha_nacimiento) 
			VALUES (:nombre, :documento, :email, :telefono, :direccion, :fecha_nacimiento)
		");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_INT);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			$stmt->closeCursor();
			return "ok";
		} else {

			return "error";
		}
	}

	/*=============================================
	MOSTRAR CINSTRUCTORES
	=============================================*/

	static public function mdlMostrarInstructores($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();
			$retorno =  $stmt->fetch();
			$stmt->closeCursor();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();
			$retorno =  $stmt->fetchAll();
			$stmt->closeCursor();
		}
		return $retorno;
	}

	/*=============================================
	EDITAR INSTRUCTOR
	=============================================*/

	static public function mdlEditarInstructor($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, documento = :documento, email = :email, telefono = :telefono, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_INT);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			$stmt->closeCursor();
			return "ok";
		} else {

			return "error";
		}
	}

	/*=============================================
	ELIMINAR INSTRUCTOR
	=============================================*/

	static public function mdlEliminarInstructor($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$stmt->closeCursor();

			return "ok";
		} else {

			return "error";
		}
	}

	/*=============================================
	ACTUALIZAR INSTRUCTOR
	=============================================*/

	static public function mdlActualizarInstructor($tabla, $item1, $valor1, $valor)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":id", $valor, PDO::PARAM_STR);

		if ($stmt->execute()) {

			$stmt->closeCursor();

			return "ok";
		} else {

			return "error";
		}
	}
}
