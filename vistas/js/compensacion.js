class compensacion {
  
    constructor() {
       this.idContribuyente=null;
    }
   
  //CARGAR PARA EDITAR CARPETA
    editarCarpetaProgreso(idCarpeta){
  
      console.log("aqui ya vas -------------", idCarpeta)
  
      let idDireccion;
      let datos = new FormData();
      datos.append("idCarpeta", idCarpeta);
      $.ajax({
        url: "ajax/carpeta.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
  
          console.log("paar cargar en la vista ",respuesta);
          // //(respuesta)
          //$("#estado_progreso").val(respuesta["Estado_progreso"]).change(); 

          if (respuesta["Estado_progreso"]) {
            $("#estado_progreso").val(respuesta["Estado_progreso"]).change();
          }

         
           // Asignar observaciones
         if (respuesta["usuario"]) {
            $("#usuario_progreso").text(respuesta["usuario"]);
          }

          // Asignar observaciones
          if (respuesta["observacion_progreso"]) {
            $("#observacion_progreso").val(respuesta["observacion_progreso"]);
          }
          if (respuesta["observacion_pendiente"]) {
            $("#observacion_pendiente").val(respuesta["observacion_pendiente"]);
          }
    
    
           // Asignar completado oficina y campo
          if (respuesta["completado_oficina"] === "on") {
            $("#completado_oficina").prop("checked", true);
          } else {
            $("#completado_oficina").prop("checked", false);
          }
    
          if (respuesta["completado_campo"] === "on") {
            $("#completado_campo").prop("checked", true);
          } else {
            $("#completado_campo").prop("checked", false);
          }



          
  
          //  $("#codigo_carpeta").val(respuesta["Codigo_Carpeta"]); 
  
            // Actualizar la barra de progreso en base al valor recibido
          actualizarBarraDeProgreso(respuesta["Estado_progreso"]);
  
          // $("#iduc").val(respuesta["Id_Ubica_Vias_Urbano"]);
          // $("#e_tipoDoc").val(respuesta["Id_Tipo_Documento"]);
          // $("#e_docIdentidad").val(respuesta["Documento"]);
          // $("#e_tipoContribuyente").val(respuesta["Id_Tipo_Contribuyente"]);
          // $("#e_codigo_sa").val(respuesta["Codigo_sa"]);
          // $("#e_razon_social").val(respuesta["Nombres"]);
          // $("#e_clasificacion").val(respuesta["Id_Clasificacion_Contribuyente"]);
          // $("#e_apellPaterno").val(respuesta["Apellido_Paterno"]);
          // $("#e_apellMaterno").val(respuesta["Apellido_Materno"]);
          // $("#e_condicionContri").val(respuesta["Id_Condicion_Contribuyente"]);
          // $("#e_nroUbicacion").val(respuesta["Numero_Ubicacion"]);
          // $("#e_nroLote").val(respuesta["Lote"]);
          // $("#e_nroDepartamento").val(respuesta["Numero_Departamento"]);
          // $("#e_nrobloque").val(respuesta["Bloque"]);
          // $("#e_nroLuz").val(respuesta["Numero_Luz"]);
          // $("#e_condicionpredio").val(respuesta["Id_Condicion_Predio_Fiscal"]);
          // $("#e_referencia").val(respuesta["Referencia"]);
          // $("#e_telefono").val(respuesta["Telefono"]);
          // $("#e_correo").val(respuesta["Correo"]);
          // $("#e_observacion").val(respuesta["Observaciones"]);
          // $("#usuarioCoactivo").prop('checked',respuesta["Coactivo"]==='1');
          // $("#usuarioFallecida").prop('checked',respuesta["Fallecida"]==='1');
          // let idDireccion = respuesta["Id_Ubica_Vias_Urbano"];
        },
      });
    }
  
    guardar_editar_progreso(datosFormulario){
     
    console.log(datosFormulario);
  
      $.ajax({
        type: 'POST',
        url: 'ajax/carpeta.ajax.php', // Cambia esto por la URL a la que envías los datos
        data: datosFormulario, // Serializa los datos del formulario
        success: function(respuesta) {
          if (respuesta.tipo === "correcto") {
            $("#modalEditarcontribuyente").modal("hide");
            $("#respuestaAjax_srm").show(); // Mostrar el elemento #error antes de establecer el mensaje
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();
              window.location.href = window.location.href; // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
              // Recargar la página manteniendo los parámetros actuales
            }, 1000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
          } else {
            $("#modalEditarcontribuyente").modal("hide");
            $("#respuestaAjax_srm").show(); // Mostrar el elemento #error antes de establecer el mensaje
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            setTimeout(function () {
              $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
              // Recargar la página manteniendo los parámetros actuales
            }, 3000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
          }
        }
      });
     }

  }
  
  const compensacion_ = new compensacion();


  // Cuando se hace clic en una fila de #compensacion_origen
$(document).on("click", "#compensacion_origen tr", function () {
  // Quitar selección anterior
  $("#compensacion_origen tr").removeClass("selected");
  
  // Agregar clase "selected" a la fila clickeada
  $(this).addClass("selected");

  console.log("Fila seleccionada:", $(this).attr("id")); // Esto es para verificar
});



  
$(document).on("click", "#btn-agregar", function () {
  console.log("Botón Agregar presionado");

  const fila = $("#compensacion_origen tr.selected");
  if (fila.length > 0) {
    fila.removeClass("selected").appendTo("#compensacion_destino");
  } else {
    alert("Selecciona una fila del ORIGEN.");
  }
});
