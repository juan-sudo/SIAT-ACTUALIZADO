class ReporteGeneralAreaClass {
  constructor() {
    this.fechaFiltroInicio = null;
    this.fechaFiltroFin = null;
    this.total = null;
  }
}
let datosProveidoExportar = {
  etiquetas: [],
  cantidades: [],
  total: 0
};
const reporteGeneralArea_ = new ReporteGeneralAreaClass();

// Gráficos separados
let chartTributaria = null;
let chartTributariaProveido = null;
let chartAgua = null;

// Función para obtener especies valoradas por gerencia
function obtenerEspeciesValoradas(gerenciaSubgerencia) {
  const especiesMap = {
    "3": "13,22,25,28,39,40,41,44,45,46,47,48,50,51,52,53,54,56,177,199,201,202,203,204,205,250,515,529,540,541,542,543,544,545,546,547,642,715",
    "4": "8,10,12,15,18,21,24,27,30,33,35,37,169,170,171,173,174,175,176,240,242,520,521,522,524,525,526,528,530,531,532,536,537,761,765,770",
    "5": "514,771,772,773,774",
    "6": "105,119,121,220,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399,400,401,402,403,404,405,406,407,408,409,410,411,412,413,414,415,416,417,418,419,425,426,428,548,549,550,551,552,553,554,555,556,557,558,559,560,561,562,563,564,565,566,567,568,569,570,571,572,573,574,575,576,577,578,579,580,581,582,583,584,585,586,587,588,589,590,591,592",
    "7": "445,446,447,448,449,450,451,452,453,454,455,456,457,458,459,460,461,462,463,464,465,466,467,468,469,470,471,472,473,474,475,476,477,478,479,480,481,482,483,484,485,486,533,766",
    "11": "348,349,350,351,352,353,354,355,356,357,358,359,360",
    "18": "1,2,3,4,5,6,196,197,487,488,489,490,491,492,493,494,495,496,497,498,499,500,501,502,534",
    "22": "38,57,58,59,60,61,206,207,208,209,210,211,212,213,214",
    "23": "194,195",
    "24": "16,19,31,34,36,42,43,200,512,513",
    "25": "535",
    "26": "523,768",
    "27": "269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343",
    "28": "344,345,346,347",
    "29": "62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,106,107,108,109,110,111,112,113,114,115,116,117,118,120,122,123,129,130,131,132,133,134,135,136,137,215,216,217,218,219,361,362,363,364,365,366,367,516,517,518,519,596,704,705,763",
    "30": "124,125,126,128,420,421,422,423,424,427,429,430,695",
    "31": "7,9,11,14,17,20,23,26,29,32,198",
    "32": "127,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,221,222,223,224,225,226,227,228,229,230,706,714",
    "33": "178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,231,232,233,234,235,236,237,238,239,241,243,244,245,246,247,248,503,504,505,506,507,508,509,510,511,527,710,711",
    "34": "249,259,260,431,432,433,434,435,436,437,438,439,440,441,442,443,444",
    "35": "172,538,539",
    "37": "738,739,740,741,742,743,744,745,746,747,748,749,750,751,752,753,754,755,756,757,758,759,760",
    "38": "769"
  };
  
  return especiesMap[gerenciaSubgerencia] || "";
}

// Función para limpiar y preparar el contenedor de gráficos
function prepararContenedorGrafico(containerId, canvasId) {
  const container = $(`#${containerId}`);
  
  // Limpiar el contenedor completamente
  container.empty();
  
  // Crear un nuevo canvas
  container.append(`<canvas id="${canvasId}"></canvas>`);
  
  // Aplicar estilos básicos
  container.css({
    width: "100%",
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
    padding: "0",
    margin: "0"
  });
  
  return $(`#${canvasId}`)[0];
}

// Función genérica para cargar gráficos
function generarGrafico({ tipoReporte, canvasId, label, color, totalId, fechaInicio, fechaFin, gerenciaSubgerencia }) {
  reporteGeneralArea_.fechaFiltroInicio = fechaInicio;
  reporteGeneralArea_.fechaFiltroFin = fechaFin;

  if (!fechaInicio || !fechaFin || !gerenciaSubgerencia) {
    alert('Por favor seleccione las fechas de inicio y fin, y la gerencia.');
    return;
  }

  const especiesValoradas = obtenerEspeciesValoradas(gerenciaSubgerencia);
  
  if (!especiesValoradas) {
    alert('No se encontraron especies valoradas para la gerencia seleccionada.');
    return;
  }

  const datos = new FormData();
  datos.append(tipoReporte, tipoReporte);
  datos.append("fechaInicio", fechaInicio);
  datos.append("fechaFin", fechaFin);
  datos.append("especiesValoradas", especiesValoradas);
  datos.append("idArea", gerenciaSubgerencia);

  // ✅ Imprimir todos los datos del FormData
  for (let [clave, valor] of datos.entries()) {
    console.log(`${clave}: ${valor}`);
  }

  const ctx = $(`#${canvasId}`)[0].getContext('2d');

  $.ajax({
    url: "ajax/reporteGeneralArea.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      console.log(`📊 Respuesta ${tipoReporte}:`, respuesta);

      let data = respuesta;
      let etiquetas = [];
      let cantidades = [];

      // 🟡 Gráfico horizontal para proveídos
      if (tipoReporte === "reporte_tributaria_proveido" && Array.isArray(data) && data.length > 0) {
       // etiquetas = data.map(item => item.Nombre_Especie);
       // cantidades = data.map(item => parseFloat(item.valor_total));

           etiquetas = data.map(item => item.Nombre_Especie);
          cantidades = data.map(item => parseFloat(item.valor_total));

          // ✅ Guardar datos para exportación a Excel
          datosProveidoExportar = {
            etiquetas: etiquetas,
            cantidades: cantidades,
            total: cantidades.reduce((a, b) => a + b, 0)
          };

        // ✅ Calcular total
        const total = cantidades.reduce((a, b) => a + b, 0).toLocaleString('es-PE', {
          style: 'currency',
          currency: 'PEN',
          minimumFractionDigits: 2
        });

        $(`#totalAdmTriPro`).text(`Monto total proveído: ${total}`);

        // ✅ Destruir gráfico anterior si existe
        if (chartTributariaProveido) chartTributariaProveido.destroy();

        // ✅ Resetear tamaño del canvas
        ctx.canvas.style.width = "100%";
        ctx.canvas.style.height = `${Math.max(500, data.length * 22)}px`;
        ctx.canvas.removeAttribute("width");
        ctx.canvas.removeAttribute("height");

        // ✅ Crear gráfico horizontal
        chartTributariaProveido = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: etiquetas,
            datasets: [{
              label: "Monto (S/)",
              data: cantidades,
              backgroundColor: color,
              borderColor: color,
              borderWidth: 1,
              barPercentage: 0.6
            }]
          },
          options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: 0 },
            scales: {
              x: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Monto (S/)',
                  color: '#333',
                  font: { size: 12, weight: 'bold' }
                },
                ticks: { color: '#000', font: { size: 13 } },
                grid: { drawBorder: true, drawOnChartArea: false }
              },
              y: {
                ticks: { autoSkip: false, color: '#000', font: { size: 12 }, padding: 4 },
                grid: { drawBorder: false, drawOnChartArea: false }
              }
            },
            plugins: {
              legend: { display: false },
              tooltip: {
                callbacks: {
                  label: (context) => `S/ ${parseFloat(context.raw).toLocaleString('es-PE', {
                    minimumFractionDigits: 2
                  })}`
                }
              },
              title: {
                display: true,
                text: 'Monto Proveído por Especie',
                font: { size: 15, weight: 'bold' },
                color: '#111'
              }
            }
          }
        });
        return;
      }

      // 🟦 Gráficos simples (barras verticales) para tributaria y agua
      if ((tipoReporte === "reporte_general_tributaria" || tipoReporte === "reporte_general_agua") && 
          Array.isArray(data) && data.length > 0) {

        

        console.log("Procesando reporte específico:", tipoReporte);

        if (data.length > 0 && data[0].length > 0 && data[0][0] !== null) {
          console.log("Data válida encontrada:", data);
          etiquetas.push(label);
          cantidades.push(parseFloat(data[0][0]));

          reporteGeneralArea_.total = cantidades[0].toLocaleString('es-PE', {
            style: 'currency',
            currency: 'PEN',
            minimumFractionDigits: 2
          });

          console.log("total--prueba", reporteGeneralArea_.total);
          $(`#${totalId}`).text(`${label}: ${reporteGeneralArea_.total}`);
        } else {
          console.log("No se encontraron datos válidos.");
          $(`#${totalId}`).text(`${label}: S/ 0.00`);
          return;
        }

        // Destruir gráficos anteriores
        if (tipoReporte === "reporte_general_tributaria" && chartTributaria) chartTributaria.destroy();
        if (tipoReporte === "reporte_general_agua" && chartAgua) chartAgua.destroy();

        // Configurar tamaño del canvas
        ctx.canvas.height = 460;
        ctx.canvas.width = 200;

        // Aplicar clases CSS
        $(`#${canvasId}`).parent().addClass("chart-container-centered");
        $(ctx.canvas).addClass("fixed-size-chart");

        const nuevoChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: etiquetas,
            datasets: [{
              label: label,
              data: cantidades,
              backgroundColor: [color],
              borderColor: [color],
              borderWidth: 1,
              barPercentage: 0.4,
              categoryPercentage: 0.5
            }]
          },
          options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
              y: {
                beginAtZero: true,
                title: { display: true, text: 'Monto (S/)' }
              }
            },
            plugins: {
              legend: { display: true },
              tooltip: {
                callbacks: {
                  label: (context) => `${context.dataset.label}: ${context.formattedValue}`
                }
              }
            }
          }
        });

        // Asignar a la variable global correspondiente
        if (tipoReporte === "reporte_general_tributaria") chartTributaria = nuevoChart;
        if (tipoReporte === "reporte_general_agua") chartAgua = nuevoChart;
      } else {
        $(`#${totalId}`).text(`${label}: No disponible`);
      }
    },
    error: function (xhr, status, error) {
      console.error(`❌ Error en la solicitud AJAX (${tipoReporte}):`, error);
      alert(`Error al cargar el gráfico: ${error}`);
    }
  });
}


