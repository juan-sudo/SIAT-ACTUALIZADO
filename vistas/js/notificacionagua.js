class NotificaionUsuario {
  constructor() {
    this.idusuario_sesion = 0;
  }


  //editar notificacion
imprimirAgua() {
    // Obtener todas las filas de la tabla
    let filas = document.querySelectorAll('#lista_de_notificacion tr');
    
    // Crear un array para almacenar los datos capturados
    let datosCapturados = [];

    // Recorrer todas las filas
    filas.forEach(fila => {
        // Obtener todas las celdas <td> de la fila actual
        let celdas = fila.querySelectorAll('td');

        // Crear un array para almacenar los valores de las celdas en esta fila
        let filaDatos = [];

        // Recorrer todas las celdas de la fila y capturar su contenido
        celdas.forEach(celda => {
            filaDatos.push(celda.innerText);  // Obtener el texto de la celda
        });

        // Agregar los datos de la fila al array principal
        datosCapturados.push(filaDatos);
    });

    // Ver los datos capturados en la consola
    console.log(datosCapturados);

    // Enviar los datos al servidor a través de AJAX
    $.ajax({
      url: "./vistas/print/imprimirNotificacionAgua.php", // Asegúrate de que esta sea la URL correcta
      method: "POST",
      data: { 
        tabla_datos: JSON.stringify(datosCapturados)  // Convertimos el array a una cadena JSON
      },
      success: function (rutaArchivo) {
        // Establecer el src del iframe con la ruta relativa del PDF
        document.getElementById("iframeA").src = 'vistas/print/' + rutaArchivo;
      },
      error: function (error) {
        console.log('Error en la llamada AJAX:', error);
      }
    });
  }


  

  // Función para listar notificaciones
  // Función para listar notificaciones
lista_notificacion(filtro_nombre = '', filtro_fecha = '', filtro_estado = 'todos', pagina = 1) {
    let datos = new FormData();
    datos.append("lista_notificacion", "lista_notificacion");
    datos.append("filtro_nombre", filtro_nombre);  // Agregar filtro de nombre
    datos.append("filtro_fecha", filtro_fecha);    // Agregar filtro de fecha
    datos.append("filtro_estado", filtro_estado);  // Agregar filtro de estado
    datos.append("pagina", pagina);                // Agregar página actual

    $.ajax({
        url: "ajax/notificacionagua.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {

          console.log("Respuesta del servidor para listar notificaciones:", respuesta); // Verifica la respuesta del servidor
           
          let data;
          try {
              data = JSON.parse(respuesta);
          } catch (e) {
              console.log("No se pudo parsear la respuesta:", e);
              return;
          }

          document.getElementById('lista_de_notificacion').innerHTML = data.data; // Asignar contenido de la tabla
          document.getElementById('pagination').innerHTML = data.pagination;  
          
          }
    });
}

  //    lista_notificacion(filtro_nombre = '', filtro_fecha = '', filtro_estado = 'todos') {
  //   let datos = new FormData();
  //    datos.append("lista_notificacion", "lista_notificacion");
  //   datos.append("filtro_nombre", filtro_nombre); // Agregar filtro de nombre
  //   datos.append("filtro_fecha", filtro_fecha);   // Agregar filtro de fecha
  //   datos.append("filtro_estado", filtro_estado); // Agregar filtro de estado

  //   $.ajax({
  //     url: "ajax/notificacionagua.ajax.php",
  //     method: "POST",
  //     data: datos,
  //     cache: false,
  //     contentType: false,
  //     processData: false,
  //     success: function (respuesta) {
  //       document.getElementById('lista_de_notificacion').innerHTML = respuesta;
  //     }
  //   });
  // }


  
  guardar_notificacion_editado_n(){
         
     // Crear un objeto FormData a partir del formulario
    let formd = new FormData($("form.form-inserta-editar_n")[0]);
    
    // Agregar el campo adicional al FormData
    formd.append("guardar_datos_editar", "guardar_datos_editar");

    // Mostrar todos los datos de FormData en la consola para depuración
    for (let entry of formd.entries()) {
        console.log(entry[0] + ': ' + entry[1]);  // Imprime cada clave y valor
    }

   
        $.ajax({
          type: "POST",
          url: "ajax/notificacionagua.ajax.php",
          data: formd,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            
            console.log("Respuesta del servidor para guardar y mostrar notiifcaion:", respuesta); // Verifica la respuesta del servidor


          if (respuesta.tipo === "correcto") { // Si la respuesta es exitosa
            $("#modalEditarUsuario").modal("hide");  // Cierra el modal de edición
            $("#respuestaAjax_srm").show();  // Muestra el área de respuesta
            $("#respuestaAjax_srm").html(respuesta.mensaje);  // Muestra el mensaje de éxito en el área de respuesta
          
            notificacionUsuario.lista_notificacion('');

            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de respuesta después de 5 segundos
            }, 5000);

             $("#modalEditarNotificacion").modal("hide");


          }
          else {
            $("#respuestaAjax_srm").show();  // Si hay error, muestra el mensaje de error
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de error después de 4 segundos
            }, 4000);
          }
          },
        });
  }



}

