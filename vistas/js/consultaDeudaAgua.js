class ConsultaDeudaAguaClass {
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
      
    }
    
    contribibuyente_agua_lista_func(page,searchClass) {
        let perfilOculto_c = $("#perfilOculto_c").val();
        let searchContribuyente = $("." + searchClass).val();
            let parametros = {
              action: "ajax",
              page: page,
              searchContribuyente: searchContribuyente,
              tipo: searchClass,
              dpLicenciaAguaLista: "dpLicenciaAguaLista",
              perfilOculto_c: perfilOculto_c,
            };
            $.ajax({
              url: "vistas/tables/dataTables.php",
              data: parametros,
              beforeSend: function() {
                $(".body-contribuyente_agua_lista").html(loadingMessage);
              },
              success: function (data) {
                $(".body-contribuyente_agua_lista").html(data);
              },
              error: function() {
                $(".body-contribuyente_agua_lista").html(errordata);
              }
            });
          }
  pasar_parametro_get_consulta_agua(id) {
        window.location =
          "index.php?ruta=consulta-deuda-agua&id=" + id;
  }

  seleccionar_predio(){
   //filaSelect = true;
    //filaLicence = false;
    
   //$("#codigoCatastral").val(this.idCatastroC_consulta_agua);
    //$("#labelUbicacionLic").text(this.ubiLicenciaC_consulta_agua);
    //$("#labelCatastroLic").text(this.codCatastroC_consulta_agua);
    console.log("id_catastro:" + this.codCatastroC_consulta_agua);
    //TRAENDO LAS LICENCIAS DE AGUA POR PREDIO
    this.MostrarLicencia_deuda(this.codCatastroC_consulta_agua);
    
  }
  MostrarLicencia_deuda(idCatastroAgua_deuda) {
  
    $.ajax({
      type: "POST",
      url: "ajax/licenciaagua.ajax.php",
      data: {
        idCatastroAgua_deuda: idCatastroAgua_deuda,
      },
      success: function (respuesta) {
        //console.log(respuesta);
        $("#listaLicenciasAgua_deuda").html(respuesta);
        //Seleccionando la licencia para mostrar su estado de cuenta
      },
    });
  }


  //MESES

  //   MostrarEstadoCuentaAguaMeses(idlicencia, anio){
  //   //let self=this;

  //   var self = {}; // Inicializa el objeto que contendrá idsSeleccionados
  //   self.idsSeleccionados = []; // Inicializa el arreglo de ids seleccionados

  //   self.idguardado=idlicencia;
  //   self.idAno=anio;

    
  //   // Función para manejar el clic en las filas
  //   self.manejarClicFila_agua_meses = function(fila) {

  //       const filaId = fila.attr("id");
  //       const estadoS = fila.find("td:eq(9)").text(); // Obtiene el estado de la fila

  //       if (estadoS === "1") {
  //           // Deselecciona la fila
  //           fila.find("td:eq(9)").text(""); // Vacía el valor de la celda
  //           fila.css("background-color", ""); // Quita el color de fondo

  //           // Elimina el valor del id de la fila del array de seleccionados
  //           const index = self.idsSeleccionados.indexOf(filaId);
  //           if (index > -1) {
  //               self.idsSeleccionados.splice(index, 1); // Elimina el id
  //           }
  //       } else {
  //           // Selecciona la fila
  //           fila.find("td:eq(9)").text("1"); // Establece el valor de la celda a "1"
  //           fila.css("background-color", "rgb(255, 248, 167)"); // Cambia el color de fondo

  //           // Agrega el valor del id de la fila al array si no existe
  //           if (!self.idsSeleccionados.includes(filaId)) {
  //               self.idsSeleccionados.push(filaId); // Añade el id al array
  //           }
  //       }

  //       // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas o deseleccionadas
  //       console.log("Ids seleccionados _AGUA:", self.idsSeleccionados);

  //   };

   
  //   // Evento de clic en el botón "Recalcular meses"
  //   $('#calcular_agua_meses').on('click', function() {
  //       var selectedCategory = $('#categoriaLicAdr').val();  // El valor seleccionado del select
  //       console.log("Categoría seleccionada:", selectedCategory);
  //       // Acceso correcto al array de idsSeleccionados
  //       console.log("id seleccionado para guardar", self.idsSeleccionados);
  //       if (selectedCategory === "") {
  //           console.log("No se ha seleccionado ninguna categoría.");
  //       } else {
  //           console.log("Categoría seleccionada:", selectedCategory);
  //       }

  //        let datos = new FormData();

  //         datos.append("idCategoria",selectedCategory);
  //         datos.append("idSelecionado",self.idsSeleccionados);
  //         datos.append("registrar_meses","registrar_meses");
        
  //         console.log(datos);
  //         $.ajax({
  //           url: "ajax/licenciaagua.ajax.php",
  //           method: "POST",
  //           data: datos,
  //           cache: false,
  //           contentType: false,
  //           processData: false,
  //          success: function (rutaArchivo) {

  //               console.log("Respuesta recibida:", rutaArchivo); // Ver respuesta completa
  //             if (rutaArchivo.trim() === "ok") {
  //                 console.log("Respuesta OK: Recargando la interfaz.");
  //                self.MostrarEstadoCuentaAguaMeses(self.idguardado, self.idAno);

  //             } else {
  //                 console.log("La respuesta no es OK. No se recargará la interfaz.");
  //             }
  //           },
  //           error: function() {
  //               console.log("Error al enviar los datos.");
  //           }
  //         });
        


  //   });

  //   let datos = new FormData();
  //   datos.append("idlicencia",idlicencia);
  //   datos.append("anio",anio);
  //    datos.append("idlicenciaagua_estadocuenta_meses","idlicenciaagua_estadocuenta_meses");


  //   $.ajax({
  //     type: "POST",
  //     url: "ajax/licenciaagua.ajax.php",
  //     method: "POST",
  //     data: datos,
  //     cache: false,
  //     contentType: false,
  //     processData: false,
  //     success: function (respuesta) {
  //       $("#listaLicenciasAgua_estadocuenta_meses").html(respuesta);
       
  //           // Función para manejar el clic en las filas de la tabla y sumar los valores
  //           $("#primeraTabla_agua_m tbody tr").on("click", function () {
  //             self.manejarClicFila_agua_meses($(this));


  //           });
           
  //     },
  //   });

  // }






  MostrarEstadoCuentaAgua(idlicencia){
    let self=this;
    $.ajax({
      type: "POST",
      url: "ajax/licenciaagua.ajax.php",
      data: {
        idlicenciaagua_estadocuenta: idlicencia,
      },
      success: function (respuesta) {
        $("#listaLicenciasAgua_estadocuenta").html(respuesta);
       
            // Función para manejar el clic en las filas de la tabla y sumar los valores
            $("#primeraTabla_agua tbody tr").on("click", function () {
              self.manejarClicFila_agua($(this));
            });
            // Función para manejar el clic en el encabezado "S"
            $("#primeraTabla_agua thead th:eq(9)").on("click", function () {
              self.manejarClicS($(this));
            });

      },
    });

  }

  MostrarEstadoCuentaAgua_pagados(idlicencia){
    let self=this;
    $.ajax({
      type: "POST",
      url: "ajax/licenciaagua.ajax.php",
      data: {
        idlicenciaagua_estadocuenta_pagados: idlicencia,
        
      },
      success: function (respuesta) {
        $("#listaLicenciasAgua_estadocuenta_pagados").html(respuesta);
       
            // Función para manejar el clic en las filas de la tabla y sumar los valores
            $("#primeraTabla_agua_pagados tbody tr").on("click", function () {
              self.manejarClicFila_agua_pagados($(this));
            });
            // Función para manejar el clic en el encabezado "S"
            $("#primeraTabla_agua_pagados thead th:eq(10)").on("click", function () {
              self.manejarClicS_pagados($(this));
            });

      },
    });

  }
  manejarClicS(thS) {
    const filas = $("#primeraTabla_agua tbody tr");
    const todasSeleccionadas = $("td:eq(9):contains('1')", filas).length === filas.length;
    if (todasSeleccionadas) {
      // Todas las filas están seleccionadas, deseleccionar todas
      filas.each((index, fila) => {
        this.manejarClicFila($(fila));
      });
    } else {
      // Al menos una fila ya está seleccionada, completar las faltantes
      filas.each((index, fila) => {
        if ($("td:eq(9)", fila).text() !== "1") {
          this.manejarClicFila($(fila));
        }
      });
    }
    thS.text(todasSeleccionadas ? "S" : "S");
    // Actualizar los totales en la segunda tabla
    $("#segundaTabla_agua tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua tbody th:eq(5)").text(this.totalTotal.toFixed(2));
  }
 
  



