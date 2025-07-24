<?php

use Controladores\ControladorUsuarios;
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
          <h3 class="box-title">Notificacion agua</h3>


        </div>

        <div class="box-header">
    <div class="col-md-4">
        <label>Filtrar por nombre</label>
        <input type="text" id="filtrar_nombre" name="filtrar_nombre" class="form-control" style="width: 100%;" placeholder="Ingrese nombre o apellidos">
    </div>

    <div class="col-md-2">
        <label>Filtrar por fecha notificación</label>
        <input type="date" id="fecha_notificacion" name="fecha_notificacion" class="form-control">
    </div>

    <div class="col-md-2">
        <label>Filtrar Estado</label>
        <select id="filtrar_estado" name="filtrar_estado" class="form-control">
            <option value="todos">Todos</option>
            <option value="N">Notificado</option>
            <option value="C">Afecto a corte</option>
            <option value="S">Sin servicio</option>
             <option value="P">Pagado</option>
               <option value="R">Reconectado</option>
               <option value="R1">Primera cuota</option>

        </select>
    </div>

    <div class="col-md-4">
        <button class="btn btn-success pull-right btn-radius" id="popimprimirExportarPDF" style="margin-top: 24px;">
            <i class="fas fa-plus-square"></i> Exportar PDF
        </button>
    </div>
</div>




        <!-- /.box-header -->
        <div class="box-body table-user">
          <input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
          <!-- table-bordered table-striped  -->
          <table class="table  dt-responsive  tbl-t" width="100%">

            <thead>
              <tr>
                <th style="width:10px;">#</th>
                <th>Nombres y apellidos</th>
                <th>Nro notificacion</th>
                <th>Direccion</th>
                <th>Fecha notificacion</th>
                <th>Fecha corte</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>

            <tbody id="lista_de_notificacion">
              <!-- Lista Contribuyente dinamico-->
            </tbody>

            

          </table>
            <!-- Agregar la sección de paginación aquí -->
          <div id="pagination" style="text-align: center;">
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

