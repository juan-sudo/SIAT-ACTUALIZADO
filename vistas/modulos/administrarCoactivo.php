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
          <h3 class="box-title">Administracion de coactivo</h3>


        </div>

        <div class="box-header">
    <div class="col-md-3">
        <label for="filtrar_nombre_coactivo">Filtrar por nombre</label>
        <input type="text" id="filtrar_nombre_coactivo" name="filtrar_nombre_coactivo" class="form-control" style="width: 100%;" placeholder="Ingrese nombre o apellidos">
    </div>

    <div class="col-md-2">
        <label for="filtrar_op">Filtrar por orden pago</label>
        <input type="text" id="filtrar_op" name="filtrar_op" class="form-control" style="width: 100%;" placeholder="Ingrese o.p.">
    </div>
     <div class="col-md-2">
        <label for="filtrar_ex">Filtrar por expdiente</label>
        <input type="text" id="filtrar_ex" name="filtrar_ex" class="form-control" style="width: 100%;" placeholder="Ingrese o.p.">
    </div>

   

     <div class="col-md-1">
        <label>Paginas</label>
        <select id="resultados_por_pagina_co" name="resultados_por_pagina_co" class="form-control">
            <option value="15" selected >15</option>
            <option value="25">25</option>
        </select>

    </div>

   
    <div class="col-md-4">
        <!-- <button class="btn btn-success pull-right btn-radius" id="popimprimirExportarPDF" style="margin-top: 24px;">
            <i class="fas fa-plus-square"></i> Exportar PDF
        </button> -->
    </div>



</div>




        <!-- /.box-header -->
        <div class="box-body table-user">
          <input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
          <!-- table-bordered table-striped  -->

           <div style="overflow-x: auto; max-width: 100%;">

          <table class="table  dt-responsive  tbl-t" width="100%">

            <thead>
              <tr>
               
                
                 <th style="width: 5%;text-align: center;">Codigo</th>
                 <th style="width: 10%; text-align: center;">N° expe.</th>
                 <th style="width: 10%; text-align: center;">N° o.p.</th>
                <th style="width: 25%;">Nombres y apellidos</th>
               
                 <th style="width: 8%;text-align: center;">Estado</th>
              
               
                <th style="width: 12%;text-align: center;">Acciones</th>
              </tr>
            </thead>

            <tbody id="lista_de_coactivo">
              <!-- Lista Contribuyente dinamico-->
            </tbody>

            

          </table>
           </div>
            <!-- Agregar la sección de paginación aquí -->
          <div id="pagination_co" style="text-align: center;">
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

<!-- MODAL EDITAR ADMINISTRACION COACTIVO -->
<div id="modalEditarEstadoCuenta" class="modal fade modal-forms fullscreen-modal" tabindex="-1" role="dialog" aria-labelledby="modalEditarNotificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->  
            <div class="modal-header" style="background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button> 
                <h4 class="modal-title">Editar administracion coactivo</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-6">
                     <div class="form-group">
                    <label for="numeroExpedienteCo">Numero de expediente</label>
                    <input type="text" class="form-control" id="numeroExpedienteCo" name="numeroExpedienteCo" placeholder="Ingrese valor para el campo 1">
                </div>

                </div>
                  <div class="col-lg-6">
                      <!-- Segundo Input -->
                <div class="form-group">
                <label for="estadoCo">Estado</label>
                <select class="form-control" id="estadoCo" name="estadoCo">
                    <option value="" disabled selected>Seleccione un estado</option>
                    <option value="I">Iniciado</option>
                    <option value="M">Medida cautelar</option>     
                </select>
            </div>

                </div>


              </div>
                <!-- Primer Input -->
             

              

            </div>

            <!-- Modal Footer (puedes agregar botones aquí si lo deseas) -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btnGuadarAdministracionCoactivo">Guardar cambios</button>
            </div>

        </div>
    </div>
</div>
<!-- MODAL DE RECONEXION FIN -->

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
                  
                  <table id="table-moto-anios">

                  </table>

              

               
                      
              </div>
              <table id="pagina_total">

                  </table>

          </div>

        
     


        </div>
    </div>
</div>
<!-- MODAL DE RECONEXION FIN -->
















<div class="resultados"></div>