//SELECIONAR MEESES
  
// manejarClicFila_agua_meses(fila) {
//     const filaId = fila.attr("id");
//         fila.find("td:eq(9)").text("1"); // Aquí estableces el valor a "1"
//         fila.css("background-color", "rgb(255, 248, 167)");   
//         // Agregar el valor del id de la fila al array (si no existe)
//         if (!this.idsSeleccionados.includes(filaId)) {
//             this.idsSeleccionados.push(filaId);
//         }

        
//     // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
//     console.log("Ids seleccionados _AGUA :", this.idsSeleccionados);
// }







//CAPTURAR EL VALOR SELCIOANDO

manejarClicFila_agua(fila) {
    const estadoS = fila.find("td:eq(9)").text();
    const gastoText = fila.find("td:eq(5)").text();
    const subtotalText = fila.find("td:eq(6)").text();
    const timText = fila.find("td:eq(7)").text();
    const totalText = fila.find("td:eq(8)").text();
    const importeText = fila.find("td:eq(4)").text();
    
    const gasto = parseFloat(gastoText);
    const subtotal = parseFloat(subtotalText);
    const tim = parseFloat(timText);
    const total = parseFloat(totalText);
    const importe = parseFloat(importeText);
    
    // Capturar el valor del atributo "id" de la fila y agregarlo al array si está seleccionada
    const filaId = fila.attr("id");
    
    if (estadoS === "1") {
        this.totalGasto -= gasto;
        this.totalSubtotal -= subtotal;
        this.totalTIM -= tim;
        this.totalTotal -= total;
        this.totalImporte -= importe;
        
        fila.find("td:eq(9)").text(""); // Aquí debería establecerse el valor a ""
        fila.css("background-color", "");
        
        // Eliminar el valor del id de la fila del array (si existe)
        const index = this.idsSeleccionados.indexOf(filaId);
        if (index > -1) {
            this.idsSeleccionados.splice(index, 1);
        }
    } else {
        this.totalGasto += gasto;
        this.totalSubtotal += subtotal;
        this.totalTIM += tim;
        this.totalTotal += total;
        this.totalImporte += importe;
        fila.find("td:eq(9)").text("1"); // Aquí estableces el valor a "1"
        fila.css("background-color", "rgb(255, 248, 167)");   
        // Agregar el valor del id de la fila al array (si no existe)
        if (!this.idsSeleccionados.includes(filaId)) {
            this.idsSeleccionados.push(filaId);
        }
    }
    // Actualización de las celdas de la segunda tabla
    $("#segundaTabla_agua tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua tbody th:eq(5)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados _AGUA :", this.idsSeleccionados);
}
  
  manejarClicFila(fila) {
    const estadoS = fila.find("td:eq(9)").text();
    const gastoText = fila.find("td:eq(5)").text();
    const subtotalText = fila.find("td:eq(6)").text();
    const desText = fila.find("td:eq(7)").text();
    const totalText = fila.find("td:eq(8)").text();
    const importeText = fila.find("td:eq(4)").text();
    
    const gasto = parseFloat(gastoText);
    const subtotal = parseFloat(subtotalText);
    const des = parseFloat(desText);
    const total = parseFloat(totalText);
    const importe = parseFloat(importeText);
    
    // Capturar el valor del atributo "id" de la fila y agregarlo al array si está seleccionada
    const filaId = fila.attr("id");
    
    if (estadoS === "1") {
        this.totalGasto -= gasto;
        this.totalSubtotal -= subtotal;
        this.totalDes -= des;
        this.totalTotal -= total;
        this.totalImporte -= importe;
        
        fila.find("td:eq(9)").text("");
        fila.css("background-color", "");
        
        // Eliminar el valor del id de la fila del array (si existe)
        const index = this.idsSeleccionados.indexOf(filaId);
        if (index > -1) {
            this.idsSeleccionados.splice(index, 1);
        }
    } else {
        this.totalGasto += gasto;
        this.totalSubtotal += subtotal;
        this.totalDes += des;
        this.totalTotal += total;
        this.totalImporte += importe;
        fila.find("td:eq(9)").text("1");
        fila.css("background-color", "rgb(255, 248, 167)");   
        // Agregar el valor del id de la fila al array (si no existe)
        if (!this.idsSeleccionados.includes(filaId)) {
            this.idsSeleccionados.push(filaId);
        }
    }
    $("#segundaTabla tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla tbody th:eq(4)").text(this.totalDes.toFixed(2));
    $("#segundaTabla tbody th:eq(5)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados:", this.idsSeleccionados);
  } 



  manejarClicS_pagados(thS) {
    const filas = $("#primeraTabla_agua_pagados tbody tr");
    const todasSeleccionadas = $("td:eq(10):contains('1')", filas).length === filas.length;
    if (todasSeleccionadas) {
      // Todas las filas están seleccionadas, deseleccionar todas
      filas.each((index, fila) => {
        this.manejarClicFila_pagados($(fila));
      });
    } else {
      // Al menos una fila ya está seleccionada, completar las faltantes
      filas.each((index, fila) => {
        if ($("td:eq(10)", fila).text() !== "1") {
          this.manejarClicFila_pagados($(fila));
        }
      });
    }
    thS.text(todasSeleccionadas ? "S" : "S");
    // Actualizar los totales en la segunda tabla
    $("#segundaTabla_agua_pagados tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(5)").text(this.totalTotal.toFixed(2));
  }
 
  