$(document).ready(function () {
  $('#btnConsultarReporteArea').on('click', function () {
    console.log("Botón 'Consultar Reporte' clickeado");

    const fechaInicio = $('#fechaInicioAreaRe').val();
    const fechaFin = $('#fechaFinAreaRe').val();
    const gerenciaSubgerencia = $('#gerenciaSubgerencia').val();

    if (!fechaInicio || !fechaFin || !gerenciaSubgerencia) {
      alert('Por favor seleccione las fechas de inicio y fin, y la gerencia.');
      return;
    }

    // 🔹 Obtener contenedores
    const containerTributaria = $("#myChartAdmTri").parent().parent(); // El div con class="table-responsive col-md-3"
    const containerProveido = $("#myChartAdmTriProveido").parent().parent(); // El div con class="div-background col-md-9"

    // Preparar contenedor del gráfico de proveído
    const canvasProveido = prepararContenedorGrafico($("#myChartAdmTriProveido").parent().attr('id'), "myChartAdmTriProveido");

    // 🟡 SIEMPRE generar gráfico horizontal con scroll (Monto Proveído por Especie)
    generarGrafico({
      tipoReporte: "reporte_tributaria_proveido",
      canvasId: "myChartAdmTriProveido",
      label: "Total Proveído",
      color: "rgb(23, 191, 172)",
      totalId: "totalAdmTriPro",
      fechaInicio: fechaInicio,
      fechaFin: fechaFin,
      gerenciaSubgerencia: gerenciaSubgerencia
    });

    // 🔹 Generar gráfico específico por gerencia
    if (gerenciaSubgerencia === "3" || gerenciaSubgerencia === "32") {
      // Mostrar ambos contenedores
      containerTributaria.show().removeClass("col-12").addClass("col-md-3");
      containerProveido.show().removeClass("col-12").addClass("col-md-9");
      
      // Preparar contenedor para el gráfico específico
      const canvasContainer = $("#myChartAdmTri").parent();
      canvasContainer.empty();
      canvasContainer.append('<canvas id="myChartAdmTri"></canvas>');
      
      const tipoReporte = gerenciaSubgerencia === "3" ? "reporte_general_tributaria" : "reporte_general_agua";
      const label = gerenciaSubgerencia === "3" ? "Total Autovaluo" : "Total Agua";
      const color = gerenciaSubgerencia === "3" ? "rgb(245, 211, 42)" : "rgb(54, 162, 235)";
      const totalId = gerenciaSubgerencia === "3" ? "totalAdmTri" : "totalAgua";

      generarGrafico({
        tipoReporte: tipoReporte,
        canvasId: "myChartAdmTri",
        label: label,
        color: color,
        totalId: totalId,
        fechaInicio: fechaInicio,
        fechaFin: fechaFin,
        gerenciaSubgerencia: gerenciaSubgerencia
      });
    } else {
      reporteGeneralArea_.total = null;
      
      // Ocultar el contenedor del gráfico específico y expandir el de proveído
      containerTributaria.hide();
      containerProveido.removeClass("col-md-9").addClass("col-12");
      
      $(`#totalAdmTri`).text("");
    }
  });
});


//GENERAR EXCEL
// Función para exportar a Excel con estilos elegantes
async function descargarExcel() {
  try {
    // Obtener datos del formulario
    const fechaInicio = $('#fechaInicioAreaRe').val();
    const fechaFin = $('#fechaFinAreaRe').val();
    const gerenciaSubgerencia = $('#gerenciaSubgerencia').val();
    const gerenciaText = $('#gerenciaSubgerencia option:selected').text();

    // Crear un nuevo libro de trabajo
    const workbook = new ExcelJS.Workbook();
    workbook.creator = 'Sistema de Reportes';
    workbook.created = new Date();

    // Crear hoja de trabajo
    const worksheet = workbook.addWorksheet('Montos Proveídos');

    // ESTILOS DEFINIDOS
    const styles = {
      header: {
        fill: {
          type: 'pattern',
          pattern: 'solid',
          fgColor: { argb: 'FF2E86AB' } // Azul elegante
        },
        font: {
          name: 'Arial',
          size: 14,
          bold: true,
          color: { argb: 'FFFFFFFF' } // Blanco
        },
        alignment: { 
          horizontal: 'center',
          vertical: 'middle'
        },
        border: {
          top: { style: 'thin', color: { argb: 'FF1B5E7F' } },
          left: { style: 'thin', color: { argb: 'FF1B5E7F' } },
          bottom: { style: 'thin', color: { argb: 'FF1B5E7F' } },
          right: { style: 'thin', color: { argb: 'FF1B5E7F' } }
        }
      },
      subHeader: {
        fill: {
          type: 'pattern',
          pattern: 'solid',
          fgColor: { argb: 'FFA3D1E6' } // Azul claro
        },
        font: {
          name: 'Arial',
          size: 11,
          bold: true,
          color: { argb: 'FF000000' } // Negro
        },
        border: {
          top: { style: 'thin', color: { argb: 'FF7FB3D5' } },
          left: { style: 'thin', color: { argb: 'FF7FB3D5' } },
          bottom: { style: 'thin', color: { argb: 'FF7FB3D5' } },
          right: { style: 'thin', color: { argb: 'FF7FB3D5' } }
        }
      },
      dataHeader: {
        fill: {
          type: 'pattern',
          pattern: 'solid',
          fgColor: { argb: 'FF4CAF50' } // Verde elegante
        },
        font: {
          name: 'Arial',
          size: 12,
          bold: true,
          color: { argb: 'FFFFFFFF' } // Blanco
        },
        alignment: { 
          horizontal: 'center',
          vertical: 'middle'
        },
        border: {
          top: { style: 'thin', color: { argb: 'FF388E3C' } },
          left: { style: 'thin', color: { argb: 'FF388E3C' } },
          bottom: { style: 'thin', color: { argb: 'FF388E3C' } },
          right: { style: 'thin', color: { argb: 'FF388E3C' } }
        }
      },
      dataRow: {
        font: {
          name: 'Arial',
          size: 10
        },
        border: {
          top: { style: 'thin', color: { argb: 'FFE0E0E0' } },
          left: { style: 'thin', color: { argb: 'FFE0E0E0' } },
          bottom: { style: 'thin', color: { argb: 'FFE0E0E0' } },
          right: { style: 'thin', color: { argb: 'FFE0E0E0' } }
        }
      },
      totalRow: {
        fill: {
          type: 'pattern',
          pattern: 'solid',
          fgColor: { argb: 'FFFF9800' } // Naranja
        },
        font: {
          name: 'Arial',
          size: 12,
          bold: true,
          color: { argb: 'FFFFFFFF' } // Blanco
        },
        border: {
          top: { style: 'thin', color: { argb: 'FFF57C00' } },
          left: { style: 'thin', color: { argb: 'FFF57C00' } },
          bottom: { style: 'thin', color: { argb: 'FFF57C00' } },
          right: { style: 'thin', color: { argb: 'FFF57C00' } }
        }
      }
    };

    // TÍTULO PRINCIPAL
    const titleRow = worksheet.addRow(['REPORTE DE MONTOS PROVEÍDOS']);
    titleRow.height = 25;
    worksheet.mergeCells('A1:B1');
    worksheet.getCell('A1').style = styles.header;

    // METADATOS
    worksheet.addRow(['Gerencia/Subgerencia:', gerenciaText]);
    worksheet.addRow(['Período:', `${fechaInicio} al ${fechaFin}`]);
    worksheet.addRow(['Fecha de exportación:', new Date().toLocaleDateString()]);
    
    // Aplicar estilos a metadatos
    for (let i = 2; i <= 4; i++) {
      worksheet.getCell(`A${i}`).style = styles.subHeader;
      worksheet.getCell(`B${i}`).style = {
        ...styles.subHeader,
        fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FFE8F4FD' } }
      };
    }

    // FILA EN BLANCO
    worksheet.addRow([]);

    // ENCABEZADOS DE COLUMNAS
    const headersRow = worksheet.addRow(['NOMBRE_ESPECIE', 'VALOR TOTAL (S/)']);
    headersRow.height = 20;
    worksheet.getCell('A6').style = styles.dataHeader;
    worksheet.getCell('B6').style = styles.dataHeader;

    // DATOS
    if (datosProveidoExportar.etiquetas.length > 0) {
      datosProveidoExportar.etiquetas.forEach((especie, index) => {
        const row = worksheet.addRow([
          especie,
          datosProveidoExportar.cantidades[index]
        ]);
        
        // Alternar colores de fila para mejor legibilidad
        const fillColor = index % 2 === 0 ? 'FFFFFFFF' : 'FFF8F9FA';
        
        worksheet.getCell(`A${row.number}`).style = {
          ...styles.dataRow,
          fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: fillColor } },
          alignment: { wrapText: true, vertical: 'middle' }
        };
        
        worksheet.getCell(`B${row.number}`).style = {
          ...styles.dataRow,
          fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: fillColor } },
          numFmt: '"S/" #,##0.00', // Formato de moneda
          alignment: { horizontal: 'right', vertical: 'middle' }
        };
      });

      // FILA EN BLANCO
      worksheet.addRow([]);

      // TOTAL GENERAL
      const totalRow = worksheet.addRow(['TOTAL GENERAL', datosProveidoExportar.total]);
      totalRow.height = 20;
      worksheet.getCell(`A${totalRow.number}`).style = styles.totalRow;
      worksheet.getCell(`B${totalRow.number}`).style = {
        ...styles.totalRow,
        numFmt: '"S/" #,##0.00'
      };

      // Información adicional
      worksheet.addRow([]);
      const infoRow = worksheet.addRow(['Cantidad de especies:', datosProveidoExportar.etiquetas.length]);
      worksheet.getCell(`A${infoRow.number}`).style = styles.subHeader;
      worksheet.getCell(`B${infoRow.number}`).style = styles.subHeader;
    } else {
      const noDataRow = worksheet.addRow(['No hay datos disponibles', '']);
      worksheet.mergeCells(`A${noDataRow.number}:B${noDataRow.number}`);
      worksheet.getCell(`A${noDataRow.number}`).style = {
        ...styles.dataRow,
        alignment: { horizontal: 'center' },
        fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FFFFF3CD' } }
      };
    }

    // AJUSTAR ANCHO DE COLUMNAS
    worksheet.columns = [
      { width: 80 }, // Columna A - NOMBRE_ESPECIE
      { width: 20 }  // Columna B - VALOR TOTAL
    ];

    // CONGELAR PANEL (título y encabezados siempre visibles)
    worksheet.views = [
      { state: 'frozen', xSplit: 0, ySplit: 6 } // Congelar hasta la fila 6
    ];

    // GENERAR ARCHIVO
    const buffer = await workbook.xlsx.writeBuffer();
    const fileName = `Reporte_Proveidos_${gerenciaText.replace(/[^a-zA-Z0-9]/g, '_')}_${fechaInicio}_a_${fechaFin}.xlsx`;
    
    // Descargar archivo
    saveAs(new Blob([buffer]), fileName);

    console.log('✅ Archivo Excel elegante generado exitosamente');

  } catch (error) {
    console.error('❌ Error al generar Excel elegante:', error);
    alert('Error al generar el archivo Excel. Por favor, intente nuevamente.');
  }
}

