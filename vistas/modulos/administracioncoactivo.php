<?php

use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorPredioLitigio;

?>
<?php
$idParam = $_GET['id'];
$anio_propietario = $_GET['anio'];
// Divide el valor en un array utilizando el guion (-) como delimitador
$idArray = explode('-', $idParam);
// Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
$idArray = array_filter($idArray);
// Ahora $idArray contiene los valores sin guiones
?>

<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">
    <div class="box container-fluid" style="border:0px; margin-bottom:3px; padding:0px;">


    
    <div class="progress" style="width: 100%; height: 10px; border: 0; margin: 0;">
    <?php
        // Capturar datos del contribuyente una sola vez
        $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);

      
      
       
        // Inicializar el porcentaje
        $porcentaje = 0;
        $color = '#ccc'; // Color por defecto

        // Verificar si los datos del contribuyente están disponibles
        // Verificar si los datos del contribuyente están disponibles
          if (count($datos_contribuyente) > 0) {
            // Solo mostrar una vez la barra de progreso
            foreach ($datos_contribuyente as $contribuyentes) {
                foreach ($contribuyentes as $contribuyente) {
                    // Asignar el valor de Estado_progreso
                    $estado_progreso = $contribuyente['Estado_progreso'];

                    // Asignar el porcentaje y color según el estado
                    if ($estado_progreso === 'P') {
                        $porcentaje = 30;
                        $color = 'rgb(255, 193, 7)';
                    } elseif ($estado_progreso === 'E') {
                        $porcentaje = 60;
                        $color = 'rgb(23, 162, 184)';
                    } elseif ($estado_progreso === 'C') {
                        $porcentaje = 100;
                        $color = 'rgb(40, 167, 69)';
                    } elseif ($estado_progreso === NULL) {
                        $porcentaje = 0;
                        $color = '#ccc';
                    }

                    // Salir del loop después de obtener el primer valor
                    break 2;
                }
            }
          }

              ?>

     

