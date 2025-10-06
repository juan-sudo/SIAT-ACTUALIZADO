class SuspencionSoclicitud {

  constructor() {
    this.idContribuyente = null;
    this.impuesto_anual = null;
    this.base_imponible = null;
    this.impuesto_trimestral = null;
    this.gasto_emision = null;
    this.total_pagar = null;
    this.selectnum = null;

    this.totalImporte = 0;
    this.totalDescuento = 0;
    this.totalGasto = 0;
    this.totalSubtotal = 0;
    this.totalTIM = 0;
    this.totalTotal = 0;
    this.idsSeleccionados = [];
    this.carpeta=null;

    //AUMENTADO 1
    //IMPUESTO PREDIAL
    this.totalImporteI = 0;
    this.totalDescuentoI = 0;
    this.totalGastoI = 0;
    this.totalSubtotalI = 0;
    this.totalTIMI = 0;
    this.totalTotalI = 0;

     //ARBITRIO MONICIPAL
     this.totalImporteA = 0;
     this.totalDescuentoA = 0;
     this.totalGastoA = 0;
     this.totalSubtotalA = 0;
     this.totalTIMA = 0;
     this.totalTotalA = 0;
     this.idenviadosbd=[];

     //ASIGNADOS
     this.resolucionEjecucion=null;
     this.resolucionMedida=null;
     this.numeroDocumento=null;
     this.fundamentoLegal=[];

    
  }

  //PARA MODAL COACTIVO
  muestra_deuda(){

    this.totalImporteI = 0;
    this.totalGastoI = 0;
    this.totalSubtotalI = 0;
    this.totalDescuentoI = 0;
    this.totalTIMI = 0;
    this.totalTotalI = 0;

    this.totalImporteA = 0;
    this.totalGastoA = 0;
    this.totalSubtotalA = 0;
    this.totalDescuentoA = 0;
    this.totalTIMA = 0;
    this.totalTotalA = 0;

    // Reseteo de los totales a cero
    this.totalGasto = 0;
    this.totalSubtotal = 0;
    this.totalDescuento = 0;
    this.totalTIM = 0;
    this.totalTotal = 0;
    this.totalImporte = 0;
    this.idsSeleccionados = [];
   
        let self=this;
         let datos = new FormData();
         let anoSeleccionado = $('#anio_orden_suspencion option:selected').val();

         this.anio_orden_coactivo=anoSeleccionado;
         this.tipo_tributo_orden = document.getElementById("select_tributo_orden").value;

         datos.append("id_propietarios", predio.Propietarios);
         datos.append("tipo_tributo ", this.tipo_tributo_orden);
         datos.append("anio", this.anio_orden_coactivo);
         datos.append("anio_trimestre",this.anoSeleccionado);
         datos.append("estado_cuenta_orden_anio_co", "estado_cuenta_orden_anio_co");

         for (let pair of datos.entries()) {
             console.log(pair[0] + ': ' + pair[1]);
         }
         $.ajax({
           url: "ajax/caja.ajax.php",
           method: "POST",
           data: datos,
           cache: false,
           contentType: false,
           processData: false,
           success: function (respuesta) {

              // Verifica si la respuesta es válida o si hay error
               if (respuesta.error) {
                 // Si hay un error, no se muestra nada
                 $(".estadocuentacaja").html('');
                 $(".perdidaFraccionamiento").html('');
                 console.log("Ocurrió un error, no se mostró ningún contenido");
                 return;  // Detener ejecución
             }


            // $(".estadocuentacaja").html(respuesta);
             console.log("Respuesta como cadena JSON:", JSON.stringify(respuesta, null, 2));

             
             var content = '';
             self.totalDeuda_ = respuesta.totales[0];
             console.log("total_total mlm"+self.totalDeuda_.Importe);
             respuesta.campos.forEach(function(value) {
               var tributo = (value['Tipo_Tributo'] == '006') ? 'Imp. Predial' : 'Arb. Municipal';
               content += '<tr id="' + value['Id_Estado_Cuenta_Impuesto'] + '">';
                         
               
               content += '<td class="text-center">' +
                           '<input type="checkbox" class="fila-checkbox custom-checkbox" style="width:15px; height:15px; margin:0;" ' +
                           (value['Estado'] === '1' ? 'checked' : '') + ' disabled>' +
                           '</td>';

               content += '<td class="text-center">' + value['Tipo_Tributo'] + '</td>';
               content += '<td class="text-center">' + tributo + '</td>';
               content += '<td class="text-center">' + value['Anio'] + '</td>';
               content += '<td class="text-center">' + (value['Periodo'] === undefined ? '-' : value['Periodo']) + '</td>';
               content += '<td class="text-center">' + value['Total_Importe'] + '</td>';
               content += '<td class="text-center">' + value['Total_Gasto_Emision'] + '</td>';
               content += '<td class="text-center">' + value['Total_Saldo'] + '</td>';
               content += '<td class="text-center">' + value['Total_Descuento'] + '</td>';
               content += '<td class="text-center">' + value['Total_TIM_Aplicar'] + '</td>';
               content += '<td class="text-center">' + value['Total_Aplicar_Anual'] + '</td>';
               content += '</tr>';  // Asegúrate de cerrar el tr aquí
             });
           
             $(".perdidaFraccionamiento").html(content);
             self.actualizarTotales(); // Llamar la func
             // Actualizar los totales
      
           },
            error: function(xhr, status, error) {
             // Si ocurre un error en la petición AJAX, no mostrar nada
     
             $(".perdidaFraccionamiento").html('');
             console.log("Ocurrió un error al realizar la solicitud AJAX: " + error);
         }
           
         });
       
 }

 // MODAL COACTIVO ACTUALIZAR 00 TOTAL
actualizarTotales() {
 // Mostrar los totales actualizados
 const formatearNumero = (numero) => {
     return numero.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
 };

 $("#segundaTablaSuspencion tbody td:eq(3)").text(formatearNumero(this.totalImporte));
 $("#segundaTablaSuspencion tbody td:eq(4)").text(formatearNumero(this.totalGasto));
 $("#segundaTablaSuspencion tbody td:eq(5)").text(formatearNumero(this.totalSubtotal));
 $("#segundaTablaSuspencion tbody td:eq(6)").text(formatearNumero(this.totalDescuento));
 $("#segundaTablaSuspencion tbody td:eq(7)").text(formatearNumero(this.totalTIM));
 $("#segundaTablaSuspencion tbody td:eq(8)").text(formatearNumero(this.totalTotal));
 
}




manejarClicSC(thS) {
  const filas = $("#primeraTablaSuspencion tbody tr");
  const todasSeleccionadas = filas.find(".fila-checkbox:not(:checked)").length === 0;

  filas.each((index, fila) => {
      const checkbox = $(fila).find(".fila-checkbox");

      if (todasSeleccionadas) {

        filas.each((index, fila) => {
          const checkbox = $(fila).find(".fila-checkbox");
          if (checkbox.is(":checked")) {
            this.manejarClicFilaC($(fila));
          }
        });

                   // ✅ Reiniciar todos los totales después de desseleccionar
            this.totalImporte = 0;
            this.totalGasto = 0;
            this.totalSubtotal = 0;
            this.totalDescuento = 0;
            this.totalTIM = 0;
            this.totalTotal = 0;

            this.totalImporteI = 0;
            this.totalGastoI = 0;
            this.totalSubtotalI = 0;
            this.totalDescuentoI = 0;
            this.totalTIMI = 0;
            this.totalTotalI = 0;

            this.totalImporteA = 0;
            this.totalGastoA = 0;
            this.totalSubtotalA = 0;
            this.totalDescuentoA = 0;
            this.totalTIMA = 0;
            this.totalTotalA = 0;

            this.idsSeleccionados = [];
            this.idenviadosbd = [];

            this.actualizarTotales();

      } else {
          // Seleccionar todas
          if (!checkbox.is(":checked")) {
              this.manejarClicFilaC($(fila));
          }
      }
  });

  thS.text(todasSeleccionadas ? "S" : "S");
}


manejarClicFilaC(fila) {

  const tipoTText = fila.find("td:eq(1)").text().trim();
  const periodoFila = fila.find("td:eq(4)").text().trim();
  const importe = parseFloat(fila.find("td:eq(5)").text().trim()) || 0;
  const gasto = parseFloat(fila.find("td:eq(6)").text().trim()) || 0;
  const subtotal = parseFloat(fila.find("td:eq(7)").text().trim()) || 0;
  const descuento = parseFloat(fila.find("td:eq(8)").text().trim()) || 0;
  const tim = parseFloat(fila.find("td:eq(9)").text().trim()) || 0;
  const total = parseFloat(fila.find("td:eq(10)").text().trim()) || 0;
  
  const checkbox = fila.find(".fila-checkbox");
  const filaId = fila.attr("id");

  const esTipoI = tipoTText === '006';
  const esTipoA = tipoTText === '742';

  const IsPeriodo = periodoFila === '-';
 
  if (checkbox.is(":checked")) {

    const index = this.idsSeleccionados.indexOf(filaId);
    if (index > -1) {
        this.idsSeleccionados.splice(index, 1);
    }
      // Si está marcado, deseleccionar
      this.totalGasto -= gasto;
      this.totalSubtotal -= subtotal;
      this.totalDescuento -= descuento;
      this.totalTIM -= tim;
      this.totalTotal -= total;
      this.totalImporte -= importe;


       // También restar del tipo correspondiente
       if (esTipoI) {
        this.totalImporteI -= importe;
        this.totalGastoI -= gasto;
        this.totalSubtotalI -= subtotal;
        this.totalDescuentoI -= descuento;
        this.totalTIMI -= tim;
        this.totalTotalI -= total;
      }

      if (esTipoA) {
        this.totalImporteA -= importe;
        this.totalGastoA -= gasto;
        this.totalSubtotalA -= subtotal;
        this.totalDescuentoA -= descuento;
        this.totalTIMA -= tim;
        this.totalTotalA -= total;
      }


      fila.css("background-color", "");
      checkbox.prop("checked", false);

      if(IsPeriodo){

        let datos = new FormData();

        datos.append("id_selecionado", JSON.stringify(this.idsSeleccionados));

        datos.append("obtener_ids_de_id", "obtener_ids_de_id");

              let self = this;  // Guarda una referencia al objeto de la clase

              $.ajax({
                url: "ajax/caja.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                
                    console.log("✅ Respuesta recibida del backend:", respuesta);


                    self.idenviadosbd=respuesta;

                    console.log("aqui tiene valor", self.idenviadosbd);

                    // Asignar la respuesta a la propiedad idenviadosbd
                    // this.idenviadosbd = Array.isArray(respuesta) ? respuesta : []; // Asegurarse de que sea un array


                  //  Verifica si la respuesta es un array
                    if (Array.isArray(respuesta)) {
                        respuesta.forEach(id => {
                            console.log("📦 ID recibido:", id);
                            
                            // Asigna los IDs al array 'idenviadosbd'
                            this.idenviadosbd.push(id);
                        });
                        // Ver el contenido completo del array después de la actualización
                        console.log("ID enviados:", this.idenviadosbd);
                    } else {
                        console.warn("❌ No se recibió un array:", respuesta);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("❌ Error en AJAX:", error);
                }
              });

       
              console.log("aqui esta vacio", this.idenviadosbd);

          }

     
  } else {
      // Si no está marcado, seleccionar
      this.totalGasto += gasto;
      this.totalSubtotal += subtotal;
      this.totalDescuento += descuento;
      this.totalTIM += tim;
      this.totalTotal += total;
      this.totalImporte += importe;


        if (esTipoI) {
      this.totalImporteI += importe;
      this.totalGastoI += gasto;
      this.totalSubtotalI += subtotal;
      this.totalDescuentoI += descuento;
      this.totalTIMI += tim;
      this.totalTotalI += total;
    }

    if (esTipoA) {
      this.totalImporteA += importe;
      this.totalGastoA += gasto;
      this.totalSubtotalA += subtotal;
      this.totalDescuentoA += descuento;
      this.totalTIMA += tim;
      this.totalTotalA += total;
    }

      console.log("aqui total: "+this.totalImporte)

      fila.css("background-color", "rgb(252, 209, 229)");
      checkbox.prop("checked", true);

      if (!this.idsSeleccionados.includes(filaId)) {
          this.idsSeleccionados.push(filaId);
      }

       if(IsPeriodo){

        let datos = new FormData();


      //  datos.append("id_selecionado", this.idsSeleccionados.join(","));
        datos.append("id_selecionado", JSON.stringify(this.idsSeleccionados));

        // datos.append("id_selecionado", this.idsSeleccionados);

        datos.append("obtener_ids_de_id", "obtener_ids_de_id");

              let self = this;  // Guarda una referencia al objeto de la clase

              $.ajax({
                url: "ajax/caja.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                
                    console.log("✅ Respuesta recibida del backend:", respuesta);

                    self.idenviadosbd=respuesta;
   
              console.log("aqui tiene valor", self.idenviadosbd);

                  //  Verifica si la respuesta es un array
                    if (Array.isArray(respuesta)) {
                        respuesta.forEach(id => {
                            console.log("📦 ID recibido:", id);
                            
                            // Asigna los IDs al array 'idenviadosbd'
                            this.idenviadosbd.push(id);
                        });
                        // Ver el contenido completo del array después de la actualización
                        console.log("ID enviados:", this.idenviadosbd);
                    } else {
                        console.warn("❌ No se recibió un array:", respuesta);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("❌ Error en AJAX:", error);
                }
              });

       
              console.log("aqui esta vacio", this.idenviadosbd);

          }
          
      console.log("total PERIORDO sumado",this.totalTotalI);
      console.log("total ANIO suamdo",this.totalTotalA);
  }


  console.log("Total Importe 1:", this.totalImporte);
  console.log("Total Gasto:", this.totalGasto);
  console.log("Total Subtotal:", this.totalSubtotal);
  console.log("Total Descuento:", this.totalDescuento);
  console.log("Total TIM:", this.totalTIM);
  console.log("Total Total:", this.totalTotal);



  const formatearNumero = (numero) => {
    return numero.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
};

  // Actualizar totales
  $("#segundaTablaSuspencion tbody td:eq(3)").text(formatearNumero(this.totalImporte));
  $("#segundaTablaSuspencion tbody td:eq(4)").text(formatearNumero(this.totalGasto));
  $("#segundaTablaSuspencion tbody td:eq(5)").text(formatearNumero(this.totalSubtotal));
  $("#segundaTablaSuspencion tbody td:eq(6)").text(formatearNumero(this.totalDescuento));
  $("#segundaTablaSuspencion tbody td:eq(7)").text(formatearNumero(this.totalTIM));
  $("#segundaTablaSuspencion tbody td:eq(8)").text(formatearNumero(this.totalTotal));
  console.log("Ids seleccionados:", this.idsSeleccionados);

  
 
}


//IMPRIMIR COACTIVO
  
imprimirherecoactivo() {
   
  const Propietarios_ = [];
  $("#id_propietarios tr").each(function (index) {
      var idFila = $(this).attr("id_contribuyente");
      Propietarios_[index] = idFila;
  });

  const Propietarios = Propietarios_.map(valor => parseInt(valor, 10));
  //const idsSeleccionados_ = this.idsSeleccionados.map(valor => parseInt(valor, 10));
   let idsSeleccionados_ = [];

    if (this.idenviadosbd && this.idenviadosbd.length > 0) {
        // Si this.idenviadosbd no está vacío, se asignan sus valores.
        idsSeleccionados_ = this.idenviadosbd.map(valor => parseInt(valor, 10));
    } else {
        // Si this.idenviadosbd está vacío, se asignan los valores de this.idsSeleccionados.
        idsSeleccionados_ = this.idsSeleccionados.map(valor => parseInt(valor, 10));
    }
    
  console.log("esat es el valro de I",this.totalTotalI);
  console.log("esat es el valro de I",this.totalTotalA);

  if (
      (this.totalTotalI == null || this.totalTotalA == null) || 
      (this.totalTotalI === 0 && this.totalTotalA === 0)
  ) {
      // Mostrar el primer modal si ambos son 0 o si algún valor es null/undefined
      $('#modal_vacio_coactivo').modal('show');
      console.log("Ambos valores son 0 o alguno es nulo. Se muestra el primer modal.");
      return;
  } else {
      // Mostrar el segundo modal si al menos uno tiene valor distinto de 0
      //console.log("Se encontró al menos un valor válido. Se muestra el modal de impresión.");
     // $("#Modalimprimir_cuenta_coactivo").modal("show");


     
     
      $("#modal_solicitud_suspencion").modal("show");

      let id_usuario=general.iso_usuario;
      let id_area=general.iso_area;
      let id_cuenta=idsSeleccionados_;
      let carpeta=predio.carpeta;

      let total_importe=this.totalImporteI.toFixed(2);
      let total_gasto= this.totalGastoI.toFixed(2);
      let total_subtotal=this.totalSubtotalI.toFixed(2);
      let total_descuento=this.totalDescuentoI.toFixed(2);
      let total_tim=this.totalTIM.toFixed(2);
      let total_total=this.totalTotalI.toFixed(2);

      let total_importeA=this.totalTotal.toFixed(2);


       
        // Asociamos el evento click al botón "OK"
      $(".print_orden_aviso_ok_18").click(function() {

        console.log("Botón OK clickeado");
          // Capturamos los datos del formulario
        
       suspencionSolicitud_.captureModalData();

           // Validar que fundamentoLegal no esté vacío antes de proceder
    if (suspencionSolicitud_.fundamentoLegal.length === 0) {
        alert("No se han seleccionado fundamentos legales.");
        return;  // Detener la ejecución si no se han seleccionado fundamentos legales
    }

          // Validar todos los campos
    

    //  if (!pagoRequerimiento_.numeroCuota || pagoRequerimiento_.numeroCuota === "" || pagoRequerimiento_.numeroCuota <= 0) {
    //     alert("Por favor, ingrese un número de cuota válido (mayor que 0).");
    //     return; // Detener ejecución si el campo numeroCuota está vacío, es igual a 0 o es negativo
    // }
    //     if (!pagoRequerimiento_.anioFiscalg || pagoRequerimiento_.anioFiscalg === "") {
    //         alert("Por favor, seleccione un año fiscal.");
    //         return; // Detener ejecución si el campo anioFiscalg está vacío
    //     }

    //     if (!pagoRequerimiento_.fechaVencimeinto || pagoRequerimiento_.fechaVencimeinto === "") {
    //         alert("Por favor, seleccione la fecha de vencimiento.");
    //         return; // Detener ejecución si el campo fechaVencimeinto está vacío
    //     }


  
      let datos = new FormData();
      
      datos.append("id_usuario", id_usuario);
      datos.append("id_area", id_area);
      datos.append("id_cuenta", id_cuenta);
      datos.append("propietarios", Propietarios);
      datos.append("carpeta", carpeta);

     //TOTAL PARA IMPUESTO
       datos.append("totalImporteI",total_importe );
      datos.append("totalGastoI", total_gasto);
      datos.append("totalSubtotalI", total_subtotal);
      datos.append("totaldescuentoI", total_descuento);
      datos.append("totalTIMI", total_tim);
      datos.append("totalTotalI", total_total);
      datos.append("totalTotal",total_importeA);

  // Agregar los valores de tipoTributario, numeroCuota y anioFiscalg capturados


      datos.append("resolucionEjecucion", suspencionSolicitud_.resolucionEjecucion);
      datos.append("resolucionMedida", suspencionSolicitud_.resolucionMedida);
      datos.append("numeroDocumento", suspencionSolicitud_.numeroDocumento);
        datos.append("fundamentoLegal", JSON.stringify(suspencionSolicitud_.fundamentoLegal));
    
     
        // Mostrar datos en consola
        for (let pair of datos.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Usar fetch en lugar de $.ajax
        fetch("./vistas/print/imprimirSolicitudSuspencion.php", {
            method: "POST",
            body: datos
        })
        .then(response => {
          console.log(response);
            if (!response.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return response.text(); // O .json() si esperas un JSON
        })
        .then(rutaArchivo => {
            document.getElementById("iframec").src = 'vistas/print/' + rutaArchivo;
        })
        .catch(error => {
            console.error("Error en la solicitud fetch:", error);
        })
        .finally(() => {
            console.log("Solicitud fetch completada.");
        });

          $('#modal_solicitud_suspencion').modal('hide');

               // Limpiar los campos del formulario
    

          // Mostrar el segundo modal
          $("#Modalimprimir_cuenta_coactivo").modal("show");

           suspencionSolicitud_.limpiarCampos();
          
      });

      // Limpiar los campos del formulario cuando el modal se cierre
      $('#modal_solicitud_suspencion').on('hidden.bs.modal', function () {
          suspencionSolicitud_.limpiarCampos();
      });





  }





}


//////////////////////FIN MODAL COACTIVO///////////////////////////////



  eliminarArchivosPDF() {
    // Realiza una solicitud al servidor para eliminar archivos PDF
    fetch('ajax/controlPDF.ajax.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({}),
    })
      .then((response) => {
        if (response.status === 200) {
          console.log('Archivos PDF eliminados con éxito.');
        } else {
          console.error('Error al eliminar archivos PDF.');
        }
      })
      .catch((error) => {
        console.error('Error en la solicitud:', error);
      });
  }

   limpiarCampos() {
    // Limpiar select (Tipo Tributario)
    // document.getElementById("tipoTributario").selectedIndex = 0;

    // // Limpiar input (Número de Cuota)
    // document.getElementById("numeroCuota").value = "";

    // // Limpiar select (Año Fiscal)
    // document.getElementById("anioFiscalg").selectedIndex = 0;

    // // Limpiar input (Fecha Vencimiento)
    // document.getElementById("fechaVenc
    // imiento").value = "";
}


captureModalData() {
    // Obtener los valores de los campos fuera de la tabla
    this.resolucionEjecucion = document.getElementById("resolucionEjecucion18").value;
    this.resolucionMedida = document.getElementById("resolucionMedida18").value;
    this.numeroDocumento = document.getElementById("numeroDocumento18").value;

    this.fundamentoLegal = [];

    // Recorrer las filas de la tabla y capturar datos solo si el checkbox está marcado
    $('#modal_solicitud_suspencion table tbody tr').each((index, row) => {
        const checkbox = $(row).find('.checkbox'); // Obtener el checkbox
        if (checkbox.is(':checked')) { // Si el checkbox está marcado
            const descripcion = $(row).find('td:eq(1)').text().trim(); // Obtener la descripción

            // Obtener los valores de los input de cada fila
            const resolucion = $(row).find('td:eq(2) input').val(); // Obtener el valor de N° Resolución
            const expediente = $(row).find('td:eq(3) input').val(); // Obtener el valor de N° Expediente
            const fecha = $(row).find('td:eq(4) input').val(); // Obtener el valor de la fecha

            // Asegúrate de que los valores no sean undefined ni null antes de hacer .trim()
            const resolucionVal = resolucion ? resolucion.trim() : ''; // Si resolucion está vacío, usar valor por defecto
            const expedienteVal = expediente ? expediente.trim() : ''; // Si expediente está vacío, usar valor por defecto
            const fechaVal = fecha ? fecha.trim() : ''; // Si fecha está vacío, usar valor por defecto

            // Agregar los datos al arreglo fundamentoLegal
            this.fundamentoLegal.push({
                descripcion: descripcion,
                resolucion: resolucionVal,
                expediente: expedienteVal,
                fecha: fechaVal
            });

            // Mostrar los resultados en consola para depuración (opcional)
            console.log("Fundamento Legal Capturado:", {
                descripcion: descripcion,
                resolucion: resolucionVal,
                expediente: expedienteVal,
                fecha: fechaVal
            });
        }
    });

    // Mostrar los resultados en formato JSON en el div 'resultados' (opcional)
    $('#resultados').html('<pre>' + JSON.stringify(this.fundamentoLegal, null, 2) + '</pre>');
}

}

// Crear una instancia de la clase ImpuestoCalculator
const suspencionSolicitud_ = new SuspencionSoclicitud();

/////////////////////////////MODAL COACTIVO//////////////////////////

// Evitar clic directo en el checkbox en COACTIVO
$(".fila-checkbox").on("click", function (event) {
  console.log("has hehco clik")
  event.stopPropagation(); // Evita el evento cuando se hace clic en el checkbox
});

// RESET MODAL COACTIVOS
$("#anio_orden_suspencion").change(function() {
  // Reset all totals
  this.totalGasto = 0;
  this.totalSubtotal = 0;
  this.totalDescuento = 0;
  this.totalTIM = 0;
  this.totalTotal = 0;
  this.totalImporte = 0;
  this.idsSeleccionados = [];


   //IMPUESTO PREDIAL
   this.totalImporteI = 0;
   this.totalDescuentoI = 0;
   this.totalGastoI = 0;
   this.totalSubtotalI = 0;
   this.totalTIMI = 0;
   this.totalTotalI = 0;

    //ARBITRIO MONICIPAL
    this.totalImporteA = 0;
    this.totalDescuentoA = 0;
    this.totalGastoA = 0;
    this.totalSubtotalA = 0;
    this.totalTIMA = 0;
    this.totalTotalA = 0;


    this.idenviadosbd=[];

  // Log the reset values to the console
  console.log("Valores reseteados a cero");
  console.log("Total Gasto:", this.totalGasto);
  console.log("Total Subtotal:", this.totalSubtotal);
  console.log("Total Descuento:", this.totalDescuento);
  console.log("Total TIM:", this.totalTIM);
  console.log("Total Total:", this.totalTotal);
  console.log("Total Importe:", this.totalImporte);

  // Optionally, you can update the UI or table with the new totals if needed
  const formatearNumero = (numero) => {
      return numero.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  };

  // Clear or reset the displayed totals
  $("#segundaTablaAcumulacion tbody td:eq(3)").text(formatearNumero(this.totalImporte));
  $("#segundaTablaAcumulacion tbody td:eq(4)").text(formatearNumero(this.totalGasto));
  $("#segundaTablaAcumulacion tbody td:eq(5)").text(formatearNumero(this.totalSubtotal));
  $("#segundaTablaAcumulacion tbody td:eq(6)").text(formatearNumero(this.totalDescuento));
  $("#segundaTablaAcumulacion tbody td:eq(7)").text(formatearNumero(this.totalTIM));
  $("#segundaTablaAcumulacion tbody td:eq(8)").text(formatearNumero(this.totalTotal));
});

//CLICK EN COLUMA PARA COACTIVO

$("#primeraTablaSuspencion tbody").on("click", "tr", function () {
  console.log("Diste click en una fila");
  suspencionSolicitud_.manejarClicFilaC($(this));
});


// CLIK EN ENCABEZADO DE COACTIVO
$("#primeraTablaSuspencion thead th:eq(0)").on("click", function () {
  //console.log("acabas de dar click aqui")
  suspencionSolicitud_.manejarClicSC($(this));
});

//IMPRIMIR ESTADO DE CUENTA COACTIVO

$(document).on("click", "#popimprimirSuspencion", function () {
  // Verificar si el primer modal está visible
  if ($('#modal_vacio_coactivo').hasClass('show')) {
      // Si el primer modal está visible, no mostrar el segundo modal
      console.log("El primer modal está visible, no se mostrará el segundo.");
      return; // Detener ejecución si el primer modal está visible
  }

  // Ejecutar la función que revisa si los valores están vacíos o no
  suspencionSolicitud_.imprimirherecoactivo();
});



//CERRAR VENTANA ES TA VACIO DE COACTIVO CON OK.
$(document).on("click", ".anio_orden_suspencion", function() {
  // Cerrar el modal
  $('#modal_vacio_coactivo').modal('hide');
});

//CLIK PARA MODAL DE ESTADO DE CUENTA COACTIVO
$("#abrirResoSuspencion").click(function () {
  $("#modalFormatoSuspencion").modal("show");
});

//PARA CAMBIO DE SEMESTRE Y AÑO DE FRACCIONAMIENTO
$(document).on("change", "#anio_orden_suspencion", function () {
  //console.log("estas aqui");
  suspencionSolicitud_.muestra_deuda();
 });
  
 // AL ABRIR EL MODAL COACTIVO CARGADO TRIMESTRE
 $('#modalFormatoSuspencion').on('show.bs.modal', function () {
   suspencionSolicitud_.muestra_deuda();
 });


  $(document).ready(function() {


     
    });
 
///////////////////////////////////////FIN MODAL COACTIVO////////////////////////////

//Eliminar los pdf de los estados de cuenta 
setInterval(suspencionSolicitud_.eliminarArchivosPDF, 60000);






