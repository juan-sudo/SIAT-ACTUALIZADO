class AdministracionCoactivo {

  constructor() {
    
    this.idcontribuyente=null;
       
  }



  lista_coactivo(filtro_nombre = '', filtro_op='', filtro_ex='',  pagina = 1, resultados_por_pagina='15') {
    let datos = new FormData();
    datos.append("lista_coactivo", "lista_coactivo");
    datos.append("filtro_nombre", filtro_nombre);  // Agregar filtro de nombre
    datos.append("filtro_op", filtro_op);  // Agregar filtro de nombre
    datos.append("filtro_ex", filtro_ex);  // Agregar filtro de nombre
    datos.append("pagina", pagina);   
    datos.append("resultados_por_pagina", resultados_por_pagina);                // Agregar página actual
   
    $.ajax({
        url: "ajax/administracioncoactivo.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
           
             let data;
          try {
              data = JSON.parse(respuesta);
          } catch (e) {
              console.log("No se pudo parsear la respuesta:", e);
              return;
          }

          document.getElementById('lista_de_coactivo').innerHTML = data.data;
          document.getElementById('pagination_co').innerHTML = data.pagination;  

            // Verifica si el elemento existe antes de modificarlo
            const listaDeCoactivo = document.getElementById('lista_de_coactivo');
            if (listaDeCoactivo) {
                // Verifica si la respuesta comienza con "<tr" (lo que indica que es HTML)
                if (respuesta.startsWith('<tr')) {
                    // Si es HTML, simplemente actualiza el contenido sin parsear
                    listaDeCoactivo.innerHTML = respuesta;
                } else {
                    // Si es JSON, parsea y maneja como JSON
                    let data;
                    try {
                        data = JSON.parse(respuesta);
                        listaDeCoactivo.innerHTML = data.data;
                    } catch (e) {
                        console.log("No se pudo parsear la respuesta:", e);
                        console.log("Respuesta cruda:", respuesta);
                    }
                }
            } else {
                console.error("No se encontró el elemento '#lista_de_coactivo'.");
            }
        }


    });
}


  //ADMINISTACION COACTIVO MOSTRAR ESTADO DE CUENTA
  MostrarAdministracionCoactivo(idContribuyente){

    console.log("id del contribuyente----", idContribuyente)



    let datos = new FormData();
    datos.append("lista_montos_coactivo", "lista_montos_coactivo");
    datos.append("idContribuyente", idContribuyente);  // Agregar filtro de nombre

    $.ajax({
      type: "POST", 
      url: "ajax/administracioncoactivo.ajax.php",
       data: datos,
        cache: false,
        contentType: false,
        processData: false,
      success: function (respuesta) {

           let data;
          try {
              data = JSON.parse(respuesta);
          } catch (e) {
              console.log("No se pudo parsear la respuesta:", e);
              return;
          }


           document.getElementById('table-moto-anios').innerHTML = data.data;
          document.getElementById('pagina_total').innerHTML = data.pagination;  
          

        

      },
    });

  }

  

  //EDITAR ADMINISTRACION COACTIVO
   EditarAdministracionCoactivo(idContribuyente){

    console.log("llego aqui-", idContribuyente)


    let datos = new FormData();

    datos.append("idContribuyente", idContribuyente);  // Agregar filtro de nombre
    datos.append("editar_coactivo", "editar_coactivo");
   


    $.ajax({
      type: "POST", 
      url: "ajax/administracioncoactivo.ajax.php",
       data: datos,
        cache: false,
        contentType: false,
        processData: false,
      success: function (respuesta) {

         if (typeof respuesta === "string") {
            respuesta = JSON.parse(respuesta);
            }

        if (respuesta.data && respuesta.data.length > 0) {
                var expediente = respuesta.data[0].expediente;
                var estado = respuesta.data[0].estado;
                  console.log(expediente);

                // Llenar los campos del modal
                $('#numeroExpedienteCo').val(expediente);

               // Asignar el estado seleccionado en el select
               // Mapea el valor "M" a la opción correspondiente
                if (estado === "I") {
                    $('#estadoCo').val('I');
                
                } else if (estado === "M") {
                    $('#estadoCo').val('M');
                }

            }

        

      },
    });

  }

  
  //EDITAR ADMINISTRACION COACTIVO
   GuardarAdministracionCoactivo(numeroExpediente, estado, pagina_numero){

    console.log("pgina actual", pagina_numero);
    let datos = new FormData();

   datos.append("idContribuyente",administracionCoactivo_.idcontribuyente);
   datos.append("expediente",numeroExpediente);
   datos.append("estado",estado);
    datos.append("guardar_coactivo", "guardar_coactivo");
   


    $.ajax({
      type: "POST", 
      url: "ajax/administracioncoactivo.ajax.php",
       data: datos,
        cache: false,
        contentType: false,
        processData: false,
      success: function (respuesta) {
          if (typeof respuesta === "string") {
            respuesta = JSON.parse(respuesta);
            }

        
          if (respuesta.status === "ok") { // Si la respuesta es exitosa
            $("#modalEditarUsuario").modal("hide");  // Cierra el modal de edición
            $("#respuestaAjax_srm").show();  // Muestra el área de respuesta
            $("#respuestaAjax_srm").html(respuesta.message);  // Muestra el mensaje de éxito en el área de respuesta
          
            administracionCoactivo_.lista_coactivo('', '','',pagina_numero);

            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de respuesta después de 5 segundos
            }, 5000);

           $("#modalEditarEstadoCuenta").modal("hide");
x

          }
          else {
            $("#respuestaAjax_srm").show();  // Si hay error, muestra el mensaje de error
            $("#respuestaAjax_srm").html(respuesta.message);
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de error después de 4 segundos
            }, 4000);
          }

        

      },
    });

  }

}

