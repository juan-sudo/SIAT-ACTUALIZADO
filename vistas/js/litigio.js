//PASAR EL VALOR DE CONTRIBUYENTE BUSCADO A PREDIOS POR GET - VALIDADO
class Litigio {
  
    constructor() {
       this.idContribuyente=null;
       this.idPredio=null;
       this.idAnioFiscal=null;
       this.observacion=null;
    }
   
  //CARGAR PARA EDITAR CARPETA
    editarPredioLitigio(idContribueyentes){
      console.log("ID Contribuyente desde editarPredioLitigio:", idContribueyentes);

      let datos = new FormData();
      datos.append("mostrar_predio_litigio", "mostrar_predio_litigio");
      datos.append("ids", idContribueyentes);

  
      $.ajax({
        url: "ajax/predioLitigio.ajax.php",
        method: "POST",  
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
  
          console.log("paar cargar en la vista ",respuesta);

          if (respuesta.length > 0) {
            const primerItem = respuesta[0]; // solo el primero

          console.log("Primer item:", primerItem);

           // Condición para marcar con color rojo el tr correspondiente
        const idPredio = primerItem["Id_Predio"]; // El id que deseas marcar en rojo

        // Buscar el tr con el id_predio correspondiente y aplicar el estilo
        $(`#fila[data-id_predio="${idPredio}"]`).css('background-color', 'red');

          // Marcar el checkbox correspondiente
        $(`input[data-id_predio="${idPredio}"]`).prop('checked', true);



            if (primerItem["Observaciones"]) {
              $("#observacion_predio").val(primerItem["Observaciones"]).change();
            }


          }
        },
      });
    }
  

  guardar_predio_litigio(datosFormulario){

    



  $.ajax({
    type: 'POST',
    url: 'ajax/predioLitigio.ajax.php',
    data: datosFormulario,
    contentType: false,
    processData: false,
    dataType: 'json',
    success: function(respuesta) {
      if (respuesta.tipo === "correcto") {
        $("#modalEditarcontribuyente").modal("hide");
        $("#respuestaAjax_srm").show().html(respuesta.mensaje);
        setTimeout(() => {
          $("#respuestaAjax_srm").hide();
        window.location.href = window.location.href;
        }, 1000);
      } else {
        $("#modalEditarcontribuyente").modal("hide");
        $("#respuestaAjax_srm").show().html(respuesta.mensaje);
        setTimeout(() => {
          $("#respuestaAjax_srm").hide();
        }, 3000);
      }
    },
    error: function(xhr, status, error) {
      console.error("ERROR AJAX:", status, error);
      console.log(xhr.responseText);
    }
  });


}

   
  
    // guardar_predio_litigio(datosFormulario){
     
    // console.log(datosFormulario);
  


    //   $.ajax({
    //     type: 'POST',
    //     url: 'ajax/predioLitigio.ajax.php', // Cambia esto por la URL a la que envías los datos
    //     data: datosFormulario, // Serializa los datos del formulario

    //     success: function(respuesta) {
    //       if (respuesta.tipo === "correcto") {
    //         $("#modalEditarcontribuyente").modal("hide");
    //         $("#respuestaAjax_srm").show(); // Mostrar el elemento #error antes de establecer el mensaje
    //         $("#respuestaAjax_srm").html(respuesta.mensaje);
            
    //         setTimeout(function () {
    //           $("#respuestaAjax_srm").hide();
    //          window.location.href = window.location.href; // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
    //           // Recargar la página manteniendo los parámetros actuales
    //         }, 1000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
    //       } else {
    //         $("#modalEditarcontribuyente").modal("hide");
    //         $("#respuestaAjax_srm").show(); // Mostrar el elemento #error antes de establecer el mensaje
    //         $("#respuestaAjax_srm").html(respuesta.mensaje);
    //         setTimeout(function () {
    //           $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
    //           // Recargar la página manteniendo los parámetros actuales
    //         }, 3000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
    //       }
    //     }
    //   });

      
    //  }



  }
  
  
  const editarLitigio = new Litigio();
  
 
$(document).on("click", "#mostrar_litigio", function () {

    const idArray = $('#id_array_php').val().split(',').map(Number);

    console.log("ID Array desde input:", idArray);

    editarLitigio.editarPredioLitigio(idArray);

    $("#modal_litigio").show();
});


  
  // Cerrar el modal de progreso
  $(document).on("click", "#salir_modal_litigio", function () {
    $("#modal_litigio").hide();
  });
  
  
  

  // $(document).on("click", "#tablalistaprediosL tbody tr", function () {

  //   // predioSelect = true;
  //    editarLitigio.idPredio = $(this).attr("id_predio");
  //   editarLitigio.observacion = $(this).attr("observacion_predio");
 
  //   console.log("id del predio", editarLitigio.idPredio,  "observacion del predio", editarLitigio.observacion);


  // });



//    // GUARDAR PREDIO LITIGIO
// $('#formPredioLitigio').on('submit', function(event) {
//     event.preventDefault();

    
//     var datosFormulario = $(this).serialize(); 
 
//      const isoValue = document.getElementById("mySpan").getAttribute("iso");
//       datosFormulario += '&id_usuario=' + encodeURIComponent(isoValue);
  
    

