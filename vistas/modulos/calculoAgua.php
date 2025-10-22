<?php
use Controladores\ControladorPredio;
?>
<div class="content-wrapper panel-medio-principal">


  <section class="container-fluid panel-medio">

    <div class="box table-responsive">

    
      <div class="row">
        <div class="col-md-8">
          <table class="table-container" id="tbConsultaReporteIngresoDiario">
            <caption>Calcular el estado de cuenta del agua</caption>
            <thead>

              <tr>

               <td class="text-right">Anio base</td>


               <td>
                <select class="busqueda_filtros" id="anioBase" name="anioBase">
                    <?php
                    $anio = ControladorPredio::ctrMostrarDataAnio();
                    foreach ($anio as $data_anio) {
                      $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                      echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . '</option>';
                    }
                    ?>
                  </select>
              </td>

                <td class="text-right">Año a calcular</td>


               <td>
                <select class="busqueda_filtros" id="anioCalcular" name="anioCalcular">
                    <?php
                    $anio = ControladorPredio::ctrMostrarDataAnio();
                    foreach ($anio as $data_anio) {
                      $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                      echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . '</option>';
                    }
                    ?>
                  </select>
              </td>

            
                <td><button class="btn-success" id="popCalcularEstadoCuenta">Calcular</button></td>
                  
               
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

  </section>



  
<!-- MODAL ELIMINAR NEGOCIO -->
<div class="modal fade" id="modal_calcular_agua" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">

           <input type="text" id="inputNegocio" class="hidden" >
          <input type="text" id="inputPredio" class="hidden"  >


          <div class="col-xs-12 text-center">
            <i class="bi bi-exclamation-circle" style="color: red; font-size: 48px;"></i>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            <h3>¿Estás seguro ?</h3>
           <p>
              <small>
                Se generará automáticamente el cálculo del estado de cuenta del agua.  
                El proceso copiará los registros del <strong>año base</strong> al <strong>siguiente año</strong>  
                para todos los contribuyentes que cuenten con los <strong>12 periodos completos</strong>.
              </small>
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary" id="btnCalculoGeneralAgua">Sí, Calcular</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- 🌀 MODAL CON BARRA DE PROGRESO -->
<div class="modal fade" id="modalCargando" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center p-3">
      <h5 class="text-primary mb-3">Procesando cálculo general...</h5>

      <!-- Barra de progreso -->
      <div class="progress" style="height: 25px;">
        <div id="barraProgresoInterna"
             class="progress-bar progress-bar-striped progress-bar-animated bg-success"
             role="progressbar"
             style="width: 0%;"
             aria-valuenow="0"
             aria-valuemin="0"
             aria-valuemax="100">
          0%
        </div>
      </div>

      <p class="mt-3 text-muted"><small>Esto puede tardar algunos segundos...</small></p>
    </div>
  </div>
</div>


<!-- MODAL ELIMINAR NEGOCIO IND -->


</div>









<!-- fin de generar pdf Reporte-->
 <!-- modal cargando -->
<?php include_once "modalcargar.php";  ?>
<!-- fin de modal cargando-->