//GENERAR EXCEL ---------------------------------FUNCIONA---------------

// Función para exportar a Excel
// function descargarExcel() {
//   try {
//     // Obtener datos del formulario
//     const fechaInicio = $('#fechaInicioAreaRe').val();
//     const fechaFin = $('#fechaFinAreaRe').val();
//     const gerenciaSubgerencia = $('#gerenciaSubgerencia').val();
//     const gerenciaText = $('#gerenciaSubgerencia option:selected').text();
    
//     // Crear un nuevo libro de trabajo
//     const wb = XLSX.utils.book_new();
    
//     // HOJA PRINCIPAL: DETALLE DE MONTOS PROVEÍDOS
//     let datosExcel = [
//       ['REPORTE DE MONTOS PROVEÍDOS'], // Título
//       ['Gerencia/Subgerencia:', gerenciaText], // Metadato 1
//       ['Período:', `${fechaInicio} al ${fechaFin}`], // Metadato 2
//       ['Fecha de exportación:', new Date().toLocaleDateString()], // Metadato 3
//       [''], // Línea en blanco
//       ['NOMBRE_ESPECIE', 'VALOR TOTAL (S/)'] // Encabezados de columnas
//     ];

//     // Agregar datos del gráfico proveído - SOLO LAS DOS COLUMNAS
//     if (datosProveidoExportar.etiquetas.length > 0) {
//       // Agregar cada fila con nombre de especie y valor total
//       datosProveidoExportar.etiquetas.forEach((especie, index) => {
//         datosExcel.push([
//           especie, // Columna A: NOMBRE_ESPECIE
//           datosProveidoExportar.cantidades[index] // Columna B: VALOR TOTAL
//         ]);
//       });

//       // Agregar línea en blanco y total general
//       datosExcel.push(['', '']);
//       datosExcel.push(['TOTAL GENERAL', datosProveidoExportar.total]);
//     } else {
//       datosExcel.push(['No hay datos disponibles', '']);
//     }

//     const ws = XLSX.utils.aoa_to_sheet(datosExcel);
    
//     // Ajustar ancho de columnas para mejor visualización
//     ws['!cols'] = [
//       { wch: 80 }, // Columna A (NOMBRE_ESPECIE) - más ancha para nombres largos
//       { wch: 20 }  // Columna B (VALOR TOTAL)
//     ];

//     // Agregar hoja al libro
//     XLSX.utils.book_append_sheet(wb, ws, "Montos Proveídos");

//     // Generar nombre del archivo
//     const fileName = `Reporte_Proveidos_${gerenciaText.replace(/[^a-zA-Z0-9]/g, '_')}_${fechaInicio}_a_${fechaFin}.xlsx`;

//     // Descargar el archivo
//     XLSX.writeFile(wb, fileName);

//     console.log('✅ Archivo Excel generado exitosamente con', datosProveidoExportar.etiquetas.length, 'registros');

//   } catch (error) {
//     console.error('❌ Error al generar Excel:', error);
//     alert('Error al generar el archivo Excel. Por favor, intente nuevamente.');
//   }
// }
// Función para exportar a Excel
// function descargarExcel() {
//   try {
//     // Obtener datos del formulario
//     const fechaInicio = $('#fechaInicioAreaRe').val();
//     const fechaFin = $('#fechaFinAreaRe').val();
//     const gerenciaSubgerencia = $('#gerenciaSubgerencia').val();
//     const gerenciaText = $('#gerenciaSubgerencia option:selected').text();
    
//     // Crear un nuevo libro de trabajo
//     const wb = XLSX.utils.book_new();
    
//     // 1. HOJA 1: RESUMEN GENERAL
//     const datosResumen = [
//       ['REPORTE GENERAL DE ÁREA'],
//       [''],
//       ['Gerencia/Subgerencia:', gerenciaText],
//       ['Período:', `${fechaInicio} al ${fechaFin}`],
//       ['Fecha de exportación:', new Date().toLocaleDateString()],
//       [''],
//       ['TOTALES'],
//       ['Descripción', 'Monto (S/)']
//     ];

//     // Agregar totales
//     const totalProveido = $('#totalAdmTriPro').text().replace('Monto total proveído: ', '');
//     const totalEspecifico = $('#totalAdmTri').text().replace('Total Autovaluo: ', '').replace('Total Agua: ', '');
    
//     datosResumen.push(['Monto Total Proveído', totalProveido || 'S/ 0.00']);
    
//     if (gerenciaSubgerencia === "3") {
//       datosResumen.push(['Total Autovaluo', totalEspecifico || 'S/ 0.00']);
//     } else if (gerenciaSubgerencia === "32") {
//       datosResumen.push(['Total Agua', totalEspecifico || 'S/ 0.00']);
//     }

//     datosResumen.push(['', '']);
//     datosResumen.push(['Total General', `=SUM(B9:B${7 + (totalEspecifico ? 2 : 1)})`]);

//     const wsResumen = XLSX.utils.aoa_to_sheet(datosResumen);
    
//     // Estilos para la hoja de resumen
//     wsResumen['!cols'] = [
//       { wch: 25 }, // Columna A
//       { wch: 20 }  // Columna B
//     ];

//     // 2. HOJA 2: DETALLE DE MONTOS PROVEÍDOS (SOLO DOS COLUMNAS)
//     let datosDetalle = [
//       ['DETALLE DE MONTOS PROVEÍDOS POR ESPECIE'],
//       [''],
//       ['Gerencia/Subgerencia:', gerenciaText],
//       ['Período:', `${fechaInicio} al ${fechaFin}`],
//       [''],
//       ['NOMBRE_ESPECIE', 'VALOR TOTAL'] // SOLO DOS COLUMNAS
//     ];

//     // Agregar datos del gráfico proveído - SOLO LAS DOS COLUMNAS REQUERIDAS
//     if (datosProveidoExportar.etiquetas.length > 0) {
//       datosProveidoExportar.etiquetas.forEach((especie, index) => {
//         datosDetalle.push([
//           especie, // Columna 1: NOMBRE_ESPECIE
//           datosProveidoExportar.cantidades[index] // Columna 2: VALOR TOTAL
//         ]);
//       });

//       // Agregar total
//       datosDetalle.push(['', '']);
//       datosDetalle.push(['TOTAL GENERAL', datosProveidoExportar.total]);
//       datosDetalle.push(['', '']);
//       datosDetalle.push(['Cantidad de especies:', datosProveidoExportar.etiquetas.length]);
//     } else {
//       datosDetalle.push(['No hay datos disponibles', '']);
//     }

//     const wsDetalle = XLSX.utils.aoa_to_sheet(datosDetalle);
    
//     // Estilos para la hoja de detalle - SOLO DOS COLUMNAS
//     wsDetalle['!cols'] = [
//       { wch: 70 }, // Columna A (NOMBRE_ESPECIE - más ancha)
//       { wch: 20 }  // Columna B (VALOR TOTAL)
//     ];

//     // 3. HOJA 3: ESTADÍSTICAS (si hay datos)
//     if (datosProveidoExportar.etiquetas.length > 0) {
//       let datosEstadisticas = [
//         ['ESTADÍSTICAS DE MONTOS PROVEÍDOS'],
//         [''],
//         ['Gerencia/Subgerencia:', gerenciaText],
//         ['Período:', `${fechaInicio} al ${fechaFin}`],
//         [''],
//         ['Estadística', 'Monto (S/)', 'Porcentaje']
//       ];

//       const montos = datosProveidoExportar.cantidades;
//       const total = datosProveidoExportar.total;
      
//       // Calcular estadísticas
//       const maxMonto = Math.max(...montos);
//       const minMonto = Math.min(...montos);
//       const avgMonto = total / montos.length;
      
//       // Encontrar la especie con mayor y menor monto
//       const indexMax = montos.indexOf(maxMonto);
//       const indexMin = montos.indexOf(minMonto);

//       datosEstadisticas.push(['Monto máximo', maxMonto, `=${maxMonto}/${total}`]);
//       datosEstadisticas.push(['Especie con mayor monto', datosProveidoExportar.etiquetas[indexMax], '']);
//       datosEstadisticas.push(['Monto mínimo', minMonto, `=${minMonto}/${total}`]);
//       datosEstadisticas.push(['Especie con menor monto', datosProveidoExportar.etiquetas[indexMin], '']);
//       datosEstadisticas.push(['Monto promedio', avgMonto, `=${avgMonto}/${total}`]);
//       datosEstadisticas.push(['Cantidad de especies', montos.length, '']);
//       datosEstadisticas.push(['Total general', total, '100%']);

//       const wsEstadisticas = XLSX.utils.aoa_to_sheet(datosEstadisticas);
      
