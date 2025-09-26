class NotificaionUsuario {
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
        this.idcontribuyentep=null;
        this.valorTotalMo=null;


  }

    reniciar_valor(){
    this.totalImporte=0;
    this.totalGasto=0;
    this.totalSubtotal=0;
    this.totalTIM=0;
    this.totalTotal=0;
   
    $("#segundaTabla_agua_r tbody th:eq(1)").text("");
    $("#segundaTabla_agua_r tbody th:eq(2)").text("");
    $("#segundaTabla_agua_r tbody th:eq(3)").text("");
    $("#segundaTabla_agua_r tbody th:eq(4)").text("");
    $("#segundaTabla_agua_r tbody th:eq(5)").text("");
  }

  

    reniciar_valors(){
    this.totalImporte=0;
    this.totalGasto=0;
    this.totalSubtotal=0;
    this.totalTIM=0;
    this.totalTotal=0;
   
    $("#segundaTabla_agua_rs tbody th:eq(1)").text("");
    $("#segundaTabla_agua_rs tbody th:eq(2)").text("");
    $("#segundaTabla_agua_rs tbody th:eq(3)").text("");
    $("#segundaTabla_agua_rs tbody th:eq(4)").text("");
    $("#segundaTabla_agua_rs tbody th:eq(5)").text("");
  }

   reniciar_valor_ver(){
    this.totalImporte=0;
    this.totalGasto=0;
    this.totalSubtotal=0;
    this.totalTIM=0;
    this.totalTotal=0;
   
    $("#segundaTabla_agua_rn tbody th:eq(1)").text("");
    $("#segundaTabla_agua_rn tbody th:eq(2)").text("");
    $("#segundaTabla_agua_rn tbody th:eq(3)").text("");
    $("#segundaTabla_agua_rn tbody th:eq(4)").text("");
    $("#segundaTabla_agua_rn tbody th:eq(5)").text("");
  }


  
  manejarClicFilaR(fila) {
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
    $("#segundaTabla_agua_r tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(4)").text(this.totalDes.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(5)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados:", this.idsSeleccionados);
  } 

  
  //VER AGUA
    
manejarClicFila_agua_rn(fila) {
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
        //TOTAL GROBAL
        
     //   this.totalCuotas = this.totalTotal.toFixed(2); 

           // Captura el valor de totalCuotas
        notificacionUsuario.totalCuotas = notificacionUsuario.totalTotal.toFixed(2); 
    }
    // Actualización de las celdas de la segunda tabla
    $("#segundaTabla_agua_r tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(5)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados _AGUA :", this.idsSeleccionados);
}
  
  
//VER AGUA

manejarClicFila_agua_rn(fila) {
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
        //TOTAL GROBAL
        
     //   this.totalCuotas = this.totalTotal.toFixed(2); 

           // Captura el valor de totalCuotas
        notificacionUsuario.totalCuotas = notificacionUsuario.totalTotal.toFixed(2); 
    }
    // Actualización de las celdas de la segunda tabla
    $("#segundaTabla_agua_rn tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_rn tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_rn tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_rn tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_rn tbody th:eq(5)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados _AGUA :", this.idsSeleccionados);
}
  
  //VER AGUA
  manejarClicSRN(thS) {
    const filas = $("#primeratabla_agua_rn tbody tr");
    const todasSeleccionadas = $("td:eq(9):contains('1')", filas).length === filas.length;
    if (todasSeleccionadas) {
      // Todas las filas están seleccionadas, deseleccionar todas
      filas.each((index, fila) => {
        this.manejarClicFilaR($(fila));
      });
    } else {
      // Al menos una fila ya está seleccionada, completar las faltantes
      filas.each((index, fila) => {
        if ($("td:eq(9)", fila).text() !== "1") {
          this.manejarClicFilaR($(fila));
        }
      });
    }
    thS.text(todasSeleccionadas ? "S" : "S");
    // Actualizar los totales en la segunda tabla
    $("#segundaTabla_agua_rn tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_rn tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_rn tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_rn tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_rn tbody th:eq(5)").text(this.totalTotal.toFixed(2));
  }
  //editar notificacion



  
manejarClicFila_agua_r(fila) {
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
        //TOTAL GROBAL
        
     //   this.totalCuotas = this.totalTotal.toFixed(2); 

           // Captura el valor de totalCuotas
        notificacionUsuario.totalCuotas = notificacionUsuario.totalTotal.toFixed(2); 
    }
    // Actualización de las celdas de la segunda tabla
    $("#segundaTabla_agua_r tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(5)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados _AGUA :", this.idsSeleccionados);
}
  
  
  manejarClicSR(thS) {
    const filas = $("#primeratabla_agua_r tbody tr");
    const todasSeleccionadas = $("td:eq(9):contains('1')", filas).length === filas.length;
    if (todasSeleccionadas) {
      // Todas las filas están seleccionadas, deseleccionar todas
      filas.each((index, fila) => {
        this.manejarClicFilaR($(fila));
      });
    } else {
      // Al menos una fila ya está seleccionada, completar las faltantes
      filas.each((index, fila) => {
        if ($("td:eq(9)", fila).text() !== "1") {
          this.manejarClicFilaR($(fila));
        }
      });
    }
    thS.text(todasSeleccionadas ? "S" : "S");
    // Actualizar los totales en la segunda tabla
    $("#segundaTabla_agua_r tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_r tbody th:eq(5)").text(this.totalTotal.toFixed(2));
  }
  //editar notificacion


  //PATRA SEGUNDA CUOTA
  
  
  manejarClicFilaRS(fila) {
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
    $("#segundaTabla_agua_rs tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(4)").text(this.totalDes.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(5)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados:", this.idsSeleccionados);
  } 

  

  // PARA LA SEGUNDA CUOTA
manejarClicFila_agua_rs(fila) {
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
        //TOTAL GROBAL
        
     //   this.totalCuotas = this.totalTotal.toFixed(2); 

           // Captura el valor de totalCuotas
        notificacionUsuario.totalCuotas = notificacionUsuario.totalTotal.toFixed(2); 
    }
    // Actualización de las celdas de la segunda tabla
    $("#segundaTabla_agua_rs tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(5)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados _AGUA OTRO :", this.idsSeleccionados);
}
  
  // PARA LA SEGUNDA CUOTA
  manejarClicSRS(thS) {
    const filas = $("#primeratabla_agua_rs tbody tr");
    const todasSeleccionadas = $("td:eq(9):contains('1')", filas).length === filas.length;
    if (todasSeleccionadas) {
      // Todas las filas están seleccionadas, deseleccionar todas
      filas.each((index, fila) => {
        this.manejarClicFilaRS($(fila));
      });
    } else {
      // Al menos una fila ya está seleccionada, completar las faltantes
      filas.each((index, fila) => {
        if ($("td:eq(9)", fila).text() !== "1") {
          this.manejarClicFilaRS($(fila));
        }
      });
    }
    thS.text(todasSeleccionadas ? "S" : "S");
    // Actualizar los totales en la segunda tabla
    $("#segundaTabla_agua_rs tbody th:eq(1)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(2)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(3)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(4)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_rs tbody th:eq(5)").text(this.totalTotal.toFixed(2));
  }