manejarClicFila_agua_pagados(fila) {
    const estadoS = fila.find("td:eq(10)").text();
    const gastoText = fila.find("td:eq(6)").text();
    const subtotalText = fila.find("td:eq(7)").text();
    const timText = fila.find("td:eq(8)").text();
    const totalText = fila.find("td:eq(9)").text();
    const importeText = fila.find("td:eq(5)").text();
    
    const gasto = parseFloat(gastoText);
    const subtotal = parseFloat(subtotalText);
    const tim = parseFloat(timText);
    const total = parseFloat(totalText);
    const importe = parseFloat(importeText);
    
    // Capturar el valor del atributo "id" de la fila y agregarlo al array si está seleccionada
    const filaId = fila.attr("id");
    
    if (estadoS === "1") {
        this.totalGasto -= gasto;
        this.totalSubtotal -= subtotal;
        this.totalTIM -= tim;
        this.totalTotal -= total;
        this.totalImporte -= importe;
        
        fila.find("td:eq(10)").text(""); // Aquí debería establecerse el valor a ""
        fila.css("background-color", "");
        
        // Eliminar el valor del id de la fila del array (si existe)
        const index = this.idsSeleccionados.indexOf(filaId);
        if (index > -1) {
            this.idsSeleccionados.splice(index, 1);
        }
    } else {
        this.totalGasto += gasto;
        this.totalSubtotal += subtotal;
        this.totalTIM += tim;
        this.totalTotal += total;
        this.totalImporte += importe;
        fila.find("td:eq(10)").text("1"); // Aquí estableces el valor a "1"
        fila.css("background-color", "rgb(255, 248, 167)");   
        // Agregar el valor del id de la fila al array (si no existe)
        if (!this.idsSeleccionados.includes(filaId)) {
            this.idsSeleccionados.push(filaId);
        }
    }
    // Actualización de las celdas de la segunda tabla
    $("#segundaTabla_agua_pagados tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(5)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados _AGUA :", this.idsSeleccionados);
}
  
  manejarClicFila_pagados(fila) {
    const estadoS = fila.find("td:eq(10)").text();
    const gastoText = fila.find("td:eq(6)").text();
    const subtotalText = fila.find("td:eq(7)").text();
    const desText = fila.find("td:eq(8)").text();
    const totalText = fila.find("td:eq(9)").text();
    const importeText = fila.find("td:eq(5)").text();
    
    const gasto = parseFloat(gastoText);
    const subtotal = parseFloat(subtotalText);
    const des = parseFloat(desText);
    const total = parseFloat(totalText);
    const importe = parseFloat(importeText);
    
    // Capturar el valor del atributo "id" de la fila y agregarlo al array si está seleccionada
    const filaId = fila.attr("id");
    
    if (estadoS === "1") {
        this.totalGasto -= gasto;
        this.totalSubtotal -= subtotal;
        this.totalDes -= des;
        this.totalTotal -= total;
        this.totalImporte -= importe;
        
        fila.find("td:eq(10)").text("");
        fila.css("background-color", "");
        
        // Eliminar el valor del id de la fila del array (si existe)
        const index = this.idsSeleccionados.indexOf(filaId);
        if (index > -1) {
            this.idsSeleccionados.splice(index, 1);
        }
    } else {
        this.totalGasto += gasto;
        this.totalSubtotal += subtotal;
        this.totalDes += des;
        this.totalTotal += total;
        this.totalImporte += importe;
        fila.find("td:eq(10)").text("1");
        fila.css("background-color", "rgb(255, 248, 167)");   
        // Agregar el valor del id de la fila al array (si no existe)
        if (!this.idsSeleccionados.includes(filaId)) {
            this.idsSeleccionados.push(filaId);
        }
    }
    $("#segundaTabla_agua_pagados tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(4)").text(this.totalDes.toFixed(2));
    $("#segundaTabla_agua_pagados tbody th:eq(5)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados:", this.idsSeleccionados);
  } 


  //NOTIFICACION
  
  imprimirhere_agua_n() {
    const Propietarios_ = []; // Declarar un arreglo vacío
    $("#id_propietarios tr").each(function (index){
      // Accede al valor del atributo 'id' de cada fila
      var idFila = $(this).attr("id_contribuyente");
      Propietarios_[index] = idFila; // Agregar el valor al arreglo
    });
    const Propietarios = Propietarios_.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });
    console.log(Propietarios);
    const idsSeleccionados_ = this.idsSeleccionados.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });
    let datos = new FormData();
    datos.append("idlicencia",this.idlicenciaagua);
    datos.append("id_cuenta",idsSeleccionados_);
    datos.append("propietarios",Propietarios);
    datos.append("totalImporte",this.totalImporte.toFixed(2));
    datos.append("totalGasto",this.totalGasto.toFixed(2));
    datos.append("totalSubtotal",this.totalSubtotal.toFixed(2));
    datos.append("totalTIM",this.totalTIM.toFixed(2));
    datos.append("totalTotal",this.totalTotal.toFixed(2));
    console.log(datos);
    $.ajax({
      url: "./vistas/print/imprimirEstadoCuentaAguaN.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (rutaArchivo) {
        // Establecer el src del iframe con la ruta relativa del PDF
        document.getElementById("iframe_agua_n").src = 'vistas/print/' + rutaArchivo;
      }
    });
  }



  imprimirhere_agua() {
    const Propietarios_ = []; // Declarar un arreglo vacío
    $("#id_propietarios tr").each(function (index){
      // Accede al valor del atributo 'id' de cada fila
      var idFila = $(this).attr("id_contribuyente");
      Propietarios_[index] = idFila; // Agregar el valor al arreglo
    });
    const Propietarios = Propietarios_.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });
    console.log(Propietarios);
    const idsSeleccionados_ = this.idsSeleccionados.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });
    let datos = new FormData();
    datos.append("idlicencia",this.idlicenciaagua);
    datos.append("id_cuenta",idsSeleccionados_);
    datos.append("propietarios",Propietarios);
    datos.append("totalImporte",this.totalImporte.toFixed(2));
    datos.append("totalGasto",this.totalGasto.toFixed(2));
    datos.append("totalSubtotal",this.totalSubtotal.toFixed(2));
    datos.append("totalTIM",this.totalTIM.toFixed(2));
    datos.append("totalTotal",this.totalTotal.toFixed(2));
    console.log(datos);
    $.ajax({
      url: "./vistas/print/imprimirEstadoCuentaAgua.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (rutaArchivo) {
        // Establecer el src del iframe con la ruta relativa del PDF
        document.getElementById("iframe_agua").src = 'vistas/print/' + rutaArchivo;
      }
    });
  }
  imprimirhere_agua_pagados() {
    const Propietarios_ = []; // Declarar un arreglo vacío
    $("#id_propietarios tr").each(function (index){
      // Accede al valor del atributo 'id' de cada fila
      var idFila = $(this).attr("id_contribuyente");
      Propietarios_[index] = idFila; // Agregar el valor al arreglo
    });
    const Propietarios = Propietarios_.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });
    console.log(Propietarios);
    const idsSeleccionados_ = this.idsSeleccionados.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });
    let datos = new FormData();
    datos.append("idlicencia",this.idlicenciaagua);
    datos.append("id_cuenta",idsSeleccionados_);
    datos.append("propietarios",Propietarios);
    datos.append("totalImporte",this.totalImporte.toFixed(2));
    datos.append("totalGasto",this.totalGasto.toFixed(2));
    datos.append("totalSubtotal",this.totalSubtotal.toFixed(2));
    datos.append("totalTIM",this.totalTIM.toFixed(2));
    datos.append("totalTotal",this.totalTotal.toFixed(2));
    console.log(datos);
    $.ajax({
      url: "./vistas/print/imprimirEstadoCuentaAguaPagados.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (rutaArchivo) {
        // Establecer el src del iframe con la ruta relativa del PDF
        document.getElementById("iframe_agua").src = 'vistas/print/' + rutaArchivo;
      }
    });
  }

  reniciar_valor(){
    this.totalImporte=0;
    this.totalGasto=0;
    this.totalSubtotal=0;
    this.totalTIM=0;
    this.totalTotal=0;
   
    $("#segundaTabla_agua tbody th:eq(1)").text("");
    $("#segundaTabla_agua tbody th:eq(2)").text("");
    $("#segundaTabla_agua tbody th:eq(3)").text("");
    $("#segundaTabla_agua tbody th:eq(4)").text("");
    $("#segundaTabla_agua tbody th:eq(5)").text("");
  }

   reniciar_valor_meses(){
    this.totalImporte=0;
    this.totalGasto=0;
    this.totalSubtotal=0;
    this.totalTIM=0;
    this.totalTotal=0;
   
    $("#segundaTabla_agua tbody th:eq(1)").text("");
    $("#segundaTabla_agua tbody th:eq(2)").text("");
    $("#segundaTabla_agua tbody th:eq(3)").text("");
    $("#segundaTabla_agua tbody th:eq(4)").text("");
    $("#segundaTabla_agua tbody th:eq(5)").text("");
  }


}

  const consulta_deuda_agua_lista = new ConsultaDeudaAguaClass();

  function lista_contribuyente_agua(page, searchClass) {
    if (event.keyCode === 13) {
      consulta_deuda_agua_lista.contribibuyente_agua_lista_func(page,searchClass);
      event.preventDefault();
    }
}
  //PASAR EL VALOR DE CONTRIBUYENTE BUSCADO A PREDIOS POR GET - VALIDADO para caja