//       wsEstadisticas['!cols'] = [
//         { wch: 30 }, // Columna A
//         { wch: 20 }, // Columna B
//         { wch: 15 }  // Columna C
//       ];

//       XLSX.utils.book_append_sheet(wb, wsEstadisticas, "Estadísticas");
//     }

//     // Agregar hojas al libro
//     XLSX.utils.book_append_sheet(wb, wsResumen, "Resumen");
//     XLSX.utils.book_append_sheet(wb, wsDetalle, "Detalle Proveídos");

//     // Generar nombre del archivo
//     const fileName = `Reporte_Area_${gerenciaText.replace(/[^a-zA-Z0-9]/g, '_')}_${fechaInicio}_a_${fechaFin}.xlsx`;

//     // Descargar el archivo
//     XLSX.writeFile(wb, fileName);

//     console.log('✅ Archivo Excel generado exitosamente');

//   } catch (error) {
//     console.error('❌ Error al generar Excel:', error);
//     alert('Error al generar el archivo Excel. Por favor, intente nuevamente.');
//   }
// }


// //GENERAR EXCEL
// // Función para exportar a Excel
// function descargarExcel() {
//   try {
//     // Obtener datos del formulario
//     const fechaInicio = $('#fechaInicioAreaRe').val();
//     const fechaFin = $('#fechaFinAreaRe').val();
//     const gerenciaSubgerencia = $('#gerenciaSubgerencia').val();
//     const gerenciaText = $('#gerenciaSubgerencia option:selected').text();
    
//     // Crear un nuevo libro de trabajo
//     const wb = XLSX.utils.book_new();
    
//     // 1. HOJA 1: RESUMEN GENERAL
//     const datosResumen = [
//       ['REPORTE GENERAL DE ÁREA'],
//       [''],
//       ['Gerencia/Subgerencia:', gerenciaText],
//       ['Período:', `${fechaInicio} al ${fechaFin}`],
//       ['Fecha de exportación:', new Date().toLocaleDateString()],
//       [''],
//       ['TOTALES'],
//       ['Descripción', 'Monto (S/)']
//     ];

//     // Agregar totales
//     const totalProveido = $('#totalAdmTriPro').text().replace('Monto total proveído: ', '');
//     const totalEspecifico = $('#totalAdmTri').text().replace('Total Autovaluo: ', '').replace('Total Agua: ', '');
    
//     datosResumen.push(['Monto Total Proveído', totalProveido || 'S/ 0.00']);
    
//     if (gerenciaSubgerencia === "3") {
//       datosResumen.push(['Total Autovaluo', totalEspecifico || 'S/ 0.00']);
//     } else if (gerenciaSubgerencia === "32") {
//       datosResumen.push(['Total Agua', totalEspecifico || 'S/ 0.00']);
//     }

//     datosResumen.push(['', '']);
//     datosResumen.push(['Total General', `=SUM(B9:B${7 + (totalEspecifico ? 2 : 1)})`]);

//     const wsResumen = XLSX.utils.aoa_to_sheet(datosResumen);
    
//     // Estilos para la hoja de resumen
//     wsResumen['!cols'] = [
//       { wch: 25 }, // Columna A
//       { wch: 20 }  // Columna B
//     ];

//     // 2. HOJA 2: DETALLE DE MONTOS PROVEÍDOS
//     let datosDetalle = [
//       ['DETALLE DE MONTOS PROVEÍDOS POR ESPECIE'],
//       [''],
//       ['Gerencia/Subgerencia:', gerenciaText],
//       ['Período:', `${fechaInicio} al ${fechaFin}`],
//       [''],
//       ['Especie', 'Monto (S/)']
//     ];

//     // Agregar datos del gráfico proveído
//     if (datosProveidoExportar.etiquetas.length > 0) {
//       datosProveidoExportar.etiquetas.forEach((especie, index) => {
//         datosDetalle.push([
//           especie,
//           datosProveidoExportar.cantidades[index]
//         ]);
//       });

//       // Agregar total
//       datosDetalle.push(['', '']);
//       datosDetalle.push(['TOTAL GENERAL', datosProveidoExportar.total]);
//       datosDetalle.push(['', '']);
//       datosDetalle.push(['Cantidad de especies:', datosProveidoExportar.etiquetas.length]);
//     } else {
//       datosDetalle.push(['No hay datos disponibles', '']);
//     }

//     const wsDetalle = XLSX.utils.aoa_to_sheet(datosDetalle);
    
//     // Estilos para la hoja de detalle
//     wsDetalle['!cols'] = [
//       { wch: 50 }, // Columna A (Especies - más ancha)
//       { wch: 20 }  // Columna B (Montos)
//     ];

//     // 3. HOJA 3: ESTADÍSTICAS (si hay datos)
//     if (datosProveidoExportar.etiquetas.length > 0) {
//       let datosEstadisticas = [
//         ['ESTADÍSTICAS DE MONTOS PROVEÍDOS'],
//         [''],
//         ['Gerencia/Subgerencia:', gerenciaText],
//         ['Período:', `${fechaInicio} al ${fechaFin}`],
//         [''],
//         ['Estadística', 'Monto (S/)', 'Porcentaje']
//       ];

//       const montos = datosProveidoExportar.cantidades;
//       const total = datosProveidoExportar.total;
      
//       // Calcular estadísticas
//       const maxMonto = Math.max(...montos);
//       const minMonto = Math.min(...montos);
//       const avgMonto = total / montos.length;
      
//       // Encontrar la especie con mayor y menor monto
//       const indexMax = montos.indexOf(maxMonto);
//       const indexMin = montos.indexOf(minMonto);

//       datosEstadisticas.push(['Monto máximo', maxMonto, `=${maxMonto}/${total}`]);
//       datosEstadisticas.push(['Especie con mayor monto', datosProveidoExportar.etiquetas[indexMax], '']);
//       datosEstadisticas.push(['Monto mínimo', minMonto, `=${minMonto}/${total}`]);
//       datosEstadisticas.push(['Especie con menor monto', datosProveidoExportar.etiquetas[indexMin], '']);
//       datosEstadisticas.push(['Monto promedio', avgMonto, `=${avgMonto}/${total}`]);
//       datosEstadisticas.push(['Cantidad de especies', montos.length, '']);
//       datosEstadisticas.push(['Total general', total, '100%']);

//       const wsEstadisticas = XLSX.utils.aoa_to_sheet(datosEstadisticas);
      
//       wsEstadisticas['!cols'] = [
//         { wch: 30 }, // Columna A
//         { wch: 20 }, // Columna B
//         { wch: 15 }  // Columna C
//       ];

//       XLSX.utils.book_append_sheet(wb, wsEstadisticas, "Estadísticas");
//     }

//     // Agregar hojas al libro
//     XLSX.utils.book_append_sheet(wb, wsResumen, "Resumen");
//     XLSX.utils.book_append_sheet(wb, wsDetalle, "Detalle Proveídos");

//     // Generar nombre del archivo
//     const fileName = `Reporte_Area_${gerenciaText.replace(/[^a-zA-Z0-9]/g, '_')}_${fechaInicio}_a_${fechaFin}.xlsx`;

//     // Descargar el archivo
//     XLSX.writeFile(wb, fileName);

//     console.log('✅ Archivo Excel generado exitosamente');

//   } catch (error) {
//     console.error('❌ Error al generar Excel:', error);
//     alert('Error al generar el archivo Excel. Por favor, intente nuevamente.');
//   }
// }


// Función para exportar a PDF
// async function descargarPDF() {
//   try {
//     const { jsPDF } = window.jspdf;
//     const doc = new jsPDF('p', 'mm', 'a4');
    
//     // Título del documento
//     doc.setFontSize(20);
//     doc.setTextColor(40, 40, 40);
//     doc.text('Reporte General de Área', 105, 20, { align: 'center' });
    
//     // Información de fechas y gerencia
//     const fechaInicio = $('#fechaInicioAreaRe').val();
//     const fechaFin = $('#fechaFinAreaRe').val();
//     const gerenciaSubgerencia = $('#gerenciaSubgerencia').val();
//     const gerenciaText = $('#gerenciaSubgerencia option:selected').text();
    
//     doc.setFontSize(12);
//     doc.setTextColor(100, 100, 100);
//     doc.text(`Período: ${fechaInicio} al ${fechaFin}`, 20, 35);
//     doc.text(`Gerencia/Subgerencia: ${gerenciaText}`, 20, 42);
    
//     let yPosition = 60;

//     // 1. Capturar gráfico de proveído si existe
//     const canvasProveido = document.getElementById('myChartAdmTriProveido');
//     if (canvasProveido && canvasProveido.style.display !== 'none') {
//       // Agregar título de la sección
//       doc.setFontSize(16);
//       doc.setTextColor(30, 30, 30);
//       doc.text('Monto Proveído por Especie', 20, yPosition);
//       yPosition += 10;
      
//       // Capturar el gráfico como imagen
//       const canvasImage = await html2canvas(canvasProveido, {
//         scale: 2,
//         useCORS: true,
//         logging: false
//       });
      
//       const imgData = canvasImage.toDataURL('image/png');
      
//       // Calcular dimensiones para mantener proporción
//       const imgWidth = 170;
//       const imgHeight = (canvasImage.height * imgWidth) / canvasImage.width;
      
//       // Verificar si hay espacio en la página
//       if (yPosition + imgHeight > 270) {
//         doc.addPage();
//         yPosition = 20;
//       }
      
//       doc.addImage(imgData, 'PNG', 20, yPosition, imgWidth, imgHeight);
//       yPosition += imgHeight + 15;
      
//       // Agregar tabla de datos del gráfico proveído
//       if (datosProveidoExportar.etiquetas.length > 0) {
//         // Verificar si necesita nueva página
//         if (yPosition > 200) {
//           doc.addPage();
//           yPosition = 20;
//         }
        
//         doc.setFontSize(14);
//         doc.setTextColor(30, 30, 30);
//         doc.text('Detalle de Montos Proveídos', 20, yPosition);
//         yPosition += 10;
        
//         // Crear tabla
//         doc.setFontSize(10);
//         let tableTop = yPosition;
        
