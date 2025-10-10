
<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">

    <div class="box table-responsive">

    
      <div class="row">
        <div class="col-md-8">
          <table class="table-container" id="tbConsultaReporteIngresoDiario">
            <caption>Reporte de actualizacion de carpetas</caption>
            <thead>
              <tr>
                <td class="text-right">Seleccione fiscalizador</td>

               <td>
                  <select id="id_usuario_act" name="id_usuario_act" class="form-control">
                      <!-- Aquí puedes añadir las opciones, que pueden provenir de una base de datos o ser estáticas -->
                      <option value=" ">Todos</option>
                      <option value="151">Katherin liz licla lopez</option>
                      <option value="114">Adon quispe jurado</option>
                        <option value="136">Mayori</option>
                          <option value="124">Lili jihuallanca basilio</option>
                          <option value="100">David jalixto huasco</option>
                          <option value="99">Jhon ordaya hancco</option>
                            <option value="102">Bertha incho marca</option>
                      <!-- Puedes añadir más opciones según sea necesario -->
                  </select>
              </td>

              <td class="text-right">Seleccione estado</td>
                <td>
                  <select id="estado_act" name="estado_act" class="form-control">
                      <!-- Aquí puedes añadir las opciones, que pueden provenir de una base de datos o ser estáticas -->
                      <option value=" ">Todos</option>
                      <option value="P">Pendiente</option>
                      <option value="E">En progreso</option>
                      <option value="C">Completado</option>
                      <!-- Puedes añadir más opciones según sea necesario -->
                  </select>
        </td>
              

               
                <td><button class="btn-success" id="btnConsultarReporteAct">Consultar</button></td>
                  <td class="text-right">Exportar excel</td>
                <td><img src="./vistas/img/iconos/excel.svg" class="t-icon-tbl-imprimi_b" title="Imprimir Reporte" id="popimprimir_reporte_actualizacion"></td>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>


  </section>
  <!-- seccion de la Id-->
  <section class="container-fluid panel-medio">
    <div class="row">
      <div class="col-md-12 table-responsive cierre_div">
        <div class="divReport_finan">
          <table class="table-container miprimeratabla_cierre" id="tbReporteIngresosDiarios">
            <caption>Reporte de Ingresos Ingresos Diarios</caption>
            <thead>
              <tr>
                <th class="text-center">#</th>
                 <th class="text-center">Codigo Carpeta</th>
                <th class="text-center">Estado</th>
                <th class="text-center">En oficina</th>
                <th class="text-center">En campo</th>
                <th class="text-center">Fecha Registro</th>
                <th class="text-center">Fecha Actualización</th>
                <th class="text-center">Actualizado Por</th>
              </tr>
            </thead>
            <tbody id="bodyReporteActualizacion">

            </tbody>
          </table>
        </div>
        <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
        
      </div>
     
    </div>
  </section>
</div>

<!-- Modal de Cargando (Spinner) -->
<div class="modal" id="modalCargando" tabindex="-1" role="dialog" aria-labelledby="modalCargandoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
        <p>Cargando, por favor espere...</p>
      </div>
    </div>
  </div>
</div>










<div class="resultados"></div>
<div id="errorLicence"><!--CONTENIDO DINAMICO  --></div>
<div id="respuestaAjax_correcto"></div>


<!-- modal donde se genera el PDF Reporte -->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_ReporteDiario" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhere">
          <iframe id="iframe_reporte_diario" class="iframe-full-height"><!-- Muestra el PDF --></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de generar pdf Reporte-->
 <!-- modal cargando -->
<?php include_once "modalcargar.php";  ?>
<!-- fin de modal cargando-->