imprimirAgua() {
    // Obtener todos los checkboxes seleccionados
    let checkboxes = document.querySelectorAll('.checkbox-notificacion:checked');

    // Crear un array para almacenar los datos capturados
    let datosCapturados = [];
    let filtroFecha = document.getElementById('fecha_notificacion').value;
    let filtroEstado = document.getElementById('filtrar_estado').value;

    // Si hay checkboxes seleccionados, filtrar solo esas filas
    if (checkboxes.length > 0) {
        checkboxes.forEach(chk => {
            let fila = chk.closest('tr');
            let celdas = fila.querySelectorAll('td');
            let filaDatos = [];

            // Capturar los datos deseados
            if (celdas.length > 0) filaDatos.push(celdas[0].innerText); // td1
            if (celdas.length > 2) filaDatos.push(celdas[2].innerText); // td3 (Nombre)
            if (celdas.length > 3) filaDatos.push(celdas[3].innerText); // td4 (Número notificación)
            if (celdas.length > 4) filaDatos.push(celdas[4].innerText); // td5 (Dirección)
            if (celdas.length > 5) filaDatos.push(celdas[celdas.length - 1].innerText); // Última celda (acciones o estado)

            datosCapturados.push(filaDatos);
        });
    } else {
        // Si no hay checkboxes marcados, recorrer todas las filas
        let filas = document.querySelectorAll('#lista_de_notificacion tr');

        filas.forEach(fila => {
            let celdas = fila.querySelectorAll('td');
            let filaDatos = [];

            if (celdas.length > 0) filaDatos.push(celdas[0].innerText); // td1
            if (celdas.length > 2) filaDatos.push(celdas[2].innerText); // td3
            if (celdas.length > 3) filaDatos.push(celdas[3].innerText); // td4
            if (celdas.length > 4) filaDatos.push(celdas[4].innerText); // td4
            if (celdas.length > 5) filaDatos.push(celdas[celdas.length - 1].innerText); // Último td

            datosCapturados.push(filaDatos);
        });
    }

    // Confirmación (opcional)
    console.log("Fecha de notificación seleccionada:", filtroFecha);
    console.log("Estado seleccionado:", filtroEstado);
    console.log("Datos capturados:", datosCapturados);

    // Enviar los datos al servidor
    $.ajax({
        url: "./vistas/print/imprimirNotificacionAgua.php",
        method: "POST",
        data: {
            tabla_datos: JSON.stringify(datosCapturados),
            fecha_notificacion: filtroFecha,
            estado: filtroEstado
        },
        success: function (rutaArchivo) {
            document.getElementById("iframeA").src = 'vistas/print/' + rutaArchivo;
        },
        error: function (error) {
            console.log('Error en la llamada AJAX:', error);
        }
    });
}


  // Función para listar notificaciones



  lista_notificacion(filtro_nombre = '', filtro_fecha = '', filtro_fecha_mc = '', filtro_estado = 'todos', pagina = 1,resultados_por_pagina='15') {
    let datos = new FormData();
    datos.append("lista_notificacion", "lista_notificacion");
    datos.append("filtro_nombre", filtro_nombre);  // Agregar filtro de nombre
    datos.append("filtro_fecha", filtro_fecha);    // Agregar filtro de fecha
    datos.append("filtro_fecha_mc", filtro_fecha_mc);    // Agregar filtro de fecha
    datos.append("filtro_estado", filtro_estado);  // Agregar filtro de estado
     datos.append("pagina", pagina);   
    datos.append("resultados_por_pagina", resultados_por_pagina);                // Agregar página actual
    $.ajax({
        url: "ajax/notificacionagua.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {

         
          let data;
          try {
              data = JSON.parse(respuesta);
          } catch (e) {
              console.log("No se pudo parsear la respuesta:", e);
              return;
          }

          document.getElementById('lista_de_notificacion').innerHTML = data.data;
          document.getElementById('pagination').innerHTML = data.pagination;  
          
          }
    });



}



  
  guardar_notificacion_editado_n(){
         
     // Crear un objeto FormData a partir del formulario
    let formd = new FormData($("form.form-inserta-editar_n")[0]);
    
    // Agregar el campo adicional al FormData
    formd.append("guardar_datos_editar", "guardar_datos_editar");

    // Mostrar todos los datos de FormData en la consola para depuración
    for (let entry of formd.entries()) {
        console.log(entry[0] + ': ' + entry[1]);  // Imprime cada clave y valor
    }

   
        $.ajax({
          type: "POST",
          url: "ajax/notificacionagua.ajax.php",
          data: formd,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            
            console.log("Respuesta del servidor para guardar y mostrar notiifcaion:", respuesta); // Verifica la respuesta del servidor


          if (respuesta.tipo === "correcto") { // Si la respuesta es exitosa
            $("#modalEditarUsuario").modal("hide");  // Cierra el modal de edición
            $("#respuestaAjax_srm").show();  // Muestra el área de respuesta
            $("#respuestaAjax_srm").html(respuesta.mensaje);  // Muestra el mensaje de éxito en el área de respuesta
          
            notificacionUsuario.lista_notificacion('');

            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de respuesta después de 5 segundos
            }, 5000);

             $("#modalEditarNotificacion").modal("hide");


          }
          else {
            $("#respuestaAjax_srm").show();  // Si hay error, muestra el mensaje de error
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de error después de 4 segundos
            }, 4000);
          }
          },
        });
  }

  
  //VERA AGUA
  MostrarEstadoCuentaAguaReconexcionn(idlicencia){
    let self=this;

 

    $.ajax({
      type: "POST",
      url: "ajax/notificacionagua.ajax.php",
      data: {
        idlicenciaagua_estadocuenta: idlicencia,
      },
      success: function (respuesta) {

       console.log("Respuesta del servidor para mostrar estado de cuenta:", respuesta); // Verifica la respuesta del servidor

        $("#listaLicenciasAgua_estadocuenta_rn").html(respuesta);


        
           // Función para manejar el clic en las filas de la tabla y sumar los valores
            $("#primeratabla_agua_rn tbody tr").on("click", function () {
              self.manejarClicFila_agua_rn($(this));
            });
            // Función para manejar el clic en el encabezado "S"
            $("#primeratabla_agua_rn thead th:eq(9)").on("click", function () {
              self.manejarClicSRN($(this));
            });

      },
    });

  }

  MostrarEstadoCuentaAguaReconexcion(idlicencia){
    let self=this;

    console.log("ID de licencia para mostrar estado de cuenta:", self); // Verifica que el ID se está capturando correctamente
  

    $.ajax({
    type: "POST",
    url: "ajax/notificacionagua.ajax.php",
    data: {
        idlicenciaagua_estadocuenta: idlicencia,
    },
    success: function (respuesta) {

        console.log("Respuesta del servidor para mostrar estado de cuenta:", respuesta);

        $("#listaLicenciasAgua_estadocuenta_r").html(respuesta);

        // Usamos 'reduce' para acumular los valores de la columna Total_Aplicar
              var totalAplicar = $("#primeratabla_agua_r tbody tr").toArray().reduce(function(total, tr) {
              var $fila = $(tr);
              if ($("td", $fila).length >= 9) {
                  var valorPenultimoTd = $("td:eq(-2)", $fila).text().trim();
                  if (valorPenultimoTd !== "" && valorPenultimoTd !== "0.00") {
                      valorPenultimoTd = parseFloat(valorPenultimoTd.replace(/[^\d.-]/g, ''));
                      if (!isNaN(valorPenultimoTd)) {
                          return total + valorPenultimoTd;
                      }
                  }
              }
              return total;
          }, 0);

        // Actualizar el campo #totalPagado con la suma total de los valores
        $("#totalPagado").val('');
        $("#totalPagado").val(totalAplicar.toFixed(2));  // Muestra el valor con dos decimales

        console.log("valor de total a aplicar-------", totalAplicar);

        // Función para manejar el clic en las filas de la tabla y sumar los valores
        $("#primeratabla_agua_r tbody tr").on("click", function () {
            self.manejarClicFila_agua_r($(this));
        });

        // Función para manejar el clic en el encabezado "S"
        $("#primeratabla_agua_r thead th:eq(9)").on("click", function () {
            self.manejarClicSR($(this));
        });

    },
});


   


    // $.ajax({
    //   type: "POST",
    //   url: "ajax/notificacionagua.ajax.php",
    //   data: {
    //     idlicenciaagua_estadocuenta: idlicencia,
    //   },
    //   success: function (respuesta) {

    //    console.log("Respuesta del servidor para mostrar estado de cuenta:", respuesta); // Verifica la respuesta del servidor

    //     $("#listaLicenciasAgua_estadocuenta_r").html(respuesta);


              
    //       // Variable para almacenar la suma total
    //       var totalAplicarr = 0;
          

    //        $("tr").each(function() {
    //             var $fila = $(this);

    //             // Asegurarse de que la fila tiene al menos 9 <td> (para tener un penúltimo td)
    //             if ($("td", $fila).length >= 9) {
    //                 // Obtener el valor del penúltimo <td> (columna 9, índice -2)
    //                 var valorPenultimoTd = $("td:eq(-2)", $fila).text().trim();

    //                 // Verificar si el penúltimo <td> no está vacío
    //                 if (valorPenultimoTd !== "" && valorPenultimoTd !== "0.00") {  // Asegurar que no sea 0.00
    //                     // Limpiar caracteres no deseados (espacios, comas, etc.) y convertir a número
    //                     valorPenultimoTd = parseFloat(valorPenultimoTd.replace(/[^\d.-]/g, ''));

    //                     // Verificar si el valor es numérico y sumarlo
    //                     if (!isNaN(valorPenultimoTd)) {
    //                         totalAplicarr += valorPenultimoTd; // Sumar el valor de la penúltima columna
    //                     } else {
    //                         // Si no es un número válido, imprimir mensaje de error o depuración
    //                         console.log("Valor no válido en la fila:", $fila);
    //                     }
    //                 }
    //             }
    //         });

    //         $("#totalPagado").val('');
    //         $("#totalPagado").val(totalAplicarr); // Mostrar solo la fecha en el span



    //         console.log("valor de total a aplicar-------", totalAplicarr);
        
    //        // Función para manejar el clic en las filas de la tabla y sumar los valores
    //         $("#primeratabla_agua_r tbody tr").on("click", function () {
    //           self.manejarClicFila_agua_r($(this));
    //         });
    //         // Función para manejar el clic en el encabezado "S"
    //         $("#primeratabla_agua_r thead th:eq(9)").on("click", function () {
    //           self.manejarClicSR($(this));
    //         });

    //   },
    // });

  }


   //LISTA PARA RECONEXION DE AGUA SEGUNDA CUOTA
  MostrarEstadoCuentaAguaReconexcions(idlicencia){

     let self=this;

    console.log("ID de licencia para mostrar estado de cuenta:", self); // Verifica que el ID se está capturando correctamente
  console.log("llego aqui", idlicencia);

    $.ajax({
      type: "POST",
      url: "ajax/notificacionagua.ajax.php",
      data: {
        idlicenciaagua_estadocuenta: idlicencia,
      },
      success: function (respuesta) {

       console.log("Respuesta del servidor para mostrar estado de cuenta:", respuesta); // Verifica la respuesta del servidor

        $("#listaLicenciasAgua_estadocuenta_rs").html(respuesta);

      //  console.log(respuesta);

        // Variable para almacenar la suma total
            var totalAplicar = 0;

            // Seleccionar todas las filas de la tabla y sumar los valores del penúltimo <td>
            // $("tr").each(function() {
            //     var $fila = $(this);

            //     // Asegurarse de que la fila tiene al menos 9 <td> (para tener un penúltimo td)
            //     if ($("td", $fila).length >= 9) {
            //         // Obtener el valor del penúltimo <td> (columna 9, índice -2)
            //         var valorPenultimoTd = $("td:eq(-2)", $fila).text().trim();

            //         // Verificar si el penúltimo <td> no está vacío
            //         if (valorPenultimoTd !== "" && valorPenultimoTd !== "0.00") {  // Asegurar que no sea 0.00
            //             // Limpiar caracteres no deseados (espacios, comas, etc.) y convertir a número
            //             valorPenultimoTd = parseFloat(valorPenultimoTd.replace(/[^\d.-]/g, ''));

            //             // Verificar si el valor es numérico y sumarlo
            //             if (!isNaN(valorPenultimoTd)) {
            //                 totalAplicar += valorPenultimoTd; // Sumar el valor de la penúltima columna
            //             } else {
            //                 // Si no es un número válido, imprimir mensaje de error o depuración
            //                 console.log("Valor no válido en la fila:", $fila);
            //             }
            //         }
            //     }
            // });


                          
            
            // Usamos setTimeout para asegurarnos de que el DOM se haya actualizado antes de calcular el total
            setTimeout(function () {
                // Variable para almacenar la suma total
                var totalAplicar = 0;

                // Sumar los valores de los <span> con id="montoCuot"
                $("span#montoCuot").each(function() {
                    var valorCuota = $(this).text().trim();  // Obtener el texto dentro del span

                    // Asegurarse de que el valor no esté vacío o sea "0.00"
                    if (valorCuota !== "" && valorCuota !== "0.00") {
                        // Limpiar caracteres no deseados y convertir a número
                        valorCuota = parseFloat(valorCuota.replace(/[^\d.-]/g, ''));

                        // Verificar si el valor es numérico y sumarlo
                        if (!isNaN(valorCuota)) {
                            totalAplicar += valorCuota;  // Sumar el valor
                        } else {
                            console.log("Valor no válido en el span:", $(this));  // Si no es un número válido
                        }
                    }
                });

                // Mostrar el total con 2 decimales
                $("#totalPagadoSe").val(totalAplicar.toFixed(2));
            }, 500);  // El tiempo en milisegundos (ajustable si es necesario)
            
           // $("#totalPagadoSe").val(totalAplicar); // Mostrar la suma total


                    // Función para manejar el clic en las filas de la tabla y sumar los valores
            $("#primeratabla_agua_rs tbody tr").on("click", function () {
              self.manejarClicFila_agua_rs($(this));
            });
            // Función para manejar el clic en el encabezado "S"
            $("#primeratabla_agua_rs thead th:eq(9)").on("click", function () {
              self.manejarClicSRS($(this));
            });

      },
    });

  }




  //MOSTRRA CUOTAS V2
  

   // Método para mostrar las cuotas a pagar
  MostrarCuotasPagarV(cuotas) {

    var valorPrimeraCuota = notificacionUsuario.totalCuotas;  // Acceder al valor totalCuotas
    
    let valorTotal=parseFloat($('#totalPagado').val());
    var valorSegundaCuota=valorTotal-valorPrimeraCuota;

    var estadoPrimeraReconexion='R1';
    var estadoSegundaReconexion='R';


    let cuotasHTML = '';


   // let fechaVencimiento = '2025-07-20';  // Fecha de vencimiento inicial (ajustar según necesidad)

  let now = new Date();
  let localDate = new Date(now.getTime() - now.getTimezoneOffset() * 60000); // Ajusta la fecha a la zona horaria local
  let fechaVencimiento = localDate.toISOString().split('T')[0];  // Devulve la fecha actual en formato 'YYYY-MM-DD'


    for (let i = 1; i <= cuotas; i++) {
         let valorCuota = i === 2 ? valorSegundaCuota : valorPrimeraCuota;  // Si es la segunda cuota, usamos valorSegundaCuota
        let valorReconecion = i === 2 ? estadoSegundaReconexion : estadoPrimeraReconexion;  // Si es la segunda cuota, usamos valorSegundaCuota


        cuotasHTML += `
            <div class="row">
                <div class="col-md-2">
                    <label for="estadoN" class="col-form-label" >Cuota ${i}: </label>
                  S/. <span id="montoCuota${i}" name="montoCuota${i}">${this.number_format(valorCuota, 2)}</span>
                </div>

                <div class="col-md-3">
                    <label for="estadoN" class="col-form-label">Fecha ven.: </label>
                    <span id="fechaVenCuota${i}" name="fechaVenCuota${i}" >${this.formatDate(fechaVencimiento)}</span>
                </div>

                <div class="col-md-3 cuotas" style="display: none;">
                    <label for="numeroProveidoP" class="col-form-label">Nro proveído: </label>
                    <input type="text" style="width: 60px;" id="numeroProveidoCuota${i}" name="numeroProveidoCuota${i}">
                </div>
                
                <div class="col-md-4 cuotas" style="display: none;">
                    <label for="estadoNP" class="col-md-7 col-form-label">Reconexión de agua</label>
                    <div class="col-md-5">
                        <select class="form-control" id="estadoNP${i}" name="estadoNP${i}" >
                            <option value=" ">Seleccionar</option>
                           ${valorReconecion === "R" ? 
                            `<option value="R" selected>Reconectar</option>` : 
                            `<option value="R1" selected>Reconectar</option>`}
                      
                           </select>
                    </div>
                </div>
            </div>
        `;
        fechaVencimiento = this.dateAddMonth(fechaVencimiento, 2); // Sumamos un mes
    }

    // Insertamos el HTML generado en el div adecuado
    $('#cuotasPago').html(cuotasHTML);

    // Mostrar el div con id="cuotasPago" y asegurarnos de que las cuotas también estén visibles
   // $('#cuotasPago').show();
    $('.cuotas').show(); // Muestra las cuotas (si están ocultas)
  }

  // Función para formatear número como moneda
  number_format(number, decimals) {
    return number.toLocaleString('es-PE', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
  }

  // Función para formatear fecha
 // Función para formatear la fecha
formatDate(dateStr) {
  let date = new Date(dateStr + "T00:00:00"); // Fuerza que la fecha tenga la hora en 00:00:00 para evitar problemas con UTC
  return `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${date.getFullYear()}`;
}


  // Función para sumar un mes a una fecha
  dateAddMonth(dateStr, months) {
    let date = new Date(dateStr);
    date.setMonth(date.getMonth() + months);
    return date.toISOString().split('T')[0];  // Devuelve la fecha en formato YYYY-MM-DD
  }


  
  MostrarCuotasPagar(cuotas,idLicencia){

    let self=this;

      if (cuotas === 0) {
        return; // No hacer la consulta ni mostrar cuotas
    } 

    console.log("ID de licencia para mostrar estado de cuenta:", self); // Verifica que el ID se está capturando correctamente
  
     let formd = new FormData();
    
    // Agregar el campo adicional al FormData
    formd.append("idLicencia", idLicencia);
    formd.append("cuotas", cuotas);
    formd.append("mostrar_cuotas", "mostrar_cuotas");




    $.ajax({
      type: "POST",
      url: "ajax/notificacionagua.ajax.php",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
       // console.log("Respuesta del servidor para mostrar estado de cuenta:", respuesta); // Verifica la respuesta del servidor

       console.log(respuesta);
      // Verifica si la respuesta es correcta
        if (respuesta.tipo == "correcto") {
            // Reemplazamos el contenido de #cuotasPago con el HTML de las cuotas
            $("#cuotasPago").html(respuesta.cuotasHTML);  
            
            // Opcional: Mostrar la sección de cuotas si es necesario
            $('.cuotas').show();  
        } 

      },
    });

  }

  //notificacionUsuario.MostrarCuotasPagarSegundaCuota(idLicencia,idNotificionAgua); // Llamar a la función para mostrar el estado de cuenta

   
  MostrarCuotasPagarSegundaCuota(idLicencia,idNotificionAgua){

   
   
     let formd = new FormData();
    
    // Agregar el campo adicional al FormData
    formd.append("idLicencia", idLicencia);
    formd.append("idNotificionAgua", idNotificionAgua);
    formd.append("mostrar_cuotas_segundo", "mostrar_cuotas_segundo");

   

    $.ajax({
      type: "POST",
      url: "ajax/notificacionagua.ajax.php",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
       // console.log("Respuesta del servidor para mostrar estado de cuenta:", respuesta); // Verifica la respuesta del servidor

       console.log(respuesta);
    
      $("#mostrar_segunda_cuota").html(respuesta);  
           
            
        
        

      },
    });

  }

  //IMPRIMIR NOTIFICADO
  

  imprimirhere_aguar() {
    console.log("llego hasta aqui");

    const idsSeleccionados_ = this.idsSeleccionados.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });

   

    let datos = new FormData();
    datos.append("idlicencia",this.idlicenciaagua);
     datos.append("propietarios",this.idcontribuyente);
    datos.append("id_cuenta",idsSeleccionados_);
    datos.append("totalImporte",this.totalImporte.toFixed(2));
    datos.append("totalGasto",this.totalGasto.toFixed(2));
    datos.append("totalSubtotal",this.totalSubtotal.toFixed(2));
    datos.append("totalTIM",this.totalTIM.toFixed(2));
    datos.append("totalTotal",this.totalTotal.toFixed(2));

    // Imprimir todos los datos de FormData
    for (let pair of datos.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    $.ajax({
      url: "./vistas/print/imprimirEstadoCuentaAgua.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (rutaArchivo) {
        // Establecer el src del iframe con la ruta relativa del PDF
        document.getElementById("iframe_aguano").src = 'vistas/print/' + rutaArchivo;
      }
    });
  }



  //PARA SEGUND CUOTA
  
  imprimirhere_aguas() {
    console.log("llego hasta aqui");

    const idsSeleccionados_ = this.idsSeleccionados.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });

    let datos = new FormData();
    datos.append("idlicencia",this.idlicenciaaguap);
     datos.append("propietarios",this.idcontribuyentep);
    datos.append("id_cuenta",idsSeleccionados_);
    datos.append("totalImporte",this.totalImporte.toFixed(2));
    datos.append("totalGasto",this.totalGasto.toFixed(2));
    datos.append("totalSubtotal",this.totalSubtotal.toFixed(2));
    datos.append("totalTIM",this.totalTIM.toFixed(2));
    datos.append("totalTotal",this.totalTotal.toFixed(2));

    // Imprimir todos los datos de FormData
    for (let pair of datos.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    $.ajax({
      url: "./vistas/print/imprimirEstadoCuentaAgua.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (rutaArchivo) {
        // Establecer el src del iframe con la ruta relativa del PDF
        document.getElementById("iframe_aguas").src = 'vistas/print/' + rutaArchivo;
      }
    });
  }

  
  //NOTIFICACION
  
  imprimirhere_agua_n_volver() {
    // const Propietarios_ = []; // Declarar un arreglo vacío

    // $("#id_propietarios tr").each(function (index){
    //   // Accede al valor del atributo 'id' de cada fila
      



    //   Propietarios_[index] = idFila; // Agregar el valor al arreglo
    // });

    // const Propietarios = Propietarios_.map(function(valor) {
    //   return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    // });


    var Propietarios = $('#inputidcontribuyente').val();


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

   datos.forEach((value, key) => {
     console.log(key + ": " + value);
    });



    $.ajax({
      url: "./vistas/print/imprimirEstadoCuentaAguaV.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (rutaArchivo) {
        // Establecer el src del iframe con la ruta relativa del PDF
        document.getElementById("iframe_agua_volver").src = 'vistas/print/' + rutaArchivo;
      }
    });



  }




}