//         // Encabezados de tabla
//         doc.setFillColor(23, 191, 172);
//         doc.setTextColor(255, 255, 255);
//         doc.rect(20, tableTop, 170, 8, 'F');
//         doc.text('Especie', 22, tableTop + 6);
//         doc.text('Monto (S/)', 150, tableTop + 6);
        
//         tableTop += 8;
//         doc.setTextColor(0, 0, 0);
        
//         // Filas de datos
//         datosProveidoExportar.etiquetas.forEach((etiqueta, index) => {
//           if (tableTop > 270) {
//             doc.addPage();
//             tableTop = 20;
//             // Redibujar encabezado en nueva página
//             doc.setFillColor(23, 191, 172);
//             doc.setTextColor(255, 255, 255);
//             doc.rect(20, tableTop, 170, 8, 'F');
//             doc.text('Especie', 22, tableTop + 6);
//             doc.text('Monto (S/)', 150, tableTop + 6);
//             tableTop += 8;
//             doc.setTextColor(0, 0, 0);
//           }
          
//           // Alternar colores de fila
//           if (index % 2 === 0) {
//             doc.setFillColor(240, 240, 240);
//             doc.rect(20, tableTop, 170, 8, 'F');
//           }
          
//           // Truncar texto largo
//           const especieText = etiqueta.length > 35 ? etiqueta.substring(0, 35) + '...' : etiqueta;
//           const montoText = `S/ ${datosProveidoExportar.cantidades[index].toLocaleString('es-PE', {
//             minimumFractionDigits: 2
//           })}`;
          
//           doc.text(especieText, 22, tableTop + 6);
//           doc.text(montoText, 150, tableTop + 6);
          
//           tableTop += 8;
//         });
        
//         // Total
//         if (tableTop > 260) {
//           doc.addPage();
//           tableTop = 20;
//         }
        
//         doc.setFillColor(200, 200, 200);
//         doc.rect(20, tableTop, 170, 8, 'F');
//         doc.setFontSize(10);
//         doc.setFont(undefined, 'bold');
//         doc.text('TOTAL GENERAL', 22, tableTop + 6);
//         doc.text(`S/ ${datosProveidoExportar.total.toLocaleString('es-PE', {
//           minimumFractionDigits: 2
//         })}`, 150, tableTop + 6);
        
//         yPosition = tableTop + 15;
//       }
//     }

//     // 2. Capturar gráfico específico si existe y es visible
//     const canvasEspecifico = document.getElementById('myChartAdmTri');
//     if (canvasEspecifico && canvasEspecifico.style.display !== 'none' && 
//         canvasEspecifico.offsetParent !== null) {
      
//       // Verificar si necesita nueva página
//       if (yPosition > 120) {
//         doc.addPage();
//         yPosition = 20;
//       }
      
//       doc.setFontSize(16);
//       doc.setTextColor(30, 30, 30);
      
//       const tituloEspecifico = gerenciaSubgerencia === "3" ? 'Total Autovaluo' : 'Total Agua';
//       doc.text(tituloEspecifico, 20, yPosition);
//       yPosition += 10;
      
//       const canvasImage = await html2canvas(canvasEspecifico, {
//         scale: 2,
//         useCORS: true,
//         logging: false
//       });
      
//       const imgData = canvasImage.toDataURL('image/png');
//       const imgWidth = 80;
//       const imgHeight = (canvasImage.height * imgWidth) / canvasImage.width;
      
//       doc.addImage(imgData, 'PNG', 60, yPosition, imgWidth, imgHeight);
//     }

//     // 3. Información de totales
//     if (yPosition > 200) {
//       doc.addPage();
//       yPosition = 20;
//     }
    
//     doc.setFontSize(12);
//     doc.setTextColor(60, 60, 60);
//     yPosition += 10;
    
//     const totalProveido = $('#totalAdmTriPro').text();
//     const totalEspecifico = $('#totalAdmTri').text();
    
//     if (totalProveido) {
//       doc.text(totalProveido, 20, yPosition);
//       yPosition += 7;
//     }
    
//     if (totalEspecifico) {
//       doc.text(totalEspecifico, 20, yPosition);
//     }

//     // Pie de página
//     const pageCount = doc.internal.getNumberOfPages();
//     for (let i = 1; i <= pageCount; i++) {
//       doc.setPage(i);
//       doc.setFontSize(10);
//       doc.setTextColor(150, 150, 150);
//       doc.text(
//         `Página ${i} de ${pageCount} - Generado el ${new Date().toLocaleDateString()}`,
//         105,
//         290,
//         { align: 'center' }
//       );
//     }

//     // Descargar el PDF
//     doc.save(`Reporte_Area_${gerenciaText}_${fechaInicio}_a_${fechaFin}.pdf`);
    
//   } catch (error) {
//     console.error('Error al generar PDF:', error);
//     alert('Error al generar el PDF. Por favor, intente nuevamente.');
//   }
// }

// $(document).ready(function () {
//   $('#btnConsultarReporteArea').on('click', function () {
//     console.log("Botón 'Consultar Reporte' clickeado");

//     const fechaInicio = $('#fechaInicioAreaRe').val();
//     const fechaFin = $('#fechaFinAreaRe').val();
//     const gerenciaSubgerencia = $('#gerenciaSubgerencia').val();

//     if (!fechaInicio || !fechaFin || !gerenciaSubgerencia) {
//       alert('Por favor seleccione las fechas de inicio y fin, y la gerencia.');
//       return;
//     }

//     // 🔹 PREPARAR CONTENEDORES ANTES DE GENERAR GRÁFICOS
//     const containerTributaria = $("#myChartAdmTri").parent();
//     const containerProveido = $("#myChartAdmTriProveido").parent();
    
//     // Preparar contenedor del gráfico de proveído
//     const canvasProveido = prepararContenedorGrafico(containerProveido.attr('id'), "myChartAdmTriProveido");
    
//     // Preparar contenedor del gráfico específico - SIEMPRE crear el canvas
//     containerTributaria.empty();
//     containerTributaria.append('<canvas id="myChartAdmTri"></canvas>');
//     containerTributaria.css({
//       width: "100%",
//       display: "flex",
//       justifyContent: "center",
//       alignItems: "center",
//       padding: "0",
//       margin: "0"
//     });

//     // 🟡 SIEMPRE generar gráfico horizontal con scroll (Monto Proveído por Especie)
//     generarGrafico({
//       tipoReporte: "reporte_tributaria_proveido",
//       canvasId: "myChartAdmTriProveido",
//       label: "Total Proveído",
//       color: "rgb(23, 191, 172)",
//       totalId: "totalAdmTriPro",
//       fechaInicio: fechaInicio,
//       fechaFin: fechaFin,
//       gerenciaSubgerencia: gerenciaSubgerencia
//     });

//     // 🔹 Generar gráfico específico por gerencia
//     if (gerenciaSubgerencia === "3") {
//       generarGrafico({
//         tipoReporte: "reporte_general_tributaria",
//         canvasId: "myChartAdmTri",
//         label: "Total Autovaluo",
//         color: "rgb(245, 211, 42)",
//         totalId: "totalAdmTri",
//         fechaInicio: fechaInicio,
//         fechaFin: fechaFin,
//         gerenciaSubgerencia: gerenciaSubgerencia
//       });
//     } else if (gerenciaSubgerencia === "32") {
//       generarGrafico({
//         tipoReporte: "reporte_general_agua",
//         canvasId: "myChartAdmTri",
//         label: "Total Agua",
//         color: "rgb(54, 162, 235)",
//         totalId: "totalAgua",
//         fechaInicio: fechaInicio,
//         fechaFin: fechaFin,
//         gerenciaSubgerencia: gerenciaSubgerencia
//       });
//     } else {
//       reporteGeneralArea_.total = null;
//       // Mostrar mensaje PERO mantener el canvas para futuras consultas
//       containerTributaria.html(`
//         <div class="text-center text-muted p-3">
//           No hay gráfico disponible para esta gerencia.
//         </div>
//         <canvas id="myChartAdmTri" style="display: none;"></canvas>
//       `);
//       $(`#totalAdmTri`).text("");
//     }
//   });
// });

// class ReporteGeneralAreaClass {
//   constructor() {
//     this.fechaFiltroInicio = null;
//     this.fechaFiltroFin = null;
//     this.total=null;
//   }
// }

// const reporteGeneralArea_ = new ReporteGeneralAreaClass();

// // Gráficos separados
// let chartTributaria = null;
// let chartTributariaProveido = null;
// let chartAgua = null;

// // Función para obtener especies valoradas por gerencia
// function obtenerEspeciesValoradas(gerenciaSubgerencia) {
//   const especiesMap = {
//     "3": "13,22,25,28,39,40,41,44,45,46,47,48,50,51,52,53,54,56,177,199,201,202,203,204,205,250,515,529,540,541,542,543,544,545,546,547,642,715",
//     "4": "8,10,12,15,18,21,24,27,30,33,35,37,169,170,171,173,174,175,176,240,242,520,521,522,524,525,526,528,530,531,532,536,537,761,765,770",
//     "5": "514,771,772,773,774",
//     "6": "105,119,121,220,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399,400,401,402,403,404,405,406,407,408,409,410,411,412,413,414,415,416,417,418,419,425,426,428,548,549,550,551,552,553,554,555,556,557,558,559,560,561,562,563,564,565,566,567,568,569,570,571,572,573,574,575,576,577,578,579,580,581,582,583,584,585,586,587,588,589,590,591,592",
//     "7": "445,446,447,448,449,450,451,452,453,454,455,456,457,458,459,460,461,462,463,464,465,466,467,468,469,470,471,472,473,474,475,476,477,478,479,480,481,482,483,484,485,486,533,766",
//     "11": "348,349,350,351,352,353,354,355,356,357,358,359,360",
//     "18": "1,2,3,4,5,6,196,197,487,488,489,490,491,492,493,494,495,496,497,498,499,500,501,502,534",
//     "22": "38,57,58,59,60,61,206,207,208,209,210,211,212,213,214",
//     "23": "194,195",
//     "24": "16,19,31,34,36,42,43,200,512,513",
//     "25": "535",
//     "26": "523,768",
//     "27": "269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343",
//     "28": "344,345,346,347",
//     "29": "62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,106,107,108,109,110,111,112,113,114,115,116,117,118,120,122,123,129,130,131,132,133,134,135,136,137,215,216,217,218,219,361,362,363,364,365,366,367,516,517,518,519,596,704,705,763",
//     "30": "124,125,126,128,420,421,422,423,424,427,429,430,695",
//     "31": "7,9,11,14,17,20,23,26,29,32,198",
//     "32": "127,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,221,222,223,224,225,226,227,228,229,230,706,714",
//     "33": "178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,231,232,233,234,235,236,237,238,239,241,243,244,245,246,247,248,503,504,505,506,507,508,509,510,511,527,710,711",
//     "34": "249,259,260,431,432,433,434,435,436,437,438,439,440,441,442,443,444",
//     "35": "172,538,539",
//     "37": "738,739,740,741,742,743,744,745,746,747,748,749,750,751,752,753,754,755,756,757,758,759,760",
//     "38": "769"
//   };
  