// Crear instancia de la clase
const notificacionUsuario = new NotificaionUsuario();



// EDITTAR NOTIFICACION
$(document).on("click", ".btnEditarNotificacion", function () {
  var idNotificacion = $(this).data("idnotificaciona");  // Usar .data() en lugar de .attr()
    console.log(idNotificacion); // Verifica que el ID se está capturando cor

  var datos = new FormData();
  datos.append("idNotificacion_selet", idNotificacion);
  datos.append("idNotificacion_seleccionado", "idNotificacion_seleccionado");


  $.ajax({
    url: "ajax/notificacionagua.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {

        console.log("llegó aquí...", respuesta); // Verifica la respuesta del servidor
        let data;
        try {
             data = JSON.parse(respuesta);
         } catch (e) {
                console.log("No se pudo parsear la respuesta:", e);
                return;
            }

        // Verifica si la respuesta es un array y tiene elementos
        if (Array.isArray(data) && data.length > 0) {
            var notificacion = data[0];  // Accede al primer objeto del array

            console.log("Objeto de notificación:", notificacion); // Verifica la estructura completa del objeto

            // Verifica si la propiedad 'estado' existe
            if (notificacion.hasOwnProperty("estado")) {
                var estado = notificacion["estado"];
                console.log("Estado recibido:", estado); // Verifica que se está recibiendo el valor correcto
                $("#estadoN").val(estado); // Establece el valor del select

                 // Si el estado es 'S', mostrar el textarea y su label
                if (estado == 'S') {
                    $('#observacionRow').show();  // Muestra la fila del textarea
                } else {
                    $('#observacionRow').hide();  // Oculta la fila del textarea si no es 'S'
                }


            } else {
                console.log("La propiedad 'estado' no existe en el objeto.");
            }

               // Verifica si la propiedad 'fecha_corte' existe antes de intentar mostrarla
                if (notificacion.hasOwnProperty("Fecha_Registro")) {
                var fechaRegistro = notificacion["Fecha_Registro"];
                console.log("Fecha de registro completa:", fechaRegistro); // Verifica que la fecha completa esté presente
                
                // Crear un objeto Date a partir de la fecha
                var fecha = new Date(fechaRegistro);
                
                // Obtener solo la parte de la fecha en formato 'yyyy-mm-dd'
                var soloFecha = fecha.toISOString().split("T")[0];
                console.log("Fecha extraída:", soloFecha); // Verifica la fecha sin la hora
                
                // Mostrar solo la fecha en el span
                $("#editarFechaRegistro").text(soloFecha); // Mostrar solo la fecha en el span
            } else {
                console.log("La propiedad 'Fecha_Registro' no existe en el objeto.");
            }

            //ID NOTIFDICACION DE AGUA
                // Verifica si la propiedad 'fecha_corte' existe antes de intentar mostrarla
                if (notificacion.hasOwnProperty("Id_Notificacion_Agua")) {
                var idNotificaionAgua = notificacion["Id_Notificacion_Agua"];
                console.log("Fecha de registro completa:", idNotificaionAgua); // Verifica que la fecha completa esté presente
                
               
                // Mostrar solo la fecha en el span
                $("#idNotificacionA").val(idNotificaionAgua); // Mostrar solo la fecha en el span
            } else {
                console.log("La propiedad 'Id_Notificacion_Agua' no existe en el objeto.");
            }



            // Verifica si la propiedad 'fecha_corte' existe antes de intentar mostrarla
            if (notificacion.hasOwnProperty("fecha_corte")) {
                var fechaCorte = notificacion["fecha_corte"];
                console.log("Fecha de corte recibida:", fechaCorte); // Verifica que la fecha de corte esté presente
                $("#editarFechaCorte").text(fechaCorte); // Mostrar la fecha de corte en el span
            } else {
                console.log("La propiedad 'fecha_corte' no existe en el objeto.");
            }

             // Verifica obsrvaciob
            if (notificacion.hasOwnProperty("observacion")) {
                var observacion = notificacion["observacion"];
                console.log("Fecha de corte recibida:", observacion); // Verifica que la fecha de corte esté presente
                $("#observacionN").text(observacion); // Mostrar la fecha de corte en el span
            } else {
                console.log("La propiedad 'observacion' no existe en el objeto.");
            }


            // Mostrar el modal después de que los campos se hayan actualizado
            $("#modalEditarNotificacion").modal("show");

        } else {
            console.log("La respuesta está vacía o no tiene elementos.");
        }
    },
});

});