const administracionCoactivo_ = new AdministracionCoactivo();

document.addEventListener('DOMContentLoaded', function () {

   administracionCoactivo_.lista_coactivo('','','',1);  // Mostrar página 1 por defecto
    
    // Detectar cambios en los campos de filtro (nombre, fecha, estado)
    const nombreField = document.querySelector('#filtrar_nombre_coactivo');

     const resultados_por_pagina = document.querySelector('#resultados_por_pagina_co'); // Campo de estado

    const numeroop = document.querySelector('#filtrar_op');
    const numeroex = document.querySelector('#filtrar_ex');

    // Detectar cambios en el campo de texto para filtrar por nombre
    nombreField.addEventListener('input', function () {
        
        const nombre = nombreField.value;
        const op = numeroop.value;
        const ex = numeroex.value;
      
        administracionCoactivo_.lista_coactivo(nombre,op, ex,1,resultados_por_pagina.value);  // Resetear a la página 1
    });

     // Detectar cambios en el campo op
    numeroop.addEventListener('input', function () {
        const nombre = nombreField.value;
        const op = numeroop.value;
        const ex = numeroex.value;
      
        administracionCoactivo_.lista_coactivo(nombre, op,ex, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });

     // Detectar cambios en el campo expdiente
      numeroex.addEventListener('input', function () {
        const nombre = nombreField.value;
        const op = numeroop.value;
        const ex = numeroex.value;
      
        administracionCoactivo_.lista_coactivo(nombre, op,ex, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });


  
     // Detectar cambios en el campo de estado para filtrar por estado
        resultados_por_pagina.addEventListener('change', function () {
            console.log("llego aqui---");
        const nombre = nombreField.value;
        const op = numeroop.value;
        const ex = numeroex.value;
        administracionCoactivo_.lista_coactivo(nombre,op,ex,  1,resultados_por_pagina.value);  // Resetear a la página 1
    });


});



//VER ADMINISTRACION DE COACTIVO
$(document).on("click", ".btnVerAdministracionCoactivo", function () {

    const idcontribuyente = $(this).data("idcontribuyente");
    

    administracionCoactivo_.idcontribuyente = idcontribuyente;

    administracionCoactivo_.MostrarAdministracionCoactivo(administracionCoactivo_.idcontribuyente);
});

//VER EDITAR ADMINISTRACION COACTIVO
$(document).on("click", ".btnEditarAdministracionCoactivo", function () {

    const idcontribuyente = $(this).data("idcontribuyente");

    administracionCoactivo_.idcontribuyente = idcontribuyente;
    administracionCoactivo_.EditarAdministracionCoactivo(administracionCoactivo_.idcontribuyente);
});


//GUARDAR EDITAR
$(document).on("click", ".btnGuadarAdministracionCoactivo", function () {

    var numeroExpediente = $('#numeroExpedienteCo').val(); // Capturar el valor del input de numeroExpedienteCo
    var estado = $('#estadoCo').val(); // Capturar el valor del select de estadoCo

     var pagina_actual = $('#paginal_Actual_c').text();
    
      var pagina_numero = parseInt(pagina_actual.match(/\d+/)[0]);


    administracionCoactivo_.GuardarAdministracionCoactivo(numeroExpediente, estado, pagina_numero);
});



//REGISTRAR EL NUMERO DE EXPEDIENTE

$(document).ready(function() {
    // Al hacer clic en "Asignar Número"
    $("#btnAsignar").click(function() {
        // Ocultar el texto del número de expediente
        $("#expedienteAsignado").hide();
        
        // Mostrar el input para el número de expediente
        $("#numeroExpediente").show().focus();
        
        // Mostrar los botones de Guardar y Cancelar
        $("#btnGuardar").show();
        $("#btnCancelar").show();
        
        // Ocultar el botón Asignar Número
        $("#btnAsignar").hide();
    });

    // Al hacer clic en "Guardar"
    $("#btnGuardar").click(function() {
        var numeroExpediente = $("#numeroExpediente").val().trim();
        
        if (numeroExpediente !== "") {
            // Actualizar el número de expediente con el valor ingresado
            $("#expedienteAsignado").text(numeroExpediente).show();
            
            // Ocultar el input y los botones
            $("#numeroExpediente").hide();
            $("#btnGuardar").hide();
            $("#btnCancelar").hide();
            
            // Mostrar el botón Asignar Número
            $("#btnAsignar").show();
        } else {
            alert("Ingrese un número de expediente válido");
        }
    });

    // Al hacer clic en "Cancelar"
    $("#btnCancelar").click(function() {
        // Volver al estado inicial, mostrando el texto del expediente
        $("#numeroExpediente").hide();
        $("#btnGuardar").hide();
        $("#btnCancelar").hide();
        $("#expedienteAsignado").show();
        $("#btnAsignar").show();
    });
});


$(document).on("click", ".btnAdministracionCoactivo", function () {
    var contribuyenteId = $(this).data('idcontribuyente');  // Obtener el valor
    console.log("ID del contribuyente:", contribuyenteId);
    
    // Verificar si el ID está presente
    if (contribuyenteId) {
        // Asegurar que contribuyenteId sea una cadena de texto antes de aplicar .trim()
        contribuyenteId = String(contribuyenteId).trim();  // Convertir a cadena y limpiar espacios
        
        // Verificar si el valor contiene más de un ID (si tiene comas)
        if (contribuyenteId.includes(',')) {
            // Convertir el valor en un arreglo si hay más de un ID
            var idsArray = contribuyenteId.split(','); 
            
            // Eliminar cualquier espacio dentro de los valores antes de unirlos con un solo guion
            idsArray = idsArray.map(function(id) {
                return id.trim(); // Limpiar cualquier espacio dentro de cada ID
            });
            
            // Unir con un solo guion
            contribuyenteId = idsArray.join('-');
        }

        // Verificar que el valor de contribuyenteId esté limpio
        console.log("ID(s) del contribuyente formateado(s):", contribuyenteId);
        
        // Construcción de la URL
        var url = 'http://localhost/SIAT/index.php?ruta=administracioncoactivo&id=' + contribuyenteId + '&anio=2025';
        
        // Asegúrate de que la URL esté correcta
        window.location.href = url; // Redirigir a la URL
    } else {
        console.log("No se encontró el ID del contribuyente.");
    }
});

//ADMINISTRACION COACTIVO

$("#volver_administracion_co").click(function (e) {
    e.preventDefault(); // Prevenir el comportamiento predeterminado, en caso de que sea un enlace
    console.log("Has hecho clic ahora ---");

    // Generar la URL para redirigir
    const url = `${window.location.origin}/SIAT/administrarCoactivo`;

    console.log("Redirigiendo a:", url);

    // Redirigir a la URL
    window.location.href = url;
});