// Crear instancia de la clase
const notificacionUsuario = new NotificaionUsuario();



// EDITTAR NOTIFICACION
$(document).on("click", ".btnEditarNotificacion", function () {
  var idNotificacion = $(this).data("idnotificaciona");  // Usar .data() en lugar de .attr()
    console.log(idNotificacion); // Verifica que el ID se está capturando cor

  var datos = new FormData();
  datos.append("idNotificacion_selet", idNotificacion);
  datos.append("idNotificacion_seleccionado", "idNotificacion_seleccionado");


  $.ajax({
    url: "ajax/notificacionagua.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {

        console.log("llegó aquí...", respuesta); // Verifica la respuesta del servidor
        let data;
        try {
             data = JSON.parse(respuesta);
         } catch (e) {
                console.log("No se pudo parsear la respuesta:", e);
                return;
            }

        // Verifica si la respuesta es un array y tiene elementos
        if (Array.isArray(data) && data.length > 0) {
            var notificacion = data[0];  // Accede al primer objeto del array

            console.log("Objeto de notificación:", notificacion); // Verifica la estructura completa del objeto

            // Verifica si la propiedad 'estado' existe
            if (notificacion.hasOwnProperty("estado")) {
                var estado = notificacion["estado"];
                console.log("Estado recibido:", estado); // Verifica que se está recibiendo el valor correcto
                $("#estadoN").val(estado); // Establece el valor del select

                 // Si el estado es 'S', mostrar el textarea y su label
                if (estado == 'S') {
                    $('#observacionRow').show();  // Muestra la fila del textarea
                } else {
                    $('#observacionRow').hide();  // Oculta la fila del textarea si no es 'S'
                }


            } else {
                console.log("La propiedad 'estado' no existe en el objeto.");
            }

               // Verifica si la propiedad 'fecha_corte' existe antes de intentar mostrarla
                if (notificacion.hasOwnProperty("Fecha_Registro")) {
                var fechaRegistro = notificacion["Fecha_Registro"];
                console.log("Fecha de registro completa:", fechaRegistro); // Verifica que la fecha completa esté presente
                
                // Crear un objeto Date a partir de la fecha
                var fecha = new Date(fechaRegistro);
                
                // Obtener solo la parte de la fecha en formato 'yyyy-mm-dd'
                var soloFecha = fecha.toISOString().split("T")[0];
                console.log("Fecha extraída:", soloFecha); // Verifica la fecha sin la hora
                
                // Mostrar solo la fecha en el span
                $("#editarFechaRegistro").text(soloFecha); // Mostrar solo la fecha en el span
            } else {
                console.log("La propiedad 'Fecha_Registro' no existe en el objeto.");
            }

            //ID NOTIFDICACION DE AGUA
                // Verifica si la propiedad 'fecha_corte' existe antes de intentar mostrarla
                if (notificacion.hasOwnProperty("Id_Notificacion_Agua")) {
                var idNotificaionAgua = notificacion["Id_Notificacion_Agua"];
                console.log("Fecha de registro completa:", idNotificaionAgua); // Verifica que la fecha completa esté presente
                
               
                // Mostrar solo la fecha en el span
                $("#idNotificacionA").val(idNotificaionAgua); // Mostrar solo la fecha en el span
            } else {
                console.log("La propiedad 'Id_Notificacion_Agua' no existe en el objeto.");
            }



            // Verifica si la propiedad 'fecha_corte' existe antes de intentar mostrarla
            if (notificacion.hasOwnProperty("fecha_corte")) {
                var fechaCorte = notificacion["fecha_corte"];
                console.log("Fecha de corte recibida:", fechaCorte); // Verifica que la fecha de corte esté presente
                $("#editarFechaCorte").text(fechaCorte); // Mostrar la fecha de corte en el span
            } else {
                console.log("La propiedad 'fecha_corte' no existe en el objeto.");
            }

             // Verifica obsrvaciob
            if (notificacion.hasOwnProperty("observacion")) {
                var observacion = notificacion["observacion"];
                console.log("Fecha de corte recibida:", observacion); // Verifica que la fecha de corte esté presente
                $("#observacionN").text(observacion); // Mostrar la fecha de corte en el span
            } else {
                console.log("La propiedad 'observacion' no existe en el objeto.");
            }


            // Mostrar el modal después de que los campos se hayan actualizado
            $("#modalEditarNotificacion").modal("show");

        } else {
            console.log("La respuesta está vacía o no tiene elementos.");
        }
    },
});

});


