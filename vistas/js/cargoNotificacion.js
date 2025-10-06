class NotificacionCargo {

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
         let anoSeleccionado = $('#anio_orden_cargo option:selected').val();

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

 $("#segundaTablaCargo tbody td:eq(3)").text(formatearNumero(this.totalImporte));
 $("#segundaTablaCargo tbody td:eq(4)").text(formatearNumero(this.totalGasto));
 $("#segundaTablaCargo tbody td:eq(5)").text(formatearNumero(this.totalSubtotal));
 $("#segundaTablaCargo tbody td:eq(6)").text(formatearNumero(this.totalDescuento));
 $("#segundaTablaCargo tbody td:eq(7)").text(formatearNumero(this.totalTIM));
 $("#segundaTablaCargo tbody td:eq(8)").text(formatearNumero(this.totalTotal));
 
}




manejarClicSC(thS) {
  const filas = $("#primeraTablaCargo tbody tr");
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
  $("#segundaTablaCargo tbody td:eq(3)").text(formatearNumero(this.totalImporte));
  $("#segundaTablaCargo tbody td:eq(4)").text(formatearNumero(this.totalGasto));
  $("#segundaTablaCargo tbody td:eq(5)").text(formatearNumero(this.totalSubtotal));
  $("#segundaTablaCargo tbody td:eq(6)").text(formatearNumero(this.totalDescuento));
  $("#segundaTablaCargo tbody td:eq(7)").text(formatearNumero(this.totalTIM));
  $("#segundaTablaCargo tbody td:eq(8)").text(formatearNumero(this.totalTotal));
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
      console.log("Se encontró al menos un valor válido. Se muestra el modal de impresión.");
      $("#Modalimprimir_cuenta_coactivo").modal("show");
  }


  // Construir el objeto FormData
  let datos = new FormData();
  datos.append("id_usuario", general.iso_usuario);
  datos.append("id_area", general.iso_area);
  datos.append("id_cuenta", idsSeleccionados_);
  datos.append("propietarios", Propietarios);
  datos.append("carpeta", predio.carpeta);

     //TOTAL PARA IMPUESTO
     datos.append("totalImporteI", this.totalImporteI.toFixed(2));
    datos.append("totalGastoI", this.totalGastoI.toFixed(2));
    datos.append("totalSubtotalI", this.totalSubtotalI.toFixed(2));
    datos.append("totaldescuentoI", this.totalDescuentoI.toFixed(2));
    datos.append("totalTIMI", this.totalTIMI.toFixed(2));
    datos.append("totalTotalI", this.totalTotalI.toFixed(2));

    //TOTAL PARA ARBITRIOS 
    datos.append("totalImporteA", this.totalImporteA.toFixed(2));
    datos.append("totalGastoA", this.totalGastoA.toFixed(2));
    datos.append("totalSubtotalA", this.totalSubtotalA.toFixed(2));
    datos.append("totaldescuentoA", this.totalDescuentoA.toFixed(2));
    datos.append("totalTIMA", this.totalTIMA.toFixed(2));
    datos.append("totalTotalA", this.totalTotalA.toFixed(2));


    datos.append("totalTotal", this.totalTotal.toFixed(2));

     // Mostrar datos en consola
   console.log(this.totalTotal.toFixed(2))


   console.log("inpueto total",this.totalTotalI)

   console.log("arbitrio total",this.totalTotalA)


   console.log("lo que esta asigando de ajax  "+this.idbackend);

  // Mostrar datos en consola
  for (let pair of datos.entries()) {
      console.log(pair[0] + ': ' + pair[1]);
  }

  // Usar fetch en lugar de $.ajax
  fetch("./vistas/print/imprimirNotificacionCargo.php", {
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


}

// Crear una instancia de la clase ImpuestoCalculator
const notificacionCargo_ = new NotificacionCargo();

/////////////////////////////MODAL COACTIVO//////////////////////////

// Evitar clic directo en el checkbox en COACTIVO
$(".fila-checkbox").on("click", function (event) {
  console.log("has hehco clik")
  event.stopPropagation(); // Evita el evento cuando se hace clic en el checkbox
});

// RESET MODAL COACTIVOS
$("#anio_orden_cargo").change(function() {
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
  $("#segundaTablaCargo tbody td:eq(3)").text(formatearNumero(this.totalImporte));
  $("#segundaTablaCargo tbody td:eq(4)").text(formatearNumero(this.totalGasto));
  $("#segundaTablaCargo tbody td:eq(5)").text(formatearNumero(this.totalSubtotal));
  $("#segundaTablaCargo tbody td:eq(6)").text(formatearNumero(this.totalDescuento));
  $("#segundaTablaCargo tbody td:eq(7)").text(formatearNumero(this.totalTIM));
  $("#segundaTablaCargo tbody td:eq(8)").text(formatearNumero(this.totalTotal));
});

//CLICK EN COLUMA PARA COACTIVO

$("#primeraTablaCargo tbody").on("click", "tr", function () {
  console.log("Diste click en una fila");
  notificacionCargo_.manejarClicFilaC($(this));
});


// CLIK EN ENCABEZADO DE COACTIVO
$("#primeraTablaCargo thead th:eq(0)").on("click", function () {
  //console.log("acabas de dar click aqui")
  notificacionCargo_.manejarClicSC($(this));
});

//IMPRIMIR ESTADO DE CUENTA COACTIVO

$(document).on("click", "#popimprimirCargo", function () {
  // Verificar si el primer modal está visible
  if ($('#modal_vacio_coactivo').hasClass('show')) {
      // Si el primer modal está visible, no mostrar el segundo modal
      console.log("El primer modal está visible, no se mostrará el segundo.");
      return; // Detener ejecución si el primer modal está visible
  }

  // Ejecutar la función que revisa si los valores están vacíos o no
  notificacionCargo_.imprimirherecoactivo();
});



//CERRAR VENTANA ES TA VACIO DE COACTIVO CON OK.
$(document).on("click", ".anio_orden_cargo", function() {
  // Cerrar el modal
  $('#modal_vacio_coactivo').modal('hide');
});

//CLIK PARA MODAL DE ESTADO DE CUENTA COACTIVO
$("#abrirResoCargaNotifi").click(function () {
  $("#modalCargoNotificiacion").modal("show");
});

//PARA CAMBIO DE SEMESTRE Y AÑO DE FRACCIONAMIENTO
$(document).on("change", "#anio_orden_cargo", function () {
  //console.log("estas aqui");
  notificacionCargo_.muestra_deuda();
 });
  
 // AL ABRIR EL MODAL COACTIVO CARGADO TRIMESTRE
 $('#modalCargoNotificiacion').on('show.bs.modal', function () {
   notificacionCargo_.muestra_deuda();
 });
 
///////////////////////////////////////FIN MODAL COACTIVO////////////////////////////

//Eliminar los pdf de los estados de cuenta 
setInterval(notificacionCargo_.eliminarArchivosPDF, 60000);