$(document).on("click", ".btnCuentaAgua_lista", function () {
    let id = $(this).attr("idContribuyente_consulta_deuda");
    consulta_deuda_agua_lista.pasar_parametro_get_consulta_agua(id);
  });
 
$(document).on("click", "#tablalistaprediosAgua_consulta tbody tr", function() {
    //consulta_deuda_agua_lista.idCatastroC_consulta_agua = $(this).find("td:nth-child(4)").text();
    //consulta_deuda_agua_lista.ubiLicenciaC_consulta_agua = $(this).find("td:nth-child(3)").text();
     
    $("#tablalistaprediosAgua_consulta tbody tr").not(this).css("background-color", "");
    $(this).css("background-color", "rgb(255, 248, 167)");
    // Aquí puedes continuar con el resto de tu lógica si es necesario
    consulta_deuda_agua_lista.codCatastroC_consulta_agua = $(this).attr("idcatastro");
    consulta_deuda_agua_lista.seleccionar_predio();   
});

$(document).on("click", "#tablalistaLicences tbody tr", function() {
    //consulta_deuda_agua_lista.idCatastroC_consulta_agua = $(this).find("td:nth-child(4)").text();
    //consulta_deuda_agua_lista.ubiLicenciaC_consulta_agua = $(this).find("td:nth-child(3)").text();
    $("#tablalistaLicences tbody tr").not(this).css("background-color", "");
    $(this).css("background-color", "rgb(255, 248, 167)");

});