<!-- MODAL AGREGAR USUARIO -->
<!-- Modal -->
<div id="modalAgregarUsuario" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">


      <form role="form" id="formUser" class="form-inserta" enctype="multipart/form-data">


        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">AGREGAR USUARIO</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">
            <div class="col-md-12">
              <div id="respuestaAjax"></div>
              <div class="form-group">
                <input type="number" class="form-control " name="Dni" id="Dni" placeholder="Ingresar D.N.I." maxlength="8" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control " name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre">
              </div>
              <div class="form-group">
                <input type="mail" class="form-control " name="nuevoEmail" id="nuevoEmail" placeholder="Ingresar correo electrónico" required>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="nuevoUsuario" id="nuevoUsuario" placeholder="Ingresar usuario" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="password" class="form-control " name="nuevoPassword" id="nuevoPassword" placeholder="Ingresar contraseña" required>
                  </div>
                </div>
              </div>

              <select class="form-control" id="id_area" name="id_area">
                <?php
                $tabla_area = 'area';
                $area = ControladorPredio::ctrMostrarData($tabla_area);
                foreach ($area as $data_area) {
                  echo "<option value='" . $data_area['Id_Area'] . "'>" . $data_area['Nombre_Area'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

        </div>


        <div class="modal-footer">

          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="far fa-times-circle fa-lg"></i> Salir</button>

          <button type="submit" class="btn btn-primary btnusuario">Guardar</button>

        </div>

      </form>


    </div>
  </div>
</div>



<!-- modal de imprimir estado cuenta -->
<div class="container-fluid">
  <div class="modal in" id="ModalImprimirNotificacionAgua" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhere">
          <iframe id="iframeA" class="iframe-full-height"></iframe>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de imprimir estado de cuenta-->

<!-- MODAL DE NOTIFICACION -->
<div id="modalEditarNotificacion" class="modal fade modal-forms fullscreen-modal" tabindex="-1" role="dialog" aria-labelledby="modalEditarNotificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <form role="form" method="post" class="form-inserta-editar_n" enctype="multipart/form-data">

                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #3c8dbc; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" > Editar Notificación</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <div class="box-body">
                        <!-- Fecha de Notificación -->
                        <div class="form-group row">
                          <input type="text" id="idNotificacionA" name="idNotificacionA" hidden>

                            <label for="editarFechaRegistro" class="col-md-3 col-form-label">Fecha Notificación</label>
                            <div class="col-md-9">
                                <span id="editarFechaRegistro"  
                                   style="background-color: #63b360; border-radius: 3px; color: white; padding-left: 10px; padding-right: 10px;" 
                                
                                
                                class="form-control-plaintext"></span>
                            </div>
                        </div>

                        <!-- Fecha de Corte -->
                        <div class="form-group row">
                            <label for="editarFechaCorte" class="col-md-3 col-form-label">Fecha Corte</label>
                            <div class="col-md-9">
                                <span id="editarFechaCorte"
                                 style="background-color: #e64d45; border-radius: 3px; color: white; padding-left: 10px; padding-right: 10px;" 
                                 class="form-control-plaintext"></span>
                            </div>
                        </div>

                        <!-- Estado de la Notificación -->
                        <div class="form-group row" >
                            <label for="estadoN" class="col-md-3 col-form-label">Estado</label>
                            <div class="col-md-9">
                                <select class="form-control" id="estadoN" name="estadoN">
                                    <option value="N">Notificado</option>
                                    <option value="C">Afecto Corte</option>
                                    <option value="S">Sin Servicio</option>
                                    <!-- <option value="P">Pagado</option> -->
                                </select>
                            </div>
                        </div>

                       <div class="form-group row" id="observacionRow" style="display:none;">
                            <label for="observacionN" class="col-md-3 col-form-label">Observacion</label>
                           
                            <div class="col-md-9">
                              <textarea id="observacionN" name="observacionN"  class="form-control" rows="4" placeholder="Ingresa tu observación de dejar sin servicio de agua"></textarea>
                          </div>

                        </div>



                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="far fa-times-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- MODAL DE NOTIFICACION FIN -->


<!-- MODAL DE RECONEXION 2 CUOTA -->
<div id="modalReconectarAguasdacuota" class="modal fade modal-forms fullscreen-modal" tabindex="-1" role="dialog" aria-labelledby="modalEditarNotificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

           
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #3c8dbc; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                    <h4 class="modal-title" > Pago segunda cuota Reconexión agua</h4>
                </div>

               <input type="text" id="inputLicenciaSe"  >
                <input type="text" id="totalPagadoSe"   >
                <input type="text" id="inputNotificacionSe"   >

                


                <!-- Modal Body -->
                <div class="modal-body estado_cuentaAgua_mostrar">
                    <div class="row divDetallePredioR">
                      <table class="table-container miprimeratabla_agua_rs" id="primeratabla_agua_rs">
                        <thead>
                          <tr>
                            <th class="text-center" style="width:30px;">Cod.</th>
                            <th class="text-center" style="width:50px;">Servicio</th>
                            <th class="text-center" style="width:50px;">Año</th>
                            <th class="text-center" style="width:50px;">Periodo</th>
                            <th class="text-center" style="width:50px;">Importe</th>
                            <th class="text-center" style="width:50px;">Gastos</th>
                            <th class="text-center" style="width:50px;">Subtotal</th>
                            <th class="text-center" style="width:50px;">Desc.</th>
                            <th class="text-center" style="width:50px;">Total</th>
                            <th class="seleccionado text-center" style="width:20px;">S</th>
                          </tr>
                        </thead>

                        <tbody id="listaLicenciasAgua_estadocuenta_rs">
                          <!-- Aqui Aparecen el estado de cuenta Agua-->
                        </tbody>
                        
                      </table>
                    </div>

                  <table class="table-container" id="segundaTabla_agua_rs">
                    
                    <tbody>
                      <th class="text-right td-round total_c" style="width:180px;">Total Deuda =</th>
                      <th class="text-center td-round" style="width:50px;"></th>
                      <th class="text-center td-round" style="width:50px;"></th>
                      <th class="text-center td-round" style="width:50px;"></th>
                      <th class="text-center" style="width:50px;"></th>
                      <th class="text-center" style="width:50px;"></th>
                      <th class="text-center" style="width:20px;" id="va" ></th>
                    </tbody>  
                          
                    
                  </table>


                  
                   <div class="form-group row" style=" padding: 10px; border: 1px dotted #999793;" >

                    <div class="form-group row " >


                         <div class="col-md-12" style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Cuotas de pago y Fechas de vencimiento</span>
                                <button type="button" class="btn btn-primary  btn-sm" id="popimprimir_aguas" data-target="#Modalimprimir_cuentaaguas">Imprimir notificacion s</button>
                            </div>

                         <div class="col-md-12" id="mostrar_segunda_cuota">

                         


                         </div>

                    </div>


                    




                 


                        </div>




                       

    
                      </div>

                
                      <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="far fa-times-circle"></i> Cancelar
                    </button>

                  <button type="button" class="btn btn-primary" id='btnGuardarReconexionSegunda'>
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>

                    
                </div>

          

        </div>
    </div>
</div>
<!-- MODAL DE RECONEXION FIN -->


<!-- MODAL DE RECONEXION -->
<div id="modalVerAgua" class="modal fade modal-forms fullscreen-modal" tabindex="-1" role="dialog" aria-labelledby="modalEditarNotificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

           
                <!-- Modal Header -->  
                <div class="modal-header" style="background-color: #3c8dbc; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                    <h4 class="modal-title" > Ver estado de cuenta agua</h4>
                </div>

               <input type="text" id="inputLicenciaa" hidden  >
                <input type="text" id="totalPagadoo" hidden >


                <!-- Modal Body -->
                <div class="modal-body estado_cuentaAgua_mostrar">
                    <div class="row divDetallePredioR">
                      <table class="table-container miprimeratabla_agua_rn" id="primeratabla_agua_rn">
                        <thead>
                          <tr>
                            <th class="text-center" style="width:30px;">Cod.</th>
                            <th class="text-center" style="width:50px;">Servicio</th>
                            <th class="text-center" style="width:50px;">Año</th>
                            <th class="text-center" style="width:50px;">Periodo</th>
                            <th class="text-center" style="width:50px;">Importe</th>
                            <th class="text-center" style="width:50px;">Gastos</th>
                            <th class="text-center" style="width:50px;">Subtotal</th>
                            <th class="text-center" style="width:50px;">Desc.</th>
                            <th class="text-center" style="width:50px;">Total</th>
                            <th class="seleccionado text-center" style="width:20px;">S</th>
                          </tr>
                        </thead>

                        <tbody id="listaLicenciasAgua_estadocuenta_rn">
                          <!-- Aqui Aparecen el estado de cuenta Agua-->
                        </tbody>
                        
                      </table>
                    </div>

                  <table class="table-container" id="segundaTabla_agua_rn">
                    
                    <tbody>
                      <th class="text-right td-round total_c" style="width:180px;">Total Deuda =</th>
                      <th class="text-center td-round" style="width:50px;"></th>
                      <th class="text-center td-round" style="width:50px;"></th>
                      <th class="text-center td-round" style="width:50px;"></th>
                      <th class="text-center" style="width:50px;"></th>
                      <th class="text-center" style="width:50px;"></th>
                      <th class="text-center" style="width:20px;" id="va" ></th>
                    </tbody>  
                          
                    
                  </table>


                  <div class="form-group row" >
                            <div class="col-md-12" style="display: flex; justify-content: space-end; align-items: center;">
                               
                                <button type="button" class="btn btn-primary  btn-sm" id="popimprimir_aguan" data-target="#Modalimprimir_cuentaaguan">Imprimir notificacion</button>
                            </div>


                            </div>

                




                       

    
                      </div>

                
                      <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="far fa-times-circle"></i> Cancelar
                    </button>

              

                    
                </div>

          

        </div>
    </div>
</div>
<!-- MODAL DE RECONEXION FIN -->





<!-- MODAL DE RECONEXION -->
<div id="modalReconectarAgua" class="modal fade modal-forms fullscreen-modal" tabindex="-1" role="dialog" aria-labelledby="modalEditarNotificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

           
                <!-- Modal Header -->  
                <div class="modal-header" style="background-color: #3c8dbc; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                    <h4 class="modal-title" > Reconexión agua</h4>
                </div>

               <input type="text" id="inputLicencia"  >
                <input type="text" id="totalPagado"  >


                <!-- Modal Body -->
                <div class="modal-body estado_cuentaAgua_mostrar">
                    <div class="row divDetallePredioR">
                      <table class="table-container miprimeratabla_agua_r" id="primeratabla_agua_r">
                        <thead>
                          <tr>
                            <th class="text-center" style="width:30px;">Cod.</th>
                            <th class="text-center" style="width:50px;">Servicio</th>
                            <th class="text-center" style="width:50px;">Año</th>
                            <th class="text-center" style="width:50px;">Periodo</th>
                            <th class="text-center" style="width:50px;">Importe</th>
                            <th class="text-center" style="width:50px;">Gastos</th>
                            <th class="text-center" style="width:50px;">Subtotal</th>
                            <th class="text-center" style="width:50px;">Desc.</th>
                            <th class="text-center" style="width:50px;">Total</th>
                            <th class="seleccionado text-center" style="width:20px;">S</th>
                          </tr>
                        </thead>

                        <tbody id="listaLicenciasAgua_estadocuenta_r">
                          <!-- Aqui Aparecen el estado de cuenta Agua-->
                        </tbody>

                     
                      </table>
                    </div>

                     
                  <table class="table-container" id="segundaTabla_agua_r">
                    
                    <tbody>
                      <th class="text-right td-round total_c" style="width:180px;">Total Deuda =</th>
                      <th class="text-center td-round" style="width:50px;"></th>
                      <th class="text-center td-round" style="width:50px;"></th>
                      <th class="text-center td-round" style="width:50px;"></th>
                      <th class="text-center" style="width:50px;"></th>
                      <th class="text-center" style="width:50px;"></th>
                      <th class="text-center" style="width:20px;" id="va" ></th>
                    </tbody>  
                          
                    
                  </table>


                 
                   <div class="form-group row" style=" padding: 10px; border: 1px dotted #999793;" >

                    <div class="form-group row" >
                            <div class="col-md-12" style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Cuotas de pago y Fechas de vencimiento</span>
                                <button type="button" class="btn btn-primary  btn-sm" id="popimprimir_aguan" data-target="#Modalimprimir_cuentaaguan">Imprimir notificacion</button>
                            </div>


                            </div>
                    
                        <div class="col-md-4">
                        <label for="estadoNo" class="col-md-6 col-form-label">¿Cómo lo pagó?</label>
                        <div class="col-md-6">


                          <select class="form-control" id="estadoNo" name="estadoNo">
                            <option value="" selected>Seleccionar</option> <!-- Opción predeterminada -->

                            <?php
                            // Obtener los tipos de pago
                            $tipoPago = ControladorNotificacion::ctrMostrarTipoPagoNo();

                            // Iterar sobre los tipos de pago y mostrar las opciones
                            foreach ($tipoPago as $tipo_pago) {
                                // Obtener el nombre de pago
                                $nombrePago = $tipo_pago['Nombre_Pago'];

                                // Mostrar las opciones basadas en el nombre del pago
                                if ($nombrePago === 'Todo') {
                                    // Si es 'Todo', no debe ser seleccionado por defecto
                                    echo "<option value='" . $tipo_pago['Id_Notificacion_t_Pago'] . "'>" . $nombrePago . "</option>";
                                } elseif ($nombrePago === 'Particionado') {
                                    // Si es 'Particionado', no debe ser seleccionado por defecto
                                    echo "<option value='" . $tipo_pago['Id_Notificacion_t_Pago'] . "'>" . $nombrePago . "</option>";
                                } else {
                                    // Para otros valores, se agregan sin seleccionarse por defecto
                                    echo "<option value='" . $tipo_pago['Id_Notificacion_t_Pago'] . "'>" . $nombrePago . "</option>";
                                }
                            }
                            ?>
                        </select>




                        </div>
                    </div>

                      <div class="col-md-3 pagoTodo" style="display: none;">
                        <label for="estadoN" class="col-md-7 col-form-label">Nro proveido: </label>
                       <div class="col-md-5">
                                <input type="text" style="width: 60px;" id="numeroProveido" name="numeroProveido">
                            </div>
                    </div>

                     <div class="col-md-5 pagoTodo" style="display: none;">
                        <label for="ReconectarTotal" class="col-md-6 col-form-label">Reconexión de agua: </label>
                        <div class="col-md-6">
                            <select class="form-control" id="ReconectarTotal" name="ReconectarTotal">
                                <option value=" ">Seleccionar</option>
                                <option value="R">Reconectar</option>
                            </select>
                        </div>
                    </div>


                 


                        </div>






                        <div class="pagaParticion" style="padding: 10px; border: 1px dotted #999793; display: none; " >
                            <div class="form-group row" >
                              <div class="col-md-12">
                              <p>Cuotas de pago y Fechas de vencimiento</p>
                                </div>
                            </div>

                              <div class="form-group row" style="margin-bottom: 4px;">
                    
                                 <div class="col-md-3">
                                  <label for="estadoN" class="col-md-12 col-form-label">Cantidad cuotas</label>

                                  </div>

                                  <div class="col-md-3">
                                   
                                           <select class="form-control" id="estadoC" name="estadoC">
                                              <option value="">Seleccionar</option> <!-- Sin "selected", no se selecciona automáticamente -->
                                              <?php
                                              $tipoPago = ControladorNotificacion::ctrMostrarCuotas();
                                              foreach ($tipoPago as $tipo_pago) {
                                                  // Verifica si el nombre del pago es "Todo" o "Particionado"
                                                  $nombrePago = $tipo_pago['Nombre_cuota'];
                                                  $ncantidadCuota = $tipo_pago['cantidad'];
                                                  if ($nombrePago === 'Todo') {
                                                      echo "<option value='" . $tipo_pago['cantidad'] . "'>" . $ncantidadCuota . '</option>';
                                                  } elseif ($nombrePago === 'Particionado') {
                                                      echo "<option value='" . $tipo_pago['cantidad'] . "'>" . $ncantidadCuota . " " . $nombrePago . '</option>';
                                                  } else {
                                                      echo "<option value='" . $tipo_pago['cantidad'] . "'>" . $ncantidadCuota . " "  .  $nombrePago . '</option>';
                                                  }
                                              }
                                              ?>
                                            </select>

                              </div>

                 

                             
                             </div>

                            

                          <div class="form-group row cuotas" id="cuotasPago"  >

                           
                                    
                              </div>


                          


                       


                               





                        </div>

                       

    
                      </div>

                
                      <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="far fa-times-circle"></i> Cancelar
                    </button>

                  <button type="button" class="btn btn-primary" id='btnGuardarReconexion'>
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>

                    
                </div>

          

        </div>
    </div>
</div>
<!-- MODAL DE RECONEXION FIN -->



<!-- modal de imprimir DEUDA NOTIFICADA-->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_cuentaaguan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhereagua">
          <iframe id="iframe_aguano" class="iframe-full-height"></iframe>
          <!-- Muestra el estado de cuenta de Agua-->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de imprimir estado de cuenta agua-->


<!-- modal de imprimir DEUDA NOTIFICADA-->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_cuentaaguas" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhereagua">
          <iframe id="iframe_aguas" class="iframe-full-height"></iframe>
          <!-- Muestra el estado de cuenta de Agua-->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de imprimir estado de cuenta agua-->
<!-- MODAL ELIMINAR NOTIFICACIÓN -->
<div class="modal fade" id="modalEliminarNotificacion" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            <i class="bi bi-exclamation-circle" style="color: red; font-size: 48px;"></i>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            <input type="text" id="idNotificacionEliminar" name="idNotificacionEliminar" hidden>
             <h3>¿Estás seguro de que deseas eliminar esta notificación?</h3>
            <p>Esta acción no puede deshacerse.</p>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <!-- Botón de confirmación de eliminación -->
        <button type="button" class="btn btn-primary" id="btnEliminarNotificacion">Sí, Eliminar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL ELIMINAR NEGOCIO IND -->



<!-- MODAL PAGAR TODO -->
<div class="modal fade" id="modalPagarTodo" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            <i class="bi bi-exclamation-circle" style="color: red; font-size: 48px;"></i>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            
             <h3>Pagar toda la deuda</h3>
            <p>Se eligió la opción pago único</p>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <!-- Botón de confirmación de eliminación -->
    
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PAGAR TODO -->




<!-- MODAL PAGAR POR PARTICIONES -->

<div class="modal fade" id="modalPagarParticiones" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            <i class="bi bi-exclamation-circle" style="color: red; font-size: 48px;"></i>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            
             <h3>Debe selecionar estado de cuenta pagados </h3>
            <p>Se eligió la opción pago por particion</p>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <!-- Botón de confirmación de eliminación -->
    
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PAGAR POR PARCIONES -->



<!-- Modal Permisos -->
<div class="modal fade" id="modalPermiso" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Permisos a Paginas</h5>

      </div>
      <div class="col-md-12 text-center"><span class="usuario_permiso"></span> con DNI:<span class="dni_permiso"></span></div>
      <div class="modal-body permiso_pagina">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary guardar_permisos">Guardar</button>
      </div>
    </div>
  </div>
</div>



<div class="resultados"></div>