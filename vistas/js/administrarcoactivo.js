class AdministracionCoactivo {

  constructor() {
    
        this.idCatastroC_consulta_agua = null;
        this.ubiLicenciaC_consulta_agua = null;
        this.codCatastroC_consulta_agua=null;
        this.idlicenciaagua=null; 
        this.totalImporte = 0;
        this.totalGasto = 0;
        this.totalSubtotal = 0;
        this.totalTIM = 0;
        this.totalTotal = 0;
        this.idsSeleccionados = [];
        this.anio=null;
        this.totalCuotas=null;
        this.idlicenciaaguap=null;
        this.idcontribuyente=null;
        this.valorTotalMo=null;
  }



  lista_coactivo(filtro_nombre = '', filtro_fecha = '', filtro_estado = 'todos', pagina = 1,resultados_por_pagina='15') {
    let datos = new FormData();
    datos.append("lista_coactivo", "lista_coactivo");
    datos.append("filtro_nombre", filtro_nombre);  // Agregar filtro de nombre
    datos.append("filtro_fecha", filtro_fecha);    // Agregar filtro de fecha
    datos.append("filtro_estado", filtro_estado);  // Agregar filtro de estado
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
            console.log("Respuesta recibida:", respuesta);

            // Verifica si la respuesta comienza con "<tr" (lo que indica que es HTML)
            if (respuesta.startsWith('<tr')) {
                // Si es HTML, simplemente actualiza el contenido sin parsear
                document.getElementById('lista_de_coactivo').innerHTML = respuesta;
            } else {
                // Si es JSON, parsea y maneja como JSON
                let data;
                try {
                    data = JSON.parse(respuesta);
                    document.getElementById('lista_de_coactivo').innerHTML = data.data;
                } catch (e) {
                    console.log("No se pudo parsear la respuesta:", e);
                    console.log("Respuesta cruda:", respuesta);
                }
            }
        }

    });
}


  //VERA AGUA
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

       console.log("Respuesta del servidor para mostrar estado de cuenta:", respuesta); // Verifica la respuesta del servidor

     $("#table-moto-anios").html(respuesta);

;

      },
    });

  }

}

const administracionCoactivo_ = new AdministracionCoactivo();


document.addEventListener('DOMContentLoaded', function () {
   administracionCoactivo_.lista_coactivo('', '', 'todos', 1);  // Mostrar página 1 por defecto
    
    // Detectar cambios en los campos de filtro (nombre, fecha, estado)
    const nombreField = document.querySelector('#filtrar_nombre');
    const fechaField = document.querySelector('#fecha_notificacion');
    const estadoField = document.querySelector('#filtrar_estado'); // Campo de estado
     const resultados_por_pagina = document.querySelector('#resultados_por_pagina'); // Campo de estado

    // Detectar cambios en el campo de texto para filtrar por nombre
    nombreField.addEventListener('input', function () {
        const nombre = nombreField.value;
        const fecha = fechaField.value; // Capturar la fecha seleccionada
        const estado = estadoField.value; // Capturar el estado sflista_notificacioneleccionado
        administracionCoactivo_.lista_coactivo(nombre, fecha, estado, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });

    // Detectar cambios en el campo de fecha para filtrar por fecha
    fechaField.addEventListener('change', function () {
        const fecha = fechaField.value;
        const nombre = nombreField.value;
        const estado = estadoField.value;
        administracionCoactivo_.lista_coactivo(nombre, fecha, estado, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });

    // Detectar cambios en el campo de estado para filtrar por estado
    estadoField.addEventListener('change', function () {
        const estado = estadoField.value;
        const nombre = nombreField.value;
        const fecha = fechaField.value;
        administracionCoactivo_.lista_coactivo(nombre, fecha, estado, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });

     // Detectar cambios en el campo de estado para filtrar por estado
    resultados_por_pagina.addEventListener('change', function () {
        const estado = estadoField.value;
        const nombre = nombreField.value;
        const fecha = fechaField.value;
        administracionCoactivo_.lista_coactivo(nombre, fecha, estado, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });


});

//VER ADMINISTRACION DE COACTIVO
$(document).on("click", ".btnVerAdministracionCoactivo", function () {

    const idcontribuyente = $(this).data("idcontribuyente");

    administracionCoactivo_.idcontribuyente = idcontribuyente;
    administracionCoactivo_.MostrarAdministracionCoactivo(administracionCoactivo_.idcontribuyente);
});