$(document).on("click", ".btnEstadoCuentaAgua", function() {
    consulta_deuda_agua_lista.reniciar_valor();
    consulta_deuda_agua_lista.idlicenciaagua = $(this).attr("idlicenciaagua");
    console.log("iDlicencia agua:"+consulta_deuda_agua_lista.idlicenciaagua)
    consulta_deuda_agua_lista.MostrarEstadoCuentaAgua(consulta_deuda_agua_lista.idlicenciaagua);
    $('#ModalEstado_cuentaAgua').modal('show');
    //ajustando el total de la columna 
});


//REACULLAR MESES ESPECIFICOS

$(document).on("click", ".btnEstadoCuentaAgua_meses", function() {

  console.log("llego aqui----");
    consulta_deuda_agua_lista.reniciar_valor_meses();
    consulta_deuda_agua_lista.idlicenciaagua = $(this).attr("idlicenciaagua");

    console.log("iDlicencia agua:"+consulta_deuda_agua_lista.idlicenciaagua)

 
    // Asignar el valor de idlicenciaagua al input
    $('#id_licienciaAgua').val(consulta_deuda_agua_lista.idlicenciaagua);
  
    
    $('#ModalEstado_cuentaAgua_Meses').modal('show');
    //ajustando el total de la columna 
});



