<?php

use Controladores\ControladorPredio;
use Controladores\ControladorNotificacion;

?>
<div class="content-wrapper panel-medio-principal">
  <?php
  if ($_SESSION['perfil'] == 'Vendedorr' || $_SESSION['perfil'] == 'Especiall') {

    echo '
      <section class="container-fluid panel-medio">
      <div class="box alert-dangers text-center">
     <div><h3> Área restringida, solo el administrador puede tener acceso</h3></div>
    <div class="img-restringido"></div>
     
     </div>
     </div>';
  } else {


  ?>


    <!-- <section class="content"> -->
    <section class="container-fluid panel-medio">
      <!-- BOX INI -->
      <div class="box rounded">
        <div class="box-header ">
          <h3 class="box-title">Administracion de orden pago</h3>


        </div>







        <!-- /.box-header -->
        <div class="box-body table-user">
          <input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
          <!-- table-bordered table-striped  -->

           <div style="overflow-y: auto; max-height: 600px; overflow-x: auto; max-width: 100%;">

          <table class="table  dt-responsive  tbl-t" width="100%">

            <thead>
              <tr>
               
                
                 <th style="width: 10%;text-align: center;">N° o.p.</th>
                 <th style="width: 15%; text-align: center;">Codigo</th> 
                 <th style="width: 10%; text-align: center;">Monto total</th>
                <th style="width: 15%; text-align: center;">Tim total</th>
               
                 <th style="width: 8%;text-align: center;">Fecha reg.</th>
                 <th style="width: 8%;text-align: center;">Fecha not.</th>
                  <th style="width: 8%;text-align: center;">Estado</th>
               
              
               
                <th style="width: 12%;text-align: center;">Acciones</th>
              </tr>
            </thead>

            <tbody id="lista_de_ordenpago">
              <!-- Lista Contribuyente dinamico-->
            </tbody>

            

          </table>
           </div>
            <!-- Agregar la sección de paginación aquí -->
          <div id="pagination_or" style="text-align: center;">
            <!-- Los enlaces de paginación se generarán aquí -->
          </div>


        </div>


      </div>
      <!-- BOX FIN -->
      <!-- /.box-footer -->
    </section>

  <?php } ?>
  <!-- <button type="button" class="btn btn-primary printsave">Print</button>
<div class="printerhere" width="100%" style=""></div> -->
  <!-- <embed class="printerhere" src="" type="application/pdf" width="100%" height="600px" class="printerhere" /> -->

</div>


<!-- MODAL EDITAR FECHA DE NOTIFICAICON ORDEN PAGO -->
<div id="modalEditarFechaNotificacion" class="modal fade modal-forms fullscreen-modal" tabindex="-1" role="dialog" aria-labelledby="modalEditarNotificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->  
            <div class="modal-header" style="background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button> 
                <h4 class="modal-title">Editar fecha notificacion</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                     <div class="form-group">
                    <label for="fechaNotificacionOrd">Fecha notificacion</label>
                    <input type="date" class="form-control" id="fechaNotificacionOrd" name="fechaNotificacionOrd" placeholder="Ingrese valor para el campo 1">
                </div>

                </div>
               
              </div>
                
            </div>

            <!-- Modal Footer (puedes agregar botones aquí si lo deseas) -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btnGuadarOrdenPagoFecha">Guardar cambios</button>
            </div>

        </div>
    </div>
</div>
<!-- MODAL DE RECONEXION FIN -->


<!-- MODAL EDITAR ADMINISTRACION COACTIVO -->
<div id="modalEditarOrdenPagoEnviarCoactivo" class="modal fade modal-forms fullscreen-modal" tabindex="-1" role="dialog" aria-labelledby="modalEditarNotificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->  
            <div class="modal-header" style="background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button> 
                <h4 class="modal-title">Editar enviar coactivo </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-6">
                     <div class="form-group">
                    <label for="numeroImforme">Numero de informe</label>
                    <input type="text" class="form-control" id="numeroImforme" name="numeroImforme" placeholder="Ingrese valor para el campo 1">
                </div>

                </div>
                  <div class="col-lg-6">
                      <!-- Segundo Input -->
                <div class="form-group">
                <label for="estadoCoactivo">Enviar coactivo</label>
                <select class="form-control" id="estadoCoactivo" name="estadoCoactivo">
                    <option value="" disabled selected>Seleccione un estado</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>     
                </select>
              </div>

                </div>


              </div>
                <!-- Primer Input -->
             

              

            </div>

            <!-- Modal Footer (puedes agregar botones aquí si lo deseas) -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btnGuadarEnviarCoactivo">Guardar cambios</button>
            </div>

        </div>
    </div>
</div>
<!-- MODAL DE RECONEXION FIN -->

<!-- modal donde se genera el pdf oden pago - impuesto-->
<div class="container-fluid">
  <div class="modal in" id="Modal_Orden_Pago_a" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-body printerhere">
          <iframe id="iframe_orden_pago_a" class="iframe-full-height"><!-- Muestra el PDF --></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cerrar-modal_a">Close</button>
        <!--  <button type="button" class="btn btn-secondary cerrar-modal" data-dismiss="modal">Close</button> -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de generar pdf oden pago - impuesto-->

<!-- MODAL MOSTRAR TOTAL DE COATCIVO -->
<div id="modalEstadoCuentaVer" class="modal fade modal-forms fullscreen-modal" tabindex="-1" role="dialog" aria-labelledby="modalEditarNotificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

           
                <!-- Modal Header -->  
                <div class="modal-header" style="background-color: #3c8dbc; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                    <h4 class="modal-title" > Importe anual /total coactivo </h4>
                </div>

         

          <!-- Modal Body -->
          <div class="modal-body estado_cuentaAgua_mostrar">
              <div class="row ">
                  
                  <table id="table-moto-anios-or">

                  </table>

              

               
                      
              </div>
              <table id="pagina_total_or">

                  </table>

          </div>

        
     


        </div>
    </div>
</div>
<!-- MODAL DE RECONEXION FIN -->
















<div class="resultados"></div>