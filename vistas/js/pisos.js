class Pisoclass {
  constructor(idCatasttroC, anioFiscalC) {
    this.idCatasttroC = idCatasttroC;
    this.anioFiscalC = anioFiscalC;
    this.idPisoC = null;
    this.idPredioC = null;
    this.fechaConstruccinC = null;
    this.idAnioFiscalC = null;
    this.estadoConservaC = null;
    this.numePisoC = null;
    this.clasifiPisoC = null;
    this.materialPisoC = null;
    this.valorUnitarioC = 0;
    this.tasaDepresciaC = null;
    this.montoDepreciacionC = null; //val calculados no guardado
    this.valorUnitDepreC = null; // val calculado
    this.areaConstruidaC = null;
    this.valorAreaConstruidaC = null; //val calculado
    this.areasComunesC = 0; // val no pasado
    this.valorAreasComunesC = 0; //val no pasados
    this.valorConstruccionC = null; //val calculado;
    this.aniosAntiguedadC = null; //val calculado
    this.idMurosColunsC = null;
    this.idTechosC = null;
    this.idPisosC = null;
    this.idPuertasVentaC = null;
    this.idRevestimientoC = null;
    this.idBañosC = null;
    this.idInstalacionesC = null;
    this.murosColumnasC = 0;
    this.techosC = 0;
    this.pisosC = 0;
    this.puertasVentanasC = 0;
    this.revestimientoC = 0;
    this.baniosC = 0;
    this.instalacionesC = 0;

    //PARA CONSTRUCCION

    this.idCatasttroCC = idCatasttroC;
    this.anioFiscalCC = anioFiscalC;
    this.idPisoCC = null;
    this.idPredioCC = null;
    this.fechaConstruccinCC = null;
    this.idAnioFiscalCC = null;
    this.estadoConservaCC = null;
    this.numePisoCC = null;
    this.clasifiPisoCC = null;
    this.materialPisoCC = null;
    this.valorUnitarioCC = 0;
    this.tasaDepresciaCC = null;
    this.montoDepreciacionCC = null; //val calculados no guardado
    this.valorUnitDepreCC = null; // val calculado
    this.areaConstruidaCC = null;
    this.valorAreaConstruidaCC = null; //val calculado
    this.areasComunesCC = 0; // val no pasado
    this.valorAreasComunesCC = 0; //val no pasados
    this.valorConstruccionCC = null; //val calculado;
    this.aniosAntiguedadCC = null; //val calculado
    this.idMurosColunsCC = null;
    this.idTechosCC = null;
    this.idPisosCC = null;
    this.idPuertasVentaCC = null;
    this.idRevestimientoCC = null;
    this.idBañosCC = null;
    this.idInstalacionesCC = null;
    this.murosColumnasCC = 0;
    this.techosCC = 0;
    this.pisosCC = 0;
    this.puertasVentanasCC = 0;
    this.revestimientoCC = 0;
    this.baniosCC = 0;
    this.instalacionesCC = 0;

    // this.numePiso = null;
  }

  MostrarPisos(codigoCatastro, idAnioFiscal) {

    const cuerpoTabla = document.getElementById("listaPisos");
    const filas = cuerpoTabla.getElementsByTagName("tr");

    while (filas.length > 0) {
      cuerpoTabla.deleteRow(0); // Elimina la primera fila de la tabla
    }
    if (codigoCatastro === "vacio") {
      $("#listaPisos").html("Click Fila");
    } else {
      $("#listaPisos").html("");
      $.ajax({
        type: "POST",
        url: "ajax/pisos.ajax.php",
        data: {
          p1: codigoCatastro,
          p2: idAnioFiscal,
        },
        success: function (respuesta) {

         
          if (respuesta === "pisovacio") {

            let fila = cuerpoTabla.insertRow();
            fila.innerHTML = `<td class="text-center" colspan='10' style='text-align:center;'>No registra Pisos</td>`;
          
          } else {

           
             let numpisos = 0;

             
              let fila2 = document.createElement("div");
              fila2.className = "row";
            //console.log(respuesta);
            respuesta = JSON.parse(respuesta);
            
            respuesta.forEach((value) => {

            
              let fila = cuerpoTabla.insertRow();

            
              fila.innerHTML = `
              <td class="text-center">${value.Catastro_Piso}</td>
              <td class="text-center">${value.Numero_Piso}</td>
              <td class="text-center">${value.Area_Construida}</td>
              <td class="text-center">${value.Valor_Construida}</td>
              <td class="text-center">${value.Categorias_Edificacion}</td>
              <td style="display: none;">${value.Id_Piso}</td>`;
              
               
              numpisos = numpisos + 1;
             

            });

            if (numpisos === 0) {
              this.numePisoC = 1;
            } else {
              this.numePisoC = parseInt(numpisos) + 1;
            }
            $("#numeroPiso").val(this.numePisoC);


            //mostrar construccion
            respuesta.forEach((value) => {

              let formd = new FormData();

            formd.append("idPredio", value.Id_Predio );
            formd.append("mostrar_contruccion", 'mostrar_contruccion' );


              $.ajax({
              type: "POST",
              url: "ajax/pisos.ajax.php",
              data: formd,
               processData: false, // NECESARIO con FormData
              contentType: false, // NECESARIO con FormData

         
              success: function (respuesta) {

                  console.log("Respuesta cruda:", respuesta);

                  // Limpiar el contenedor SIEMPRE
                  const contenedor = document.querySelector(".construccionesid");
                  contenedor.innerHTML = "";

                  // Mostrar mensaje en tabla si es "nulo"
                  if (typeof respuesta === "string" && respuesta.trim() === "nulo") {
                    let fila = cuerpoTabla.insertRow();
                    fila.innerHTML = `<td class="text-center" colspan='10' style='text-align:center;'>No registra Pisos</td>`;
                    return; // Salir
                  }

                  // Parsear si es string JSON
                  if (typeof respuesta === "string") {
                    try {
                      respuesta = JSON.parse(respuesta);
                    } catch (e) {
                      console.error("Error parseando JSON:", respuesta);
                      return;
                    }
                  }

                  // Validar que sea un array
                  if (!Array.isArray(respuesta) || respuesta.length === 0) {
                    let fila = cuerpoTabla.insertRow();
                    fila.innerHTML = `<td class="text-center" colspan='10' style='text-align:center;'>  </td>`;
                    return;
                  }

                  // Agrupar construcciones
                  const construccionesAgrupadas = {};

                 

                  respuesta.forEach(row => {
                    const numConstruccion = row.numero_construccion;

                    if (!construccionesAgrupadas[numConstruccion]) {
                      construccionesAgrupadas[numConstruccion] = {
                        construccion: {
                          Nombre_Construccion: row.Nombre_Construccion,
                          numero_construccion: numConstruccion,
                           Id_Construccion: row.Id_Construccion  || row.Id_Cons // ✅ AÑADIR ESTO
                        },
                        pisos: []
                      };
                    }

                    // Solo si hay datos de piso
                    if (row.Id_Piso !== null && row.Id_Piso !== undefined) {
                      construccionesAgrupadas[numConstruccion].pisos.push(row);
                    }
                  });


                  // let numpisosc = 0;

                  // Renderizar construcciones
                  Object.values(construccionesAgrupadas).forEach(grupo => {

                    const { construccion, pisos } = grupo;

                    const contenedorConstruccion = document.createElement("div");
                    contenedorConstruccion.style.borderBottom = "1px solid #b5b3b3";
                    contenedorConstruccion.className = "col-12 mb-3";

                    let filasHTML = "";

                    if (pisos.length > 0) {
                      filasHTML = pisos.map(p => `
                        <tr>
                          <td class="text-center">${p.Catastro_Piso ?? ''}</td>
                          <td class="text-center">${p.Numero_Piso ?? ''}</td>
                          <td class="text-center">${p.Area_Construida ?? ''}</td>
                          <td class="text-center">${p.Valor_Construida ?? ''}</td>
                          <td class="text-center">${p.Categorias_Edificacion ?? ''}</td>
                        </tr>
                      `).join("");
                    } else {
                      filasHTML = `
                        <tr>
                          <td class="text-center" colspan="5">No hay pisos registrados</td>
                        </tr>
                      `;
                    }


                    let siguienteNumeroPiso;
                    if (pisos.length > 0) {
                      let maxNumeroPiso = Math.max(...pisos.map(p => parseInt(p.Numero_Piso || 0)));
                      siguienteNumeroPiso = maxNumeroPiso + 1;
                    } else {
                      siguienteNumeroPiso = 1;
                    }


                    contenedorConstruccion.innerHTML = `
                      <div class="card" >
                        <div class="card-header">
                         
                            <caption>Construcción ${construccion.numero_construccion +1} - ${construccion.Nombre_Construccion}</caption>
                       
                          </div>
                        <div class="card-body">
                          <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                              <tr>
                                <th class="text-center">Catastro</th>
                                <th class="text-center">N° Piso</th>
                                <th class="text-center">A.Const.</th>
                                <th class="text-center">Val.Const.</th>
                                <th class="text-center">Val.Edifica</th>
                              </tr>
                            </thead>
                            <tbody>
                              ${filasHTML}
                            </tbody>
                          </table>

                          <div class="row mt-2">
                            <div class="col-md-1">
                            
                              <img src="./vistas/img/iconos/nuevo_piso.png" class="t-icon-tbl-imprimir btnAbrirRegistrarPisoC"  data-target="#modalAgregarPisoC" title="Nuevo Piso" data-numero-piso="${siguienteNumeroPiso}" 
              data-id-construccion="${construccion.Id_Construccion}"    data-nombre-construccion="${construccion.Nombre_Construccion}" >

 
                            </div>
                            <div class="col-md-1">
                              <img src="./vistas/img/iconos/editar.png" class="t-icon-tbl-imprimir" id="btnAbrirEditarPiso" data-target="#modalEditarPiso" title="Editar Piso">
                            </div>
                            <div class="col-md-1">
                              <img src="./vistas/img/iconos/delete.png" class="t-icon-tbl-imprimir" id="btnEliminarPiso" title="Eliminar Piso">
                            </div>
                          </div>
                        </div>
                      </div>
                    `;

                    contenedor.appendChild(contenedorConstruccion);

                       
              //numpisosc = numpisosc + 1;
                  });

            // if (numpisos === 0) {
            //   this.numePisoC = 1;
            // } else {
            //   this.numePisoC = parseInt(numpisos) + 1;
            // }
            // $("#numeroPisoC").val(this.numePisoC);


                }





              });

               numpisosC = numpisosC + 1;

            });


             if (numpisosC === 0) {
              this.numePisoC = 1;
            } else {
              this.numePisoC = parseInt(numpisosC) + 1;
            }
            $("#numeroPiso").val(this.numePisoC);




          }

          


        },
      });
    }
  }



  //metodos
  calcularValorUnitario() {
    this.valorUnitarioC =
      this.murosColumnasC +
      this.techosC +
      this.pisosC +
      this.puertasVentanasC +
      this.revestimientoC +
      this.baniosC +
      this.instalacionesC;
    return this.valorUnitarioC;
  }

  //CONSTRUCCION

   calcularValorUnitarioC() {

    this.valorUnitarioCC =
      this.murosColumnasCC +
      this.techosCC +
      this.pisosCC +
      this.puertasVentanasCC +
      this.revestimientoCC +
      this.baniosCC +
      this.instalacionesCC;
    return this.valorUnitarioCC;
  }

  DepreciarPiso() {
    this.montoDepreciacionC = parseFloat(
      (this.tasaDepresciaC * this.valorUnitarioC) / 100
    ).toFixed(2);
    this.valorUnitDepreC = parseFloat(
      this.valorUnitarioC - this.montoDepreciacionC
    ).toFixed(2);
  }

  //CONSTRUCCION
    DepreciarPisoC() {

      console.log("tasa---", this.tasaDepresciaCC);
       console.log("unitario---", this.valorUnitarioCC);

    this.montoDepreciacionCC = parseFloat(
      (this.tasaDepresciaCC * this.valorUnitarioCC) / 100
    ).toFixed(2);
    this.valorUnitDepreCC = parseFloat(
      this.valorUnitarioCC - this.montoDepreciacionCC
    ).toFixed(2);
  }

  calcularValorAreaConstruida() {
    this.valorAreaConstruidaC = parseFloat(
      this.areaConstruidaC * this.valorUnitDepreC
    ).toFixed(2);
  }

  //CONSTRUCCION
   calcularValorAreaConstruidaC() {

    this.valorAreaConstruidaCC = parseFloat(
      this.areaConstruidaCC * this.valorUnitDepreCC
    ).toFixed(2);

  }

  calcularValorConstruccion() {
    this.valorConstruccionC = parseFloat(
      this.valorAreaConstruidaC + this.valorAreasComunesC
    ).toFixed(2);
  }


  //CONSTRUCCION
    calcularValorConstruccionC() {
    this.valorConstruccionCC = parseFloat(
      this.valorAreaConstruidaCC + this.valorAreasComunesCC
    ).toFixed(2);
  }


  calcularRangoDepreciacion() {
    let rango;
    let fechaSeleccionada = new Date(this.fechaConstruccinC);

  
    let fechaActual = new Date();
    let diferenciaEnMilisegundos = fechaActual - fechaSeleccionada;
    this.aniosAntiguedadC = Math.floor(
      diferenciaEnMilisegundos / (1000 * 60 * 60 * 24 * 365.25)
    );
    if (this.aniosAntiguedadC >= 0) {
      if (this.aniosAntiguedadC <= 5) {
        rango = 1;
      }
      if (this.aniosAntiguedadC > 5 && this.aniosAntiguedadC <= 10) {
        rango = 2;
      }
      if (this.aniosAntiguedadC > 10 && this.aniosAntiguedadC <= 15) {
        rango = 3;
      }
      if (this.aniosAntiguedadC > 15 && this.aniosAntiguedadC <= 20) {
        rango = 4;
      }
      if (this.aniosAntiguedadC > 20 && this.aniosAntiguedadC <= 25) {
        rango = 5;
      }
      if (this.aniosAntiguedadC > 25 && this.aniosAntiguedadC <= 30) {
        rango = 6;
      }
      if (this.aniosAntiguedadC > 30 && this.aniosAntiguedadC <= 35) {
        rango = 7;
      }
      if (this.aniosAntiguedadC > 35 && this.aniosAntiguedadC <= 40) {
        rango = 8;
      }
      if (this.aniosAntiguedadC > 40 && this.aniosAntiguedadC <= 45) {
        rango = 9;
      }
      if (this.aniosAntiguedadC > 45 && this.aniosAntiguedadC <= 50) {
        rango = 10;
      }
      if (this.aniosAntiguedadC > 50 && this.aniosAntiguedadC <= 150) {
        rango = 11;
      }
      return rango;
    } else {
      rango = -100;
      return rango;
    }
    //console.log(rango, materialContruc, tipoEdificaion, estadoConserva);
  }


  //COSNTRUCCION
  calcularRangoDepreciacionC() {
    let rango;
    let fechaSeleccionadaC = new Date(this.fechaConstruccinCC);

    console.log("en otro funcion", fechaSeleccionadaC);
     
    let fechaActual = new Date();
    let diferenciaEnMilisegundos = fechaActual - fechaSeleccionadaC;
    this.aniosAntiguedadCC = Math.floor(
      diferenciaEnMilisegundos / (1000 * 60 * 60 * 24 * 365.25)
    );
    if (this.aniosAntiguedadCC >= 0) {
      if (this.aniosAntiguedadCC <= 5) {
        rango = 1;
      }
      if (this.aniosAntiguedadCC > 5 && this.aniosAntiguedadCC <= 10) {
        rango = 2;
      }
      if (this.aniosAntiguedadCC > 10 && this.aniosAntiguedadCC <= 15) {
        rango = 3;
      }
      if (this.aniosAntiguedadCC > 15 && this.aniosAntiguedadCC <= 20) {
        rango = 4;
      }
      if (this.aniosAntiguedadCC > 20 && this.aniosAntiguedadCC <= 25) {
        rango = 5;
      }
      if (this.aniosAntiguedadCC > 25 && this.aniosAntiguedadCC <= 30) {
        rango = 6;
      }
      if (this.aniosAntiguedadCC > 30 && this.aniosAntiguedadCC <= 35) {
        rango = 7;
      }
      if (this.aniosAntiguedadCC > 35 && this.aniosAntiguedadCC <= 40) {
        rango = 8;
      }
      if (this.aniosAntiguedadCC > 40 && this.aniosAntiguedadCC <= 45) {
        rango = 9;
      }
      if (this.aniosAntiguedadCC > 45 && this.aniosAntiguedadCC <= 50) {
        rango = 10;
      }
      if (this.aniosAntiguedadCC > 50 && this.aniosAntiguedadCC <= 150) {
        rango = 11;
      }
      return rango;
    } else {
      rango = -100;
      return rango;
    }
    //console.log(rango, materialContruc, tipoEdificaion, estadoConserva);
  }






}
//fIN DE LA CLASE
//============== REGISTRAR PISO ========================
$(document).ready(function () {
  // Tu código aquí se ejecutará cuando el DOM esté completamente cargado.
  let nuevoPiso;
  let pisoEdit;
  let modificaciones = false; 
  let filaPredio = false;
  let filaPiso = false; 
  let anioFiscalS = $("#selectnum").find("option:selected").text();
  let idAnioFiscalS = $("#selectnum option:selected").val();


  $(document).on("click", "#tablalistapredios tbody tr", function () {
    nuevoPiso = new Pisoclass();
    pisoEdit = new Pisoclass();
    nuevoPiso.idCatasttroC = $(this).find("td:nth-child(5)").text();
    nuevoPiso.anioFiscalC = anioFiscalS;
    nuevoPiso.idAnioFiscalC = idAnioFiscalS;
    filaPredio = true;
    $("#idCatastroRow").val(nuevoPiso.idCatasttroC);
    $("#anioFiscal").val(nuevoPiso.anioFiscalC);
    nuevoPiso.MostrarPisos(nuevoPiso.idCatasttroC, nuevoPiso.idAnioFiscalC);
    filaPiso = false;
  });


  //CONSTRUCCION
   $(document).on("click", "#tablalistapredios tbody tr", function () {
    nuevoPisoC = new Pisoclass();
    pisoEditC = new Pisoclass();
    nuevoPisoC.idCatasttroCC = $(this).find("td:nth-child(5)").text();
    nuevoPisoC.anioFiscalCC = anioFiscalS;
    nuevoPisoC.idAnioFiscalCC = idAnioFiscalS;
    filaPredio = true;
    $("#idCatastroRowC").val(nuevoPisoC.idCatasttroCC);
    $("#anioFiscalC").val(nuevoPisoC.anioFiscalCC);
    nuevoPisoC.MostrarPisos(nuevoPisoC.idCatasttroCC, nuevoPisoC.idAnioFiscalC);
    filaPiso = false;
  });


  $(document).on("click", "#btnAbrirRegistrarPiso", function () {

    if (filaPredio) {
      if (nuevoPiso.anioFiscalC >= 2023) {
        BloquerCamposRegistro();
        $("#modalAgregarPiso").modal("show");
      } else {
        DesbloqueoCamposRegistro();
        $("#modalAgregarPiso").modal("show");
      }
    } else {
      $("#respuestaAjax_correcto").html(
        '<div class="alert alert-warning" role="alert">DEBE SELECCIONAR UN PREDIO</div>'
      );
      $("#respuestaAjax_correcto").show();
      setTimeout(function () {
        $("#respuestaAjax_correcto").hide(); //(p, 3 segundos)
      }, 3000);
    }
  });




  //EN CONSTRUCCIONES
  $(document).on("click", ".btnAbrirRegistrarPisoC", function () {
    if (filaPredio) {

    const numeroPiso = $(this).data("numero-piso");
    const idConstruccion = $(this).data("id-construccion");
    const nombreConstruccion = $(this).data("nombre-construccion");
    

    // Guardamos los datos en el modal como data temporal
    $("#modalAgregarPisoC").data("numeroPiso", numeroPiso);
    $("#modalAgregarPisoC").data("idConstruccion", idConstruccion);

    $("#modalAgregarPisoC").data("nombreConstruccion", nombreConstruccion);



      if (nuevoPisoC.anioFiscalCC >= 2023) {
        BloquerCamposRegistro();
        $("#modalAgregarPisoC").modal("show");
      } else {
        DesbloqueoCamposRegistro();
        $("#modalAgregarPisoC").modal("show");
      }
    } else {
      $("#respuestaAjax_correcto").html(
        '<div class="alert alert-warning" role="alert">DEBE SELECCIONAR UN PREDIO</div>'
      );
      $("#respuestaAjax_correcto").show();
      setTimeout(function () {
        $("#respuestaAjax_correcto").hide(); //(p, 3 segundos)
      }, 3000);
    }
  });


  $("#murosColumnas").on("change", function () {
    nuevoPiso.idMurosColunsC = $("#murosColumnas").val();
    let parametro = 1; //muros y columnas
    let valorMuros = "#valorMuros";
    "la funcion" +
      TraerValorxCategoria(
        nuevoPiso.idMurosColunsC,
        nuevoPiso.anioFiscalC,
        parametro,
        valorMuros,
        "murosColumnasC"
      );
  });

  //CONSTRUCCION
    $("#murosColumnasC").on("change", function () {
    nuevoPisoC.idMurosColunsCC = $("#murosColumnasC").val();
    let parametro = 1; //muros y columnas
    let valorMuros = "#valorMurosC";
    "la funcion" +
      TraerValorxCategoriaC(
        nuevoPisoC.idMurosColunsCC,
        nuevoPisoC.anioFiscalCC,
        parametro,
        valorMuros,
        "murosColumnasCC"
      );
  });



  $("#techos").on("change", function () {
    nuevoPiso.idTechosC = $("#techos").val();
    let parametro = 2; //Techos
    let valorTechos = "#valorTechos";
    TraerValorxCategoria(
      nuevoPiso.idTechosC,
      nuevoPiso.anioFiscalC,
      parametro,
      valorTechos,
      "techosC"
    );
  });

  //CONSTRUCCION
   $("#techosC").on("change", function () {
    nuevoPisoC.idTechosCC = $("#techosC").val();
    let parametro = 2; //Techos
    let valorTechos = "#valorTechosC";
    TraerValorxCategoriaC(
      nuevoPisoC.idTechosCC,
      nuevoPisoC.anioFiscalCC,
      parametro,
      valorTechos,
      "techosCC"
    );
  });




  $("#pisos").on("change", function () {
    nuevoPiso.idPisoC = $("#pisosC").val();
    let parametro = 3; //puertas Ventanas
    let valorCampo = "#valorPisos";
    TraerValorxCategoria(
      nuevoPiso.idPisoC,
      nuevoPiso.anioFiscalC,
      parametro,
      valorCampo,
      "pisosC"
    );
  });

  //CONSTRUCCION

   $("#pisosC").on("change", function () {
    nuevoPisoC.idPisoCC = $("#pisosC").val();
    let parametro = 3; //puertas Ventanas
    let valorCampo = "#valorPisosC";
    TraerValorxCategoriaC(
      nuevoPisoC.idPisoCC,
      nuevoPisoC.anioFiscalCC,
      parametro,
      valorCampo,
      "pisosCC"
    );
  });


  $("#puertasVentanas").on("change", function () {
    nuevoPiso.idPuertasVentaC = $("#puertasVentanas").val();
    let parametro = 4; //puertas Ventanas
    let valorpuertas = "#valorPuertasyVentanas";
    TraerValorxCategoria(
      nuevoPiso.idPuertasVentaC,
      nuevoPiso.anioFiscalC,
      parametro,
      valorpuertas,
      "puertasVentanasC"
    );
  });

  //CONSTRUCCION
   $("#puertasVentanasC").on("change", function () {
    nuevoPisoC.idPuertasVentaCC = $("#puertasVentanasC").val();
    let parametro = 4; //puertas Ventanas
    let valorpuertas = "#valorPuertasyVentanasC";
    TraerValorxCategoriaC(
      nuevoPisoC.idPuertasVentaCC,
      nuevoPisoC.anioFiscalCC,
      parametro,
      valorpuertas,
      "puertasVentanasCC"
    );
  });



  $("#revestimiento").on("change", function () {
    nuevoPiso.idRevestimientoC = $("#revestimiento").val();
    let parametro = 5; //puertas Ventanas
    let valoCampo = "#valorRevestimientos";
    TraerValorxCategoria(
      nuevoPiso.idRevestimientoC,
      nuevoPiso.anioFiscalC,
      parametro,
      valoCampo,
      "revestimientoC"
    );
  });

  //CONSTRUCCION
  $("#revestimientoC").on("change", function () {
    nuevoPisoC.idRevestimientoCC = $("#revestimientoC").val();
    let parametro = 5; //puertas Ventanas
    let valoCampo = "#valorRevestimientosC";
    TraerValorxCategoriaC(
      nuevoPisoC.idRevestimientoCC,
      nuevoPisoC.anioFiscalCC,
      parametro,
      valoCampo,
      "revestimientoCC"
    );
  });




  $("#banios").on("change", function () {
    nuevoPiso.idBañosC = $("#banios").val();
    let parametro = 6; //puertas Ventanas
    let valorbanio = "#valorBaños";
    TraerValorxCategoria(
      nuevoPiso.idBañosC,
      nuevoPiso.anioFiscalC,
      parametro,
      valorbanio,
      "baniosC"
    );
  });


  //CONSTRUCCION
   $("#baniosC").on("change", function () {
    nuevoPisoC.idBañosCC = $("#baniosC").val();
    let parametro = 6; //puertas Ventanas
    let valorbanio = "#valorBañosC";
    TraerValorxCategoriaC(
      nuevoPisoC.idBañosCC,
      nuevoPisoC.anioFiscalCC,
      parametro,
      valorbanio,
      "baniosCC"
    );
  });



  $("#OtrasInsta").on("change", function () {
    nuevoPiso.idInstalacionesC = $("#OtrasInsta").val();
    let parametro = 7; //puertas Ventanas
    let valorotras = "#valorOtrasInsta";
    TraerValorxCategoria(
      nuevoPiso.idInstalacionesC,
      nuevoPiso.anioFiscalC,
      parametro,
      valorotras,
      "instalacionesC"
    );
  });

  //CONSTRUCION
   $("#OtrasInstaC").on("change", function () {
    nuevoPisoC.idInstalacionesCC = $("#OtrasInstaC").val();
    let parametro = 7; //puertas Ventanas
    let valorotras = "#valorOtrasInstaC";
    TraerValorxCategoriaC(
      nuevoPisoC.idInstalacionesCC,
      nuevoPisoC.anioFiscalCC,
      parametro,
      valorotras,
      "instalacionesCC"
    );
  });




  $(document).on("change", "#estadoConservaImp", function () {
    nuevoPiso.estadoConservaC = $("#estadoConservaImp").val();
    console.log(" hola esta aqui", nuevoPiso.estadoConservaC );
  });

  //CONSTRUCCION
   $(document).on("change", "#estadoConservaImpC", function () {
    nuevoPisoC.estadoConservaCC = $("#estadoConservaImpC").val();
    console.log(" hola esta aqui", nuevoPiso.estadoConservaCC );
  });

  
  $(document).on("change", "#materialConsImp", function () {
    nuevoPiso.materialPisoC = $("#materialConsImp").val();
  });

  //CONSTRUCCION
   $(document).on("change", "#materialConsImpC", function () {
    nuevoPisoC.materialPisoCC = $("#materialConsImpC").val();
  });

  $(document).on("change", "#clasificaPisoImp", function () {
    nuevoPiso.clasifiPisoC = $("#clasificaPisoImp").val();
  });

  //CONSTRUCCION
   $(document).on("change", "#clasificaPisoImpC", function () {
    nuevoPisoC.clasifiPisoCC = $("#clasificaPisoImpC").val();
  });

  // Reinicio de Eleccion de Años
  $(document).on("change", "#selectnum", function () {
    filaPredio = false;
    filaPiso = false;
    codigoCatastro1 = "vacio";
    anioFiscalS = $("#selectnum").find("option:selected").text();
    idAnioFiscalS = $("#selectnum option:selected").val();
    //nuevoPiso.MostrarPisos(codigoCatastro1, nuevoPiso.idAnioFiscalC);
    //    console.log("codCatas:" + codigoCatastro1, "Id Año:" + idAnioFiscal);
  });


  // Depreciar piso, antes de Registrar
  $(document).on("click", "#btnDepreciar", function () {
    nuevoPiso.fechaConstruccinC = $("#fechaAntiguedad").val();

    console.log("llegaste aqui-------");
    if (
      nuevoPiso.calcularRangoDepreciacion() >= 0 &&
      nuevoPiso.estadoConservaC !== null &&
      nuevoPiso.clasifiPisoC !== null &&
      nuevoPiso.materialPisoC !== null
    ) {
      $.ajax({
        type: "POST",
        url: "ajax/pisos.ajax.php",
        data: {
          f1: nuevoPiso.calcularRangoDepreciacion(), //devuelve el rango
          f2: nuevoPiso.materialPisoC, //
          f3: nuevoPiso.clasifiPisoC,
          f4: nuevoPiso.estadoConservaC,
        },
        success: function (respuesta) {
          nuevoPiso.tasaDepresciaC = respuesta;
          $("#tasaDepreCal").val(respuesta + " %");
          nuevoPiso.DepreciarPiso();
          $("#depresiacionInp").val(nuevoPiso.montoDepreciacionC);
          $("#valUniDepreciadoImp").val(nuevoPiso.valorUnitDepreC);
          $("#aniosAntiguedadImp").val(nuevoPiso.aniosAntiguedadC);
        },
        error: function () {
          console.error("Error en la solicitud AJAX");
        },
      });
    } else if (nuevoPiso.estadoConservaC === null) {
      $("#respuestaAjax_srm").html(
       '<div class="alert warning">' +
          '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
          '<span aria-hidden="true" class="letra">×</span>' +
          '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Debe elegir ESTADO DE CONSERVACION</span></p></div>'
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    } else if (nuevoPiso.clasifiPisoC === null) {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
          '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
          '<span aria-hidden="true" class="letra">×</span>' +
          '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Debe elegir CLASIFICACION</span></p></div>'
     
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    } else if (nuevoPiso.materialPisoC === null) {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
        '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
        '<span aria-hidden="true" class="letra">×</span>' +
        '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Debe elegir MATERIAL DE CONSTRUCCION</span></p></div>'
   
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    } else if (
      nuevoPiso.fechaConstruccinC === "" ||
      nuevoPiso.calcularRangoDepreciacion() < 0
    ) {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
          '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
          '<span aria-hidden="true" class="letra">×</span>' +
          '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">FECHA DE CONSTRUCCION no valida</span></p></div>'
     
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    }
  });


  //CONSTRUCCION

  
  // Depreciar piso, antes de Registrar
  $(document).on("click", "#btnDepreciarC", function () {
    nuevoPisoC.fechaConstruccinCC = $("#fechaAntiguedadC").val();

    console.log("fecha constrccion--", nuevoPisoC.fechaConstruccinCC );
    if (
      nuevoPisoC.calcularRangoDepreciacionC() >= 0 &&
      nuevoPisoC.estadoConservaCC !== null &&
      nuevoPisoC.clasifiPisoCC !== null &&
      nuevoPisoC.materialPisoCC !== null
    ) {

      console.log("Datos a enviar:");
      console.log("Rango de depreciación:", nuevoPisoC.calcularRangoDepreciacionC());
      console.log("Material de piso:", nuevoPisoC.materialPisoCC);
      console.log("Clasificación de piso:", nuevoPisoC.clasifiPisoCC);
      console.log("Estado de conservación:", nuevoPisoC.estadoConservaCC);


      $.ajax({
        type: "POST",
        url: "ajax/pisos.ajax.php",
        data: {
          f5: nuevoPisoC.calcularRangoDepreciacionC(), //devuelve el rango
          f6: nuevoPisoC.materialPisoCC, //
          f7: nuevoPisoC.clasifiPisoCC,
          f8: nuevoPisoC.estadoConservaCC,
        },
        success: function (respuesta) {
          nuevoPisoC.tasaDepresciaCC = respuesta;

          console.log("esta es lo que devuelve de depresiacion--",respuesta );
          $("#tasaDepreCalC").val(respuesta + " %");
          
          nuevoPisoC.DepreciarPisoC();
          $("#depresiacionInpC").val(nuevoPisoC.montoDepreciacionCC);
          $("#valUniDepreciadoImpC").val(nuevoPisoC.valorUnitDepreCC);
          $("#aniosAntiguedadImpC").val(nuevoPisoC.aniosAntiguedadCC);
        },
        error: function () {
          console.error("Error en la solicitud AJAX");
        },
      });
    } else if (nuevoPisoC.estadoConservaCC === null) {
      $("#respuestaAjax_srm").html(
       '<div class="alert warning">' +
          '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
          '<span aria-hidden="true" class="letra">×</span>' +
          '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Debe elegir ESTADO DE CONSERVACION</span></p></div>'
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    } else if (nuevoPisoC.clasifiPisoCC === null) {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
          '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
          '<span aria-hidden="true" class="letra">×</span>' +
          '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Debe elegir CLASIFICACION</span></p></div>'
     
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    } else if (nuevoPisoC.materialPisoCC === null) {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
        '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
        '<span aria-hidden="true" class="letra">×</span>' +
        '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Debe elegir MATERIAL DE CONSTRUCCION</span></p></div>'
   
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    } else if (
      nuevoPisoC.fechaConstruccinCC === "" ||
      nuevoPisoC.calcularRangoDepreciacionC() < 0
    ) {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
          '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
          '<span aria-hidden="true" class="letra">×</span>' +
          '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">FECHA DE CONSTRUCCION no valida</span></p></div>'
     
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    }
  });



  // digitar el Area del Piso
  $(document).on("change", "#areaConstruidaImp", function () {
    nuevoPiso.areaConstruidaC = parseFloat($("#areaConstruidaImp").val());
    nuevoPiso.calcularValorAreaConstruida();
    nuevoPiso.calcularValorConstruccion();
    $("#valorAreaConstruImp").val(
      parseFloat(nuevoPiso.valorAreaConstruidaC).toFixed(2)
    );
    $("#valorConstrucionCal").val(
      parseFloat(nuevoPiso.valorConstruccionC).toFixed(2)
    );
  });

  //CONSTRUCIDA
   // digitar el Area del Piso
  $(document).on("change", "#areaConstruidaImpC", function () {
    nuevoPisoC.areaConstruidaCC = parseFloat($("#areaConstruidaImpC").val());

   
    nuevoPisoC.calcularValorAreaConstruidaC();
    nuevoPisoC.calcularValorConstruccionC();

     console.log("ver valor de construccion---", nuevoPisoC.valorConstruccionCC );


    $("#valorAreaConstruImpC").val(
      parseFloat(nuevoPisoC.valorAreaConstruidaCC).toFixed(2)
    );
    $("#valorConstrucionCalC").val(
      parseFloat(nuevoPisoC.valorConstruccionCC).toFixed(2)
    );
  });



  // Registrar Nuevo Piso la mascara negra esta es la mascara de la nefr
  $(document).on("click", "#btnRegistrarPiso", function () {
    let letrasValorEdica;
    if (nuevoPiso.anioFiscalC >= 2023) {
      letrasValorEdica =
        $("#murosColumnasC").find("option:selected").text() +
        $("#techosC").find("option:selected").text() +
        $("#puertasVentanasC").find("option:selected").text();
    } else {
      letrasValorEdica =
        $("#murosColumnasC").find("option:selected").text() +
        $("#techosC").find("option:selected").text() +
        $("#pisosC").find("option:selected").text() +
        $("#puertasVentanasC").find("option:selected").text() +
        $("#revestimientoC").find("option:selected").text() +
        $("#baniosC").find("option:selected").text() +
        $("#OtrasInstaC").find("option:selected").text();
    }
    let formd = new FormData();
    formd.append("idCatastroRow", nuevoPiso.idCatasttroC);
    formd.append("numeroPiso", nuevoPiso.numePisoC);
    formd.append("fechaAntiguedad", nuevoPiso.fechaConstruccinC);
    formd.append("cantidadAños", nuevoPiso.aniosAntiguedadC);
    formd.append("valUnitariosCal", nuevoPiso.valorUnitarioC);
    formd.append("tasaDepreCal", nuevoPiso.tasaDepresciaC);
    formd.append("depresiacionInp", nuevoPiso.montoDepreciacionC);
    formd.append("valUniDepreciadoImp", nuevoPiso.valorUnitDepreC);
    formd.append("areaConstruidaImp", nuevoPiso.areaConstruidaC);
    formd.append("valorAreaConstruImp", nuevoPiso.valorAreaConstruidaC);
    formd.append("areaComunesImp", nuevoPiso.areasComunesC);
    formd.append("valorAreComunImp", nuevoPiso.valorAreasComunesC);
    formd.append("valorConstrucionCal", nuevoPiso.valorConstruccionC);
    formd.append("estadoConservaImp", nuevoPiso.estadoConservaC);
    formd.append("clasificaPisoImp", nuevoPiso.clasifiPisoC);
    formd.append("materialConsImp", nuevoPiso.materialPisoC);
    formd.append("idAnioFiscal", nuevoPiso.idAnioFiscalC);
    formd.append("murosColumnas", nuevoPiso.idMurosColunsC);
    formd.append("techos", nuevoPiso.idTechosC);
    formd.append("puertasVentanas", nuevoPiso.idPuertasVentaC);
    formd.append("letrasValorEdica", letrasValorEdica);
    formd.append("registrar_piso", "registrar_piso");
    for (const pair of formd.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }
    $.ajax({
      type: "POST",
      url: "ajax/pisos.ajax.php",
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


  //COSTRUCCION
  // Registrar Nuevo Piso
  $(document).on("click", "#btnRegistrarPisoC", function () {

    let idCons = $('#idConstruccionC').val();
    let nunPiso = $('#numeroPisoC').val();


    let letrasValorEdica;
    if (nuevoPisoC.anioFiscalC >= 2023) {
      letrasValorEdica =
        $("#murosColumnasC").find("option:selected").text() +
        $("#techosC").find("option:selected").text() +
        $("#puertasVentanasC").find("option:selected").text();
    } else {
      letrasValorEdica =
        $("#murosColumnasC").find("option:selected").text() +
        $("#techosC").find("option:selected").text() +
        $("#pisosC").find("option:selected").text() +
        $("#puertasVentanasC").find("option:selected").text() +
        $("#revestimientoC").find("option:selected").text() +
        $("#baniosC").find("option:selected").text() +
        $("#OtrasInstaC").find("option:selected").text();
    }

    let formd = new FormData();
    formd.append("idCatastroRow", nuevoPisoC.idCatasttroCC);
    formd.append("numeroPiso", nuevoPisoC.numePisoCC);
    formd.append("fechaAntiguedad", nuevoPisoC.fechaConstruccinCC);
    formd.append("cantidadAños", nuevoPisoC.aniosAntiguedadCC);
    formd.append("valUnitariosCal", nuevoPisoC.valorUnitarioCC);
    formd.append("tasaDepreCal", nuevoPisoC.tasaDepresciaCC);
    formd.append("depresiacionInp", nuevoPisoC.montoDepreciacionCC);
    formd.append("valUniDepreciadoImp", nuevoPisoC.valorUnitDepreCC);
    formd.append("areaConstruidaImp", nuevoPisoC.areaConstruidaCC);
    formd.append("valorAreaConstruImp", nuevoPisoC.valorAreaConstruidaCC);
    formd.append("areaComunesImp", nuevoPisoC.areasComunesCC);
    formd.append("valorAreComunImp", nuevoPisoC.valorAreasComunesCC);
    formd.append("valorConstrucionCal", nuevoPisoC.valorConstruccionCC);
    formd.append("estadoConservaImp", nuevoPisoC.estadoConservaCC);
    formd.append("clasificaPisoImp", nuevoPisoC.clasifiPisoCC);
    formd.append("materialConsImp", nuevoPisoC.materialPisoCC);
    formd.append("idAnioFiscal", nuevoPisoC.idAnioFiscalCC);
    formd.append("murosColumnas", nuevoPisoC.idMurosColunsCC);
    formd.append("techos", nuevoPisoC.idTechosCC);
    formd.append("puertasVentanas", nuevoPisoC.idPuertasVentaCC);
    formd.append("idConstruccion", idCons);// AUUI ME QUEDADO
    formd.append("numPiso", nunPiso);// AUUI ME QUEDADO
    formd.append("letrasValorEdica", letrasValorEdica);
    formd.append("registrar_piso_cons", "registrar_piso_cons");
    
    for (const pair of formd.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }
    $.ajax({
      type: "POST",
      url: "ajax/pisos.ajax.php",
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

  
  //Bloquear Campos y Blanqueo de Campos
  $("#modalAgregarPiso").on("show.bs.modal", function () {
     

    $("#idCatastroRow").val(nuevoPiso.idCatasttroC);
    $("#anioFiscal").val(nuevoPiso.anioFiscalC);
 
    $("#valUnitariosCal").prop("disabled", true);
    $("#depresiacionInp").prop("disabled", true);
    $("#valUniDepreciadoImp").prop("disabled", true);
    $("#valorAreaConstruImp").prop("disabled", true);
    $("#areaComunesImp").prop("disabled", true);
    $("#valorAreComunImp").prop("disabled", true);
    $("#valorConstrucionCal").prop("disabled", true);
  });



  //Bloquear Campos y Blanqueo de Campos con construccion
   $("#modalAgregarPisoC").on("show.bs.modal", function () {
     const numeroPiso = $(this).data("numeroPiso") || 1;
  const idConstruccion = $(this).data("idConstruccion") || '';

  console.log("aqui el id de construccion", idConstruccion);
  const nombreConstruccion = $(this).data("nombreConstruccion") || '';

    $("#idCatastroRowC").val(nuevoPiso.idCatasttroC);
    $("#anioFiscalC").val(nuevoPiso.anioFiscalC);
    $("#numeroPisoC").val(numeroPiso); // <- Aquí llenamos el número del piso
    $("#idConstruccionC").val(idConstruccion); // <- Asegúrate de tener este input en el modal
   $("#nombreConstruccionC").text(nombreConstruccion); // <- Asegúrate de tener este input en el modal

    $("#valUnitariosCal").prop("disabled", true);
    $("#depresiacionInp").prop("disabled", true);
    $("#valUniDepreciadoImp").prop("disabled", true);
    $("#valorAreaConstruImp").prop("disabled", true);
    $("#areaComunesImp").prop("disabled", true);
    $("#valorAreComunImp").prop("disabled", true);
    $("#valorConstrucionCal").prop("disabled", true);
  });



  // Reseteo del Formaulario Nuevo Piso
  $("#modalAgregarPiso").on("hidden.bs.modal", function (e) {
    $("#formRegistrarPiso")[0].reset();
  });






  //salir Registro Modal salirRegistroModal
  $(document).on("click", "#salirRegistroModal", function () {
    $("#modalAgregarPiso").modal("hide");
  });


   //salir Registro Modal salirRegistroModal
  $(document).on("click", "#salirRegistroModalC", function () {
    $("#modalAgregarPisoC").modal("hide");
  });


  //============== EDITAR PISO ======================
  let cadenaValoreEdit;
  //---- Click en la Fila Pisos -----
  $(document).on("click", "#listaPisos tr", function () {
    filaPiso = true;
    pisoEdit = new Pisoclass();
    pisoEdit.idPisoC = $(this).find("td:nth-child(6)").text();
    pisoEdit.anioFiscalC = $("#selectnum").find("option:selected").text();
    pisoEdit.idAnioFiscalC = $("#selectnum option:selected").val();
    // despintar y pintar fila seleccionada
    $("#listaPisos tr").removeClass("filaSeleccionada");
    $(this).addClass("filaSeleccionada");
    $.ajax({
      type: "POST",
      url: "ajax/pisos.ajax.php",
      data: {
        idPiso: pisoEdit.idPisoC,
      },
      success: function (respuesta) {
        respuesta = JSON.parse(respuesta);
        for (let i = 0; i < respuesta.length; i++) {
          const piso = respuesta[i];
          pisoEdit.idCatasttroC = piso.Catastro_Piso;
          pisoEdit.numePisoC = piso.Numero_Piso;
          pisoEdit.tasaDepresciaC = piso.Porcentaje_Depreciacion;
          pisoEdit.estadoConservaC = piso.Id_Estado_Conservacion;
          pisoEdit.materialPisoC = piso.Id_Material_Piso;
          pisoEdit.aniosAntiguedadC = piso.Cantidad_Anios;
          pisoEdit.clasifiPisoC = piso.Id_Clasificacion_Piso;
          pisoEdit.fechaConstruccinC = piso.Fecha_Construccion;
          pisoEdit.valorUnitDepreC = piso.Valor_Unitario_Depreciado;
          pisoEdit.valorUnitarioC = piso.Valores_Unitarios;
          pisoEdit.areaConstruidaC = piso.Area_Construida;
          pisoEdit.valorAreaConstruidaC = piso.Valor_Area_Construida;
          pisoEdit.valorConstruccionC = piso.Valor_Construida;
          pisoEdit.idPredioC = piso.Id_Predio;
          cadenaValoreEdit = piso.Categorias_Edificacion;
        }
      },
    });
  });
  //---- Abrir Modal Editar -----
  $(document).on("click", "#btnAbrirEditarPiso", function () {
    if (filaPiso) {
      $("#anioFiscalEdit").val(pisoEdit.anioFiscalC);
      $("#idCatastroEdit").val(pisoEdit.idCatasttroC);
      $("#numeroPisoEdit").val(pisoEdit.numePisoC);
      $("#estadoConservaEdit").val(pisoEdit.estadoConservaC);
      $("#aniosAntiguedadEdit").val(pisoEdit.aniosAntiguedadC);
      $("#materialConsEdit").val(pisoEdit.materialPisoC);
      $("#clasificaPisoEdit").val(pisoEdit.clasifiPisoC);
      $("#fechaAntiguedadEdit").val(pisoEdit.fechaConstruccinC);
      $("#tasaDepreEdit").val(pisoEdit.tasaDepresciaC + " %");
      pisoEdit.DepreciarPiso();
      $("#depresiacionEdit").val(pisoEdit.montoDepreciacionC);
      $("#valUnitariosEdit").val(pisoEdit.valorUnitarioC);
      $("#valUniDepreciadoEdit").val(pisoEdit.valorUnitDepreC);
      $("#areaConstruidaEdit").val(pisoEdit.areaConstruidaC);
      $("#valorAreaConstruEdit").val(pisoEdit.valorAreaConstruidaC);
      $("#valorConstrucionEdit").val(pisoEdit.valorConstruccionC);
      let letra4;
      let letra1 = cadenaValoreEdit.charAt(0); // Asigna letra1
      let letra2 = cadenaValoreEdit.charAt(1); // Asigna letra2
      let letra3 = cadenaValoreEdit.charAt(2); // Asigna letra3
      let letra5 = cadenaValoreEdit.charAt(4); // Asigna letra3
      let letra6 = cadenaValoreEdit.charAt(5); // Asigna letra3
      let letra7 = cadenaValoreEdit.charAt(6); // Asigna letra3
      if (pisoEdit.anioFiscalC >= 2023) {
        letra4 = cadenaValoreEdit.charAt(2);
        $("#murosColumnasEdit option:contains(" + letra1 + ")").prop(
          "selected",
          true
        );
        $("#techosEdit option:contains(" + letra2 + ")").prop("selected", true);
        $("#puertasVentanasEdit option:contains(" + letra4 + ")").prop(
          "selected",
          true
        );
      } else {
        letra4 = cadenaValoreEdit.charAt(3);
        $("#murosColumnasEdit option:contains(" + letra1 + ")").prop(
          "selected",
          true
        );
        $("#techosEdit option:contains(" + letra2 + ")").prop("selected", true);
        $("#pisosEdit option:contains(" + letra3 + ")").prop("selected", true);
        $("#puertasVentanasEdit option:contains(" + letra4 + ")").prop(
          "selected",
          true
        );
        $("#revestimientoEdit option:contains(" + letra5 + ")").prop(
          "selected",
          true
        );
        $("#baniosEdit option:contains(" + letra6 + ")").prop("selected", true);
        $("#OtrasInstaEdit option:contains(" + letra7 + ")").prop(
          "selected",
          true
        );
      }
      $("#modalEditarPiso").modal("show");
      EncontrarMontoParaLetraSinAccion();
      if (pisoEdit.anioFiscalC >= 2023) {
        BloquearCamposEdicion();
      } else {
        DesbloquearCamposEdicion();
      }
    } else {
      $("#respuestaAjax_correcto").html(
        '<div class="alert alert-warning" role="alert">DEBE SELECCIONAR UN PISO</div>'
      );
      $("#respuestaAjax_correcto").show();
      setTimeout(function () {
        $("#respuestaAjax_correcto").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 3000);
    }
  });
  $("#murosColumnasEdit").on("change", function () {
    modificaciones = false;
    pisoEdit.idMurosColunsC = $("#murosColumnasEdit").val();
    TraerValorxCategoriaEdit(
      pisoEdit.idMurosColunsC,
      pisoEdit.anioFiscalC,
      1,
      "#valorMurosEdit",
      "murosColumnasC"
    );
  });
  $("#techosEdit").on("change", function () {
    modificaciones = false;
    pisoEdit.idTechosC = $("#techosEdit").val();
    TraerValorxCategoriaEdit(
      pisoEdit.idTechosC,
      pisoEdit.anioFiscalC,
      2,
      "#valorTechosEdit",
      "techosC"
    );
  });
  $("#pisosEdit").on("change", function () {
    modificaciones = false;
    pisoEdit.idPisosC = $("#pisosEdit").val();
    TraerValorxCategoriaEdit(
      pisoEdit.idPisosC,
      pisoEdit.anioFiscalC,
      3,
      "#valorPisosEdit",
      "pisosC"
    );
  });
  $("#puertasVentanasEdit").on("change", function () {
    modificaciones = false;
    pisoEdit.idPuertasVentaC = $("#puertasVentanasEdit").val();
    TraerValorxCategoriaEdit(
      pisoEdit.idPuertasVentaC,
      pisoEdit.anioFiscalC,
      4,
      "#valorPuertasyVentanasEdit",
      "puertasVentanasC"
    );
  });
  $("#revestimientoEdit").on("change", function () {
    modificaciones = false;
    pisoEdit.idRevestimientoC = $("#revestimientoEdit").val();
    TraerValorxCategoriaEdit(
      pisoEdit.idRevestimientoC,
      pisoEdit.anioFiscalC,
      5,
      "#valorRevestimientosEdit",
      "revestimientoC"
    );
  });
  $("#baniosEdit").on("change", function () {
    modificaciones = false;
    pisoEdit.idBañosC = $("#baniosEdit").val();
    TraerValorxCategoriaEdit(
      pisoEdit.idBañosC,
      pisoEdit.anioFiscalC,
      6,
      "#valorBaniosEdit",
      "baniosC"
    );
  });
  $("#OtrasInstaEdit").on("change", function () {
    modificaciones = false;
    pisoEdit.idInstalacionesC = $("#OtrasInstaEdit").val();
    TraerValorxCategoriaEdit(
      pisoEdit.idInstalacionesC,
      pisoEdit.anioFiscalC,
      7,
      "#valorOtrasInstaEdit",
      "instalacionesC"
    );
  });
  $(document).on("change", "#estadoConservaEdit", function () {
    pisoEdit.estadoConservaC = $("#estadoConservaEdit").val();
    modificaciones = false;
  });
  $(document).on("change", "#materialConsEdit", function () {
    pisoEdit.materialPisoC = $("#materialConsEdit").val();
    modificaciones = false;
  });
  $(document).on("change", "#clasificaPisoEdit", function () {
    pisoEdit.clasifiPisoC = $("#clasificaPisoEdit").val();
    modificaciones = false;
  });
  $(document).on("change", "#fechaAntiguedadEdit", function () {
    pisoEdit.fechaConstruccinC = $("#fechaAntiguedadEdit").val();
    modificaciones = false;
  });
  //---- Depreciar Piso a Editar -----
  $(document).on("click", "#btnDepreciarEdit", function () {
    pisoEdit.fechaConstruccinC = $("#fechaAntiguedadEdit").val();
    if (
      pisoEdit.calcularRangoDepreciacion() >= 0 &&
      pisoEdit.estadoConservaC !== null &&
      pisoEdit.clasifiPisoC !== null &&
      pisoEdit.materialPisoC !== null
    ) {
      $.ajax({
        type: "POST",
        url: "ajax/pisos.ajax.php",
        data: {
          f1: pisoEdit.calcularRangoDepreciacion(), //devuelve el rango
          f2: pisoEdit.materialPisoC, //
          f3: pisoEdit.clasifiPisoC,
          f4: pisoEdit.estadoConservaC,
        },
        success: function (respuesta) {
          pisoEdit.tasaDepresciaC = respuesta;
          $("#tasaDepreEdit").val(respuesta + " %");
          pisoEdit.DepreciarPiso();
          $("#depresiacionEdit").val(pisoEdit.montoDepreciacionC);
          $("#valUniDepreciadoEdit").val(pisoEdit.valorUnitDepreC);
          $("#aniosAntiguedadEdit").val(pisoEdit.aniosAntiguedadC);
          pisoEdit.calcularValorAreaConstruida();
          $("#valorAreaConstruEdit").val(
            parseFloat(pisoEdit.valorAreaConstruidaC).toFixed(2)
          );
          pisoEdit.calcularValorConstruccion();
          $("#valorConstrucionEdit").val(
            parseFloat(pisoEdit.valorConstruccionC).toFixed(2)
          );
        },
        error: function () {
          console.error("Error en la solicitud AJAX");
        },
      });
      modificaciones = true;
    } else if (pisoEdit.estadoConservaC === null) {
      $("#respuestaAjax_srm").html('<div class="alert warning">' +
          '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
          '<span aria-hidden="true" class="letra">×</span>' +
          '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Debe elegir ESTADO DE CONSERVACION</span></p></div>'
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    } else if (pisoEdit.clasifiPisoC === null) {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
        '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
        '<span aria-hidden="true" class="letra">×</span>' +
        '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Debe elegir CLASIFICADOR</span></p></div>'
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    } else if (pisoEdit.materialPisoC === null) {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
        '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
        '<span aria-hidden="true" class="letra">×</span>' +
        '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Debe elegir MATERIAL DE CONSTRUCCION</span></p></div>'
    
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    } else if (
      pisoEdit.fechaConstruccinC === "" ||
      pisoEdit.calcularRangoDepreciacion() < 0
    ) {
      $("#respuestaAjax_srm").html('<div class="alert warning">' +
        '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
        '<span aria-hidden="true" class="letra">×</span>' +
        '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">FECHA DE CONSTRUCCION no valida</span></p></div>'
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    }
  });
  //---- Digitar area En modal editar
  $(document).on("change", "#areaConstruidaEdit", function () {
    pisoEdit.areaConstruidaC = parseFloat($("#areaConstruidaEdit").val());
    pisoEdit.calcularValorAreaConstruida();
    pisoEdit.calcularValorConstruccion();
    $("#valorAreaConstruEdit").val(
      parseFloat(pisoEdit.valorAreaConstruidaC).toFixed(2)
    );
    $("#valorConstrucionEdit").val(
      parseFloat(pisoEdit.valorConstruccionC).toFixed(2)
    );
  });
  //---- Guardar Modificacion Piso
  $(document).on("click", "#btnRegistrarEditar", function () {
    if (modificaciones) {
      let letrasValorEdica=null;
     if(pisoEdit.idAnioFiscalC>19){
        letrasValorEdica =
        $("#murosColumnasEdit").find("option:selected").text() +
        "" +
        $("#techosEdit").find("option:selected").text() +
        "" +
        $("#puertasVentanasEdit").find("option:selected").text(); 
     }
     else{
      letrasValorEdica =
      $("#murosColumnasEdit").find("option:selected").text() +
      "" +
      $("#techosEdit").find("option:selected").text() +
      "" +
      $("#pisosEdit").find("option:selected").text() +
      "" +
      $("#puertasVentanasEdit").find("option:selected").text()+
      ""+
      $("#revestimientoEdit").find("option:selected").text()+
      ""+
      $("#baniosEdit").find("option:selected").text()+
      ""+
      $("#OtrasInstaEdit").find("option:selected").text();

     }
      let formd = new FormData();
      formd.append("idCatastroRow", pisoEdit.idCatasttroC);
      formd.append("numeroPiso", pisoEdit.numePisoC);
      formd.append("fechaAntiguedad", pisoEdit.fechaConstruccinC);
      formd.append("cantidadAños", pisoEdit.aniosAntiguedadC);
      formd.append("valUnitariosCal", pisoEdit.valorUnitarioC);
      formd.append("tasaDepreCal", pisoEdit.tasaDepresciaC);
      formd.append("depresiacionInp", pisoEdit.montoDepreciacionC);
      formd.append("valUniDepreciadoImp", pisoEdit.valorUnitDepreC);
      formd.append("areaConstruidaImp", pisoEdit.areaConstruidaC);
      formd.append("valorAreaConstruImp", pisoEdit.valorAreaConstruidaC);
      formd.append("areaComunesImp", pisoEdit.areasComunesC);
      formd.append("valorAreComunImp", pisoEdit.valorAreasComunesC);
      formd.append("valorConstrucionCal", pisoEdit.valorConstruccionC);
      formd.append("estadoConservaImp", pisoEdit.estadoConservaC);
      formd.append("clasificaPisoImp", pisoEdit.clasifiPisoC);
      formd.append("materialConsImp", pisoEdit.materialPisoC);
      formd.append("idAnioFiscal", pisoEdit.idAnioFiscalC);
      formd.append("murosColumnas", pisoEdit.idMurosColunsC);//null
      formd.append("techos", pisoEdit.idTechosC);//null
      formd.append("puertasVentanas", pisoEdit.idPuertasVentaC);//null
      formd.append("idPidoEdit", pisoEdit.idPisoC);
      formd.append("IdPredio", pisoEdit.idPredioC);
      formd.append("letrasValorEdica", letrasValorEdica);
      formd.append("editar_piso", "editar_piso");
     for (const pair of formd.entries()) {
        console.log(pair[0] + ", " + pair[1]);
     }
      $.ajax({
        type: "POST",
        url: "ajax/pisos.ajax.php",
        data: formd, // Solo necesitas pasar 'formd' como datos
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          //respuesta = JSON.parse(respuesta);
          if (respuesta.tipo === "error") {
            $("#errorPiso").show(); // Mostrar el elemento #error antes de establecer el mensaje
            $("#errorPiso").html(respuesta.mensaje);
            setTimeout(function () {
              $("#errorPiso").hide();
            }, 4000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
          } else {
            $("#respuestaAjax_correcto").html(respuesta.mensaje);
            $("#modalEditarPiso").modal("hide");
            $("#respuestaAjax_correcto").show(); // Muestra el mensaje
            // Obtener los parámetros actuales de la URL
            setTimeout(function () {
              $("#respuestaAjax_correcto").hide(); // Oculta el mensaje después de un tiempo (por ejemplo,
            }, 3000); // 3 segundos
            pisoEdit.MostrarPisos(
              pisoEdit.idCatasttroC,
              pisoEdit.idAnioFiscalC
            );
          }
        },
      });
    } else {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
        '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
        '<span aria-hidden="true" class="letra">×</span>' +
        '</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Ha realizado cambios debe volver a <strong>DEPRECIAR</strong> el piso</span></p></div>'
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 5000);
    }
  });
  //---- Salir Modal -----
  $(document).on("click", "#btnSalirModalEditar", function () {
    $("#modalEditarPiso").modal("hide");
  });
  $("#modalEditarPiso").on("hidden.bs.modal", function (e) {
    $("#formEditarPiso")[0].reset();
  });



  
//=============== ELIMINAR PISO ======================
$("#btnEliminarPiso").on("click", function () {
  if (filaPiso) {
    // Mostrar el modal de confirmación
    $('#modal_eliminar_piso').modal('show');
  } else {
    $("#respuestaAjax_correcto").html(
      '<div class="alert alert-warning" role="alert">DEBE SELECCIONAR UN PISO</div>'
    );
    $("#respuestaAjax_correcto").show();
    setTimeout(function () {
      $("#respuestaAjax_correcto").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
    }, 3000);
  }
});

  



// Al hacer clic en el botón de confirmar eliminación dentro del modal
$("#confirmarEliminarPiso").on("click", function () {
  $.ajax({
    type: "POST",
    url: "ajax/pisos.ajax.php",
    data: {
      idPidoEdit: pisoEdit.idPisoC,
      eliminar_piso: "eliminar_piso",
    },
    success: function (respuesta) {
      if (respuesta.tipo === "error") {
        $("#errorPiso").show(); // Mostrar el elemento #error antes de establecer el mensaje
        $("#errorPiso").html(respuesta.mensaje);
        setTimeout(function () {
          $("#errorPiso").hide();
        }, 4000); 
      } else {
        $("#respuestaAjax_correcto").html(respuesta.mensaje);
        $("#modalAgregarPiso").modal("hide");
        $("#respuestaAjax_correcto").show(); // Muestra el mensaje

        setTimeout(function () {
          $("#respuestaAjax_correcto").hide(); 
        }, 3000); // 3 segundos
        filaPiso = false;
        nuevoPiso.MostrarPisos(
          nuevoPiso.idCatasttroC,
          nuevoPiso.idAnioFiscalC
        );
      }
    },
    error: function () {
      console.error("Error en la solicitud AJAX");
    },
  });

  // Cerrar el modal después de realizar la eliminación
  $('#modal_eliminar_piso').modal('hide');
});








  //=============== ELIMINAR PISO ======================
  // $("#btnEliminarPiso").on("click", function () {
  //   if (filaPiso) {
  //     $.ajax({
  //       type: "POST",
  //       url: "ajax/pisos.ajax.php",
  //       data: {
  //         idPidoEdit: pisoEdit.idPisoC,
  //         eliminar_piso: "eliminar_piso",
  //       },
  //       success: function (respuesta) {
  //         if (respuesta.tipo === "error") {
  //           $("#errorPiso").show(); // Mostrar el elemento #error antes de establecer el mensaje
  //           $("#errorPiso").html(respuesta.mensaje);
  //           setTimeout(function () {
  //             $("#errorPiso").hide();
  //           }, 4000); 
  //         } else {
  //           $("#respuestaAjax_correcto").html(respuesta.mensaje);
  //           $("#modalAgregarPiso").modal("hide");
  //           $("#respuestaAjax_correcto").show(); // Muestra el mensaje

  //           setTimeout(function () {
  //             $("#respuestaAjax_correcto").hide(); 
  //           }, 3000); // 3 segundos
  //           filaPiso = false;
  //           nuevoPiso.MostrarPisos(
  //             nuevoPiso.idCatasttroC,
  //             nuevoPiso.idAnioFiscalC
  //           );
  //         }
  //       },
  //       error: function () {
  //         console.error("Error en la solicitud AJAX");
  //       },
  //     });
  //   } else {
  //     $("#respuestaAjax_correcto").html(
  //       '<div class="alert alert-warning" role="alert">DEBE SELECCIONAR UN PISO</div>'
  //     );
  //     $("#respuestaAjax_correcto").show();
  //     setTimeout(function () {
  //       $("#respuestaAjax_correcto").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
  //     }, 3000);
  //   }
  // });




  //============FUNCIONES==========================
  function TraerValorxCategoria(
    categoriaP,
    anioFiscalP,
    parametroP,
    inputSalida,
    atriClas
  ) {
    $.ajax({
      type: "POST",
      url: "ajax/pisos.ajax.php",
      data: {
        categoria: categoriaP,
        anio: anioFiscalP,
        parametro: parametroP,
      },
      success: function (respuesta) {
        let valorNumerico = parseFloat(respuesta);
        $(inputSalida).val(valorNumerico);
        nuevoPiso[atriClas] = valorNumerico;
        $("#valUnitariosCal").val(nuevoPiso.calcularValorUnitario().toFixed(2));
      },
      error: function () {
        console.error("Error en la solicitud AJAX");
      },
    });
  }

  //CONSTRCCIONES

    function TraerValorxCategoriaC(
    categoriaP,
    anioFiscalP,
    parametroP,
    inputSalida,
    atriClas
  ) {

  console.log("Enviando a pisos.ajax.php:");
  console.log("Categoría:", categoriaP);
  console.log("Año fiscal:", anioFiscalP);
  console.log("Parámetro:", parametroP);
  console.log("Campo de salida:", inputSalida);
  console.log("Propiedad en nuevoPiso:", atriClas);


    $.ajax({
      type: "POST",
      url: "ajax/pisos.ajax.php",
      data: {
        categoria: categoriaP,
        anio: anioFiscalP,
        parametro: parametroP,
      },
      success: function (respuesta) {
        let valorNumerico = parseFloat(respuesta);
        $(inputSalida).val(valorNumerico);
        nuevoPisoC[atriClas] = valorNumerico;
        $("#valUnitariosCalC").val(nuevoPisoC.calcularValorUnitarioC().toFixed(2));
      },
      error: function () {
        console.error("Error en la solicitud AJAX");
      },
    });
  }




  function TraerValorxCategoriaEdit(
    categoriaPE,
    anioFiscalPE,
    parametroPE,
    inputSalida,
    atriClas
  ) {
    $.ajax({
      type: "POST",
      url: "ajax/pisos.ajax.php",
      data: {
        categoria: categoriaPE,
        anio: anioFiscalPE,
        parametro: parametroPE,
      },
      success: function (respuesta) {
        let valorNumerico = parseFloat(respuesta);
        $(inputSalida).val(valorNumerico);
        pisoEdit[atriClas] = valorNumerico;
        $("#valUnitariosEdit").val(pisoEdit.calcularValorUnitario().toFixed(2));
      },
      error: function () {
        console.error("Error en la solicitud AJAX");
      },
    });
  }
  function BloquerCamposRegistro() {
    $("#pisos").prop("disabled", true);
    $("#valorPisos").prop("disabled", true);
    $("#revestimiento").prop("disabled", true);
    $("#valorRevestimientos").prop("disabled", true);
    $("#banios").prop("disabled", true);
    $("#valorBaños").prop("disabled", true);
    $("#OtrasInsta").prop("disabled", true);
    $("#valorOtrasInsta").prop("disabled", true);
  }
  function DesbloqueoCamposRegistro() {
    $("#pisos").prop("disabled", false);
    $("#valorPisos").prop("disabled", true);
    $("#revestimiento").prop("disabled", false);
    $("#valorRevestimientos").prop("disabled", true);
    $("#banios").prop("disabled", false);
    $("#valorBaños").prop("disabled", true);
    $("#OtrasInsta").prop("disabled", false);
    $("#valorOtrasInsta").prop("disabled", true);
  }
  function BloquearCamposEdicion() {
    $("#pisosEdit").prop("disabled", true);
    $("#valorPisosEdit").prop("disabled", true);
    $("#revestimientoEdit").prop("disabled", true);
    $("#valorRevestimientosEdit").prop("disabled", true);
    $("#baniosEdit").prop("disabled", true);
    $("#valorBaniosEdit").prop("disabled", true);
    $("#OtrasInstaEdit").prop("disabled", true);
    $("#valorOtrasInstaEdit").prop("disabled", true);
  } 
  function DesbloquearCamposEdicion() {
    $("#pisosEdit").prop("disabled", false);
    $("#valorPisosEdit").prop("disabled", true);
    $("#revestimientoEdit").prop("disabled", false);
    $("#valorRevestimientosEdit").prop("disabled", true);
    $("#baniosEdit").prop("disabled", false);
    $("#valorBaniosEdit").prop("disabled", true);
    $("#OtrasInstaEdit").prop("disabled", false);
    $("#valorOtrasInstaEdit").prop("disabled", true);
  }
  function EncontrarMontoParaLetraSinAccion() {
    if (pisoEdit.anioFiscalC >= 2023) {
      pisoEdit.idMurosColunsC=$("#murosColumnasEdit").val();
      TraerValorxCategoriaEdit(
        $("#murosColumnasEdit").val(),
        pisoEdit.anioFiscalC,
        1,
        "#valorMurosEdit",
        "murosColumnasC"
      );
      pisoEdit.idTechosC=$("#techosEdit").val();
      TraerValorxCategoriaEdit(
        $("#techosEdit").val(),
        pisoEdit.anioFiscalC,
        2,
        "#valorTechosEdit",
        "techosC"
      );
      pisoEdit.idPuertasVentaC=$("#puertasVentanasEdit").val();
      TraerValorxCategoriaEdit(
        $("#puertasVentanasEdit").val(),
        pisoEdit.anioFiscalC,
        4,
        "#valorPuertasyVentanasEdit",
        "puertasVentanasC"
      );
    } else {
      pisoEdit.idMurosColunsC=$("#murosColumnasEdit").val();
      TraerValorxCategoriaEdit(
        $("#murosColumnasEdit").val(),
        pisoEdit.anioFiscalC,
        1,
        "#valorMurosEdit",
        "murosColumnasC"
      );
      pisoEdit.idTechosC=$("#techosEdit").val();
      TraerValorxCategoriaEdit(
        $("#techosEdit").val(),
        pisoEdit.anioFiscalC,
        2,
        "#valorTechosEdit",
        "techosC"
      );
      pisoEdit.idPisosC=$("#pisosEdit").val();
      TraerValorxCategoriaEdit(
        $("#pisosEdit").val(),
        pisoEdit.anioFiscalC,
        3,
        "#valorPisosEdit",
        "pisosC"
      );
      pisoEdit.idPuertasVentaC=$("#puertasVentanasEdit").val();
      TraerValorxCategoriaEdit(
        $("#puertasVentanasEdit").val(),
        pisoEdit.anioFiscalC,
        4,
        "#valorPuertasyVentanasEdit",
        "puertasVentanasC"
      );
      pisoEdit.idRevestimientoC=$("#revestimientoEdit").val();
      TraerValorxCategoriaEdit(
        $("#revestimientoEdit").val(),
        pisoEdit.anioFiscalC,
        5,
        "#valorRevestimientosEdit",
        "revestimientoC"
      );
      pisoEdit.idBañosC=$("#baniosEdit").val();
      TraerValorxCategoriaEdit(
        $("#baniosEdit").val(),
        pisoEdit.anioFiscalC,
        6,
        "#valorBaniosEdit",
        "baniosC"
      );
     pisoEdit.idInstalacionesC=$("#OtrasInstaEdit").val();
      TraerValorxCategoriaEdit(
        $("#OtrasInstaEdit").val(),
        pisoEdit.anioFiscalC,
        7,
        "#valorOtrasInstaEdit",
        "instalacionesC"
      );
    }
  }
});


//MOSTRAR VISUALIZACION DE CUADRO DE VALORES
  
//=============== CUADRO DE VALOR EN NUEVO PISO ======================
$("#btnVerCuadroValor").on("click", function () {
  
    // Mostrar el modal de confirmación
    $('#modalVerCuadroValor').modal('show');

});

 
//=============== CUADRO DE VALOR EN EDITAR PISO ======================
$("#btnEditarCuadroValor").on("click", function () {
  
    // Mostrar el modal de confirmación
    $('#modalVerCuadroValor').modal('show');

});