// $(document).ready(function(){

//   $('#selectnumRe').change(function(){

//     consulta_deuda_agua_lista.reniciar_valor_meses();

     
//     var selectedYear = $(this).val();  // Captura el valor seleccionado
//     console.log("Año seleccionado: " + selectedYear);  // Muestra el valor en la consola o lo usas como necesites
//    consulta_deuda_agua_lista.anio=selectedYear;

//      var inputValue = $('#id_licienciaAgua').val();  // Captura el valor del input
//     console.log("Valor del input id_licienciaAgua: " + inputValue);  // Muestra e

//      consulta_deuda_agua_lista.idlicenciaagua=inputValue;


//      consulta_deuda_agua_lista.MostrarEstadoCuentaAguaMeses(consulta_deuda_agua_lista.idlicenciaagua, consulta_deuda_agua_lista.anio);


 
//   });
// });


//MOSTRAR RESOCLUION SELECIONADO

 $(document).ready(function() {
    // Cuando se cambie el valor en el select
    $('#descuendoServicioR').change(function() {
      // Verificar si el valor seleccionado es "2.00"
      if ($(this).val() == "2.00") {
        // Mostrar el div con id "pagoServicioExpedinteReMe"
        $('#pagoServicioExpedinteReMe').show();
      } else {
        // Ocultar el div si se selecciona otro valor
        $('#pagoServicioExpedinteReMe').hide();
      }
    });
  });

  //MOSTRAR CUADNO ES SINDICATO
  //MOSTRAR RESOCLUION SELECIONADO

 $(document).ready(function() {
    // Cuando se cambie el valor en el select
    $('#descuentoSindicatoR').change(function() {
      // Verificar si el valor seleccionado es "2.00"
      if ($(this).val() == "0.50") {
        // Mostrar el div con id "pagoServicioExpedinteReMe"
        $('#pagoServicioSidiactoReMe').show();
      } else {
        // Ocultar el div si se selecciona otro valor
        $('#pagoServicioSidiactoReMe').hide();
      }
    });
  });


