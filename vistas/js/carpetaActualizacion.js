
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


$(document).on("click", "#popimprimir_reporte_actualizacion", async function () {
  const cuerpoTabla = document.getElementById("bodyReporteActualizacion");
  const filas = cuerpoTabla.getElementsByTagName("tr");

  const encabezado = document.getElementById("tbReporteIngresosDiarios").getElementsByTagName("thead")[0].rows[0];

  // Crear workbook y worksheet
  const workbook = new ExcelJS.Workbook();
  const worksheet = workbook.addWorksheet("Reporte de Actualización");

  // Definir columnas con ancho fijo
  worksheet.columns = [
    { header: 'Codigo Carpeta', key: 'codigo', width: 7 },
    { header: 'Estado', key: 'estado', width: 12 },
    { header: 'Oficina', key: 'oficina', width: 10 },
    { header: 'Campo', key: 'campo', width: 10 },
    { header: 'Obs. pendiente', key: 'encampo1', width: 24 },
    { header: 'Obs. progreso', key: 'encampo2', width: 24 },
    { header: 'Fecha Actualización', key: 'fechaActualizacion', width: 18 },
    { header: 'Resposable', key: 'actualizadoPor', width: 18 },
  ];

  // Agregar encabezado con estilo
  const headerRow = worksheet.getRow(1);
  headerRow.eachCell((cell) => {
    cell.font = { bold: true, color: { argb: 'FFFFFFFF' } }; // texto blanco
    cell.fill = {
      type: 'pattern',
      pattern: 'solid',
      fgColor: { argb: 'FF1F4E78' } // fondo azul
    };
    cell.alignment = { vertical: 'middle', horizontal: 'center' };
    cell.border = {
      top: { style: 'thin' },
      left: { style: 'thin' },
      bottom: { style: 'thin' },
      right: { style: 'thin' },
    };
  });

  // Agregar datos
  for (let i = 0; i < filas.length; i++) {
    const row = filas[i];
    const cells = row.getElementsByTagName("td");
    const rowData = [];
    for (let j = 0; j < cells.length; j++) {
      rowData.push(cells[j].innerText);
    }
    const dataRow = worksheet.addRow(rowData);

    // Estilo de filas
    dataRow.eachCell((cell) => {
      cell.alignment = { vertical: 'middle', horizontal: 'center' };
      cell.border = {
        top: { style: 'thin' },
        left: { style: 'thin' },
        bottom: { style: 'thin' },
        right: { style: 'thin' },
      };
    });
  }

  // Descargar Excel
  const buffer = await workbook.xlsx.writeBuffer();
  const blob = new Blob([buffer], { type: 'application/octet-stream' });
  saveAs(blob, "Reporte_Actualizacion.xlsx");
});



// $(document).on("click", "#popimprimir_reporte_actualizacion", async function () {
//   const cuerpoTabla = document.getElementById("bodyReporteActualizacion");
//   const filas = cuerpoTabla.getElementsByTagName("tr");

//   const encabezado = document.getElementById("tbReporteIngresosDiarios").getElementsByTagName("thead")[0].rows[0];

//   // Crear un nuevo workbook
//   const workbook = new ExcelJS.Workbook();
//   const worksheet = workbook.addWorksheet("Reporte de Actualización");

//   // Encabezado
//   const rowHeader = [];
//   for (let i = 0; i < encabezado.cells.length; i++) {
//     rowHeader.push(encabezado.cells[i].innerText);
//   }
//   const headerRow = worksheet.addRow(rowHeader);

//   // Estilos del encabezado
//   headerRow.eachCell((cell) => {
//     cell.font = { bold: true, color: { argb: "FFFFFFFF" } }; // Texto blanco
//     cell.fill = {
//       type: "pattern",
//       pattern: "solid",
//       fgColor: { argb: "FF1F4E78" }, // Fondo azul elegante
//     };
//     cell.alignment = { vertical: "middle", horizontal: "center" };
//     cell.border = {
//       top: { style: "thin" },
//       left: { style: "thin" },
//       bottom: { style: "thin" },
//       right: { style: "thin" },
//     };
//   });

//   // Datos
//   for (let i = 0; i < filas.length; i++) {
//     const row = filas[i];
//     const cells = row.getElementsByTagName("td");
//     const rowData = [];
//     for (let j = 0; j < cells.length; j++) {
//       rowData.push(cells[j].innerText);
//     }
//     const dataRow = worksheet.addRow(rowData);

//     // Bordes para cada celda
//     dataRow.eachCell((cell) => {
//       cell.border = {
//         top: { style: "thin" },
//         left: { style: "thin" },
//         bottom: { style: "thin" },
//         right: { style: "thin" },
//       };
//     });
//   }

//   // Ajustar ancho de columnas automáticamente
//   worksheet.columns.forEach((column) => {
//     let maxLength = 0;
//     column.eachCell({ includeEmpty: true }, (cell) => {
//       const columnLength = cell.value ? cell.value.toString().length : 10;
//       if (columnLength > maxLength) maxLength = columnLength;
//     });
//     column.width = maxLength + 5;
//   });

//   // Descargar Excel
//   const buffer = await workbook.xlsx.writeBuffer();
//   const blob = new Blob([buffer], { type: "application/octet-stream" });
//   saveAs(blob, "Reporte_Actualizacion.xlsx");
// });




// $(document).on("click", "#popimprimir_reporte_actualizacion", function () {
//   // Obtener el cuerpo de la tabla (donde están los datos)
//   const cuerpoTabla = document.getElementById("bodyReporteActualizacion");
//   const filas = cuerpoTabla.getElementsByTagName("tr");

//   // Crear un array para almacenar las filas de la tabla
//   const rows = [];

//   // Obtener los encabezados de la tabla
//   const encabezado = document.getElementById("tbReporteIngresosDiarios").getElementsByTagName("thead")[0].rows[0];
//   const rowHeader = [];

//   // Obtener los datos de cada celda del encabezado (los `th`)
//   for (let i = 0; i < encabezado.cells.length; i++) {
//     rowHeader.push(encabezado.cells[i].innerText);  // Usamos innerText para obtener el contenido de las celdas
//   }

//   // Agregar los encabezados al array de filas
//   rows.push(rowHeader);

//   // Iterar sobre las filas de datos (tbody)
//   for (let i = 0; i < filas.length; i++) {
//     const row = filas[i];
//     const cells = row.getElementsByTagName("td");
//     const rowData = [];

//     // Obtener los datos de cada celda y agregarla al array de la fila
//     for (let j = 0; j < cells.length; j++) {
//       rowData.push(cells[j].innerText);  // Usamos innerText para obtener el contenido de las celdas
//     }

//     // Agregar la fila al array
//     rows.push(rowData);
//   }

//   // Crear una hoja de Excel a partir de las filas obtenidas (encabezado + datos)
//   const ws = XLSX.utils.aoa_to_sheet(rows);

//   // Crear un libro de Excel con la hoja creada
//   const wb = XLSX.utils.book_new();
//   XLSX.utils.book_append_sheet(wb, ws, "Reporte de Actualización");

//   // Descargar el archivo Excel
//   XLSX.writeFile(wb, "Reporte_Actualizacion.xlsx");
// });

