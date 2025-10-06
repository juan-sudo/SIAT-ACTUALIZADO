class AdministracionOrdenPago {

  constructor() {
    
    this.idcontribuyente=null;
    this.idcoactivo=null;
    this.ordencompleta=null;
       
  }

  lista_orden_pago(filtro_nombre = '', filtro_op='', filtro_ex='',  pagina = 1, resultados_por_pagina='15') {
    let datos = new FormData();
    datos.append("lista_coactivo", "lista_coactivo");
    datos.append("filtro_nombre", filtro_nombre);
    datos.append("filtro_op", filtro_op);
    datos.append("filtro_ex", filtro_ex);
    datos.append("pagina", pagina);
    datos.append("resultados_por_pagina", resultados_por_pagina);
   
    $.ajax({
        url: "ajax/administracionordenpago.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {

       
            let data;
            try {
                // Intenta parsear la respuesta como JSON
                data = JSON.parse(respuesta);
            } catch (e) {
                console.log("No se pudo parsear la respuesta:", e);
                return;
            }

            const listaDeCoactivo = document.getElementById('lista_de_ordenpago');
            const pagination = document.getElementById('pagination_or');

            // Asegúrate de que los elementos existen
            if (listaDeCoactivo && pagination) {
                // Si la respuesta es HTML (por ejemplo, empieza con "<tr"), actualiza el contenido
                if (respuesta.startsWith('<tr')) {
                    listaDeCoactivo.innerHTML = respuesta;
                } else {
                    // Si la respuesta es JSON, asegura que 'data' tiene la propiedad 'data'
                    if (data && data.data) {
                        listaDeCoactivo.innerHTML = data.data;
                        pagination.innerHTML = data.pagination;
                    } else {
                        console.error("La respuesta no contiene los datos esperados.");
                    }
                }
            } else {
                console.error("No se encontró el elemento '#lista_de_ordenpago' o '#pagination_or'.");
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
      url: "ajax/administracionordenpago.ajax.php",
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


           document.getElementById('table-moto-anios-or').innerHTML = data.data;
          document.getElementById('pagina_total_or').innerHTML = data.pagination;  
          

        

      },
    });

  }

  
  

  


   //MOSTRAR ORDEN DE PAGO
    VerOrdenPago(concatenadoid,total,totaltim,importe,gasto) {

      let datos = new FormData();
      // datos.append("carpeta", predio.carpeta);
      // datos.append("propietarios",predio.Propietarios);

      // datos.append("tipo_tributo", this.tipo_tributo_orden);
      // datos.append("anio", this.anio_orden);
  
      datos.append("gasto", gasto);
      datos.append("importe", importe);
      datos.append("tim", totaltim);
      datos.append("total", total);

      datos.append("concatenadoId",concatenadoid);

      for (let pair of datos.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }


     // if(this.tipo_tributo_orden==='006'){
      $.ajax({
          url: "./vistas/print/imprimirOrdenPagoHistorialAdmi.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          // beforeSend: function() {
          //   $(".cargando").html(loadingMessage_s);
          //   $("#modal_cargar").modal("show");
          // },
          success: function(rutaArchivo) {

            console.log("estas aquiiiiiiiiiiiiiiiiiiiiii",rutaArchivo);
             $("#modal_cargar").modal("hide");
             document.getElementById("iframe_orden_pago_a").src = 'vistas/print/' + rutaArchivo;
            $("#Modal_Orden_Pago_a").modal("show");

          },
          error: function() {
              $("#modal_cargar").text("Error al cargar el archivo.");
          }


      });
  //  }


    // else{
    //   $.ajax({
    //     url: "./vistas/print/imprimirDeterminacion.php",
    //     method: "POST",
    //     data: datos,
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     beforeSend: function() {
    //       $(".cargando").html(loadingMessage_s);
    //       $("#modal_cargar").modal("show");
    //     },
    //     success: function(rutaArchivo) {
    //       $("#modal_cargar").modal("hide");
    //         document.getElementById("iframe_orden_pago").src = 'vistas/print/' + rutaArchivo;
    //         $("#Modal_Orden_Pago").modal("show");
    //     },
    //     error: function() {
    //         $("#modal_cargar").text("Error al cargar el archivo.");
    //     }
    // });
    // }
  }

  //VER ENVIAR A COACTIVO

  
  EditarAdministracionOrdenPagoEnviarCoactivo(idContribueynte){

    let datos = new FormData();

    datos.append("idContribueynte", idContribueynte);  // Agregar filtro de nombre
    datos.append("editar_enviar_coactivo", "editar_enviar_coactivo");
   
    $.ajax({
      type: "POST", 
      url: "ajax/administracionordenpago.ajax.php",
       data: datos,
        cache: false,
        contentType: false,
        processData: false,
      success: function (respuesta) {

        console.log(respuesta);

         if (typeof respuesta === "string") {
            respuesta = JSON.parse(respuesta);
            }

        if (respuesta.data && respuesta.data.length > 0) {
            // CORRECCIÓN: Acceder al primer elemento del array data
            var primerRegistro = respuesta.data[0];
            var expediente = primerRegistro.numero_informe;
            var coactivo = primerRegistro.coactivo;
          
            console.log("Datos encontrados:", primerRegistro);
            console.log("Expediente:", expediente);
            console.log("Coactivo:", coactivo);
            
            // Llenar los campos del modal
            $('#numeroImforme').val(expediente);  

            // Establecer el valor del select basado en coactivo
            if (coactivo === "0") {
                $('#estadoCoactivo').val("0");  
            } else if (coactivo === "1") {
                $('#estadoCoactivo').val("1");  
            } else {
                $('#estadoCoactivo').val("");  // Volver al estado inicial
            }
        }
      },
    });
  }


  //MOSTRAR EDITAR FECHA ORDEN COACTIUVO
   EditarAdministracionOrdenPagoFecha(idContribueynte){

    let datos = new FormData();

    datos.append("idContribueynte", idContribueynte);  // Agregar filtro de nombre
    datos.append("editar_notificacion", "editar_notificacion");
   
    $.ajax({
      type: "POST", 
      url: "ajax/administracionordenpago.ajax.php",
       data: datos,
        cache: false,
        contentType: false,
        processData: false,
      success: function (respuesta) {

        console.log(respuesta);

         if (typeof respuesta === "string") {
            respuesta = JSON.parse(respuesta);
            }

           if (respuesta.data && respuesta.data.length > 0) {

                var expediente = respuesta.fecha_notificacion;
               
                // Llenar los campos del modal
                $('#fechaNotificacionOrd').val(expediente);  
            }
      },
    });
  }

  
  //GUARDAR Y EDITAR FECHA DE ORDEN DE PAGO
   GuardarAdministracionCoactivoFecha(fechaNotificacion){

    console.log("paaaa actual", fechaNotificacion);

    let datos = new FormData();

    datos.append("idContribueyentes",this.idcontribuyente);
    datos.append("fechaNotificacion",fechaNotificacion);
    datos.append("guardar_orden_fecha_no", "guardar_orden_fecha_no");

       for (let pair of datos.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

   
    $.ajax({
      type: "POST", 
      url: "ajax/administracionordenpago.ajax.php",
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
          
          administracionOrdenPago_.lista_orden_pago('', '','',pagina_numero);

            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de respuesta después de 5 segundos
            }, 5000);

           $("#modalEditarFechaNotificacion").modal("hide");


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

  //GUARDAR Y EDITAR FECHA DE ORDEN DE PAGO
   GuardarAdministracionEnviarCoactivo(numeroImforme,estadoCoactivo , ordencompleta){

    let datos = new FormData();

    datos.append("idContribueyentes",this.idcontribuyente);
    
    datos.append("numeroImforme",numeroImforme);  
    datos.append("estadoCoactivo",estadoCoactivo);
    datos.append("ordencompleta",ordencompleta);


    datos.append("guardar_orden_en_coactivo", "guardar_orden_en_coactivo");

       for (let pair of datos.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

   
    $.ajax({
      type: "POST", 
      url: "ajax/administracionordenpago.ajax.php",
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
          
          administracionOrdenPago_.lista_orden_pago('', '','',1);

            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de respuesta después de 5 segundos
            }, 5000);

           $("#modalEditarOrdenPagoEnviarCoactivo").modal("hide");


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

const administracionOrdenPago_ = new AdministracionOrdenPago();


document.addEventListener('DOMContentLoaded', function () {

   administracionOrdenPago_.lista_orden_pago('','','',1);  // Mostrar página 1 por defecto
 
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
      
        administracionOrdenPago_.lista_orden_pago(nombre,op, ex,1,resultados_por_pagina.value);  // Resetear a la página 1
    });

     // Detectar cambios en el campo op
    numeroop.addEventListener('input', function () {
        const nombre = nombreField.value;
        const op = numeroop.value;
        const ex = numeroex.value;
      
        administracionOrdenPago_.lista_orden_pago(nombre, op,ex, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });

     // Detectar cambios en el campo expdiente
      numeroex.addEventListener('input', function () {
        const nombre = nombreField.value;
        const op = numeroop.value;
        const ex = numeroex.value;
      
        administracionOrdenPago_.lista_orden_pago(nombre, op,ex, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });


  
     // Detectar cambios en el campo de estado para filtrar por estado
        resultados_por_pagina.addEventListener('change', function () {
            console.log("llego aqui---");
        const nombre = nombreField.value;
        const op = numeroop.value;
        const ex = numeroex.value;
        administracionOrdenPago_.lista_orden_pago(nombre,op,ex,  1,resultados_por_pagina.value);  // Resetear a la página 1
    });


});



//VER ADMINISTRACION DE COACTIVO
$(document).on("click", ".btnVerAdministracionOrdenPago", function () {

    const idcontribuyente = $(this).data("idcontribuyente");
    

    administracionOrdenPago_.idcontribuyente = idcontribuyente;

    administracionOrdenPago_.MostrarAdministracionCoactivo(administracionOrdenPago_.idcontribuyente);
});


// VER fecha orden pago
$(document).on("click", ".btnEditarAdministracionOrdenPagoFe", function () {
   const cocatenadoid = $(this).data("idcoactivo");

    console.log("para editar -----------", cocatenadoid);

    administracionOrdenPago_.idcontribuyente = cocatenadoid;
    administracionOrdenPago_.EditarAdministracionOrdenPagoFecha(administracionOrdenPago_.idcontribuyente);

});

 
//GUARDAR FECHA DE NOTIFICACION DE ORDEN DE PAGO
$(document).on("click", ".btnGuadarOrdenPagoFecha", function () {
    var fechaNotificacion = $('#fechaNotificacionOrd').val(); // usar el id correcto
    administracionOrdenPago_.GuardarAdministracionCoactivoFecha(fechaNotificacion);
});


// VER ENVIAR A COACTIVO
$(document).on("click", ".btnEditarAdministracionEnviarCoactivo", function () {
   const cocatenadoid = $(this).data("idcoactivo");
    const ordencompleta = $(this).data("ordencompleta");

    administracionOrdenPago_.idcontribuyente = cocatenadoid;
    administracionOrdenPago_.ordencompleta = ordencompleta;
    administracionOrdenPago_.EditarAdministracionOrdenPagoEnviarCoactivo(administracionOrdenPago_.idcontribuyente);

});

//GUARDAR FECHA DE NOTIFICACION DE ORDEN DE PAGO
$(document).on("click", ".btnGuadarEnviarCoactivo", function () {
    var numeroImforme = $('#numeroImforme').val(); // usar el id correcto
    var estadoCoactivo = $('#estadoCoactivo').val(); // usar el id correcto

    administracionOrdenPago_.GuardarAdministracionEnviarCoactivo(numeroImforme,estadoCoactivo, administracionOrdenPago_.ordencompleta );


});




//VER EDITAR ADMINISTRACION COACTIVO
$(document).on("click", ".btnEditarAdministracionInforma", function () {

    const idcoactivo = $(this).data("cocatenadoid");

    console.log("para editare-----------",idcoactivo);

    // administracionOrdenPago_.idcoactivo = idcoactivo;
    // administracionOrdenPago_.EditarAdministracionCoactivo(administracionOrdenPago_.idcoactivo);
});








//REGISTRAR EL NUMERO DE EXPEDIENTE



$(document).on("click", ".btnAdministracionOrdenPago", function () {
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


//MOSATRAR ORDEN DE COMPRA
$(document).on("click", ".mostrar-btn-admi", function () {
 // $('#modalImprimir_ordenpago_si_no').modal('hide');
 // Obtener el valor de la opción seleccionada
 
    let concatenadoid = $(this).data("cocatenadoid");  
    let total = $(this).data("total");  
    let totaltim = $(this).data("totaltim");  
    let importe = $(this).data("importe");  
    let gasto = $(this).data("gasto");  

    administracionOrdenPago_.VerOrdenPago(concatenadoid,total,totaltim,importe,gasto );


});


//CERRAR EL JFRAME DE ORDEN DE PAGO
$(document).on("click", ".cerrar-modal_a", function () {
  // Cerrar el modal de orden de pago
  $('#Modal_Orden_Pago_a').modal('hide'); // Cierra el modal
  // Ejecutar la función de imprimir orden
 // orden_pago.ordenes_pago();

});