$(document).ready(function() {
    // Al cambiar el valor del select, muestra u oculta el textarea y su label
    $('#estadoN').change(function() {
        var estadoSeleccionado = $(this).val();

        if (estadoSeleccionado == 'S') {
            // Muestra el textarea y su label cuando se selecciona "Sin Servicio"
            $('#observacionRow').show();
        } else {
            // Oculta el textarea y su label cuando se selecciona otro estado
            $('#observacionRow').hide();
        }
    });
});



// Al cargar la página, mostrar todas las notificaciones
// Al cargar la página, mostrar todas las notificaciones
// Al cargar la página, mostrar todas las notificaciones
document.addEventListener('DOMContentLoaded', function () {
  
   notificacionUsuario.lista_notificacion('', '', '', 'todos', 1);  // Mostrar página 1 por defecto
    
    // Detectar cambios en los campos de filtro (nombre, fecha, estado)
    const nombreField = document.querySelector('#filtrar_nombre');
    const fechaField = document.querySelector('#fecha_notificacion');
    const fecha_mecerrado = document.querySelector('#fecha_mecerrado');
    const estadoField = document.querySelector('#filtrar_estado'); // Campo de estado
     const resultados_por_pagina = document.querySelector('#resultados_por_pagina'); // Campo de estado

    // Detectar cambios en el campo de texto para filtrar por nombre
    nombreField.addEventListener('input', function () {
        const nombre = nombreField.value;
        const fecha = fechaField.value; // Capturar la fecha seleccionada
        const estado = estadoField.value; // Capturar el estado seleccionado
        const fechamc = fecha_mecerrado.value;
        notificacionUsuario.lista_notificacion(nombre, fecha,fechamc, estado, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });

    // Detectar cambios en el campo de fecha para filtrar por fecha
    fechaField.addEventListener('change', function () {
        const fecha = fechaField.value;
        const nombre = nombreField.value;
        const estado = estadoField.value;
        const fechamc = fecha_mecerrado.value;
        notificacionUsuario.lista_notificacion(nombre, fecha, fechamc, estado, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });
     // Detectar cambios en el campo de fecha para filtrar por medidor cerrado
    fecha_mecerrado.addEventListener('change', function () {
        const fecha = fechaField.value;
        const fechamc = fecha_mecerrado.value;
        const nombre = nombreField.value;
        const estado = estadoField.value;
        notificacionUsuario.lista_notificacion(nombre, fecha, fechamc, estado, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });


    // Detectar cambios en el campo de estado para filtrar por estado
    estadoField.addEventListener('change', function () {
        const estado = estadoField.value;
        const nombre = nombreField.value;
        const fecha = fechaField.value;
        const fechamc = fecha_mecerrado.value;
        notificacionUsuario.lista_notificacion(nombre, fecha,fechamc, estado, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });

     // Detectar cambios en el campo de estado para filtrar por estado
    resultados_por_pagina.addEventListener('change', function () {
        const estado = estadoField.value;
        const nombre = nombreField.value;
        const fecha = fechaField.value;
        const fechamc = fecha_mecerrado.value;
        notificacionUsuario.lista_notificacion(nombre, fecha,fechamc, estado, 1,resultados_por_pagina.value);  // Resetear a la página 1
    });


});




$(".form-inserta-editar_n").submit(function (e) {
    e.preventDefault();
    notificacionUsuario.guardar_notificacion_editado_n();
});




// Confirmar eliminación cuando el usuario hace clic en "Sí, Eliminar"

$(document).on("click", ".btnAbrirNotificacion", function () {
    // Obtener el ID de la notificación desde el atributo data-idnotificacion
    var idNotificacion = $(this).data("idnotificacion");  // Usar .data() en lugar de .attr()
    console.log(idNotificacion); // Verifica que el ID se está capturando correctamente

    // Asignar el valor del ID de la notificación al input oculto
    $("#idNotificacionEliminar").val(idNotificacion);
});






//RECONOCECTAT AGUA

$(document).on("click", ".btnReconectarAgua", function () {

    notificacionUsuario.reniciar_valor();

    notificacionUsuario.idlicenciaagua=$(this).data("idlicenciar");
    notificacionUsuario.idcontribuyente=$(this).data("idcontribuyenter");

     
    // Obtener el ID de la notificación desde el atributo data-idnotificacion
    var idNotificionAgua = $(this).data("idnotificacionr");  // Usar .data() en lugar de .attr()
    console.log(idNotificionAgua); // Verifica que el ID se está capturando correctamente

     var idLicencia  = $(this).data("idlicenciar");  // Usar .data() en lugar de .attr()
    console.log(idLicencia); // Verifica que el ID se está capturando correctamente

     $("#inputLicencia").val(idLicencia);  // Mostrar el valor en el input


    notificacionUsuario.MostrarEstadoCuentaAguaReconexcion(idLicencia); // Llamar a la función para mostrar el estado de cuenta


    // Asignar el valor del ID de la notificación al input oculto
   // $("#idNotificacionEliminar").val(idNotificacion);


});


//VER NOTIFICACION AGUA

$(document).on("click", ".btnVerNotificacion", function () {

     notificacionUsuario.reniciar_valor_ver();

      notificacionUsuario.idlicenciaagua=$(this).data("idlicenciaver");
      notificacionUsuario.idcontribuyente=$(this).data("idcontribuyentever");

     
    // Obtener el ID de la notificación desde el atributo data-idnotificacion
    var idNotificionAgua = $(this).data("idnotificacionver");  // Usar .data() en lugar de .attr()
    console.log(idNotificionAgua); // Verifica que el ID se está capturando correctamente

     var idLicencia  = $(this).data("idlicenciaver");  // Usar .data() en lugar de .attr()
    console.log(idLicencia); // Verifica que el ID se está capturando correctamente

     $("#inputLicencia").val(idLicencia);  // Mostrar el valor en el input

     $("#inputidcontribuyente").val(notificacionUsuario.idcontribuyente);  // Mostrar el valor en el input


    notificacionUsuario.MostrarEstadoCuentaAguaReconexcionn(idLicencia); // Llamar a la función para mostrar el estado de cuenta


    // Asignar el valor del ID de la notificación al input oculto
   // $("#idNotificacionEliminar").val(idNotificacion);


});



//PAGO DE SEGUNDO CUOTA
$(document).on("click", ".btnReconectarAguaseCuota", function () {

  

     notificacionUsuario.reniciar_valors();

      notificacionUsuario.idlicenciaaguap=$(this).data("idlicenciarp");
      notificacionUsuario.idcontribuyentep=$(this).data("idcontribuyentep");

    // Obtener el ID de la notificación desde el atributo data-idnotificacion
    var idNotificionAgua = $(this).data("idnotificacionrp");  // Usar .data() en lugar de .attr()
    console.log(idNotificionAgua); // Verifica que el ID se está capturando correctamente

    $("#inputNotificacionSe").val(idNotificionAgua);  // Mostrar el valor en el input


     var idLicencia  = $(this).data("idlicenciarp");  // Usar .data() en lugar de .attr()
    console.log(idLicencia); // Verifica que el ID se está capturando correctamente

     $("#inputLicenciaSe").val(idLicencia);  // Mostrar el valor en el input

   
   notificacionUsuario.MostrarEstadoCuentaAguaReconexcions(idLicencia); // Llamar a la función para mostrar el estado de cuenta

   notificacionUsuario.MostrarCuotasPagarSegundaCuota(idLicencia,idNotificionAgua); // Llamar a la función para mostrar el estado de cuenta


    // Asignar el valor del ID de la notificación al input oculto
   // $("#idNotificacionEliminar").val(idNotificacion);


});


//BOTON GUARDAR RECONOEXION SEGUNDA CUOTA
$("#btnGuardarReconexionSegunda").on("click", function () {
   
      var todoPago = parseFloat($("#totalPagadoSe").val());  // Aseguramos que todoPago sea numérico
       var idLicencia = $("#inputLicenciaSe").val();
       var idNotificaionAgua = $("#inputNotificacionSe").val();

        // Seleccionar las filas de la tabla
        const filas = $("#primeratabla_agua_rs tbody tr");

        // Inicializar la variable para el total a aplicar
        var totalAplicar = 0;
        
        // Iterar sobre las filas de la tabla
        filas.each(function() {
            var $fila = $(this);

            // Verificar si la fila tiene la clase 'green-background' (indicando estado 'H')
            if ($fila.hasClass('green-background')) {
                console.log("Fila con fondo verde: ", $fila);
                
                // Obtener el valor de la columna Total_Aplicar (columna 9)
                var totalAplicarValor = parseFloat($("td:eq(8)", $fila).text().trim().replace(/[^\d.-]/g, '')); // Eliminar caracteres no deseados

                if (!isNaN(totalAplicarValor)) {
                    totalAplicar += totalAplicarValor; // Sumar el valor de Total_Aplicar
                } else {
                    console.log("Valor no válido en la fila:", $fila);
                }
            }
        });

       

        // Verificar si el total a aplicar coincide con el valor esperado
        if (totalAplicar !== todoPago) {
           // alert("Pagar todo");
            $('#modalPagarTodo').modal('show');
        }
        else{

        var numeroProveidoSegundo = $("#numeroProveidoCuotaSegundo").val();
        var estadoReconectarSeg = $("#estadoNS").val();

         // Aquí puedes hacer la solicitud AJAX para eliminar la notificación, usando el valor del input
         var datos = new FormData();
        datos.append("numeroProveidoSegundo", numeroProveidoSegundo);  // Añadir el ID de la notificación a los datos
        datos.append("estadoReconectarSeg", estadoReconectarSeg);  // Añadir el ID de la notificación a los datos
        datos.append("idNotificaionAgua", idNotificaionAgua);  // Añadir el ID de la notificación a los datos
        datos.append("idLicencia", idLicencia);  // Añadir el ID de la notificación a los datos
        datos.append("registrar_notificacion_segundo", "registrar_notificacion_segundo");  // Añadir el ID de la notificación a los datos

          for (var pair of datos.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }

          $.ajax({
              url: "ajax/notificacionagua.ajax.php",  // Ajusta la URL según tu lógica
              method: "POST",
              data: datos,
              cache: false,
              contentType: false,
              processData: false,
              success: function (respuesta) {
              
                if (respuesta.tipo === "correcto") { // Si la respuesta es exitosa
                  $("#modalEditarUsuario").modal("hide");  // Cierra el modal de edición
                  $("#respuestaAjax_srm").show();  // Muestra el área de respuesta
                  $("#respuestaAjax_srm").html(respuesta.mensaje);  // Muestra el mensaje de éxito en el área de respuesta
                
                  notificacionUsuario.lista_notificacion('');
                  setTimeout(function () {
                    $("#respuestaAjax_srm").hide();  // Esconde el mensaje de respuesta después de 5 segundos
                  }, 5000);

                    $("#modalReconectarAguasdacuota").modal("hide");



                }
                else {
                  $("#respuestaAjax_srm").show();  // Si hay error, muestra el mensaje de error
                  $("#respuestaAjax_srm").html(respuesta.mensaje);
                  setTimeout(function () {
                    $("#respuestaAjax_srm").hide();  // Esconde el mensaje de error después de 4 segundos
                  }, 4000);
                }
              },
              error: function (error) {
                  console.log("Error al eliminar la notificación:", error);
                  // Maneja los errores en caso de fallo en la solicitud
              }
          });

         
         

        }
    
    
   

});


//BOTON GUARDAR RECONOEXION
$("#btnGuardarReconexion").on("click", function () {

  console.log("llego aqui");
    var tipoPago = $("#estadoNo").val();
      var todoPago = parseFloat($("#totalPagado").val());  // Aseguramos que todoPago sea numérico
       var idLicencia = $("#inputLicencia").val();

       // Aquí capturamos el valor totalCuotas

    //CUANDO EL PAGO ES DE TIPO TODO
    if (tipoPago == 1) {
        
        // Seleccionar las filas de la tabla
        const filas = $("#primeratabla_agua_r tbody tr");

        // Inicializar la variable para el total a aplicar
        var totalAplicar = 0;
        
        // Iterar sobre las filas de la tabla
        filas.each(function() {
            var $fila = $(this);

            // Verificar si la fila tiene la clase 'green-background' (indicando estado 'H')
            if ($fila.hasClass('green-background')) {
                console.log("Fila con fondo verde: ", $fila);
                
                // Obtener el valor de la columna Total_Aplicar (columna 9)
                var totalAplicarValor = parseFloat($("td:eq(8)", $fila).text().trim().replace(/[^\d.-]/g, '')); // Eliminar caracteres no deseados

                if (!isNaN(totalAplicarValor)) {
                    totalAplicar += totalAplicarValor; // Sumar el valor de Total_Aplicar
                } else {
                    console.log("Valor no válido en la fila:", $fila);
                }
            }
        });

        console.log(totalAplicar);
        console.log(todoPago);
       

        // Verificar si el total a aplicar coincide con el valor esperado
        if (totalAplicar !== todoPago) {
            alert("Pagar todo");
        }
        else{

        var numeroProveido = $("#numeroProveido").val();
        var reconectarTotal = $("#ReconectarTotal").val();
        
         // Aquí puedes hacer la solicitud AJAX para eliminar la notificación, usando el valor del input
         var datos = new FormData();
        datos.append("numeroProveido", numeroProveido);  // Añadir el ID de la notificación a los datos
        datos.append("estadoReconectarTotal", reconectarTotal);  // Añadir el ID de la notificación a los datos
        datos.append("totalAplicar", totalAplicar);  // Añadir el ID de la notificación a los datos
        datos.append("idLicencia", idLicencia);  // Añadir el ID de la notificación a los datos
        datos.append("idtipoPago", tipoPago);  // Añadir el ID de la notificación a los datos
        datos.append("registrar_notificacion_total", "registrar_notificacion_total");  // Añadir el ID de la notificación a los datos


          $.ajax({
              url: "ajax/notificacionagua.ajax.php",  // Ajusta la URL según tu lógica
              method: "POST",
              data: datos,
              cache: false,
              contentType: false,
              processData: false,
              success: function (respuesta) {
              
                if (respuesta.tipo === "correcto") { // Si la respuesta es exitosa
                  $("#modalEditarUsuario").modal("hide");  // Cierra el modal de edición
                  $("#respuestaAjax_srm").show();  // Muestra el área de respuesta
                  $("#respuestaAjax_srm").html(respuesta.mensaje);  // Muestra el mensaje de éxito en el área de respuesta
                
                  // Limpia los campos cuando se cierra el modal
                    $("#estadoNo").val('');  // Limpia el campo de tipo de pago
                    $("#totalPagado").val('');  // Limpia el campo del total pagado
                    $("#inputLicencia").val('');  // Limpia el campo de licencia


                  notificacionUsuario.lista_notificacion('');
                  setTimeout(function () {
                    $("#respuestaAjax_srm").hide();  // Esconde el mensaje de respuesta después de 5 segundos
                  }, 5000);

                    $("#modalReconectarAgua").modal("hide");


                }
                else {
                  $("#respuestaAjax_srm").show();  // Si hay error, muestra el mensaje de error
                  $("#respuestaAjax_srm").html(respuesta.mensaje);
                  setTimeout(function () {
                    $("#respuestaAjax_srm").hide();  // Esconde el mensaje de error después de 4 segundos
                  }, 4000);
                }
              },
              error: function (error) {
                  console.log("Error al eliminar la notificación:", error);
                  // Maneja los errores en caso de fallo en la solicitud
              }
          });

         
         

        }
    }
    
    
    //CUANDO EL PAGO ES POR PARTICION

    else{

      var fecha=$("#fechaVenCuota1").text();

      // Obtener la fecha actual
      var now = new Date();

      // Convertir la fecha del DOM a un objeto Date para poder compararla
      var fechaParts = fecha.split('/'); // Separar la fecha en partes (día, mes, año)
      var fechaObjeto = new Date(fechaParts[2], fechaParts[1] - 1, fechaParts[0]); // Crear el objeto Date con formato (año, mes, día)


      // ES DE LA PRIMERA CUOTA......
      // Comparar la fecha
      if (fechaObjeto.toDateString() === now.toDateString()) {

       
        // DEL PRIMERA CUOTA
        var monto = $("#montoCuota1").text();  // S/. 56.00 (para cuota 2)
        var montoValor = parseFloat(monto.replace(/[^\d.-]/g, '').trim());

        var fechaVencimiento = $("#fechaVenCuota1").text(); // 19/08/2025
        var partesFecha = fechaVencimiento.split("/");  // Separa la fecha en [día, mes, año]
        var fechaFormateada = new Date(partesFecha[2], partesFecha[1] - 1, partesFecha[0]);  // Año, mes, día (recuerda que el mes empieza desde 0)        // Formatear la fecha a yyyy-mm-dd
        var fechaFinalVenCuotauno = fechaFormateada.getFullYear() + '-' + (fechaFormateada.getMonth() + 1).toString().padStart(2, '0') + '-' + fechaFormateada.getDate().toString().padStart(2, '0');




        var numeroProveidoP = $("#numeroProveidoCuota1").val(); // Nro proveído
        var estadoReconexion = $("#estadoNP1").val(); // Reconexión de agua

         // DEL SEGUNDA CUOTA
        var monto2 = $("#montoCuota2").text();  // S/. 56.00 (para cuota 2)
        var montoValor2 = parseFloat(monto2.replace(/[^\d.-]/g, '').trim());

        var fechaVencimiento2 = $("#fechaVenCuota2").text(); // 19/08/2025
        var partesFecha2 = fechaVencimiento2.split("/");  // Separa la fecha en [día, mes, año]
        var fechaFormateada2 = new Date(partesFecha2[2], partesFecha2[1] - 1, partesFecha2[0]);  // Año, mes, día (recuerda que el mes empieza desde 0)        // Formatear la fecha a yyyy-mm-dd
        var fechaFinalVenCuotados = fechaFormateada2.getFullYear() + '-' + (fechaFormateada2.getMonth() + 1).toString().padStart(2, '0') + '-' + fechaFormateada2.getDate().toString().padStart(2, '0');


          //  COMPARAR CON LO PAGADO
        const filas = $("#primeratabla_agua_r tbody tr");

        // Inicializar la variable para el total a aplicar
        var totalAplicar = 0;
        
        // Iterar sobre las filas de la tabla
        filas.each(function() {
            var $fila = $(this);

            // Verificar si la fila tiene la clase 'green-background' (indicando estado 'H')
            if ($fila.hasClass('green-background')) {
               // console.log("Fila con fondo verde: ", $fila);
                
                // Obtener el valor de la columna Total_Aplicar (columna 9)
                var totalAplicarValor = parseFloat($("td:eq(8)", $fila).text().trim().replace(/[^\d.-]/g, '')); // Eliminar caracteres no deseados

                if (!isNaN(totalAplicarValor)) {
                    totalAplicar += totalAplicarValor; // Sumar el valor de Total_Aplicar
                } else {
                  //  console.log("Valor no válido en la fila:", $fila);
                }
            }
        });

        let valorSelecioando=totalAplicar;  
        

   
         //VALIDAD CUANTO PAGO EN LA PRIMERA CUOTA

        if ( valorSelecioando !== montoValor) {

          $('#modalPagarParticiones').modal('show');




        }

        //VALIDAR EL PRIMER PAGO SI COENCIDE....
        else{

        //COMPARAR CON LO PAGADO END

         // Aquí puedes hacer la solicitud AJAX para eliminar la notificación, usando el valor del input
        var datos = new FormData();
        datos.append("idLicencia", idLicencia);  // Añadir el ID de la notificación a los datos
        datos.append("idtipoPago", tipoPago);  // Añadir el ID de la notificación a los datos

        //PRIMER CUOTA
        datos.append("numeroProveido", numeroProveidoP);  // Añadir el ID de la notificación a los datos
        datos.append("estadoReconectarParticion", estadoReconexion);  // Añadir el ID de la notificación a los datos
        datos.append("particionAplicar", montoValor);  // Añadir el ID de la notificación a los datos
        datos.append("fechaVencimiento", fechaFinalVenCuotauno);  // Añadir el ID de la notificación a los datos
       
        //SEGUNDA CUOTA
        datos.append("totalAplicar2", montoValor2);  // Añadir el ID de la notificación a los datos
        datos.append("fechaVencimiento2", fechaFinalVenCuotados);  // Añadir el ID de la notificación a los datos
       
       
       
        datos.append("registrar_notificacion_particion", "registrar_notificacion_particion");  // Añadir el ID de la notificación a los datos

        // Imprimir los valores de FormData en la consola
        for (let pair of datos.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

          $.ajax({
              url: "ajax/notificacionagua.ajax.php",  // Ajusta la URL según tu lógica
              method: "POST",
              data: datos,
              cache: false,
              contentType: false,
              processData: false,
              success: function (respuesta) {

              
                if (respuesta.tipo === "correcto") { // Si la respuesta es exitosa
                  $("#modalEditarUsuario").modal("hide");  // Cierra el modal de edición
                  $("#respuestaAjax_srm").show();  // Muestra el área de respuesta
                  $("#respuestaAjax_srm").html(respuesta.mensaje);  // Muestra el mensaje de éxito en el área de respuesta
                
                  notificacionUsuario.lista_notificacion('');
                  setTimeout(function () {
                    $("#respuestaAjax_srm").hide();  // Esconde el mensaje de respuesta después de 5 segundos
                  }, 5000);



                    $("#modalReconectarAgua").modal("hide");


                }
                else {
                  $("#respuestaAjax_srm").show();  // Si hay error, muestra el mensaje de error
                  $("#respuestaAjax_srm").html(respuesta.mensaje);
                  setTimeout(function () {
                    $("#respuestaAjax_srm").hide();  // Esconde el mensaje de error después de 4 segundos
                  }, 4000);
                }
              },
              error: function (error) {
                  console.log("Error al eliminar la notificación:", error);
                  // Maneja los errores en caso de fallo en la solicitud
              }
          });

         




        }





      } 
      
      // ES DE LA SEGUNDA CUOTA......
      else {

        var monto = $("#montoCuota2").text();  // S/. 56.00 (para cuota 2)
          var fechaVencimiento = $("#fechaVenCuota2").text(); // 19/08/2025
          var numeroProveidoP = $("#numeroProveidoCuota2").val(); // Nro proveído
          var estadoReconexion = $("#estadoNP2").val(); // Reconexión de agua

          console.log("monto---", monto); // S/. 56.00
          console.log("fecha---", fechaVencimiento); // 19/08/2025
          console.log("numero proveido particion", numeroProveidoP); // Valor de "Nro proveído"
          console.log("estado reconexion", estadoReconexion); // Valor de "Reconectar"

      }

    }

});



// Cuando el usuario hace clic en "Sí, Eliminar"
$("#btnEliminarNotificacion").on("click", function () {
    // Capturar el valor del input oculto
    var idNotificacion = $("#idNotificacionEliminar").val();
    console.log("Confirmando eliminación de notificación con ID:", idNotificacion);  // Verifica que se está obteniendo el ID correctamente

    // Aquí puedes hacer la solicitud AJAX para eliminar la notificación, usando el valor del input
    var datos = new FormData();
    datos.append("idNotificacion", idNotificacion);  // Añadir el ID de la notificación a los datos

      datos.append("eliminar_notificacion", "eliminar_notificacion");  // Añadir el ID de la notificación a los datos

    $.ajax({
        url: "ajax/notificacionagua.ajax.php",  // Ajusta la URL según tu lógica
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
         
          if (respuesta.tipo === "correcto") { // Si la respuesta es exitosa
            $("#modalEditarUsuario").modal("hide");  // Cierra el modal de edición
            $("#respuestaAjax_srm").show();  // Muestra el área de respuesta
            $("#respuestaAjax_srm").html(respuesta.mensaje);  // Muestra el mensaje de éxito en el área de respuesta
          
            notificacionUsuario.lista_notificacion('');
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de respuesta después de 5 segundos
            }, 5000);

              $("#modalEliminarNotificacion").modal("hide");


          }
          else {
            $("#respuestaAjax_srm").show();  // Si hay error, muestra el mensaje de error
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();  // Esconde el mensaje de error después de 4 segundos
            }, 4000);
          }
        },
        error: function (error) {
            console.log("Error al eliminar la notificación:", error);
            // Maneja los errores en caso de fallo en la solicitud
        }
    });





});