$(document).on("click", ".btnEstadoCuentaAgua_pagados", function() {
  consulta_deuda_agua_lista.idlicenciaagua = $(this).attr("idlicenciaagua");
  console.log("iDlicencia agua:"+consulta_deuda_agua_lista.idlicenciaagua)
  consulta_deuda_agua_lista.MostrarEstadoCuentaAgua_pagados(consulta_deuda_agua_lista.idlicenciaagua);
  $('#ModalEstado_cuentaAgua_pagados').modal('show');
  //ajustando el total de la columna 
});

$(document).on("click", "#popimprimir_agua", function () {
  if(consulta_deuda_agua_lista.idsSeleccionados.length === 0)
  {
    $("#respuestaAjax_srm").show();
    $("#respuestaAjax_srm").html('<div class="col-sm-30">' +
    '<div class="alert alert-warning">' +
      '<button type="button" class="close font__size-18" data-dismiss="alert">' +
      '</button>' +
      '<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>' +
      '<strong class="font__weight-semibold">Alerta!</strong> Seleccione un fila para poder imprimir.' +
    '</div>' +
    '</div>');
    setTimeout(function () {
      $("#respuestaAjax_srm").hide();
    }, 4000);
  }
  else{
    consulta_deuda_agua_lista.imprimirhere_agua();
    $("#Modalimprimir_cuentaagua").modal("show");
    
  }
});

//NOTIFICACION
$(document).on("click", "#popimprimir_agua_n", function () {
  if(consulta_deuda_agua_lista.idsSeleccionados.length === 0)
  {
    $("#respuestaAjax_srm").show();
    $("#respuestaAjax_srm").html('<div class="col-sm-30">' +
    '<div class="alert alert-warning">' +
      '<button type="button" class="close font__size-18" data-dismiss="alert">' +
      '</button>' +
      '<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>' +
      '<strong class="font__weight-semibold">Alerta!</strong> Seleccione un fila para poder imprimir.' +
    '</div>' +
    '</div>');
    setTimeout(function () {
      $("#respuestaAjax_srm").hide();
    }, 4000);
  }
  else{
    consulta_deuda_agua_lista.imprimirhere_agua_n();
    $("#Modalimprimir_cuentaagua_n").modal("show");
    
  }
});



$(document).on("click", "#popimprimir_agua_pagados", function () {
  if(consulta_deuda_agua_lista.idsSeleccionados.length === 0)
  {
    $("#respuestaAjax_srm").show();
    $("#respuestaAjax_srm").html('<div class="col-sm-30">' +
    '<div class="alert alert-warning">' +
      '<button type="button" class="close font__size-18" data-dismiss="alert">' +
      '</button>' +
      '<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>' +
      '<strong class="font__weight-semibold">Alerta!</strong> Seleccione un fila para poder imprimir.' +
    '</div>' +
    '</div>');
    setTimeout(function () {
      $("#respuestaAjax_srm").hide();
    }, 4000);
  }
  else{
    consulta_deuda_agua_lista.imprimirhere_agua_pagados();
    $("#Modalimprimir_cuentaagua").modal("show");
    
  }
});






$(document).ready(function() {

    $('#selectnumRe').change(function() {

        aguaListaConsulta.reniciar_valor_meses();

        var selectedYear = $(this).val();  // Captura el valor seleccionado
        console.log("Año seleccionado: " + selectedYear);  // Muestra el valor en la consola o lo usas como necesites
        aguaListaConsulta.anio = selectedYear;

        var inputValue = $('#id_licienciaAgua').val();  // Captura el valor del input
        console.log("Valor del input id_licienciaAgua: " + inputValue);  // Muestra el valor

        aguaListaConsulta.idlicenciaagua = inputValue;

        aguaListaConsulta.MostrarEstadoCuentaAguaMeses(aguaListaConsulta.idlicenciaagua, aguaListaConsulta.anio);

    });
});


$(document).ready(function() {
    // Utilizar delegación de eventos para el botón dentro del modal
    $(document).on('click', '#calcular_agua_meses', function() {
        aguaListaConsulta.recalcularMeses();
    });
});


