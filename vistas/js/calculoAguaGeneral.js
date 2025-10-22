class CalculoGeneralAguaClass {
  constructor() {
    this.anioCalcular = null;
    this.anioBase = null;
  }
}

const calculoGeneralAgua_ = new CalculoGeneralAguaClass();

// ✅ Cuando hace clic en "Sí, Calcular"
$(document).on("click", "#btnCalculoGeneralAgua", function () {
  calculoGeneralAgua_.anioCalcular = $("#anioCalcular").val();
  calculoGeneralAgua_.anioBase = $("#anioBase").val();

  // 🔹 Ocultar el modal de confirmación antes de mostrar el de carga
  $("#modal_calcular_agua").modal('hide');

  // 🔹 Mostrar modal de carga
  $("#modalCargando").modal('show');
  actualizarProgreso(10);

  let datos = new FormData();
  datos.append("anioCalcular", calculoGeneralAgua_.anioCalcular);
  datos.append("anioBase", calculoGeneralAgua_.anioBase);
  datos.append("calcularEstadoAgua", "calcularEstadoAgua");

  fetch("ajax/calculoAguaEstado.ajax.php", {
    method: "POST",
    body: datos,
  })
    .then(response => {
      actualizarProgreso(60);
      return response.text();
    })

    .then(respuesta => {

      console.log("✅ Cálculo finalizado correctamente.");
      console.log("holaaaaa", respuesta)
      actualizarProgreso(90);

      // Si existe tabla donde mostrar respuesta
      const cuerpoTabla = document.getElementById("cuerpoTabla");
      if (cuerpoTabla) cuerpoTabla.innerHTML = respuesta;

      // 🔹 Finaliza la barra y cierra el modal luego de un breve tiempo
      setTimeout(() => {
        actualizarProgreso(100);
        setTimeout(() => $("#modalCargando").modal('hide'), 600);
      }, 500);

    })
    .catch(error => {
      console.error("❌ Error:", error);
      actualizarProgreso(0);
      $("#modalCargando").modal('hide');
      alert("Hubo un error al procesar el cálculo: " + error);
    });
});

// ✅ Función de actualización segura
function actualizarProgreso(porcentaje) {
  const barra = document.getElementById("barraProgresoInterna");
  if (!barra) {
    console.warn("⚠️ No se encontró la barra de progreso en el DOM.");
    return;
  }
  barra.style.width = porcentaje + "%";
  barra.setAttribute("aria-valuenow", porcentaje);
  barra.textContent = porcentaje + "%";
}

// ✅ Modal que pregunta si desea generar
$(document).on("click", "#popCalcularEstadoCuenta", function () {
  $("#modal_calcular_agua").modal("show");
});



// class CalculoGeneralAguaClass {
//   constructor() {
//     this.anioCalcular = null;
//     this.anioBase = null;
//   }
// }

// const calculoGeneralAgua_ = new CalculoGeneralAguaClass();


//  $(document).on("click", "#btnCalculoGeneralAgua", function () {
//     calculoGeneralAgua_.anioCalcular = $("#anioCalcular").val();
//     calculoGeneralAgua_.anioBase = $("#anioBase").val();

//     // Mostrar modal con barra
//     $("#modalCargando").modal('show');
//     actualizarProgreso(10); // Empieza al 10%

//     let datos = new FormData();
//     datos.append("anioCalcular", calculoGeneralAgua_.anioCalcular);
//     datos.append("anioBase", calculoGeneralAgua_.anioBase);
//     datos.append("calcularEstadoAgua", "calcularEstadoAgua");

//     fetch("ajax/calculoEstadoAgua.ajax.php", {
//       method: "POST",
//       body: datos,
//     })
//       .then(response => {
//         actualizarProgreso(60); // mitad del proceso
//         return response.text();
//       })
//       .then(respuesta => {

//          $("#modalCargando").modal('hide');

//         console.log("Actualizando resultados...");

//         actualizarProgreso(90);

         

//         // Si existe tabla donde mostrar respuesta
//         const cuerpoTabla = document.getElementById("cuerpoTabla");
//         if (cuerpoTabla) cuerpoTabla.innerHTML = respuesta;

      

//         // Finaliza la barra con una breve animación
//         setTimeout(() => {
//           actualizarProgreso(100);
//           setTimeout(() => $("#modalCargando").modal('hide'), 500);

//         }, 500);
//       })
//       .catch(error => {
//         actualizarProgreso(0);
//         $("#modalCargando").modal('hide');
//         alert("Hubo un error al procesar el cálculo: " + error);
//       });
//   });

//   // ✅ Función de actualización segura
//   function actualizarProgreso(porcentaje) {
//     const barra = document.getElementById("barraProgresoInterna");
//     if (!barra) {
//       console.warn("⚠️ No se encontró la barra de progreso en el DOM.");
//       return;
//     }

//     barra.style.width = porcentaje + "%";
//     barra.setAttribute("aria-valuenow", porcentaje);
//     barra.textContent = porcentaje + "%";
//   }





// //MODAL PREGUTA SI DESA GENERAR
// $(document).on("click", "#popCalcularEstadoCuenta", function () {
 
   
//   //  consulta_deuda_agua_lista.imprimirhere_agua_n();
//    // $("#Modalimprimir_cuentaagua_n").modal("show");

//      $("#modal_calcular_agua").modal("show");
    
  
// });