//     // Capturar el ID del predio seleccionado (checkbox marcado)
//     var prediosSeleccionados = [];

//     $('.checkbox-predio:checked').each(function () {
//         prediosSeleccionados.push($(this).data('id_predio'));
//     });

//     if (prediosSeleccionados.length === 0) {
//         alert("Por favor seleccione al menos un predio.");
//         return;
//     }

//     // Puedes asignar solo uno si es individual, o enviar todos si es múltiple
//     editarLitigio.idPredio = prediosSeleccionados[0]; // o envía todo el array



//       datosFormulario += '&id_predio=' + editarLitigio.idPredio
//        datosFormulario += '&guardar_predio_litigio=guardar_predio_litigio'; 
  

//     editarLitigio.guardar_predio_litigio(datosFormulario);


// });

  
$('#formPredioLitigio').on('submit', function(event) {
    event.preventDefault();

    const formElement = this;
    const formData = new FormData(formElement); // captura todos los campos del formulario

    // Agregar id_usuario desde el atributo span
    const isoValue = document.getElementById("mySpan").getAttribute("iso");
    formData.append("id_usuario", isoValue);

    // Agregar ids (array convertido a string)
    const idArray = $('#id_array_php').val().split(',').map(Number);
    formData.append("ids", idArray.join(',')); // "255,256"

    // Capturar el radio seleccionado
    const radioSeleccionado = $('input[name="predio_seleccionado"]:checked');

    if (radioSeleccionado.length === 0) {
        alert("Por favor seleccione un predio.");
        return;
    }

    const idPredio = radioSeleccionado.val();
    formData.append("id_predio", idPredio);

    // Marcar que es para guardar
    formData.append("guardar_predio_litigio", "guardar_predio_litigio");

    // Llamar a la función
    editarLitigio.guardar_predio_litigio(formData);
});


// CONSULTA QU SI VA ELIMINAR PREDIO EN LITIGIO
$(document).on("click", ".icono-eliminar-litigio", function () {
    const id_predio_litigio = $(this).data('id_prediol_eliminar');
   
    if(id_predio_litigio ){

        $("#id_predio_litigio_eliminar_m").val(id_predio_litigio);

       $("#modal_pregita_elimar_litigio").modal("show");

    }

});

//ELIMINAR PREDIO LITIGIO CONFIRMADO

//NOTIFICACION
$(document).on("click", "#confirmarEliminarPredioL", function () {
    const idPredioLitigio = $("#id_predio_litigio_eliminar_m").val();
 console.log("ID del predio litigio a eliminar:", idPredioLitigio);

formData = new FormData();
formData.append("id_predio_litigio_eliminar", idPredioLitigio);
formData.append("eliminar_predio_litigio", "eliminar_predio_litigio");

  $.ajax({
    type: 'POST',
    url: 'ajax/predioLitigio.ajax.php',
    data: formData,
    contentType: false,
    processData: false,
    dataType: 'json',
    success: function(respuesta) {
      if (respuesta.tipo === "correcto") {
        $("#modalEditarcontribuyente").modal("hide");
        $("#respuestaAjax_srm").show().html(respuesta.mensaje);
        setTimeout(() => {
          $("#respuestaAjax_srm").hide();
        window.location.href = window.location.href;
        }, 1000);
      } else {
        $("#modalEditarcontribuyente").modal("hide");
        $("#respuestaAjax_srm").show().html(respuesta.mensaje);
        setTimeout(() => {
          $("#respuestaAjax_srm").hide();
        }, 3000);
      }
    },
    error: function(xhr, status, error) {
      console.error("ERROR AJAX:", status, error);
      console.log(xhr.responseText);
    }
  });
  

    // $("#modal_pregita_elimar_litigio").modal("hide");

    
});




// $('#formPredioLitigio').on('submit', function(event) {
//     event.preventDefault();

//     var datosFormulario = $(this).serialize(); 

//     const isoValue = document.getElementById("mySpan").getAttribute("iso");
//     datosFormulario += '&id_usuario=' + encodeURIComponent(isoValue);

//     const idArray = $('#id_array_php').val().split(',').map(Number);

//     datosFormulario += '&ids=' + idArray;

//     // Capturar el ID del predio seleccionado (solo uno marcado)
//     var prediosSeleccionados = [];

//     // Seleccionar solo un checkbox marcado (el último marcado)
//     var ultimoPredio = $('.checkbox-predio:checked').last();

//     if (ultimoPredio.length > 0) {
//         prediosSeleccionados.push(ultimoPredio.data('id_predio'));
//     } else {
//         alert("Por favor seleccione un predio.");
//         return;
//     }

//     // Asignar el ID del predio seleccionado
//     editarLitigio.idPredio = prediosSeleccionados[0]; 



//     datosFormulario += '&id_predio=' + editarLitigio.idPredio;
//     datosFormulario += '&guardar_predio_litigio=guardar_predio_litigio'; 

//     // Llamar la función para guardar el predio litigio
//     editarLitigio.guardar_predio_litigio(datosFormulario);
// });



// // Asegurar que solo se marque un checkbox
// $('.checkbox-predio').on('change', function() {
//     $('.checkbox-predio').prop('checked', false); // Desmarcar todos los checkboxes
//     $(this).prop('checked', true); // Marcar el checkbox actual
// });


  