var aguaListaConsulta = {
    idsSeleccionados: [],
    idguardado: null,
    idAno: null,
    idlicenciaagua: null,
    anio: null,

    // Función para manejar el clic en las filas
    manejarClicFila_agua_meses: function(fila) {
        const filaId = fila.attr("id");
        const estadoS = fila.find("td:eq(9)").text(); // Obtiene el estado de la fila

        if (estadoS === "1") {
            // Deselecciona la fila
            fila.find("td:eq(9)").text(""); // Vacía el valor de la celda
            fila.css("background-color", ""); // Quita el color de fondo

            // Elimina el valor del id de la fila del array de seleccionados
            const index = this.idsSeleccionados.indexOf(filaId);
            if (index > -1) {
                this.idsSeleccionados.splice(index, 1); // Elimina el id
            }
        } else {
            // Selecciona la fila
            fila.find("td:eq(9)").text("1"); // Establece el valor de la celda a "1"
            fila.css("background-color", "rgb(255, 248, 167)"); // Cambia el color de fondo

            // Agrega el valor del id de la fila al array si no existe
            if (!this.idsSeleccionados.includes(filaId)) {
                this.idsSeleccionados.push(filaId); // Añade el id al array
            }
        }

        // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas o deseleccionadas
        console.log("Ids seleccionados _AGUA:", this.idsSeleccionados);
    },

    // MostrarEstadoCuentaAguaMeses para mostrar la cuenta de agua
    MostrarEstadoCuentaAguaMeses: function(idlicencia, anio) {
        this.idguardado = idlicencia;
        this.idAno = anio;

        let datos = new FormData();
        datos.append("idlicencia", idlicencia);
        datos.append("anio", anio);
        datos.append("idlicenciaagua_estadocuenta_meses", "idlicenciaagua_estadocuenta_meses");

        $.ajax({
            type: "POST",
            url: "ajax/licenciaagua.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                $("#listaLicenciasAgua_estadocuenta_meses").html(respuesta);

                // Función para manejar el clic en las filas de la tabla y sumar los valores
                $("#primeraTabla_agua_m tbody tr").on("click", function() {
                    aguaListaConsulta.manejarClicFila_agua_meses($(this));
                });

            },
        });
    },

    // Función para reiniciar valores
    reniciar_valor_meses: function() {
        // Aquí puedes reiniciar los valores que necesites, por ejemplo:
        this.idsSeleccionados = [];  // Limpiar el array de ids seleccionados
        console.log("Valores reiniciados.");
    },


    // Evento de clic en el botón "Recalcular meses"
    recalcularMeses: function() {
        var selectedCategory = $('#categoriaLicAdr').val();  // El valor seleccionado del select
        console.log("Categoría seleccionada:", selectedCategory);

        console.log("id seleccionado para guardar", this.idsSeleccionados);

        if (selectedCategory === "") {
            console.log("No se ha seleccionado ninguna categoría.");
        } else {
            console.log("Categoría seleccionada:", selectedCategory);
        }

        let datos = new FormData();
        datos.append("idCategoria", selectedCategory);
        datos.append("idSelecionado", this.idsSeleccionados);
        datos.append("registrar_meses", "registrar_meses");

        console.log(datos);
        $.ajax({
            url: "ajax/licenciaagua.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function(respuesta) {

                console.log("Respuesta recibida:", respuesta); // Ver respuesta completa

                 // Si la respuesta es una cadena con múltiples JSON concatenados
                var respuestas = respuesta.split('}{'); // Divide la cadena en partes. Esto debería funcionar si las respuestas son concatenadas correctamente.

                // Si el primer objeto está entre corchetes, lo unimos de nuevo
                if (respuestas.length > 1) {
                    respuestas[0] += '}'; // Cierra el primer objeto JSON
                    respuestas[1] = '{' + respuestas[1]; // Abre el segundo objeto JSON
                }

                // Intentamos convertir cada respuesta a objeto JSON
                var respuesta1 = JSON.parse(respuestas[0]);


                if (respuesta1.status === "ok") {

                    console.log("Respuesta OK: Recargando la interfaz.");


                    aguaListaConsulta.MostrarEstadoCuentaAguaMeses(aguaListaConsulta.idguardado, aguaListaConsulta.idAno);
               
                      $("#respuestaAjax_srm").html(respuesta1.message);
                        $("#respuestaAjax_srm").show(); // Muestra el mensaje

                            // Obtener los parámetros actuales de la URL
                        setTimeout(function () {
                                  $("#respuestaAjax_srm").hide(); //
                        }, 5000); // 3 segundos

               
               
                  } else {
                     $("#respuestaAjax_srm").html(respuesta1.message);
                     $("#respuestaAjax_srm").show(); // Muestra el mensaje

                  // Obtener los parámetros actuales de la URL
                            setTimeout(function () {
                        $("#respuestaAjax_srm").hide(); //
                            }, 5000); // 3 segundos
                }
            },
            error: function() {
                console.log("Error al enviar los datos.");
            }
        });
    }
};