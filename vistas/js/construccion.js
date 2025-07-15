class Construccionclass {
  constructor() {

    this.nombreContruccion = null;
    this.observacion = null;
    this.idPredio =null;
    
  }

}
//=============== REGISTRAR CONSTRUCCION ======================
// Mostrar el modal al hacer clic en el botón
// $(document).on("click", "#agregarConstruccion", function () {
//   console.log("has hecho click aqui--");

//   // Mostrar el modal
//   $("#modal_registrar_construccion").modal("show");
// });



//fIN DE LA CLASE
//============== REGISTRAR PISO ========================
$(document).ready(function () {
  // Tu código aquí se ejecutará cuando el DOM esté completamente cargado.
 
  //REGISTRAR CONSTRUCCION
  $("#modal_registrar_construccion").on("hidden.bs.modal", function (e) {
    $("#formRegistrarCostruccion")[0].reset();
  });

  //salir Registro modal construccion
  $(document).on("click", "#salirRegistroConstruccion", function () {
    $("#modal_registrar_construccion").modal("hide");
  });



 

   $(document).on("click", "#btnRegistrarConst", function () {

    this.nombreContruccion = $("#descripcion").val().trim();
    this.observacion = $("#observacion").val().trim();
    this.idPredio = $("#idPredioCons").val().trim();

   
    let formd = new FormData();

    formd.append("nombreConstruccion", this.nombreContruccion );
    formd.append("observacion", this.observacion );
     formd.append("idPredio", this.idPredio );

    
    
    formd.append("registrarConstruccion", "registrarConstruccion" );
  
    for (const pair of formd.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }


    $.ajax({
      type: "POST",
      url: "ajax/construccion.ajax.php",
      data: formd, // Solo necesitas pasar 'formd' como datos
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {


        //respuesta = JSON.parse(respuesta);
        if (respuesta.tipo === "error") {
          $("#respuestaAjax_srm").show(); // Mostrar el elemento #error antes de establecer el mensaje
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 5000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
        } else {
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          $("#modalAgregarPiso").modal("hide");
          $("#respuestaAjax_srm").show(); // Muestra el mensaje
          // Obtener los parámetros actuales de la URL
          setTimeout(function () {
            $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo,
          }, 5000); // 3 segundos
          nuevoPiso.MostrarPisos(nuevoPiso.idCatasttroC,nuevoPiso.idAnioFiscalC);
          predio.lista_predio(predio.anio_predio);

        }
      },
    });

    
  });
  





});