$(document).ready(function() {
    // Al cambiar el valor del select, muestra u oculta el textarea y su label
    $('#estadoN').change(function() {
        var estadoSeleccionado = $(this).val();

        if (estadoSeleccionado == 'S') {
            // Muestra el textarea y su label cuando se selecciona "Sin Servicio"
            $('#observacionRow').show();
        } else {
            // Oculta el textarea y su label cuando se selecciona otro estado
            $('#observacionRow').hide();
        }
    });
});



// Al cargar la página, mostrar todas las notificaciones
// Al cargar la página, mostrar todas las notificaciones
// Al cargar la página, mostrar todas las notificaciones
document.addEventListener('DOMContentLoaded', function () {
   notificacionUsuario.lista_notificacion('', '', 'todos', 1);  // Mostrar página 1 por defecto
    
    // Detectar cambios en los campos de filtro (nombre, fecha, estado)
    const nombreField = document.querySelector('#filtrar_nombre');
    const fechaField = document.querySelector('#fecha_notificacion');
    const estadoField = document.querySelector('#filtrar_estado'); // Campo de estado

    // Detectar cambios en el campo de texto para filtrar por nombre
    nombreField.addEventListener('input', function () {
        const nombre = nombreField.value;
        const fecha = fechaField.value; // Capturar la fecha seleccionada
        const estado = estadoField.value; // Capturar el estado seleccionado
        notificacionUsuario.lista_notificacion(nombre, fecha, estado, 1);  // Resetear a la página 1
    });

    // Detectar cambios en el campo de fecha para filtrar por fecha
    fechaField.addEventListener('change', function () {
        const fecha = fechaField.value;
        const nombre = nombreField.value;
        const estado = estadoField.value;
        notificacionUsuario.lista_notificacion(nombre, fecha, estado, 1);  // Resetear a la página 1
    });

    // Detectar cambios en el campo de estado para filtrar por estado
    estadoField.addEventListener('change', function () {
        const estado = estadoField.value;
        const nombre = nombreField.value;
        const fecha = fechaField.value;
        notificacionUsuario.lista_notificacion(nombre, fecha, estado, 1);  // Resetear a la página 1
    });
});




// document.addEventListener('DOMContentLoaded', function () {
//   // Llamar a la función lista_notificacion() para cargar todas las notificaciones
//   notificacionUsuario.lista_notificacion('');
//   console.log('Valor del atributo iso:', notificacionUsuario.idusuario_sesion);
  
//   // Detectar cambios en el campo de texto para filtrar por nombre
//   const nombreField = document.querySelector('#filtrar_nombre');
//    const fechaField = document.querySelector('#fecha_notificacion');
//    const estadoField = document.querySelector('#filtrar_estado'); // Campo de estado
  
//   // Detectar cambios en el campo de texto para filtrar por nombre
//   nombreField.addEventListener('input', function () {
//     // Capturar el valor ingresado en el campo de texto
//     const nombre = nombreField.value;
//     const fecha = fechaField.value; // Capturar la fecha seleccionada
//     const estado = estadoField.value; // Capturar el estado seleccionado
    
//     // Llamar a la función lista_notificacion() con los filtros aplicados (nombre, fecha y estado)
//     notificacionUsuario.lista_notificacion(nombre, fecha, estado);
    
//     console.log('Filtrar por nombre:', nombre); // Ver el valor filtrado
//     console.log('Filtrar por fecha:', fecha); // Ver el valor de la fecha filtrada
//     console.log('Filtrar por estado:', estado); // Ver el valor del estado filtrado
//   });


//    // Detectar cambios en el campo de fecha para filtrar por fecha
//   fechaField.addEventListener('change', function () {
//     // Capturar el valor seleccionado en el campo de fecha
//     const fecha = fechaField.value;
//     const nombre = nombreField.value; // Capturar el nombre ingresado
//     const estado = estadoField.value; // Capturar el estado seleccionado
    
//     // Llamar a la función lista_notificacion() con los filtros aplicados (nombre, fecha y estado)
//     notificacionUsuario.lista_notificacion(nombre, fecha, estado);
    