</div>



     
    <div class="col-lg-7 col-xs-7 "  >
        <?php
       // $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);
        if (count($datos_contribuyente) > 0) {
        ?>

          <table class="miTabla_propietarios " style=" margin-bottom: 0.3rem;">
         
            <thead>
              <th class="text-center">Codigo</th>
              <th class="text-center">Documento</th>
              <th class="text-center">Nombres</th>
              <th class="text-center">Direccion</th>
              <th class="text-center">Carpeta</th>
              <th class="text-center">Accion</th>
            </thead>
            <tbody id="id_propietarios">
              <?php foreach ($datos_contribuyente as $valor => $filas) {
                foreach ($filas as $fila) {

                  //BACKGROUN PARA FALLECIDO
                  $backgroundColor = $fila['Fallecida'] == 1 ? 'background-color: #333b40; color:rgb(224, 232, 236);' : ''; 

                  echo '<tr id="fila" id_contribuyente="' . $fila['Id_Contribuyente'] . '">
                      <td class="text-center" style="' . $backgroundColor . '" >' . $fila['Id_Contribuyente'] . '</td>
                      <td class="text-center" style="' . $backgroundColor . '" >' . $fila['Documento'] . '</td>
                      <td class="text-center" style="' . $backgroundColor . '" >' . $fila['Nombre_Completo'] . '</td>
                      <td class="text-center" style="' . $backgroundColor . '" >' . $fila['Direccion_completo'] . '</td>
                      <td style="display:none" class="text-center"  style="' . $backgroundColor . '" >' . $fila['Telefono'] . '</td>
                      <td class="text-center" id="carpeta_contribuyente" id_carpeta="' . $fila['Codigo_Carpeta'] . '">' . $fila['Codigo_Carpeta'] . '</td>
                     <td class="text-center">
                    <span class="link btnEditarcontribuyente " 
                        title="Editar" 
                        idContribuyente="' . $fila['Id_Contribuyente'] . '" 
                        idDireccionnu="' . $fila['Id_Ubica_Vias_Urbano'] . '" 
                        data-toggle="modal" 
                        data-target="#modalEditarcontribuyente">
                    Editar
                  </span> | 
 
                      <span class=" btnEliminarcontribuyente text-danger" 
                            title="Eliminar" 
                            idContribuyente="' . $fila['Id_Contribuyente'] . '" 
                            idDireccionnu="' . $fila['Id_Ubica_Vias_Urbano'] . '" 
                            data-toggle="modal" 
                            data-target="#modalEliminarcontribuyente">
                        Eliminar
                      </span>
                    </td>

                      
                      
                      ';
               
                    }
              }
              ?>
            <tbody>
          </table>

      </div>

      <div class="col-lg-5 col-xs-5" style="display: flex; flex-direction: row; justify-content: center; align-items: center; padding-top: 2rem; ">

          <button class="btn btn-secondary btn-sm btn-1" id="volver_administracion_co" style="margin-right: 1rem;">
            <i class="bi bi-box-arrow-left"></i> Volver
        </button>


        </div>







      

    </div>


    
  </section>


  <section class="container-fluid panel-medio">
    <div class="box rounded">
      <div class="box-body table-user">
        <div class="row">
          <div class="col-md-7 table-responsive">
            <div class="row divDetallePredio">
              <div class="col-mod-12">
                <span class="caption_">Predios del Contribuyente</span>
                <div class="row pull-right">
                  <input type="hidden" id="perfilOculto_p" value="<?php echo $_SESSION['perfil'] ?>">

                  <select class="busqueda_filtros" id="selectnum" name="selectnum">
                    <?php
                    $anio = ControladorPredio::ctrMostrarDataAnio();
                    foreach ($anio as $data_anio) {
                      $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                      echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <br>
              
              <table class="table-container" id="tablalistapredios">
                <thead>
                  <tr>
                    <!-- <th class="text-center">N°</th> -->
                    <th class="text-center" style="width: 3rem;"> </th>
                    <th class="text-center" style="width: 3rem;">Tipo</th>
                    <th class="text-center">Ubicacion del Predio</th>
                    <th class="text-center" style="display:none;">Id.Catastro</th>
                    <th class="text-center">A.Terreno</th>
                    <th class="text-center">A.Const.</th>
                    <th class="text-center">Val.Predio</th>
                    <th class="text-center" style="width: 3rem;"></th>
                    <!-- <th class="text-center">Foto</th> -->
                  </tr>
                </thead>
                <tbody class='body-predio'>
                  <?php
                  $listaPredio = ControladorPredio::ctrListarPredio($idArray, $anio_propietario);
                  ?>
                </tbody>
              </table>

              <div style="margin-top: 4rem ;">
              <span class="caption_" >Predios transferidos</span>
              </div>

              <table class="table-container" id="tablalistapredios">
                <thead>
                  <tr>
                    <th class="text-center"  style="background-color: rgb(149, 153, 161)  !important; ">N°</th>
                    <th class="text-center" style="background-color:rgb(149, 153, 161) !important; ">Tipo</th>
                    <th class="text-center" style="background-color: rgb(149, 153, 161)  !important; ">Ubicacion del Predio</th>
                    <th class="text-center" style="display:none;">Id.Catastro</th>
                    <th class="text-center" style="background-color: rgb(149, 153, 161)  !important; ">A.Terreno n</th>
                    <th class="text-center" style="background-color: rgb(149, 153, 161)  !important; ">A.Const.</th>
                    <th class="text-center"style="background-color: rgb(149, 153, 161)  !important; ">Val.Predio</th>
                    <th class="text-center" style="background-color: rgb(149, 153, 161)  !important; ">Detalle</th>
                  </tr>
                </thead>
               
                
                <tbody class='body-predio-historial'>
                  <?php
                  $listaPredio = ControladorPredio::ctrListarPredio_historial($idArray, $anio_propietario);
                  ?>
                </tbody>


              </table>


            </div>
            <label class="bltp" id="countpredio"></label>


            <!--======== CONTADOR PREDIOS ===========-->
            <div class="row">

                <div class="col-md-1">
                  <img src="./vistas/img/iconos/deuda.png" class="t-icon-tbl-imprimir" id="abrirEstadoCuenta" data-target="#modalEstadoCuenta" title="Estado Cuenta">
                </div>        

                <div class="col-md-1">
                  <img src="./vistas/img/iconos/pagos_.png" class="t-icon-tbl-imprimir" id="abrirPagosImpuestoArbitrios" data-target="#modalPagosImpuestoArbitrios" title="Pagos Impuesto Arbitrios">
                </div>

               <!-- ANEXO 01 --> 
                <div class="col-md-1">
                    <img src="./vistas/img/iconos/imagen1r.png" class="t-icon-tbl-imprimir" id="abrirCartaRecordatorio" data-target="#modalCartaRecordatorio" title=" Formato de carta recordatoria de pago ">
                </div>
                 <!-- ANEXO 02 --> 
                 <div class="col-md-1">
                    <img src="./vistas/img/iconos/formato2r.png" class="t-icon-tbl-imprimir" id="abrirRequerimientoPago" data-target="#modalRequerimientoPago" title="Formato de requerimiento de pago">
                </div>

                 <!-- ANEXO 03 --> 
                 <div class="col-md-1">
                    <img src="./vistas/img/iconos/formato3r.png" class="t-icon-tbl-imprimir" id="abrirEsquelaCobranza" data-target="#modalEsquelaCobranza" title="Formato de esquela de cobranza ">
                </div>

                 <!-- ANEXO 04 --> 

                <div class="col-md-1">
                    <img src="./vistas/img/iconos/formato4r.png" class="t-icon-tbl-imprimir" id="abrirGestionDomiciliaria" data-target="#modalGestionDomiciliaria" title=" Formato de acta de visita en una gestión domiciliaria ">
                </div>

                <!-- ANEXO 05 --> 
                <div class="col-md-1">
                    <img src="./vistas/img/iconos/formato5r.png" class="t-icon-tbl-imprimir" id="abrirCobranzaTelefonica" data-target="#modalCobranzaTelefonica" title="Formatos de “speech” de cobranza telefónica">
                </div>
                
                <!-- ANEXO 06 --> 
                <div class="col-md-1">
                  <img src="./vistas/img/iconos/orden_pago.png" class="t-icon-tbl-imprimir" id="abrirOrdenPago" data-target="#modalOrdenPago" title=" Formato de orden de pago ">
                </div>

                <!-- ANEXO 07 --> 
                <div class="col-md-1">
                    <img src="./vistas/img/iconos/formato7r.png" class="t-icon-tbl-imprimir" id="abrirResoDeter" data-target="#modalResolucionDeterminacion" title="Formato de Resolución de Determinación ">
                </div>

                <!-- ANEXO 08 --> 
                <div class="col-md-1">
                    <img src="./vistas/img/iconos/formato8r.png" class="t-icon-tbl-imprimir" id="abrirResoMulta" data-target="#modalResolucionMulta" title="Formato de Resolución de Multa ">
                </div>

                <!-- ANEXO 09 --> 
                <div class="col-md-1">
                  <img src="./vistas/img/iconos/frados.png" class="t-icon-tbl-imprimir" id="abrirPerFraccio" data-target="#modalPerdidaFraccionamiento" title="Formato de resolución de pérdida de fraccionamiento  ">
                </div>

                <!-- ANEXO 10 --> 
                 <div class="col-md-1">
                  <img src="./vistas/img/iconos/fratres.png" class="t-icon-tbl-imprimir" id="abrirFraccionadoDeuda" data-target="#modalFraccionadoDeuda" title=" Formato de solicitud de fraccionamiento de deuda ">
                </div>
              
             
             </div>

            <div class="row">

               <!-- ANEXO 11 --> 
                 <div class="col-md-1">
                  <img src="./vistas/img/iconos/frauno.png" class="t-icon-tbl-imprimir" id="abrirAproFraccion" data-target="#modalAprobacionFracciona" title="Resolución de aprobación de un fraccionamiento  ">
                </div>

                <!-- ANEXO 12 --> 
                <div class="col-md-1">
                    <img src="./vistas/img/iconos/formato12r.png" class="t-icon-tbl-imprimir" id="abrirConcentidaDeuda" data-target="#modalConcentidaDeuda" title="Formato de constancia de haber quedado consentida la deuda para el inicio del proceso coactivo">
                </div>


                <!-- ANEXO 13 --> 
                  <div class="col-md-1">
                    <img src="./vistas/img/iconos/icono_coactivo.png" class="t-icon-tbl-imprimir" id="abrirEstadoCoactivo" data-target="#modalEstadoCuentaC" title="Coactivo">
                </div>


                <!-- ANEXO 14 --> 
                <div class="col-md-1">
                  <img src="./vistas/img/iconos/sentenciadoce.png" class="t-icon-tbl-imprimir" id="abrirResolucionDOS" data-target="#modalrResolucionAcumulacionDOS" title="Resolución Ejecución Coactiva DOS por acumulación ">
                </div>

              
                <!-- ANEXO 15 --> 
                <div class="col-md-1">
                  <img src="./vistas/img/iconos/vehicular15.png" class="t-icon-tbl-imprimir" id="abrirResolucionDOSVehi" data-target="#modalResolucionVehicular" title="Resolución Ejecución Coactiva DOS. Por acumulación y/o ejecución, trabando Medida Cautelar en forma de secuestro conservativo y/o inscripción vehicular  ">
                </div>

                <!-- ANEXO 16 --> 
                <div class="col-md-1">
                  <img src="./vistas/img/iconos/ejecucionCoactivo15.png" class="t-icon-tbl-imprimir" id="abrirResolucionDOSIm" data-target="#modalResolucionInmueble" title="Resolución Ejecución Coactiva DOS. Por acumulación y/o ejecución, trabando Medida Cautelar en forma de inscripción de inmueble  ">
                </div>

                <!-- ANEXO 17 --> 
                <div class="col-md-1">
                  <img src="./vistas/img/iconos/medidacutelar16.png" class="t-icon-tbl-imprimir" id="abrirResolucionDOSMedidaCau" data-target="#modalrResolucionAcumulacionEjecucion" title="Resolución Ejecución Coactiva DOS por acumulación y/o ejecución. trabando Medida Cautelar en forma de retención  ">
                </div>

                <!-- ANEXO 18 --> 
                <div class="col-md-1">
                  <img src="./vistas/img/iconos/formato18r.png" class="t-icon-tbl-imprimir" id="abrirResoSuspencion" data-target="#modalFormatoSuspencion" title="Resolución Ejecución Coactiva DOS por acumulación y/o ejecución. trabando Medida Cautelar en forma de retención  ">
                </div>

                <!-- ANEXO 19 --> 
                  <div class="col-md-1">
                  <img src="./vistas/img/iconos/formato19r.png" class="t-icon-tbl-imprimir" id="abrirTerceraPropiedad" data-target="#modalTerceraPropiedad" title="Resolución Ejecución Coactiva DOS por acumulación y/o ejecución. trabando Medida Cautelar en forma de retención  ">
                </div>

                <!-- ANEXO 20 --> 
                <div class="col-md-1">
                  <img src="./vistas/img/iconos/formato20r.png" class="t-icon-tbl-imprimir" id="abrirResoNotiValores" data-target="#modalNotificacionValores" title="Resolución Ejecución Coactiva DOS por acumulación y/o ejecución. trabando Medida Cautelar en forma de retención  ">
                </div>

                <!-- ANEXO 21 --> 
                <div class="col-md-1">
                  <img src="./vistas/img/iconos/formato21r.png" class="t-icon-tbl-imprimir" id="abrirResoCargaNotifi" data-target="#modalCargoNotificiacion" title="Resolución Ejecución Coactiva DOS por acumulación y/o ejecución. trabando Medida Cautelar en forma de retención  ">
                </div>

            </div>


          </div>
          <!--DETALLE PREDIOS - PISOS-->
          <div class="col-md-5 table-responsive">
            <div class="row divDetallePredio">
              <table class="table-container" id="listaDePisosContainer">
                <caption>Lista de Pisos</caption>
                <thead>
                  <tr>
                    <th class="text-center">Catastro</th>
                    <th class="text-center">N° Piso</th>
                    <th class="text-center">A.Const.</th>
                    <th class="text-center">Val.Const.</th>
                    <th class="text-center">Val.Edifica</th>
                  </tr>
                </thead>
                <tbody id="listaPisos">
                </tbody>
                <!-- Aqui Aparecen los Pisos del Predio-->
              </table>
            </div>
            <div class="row">
              <br>
              <!-- Boton Casita Registrar Piso-->
              <div class="col-md-1">
                <img src="./vistas/img/iconos/nuevo_piso.png" class="t-icon-tbl-imprimir" id="btnAbrirRegistrarPiso" data-target="#modalAgregarPiso" title="Nuevo Piso"></img>
              </div>
              <!-- Boton Tarjeta Editar-->
              <div class="col-md-1">
                <img src="./vistas/img/iconos/editar.png" class="t-icon-tbl-imprimir" id="btnAbrirEditarPiso" data-target="#modalEditarPiso" title="Editar Piso"></img>
              </div>
              <!-- Boton Eliminar Piso -->
              <div class="col-md-1">
                <img src="./vistas/img/iconos/delete.png" class="t-icon-tbl-imprimir" id="btnEliminarPiso" title="Eliminar Piso"></img> <!-- data-toggle="modal" -->
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>

</div>
</section>
</div>












<!--INICIO MODAL CUANOD EL COACTIVO ESTA VACIO-->
<div class="modal fade" id="modal_vacio_coactivo" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
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
          
          <h7> Al menos debe elegir una fila <span id="anio_formato"><!-- CONTENIDO DINAMICO--></span></h7>
        </div>

      </div>



      </div>
      <div class="modal-footer" style=" display: flex; justify-content: center; align-items: center;">
    <button type="button" class="btn btn-primary print_orden_coactivo_aviso">OK</button>
</div>


    </div>
  </div>
</div>

<!-- END MODAL CUANOD EL COACTIVO ESTA VACIO-->



<!--FROMULARIO DE ANEXO 01-->
<div class="modal fade" id="modal_formulario_carta" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
        <div class="row">
          <div class="col-lg-4">
            <label for="tipoTributario">Tipo Tributario:</label>
            <select class="form-control" id="tipoTributario" name="tipoTributario">
              <option value="">Seleccione tipo tributario</option>
              <option value="tributario">Tributario</option>
              <option value="no tributario">No tributario</option>
            </select>
          </div>
           <div class="col-lg-2">
            <label for="numeroCuota">Número de Cuota:</label>
            <input type="number" class="form-control" id="numeroCuota" name="numeroCuota" value="" placeholder="Ingrese número de cuota" />
          </div>
        

            <div class="col-lg-3">
            <label for="fechaVencimiento">Fecha Vencimiento:</label>
            <input type="date" class="form-control" id="fechaVencimiento" name="fechaVencimiento" value="" placeholder="Seleccione la fecha de vencimiento" />
          </div>
            <div class="col-lg-3">
            <label for="anioFiscal">Año Fiscal:</label>
            <select class="form-control" id="anioFiscalg" name="anioFiscalg">
              <option value="">Seleccione un año fiscal</option>
              <option value="2026">2026</option>
              <option value="2025">2025</option>
              <option value="2024">2024</option>
              <option value="2023">2023</option>
              <option value="2022">2022</option>
              <option value="2021">2021</option>
              <option value="2020">2020</option>
              <option value="2019">2019</option>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="2015">2015</option>
              <option value="2014">2014</option>
              <option value="2013">2013</option>
              <option value="2012">2012</option>
              <option value="2011">2011</option>
              <option value="2010">2010</option>
              <option value="2009">2009</option>
              <option value="2008">2008</option>
              <option value="2007">2007</option>
              <option value="2006">2006</option>
              <option value="2005">2005</option>
              <option value="2004">2004</option>
            </select>
          </div>

        </div>


     
      
      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_coactivo_aviso_ok">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 01-->


<!--FROMULARIO DE ANEXO 02-->
<div class="modal fade" id="modal_requerimiento_pago" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
     <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
     
        <div class="row mt-3">
          <div class="col-lg-2">
            <label for="numeroCuota2">Número de Cuota:</label>
            <input type="number" class="form-control" id="numeroCuota2" name="numeroCuota2" value="" placeholder="Ingrese número de cuota" />
          </div>
          <div class="col-lg-3">
            <label for="anioFiscal2">Año Fiscal:</label>
            <select class="form-control" id="anioFiscalg2" name="anioFiscalg2">
              <option value="">Seleccione un año fiscal</option>
              <option value="2026">2026</option>
              <option value="2025">2025</option>
              <option value="2024">2024</option>
              <option value="2023">2023</option>
              <option value="2022">2022</option>
              <option value="2021">2021</option>
              <option value="2020">2020</option>
              <option value="2019">2019</option>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="2015">2015</option>
              <option value="2014">2014</option>
              <option value="2013">2013</option>
              <option value="2012">2012</option>
              <option value="2011">2011</option>
              <option value="2010">2010</option>
              <option value="2009">2009</option>
              <option value="2008">2008</option>
              <option value="2007">2007</option>
              <option value="2006">2006</option>
              <option value="2005">2005</option>
              <option value="2004">2004</option>
            </select>
          </div>

            <div class="col-lg-2">
            <label for="periodo2">Periodo:</label>
            <select class="form-control" id="periodo2" name="periodo2">
              <option value="">Seleccione perido</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
             
            </select>
          </div>
           <div class="col-lg-2">
            <label for="plazoDias2">Plazo en dias:</label>
            <input type="number" class="form-control" id="plazoDias2" name="plazoDias2" value="" placeholder="Plazo en dias" />
          </div>

           <div class="col-lg-3">
            <label for="fechaVencimiento2">Fecha Vencimiento:</label>
            <input type="date" class="form-control" id="fechaVencimiento2" name="fechaVencimiento2" value="" placeholder="Seleccione la fecha de vencimiento" />
          </div>

        </div>





      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_2">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 02-->


<!--FROMULARIO DE ANEXO 03-->
<div class="modal fade" id="modal_esquela_cobranza" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
     <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
     
       
         <div class="row mt-3">
          <div class="col-xs-12">
            <label for="plazoDias3">Plazo en dias:</label>
            <input type="number" class="form-control" id="plazoDias3" name="plazoDias3" value="" placeholder="Plazo en dias" />
          </div>
        </div>



      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_3">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 03-->


<!--FROMULARIO DE ANEXO 07-->
<div class="modal fade" id="modal_resolucion_determinacion" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
     
       
         <div class="row mt-3">


          <div class="col-lg-3">
            <label for="baseImponible7">Base imp. fiscalizada</label>
            <input type="number" class="form-control" id="baseImponible7" name="baseImponible7" value="" placeholder="Plazo en dias" />
          </div>

           <div class="col-lg-3">
            <label for="montoFiscalizado7">Monto fiscalizada</label>
            <input type="number" class="form-control" id="montoFiscalizado7" name="montoFiscalizado7" value="" placeholder="Plazo en dias" />
          </div>
          
            <div class="col-lg-3">
            <label for="impuestoFiscalizado7">Impuesto fiscalizada</label>
            <input type="number" class="form-control" id="impuestoFiscalizado7" name="impuestoFiscalizado7" value="" placeholder="Plazo en dias" />
          </div>



        </div>



      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_7">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 07-->

<!--FROMULARIO DE ANEXO 08-->
<div class="modal fade" id="modal_resolucion_multa" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
     <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">

         <div class="row ">

           <div class="col-lg-3">
            <label for="docInfraccion8">Doc. de infraccion</label>
            <input type="text" class="form-control" id="docInfraccion8" name="docInfraccion8" value="" placeholder="EJ: DOC-INFRACCION" />
          </div>

        
 

        </div>

         <div class="row " style="margin-top: 10px;">
          <div class="col-lg-12">
            <p>lIQUIDACION DE MULTA TRIBUTARIA</p>

          </div>
          </div>

         <div class="row ">


          <div class="col-lg-6">
            <label for="fechaInfraccion8">Fecha de infraccion</label>
            <input type="date" class="form-control" id="fechaInfraccion8" name="fechaInfraccion8" value=""  />
          </div>

           <div class="col-lg-6">
            <label for="baseImponible8">Base imponible</label>
            <input type="number" class="form-control" id="baseImponible8" name="baseImponible8" value="" placeholder="EJ: 45254.85" />
          </div>
         
         
 

        </div>



    
         <div class="row">

           <div class="col-lg-3">
            <label for="sansion8">Sanción (%)</label>
            <input type="number" class="form-control" id="sansion8" name="sansion8" value="" placeholder="EJ: 10" min="0" max="100" step="0.01" />
          </div>


           <div class="col-lg-3">
            <label for="montoInsoluto8">Monto insoluto</label>
            <input type="number" class="form-control" id="montoInsoluto8" name="montoInsoluto8" value="" placeholder="EJ: 200.00" />
          </div>

          <div class="col-lg-3">
            <label for="interesMoratorio8">Interes moratorio</label>
            <input type="number" class="form-control" id="interesMoratorio8" name="interesMoratorio8" value="" placeholder="EJ: 20" />
          </div>

          <div class="col-lg-3">
            <label for="total8">Total</label>
            <input type="number" class="form-control" id="total8" name="total8" value=""   />
          </div>

        </div>

        
      </div>


      

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_8">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 08-->



<!--FROMULARIO DE ANEXO 09-->
<div class="modal fade" id="modal_perdida_fracciona" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
      <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
     
        <div class="row">

         
          <div class="col-lg-4">
            <label for="numeroResolucion109">Número de resolución:</label>
            <input type="number" class="form-control" id="numeroResolucion109" name="numeroResolucion109" value="" placeholder="EJ: 001-2025 GAT" />
          </div>
     

          <div class="col-lg-4">
            <label for="numeroSolicitud09">Número de solicitud:</label>
            <input type="number" class="form-control" id="numeroSolicitud09" name="numeroSolicitud09" value="" placeholder="EJ: 007-2025 GAT"  />
          </div>
        

          <div class="col-lg-4">
            <label for="numeroResolucion209">Número de resolucion:</label>
            <input type="number" class="form-control" id="numeroResolucion209" name="numeroResolucion209" value="" placeholder="EJ: 004-2025 GAT" />
          </div>


        </div>

     
     <div class="row">

      
          <div class="col-lg-4">
            <label for="fechaFraccionamiento09">Fecha fraccionamiento:</label>
            <input type="date" class="form-control" id="fechaFraccionamiento09" name="fechaFraccionamiento09" value="" placeholder="Seleccione la fecha de vencimiento" />
          </div>
     
          <div class="col-lg-4">
            <label for="fechaAprobacion09">Fecha aprobacion:</label>
            <input type="date" class="form-control" id="fechaAprobacion09" name="fechaAprobacion09" value="" placeholder="Seleccione la fecha de vencimiento" />
          </div>
     </div>

      

        <!-- Tabla con 4 campos input -->
    <div class="row" style="margin-top: 20px;">
      <div class="col-lg-12">
        <table class="table table-bordered" id="tabla-deuda">
          <thead>
            <tr>
              <th>N° cuota</th>
              <th>Documento de deuda</th>
              <th>Fecha vencimiento</th>
              <th>Monto total</th>
          
            </tr>
          </thead>
          <tbody>
            
            <tr>
              <td><input type="number" class="form-control" name="nCouta" id="nCouta" placeholder="EJ: 1"></td>
              <td><input type="text" class="form-control" name="DocDeuda" id="DocDeuda" placeholder="EJ:DOC-002"></td>
              <td><input type="date" class="form-control" name="fechaVencimiento" id="fechaVencimiento" placeholder="Ingrese fecha ven"></td>
              <td><input type="number" class="form-control" name="montoTotal" id="montoTotal" placeholder="EJ: 2055.20"></td>
              <td style="text-align: center;"></td>
            </tr>
            

          </tbody>
        </table>
        <button type="button" class="btn btn-success agregar-fila">+ Agregar fila</button>
      </div>
    </div>


      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_9">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 09-->


<!--FROMULARIO DE ANEXO 11-->
<div class="modal fade" id="modal_aprobacion_fracciona" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
      <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
     
        <div class="row">

          <div class="col-lg-5">
            <label for="numeroFraccionado11">N° de solicitud fraccionado:</label>
            <input type="text" class="form-control" id="numeroFraccionado11" name="numeroFraccionado11" value="" placeholder="EJ: 001-2025 GAT " />
          </div>

          

          <div class="col-lg-5">
            <label for="numeroConvenio11">N° de convenio fraccionado:</label>
            <input type="text" class="form-control" id="numeroConvenio11" name="numeroConvenio11" value="" placeholder="EJ: 002-2025 GAT " />
          </div>

           <div class="col-lg-2">
            <label for="numeroCuotas11">N°cuotas:</label>
            <input type="number" class="form-control" id="numeroCuotas11" name="numeroCuotas11" value="" placeholder="EJ: 1" />
          </div>

            
     
        </div>

      

      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_11">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 11-->


<!--FROMULARIO DE ANEXO 12-->
<div class="modal fade" id="modal_concentida_deuda" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
      <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
   
        <!-- Tabla con 4 campos input -->
        <div class="row" style="margin-top: 20px;">
          <div class="col-lg-12">
            <table class="table table-bordered" id="consentida-deuda">
              <thead>
                <tr>
                  <th>Detalle de los documentos</th>
       
                </tr>
              </thead>
              <tbody>
                
                <tr>
                  <td><input type="text" class="form-control" name="detalleFraccionamiento12" id="detalleFraccionamiento12" placeholder="Ingrese cuota"></td>
                
                  <td style="text-align: center;"></td>
                </tr>
                

              </tbody>
            </table>
            <button type="button" class="btn btn-success agregar-fila-concentido">+ Agregar fila</button>
          </div>
        </div>


      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_12">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 12-->



<!--FROMULARIO DE ANEXO 14-->
<div class="modal fade" id="modal_coactiva_dos" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
      <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
     
        <div class="row">
           <div class="col-lg-5">
            <label for="numeroExpediente14">Número de expedientes:</label>
            <input type="number" class="form-control" id="numeroExpediente14" name="numeroExpediente14" value="" placeholder="Ingrese número de cuota" />
          </div>
         <div class="col-lg-7">
            <label for="expedientes14">Expedientes:</label>
            <input type="number" class="form-control" id="expedientes14" name="expedientes14" value="" placeholder="Ingrese número de cuota" />
          </div>
         
     
        </div>

       


      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_14">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 14-->
                    
<!--FROMULARIO DE ANEXO 15-->
<div class="modal fade" id="modal_coactiva_dos_vehicular" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
      <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->

        <div class="row">
         <div class="col-lg-4">
            <label for="numeroExpediente15">Número de expediente:</label>
            <input type="text" class="form-control" id="numeroExpediente15" name="numeroExpediente15" value="" placeholder="EJ: 001-2025/GAT" />
          </div>

            <div class="col-lg-5">
            <label for="expedientes15">Expedientes acumulados:</label>
            <input type="text" class="form-control" id="expedientes15" name="expedientes15" value="" placeholder="EJ: 001-2025/GAT Y EJ: 005-2025/GAT" />
          </div>

            <div class="col-lg-3">
            <label for="placaRodaje15">Número de placa de rodaje:</label>
                <input type="text" class="form-control" id="placaRodaje15" name="placaRodaje15" value="" placeholder="EJ: AEF-717" />
              </div>
            </div>
        
     
        </div>
     
      

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_15">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 15-->

<!--FROMULARIO DE ANEXO 16 -->
<div class="modal fade" id="modal_coactiva_dos_inmueble" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
     <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
     
      
        <div class="row">
         <div class="col-lg-4">
            <label for="numeroExpediente0116">Número de expediente:</label>
            <input type="text" class="form-control" id="numeroExpediente0116" name="numeroExpediente0116" value="" placeholder="EJ: 005-2025/GAT" />
          </div>

           <div class="col-lg-6">
            <label for="expedientes16">Expedientes de acumulacion:</label>
            <input type="text" class="form-control" id="expedientes16" name="expedientes16" value="" placeholder="EJ: 005-2025/GAT Y 002-2025/RENTAS" />
          </div>

           <div class="col-lg-2">
            <label for="numeroPartida16">Nro partida:</label>
            <input type="text" class="form-control" id="numeroPartida16" name="numeroPartida16" value="" placeholder="EJ: P4514575" />
          </div>
     
     
        </div>
     
       
          
        


      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_16">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 16-->


<!--FROMULARIO DE ANEXO 17 -->
<div class="modal fade" id="modal_coactiva_dos_cautelar" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
      <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
     
      
        <div class="row">

     
          <div class="col-lg-4">
            <label for="numeroExpediente17">Número de expediente:</label>
            <input type="text" class="form-control" id="numeroExpediente17" name="numeroExpediente17" value="" placeholder="EJE. 254-2025/GAT" />
          </div>


           <div class="col-lg-6">
            <label for="expedientes17">Expedientes similares:</label>
            <input type="text" class="form-control" id="expedientes17" name="expedientes17" value="" placeholder="EJE. 111-2024/GAT y 222-2025/GAT" />
          </div>

          <div class="col-lg-1">
            <label for="dias17">Dias:</label>
            <input type="text" class="form-control" id="dias17" name="dias17" value="" placeholder="5" />
          </div>

       

     
        </div>
     
      

      



      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_17">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 17-->



<!--FROMULARIO DE ANEXO 18 -->
<div class="modal fade" id="modal_solicitud_suspencion" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
     <!-- Cabecera del Modal -->
      <!-- Cabecera del Modal -->
  <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>



      <div class="modal-body">
        <!-- Formulario de los campos -->
     
      
        <div class="row">
         <div class="col-lg-4">
            <label for="resolucionEjecucion18">Resolucion de ejecucion coactiva REC N°:</label>
            <input type="text" class="form-control" id="resolucionEjecucion18" name="resolucionEjecucion18" value="" placeholder="EJ: 001-2025 GAT" />
          </div>

           <div class="col-lg-4">
            <label for="resolucionMedida18">Resolucion de medida cautelar N°:</label>
            <input type="text" class="form-control" id="resolucionMedida18" name="resolucionMedida18" value="" placeholder="EJ: 0221-2025 GAT" />
          </div>

          <div class="col-lg-4">
            <label for="numeroDocumento18">Número de docuemento de deuda:</label>
            <input type="text" class="form-control" id="numeroDocumento18" name="numeroDocumento18" value="" placeholder="EJ: 4 DOC" />
          </div>


     
        </div>

           <div class="row">
              <div class="col-lg-4">
                  <p>Fundamento</p>
              </div>
         </div>
      
      <div class="row">
              <div class="col-lg-12">
         
        <div style="max-height: 400px; overflow-y: scroll;">
        <table border="1" style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr>
              <th style="position: sticky; top: 0; background-color: #0d4570; z-index: 1;">Estado</th>
              <th style="position: sticky; top: 0; background-color: #0d4570; z-index: 1;">Descripción</th>
              <th style="position: sticky; top: 0; background-color: #0d4570; z-index: 1;">Nro Expediente</th>
              <th style="position: sticky; top: 0; background-color: #0d4570; z-index: 1;">Nro Resolución</th>
              <th style="position: sticky; top: 0; background-color: #0d4570; z-index: 1;">Fecha</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox"  data-experiment="1">
              </td>
              <td>La deuda ha sido extinguida o la obligación ha sido cumplida. 1/ (Art. 16.1 inc. a)</td>
            </tr>

            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-experiment="2">
              </td>
              <td>La deuda u obligación está prescrita. 1/ (Art. 16.1, inc. b)</td>
              <td><input type="text"  placeholder="N° 001-2025 GAT"></td>
              <td><input type="number" disabled placeholder=""></td>
              <td><input type="date" ></td>
            </tr>

            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="El obligado es persona distinta. 1/ (Art. 16.1, inc. c)"></td>
              <td>El obligado es persona distinta. 1/ (Art. 16.1, inc. c)</td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="Se ha omitido notificar al obligado el acto administrativo que sirve de título para la ejecución. 1/ (Art. 16.1, inc. d)"></td>
              <td>Se ha omitido notificar al obligado el acto administrativo que sirve de título para la ejecución. 1/ (Art. 16.1, inc. d)</td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="Se encuentra en trámite un recurso administrativo, recurso impugnatorio de reclamación o demanda contenciosa administrativa presentado dentro del plazo establecido por ley o está pendiente de vencimiento el plazo para la presentación del mismo. 1/(Art. 16.1, inc. e y 31.1, inc. c)"></td>
              <td>Se encuentra en trámite un recurso administrativo, recurso impugnatorio de reclamación o demanda contenciosa administrativa presentado dentro del plazo establecido por ley o está pendiente de vencimiento el plazo para la presentación del mismo. 1/(Art. 16.1, inc. e y 31.1, inc. c)</td>
              <td><input type="text" placeholder=" " disabled></td>
              <td><input type="text"  placeholder="EJ: 001-2025 GAT"></td>
              <td><input type="date" disabled></td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="Existe convenio de liquidación judicial o extrajudicial, acuerdo de acreedores o declaración de quiebra. 1/(Art. 16.1, inc. f)"></td>
              <td>Existe convenio de liquidación judicial o extrajudicial, acuerdo de acreedores o declaración de quiebra. 1/(Art. 16.1, inc. f)</td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="Existe Resolución de fraccionamiento y/o aplazamiento. 1/ (Art. 16.1, inc. g)"></td>
              <td>Existe Resolución de fraccionamiento y/o aplazamiento. 1/ (Art. 16.1, inc. g)</td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="La empresa se encuentra en proceso de reestructuración patrimonial. 1/ (Art. 16.1, inc. h)"></td>
              <td>La empresa se encuentra en proceso de reestructuración patrimonial. 1/ (Art. 16.1, inc. h)</td>
              <td><input type="text" placeholder="" disabled></td>
              <td><input type="number" placeholder="" disabled></td>
              <td><input type="date" ></td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="Se ha cumplido con el pago de la obligación tributaria o no tributaria ante otra Municipalidad que se atribuye la misma competencia territorial. 1/ (Art. 16.1, inc. i y 31.1, inc. d)"></td>
              <td>Se ha cumplido con el pago de la obligación tributaria o no tributaria ante otra Municipalidad que se atribuye la misma competencia territorial. 1/ (Art. 16.1, inc. i y 31.1, inc. d)</td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="Existe mandato emitido por el Poder Judicial dentro de un proceso de amparo o contencioso administrativo o se ha dictado medida cautelar dentro o fuera del proceso contencioso administrativo. 1/ (Art. 16.2 y 31.4)"></td>
              <td>Existe mandato emitido por el Poder Judicial dentro de un proceso de amparo o contencioso administrativo o se ha dictado medida cautelar dentro o fuera del proceso contencioso administrativo. 1/ (Art. 16.2 y 31.4)</td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="Silencio positivo (Art. 16.4)"></td>
              <td>Silencio positivo (Art. 16.4)</td>
              <td><input type="text"  placeholder="EJ: 002-2025 GAT"></td>
              <td><input type="number" placeholder=" " disabled></td>
              <td><input type="date" name="fecha1811"></td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="Se ha presentado una demanda de revisión judicial. 1/ (Art. 23.3)"></td>
              <td>Se ha presentado una demanda de revisión judicial. 1/ (Art. 23.3)</td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="Existen anticipos o pagos a cuenta del mismo tributo realizados en exceso, que no se encuentran prescritos. (Art. 31.1, inc. a)"></td>
              <td>Existen anticipos o pagos a cuenta del mismo tributo realizados en exceso, que no se encuentran prescritos. (Art. 31.1, inc. a)</td>
            </tr>
            <tr>
              <td style="display: flex; justify-content: center; align-items: center;">
                <input type="checkbox" class="checkbox" data-description="Por decisión del Tribunal Fiscal, en mérito a la solicitud presentada por el administrado dentro de un recurso de queja. 1/ (Art. 31.1 inc. b)"></td>
              <td>Por decisión del Tribunal Fiscal, en mérito a la solicitud presentada por el administrado dentro de un recurso de queja. 1/ (Art. 31.1 inc. b)</td>
            </tr>
          </tbody>
        </table>
      </div>

        </div>
         </div>
                     


      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_18">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 18-->



<!--FROMULARIO DE ANEXO 19 -->
<div class="modal fade" id="modal_terceria_propiedad" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabecera del Modal -->
      <!-- Cabecera del Modal -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Asignar valores</h5>
      
      </div>

      <div class="modal-body">
        <!-- Formulario de los campos -->
     

        <div class="row">
         <div class="col-lg-4">
            <label for="resolucionEjecucion19">N° Expediente coactivo </label>
            <input type="text" class="form-control" id="resolucionEjecucion19" name="resolucionEjecucion19" value="" placeholder="EJ: 001-2025 GAT" />
          </div>

           <div class="col-lg-4">
            <label for="resolucionMedida19">N° Resolucion de medida cautelar </label>
            <input type="text" class="form-control" id="resolucionMedida19" name="resolucionMedida19" value="" placeholder="EJ: 002-2025 GAT" />
          </div>

        </div>

         <div class="row" style="margin-top: 10px;">
          <div class="col-lg-6">
              <label for="resolucionEjecucion19"> <strong> RESPECTO DEL BIEN AFECTADO POR LA MEDIDA CAUTELAR: </strong></label>
            
            </div>

        </div>
    
       <div class="row">
          <div class="col-lg-6">
              <div style="display: flex; flex-direction: row; gap: 20px;">
                  <div style="display: flex; align-items: center;">
                      <input type="checkbox" class="checkboxx" data-descriptionm="Mueble">
                      <label for="mueble" style="padding-left: 10px;"> Mueble</label>
                  </div>
                  <div style="display: flex; align-items: center;">
                      <input type="checkbox" class="checkboxx" data-descriptionm="Inmueble">
                      <label for="inmueble" style="padding-left: 10px;"> Inmueble</label>
                  </div>
              </div>
          </div>
      </div>


      <div class="row" style="margin-top: 10px;">
         <div class="col-lg-4">
            <label for="placaVehiculo19">Placa de vehiculo</label>
            <input type="text" class="form-control" id="placaVehiculo19" name="placaVehiculo19" value="" placeholder="EJ: ARD-214" />
          </div>

           <div class="col-lg-4">
            <label for="ubicacionPredio19">Ubicacion del predio</label>
            <input type="text" class="form-control" id="ubicacionPredio19" name="ubicacionPredio19" value="" placeholder="EJ: JR LOS ROSALES MZ.4 LT8" />
          </div>
            <div class="col-lg-4">
            <label for="partidaRegistral19">Partida registral</label>
            <input type="text" class="form-control" id="partidaRegistral19" name="partidaRegistral19" value="" placeholder="EJ: P85412542" />
          </div>

        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col-lg-12">
                <label for="fundamento19">Fundamento°:</label>
                <textarea class="form-control" id="fundamento19" name="fundamento19" placeholder="EJ: Lorem ipsum es el texto que se usa habitualmente en diseño gráfico en demostraciones de tipografías o de borradores de diseño para probar el diseño visual antes de insertar el texto final."></textarea>
            </div>
        </div>




        <div class="row" style="margin-top: 10px;">
         <div class="col-lg-6">
            <label for="resolucionEjecucion19">Fundamentos: </label>
           
          </div>

        </div>

     
        <div class="row">
          <div class="col-lg-6" >
            <table border="1" style="width: 100%; border-collapse: collapse;">
                <thead>
                  <tr>
                    <th style="position: sticky; top: 0; background-color: #0d4570; z-index: 1;">Estado</th>
                  <th style="position: sticky; top: 0; background-color: #0d4570; z-index: 1;">Descripcion</th>
                  
                    
                  </tr>
                </thead>
                <tbody> 
                  <tr>
                    <td style="display: flex; justify-content: center; align-items: center;">
                      <input type="checkbox" class="checkbox" data-description="Tarjeta de propiedad"></td>
                    <td>Tarjeta de propiedad</td>
                  </tr>
                  <tr>
                    <td style="display: flex; justify-content: center; align-items: center;">
                      <input type="checkbox" class="checkbox" data-description="Acta de transparencia"></td>
                    <td>Acta de transparencia</td>
                  </tr>
                  <tr>
                    <td style="display: flex; justify-content: center; align-items: center;">
                      <input type="checkbox" class="checkbox" data-description="Contrato de compra venta"></td>
                    <td>Contrato de compra venta</td>
                  </tr>
                  <tr>
                    <td style="display: flex; justify-content: center; align-items: center;">
                      <input type="checkbox" class="checkbox" data-description="Partida registral"></td>
                    <td>Partida registral</td>
                  </tr>
                    <tr>
                    <td style="display: flex; justify-content: center; align-items: center;">
                      <input type="checkbox" class="checkbox" data-description="Otros"></td>
                    <td>Otros</td>
                  </tr>


                </tbody>
              </table>

          </div>

        



      </div>

      </div>

      <!-- Pie de Modal -->
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary print_orden_aviso_ok_19">OK</button>
      </div>

    </div>
  </div>
</div>
<!--END FROMULARIO DE ANEXO 19-->




<!--====== MODAL EDITAR PREDIO U==================-->













</div>
<!--====== FIN DEL MODAL AGREGAR PISO ============-->
<!--====== MODAL EDITAR PISO =============-->


<!--====== FIN DEL MODAL EDITAR PISO =============-->
<?php
        } else {
          echo "<div>error al cargar la pagina</div>";
        } ?>

















<!--======  INICIO MODAL ESTADO DE CUENTA COACTIVO-->
<div class="modal fade" id="modalEstadoCuentaC" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Estado de Cuenta para coactivo aqui
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       
  
                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_coactivo" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablac" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable estadocuentacoactivo">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablac" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimircoactiva">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--====INICIO MODAL ANEXO 01-->

<div class="modal fade" id="modalCartaRecordatorio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 Carta recordatoria de pago 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_coactivo_reco" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablacRecor" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablacRecor" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirCartaRecordatorio">Imprimir</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 2-->

<div class="modal fade" id="modalRequerimientoPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Requerimiento de pago (post vencimiento y antes de la notificación de valores) 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_coactivopagono" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaRequePaga" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaPagoReque" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirRequerimientoPago">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>


<!--FIN MODAL ANEXO 03-->

<div class="modal fade" id="modalEsquelaCobranza" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                Formato de esquela de cobranza (post notificación de valores)
            </div>



            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_esquela" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                          <table class="table-container " id="primeraTablaEsquelPago" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaEsquelaPago" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirEsquelaPago">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 04-->

<div class="modal fade" id="modalGestionDomiciliaria" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
               Formato de acta de visita en una gestión domiciliaria 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_gestion_domi" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaGestionDomi" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaGestionDomi" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirGestionDomiciliaria">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 05-->

<div class="modal fade" id="modalCobranzaTelefonica" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            Formatos de “speech” de cobranza telefónica 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_gestion_cotelefono" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaCoTelefo" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaCoTelefonica" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirCobranzaTelefonica">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 07-->


<div class="modal fade" id="modalResolucionDeterminacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            Resolución de Determinación 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_reso_determinacion" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container "   id="primeraTablaResoDete"  style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaResoDete" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirResoDeter">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 08-->


<div class="modal fade" id="modalResolucionMulta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
             Resolución de Multa 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_reso_multa" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaResoMulta" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaResoMulta" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirResoMulta">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 09-->

<div class="modal fade" id="modalPerdidaFraccionamiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 Resolución de pérdida de fraccionamiento 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_per_fra" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablacPer" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablacper" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirPerdidaFraccionamiento">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 10-->
<!--======  INICIO MODAL RESOLUCION DE APROBACION -->
<div class="modal fade" id="modalFraccionadoDeuda" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              solicitud de fraccionamiento de deuda 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_coactivo_eduda" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablacRosoDeuda" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablacResoDeuda" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirResoDeuda">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 11-->
<!--======  INICIO MODAL RESOLUCION DE APROBACION -->
<div class="modal fade" id="modalAprobacionFracciona" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              Resolución de aprobación de un fraccionamiento
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_aprobacion" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablacRosoApro" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablacResoApro" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirResoApro">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 12-->
<!--======  INICIO MODAL RESOLUCION DE APROBACION -->
<div class="modal fade" id="modalConcentidaDeuda" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              Constancia de haber quedado consentida la deuda para el inicio del proceso coactivo 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_consentida_deuda" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaConcenDeua" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaConcentidaDeuda" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirConcentidaDeu">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 14 -->
<!--======  INICIO MODAL RESOLUCION DE ACUMULACION-->
<div class="modal fade" id="modalrResolucionAcumulacionDOS" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">  
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

               14- Resolución Ejecución Coactiva DOS por acumulación 


            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_reso_acu" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaResoDosAcu" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaResoDosAcu" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirResoDosAcu">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>


<!--FIN MODAL ANEXO 15 -->
<!--======  INICIO MODAL RESOLUCION DE ACUMULACION-->
<div class="modal fade" id="modalResolucionVehicular" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

              15--- Resolución Ejecución Coactiva DOS. Por acumulación y/o ejecución, trabando Medida Cautelar en forma de secuestro conservativo y/o 
            
            
            
              </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_vehicular" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaVehicular" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaVehicular" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirVehicular">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>


<!--FIN MODAL ANEXO 16 -->
<!--======  INICIO MODAL RESOLUCION DE ACUMULACION-->
<div class="modal fade" id="modalResolucionInmueble" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

               16- Resolución Ejecución Coactiva DOS. Por acumulación
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_inmueble" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaInmueble" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaInmueble" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirInmueble">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>


<!--FIN MODAL ANEXO 17 -->
<!--======  INICIO MODAL RESOLUCION DE ACUMULACION-->
<div class="modal fade" id="modalrResolucionAcumulacionEjecucion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

             17- Formato de Resolución Ejecución Coactiva DOS por acumulación y/o ejecución. 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_acumulacion" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaAcumulacione" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaAcumulacionn" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirAcumulaciona">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 18 -->
<!--======  INICIO MODAL RESOLUCION DE ACUMULACION-->
<div class="modal fade" id="modalFormatoSuspencion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

             18-  Suspensión del procedimiento coactivo 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_suspencion" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaSuspencion" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaSuspencion" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirSuspencion">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>


<!--FIN MODAL ANEXO 19 -->
<!--======  INICIO MODAL RESOLUCION DE ACUMULACION-->
<div class="modal fade" id="modalTerceraPropiedad" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

             19-  Tercería de propiedad 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_propiedad" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaPropiedad" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaPropiedad" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirPropiedad">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>


<!--FIN MODAL ANEXO 20 -->
<!--======  INICIO MODAL RESOLUCION DE ACUMULACION-->
<div class="modal fade" id="modalNotificacionValores" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

              20- Cargo de notificación de valores tributarios 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_valores" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaValores" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaValores" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirValores">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL ANEXO 21 -->
<!--======  INICIO MODAL RESOLUCION DE ACUMULACION-->
<div class="modal fade" id="modalCargoNotificiacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

             21-  Notificación de resoluciones de ejecución coactiva 
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_cargo" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablaCargo" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
                                        S
                                    </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable perdidaFraccionamiento">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                           



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablaCargo" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimirCargo">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>

<!--FIN MODAL RESOLUCION DE ACUMULACION-->

<!--===== MODAL ORDEN DE PAGO -->
<div class="modal fade" id="modalOrdenPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        ORDEN DE PAGO
      </div>
      
      <div class="modal-body">
        <section class="container-fluid panel-medio">
          <div class="box rounded table-responsive">
            <div class="row">

              <div class="col-md-12" style="padding-left: 0; padding-right: 0;">
                
                <div class="col-md-5">
                  <div class="col-md-12" style="padding-left: 0; padding-right: 0;">
                    <input type="hidden" id="area_oculta" name="area_oculta" value="">
                  </div>
                </div>

                <div class="col-md-7">
                  <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                    <option value='006'>Impuesto Predial</option>
                    <option value='742'>Arbitrio Municipal</option>
                    ?>
                  </select>

                  <select class="busqueda_filtros pull-right" id="anio_orden" name="anio_orden">
                    <?php
                      $anio = ControladorPredio::ctrMostrarDataAnio();
                      foreach ($anio as $data_anio) {
                        $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                        echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . '</option>';
                      }
                    ?>
                  </select>
                </div>

              </div> <!-- /col-md-12 -->

              <div class="col-md-12">
                <div class="box divDetallePredio">

                  <table class="table-container miprimeratabla" id="primeraTabla_caja">
                    <thead>
                      <tr>
                        <th class="text-center" style="width:100px;">Cod.</th>
                        <th class="text-center" style="width:200px;">Tributo</th>
                        <th class="text-center" style="width:100px;">Año</th>
                        <th class="text-center" style="width:100px;">Periodo</th>
                        <th class="text-center" style="width:100px;">Importe</th>
                        <th class="text-center" style="width:100px;">Gasto</th>
                        <th class="text-center" style="width:100px;">Subtotal</th>
                        <th class="text-center" style="width:100px;">T.I.M</th>
                        <th class="text-center" style="width:100px;">Total</th>
                      </tr>
                    </thead>
                    <tbody id="estadoCuenta" class="scrollable estadocuentaorden">
                      <!-- Aqui Aparecen los estado de cuenta-->
                    </tbody>
                  </table>

                </div>

                <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
                <table class="table-container table table-bordered" id="segundaTabla_orden">
                  <tbody>
                    <tr>
                      <th class="text-right td-round" style="width:550px;">Total Deuda = </th>
                      <th class="text-center td-round" style="width:100px;" id="importe_o"></th>
                      <th class="text-center td-round" style="width:100px;" id="gasto_o"></th>
                      <th class="text-center td-round" style="width:100px;" id="subtotal_o"></th>
                      <th class="text-center td-round" style="width:100px;" id="tim_o"></th>
                      <th class="text-center td-round" style="width:100px;" id="total_o"></th>
                    </tr>
                  </tbody>
                </table>

              </div> <!-- /col-md-12 -->

            </div> <!-- /row -->
          </div> <!-- /box -->
        </section>
      </div> <!-- /modal-body -->

      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12" style="padding-left: 0; padding-right: 0;">

            <div class="col-md-5" style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
              <select class="select-elegante historialOrdenPago" name="select_tributo_orden_h" id="select_tributo_orden_h" style="width: 60%; text-align: left;">
              </select>

              <!-- Botones para Modificar y Borrar, inicialmente ocultos -->
              <button type="button" id="modificarBtn" class="btn-elegante mostrar-btn" style="display: none;">Mostrar</button>
              <button type="button" id="borrarBtn" class="btn-elegante" style="display: none;">Borrar</button>
            </div>

            <div class="col-md-7">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
              <button type="button" class="btn btn-primary btnOrdenPago">Imprimir Orden</button>
            </div>

          </div> <!-- /col-md-12 -->
        </div> <!-- /row -->
      </div> <!-- /modal-footer -->

    </div> <!-- /modal-content -->
  </div> <!-- /modal-dialog -->
</div> <!-- /modal -->


<!-- fin de generar pdf oden pago - impuesto-->
<!-- fin de generar pdf oden pago - impuesto-->

<!-- MODAL CONFIRMAR LA IMPRESION DEL ORDEN PAGO -->
<div class="modal fade" id="modalImprimir_ordenpago_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Imprimir Orden Pago</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Generar Orden de Pago desde el año <span id="anio_formato"><!-- CONTENIDO DINAMICO--></span>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary print_orden_pago">si</button>
      </div>


      
    </div>
  </div>
</div>
<!-- FIN MODAL PARA CUARGAR SI O NO ORDEN DE PAGO -->


<!--====== MODAL ESTADO DE CUENTA -->
<div class="modal fade" id="modalEstadoCuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Estado de Cuenta
      </div>

      <div class="modal-body">

        <section class="container-fluid panel-medio ">
          <div class="box-body table-responsive">

            <div class="col-md-12">
              Estdo de Cuenta + Tasa de Interes Moratorio (TIM)
            </div>

            <div class="box divDetallePredio">
              <table class="table-container" id="primeraTabla">
                <thead>
                  <tr>
                    <th class="text-center" style="width:50px;">Cod.</th>
                    <th class="text-center" style="width:100px;">Tributo</th>
                    <th class="text-center" style="width:50px;">Año</th>
                    <th class="text-center" style="width:50px;">Periodo</th>
                    <th class="text-center" style="width:50px;">Importe</th>
                    <th class="text-center" style="width:50px;">Gasto</th>
                    <th class="text-center" style="width:50px;">Subtotal</th>
                    <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                    <th class="text-center" style="width:50px;">T.I.M</th>
                    <th class="text-center" style="width:50px;">Total</th>
                    <th class="seleccionado text-center" style="width:30px;">S</th>
                  </tr>
                </thead>
                <tbody id="estadoCuenta" class="scrollable">
                  <!-- Aqui Aparecen los estado de cuenta-->
                  <?php
                  $estado_cuenta = ControladorEstadoCuenta::ctrEstadoCuenta($idArray, "estadocuenta"); ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->

          <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
          <table class="table-container" id="segundaTabla">
            <tbody>
              <th class="text-center" style="width:50px;">
              </th>
              <!-- no eliminar los Td-->
              <th class="text-right td-round total_c" style="width:200px;">Total Deuda =</th>
              <th class="text-center td-round total_c" style="width:50px;"></th>
              <th class="text-center td-round" style="width:50px;"></th>
              <th class="text-center td-round" style="width:50px;"></th>
              <th class="text-center td-round" style="width:50px;"></th>
              <th class="text-center td-round" style="width:50px;"></th>
              <th class="text-center rd-round" style="width:50px;"></th>
              <th class="text-center rd-round" style="width:30px;"></th>
            </tbody>
          </table>




        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-success" id="enviarWhapsApp">Enviar whapsApp</button>
        <button type="button" class="btn btn-primary" id="popimprimir">Imprimir Estado Cuenta</button>
      </div>
    </div>
  </div>
</div>
<!--FIN DETALLE ESTADO CUENTA-->

<div class="container-fluid">
  <div class="modal in" id="Modal_Orden_Pago" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-body printerhere">
          <iframe id="iframe_orden_pago" class="iframe-full-height"><!-- Muestra el PDF --></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cerrar-modal">Close</button>
        <!--  <button type="button" class="btn btn-secondary cerrar-modal" data-dismiss="modal">Close</button> -->
        </div>
      </div>
    </div>
  </div>
</div>



<!--====== MODAL PAGOS REALIZADOS DE IMPUESTO Y ARBITRIOS -->
<div class="modal fade " id="modalPagosImpuestoArbitrios" tabindex="-2" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Pagos Realizados
      </div>
      <div class="modal-body">

        <section class="container-fluid panel-medio ">
          <div class="box rounded table-responsive">
            <div class="row">
              <div class="col-md-12">

                Estado Cuenta Pagos de Impuesto - Arbitrios

              </div>
              <div class="col-md-12">
                <div class="box divDetallePredio">
                  <table class="table-container" id="primeraTabla_reporte_pagados_IA">

                    <thead>
                      <tr>
                        <th class="text-center" style="width:30px;">Cod.</th>
                        <th class="text-center" style="width:70px;">Tributo</th>
                        <th class="text-center" style="width:30px;">Año</th>
                        <th class="text-center" style="width:30px;">Periodo</th>
                        <th class="text-center" style="width:100px;">Fecha Pago</th>
                        <th class="text-center" style="width:50px;">Estado</th>
                        <th class="text-center" style="width:50px;">Importe</th>
                        <th class="text-center" style="width:50px;">Gasto</th>
                        <th class="text-center" style="width:50px;">Subtotal</th>
                        <th class="text-center" style="width:50px;">T.I.M</th>
                        <th class="text-center" style="width:50px;">Total</th>
                        <th class="seleccionado text-center" style="width:20px;">S</th>
                      </tr>
                    </thead>
                    <tbody id="estadoCuenta" class="scrollable">
                      <!-- Aqui Aparecen los estado de cuenta-->
                      <?php
                      $estado_cuenta = ControladorEstadoCuenta::ctrEstadoCuenta_Pagado($idArray, "estadocuenta"); ?>
                    </tbody>
                  </table>
                </div>
                <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
                <table class="table-container" id="segundaTabla_reporte_pagados_IA">
                  <tbody>
                    <th class="text-right td-round total_c" style="width:330px;">Total Pagado =</th>
                    <th class="text-center td-round" style="width:50px;"></th>
                    <th class="text-center td-round" style="width:50px;"></th>
                    <th class="text-center td-round" style="width:50px;"></th>
                    <th class="text-center" style="width:50px;"></th>
                    <th class="text-center" style="width:50px;"></th>
                    <th class="text-center" style="width:20px;"></th>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" id="popimprimir_estadoCuentapagados">Imprimir Pagos</button>
      </div>
    </div>
  </div>
</div>
<!--FIN DE PAGOS REALIZADOS DE IMPUESTO Y ARBITRIOS-->


<!-- modal de imprimir estado cuenta -->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_cuenta_coactivo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhere">
          <iframe id="iframec" class="iframe-full-height"></iframe>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de imprimir estado de cuenta-->



<!-- modal de imprimir estado cuenta -->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_cuenta" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhere">
          <iframe id="iframe" class="iframe-full-height"></iframe>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de imprimir estado de cuenta-->



   

<!-- modal cargando -->
<?php include_once "proceso-calcular-impuesto.php";  ?>
<!-- fin de modal cargando-->

<!-- modal cargando -->
<?php include_once "modalcargar.php";  ?>
<!-- fin de modal cargando-->