$(document).on("click", "#popimprimirExportarPDF", function () {

 notificacionUsuario.imprimirAgua();

   $("#ModalImprimirNotificacionAgua").modal("show");
});






$(document).ready(function() {
    // Muestra u oculta el div 'pagoTodo' basado en el cambio en #estadoNo
    $('#estadoNo').change(function() {
        var estadoSeleccionado = $(this).val(); // Captura el valor del select
        
        if (estadoSeleccionado === '1') {
            $('.pagoTodo').show();  // Muestra el div con clase 'pagoTodo'
            $('.pagaParticion').hide(); // Oculta el div con clase 'pagaParticion'
             $('#estadoN2').val(' ');  // Establece el valor del select 'estadoN2' a 'Seleccionar'
              $('#estadoC').val(' ');  // Establece el valor del select 'estadoN2' a 'Seleccionar'
               $('#estadoNP').val(' '); 

               notificacionUsuario.MostrarCuotasPagar(0, 0);
               


        } else if (estadoSeleccionado === '2') {
            $('.pagaParticion').show();  // Muestra el div con clase 'pagaParticion'
            $('.pagoTodo').hide(); // Oculta el div con clase 'pagoTodo'
             $('#estadoN2').val(' ');  // Establece el valor del select 'estadoN2' a 'Seleccionar'

             $('#estadoC').val(' ');  // Establece el valor del select 'estadoN2' a 'Seleccionar'
            $('#estadoNP').val(' '); 

            

        } else {
            $('.pagoTodo').hide();  // Oculta el div con clase 'pagoTodo'
            $('.pagaParticion').hide(); // Oculta el div con clase 'pagaParticion'
              $('#estadoN2').val(' ');
              $('#estadoC').val(' ');  // Establece el valor del select 'estadoN2' a 'Seleccionar'
                $('#estadoNP').val(' '); 

             notificacionUsuario.MostrarCuotasPagar(0, 0);
        }
    });

    // Manejo de la selección de cuotas
    $('#estadoC').change(function() {
        var cuotas = $(this).val(); // Captura directamente el valor del select (2C o 3C)
        var idLicencia = $('#inputLicencia').val();  // Captura el valor del input con id 'inputLicencia'

        if (cuotas === '2' || cuotas === '3') {
            console.log("Valor de idLicencia:", idLicencia); // Muestra el valor capturado del input
            console.log("Valor seleccionado para cuotas:", cuotas); // Muestra el valor de las cuotas

            // Llama a la función para mostrar las cuotas
            notificacionUsuario.MostrarCuotasPagarV(cuotas);

            // Muestra el div con la clase 'cuotas'
            $('.cuotas').show();  
        } else {
            // Oculta el div con la clase 'cuotas' si no se selecciona '2C' o '3C'
            $('.cuotas').hide();  
        }
    });
});