//   return especiesMap[gerenciaSubgerencia] || "";
// }

// // Función genérica para cargar gráficos
// function generarGrafico({ tipoReporte, canvasId, label, color, totalId, fechaInicio, fechaFin, gerenciaSubgerencia }) {
//   reporteGeneralArea_.fechaFiltroInicio = fechaInicio;
//   reporteGeneralArea_.fechaFiltroFin = fechaFin;

//   if (!fechaInicio || !fechaFin || !gerenciaSubgerencia) {
//     alert('Por favor seleccione las fechas de inicio y fin, y la gerencia.');
//     return;
//   }

//   const especiesValoradas = obtenerEspeciesValoradas(gerenciaSubgerencia);
  
//   if (!especiesValoradas) {
//     alert('No se encontraron especies valoradas para la gerencia seleccionada.');
//     return;
//   }

//   const datos = new FormData();
//   datos.append(tipoReporte, tipoReporte);
//   datos.append("fechaInicio", fechaInicio);
//   datos.append("fechaFin", fechaFin);
//   datos.append("especiesValoradas", especiesValoradas);
//   datos.append("idArea", gerenciaSubgerencia);

//   // ✅ Imprimir todos los datos del FormData
//   for (let [clave, valor] of datos.entries()) {
//     console.log(`${clave}: ${valor}`);
//   }

//   const ctx = $(`#${canvasId}`)[0].getContext('2d');

//   $.ajax({
//     url: "ajax/reporteGeneralArea.ajax.php",
//     method: "POST",
//     data: datos,
//     cache: false,
//     contentType: false,
//     processData: false,
//     success: function (respuesta) {
//       console.log(`📊 Respuesta ${tipoReporte}:`, respuesta);

//       let data = respuesta;
//       let etiquetas = [];
//       let cantidades = [];

//       // 🟡 Gráfico horizontal para proveídos
//       if (tipoReporte === "reporte_tributaria_proveido" && Array.isArray(data) && data.length > 0) {
//         etiquetas = data.map(item => item.Nombre_Especie);
//         cantidades = data.map(item => parseFloat(item.valor_total));

//         // ✅ Calcular total
//         const total = cantidades.reduce((a, b) => a + b, 0).toLocaleString('es-PE', {
//           style: 'currency',
//           currency: 'PEN',
//           minimumFractionDigits: 2
//         });

//         $(`#totalAdmTriPro`).text(`Monto total proveído: ${total}`);

//         // ✅ Destruir gráfico anterior si existe
//         if (chartTributariaProveido) chartTributariaProveido.destroy();

//         // ✅ Resetear tamaño del canvas
//         ctx.canvas.style.width = "100%";
//         ctx.canvas.style.height = `${Math.max(500, data.length * 22)}px`;
//         ctx.canvas.removeAttribute("width");
//         ctx.canvas.removeAttribute("height");

//         // ✅ Ajustar estilos del contenedor
//         $(`#${canvasId}`).parent().css({
//           width: "100%",
//           display: "flex",
//           justifyContent: "center",
//           alignItems: "center",
//           padding: "0",
//           margin: "0"
//         });

//         // ✅ Crear gráfico horizontal
//         chartTributariaProveido = new Chart(ctx, {
//           type: 'bar',
//           data: {
//             labels: etiquetas,
//             datasets: [{
//               label: "Monto (S/)",
//               data: cantidades,
//               backgroundColor: color,
//               borderColor: color,
//               borderWidth: 1,
//               barPercentage: 0.6
//             }]
//           },
//           options: {
//             indexAxis: 'y',
//             responsive: true,
//             maintainAspectRatio: false,
//             layout: { padding: 0 },
//             scales: {
//               x: {
//                 beginAtZero: true,
//                 title: {
//                   display: true,
//                   text: 'Monto (S/)',
//                   color: '#333',
//                   font: { size: 12, weight: 'bold' }
//                 },
//                 ticks: { color: '#000', font: { size: 13 } },
//                 grid: { drawBorder: true, drawOnChartArea: false }
//               },
//               y: {
//                 ticks: { autoSkip: false, color: '#000', font: { size: 12 }, padding: 4 },
//                 grid: { drawBorder: false, drawOnChartArea: false }
//               }
//             },
//             plugins: {
//               legend: { display: false },
//               tooltip: {
//                 callbacks: {
//                   label: (context) => `S/ ${parseFloat(context.raw).toLocaleString('es-PE', {
//                     minimumFractionDigits: 2
//                   })}`
//                 }
//               },
//               title: {
//                 display: true,
//                 text: 'Monto Proveído por Especie',
//                 font: { size: 15, weight: 'bold' },
//                 color: '#111'
//               }
//             }
//           }
//         });
//         return;
//       }


    
//     if (tipoReporte === "reporte_general_tributaria" && Array.isArray(data) && data.length > 0) {

//       console.log("Procesando reporte_general_tributaria--------------------");

//       // 🟦 Gráficos simples (barras verticales)
//       if (data.length > 0 && data[0].length > 0 && data[0][0] !== null) {

//         console.log("Data válida encontrada:", data);
//         etiquetas.push(label);
//         cantidades.push(parseFloat(data[0][0]));


//       } else {
//         console.log("No se encontraron datos válidos.");
//         $(`#${totalId}`).text("Monto total: S/ 0.00");

//         return;
//       }


//           reporteGeneralArea_.total = cantidades[0].toLocaleString('es-PE', {
//           style: 'currency',
//           currency: 'PEN',
//           minimumFractionDigits: 2
//         });

//         console.log("total--prueba", reporteGeneralArea_.total);

//         $(`#${totalId}`).text(`Monto total: ${reporteGeneralArea_.total}`);

        
      
//       // Destruir gráficos anteriores
//       if (tipoReporte === "reporte_general_tributaria" && chartTributaria) chartTributaria.destroy();
//       if (tipoReporte === "reporte_general_agua" && chartAgua) chartAgua.destroy();

//       ctx.canvas.height = 460;
//       ctx.canvas.width = 200;

//       // Aplicar clases CSS
//       $(`#${canvasId}`).parent().addClass("chart-container-centered");
//       $(ctx.canvas).addClass("fixed-size-chart");

//       const nuevoChart = new Chart(ctx, {
//         type: 'bar',
//         data: {
//           labels: etiquetas,
//           datasets: [{
//             label: label,
//             data: cantidades,
//             backgroundColor: [color],
//             borderColor: [color],
//             borderWidth: 1,
//             barPercentage: 0.4,
//             categoryPercentage: 0.5
//           }]
//         },
//         options: {
//           responsive: false,
//           maintainAspectRatio: false,
//           scales: {
//             y: {
//               beginAtZero: true,
//               title: { display: true, text: 'Monto (S/)' }
//             }
//           },
//           plugins: {
//             legend: { display: true },
//             tooltip: {
//               callbacks: {
//                 label: (context) => `${context.dataset.label}: ${context.formattedValue}`
//               }
//             }
//           }
//         }
//       });

//       // Asignar a la variable global correspondiente
//       if (tipoReporte === "reporte_general_tributaria") chartTributaria = nuevoChart;
//       if (tipoReporte === "reporte_general_agua") chartAgua = nuevoChart;




//       }else{
//          $(`#${totalId}`).text(``);



//       }
    



//     },
//     error: function (xhr, status, error) {
//       console.error(`❌ Error en la solicitud AJAX (${tipoReporte}):`, error);
//       alert(`Error al cargar el gráfico: ${error}`);
//     }
//   });
// }


// $(document).ready(function () {
//   $('#btnConsultarReporteArea').on('click', function () {
//     console.log("Botón 'Consultar Reporte' clickeado");

//     const fechaInicio = $('#fechaInicioAreaRe').val();
//     const fechaFin = $('#fechaFinAreaRe').val();
//     const gerenciaSubgerencia = $('#gerenciaSubgerencia').val();

//     if (!fechaInicio || !fechaFin || !gerenciaSubgerencia) {
//       alert('Por favor seleccione las fechas de inicio y fin, y la gerencia.');
//       return;
//     }

//     // 🟡 Gráfico horizontal con scroll (siempre se genera)
//     generarGrafico({
//       tipoReporte: "reporte_tributaria_proveido",
//       canvasId: "myChartAdmTriProveido",
//       label: "Total Proveído",
//       color: "rgb(23, 191, 172)",
//       totalId: "totalAdmTriProveido",
//       fechaInicio: fechaInicio,
//       fechaFin: fechaFin,
//       gerenciaSubgerencia: gerenciaSubgerencia
//     });

//     // 🔹 Gráfico específico por gerencia - CORREGIDO
//     const containerTributaria = $("#myChartAdmTri").parent();
//     const canvasId = "myChartAdmTri";

//     // Verificar si el canvas fue reemplazado y restaurarlo si es necesario
//     if (containerTributaria.find('canvas').length === 0) {
//       containerTributaria.html('<canvas id="' + canvasId + '"></canvas>');
//     }

