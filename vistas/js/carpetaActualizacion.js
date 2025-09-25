
class ActualizacionCarpetaClass {
  constructor() {
    this.nombrefiltro = null;
    this.estadofiltro = null;

  }

}

const carpetaActualizacion_ = new ActualizacionCarpetaClass();

/*===================================ACTUALIZACION DE CARPETA ======================*/
$(document).on("click", "#btnConsultarReporteAct", function () {

  // Recoger los filtros de los inputs
  carpetaActualizacion_.nombrefiltro = $("#id_usuario_act").val();
  carpetaActualizacion_.estadofiltro = $("#estado_act").val();

  // Mostrar el spinner de carga
  $("#modalCargando").modal('show');  // Muestra el modal con el spinner

  // Limpiar la tabla antes de cargar los nuevos datos
  const cuerpoTabla = document.getElementById("bodyReporteActualizacion");
  const filas = cuerpoTabla.getElementsByTagName("tr");

  while (filas.length > 0) {
    cuerpoTabla.deleteRow(0); // Elimina la primera fila de la tabla
  }

  let datos = new FormData();
  datos.append("idUsuarioFiltro", carpetaActualizacion_.nombrefiltro);
  datos.append("estadoFiltro", carpetaActualizacion_.estadofiltro);
  datos.append("reporteActualizacion", "reporteActualizacion");

  // Usamos Fetch en lugar de AJAX
  fetch("ajax/reporteActualizacion.ajax.php", {
    method: "POST",
    body: datos,
  })
  .then(response => response.text())  // Convertimos la respuesta a texto
  .then(respuesta => {
    // Rellenar la tabla con los datos recibidos
    cuerpoTabla.innerHTML = respuesta;

    // Ocultar el spinner de carga
    $("#modalCargando").modal('hide');  // Oculta el modal con el spinner
  })
  .catch(error => {
    // Si ocurre un error, ocultamos el spinner y mostramos un mensaje de error
    $("#modalCargando").modal('hide');  // Oculta el modal con el spinner
    alert("Hubo un error al cargar los datos.");
  });

});


$(document).on("click", "#popimprimir_reporte_actualizacion", function () {
  // Obtener el cuerpo de la tabla (donde están los datos)
  const cuerpoTabla = document.getElementById("bodyReporteActualizacion");
  const filas = cuerpoTabla.getElementsByTagName("tr");

  // Crear un array para almacenar las filas de la tabla
  const rows = [];

  // Obtener los encabezados de la tabla
  const encabezado = document.getElementById("tbReporteIngresosDiarios").getElementsByTagName("thead")[0].rows[0];
  const rowHeader = [];

  // Obtener los datos de cada celda del encabezado (los `th`)
  for (let i = 0; i < encabezado.cells.length; i++) {
    rowHeader.push(encabezado.cells[i].innerText);  // Usamos innerText para obtener el contenido de las celdas
  }

  // Agregar los encabezados al array de filas
  rows.push(rowHeader);

  // Iterar sobre las filas de datos (tbody)
  for (let i = 0; i < filas.length; i++) {
    const row = filas[i];
    const cells = row.getElementsByTagName("td");
    const rowData = [];

    // Obtener los datos de cada celda y agregarla al array de la fila
    for (let j = 0; j < cells.length; j++) {
      rowData.push(cells[j].innerText);  // Usamos innerText para obtener el contenido de las celdas
    }

    // Agregar la fila al array
    rows.push(rowData);
  }

  // Crear una hoja de Excel a partir de las filas obtenidas (encabezado + datos)
  const ws = XLSX.utils.aoa_to_sheet(rows);

  // Crear un libro de Excel con la hoja creada
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Reporte de Actualización");

  // Descargar el archivo Excel
  XLSX.writeFile(wb, "Reporte_Actualizacion.xlsx");
});


// $(document).on("click", "#popimprimir_reporte_actualizacion", function () {
//   // Obtener el cuerpo de la tabla (se asume que ya tienes la tabla cargada con los encabezados)
//   const cuerpoTabla = document.getElementById("bodyReporteActualizacion");
//   const filas = cuerpoTabla.getElementsByTagName("tr");

//   // Crear un array para almacenar las filas de la tabla
//   const rows = [];

//   // Iterar sobre las filas de la tabla (solo el encabezado)
//   for (let i = 0; i < filas.length; i++) {
//     const row = filas[i];
//     const cells = row.getElementsByTagName("td");
//     const rowData = [];
    
//     // Obtener los datos de cada celda y agregarla al array de la fila
//     for (let j = 0; j < cells.length; j++) {
//       rowData.push(cells[j].innerText);  // Usamos innerText para obtener el contenido de la celda
//     }
    
//     // Agregar la fila al array
//     rows.push(rowData);
//   }

//   // Crear una hoja de Excel a partir de las filas obtenidas (solo encabezado)
//   const ws = XLSX.utils.aoa_to_sheet(rows);

//   // Crear un libro de Excel con la hoja creada
//   const wb = XLSX.utils.book_new();
//   XLSX.utils.book_append_sheet(wb, ws, "Reporte de Actualización");

//   // Descargar el archivo Excel
//   XLSX.writeFile(wb, "Reporte_Actualizacion_Encabezado.xlsx");
// });