//     console.log('Filtrar por nombre:', nombre); // Ver el valor filtrado
//     console.log('Filtrar por fecha:', fecha); // Ver el valor de la fecha filtrada
//     console.log('Filtrar por estado:', estado); // Ver el valor del estado filtrado
//   });

//     // Detectar cambios en el campo de estado para filtrar por estado
//   estadoField.addEventListener('change', function () {
//     // Capturar el valor seleccionado en el campo de estado
//     const estado = estadoField.value;
//     const nombre = nombreField.value; // Capturar el nombre ingresado
//     const fecha = fechaField.value;  // Capturar la fecha seleccionada
    
//     // Llamar a la función lista_notificacion() con los filtros aplicados (nombre, fecha y estado)
//     notificacionUsuario.lista_notificacion(nombre, fecha, estado);
    
//     console.log('Filtrar por nombre:', nombre); // Ver el valor filtrado
//     console.log('Filtrar por fecha:', fecha); // Ver el valor de la fecha filtrada
//     console.log('Filtrar por estado:', estado); // Ver el valor del estado filtrado
//   });


// });




$(".form-inserta-editar_n").submit(function (e) {
    e.preventDefault();
    notificacionUsuario.guardar_notificacion_editado_n();
});


    
// CONFIRMAR ELIMIANR NOTIFICACION
// Confirmar eliminación de la notificación
// $(".btnEliminarNotificacion").on("click", function () {
//     // Capturar el ID de la notificación desde el atributo data-idnotificacion del botón
//     var idNotificacion = $(this).data("idnotificacion");
//     console.log("ID de notificación a eliminar:", idNotificacion);  // Verifica que el ID sea correcto

//     // Almacenamos el ID en el botón de confirmación dentro del modal, para usarlo al confirmar la eliminación
//     $("#btnEliminarNotificacion").data("idnotificacion", idNotificacion);
// });


// Confirmar eliminación de la notificación (cuando se hace clic en el botón de eliminación)
// Confirmar eliminación de la notificación cuando se hace clic en el botón de eliminación



// Confirmar eliminación cuando el usuario hace clic en "Sí, Eliminar"

$(document).on("click", ".btnAbrirNotificacion", function () {
    // Obtener el ID de la notificación desde el atributo data-idnotificacion
    var idNotificacion = $(this).data("idnotificacion");  // Usar .data() en lugar de .attr()
    console.log(idNotificacion); // Verifica que el ID se está capturando correctamente

    // Asignar el valor del ID de la notificación al input oculto
    $("#idNotificacionEliminar").val(idNotificacion);
});


// Cuando el usuario hace clic en "Sí, Eliminar"
$("#btnEliminarNotificacion").on("click", function () {
    // Capturar el valor del input oculto
    var idNotificacion = $("#idNotificacionEliminar").val();
    console.log("Confirmando eliminación de notificación con ID:", idNotificacion);  // Verifica que se está obteniendo el ID correctamente

    // Aquí puedes hacer la solicitud AJAX para eliminar la notificación, usando el valor del input
    var datos = new FormData();
    datos.append("idNotificacion", idNotificacion);  // Añadir el ID de la notificación a los datos

      datos.append("eliminar_notificacion", "eliminar_notificacion");  // Añadir el ID de la notificación a los datos

    $.ajax({
        url: "ajax/notificacionagua.ajax.php",  // Ajusta la URL según tu lógica
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            console.log("Respuesta del servidor:", respuesta);

          if (respuesta.tipo === "correcto") { // Si la respuesta es exitosa
            $("#modalEditarUsuario").modal("hide");  // Cierra el modal de edición
            $("#respuestaAjax_srm").show();  // Muestra el área de respuesta
            $("#respuestaAjax_srm").html(respuesta.mensaje);  // Muestra el mensaje de éxito en el área de respuesta
          
            notificacionUsuario.lista_notificacion('');
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de respuesta después de 5 segundos
            }, 5000);

              $("#modalEliminarNotificacion").modal("hide");


          }
          else {
            $("#respuestaAjax_srm").show();  // Si hay error, muestra el mensaje de error
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de error después de 4 segundos
            }, 4000);
          }
        },
        error: function (error) {
            console.log("Error al eliminar la notificación:", error);
            // Maneja los errores en caso de fallo en la solicitud
        }
    });
});



$(document).on("click", "#popimprimirExportarPDF", function () {

 notificacionUsuario.imprimirAgua();

   $("#ModalImprimirNotificacionAgua").modal("show");
});