//     if (gerenciaSubgerencia === "3") {
//       generarGrafico({
//         tipoReporte: "reporte_general_tributaria",
//         canvasId: canvasId,
//         label: "Total Autovaluo",
//         color: "rgb(245, 211, 42)",
//         totalId: "totalAdmTri",
//         fechaInicio: fechaInicio,
//         fechaFin: fechaFin,
//         gerenciaSubgerencia: gerenciaSubgerencia
//       });
//     } else if (gerenciaSubgerencia === "32") {
//       generarGrafico({
//         tipoReporte: "reporte_general_agua",
//         canvasId: canvasId,
//         label: "Total Agua",
//         color: "rgb(54, 162, 235)",
//         totalId: "totalAgua",
//         fechaInicio: fechaInicio,
//         fechaFin: fechaFin,
//         gerenciaSubgerencia: gerenciaSubgerencia
//       });
//     } else {
//       reporteGeneralArea_.total=null;
//       // En lugar de reemplazar el canvas, mostramos un mensaje encima
//       containerTributaria.html(`
//         <div class="text-center text-muted p-3">
//           No hay gráfico disponible para esta gerencia.
//         </div>
//         <canvas id="${canvasId}" style="display: none;"></canvas>
//       `);
//     }
//   });
// });

// $(document).ready(function () {
//   $('#btnConsultarReporteArea').on('click', function () {
//     console.log("Botón 'Consultar Reporte' clickeado");

//     const fechaInicio = $('#fechaInicioAreaRe').val();
//     const fechaFin = $('#fechaFinAreaRe').val();
//     const gerenciaSubgerencia = $('#gerenciaSubgerencia').val();

//     if (!fechaInicio || !fechaFin || !gerenciaSubgerencia) {
//       alert('Por favor seleccione las fechas de inicio y fin, y la gerencia.');
//       return;
//     }

//     // 🟡 Gráfico horizontal con scroll (siempre se genera)
//     generarGrafico({
//       tipoReporte: "reporte_tributaria_proveido",
//       canvasId: "myChartAdmTriProveido",
//       label: "Total Proveído",
//       color: "rgb(23, 191, 172)",
//       totalId: "totalAdmTriProveido",
//       fechaInicio: fechaInicio,
//       fechaFin: fechaFin,
//       gerenciaSubgerencia: gerenciaSubgerencia
//     });

//     // 🔹 Gráfico específico por gerencia
//     const canvasTributaria = document.getElementById("myChartAdmTri");
//     const parentTributaria = canvasTributaria.parentNode;

//     if (gerenciaSubgerencia === "3") {
//       generarGrafico({
//         tipoReporte: "reporte_general_tributaria",
//         canvasId: "myChartAdmTri",
//         label: "Total Autovaluo",
//         color: "rgb(245, 211, 42)",
//         totalId: "totalAdmTri",
//         fechaInicio: fechaInicio,
//         fechaFin: fechaFin,
//         gerenciaSubgerencia: gerenciaSubgerencia
//       });
//     } else if (gerenciaSubgerencia === "32") {
//       generarGrafico({
//         tipoReporte: "reporte_general_agua",
//         canvasId: "myChartAdmTri",
//         label: "Total Agua",
//         color: "rgb(54, 162, 235)",
//         totalId: "totalAgua",
//         fechaInicio: fechaInicio,
//         fechaFin: fechaFin,
//         gerenciaSubgerencia: gerenciaSubgerencia
//       });
//     } else {
//       // Limpiar canvas si no coincide
//       parentTributaria.innerHTML = `<div class="text-center text-muted p-3">
//         No hay gráfico disponible para esta gerencia.
//       </div>`;
//     }
//   });
// });




// class ReporteGeneralAreaClass {
//   constructor() {
//     this.fechaFiltroInicio = null;
//     this.fechaFiltroFin = null;
//   }
// }

// const reporteGeneralArea_ = new ReporteGeneralAreaClass();

// // Gráficos separados
// let chartTributaria = null;
// let chartTributariaProveido = null;
// let chartAgua = null;

// // Función genérica para cargar gráficos
// function generarGrafico({ tipoReporte, canvasId, label, color, totalId , fechaInicio, fechaFin, gerenciaSubgerencia  }) {

//     reporteGeneralArea_.fechaFiltroInicio = fechaInicio;
//   reporteGeneralArea_.fechaFiltroFin = fechaFin;
//   let especiesValoradas ="";


//  // let gerenciaSubgerencia = $('#gerenciaSubgerencia').val();


//   if(gerenciaSubgerencia === "3") {
//      especiesValoradas = "13,22,25,28,39,40,41,44,45,46,47,48,50,51,52,53,54,56,177,199,201,202,203,204,205,250,515,529,540,541,542,543, 544,545,546,547, 642,715";
//   }
//   else if(gerenciaSubgerencia === "4") {
//      especiesValoradas = "8,10,12,15,18,21,24,27,30,33,35,37,169,170,171,173,174,175,176,240,242,520,521,522,524,525,526,528,530,531,532,536,537,761,765,770";
//   }
//   else if(gerenciaSubgerencia === "5") {
//      especiesValoradas = "514,771,772,773,774";

//   }
//   //falta
//    else if(gerenciaSubgerencia === "6") {
//      especiesValoradas = "105,119,121,220,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399,400,401,402,403,404,405,406,407,408,409,410,411,412,413,414,415,416,417,418,419,425,426,428,548,549,550,551,552,553,554,555,556,557,558,559,560,561,562,563,564,565,566,567,568,569,570,571,572,573,574,575,576,577,578,579,580,581,582,583,584,585,586,587,588,589,590,591,592";

//   }

//   // GERENCIA DE SERVICIOS MUNICIPALES Y GESTION AMBIEN.
//    else if(gerenciaSubgerencia === "7") {
//      especiesValoradas = "445,446,447,448,449,450,451,452,453,454,455,456,457,458,459,460,461,462,463,464,465,466,467,468,469,470,471,472,473,474,475,476,477,478,479,480,481,482,483,484,485,486,533,766";

//   }

//   // 	OFICINA DE ADMINISTRACION FINANCIERA
//    else if(gerenciaSubgerencia === "11") {
//      especiesValoradas = "348,349,350,351,352,353,354,355,356,357,358,359,360";

//   }

//   //Oficina General de Atención al Ciudadano y Gestión Documentaria
//     else if(gerenciaSubgerencia === "18") {
//      especiesValoradas = "1,2,3,4,5,6,196,197,487,488,489,490,491,492,493,494,495,496,497,498,499,500,501,502,534";

//   }
//    // Subgerencia de Fiscalización
//     else if(gerenciaSubgerencia === "22") {
//      especiesValoradas = "38,57,58,59,60,61,206,207,208,209,210,211,212,213,214";

//   }

//   //Subgerencia de Programas Sociales

//    else if(gerenciaSubgerencia === "23") {
//      especiesValoradas = "194,195";

//   }

//    //Subgerencia de Rentas
//    else if(gerenciaSubgerencia === "24") {
//      especiesValoradas = "16,19,31,34,36,42,43,200,512,513";

//   }
   
//    //Subgerencia de Servicios Sociales
//    else if(gerenciaSubgerencia === "25") {
//      especiesValoradas = "535";

//   }

//    //Subgerencia Ambiental
//    else if(gerenciaSubgerencia === "26") {
//      especiesValoradas = "523,768";

//   }
//   //Subgerencia de Comercio, Licencias y Control Sanitario
//    else if(gerenciaSubgerencia === "27") {
//      especiesValoradas = "269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343";

//   }

//   //Subgerencia de Desarrollo Económico y Productivo

//    else if(gerenciaSubgerencia === "28") {
//      especiesValoradas = "344,345,346,347";

//   }

//   //ubgerencia de Desarrollo Territorial
//   else if(gerenciaSubgerencia === "29") {
//      especiesValoradas = "62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,106,107,108,109,110,111,112,113,114,115,116,117,118,120,122,123,129,130,131,132,133,134,135,136,137,215,216,217,218,219,361,362,363,364,365,366,367,516,517,518,519,596,704,705,763";

//   }

//   //Subgerencia de Infraestructura
//    else if(gerenciaSubgerencia === "30") {
//      especiesValoradas = "124,125,126,128,420,421,422,423,424,427,429,430,695";

//   }
//   //Subgerencia de Participación y Seguridad Ciudadana
//    else if(gerenciaSubgerencia === "31") {
//      especiesValoradas = "7,9,11,14,17,20,23,26,29,32,198";

//   }

//   //Subgerencia de Servicios Municipales
//      else if(gerenciaSubgerencia === "32") {
//      especiesValoradas = "127,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,221,222,223,224,225,226,227,228,229,230,706,714";

//   }

//     //Oficina de Registro Civil
//    else if(gerenciaSubgerencia === "33") {
//      especiesValoradas = "178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,231,232,233,234,235,236,237,238,239,241,243,244,245,246,247,248,503,504,505,506,507,508,509,510,511,527,710,711";

//   }

//     //Unidad de Transportes y Seguridad Vial
//    else if(gerenciaSubgerencia === "34") {
//      especiesValoradas = "249,259,260,431,432,433,434,435,436,437,438,439,440,441,442,443,444";

//   }

//     //Área Funcional de Mercados y Comercialización
//    else if(gerenciaSubgerencia === "35") {
//      especiesValoradas = "172,538,539";

//   }
//   else if(gerenciaSubgerencia === "37") {
//      especiesValoradas = "738,739,740,741,742,743,744,745,746,747,748,749,750,751,752,753,754,755,756,757,758,759,760";

//   }
//   else if(gerenciaSubgerencia === "38") {
//      especiesValoradas = "769";

//   }

//   // if (!fechaInicio || !fechaFin || !gerenciaSubgerencia) {
//   //   alert('Por favor seleccione las fechas de inicio y fin.');
//   //   return;
//   // }

//   // reporteGeneralArea_.fechaFiltroInicio = fechaInicio;
//   // reporteGeneralArea_.fechaFiltroFin = fechaFin;
 

