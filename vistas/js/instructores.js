/*=============================================
EDITAR INSTRUCTOR
=============================================*/
$(".tablas").on("click", ".btnEditarInstructor", function(){

	var idInstructor = $(this).attr("idInstructor");

	var datos = new FormData();
    datos.append("idInstructor", idInstructor);

    $.ajax({

      url:"ajax/instructores.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      
      	   $("#idInstructor").val(respuesta["id"]);
	       $("#editarInstructor").val(respuesta["nombre"]);
	       $("#editarDocumentoId").val(respuesta["documento"]);
	       $("#editarEmail").val(respuesta["email"]);
	       $("#editarTelefono").val(respuesta["telefono"]);
	       $("#editarDireccion").val(respuesta["direccion"]);
           $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);
	  }

  	})

})

/*=============================================
ELIMINAR INSTRUCTOR
=============================================*/
$(".tablas").on("click", ".btnEliminarInstructor", function(){

	var idInstructor = $(this).attr("idInstructor");
	
	swal({
        title: '¿Está seguro de borrar el instructor?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar instructor!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=instructores&idInstructor="+idInstructor;
        }

  })

})