//NOTIFICACION
$(document).on("click", "#popimprimir_agua_volver", function () {
  if(notificacionUsuario.idsSeleccionados.length === 0)
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
  //  consulta_deuda_agua_lista.imprimirhere_agua_n();
   // $("#Modalimprimir_cuentaagua_n").modal("show");


     $("#modal_generar_notificacion_volver").modal("show");
    
  }
});

//NOTIFICACION VOLVER A IMPRIMIR

$(document).on("click", "#confirmarGenerarNotificacionVolver", function () {
  if(notificacionUsuario.idsSeleccionados.length === 0)
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
    notificacionUsuario.imprimirhere_agua_n_volver();

    $("#Modalimprimir_cuentaagua_n_volver").modal("show");
     $("#modal_generar_notificacion_volver").modal("hide");

    
  }
});



//REEMPRIMIR NOTIFICACION
$(document).on("click", "#popimprimir_aguan", function () {

  

  if(notificacionUsuario.idsSeleccionados.length === 0)
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
    notificacionUsuario.imprimirhere_aguar();
    $("#Modalimprimir_cuentaaguan").modal("show");
    
  }
});



//REEMPRIMIR NOTIFICACION
$(document).on("click", "#popimprimir_aguas", function () {

  if(notificacionUsuario.idsSeleccionados.length === 0)
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
    notificacionUsuario.imprimirhere_aguas();
    $("#Modalimprimir_cuentaaguas").modal("show");
    
  }

});


$(document).ready(function() {
    // ...otros códigos de inicialización...

    // Limpia los inputs al abrir los modales de reconexión
    $('#modalReconectarAgua').on('show.bs.modal', function () {
        $('#totalPagado').val('');
    });
    $('#modalReconectarAguasdacuota').on('show.bs.modal', function () {
        $('#totalPagadoSe').val('');
    });
});

//REDIRIGE AL LICENCIA DE AGUA
$(document).ready(function() {
    // Usamos delegación de eventos para asegurarnos de que el click funcione incluso si las filas se generan dinámicamente
    $('body').on('click', '.id-contribuyente .btn-enlace', function() {
        console.log("¡Has hecho clic aquí!");

        // Obtener el Id_Contribuyente desde el atributo 'data-id' de la celda
        var idContribuyente = $(this).closest('td').data('id');
        
        // Construir la URL dinámica
        var url = "http://localhost/SIAT/index.php?ruta=listapredioagua&id=" + idContribuyente;
        
        // Redirigir a la URL
        window.location.href = url;
    });
});