//   const datos = new FormData();
//     datos.append(tipoReporte, tipoReporte);
//     datos.append("fechaInicio", fechaInicio);
//     datos.append("fechaFin", fechaFin);
//     datos.append("especiesValoradas", especiesValoradas);
//     datos.append("idArea", gerenciaSubgerencia);

//     // ✅ Imprimir todos los datos del FormData
//     for (let [clave, valor] of datos.entries()) {
//       console.log(`${clave}: ${valor}`);
//     }



//   const ctx = $(`#${canvasId}`)[0].getContext('2d');

//   $.ajax({
//     url: "ajax/reporteGeneralArea.ajax.php",
//     method: "POST",
//     data: datos,
//     cache: false,
//     contentType: false,
//     processData: false,
//     success: function (respuesta) {

//       console.log(`📊 Respuesta-------HH ${tipoReporte}:`, respuesta);

//       let data = respuesta;
//       let etiquetas = [];
//       let cantidades = [];


//       if (tipoReporte === "reporte_tributaria_proveido" && Array.isArray(data) && data.length > 0) {
//           etiquetas = data.map(item => item.Nombre_Especie);
//           cantidades = data.map(item => parseFloat(item.valor_total));

//           // ✅ Calcular total
//           const total = cantidades.reduce((a, b) => a + b, 0).toLocaleString('es-PE', {
//             style: 'currency',
//             currency: 'PEN',
//             minimumFractionDigits: 2
//           });
//           $(`#totalAdmTriPro`).text(`Monto total proveído: ${total}`);

//           // ✅ Destruir gráfico anterior si existe
//           if (chartTributariaProveido) chartTributariaProveido.destroy();

//           // ✅ Resetear tamaño del canvas (para que Chart.js maneje el escalado)
//           ctx.canvas.style.width = "100%";
//           ctx.canvas.style.height = `${Math.max(500, data.length * 22)}px`;
//           ctx.canvas.removeAttribute("width");
//           ctx.canvas.removeAttribute("height");

//           // ✅ Ajustar estilos del contenedor
//           $(`#${canvasId}`).parent().css({
//             width: "100%",
//             display: "flex",
//             justifyContent: "center",
//             alignItems: "center",
//             padding: "0",
//             margin: "0"
//           });

//           // ✅ Crear gráfico con escalado automático y texto nítido
//           chartTributariaProveido = new Chart(ctx, {
//             type: 'bar',
//             data: {
//               labels: etiquetas,
//               datasets: [{
//                 label: "Monto (S/)",
//                 data: cantidades,
//                 backgroundColor: color,
//                 borderColor: color,
//                 borderWidth: 1,
//                 barPercentage: 0.6
//               }]
//             },
//             options: {
//               indexAxis: 'y',
//               responsive: true,            // ✅ Deja que Chart.js ajuste resolución
//               maintainAspectRatio: false,  // ✅ Permite altura dinámica
//               layout: { padding: 0 },
//               scales: {
//                 x: {
//                   beginAtZero: true,
//                   title: {
//                     display: true,
//                     text: 'Monto (S/)',
//                     color: '#333',
//                     font: { size: 12, weight: 'bold' }
//                   },
//                   ticks: { color: '#000', font: { size: 13 } },
//                   grid: { drawBorder: true, drawOnChartArea: false }
//                 },
//                 y: {
//                   ticks: { autoSkip: false, color: '#000', font: { size: 12 }, padding: 4 },
//                   grid: { drawBorder: false, drawOnChartArea: false }
//                 }
//               },
//               plugins: {
//                 legend: { display: false },
//                 tooltip: {
//                   callbacks: {
//                     label: (context) => `S/ ${parseFloat(context.raw).toLocaleString('es-PE', {
//                       minimumFractionDigits: 2
//                     })}`
//                   }
//                 },
//                 title: {
//                   display: true,
//                   text: 'Monto Proveído por Especie',
//                   font: { size: 15, weight: 'bold' },
//                   color: '#111'
//                 }
//               }
//             }
//           });

//           return;
//         }





//       // 🟦 Resto de reportes (gráfico simple)
//       if (data.length > 0 && data[0].length > 0 && data[0][0] !== null) {

//         etiquetas.push(label);
//         cantidades.push(parseFloat(data[0][0]));

//       } else {
//         console.log("No se encontraron datos válidos.");
//         $(`#${totalId}`).text("Monto total: S/ 0.00");
//         return;
//       }

//       const total = cantidades[0].toLocaleString('es-PE', {
//         style: 'currency',
//         currency: 'PEN',
//         minimumFractionDigits: 2
//       });
//       $(`#${totalId}`).text(`Monto total: ${total}`);

//       if (tipoReporte === "reporte_general_tributaria" && chartTributaria) chartTributaria.destroy();
//       if (tipoReporte === "reporte_general_agua" && chartAgua) chartAgua.destroy();

//       ctx.canvas.height = 460;
//       ctx.canvas.width = 200;

//       // Aplicar clases CSS
//       $(`#${canvasId}`).parent().addClass("chart-container-centered");
//       $(ctx.canvas).addClass("fixed-size-chart");

//       const nuevoChart = new Chart(ctx, {
//           type: 'bar',
//           data: {
//               labels: etiquetas,
//               datasets: [{
//                   label: label,
//                   data: cantidades,
//                   backgroundColor: [color],
//                   borderColor: [color],
//                   borderWidth: 1,
//                   barPercentage: 0.4,
//                   categoryPercentage: 0.5
//               }]
//           },
//           options: {
//               responsive: false, // 👈 CRÍTICO: false para dimensiones fijas
//               maintainAspectRatio: false,
//               scales: {
//                   y: {
//                       beginAtZero: true,
//                       title: { display: true, text: 'Monto (S/)' }
//                   }
//               },
//               plugins: {
//                   legend: { display: true },
//                   tooltip: {
//                       callbacks: {
//                           label: (context) => `${context.dataset.label}: ${context.formattedValue}`
//                       }
//                   }
//               }
//           }
//       });


//       if (tipoReporte === "reporte_general_tributaria") chartTributaria = nuevoChart;
//       if (tipoReporte === "reporte_general_agua") chartAgua = nuevoChart;

//     },
//     error: function (xhr, status, error) {
//       console.error(`❌ Error en la solicitud AJAX (${tipoReporte}):`, error);
//     }
//   });
// }

// $(document).ready(function () {

//   $('#btnConsultarReporteArea').on('click', function () {
//     console.log("Botón 'Consultar Reporte' clickeado");

    
//   const fechaInicio = $('#fechaInicioAreaRe').val();
//   const fechaFin = $('#fechaFinAreaRe').val();
//   const gerenciaSubgerencia = $('#gerenciaSubgerencia').val();

//   if (!fechaInicio || !fechaFin || !gerenciaSubgerencia) {
//     alert('Por favor seleccione las fechas de inicio y fin.');
//     return;
//   }


//       generarGrafico({
//     tipoReporte: "reporte_tributaria_proveido",
//     canvasId: "myChartAdmTriProveido",
//     label: "Total Proveído",
//     color: "rgb(23, 191, 172)",
//     totalId: "totalAdmTriProveido",
//     fechaInicio: fechaInicio,
//     fechaFin: fechaFin,
//     gerenciaSubgerencia: gerenciaSubgerencia
//   });

//     // 🔹 Mostrar o limpiar canvas `myChartAdmTri`
//     const canvasTributaria = document.getElementById("myChartAdmTri");
//     const parentTributaria = canvasTributaria.parentNode;
// if (gerenciaSubgerencia === "3") {
//     generarGrafico({
//       tipoReporte: "reporte_general_tributaria",
//       canvasId: "myChartAdmTri",
//       label: "Total Autovaluo",
//       color: "rgb(245, 211, 42)",
//       totalId: "totalAdmTri",
//       fechaInicio: fechaInicio,
//       fechaFin: fechaFin,
//       gerenciaSubgerencia: gerenciaSubgerencia
//     });
//   } else if (gerenciaSubgerencia === "32") {
//     generarGrafico({
//       tipoReporte: "reporte_general_agua",
//       canvasId: "myChartAdmTri",
//       label: "Total Agua",
//       color: "rgb(54, 162, 235)",
//       totalId: "totalAgua",
//       fechaInicio: fechaInicio,
//       fechaFin: fechaFin,
//       gerenciaSubgerencia: gerenciaSubgerencia
//     });
//   } else {
//     // Limpiar canvas si no coincide
//     parentTributaria.innerHTML = `<div class="text-center text-muted p-3">
//       No hay gráfico disponible para esta gerencia.
//     </div>`;
//   }

//   });
// });



// // $(document).ready(function () {
// //   $('#btnConsultarReporteArea').on('click', function () {

    

// //       // 🟡 Gráfico horizontal con scroll
// //     generarGrafico({
// //       tipoReporte: "reporte_tributaria_proveido",
// //       canvasId: "myChartAdmTriProveido",
// //       label: "Total Proveído",
// //       color: "rgb(23, 191, 172)",
// //       totalId: "totalAdmTriProveido"
// //     });



// //     if (gerenciaSubgerencia === "3") {
// //     generarGrafico({
// //       tipoReporte: "reporte_general_tributaria",
// //       canvasId: "myChartAdmTri",
// //       label: "Total Autovaluo",
// //       color: "rgb(245, 211, 42)",
// //       totalId: "totalAdmTri"
// //     });
// //   }

// //    else if (gerenciaSubgerencia === "32") {

// //     generarGrafico({
// //       tipoReporte: "reporte_general_agua",
// //       canvasId: "myChartAdmTri",
// //       label: "Total Agua",
// //       color: "rgb(54, 162, 235)",
// //       totalId: "totalAgua"
// //     });

// //     }else {
// //   // 🟡 Si no coincide con ninguno, limpiar ambos canvas
// //   const canvases = ["myChartAdmTri"];
// //   canvases.forEach(id => {
// //     const ctx = document.getElementById(id);
// //     if (ctx) {
// //       const parent = ctx.parentNode;
// //       parent.innerHTML = `<div class="text-center text-muted p-3">
// //         No hay gráfico disponible para esta gerencia.
// //       </div>`;
// //     }
// //   });
// // }
    

  
// //   });
// // });


