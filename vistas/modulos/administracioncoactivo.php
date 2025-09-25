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

      <!-- Mostrar la barra de progreso con el porcentaje y color calculado -->
    <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentaje; ?>%; height: 100%; background-color: <?php echo $color; ?>; display: flex; justify-content: center; align-items: center; color: white; font-weight: bold; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
        <?php echo $porcentaje . '%'; ?>
    </div>

</div>



     
    <div class="col-lg-7 col-xs-7 "  >
        <?php
       // $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);
        if (count($datos_contribuyente) > 0) {
        ?>

<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;  margin-bottom: 0.3rem; margin-top: 0.3rem;">
    <table class="miTabla_propietarios" style="width: 100%;">
        <caption>Propietarios</caption>
    </table>

    <input  id="id_array_php" class="hidden" value="<?php echo implode(',', $idArray); ?>">

    <button class="bi bi-briefcase btn btn-sm" id="mostrar_litigio" style="background-color: red; color: white;">
    Predio litigio
    </button>


    <button class="bi bi-bar-chart btn btn-secundary btn-sm" id="editar_progreso_Predio" >
        Editar progreso
    </button>

    <button class="bi bi-person-fill-add btn btn-success btn-sm" id="agregarContribuyente_Predio">  Agregar Contribuyente</button>
</div>

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



<!--====== MODAL DE HISTORIAL PREDIO -->

<div class="modal fade" id="modalFotosPredio" tabindex="-1" role="dialog" aria-labelledby="modalFotosPredioTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="modalFotosPredioTitle">Historial de predio</h5>
               
            </div>
            <div class="aqui" style="margin-left: 20px; margin-top:10px" >


            </div>

            <div class="modal-body">
                <!-- Mostrar los detalles de las fotos en la línea de tiempo -->
                <div class="show-historial-predio"></div>

                <!-- Mensaje cuando no hay fotos -->
                <div id="mensaje-no-fotos" class="alert alert-info" style="display:none;">
                    No hay fotos disponibles para este predio.
                </div>
            </div>
        </div>
    </div>
</div>




<!-- MODAL ELIMINAR NEGOCIO -->
<div class="modal fade" id="modal_pregita_elimar_litigio" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">

           <input type="text" id="id_predio_litigio_eliminar_m" class="hidden" >
   

          <div class="col-xs-12 text-center">
            <i class="bi bi-exclamation-circle" style="color: red; font-size: 48px;"></i>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            <h3>¿Estás seguro de eliminar predio en litigio?</h3>
              <p><small>Est accion recomendable una vez los propitarios lleguen a un acuerdo</small></p>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary" id="confirmarEliminarPredioL">Sí, elimar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL ELIMINAR NEGOCIO IND -->






<!--====== MODAL DE TRANSFERIR PREDIO -->
<div class="modal fade " id="modalTransferenciaPredio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        TRANSFERIR PREDIO
      </div>
      <div class="modal-body">
        <div class="form-group predio_catastro_transferir">
          <!--CONTENIDO DINAMICO DEL PREDIO A TRANSFERIR -->
        </div>
        <div class="col-md-6 table-responsive">
          <table class="table-container">
            <caption>Propietarios</caption>
            <thead>
              <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Documento</th>
                <th class="text-center">Nombres</th>
              </tr>
            </thead>
            <tbody id="id_propietarios_modal">
              <?php foreach ($datos_contribuyente as $valor => $filas) {
                foreach ($filas as $fila) {
                  echo '<tr id="fila" id_contribuyente="' . $fila['Id_Contribuyente'] . '">
                      <td class="text-center">' . $fila['Id_Contribuyente'] . '</td>
                      <td class="text-center">' . $fila['Documento'] . '</td>
                      <td class="text-center">' . $fila['Nombre_Completo'] . '</td>';
                }
              }
              ?>
            </tbody>
          </table>
        </div>

        <div class="col-md-6 table-responsive">
          <div class="col-md-12">
            <span class="caption_"> Documento de Transferencia</span>
          </div>
          <div class="col-md-6">
            <label for="tipodocInscripcion">Documento Inscripcion</label>
            <select class="form-control" id="tipodocInscripcion" required="" id="tipodocInscripcion" required="">
              <option value="" selected="" disabled="">Seleccione Documento</option>
              <?php
              $tabla = 'documento_inscripcion';
              $registros = ControladorPredio::ctrMostrarData($tabla);
              foreach ($registros as $data_d) {
                echo "<option value='" . $data_d['Id_Documento_Inscripcion'] . "'>" . $data_d['Documento_Inscripcion'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-6">
            <label>N° Documento </label>
            <input type="text" class="form-control" id="n_documento" placeholder="N° documento">
          </div>

          <div class="col-md-6">
            <br>
            <label for="tipoEscritura">Tipo de Documento</label>
            <select class="form-control" name="tipoEscritura" required="" id="tipoEscritura">
              <option value="" selected="" disabled="">Seleccione Tipo Documento</option>
              <?php
              $tabla = 'tipo_escritura';
              $registros = ControladorPredio::ctrMostrarData($tabla);
              foreach ($registros as $data_d) {
                echo "<option value='" . $data_d['Id_Tipo_Escritura'] . "'>" . $data_d['Tipo_Escritura'] . '</option>';
              }
              ?>
            </select>

          </div>

          <div class="col-md-6">
            <br>
            <label for="fechaEscritura">Fecha Documento</label>
            <input type="date" name="fechaEscritura" id="fechaEscritura" required="">
          </div>
          </fieldset>
        </div>
      </div>

      <div class="col-md-12">
        <div class="col-md-6 table-responsive">
          <table id="tabla_propietario" class="table-container">
            <caption><b>(Nuevo Propietario)</b></caption>
            <thead>
              <tr>
                <th class="text-center transferir">Código</th>
                <th class="text-center transferir">Documento</th>
                <th class="text-center transferir">Nombres</th>
                <th class="text-center transferir">Acciones</th>
              </tr>
            </thead>
            <tbody id="div_propietario">
              <!-- Aquí se agregarán las filas de datos -->
            </tbody>
          </table>
          <div class="boton-propietario">
            <button type="button" class="btn btn-secundary btn-1" data-toggle="modal" data-target="#modalPropietarios">Nuevo Propietario</button>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary btnTransferirPredio">Trasnferir</button>
      </div>
    </div>
  </div>
</div>
<!--====== FIN DEL MODAL TRANSFERIR PREDIO =======-->



<!--====== MODAL EDITAR BARRA DE PROGRESO =======-->
<div class="modal" id="modal_editar_barra_progreso" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form role="form" id="formCarpetaProgress" method="post" enctype="multipart/form-data">
      
      <div class="modal-header">
        <label class="modal-title">EDITAR BARRA DE PROGRESO</label>
      </div>
      <div class="modal-body">
     
        <!-- Input oculto para almacenar el valor de Codigo_Carpeta -->
        <!-- Input oculto para almacenar el valor de Codigo_Carpeta -->
        <input type="hidden" id="codigo_carpeta" name="codigo_carpeta" value="">



        <!-- Sección de Estado de Progreso -->
        <section class="container-fluid panel-medio col-xs-6" id="propietarios" style="width: 100%;">
            <div class="row">
                <div class="col-12 col-md-2" style="display: flex; align-items: center;">
                    <!-- Label para el select -->
                    <label for="estado_progreso" style="font-weight: bold;">Estado de progreso:</label>
                </div>
                <div class="col-12 col-md-2" style="display: flex; align-items: center;">
                    <!-- Select con las opciones -->
                    <select id="estado_progreso" name="estado_progreso" class="form-control" style="border-radius: 8px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1);">
                        <option value="P">Pendiente</option>
                        <option value="E">En Progreso</option>
                        <option value="C">Completado</option>
                    </select>
                </div>
                <div class="col-12 col-md-4" style="display: flex; align-items: center;" id="campletado_desde_oficina">
                    <!-- Label para el select -->
                  
                   <label>
                    <input type="checkbox" id="completado_oficina" name="completado_oficina" >
                    Completado desde oficina
                  </label>
                </div>

                  <div class="col-12 col-md-4" style="display: flex; align-items: center;" id="campletado_desde_Campo">
                    <!-- Label para el select -->
                  
                   <label>
                    <input type="checkbox" id="completado_campo" name="completado_campo">
                    Completado desde campo
                  </label>
                </div>
                
            </div>
        </section>

        <!-- Sección de Barra de Progreso -->
        <section class="container-fluid panel-medio" id="propietarios" style="width: 100%; margin-top:5rem">
            <div class="row">
                <div class="col-12" style="display: flex; align-items: center; width: 100%;">
                    <!-- Barra de progreso que ocupa el 100% del ancho -->
                    <div class="progress" style="width: 100%; height: 20px; border-radius: 10px ; background-color: #f0f0f0; border:0">
                        <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%; background-color: #ffc107; border-radius: 10px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            0%
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="container-fluid panel-medio" id="campo_observacion" style="width: 100%; ">
            <div class="row">
                 <div class="col-12" style="display: flex; align-items: center; width: 100%;">

                    <p> Observacion en progreso </p>
                    <!-- Área de texto que ocupa el 100% del ancho -->
                   
                </div>

                 <div class="col-12" style="display: flex; align-items: center; width: 100%;">

                    <!-- Área de texto que ocupa el 100% del ancho -->
                    <textarea style="width: 100%;" id="observacion_progreso" name="observacion_progreso"></textarea>
                </div>
            </div>
        </section>

        <section class="container-fluid panel-medio" id="campo_observacion_p" style="width: 100%; ">

        <div class="row">
          
            <div class="col-12" style="display: flex; align-items: center; width: 100%;">

                <p> Observacion de pendiente </p>
                <!-- Área de texto que ocupa el 100% del ancho -->
              
            </div>

            <div class="col-12" style="display: flex; align-items: center; width: 100%;">

                <!-- Área de texto que ocupa el 100% del ancho -->
                <textarea style="width: 100%;" id="observacion_pendiente" name="observacion_pendiente"></textarea>
            </div>
            
        </div>
        </section>


      </div>

      <div class="modal-footer">
        
      <div class="row">

        <div class="col-12 col-md-4 text-start" style="text-align: left;">
          <p> <i class="bi bi-person-check-fill"></i> Ultima modificacion: <span id="usuario_progreso"></span></p>

          
        </div>

        <div class="col-12 col-md-">
          <button type="button" class="btn btn-secondary" id="salir_modal_progreso" data-dismiss="modal">Salir</button>
        <button style='float:right;' type="sudmit" class="btn btn-primary ">Guardar cambio</button>


          
        </div>

        </div>

      </div>

      </form>

    </div>
  </div>
</div>

<!--====== FIN DEL MODAL BARRA PROGRESO =======-->



<!--====== MODAL EDITAR LITIGIO =======-->
<div class="modal" id="modal_litigio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form role="form" id="formPredioLitigio" method="post" enctype="multipart/form-data">
      
      <div class="modal-header">
        <label class="modal-title">PREDIO EN LITIGIO</label>
      </div>
      <div class="modal-body">

       <p> Selecione un predio en litigio </p>
     
        <section class="container-fluid panel-medio" id="campo_observacion_p" style="width: 100%; ">


        <table class="table-container" id="tablalistaprediosL">
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
             
                  </tr>
                </thead>
                <tbody class='body-predio-j'>
                  <?php
                  $listaPredio = ControladorPredioLitigio::ctrListarPredioLitigio($idArray, $anio_propietario);
                  ?>
                </tbody>
              </table>
     
        </section>

        <section class="container-fluid panel-medio" id="campo_observacion_p" style="width: 100%; ">

        <div class="row">
          
            <div class="col-12" style="display: flex; align-items: center; width: 100%;">

                <p> Observacion </p>
                <!-- Área de texto que ocupa el 100% del ancho -->
              
            </div>

            <div class="col-12" style="display: flex; align-items: center; width: 100%;">

                <!-- Área de texto que ocupa el 100% del ancho -->
                <textarea style="width: 100%;" id="observacion_predio" name="observacion_predio"></textarea>
            </div>
            
        </div>
        </section>


      </div>

      <div class="modal-footer">

      <div class="row">

        <div class="col-12 col-md-4 text-start" style="text-align: left;">
           <p> <i class="bi bi-person-check-fill"></i> Ultima modificacion: <span id="usuario_progreso"></span></p>

          
        </div>

         <div class="col-12 col-md-">
           <button type="button" class="btn btn-secondary" id="salir_modal_litigio" data-dismiss="modal">Salir</button>
        <button style='float:right;' type="sudmit" class="btn btn-primary ">Guardar cambio</button>
    
    
          
        </div>

      </div>

     
       
      </div>

      </form>

    </div>
  </div>
</div>

<!--====== FIN DEL MODAL LITIGIO =======-->


<!--====== MODAL REGISTRAR CONTRIBUYENTE A PREDIO EXISTENTE =======-->
<div class="modal" id="modalAgregarContribuyente_Predio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> AGREGAR CONTRIBUYENTE</label>
      </div>
      <div class="modal-body">
        <div class="row divDetallePredio_predio">

          <section class="container-fluid panel-medio col-xs-6" id="propietarios" style='width: 100%;'>
            <div class="box container-fluid">

              <div class="text-bordeada">
                Propietarios
              </div>
              <table id="tabla_contribuyente_predio" class="table-container">
                <thead>
                  <tr>
                    <th class="text-center">Código</th>
                    <th class="text-center">Documento</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody id="div_propietario2">
                  <!-- Aquí se agregarán los propietarios en filas -->
                </tbody>
              </table>
              <div class="boton-propietario">
                <button type="button" class="btn btn-secundary btn-1" data-toggle="modal" data-target="#modalPropietarios">Agregar Propietarios</button>
              </div>
            </div>
          </section>

          <section class="container-fluid panel-medio col-xs-6" id="propietarios" style='width: 100%;'>
            <div class="box container-fluid">
              <div class="text-bordeada">
                Predios
              </div>
              <table class="table-container" id="tablalistapredios2">
                <thead>
                  <tr>
                    <th class="text-center">N°</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Ubicacion del Predio</th>
                    <th class="text-center" style="display:none;">Id.Catastro</th>
                    <th class="text-center">A.Terreno</th>
                    <th class="text-center">A.Const.</th>
                    <th class="text-center">Val.Predio</th>
                    <th class="text-center">Foto</th>
                  </tr>
                </thead>
                <tbody class='body-predio' id='predios_contribuyente'>
                  <?php
                  $listaPredio = ControladorPredio::ctrListarPredio($idArray, $anio_propietario);
                  ?>
                </tbody>
              </table>
            </div>
            <button type="button" class="btn btn-secondary" id="salir_AgregarContribuyente" data-dismiss="modal">Salir</button>
            <button style='float:right;' type="button" class="btn btn-primary btnAgregarContribuyente_predio">Agregar</button>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
<!--====== FIN DEL MODAL REGISTRAR CONTRIBUYENTE A PREDIO EXISTENTE =======-->

<!--====== MODAL DE COPIAR PREDIO -->
<div class="modal" id="modalCopiarPredio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">COPIAR PREDIO</h5>
      </div>

      <div class="modal-body">
        <div class="predio_catastro ">
          <!--CONTENIDO DINAMICO DEL PREDIO A TRANSFERIR -->
        </div>
      </div>

      <div class="row" style="margin-bottom: 20px;"> 
      <div class="col-12 col-md-5">
                  <label for="anioFiscal_e" class="cajalabel2">Año a copiar</label>
                  <select class="form2" name="anioFiscal_e" id="anioFiscal_e" required="">
                    <option value="" selected="" disabled="">Seleccione Año</option>
                    <?php
                    $anioSiat = 'anio';
                    $registros = ControladorPredio::ctrMostrarData($anioSiat);
                    foreach ($registros as $data_d) {
                        // Asegúrate de añadir el 'NomAnio' en el atributo data-nomanio
                        echo "<option value='" . $data_d['Id_Anio'] . "' data-nomanio='" . $data_d['NomAnio'] . "'>" . $data_d['NomAnio'] . "</option>";
                      }
                    ?>
                  </select>
          </div>
      </div>




      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary btnCopiarPredio">Copiar</button>
      </div>
    </div>
  </div>
</div>
<!--====== FIN DEL MODAL COPIAR PREDIO URB========-->


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
            <input type="text" class="form-control" id="docInfraccion8" name="docInfraccion8" value="" placeholder="Doc infraccion" />
          </div>

          <div class="col-lg-3">
            <label for="fechaInfraccion8">Fecha de infraccion</label>
            <input type="date" class="form-control" id="fechaInfraccion8" name="fechaInfraccion8" value="" placeholder="Fecha infraccion" />
          </div>

           <div class="col-lg-3">
            <label for="baseImponible8">Base imponible</label>
            <input type="number" class="form-control" id="baseImponible8" name="baseImponible8" value="" placeholder="Base imponible" />
          </div>
         
         
 

        </div>



    
         <div class="row">

           <div class="col-lg-3">
            <label for="sansion8">Sanción (%)</label>
            <input type="number" class="form-control" id="sansion8" name="sansion8" value="" placeholder="Sancion" min="0" max="100" step="0.01" />
          </div>


           <div class="col-lg-3">
            <label for="montoInsoluto8">Monto insoluto</label>
            <input type="number" class="form-control" id="montoInsoluto8" name="montoInsoluto8" value="" placeholder="Monto insoluto" />
          </div>

          <div class="col-lg-3">
            <label for="interesMoratorio8">Interes moratorio</label>
            <input type="number" class="form-control" id="interesMoratorio8" name="interesMoratorio8" value="" placeholder="Interes moratorio" />
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
            <input type="number" class="form-control" id="numeroResolucion109" name="numeroResolucion109" value="" placeholder="Ingrese número de cuota" />
          </div>
     

          <div class="col-lg-4">
            <label for="numeroSolicitud09">Número de solicitud:</label>
            <input type="number" class="form-control" id="numeroSolicitud09" name="numeroSolicitud09" value="" placeholder="Ingrese número de cuota" />
          </div>
        

          <div class="col-lg-4">
            <label for="numeroResolucion209">Número de resolucion:</label>
            <input type="number" class="form-control" id="numeroResolucion209" name="numeroResolucion209" value="" placeholder="Ingrese número de cuota" />
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
          <td><input type="number" class="form-control" name="nCouta" id="nCouta" placeholder="Ingrese cuota"></td>
          <td><input type="text" class="form-control" name="DocDeuda" id="DocDeuda" placeholder="Ingres numero docu"></td>
          <td><input type="date" class="form-control" name="fechaVencimiento" id="fechaVencimiento" placeholder="Ingrese fecha ven"></td>
          <td><input type="number" class="form-control" name="montoTotal" id="montoTotal" placeholder="Ingrese monto"></td>
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
     
        <div class="row">

          <div class="col-lg-12">
            <label for="numeroFraccionado11">Número de solicitud fraccionado:</label>
            <input type="number" class="form-control" id="numeroFraccionado11" name="numeroFraccionado11" value="" placeholder="Ingrese número de cuota" />
          </div>
     
        </div>

        
        <div class="row">

         
          <div class="col-lg-12">
            <label for="numeroCuotas11">Número de cuotas:</label>
            <input type="number" class="form-control" id="numeroCuotas11" name="numeroCuotas11" value="" placeholder="Ingrese número de cuota" />
          </div>
       
        </div>

      <div class="row">
          <div class="col-lg-12">
            <label for="numeroConvenio11">Número de convenio:</label>
            <input type="number" class="form-control" id="numeroConvenio11" name="numeroConvenio11" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>

            <div class="row">
          <div class="col-lg-12">
            <label for="importeFraccionado11">Importe fraccionamiento:</label>
            <input type="number" class="form-control" id="importeFraccionado11" name="importeFraccionado11" value="" placeholder="Ingrese número de cuota" />
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
                  <th>Detalle de cosuemtos</th>
       
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
     
        <div class="row">
         <div class="col-lg-12">
            <label for="expedientes14">Expedientes:</label>
            <input type="number" class="form-control" id="expedientes14" name="expedientes14" value="" placeholder="Ingrese número de cuota" />
          </div>
     
        </div>

          <div class="row">
          <div class="col-lg-12">
            <label for="numeroExpediente14">Número de expedientes:</label>
            <input type="number" class="form-control" id="numeroExpediente14" name="numeroExpediente14" value="" placeholder="Ingrese número de cuota" />
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

        <div class="row">
         <div class="col-lg-12">
            <label for="numeroExpediente0115">Número de expedientes:</label>
            <input type="number" class="form-control" id="numeroExpediente0115" name="numeroExpediente0115" value="" placeholder="Ingrese número de cuota" />
          </div>
     
        </div>
     
        <div class="row">
         <div class="col-lg-12">
            <label for="expedientes15">Expedientes:</label>
            <input type="number" class="form-control" id="expedientes15" name="expedientes15" value="" placeholder="Ingrese número de cuota" />
          </div>
     
        </div>

          <div class="row">
          <div class="col-lg-12">
            <label for="numeroExpediente15">Número de expedientes acumulados:</label>
            <input type="number" class="form-control" id="numeroExpediente15" name="numeroExpediente15" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <label for="monto15">Monto de deuda:</label>
            <input type="number" class="form-control" id="monto15" name="monto15" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>

          <div class="row">
          <div class="col-lg-12">
            <label for="placaRodaje15">Número de placa de rodaje:</label>
            <input type="number" class="form-control" id="placaRodaje15" name="placaRodaje15" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>

         <div class="row">
          <div class="col-lg-12">
            <label for="nombrePropietario15">Nombre propietario:</label>
            <input type="text" class="form-control" id="nombrePropietario15" name="nombrePropietario15" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label for="dniPropietario15">Dni de propietario:</label>
            <input type="text" class="form-control" id="dniPropietario15" name="dniPropietario15" value="" placeholder="Ingrese número de cuota" />
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
     
      
        <div class="row">
         <div class="col-lg-12">
            <label for="numeroExpediente0116">Número de expedientes:</label>
            <input type="number" class="form-control" id="numeroExpediente0116" name="numeroExpediente0116" value="" placeholder="Ingrese número de cuota" />
          </div>
     
        </div>
     
        <div class="row">
         <div class="col-lg-12">
            <label for="expedientes16">Expedientes:</label>
            <input type="number" class="form-control" id="expedientes16" name="expedientes16" value="" placeholder="Ingrese número de cuota" />
          </div>
     
        </div>

          <div class="row">
          <div class="col-lg-12">
            <label for="numeroExpediente16">Número de expedientes acumulados:</label>
            <input type="number" class="form-control" id="numeroExpediente16" name="numeroExpediente16" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <label for="monto16">Monto de deuda:</label>
            <input type="number" class="form-control" id="monto16" name="monto16" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>


         <div class="row">
          <div class="col-lg-12">
            <label for="nombrePropietario16">Nombre propietario:</label>
            <input type="text" class="form-control" id="nombrePropietario16" name="nombrePropietario16" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>
        
        <div class="row">
          <div class="col-lg-12">
            <label for="dniPropietario16">Dni de propietario:</label>
            <input type="text" class="form-control" id="dniPropietario16" name="dniPropietario16" value="" placeholder="Ingrese número de cuota" />
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
     
      
        <div class="row">
         <div class="col-lg-12">
            <label for="numeroExpediente0117">Número de expedientessss:</label>
            <input type="text" class="form-control" id="numeroExpediente0117" name="numeroExpediente0117" value="" placeholder="Ingrese número de cuota" />
          </div>
     
        </div>
     
        <div class="row">
         <div class="col-lg-12">
            <label for="expedientes17">Expedientes:</label>
            <input type="text" class="form-control" id="expedientes17" name="expedientes17" value="" placeholder="Ingrese número de cuota" />
          </div>
     
        </div>

          <div class="row">
          <div class="col-lg-12">
            <label for="numeroExpediente17">Número de expedientes acumulados:</label>
            <input type="text" class="form-control" id="numeroExpediente17" name="numeroExpediente17" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <label for="monto17">Monto de deuda:</label>
            <input type="number" class="form-control" id="monto17" name="monto17" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>


         <div class="row">
          <div class="col-lg-12">
            <label for="nombrePropietario17">Nombre propietario:</label>
            <input type="text" class="form-control" id="nombrePropietario17" name="nombrePropietario17" value="" placeholder="Ingrese número de cuota" />
          </div>
        </div>
        
        <div class="row">
          <div class="col-lg-12">
            <label for="dniPropietario17">Dni de propietario:</label>
            <input type="number" class="form-control" id="dniPropietario17" name="dniPropietario17" value="" placeholder="Ingrese número de cuota" />
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
            <input type="text" class="form-control" id="resolucionEjecucion18" name="resolucionEjecucion18" value="" placeholder="Ingrese número de cuota" />
          </div>

           <div class="col-lg-4">
            <label for="resolucionMedida18">Resolucion de medida cautelar N°:</label>
            <input type="text" class="form-control" id="resolucionMedida18" name="resolucionMedida18" value="" placeholder="Ingrese número de cuota" />
          </div>

          <div class="col-lg-4">
            <label for="numeroDocumento18">Número de docuemento de deuda:</label>
            <input type="text" class="form-control" id="numeroDocumento18" name="numeroDocumento18" value="" placeholder="Ingrese número de cuota" />
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
              <td><input type="text"  placeholder="N° Resolución"></td>
              <td><input type="number" disabled placeholder="N° Expediente"></td>
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
              <td><input type="text" placeholder="N° Resolución " disabled></td>
              <td><input type="text"  placeholder="N° Expediente"></td>
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
              <td><input type="text" placeholder="N° Resolución" disabled></td>
              <td><input type="number" placeholder="N° Expediente" disabled></td>
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
              <td><input type="text"  placeholder="Resolución N°"></td>
              <td><input type="number" placeholder="N° resolución" disabled></td>
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
         <div class="col-lg-6">
            <label for="resolucionEjecucion19">Respecto de la deuda: </label>
           
          </div>

        </div>


        <div class="row">
         <div class="col-lg-4">
            <label for="resolucionEjecucion19">Expediente coactivo N°</label>
            <input type="text" class="form-control" id="resolucionEjecucion19" name="resolucionEjecucion19" value="" placeholder="Ingrese número de cuota" />
          </div>

           <div class="col-lg-4">
            <label for="resolucionMedida19">Resolucion de medida cautelar N°</label>
            <input type="text" class="form-control" id="resolucionMedida19" name="resolucionMedida19" value="" placeholder="Ingrese número de cuota" />
          </div>

        </div>

         <div class="row" style="margin-top: 10px;">
          <div class="col-lg-6">
              <label for="resolucionEjecucion19"> <strong> Respecto del bien afectado por la medida cautelar: </strong></label>
            
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
            <input type="text" class="form-control" id="placaVehiculo19" name="placaVehiculo19" value="" placeholder="Ingrese número de cuota" />
          </div>

           <div class="col-lg-4">
            <label for="ubicacionPredio19">Ubicacion del predio</label>
            <input type="text" class="form-control" id="ubicacionPredio19" name="ubicacionPredio19" value="" placeholder="Ingrese número de cuota" />
          </div>
            <div class="col-lg-4">
            <label for="partidaRegistral19">Partida registral</label>
            <input type="text" class="form-control" id="partidaRegistral19" name="partidaRegistral19" value="" placeholder="Ingrese número de cuota" />
          </div>

        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col-lg-12">
                <label for="fundamento19">Fundamento°:</label>
                <textarea class="form-control" id="fundamento19" name="fundamento19" placeholder="Ingrese el texto aquí"></textarea>
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




<!-- MODAL  VER NEGOCIO -->
<div class="modal" id="modalVer_negocio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle del Negocio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="col-12">
          <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
               <div class="row mb-4">
                <div class="col-md-6">
                
                  <p id="nombreNegocioModal" class="lead text-muted"></p>
                </div>
               
              </div>
              
            

              <!-- Información del Negocio -->
              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-person-circle me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Razón Social</span>
                  </div>
                  <p id="razonSocialModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-building me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">RUC</span>
                  </div>
                  <p id="rucModal"></p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-geo-alt me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Área del Negocio</span>
                  </div>
                  <p id="areaNegocioModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-house-door me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Tenencia del Negocio</span>
                  </div>
                  <p id="tenenciaNegocioModal"></p>
                </div>
              </div>

              <!-- Más Información -->
              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-person-check me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Número de Trabajadores</span>
                  </div>
                  <p id="nTrabajadoresModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-table me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Número de Mesas</span>
                  </div>
                  <p id="nMesasModal"></p>
                </div>
              </div>

              <!-- LADO 2 -->
              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-bed me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Número de Camas</span>
                  </div>
                  <p id="nCamasModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-door-open me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Número de Cuartos</span>
                  </div>
                  <p id="nCuartosModal"></p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-droplet me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Agua del Negocio</span>
                  </div>
                  <p id="aguaNegocioModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-shield-lock me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">ITSE</span>
                  </div>
                  <p id="itseModal"></p>
                </div>
              </div>

              <div class="row">
                 <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-check-circle me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Estado</span>
                  </div>
                  <p id="estadoModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-calendar-event me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Vencimiento ITSE</span>
                  </div>
                  <p id="vencimientoItseModal"></p>
                </div>
               
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" id="cancelarModalVer" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
      
     
      </div>
    </div>
  </div>
</div>


<!-- MODAL  EDITAR NEGOCIO -->





<!-- MODAL  EDITAR NEGOCIO -->


<!-- MODAL  EDITAR NEGOCIO -->
<div class="modal" id="modalRegistrar_negocio_editar">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Editar negocio</h5>
      </div>
      <div class="modal-body">
        <div class="col-12">

        
         <div id="divDescripPreu" >
                  <div class="box box-success" style="border-top: 0px;">
                    <div class="box-body" style="border: 1px dotted gray;  ">
                      <div class="row">


                        <div class="col-12 col-md-3"> <!-- LADO 1 class="hidden" PARAMETROS DEL PREDIO URBANO-->
                         
                          <input   name="idPredioModal_e" class="hidden"   id="idPredioModal_e" />


                         <input   name="idNegocioModal_e" class="hidden"   id="idNegocioModal_e" />



                              <!-- GIRO ESTABLECIMIENTO -->
                            <div class="row "  style="margin-top: 3px; margin-bottom: 3px" >
                              <label for="giroNegocio_e_d" class="cajalabett"> Giro negocio</label>

                                  <select id="giroNegocio_e_d" class="form33" name="giroNegocio_e_d" required >
                                        <option value=""></option> <!-- Para placeholder -->
                                        <?php
                                        //$tabla = 'giro_establecimiento';
                                       // $registros = ControladorPredio::ctrMostrarData($tabla);
                                        $registros = ControladorPredio::ctrMostrarDataGiro();
                                        foreach ($registros as $data_d) {
                                          echo "<option value='" . intval($data_d['Id_Giro_Establecimiento']) . "'>" . htmlspecialchars($data_d['Nombre']) . "</option>";
                                        }
                                        ?>
                                </select>

                            </div>

                          <div class="row">
                            <label for="razon_social" class="cajalabel2">Razón social</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="razon_social_d" id="razon_social_d" maxlength="100" required="">
                          </div>

                            <div class="row">
                            <label for="nro_ruc" class="cajalabel2">Nro RUC</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="nro_ruc_d" id="nro_ruc_d" maxlength="50" required="">
                          </div>

                          
                          <!-- ENTRADA AREA TERRENO-->
                        

                           <div class="row align-items-center">
                                      <div class="d-flex align-items-center">
                                      <span class="cajalabet">¿Cuenta con licencia?</span>
                                      </div>

                                    <div class="col-auto d-flex align-items-center">
                                    <input type="radio" id="tiene_licencia_si" name="licenciN_n_d" value="si" />
                                    <label for="tiene_licencia_si" class="cajalabet">Sí</label>

                                    <input type="radio" id="tiene_licencia_no" name="licenciN_n_d" value="no" />
                                    <label for="tiene_licencia_no" class="cajalabet">No</label>
                                  </div>

                                  <div class="row"  id="licencia_licencia_row_d">
                                          <label for="nro_licencia_d" class="cajalabel22">Nro licencia</label>
                                          
                                           <input type="text" title="Solo se permite todo" class="form33" name="nro_licencia_d" id="nro_licencia_d" maxlength="30" required="">
                         
                                    </div>


                                    </div>




                          
                          <!-- VALOR ARANCEL-->
                         
                        </div>

                           <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                           <div class="row">
                              <label for="tenencia_ne_d" class="cajalabel2"> Tenencia neg. </label>
                              <select class="form33" name="tenencia_ne_d" id="tenencia_ne_d">
                                <option value="" selected="" >Seleccione</option>
                                 <option value="PROPIO"  >Propio</option>
                                  <option value="ALQUILADO"  >Alquilado</option>
                                    <option value="OTRO"  >Otro</option>
                               
                              </select>
                            </div>


                        <!-- Personería (Natural o Jurídica) -->
                    <div class="row">
                      <label for="personeria_ne_d" class="cajalabel2">Personería jurídica</label>
                      <select class="form33" name="personeria_ne_d" id="personeria_ne_d">
                        <option value="" selected>Seleccione</option>
                        <option value="PERSONA_NATURAL">Persona natural</option>
                        <option value="PERSONA_JURIDICA">Persona jurídica</option>
                      </select>
                    </div>

                    <!-- Tipo sociedad (solo se muestra si es PERSONA_JURIDICA) -->
                    <div class="row" id="otroInputRowJuridica" style="display: none;">
                      <label for="tipo_sociedad_d" class="cajalabel2">Tipo sociedad</label>
                      <select class="form33" name="tipo_sociedad_d" id="tipo_sociedad_d">
                        <option value="" selected>Seleccione</option>
                        <option value="SA">S.A.</option>
                        <option value="SAC">S.A.C.</option>
                        <option value="SRL">S.R.L.</option>
                        <option value="EIRL">E.I.R.L.</option>
                      </select>
                    </div>


                             <div class="row">
                            <label for="n_trabajadores_d" class="cajalabel2">N° trabajadores </label>
                            <input type="number" title="Solo se permiten números" class="form33" name="n_trabajadores_d" id="n_trabajadores_d" maxlength="10" required="">
                          </div>

                          
                         
                         
                        </div>


                        <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                        <div class="row">
                            <label for="nMesas_e_d" class="cajalabel2">N° mesas(Restaurante)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="nMesas_e_d" id="nMesas_e_d" maxlength="10" required="">
                        </div>
                          
                          <!-- ENTRADA AREA TERRENO-->
                          <div class="row">
                            <label for="areaNegocio_e_d" class="cajalabel2">Area neg. m2</label>
                            <input type="text" title="Solo se permiten números" class="form33" name="areaNegocio_e_d" id="areaNegocio_e_d" maxlength="10" required="">
                          </div>
                          <!-- VALOR ARANCEL-->

                        <div class="row">
                            <label for="ncuartos_d" class="cajalabel2">N° cuartos(hotel)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="ncuartos_d" id="ncuartos_d" maxlength="10" required="">
                        </div>

                          <div class="row">
                            <label for="ncamas_d" class="cajalabel2">N° camas(hotel)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="ncamas_d" id="ncamas_d" maxlength="10" required="">
                        </div>
                         
                         
                       
                         
                        </div>

                         <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                        <div class="row">
                            <label for="nBano_d" class="cajalabel2">N° baño</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="nBano_d" id="nBano_d" maxlength="10" required="">
                        </div>

                     <div class="row align-items-center">
                      <div class="d-flex align-items-center">
                      <span class="cajalabet">¿Tiene agua negocio?</span>
                      </div>

                     <div class="col-auto d-flex align-items-center">
                    <input type="radio" id="agua_si_n" name="tieneAguan_n" value="si" />
                    <label for="agua_si_n" class="cajalabet">Sí</label>

                    <input type="radio" id="agua_no_n" name="tieneAguan_n" value="no" />
                    <label for="agua_no_n" class="cajalabet">No</label>
                  </div>


                    </div>
                        
                        </div>

                         <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                            <div class="row align-items-center">
                                      <div class="d-flex align-items-center">
                                      <span class="cajalabet">¿Cuenta con ITSE?</span>
                                      </div>

                                    <div class="col-auto d-flex align-items-center">
                                    <input type="radio" id="tiene_itse_si" name="licenciaitse_n_d" value="si" />
                                    <label for="tiene_itse_si" class="cajalabet">Sí</label>

                                    <input type="radio" id="tiene_itse_no" name="licenciaitse_n_d" value="no" />
                                    <label for="tiene_itse_no" class="cajalabet">No</label>
                                  </div>

                                  <div class="row"  id="licencia_itse_row_d">
                                          <label for="fecha_vencimiento_n_d" class="cajalabel22">Fecha vencimiento</label>
                                            <input type="date" title="Solo se permiten números" class="form33" name="fecha_vencimiento_n_d" id="fecha_vencimiento_n_d" maxlength="150" required="">
                                      
                                    </div>


                                    </div>
                                </div>

                       


                        <!--OBSERVACIONES-->
                      </div>
                      
                    </div>
                  </div>
                </div>

        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
   
       <button type="button" class="btn btn-primary" id="btnGuardarEditarNegocio_e"><i class="bi bi-floppy2-fill"></i> Guardar</button>
    
      </div>

<div class="resultados3"></div>

    </div>
  </div>
</div>




<!-- MODAL  AGREGAR NEGOCIO -->





<!-- MODAL ELIMINAR NEGOCIO -->
<div class="modal fade" id="modal_eliminar_negocio" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
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
            <h7>¿Estás seguro de que deseas eliminar este negocio?</h7>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary" id="confirmarEliminarNegocio">Sí, Eliminar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL ELIMINAR NEGOCIO IND -->




<!-- MODAL  AGREGAR NEGOCIO -->
<div class="modal" id="modalRegistrar_negocio">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Agregar negocio</h5>
      </div>
      <div class="modal-body">
        <div class="col-12">

        
         <div id="divDescripPreu" >
                  <div class="box box-success" style="border-top: 0px;">
                    <div class="box-body" style="border: 1px dotted gray;  ">
                      <div class="row">


                        <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                         
                         <input  type="text" name="idPredioModal" class="hidden" id="idPredioModal" />

                              <!-- GIRO ESTABLECIMIENTO -->
                            <div class="row "  style="margin-top: 3px; margin-bottom: 3px" >
                              <label for="giroNegocio_e" class="cajalabett"> Giro negocio</label>

                                  <select id="giroNegocio_e" class="form33" name="giroNegocio_e" required >
                                        <option value=""></option> <!-- Para placeholder -->
                                        <?php
                                      //  $tabla = 'giro_establecimiento';

                                        
                                       // $registros = ControladorPredio::ctrMostrarData($tabla);
                                        $registros = ControladorPredio::ctrMostrarDataGiro();

                                        
                                        foreach ($registros as $data_d) {
                                          echo "<option value='" . intval($data_d['Id_Giro_Establecimiento']) . "'>" . htmlspecialchars($data_d['Nombre']) . "</option>";
                                        }
                                        ?>
                                </select>

                            </div>

                          <div class="row">
                            <label for="razon_social" class="cajalabel2">Razón social</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="razon_social" id="razon_social" maxlength="100" required="">
                          </div>

                            <div class="row">
                            <label for="nro_ruc" class="cajalabel2">Nro RUC</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="nro_ruc" id="nro_ruc" maxlength="50" required="">
                          </div>

                          
                          <!-- ENTRADA AREA TERRENO-->
                           <!-- <div class="row">
                            <label for="nro_licencia" class="cajalabel2">N° licencia</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="nro_licencia" id="nro_licencia" maxlength="30" required="">
                          </div> -->

                          <div class="row align-items-center">
                                      <div class="d-flex align-items-center">
                                      <span class="cajalabet">¿Cuenta con licencia funcio.?</span>
                                      </div>

                                    <div class="col-auto d-flex align-items-center">
                                    <input type="radio" id="tiene_licencia_s" name="licenciN_n" value="si" />
                                    
                                    <label for="tiene_licencia_si" class="cajalabet">Sí</label>

                                    <input type="radio" id="tiene_licencia_n" name="licenciN_n" value="no" />
                                    <label for="tiene_licencia_no" class="cajalabet">No</label>
                                  </div>

                                  <div class="row"  id="licencia_licencia_row">
                                          <label for="nro_licencia" class="cajalabel22">Nro licencia</label>
                                          
                                         <input type="text" title="Solo se permite todo" class="form33" name="nro_licencia" id="nro_licencia" maxlength="30" required="">
                        
                                    </div>


                             </div>

                          
                          <!-- VALOR ARANCEL-->
                         
                        </div>

                           <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                           <div class="row">
                              <label for="tenencia_ne" class="cajalabel2"> Tenencia neg. </label>
                              <select class="form33" name="tenencia_ne" id="tenencia_ne">
                                <option value="" selected="" >Seleccione</option>
                                 <option value="PROPIO"  >Propio</option>
                                  <option value="ALQUILADO"  >Alquilado</option>
                                    <option value="OTRO"  >Otro</option>
                               
                              </select>
                            </div>


                        <!-- Personería (Natural o Jurídica) -->
                    <div class="row">
                      <label for="personeria_ne" class="cajalabel2">Personería jurídica</label>
                      <select class="form33" name="personeria_ne" id="personeria_ne">
                        <option value="" selected>Seleccione</option>
                        <option value="PERSONA_NATURAL">Persona natural</option>
                        <option value="PERSONA_JURIDICA">Persona jurídica</option>
                      </select>
                    </div>

                    <!-- Tipo sociedad (solo se muestra si es PERSONA_JURIDICA) -->
                    <div class="row" id="otroInputRowJuridica" style="display: none;">
                      <label for="tipo_sociedad" class="cajalabel2">Tipo sociedad</label>
                      <select class="form33" name="tipo_sociedad" id="tipo_sociedad">
                        <option value="" selected>Seleccione</option>
                        <option value="SA">S.A.</option>
                        <option value="SAC">S.A.C.</option>
                        <option value="SRL">S.R.L.</option>
                        <option value="EIRL">E.I.R.L.</option>
                      </select>
                    </div>


                             <div class="row">
                            <label for="n_trabajadores" class="cajalabel2">N° trabajadores </label>
                            <input type="number" title="Solo se permiten números" class="form33" name="n_trabajadores" id="n_trabajadores" maxlength="10" required="">
                          </div>

                          
                         
                         
                        </div>


                        <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                        <div class="row">
                            <label for="nMesas_e" class="cajalabel2">N° mesas(Restaurante)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="nMesas_e" id="nMesas_e" maxlength="10" required="">
                        </div>
                          
                          <!-- ENTRADA AREA TERRENO-->
                          <div class="row">
                            <label for="areaNegocio_e" class="cajalabel2">Area neg. m2</label>
                            <input type="text" title="Solo se permiten números" class="form33" name="areaNegocio_e" id="areaNegocio_e" maxlength="10" required="">
                          </div>
                          <!-- VALOR ARANCEL-->

                        <div class="row">
                            <label for="ncuartos" class="cajalabel2">N° cuartos(hotel)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="ncuartos" id="ncuartos" maxlength="10" required="">
                        </div>

                          <div class="row">
                            <label for="ncamas" class="cajalabel2">N° camas(hotel)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="ncamas" id="ncamas" maxlength="10" required="">
                        </div>
                         
                         
                       
                         
                        </div>

                         <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                        <div class="row">
                            <label for="nBano" class="cajalabel2">N° baño</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="nBano" id="nBano" maxlength="10" required="">
                        </div>

                     <div class="row align-items-center">
                      <div class="d-flex align-items-center">
                      <span class="cajalabet">¿Tiene agua negocio?</span>
                      </div>

                     <div class="col-auto d-flex align-items-center">
                    <input type="radio" id="agua_si" name="tieneAguan" value="si" />
                    <label for="agua_si" class="cajalabet">Sí</label>

                    <input type="radio" id="agua_no" name="tieneAguan" value="no" />
                    <label for="agua_no" class="cajalabet">No</label>
                  </div>


                    </div>
                        
                        </div>

                         <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                         <div class="row align-items-center">
                                  <div class="d-flex align-items-center">
                                  <span class="cajalabet">¿Cuenta con ITSE?</span>
                                  </div>

                                <div class="col-auto d-flex align-items-center">
                                <input type="radio" id="agua_si" name="licenciaitse" value="si" />
                                <label for="agua_si" class="cajalabet">Sí</label>

                                <input type="radio" id="agua_no" name="licenciaitse" value="no" />
                                <label for="agua_no" class="cajalabet">No</label>
                              </div>
                               <div class="row"  id="licencia_itse_row">
                                      <label for="fecha_vencimiento" class="cajalabel22">Fecha vencimiento</label>
                                        <input type="date" title="Solo se permiten números" class="form33" name="fecha_vencimiento" id="fecha_vencimiento" maxlength="150" required="">
                                  
                                 </div>


                                </div>
                                </div>

                       


                        <!--OBSERVACIONES-->
                      </div>
                      
                    </div>
                  </div>
                </div>

        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
   
       <button type="button" class="btn btn-primary" id="btnGuardarNegocio_e_a"><i class="bi bi-floppy2-fill"></i> Guardar</button>
    
      </div>

<div class="resultados3"></div>

    </div>
  </div>
</div>
 


<!--====== FIN EDITAR PREDIO =====================-->
<!--====== MODAL DE ELIMINAR PREDIO -->
<div class="modal fade" id="modalEliminarPredio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Predio</h5>
      </div>
      <div class="modal-body">
        <div class="form-group predio_catastro_eliminar bg-success p-2 text-dark bg-opacity-25">
          <!--CONTENIDO DINAMICO DEL PREDIO A TRANSFERIR -->
        </div>
        <label for="" class="lbl-text">Ingrese Sustento</label>
        <div class="row2"> <!--Datos del Predio-->
          <input type="text" class="form-control " id="documento_eliminar" name="documento_eliminar" placeholder="Documento Sustentatorio para eliminar el Predio" required="">
        </div>
        <div id="error_eliminar">
          <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary btnEliminarPredio">Eliminar</button>
      </div>
    </div>
  </div>
</div>
<!--====== FIN DEL MODAL ELIMINAR PREDIO =========-->
<!--====== MODAL AGREGAR PISO =============-->
<div class="modal" id="modalAgregarPiso">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <label class="modal-title"> NUEVO PISO</label>
      </div>

      <div class="modal-body">
        <form role="form" method="POST" enctype="multipart/form-data" class="formRegistrarPiso" id="formRegistrarPiso">

          <div class="row2"> <!--Datos del Predio-->
            <label class="cajalabel" for=""> Codigo Predio: </label>
            <input type="text" class="form2" name="idCatastroRow" id="idCatastroRow" disabled="true">
            <label class="cajalabel" for=""> Año Fiscal: </label>
            <input type="text" class="form2" name="anioFiscal" id="anioFiscal" disabled="true">
            <button type="button" class="btn btn-primary " id="btnVerCuadroValor">
            Ver Cuadro Valor
          </button>
          </div>

          <div class="row"> <!--Datos del Piso-->
            <fieldset style="border: 1px dotted #000;">
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Estado Conservacion:</label>
                <select name="estadoConservaImp" class="form2" id="estadoConservaImp">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'estado_conservacion';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Estado_Conservacion'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Clasificacion Piso: </label>
                <select name="clasificaPisoImp" class="form2" id="clasificaPisoImp">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'clasificacion_piso';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Clasificacion_Piso'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Numero Piso: </label>
                <input type="text" name="numeroPiso" id="numeroPiso" class="form2" disabled="true">
              </div>
              <!--<div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Incrememto: </label>
                <input type="text" class="form2" value="1" disabled="true">
              </div>-->
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Años Antiguedad: </label>
                <input id="aniosAntiguedadImp" name="aniosAntiguedadImp" type="text" class="form2" disabled>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Material Predominante: </label>
                <select name="materialConsImp" class="form2" id="materialConsImp">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'material_piso';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Material_Piso'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Fecha Construccion: </label>
                <input id="fechaAntiguedad" name="fechaAntiguedad" type="date" class="form2">
              </div>
            </fieldset>
          </div>

          <!-- Valores de Edificacion del Piso -->
          <div class="row2 col-md-6">
            <fieldset style="border: 1px dotted #000; padding: 5px;">
              <legend>Valores Unitarios de Edificacion</legend>
              <div>
                <label for="" class="cajalabel2">Muros y Columnas</label>
                <select name="murosColumnas" id="murosColumnas">
                  <option selected="" disabled="true">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorMuros" class="form3" disabled="true">
              </div>

              <div>
                <label for="techos" class="cajalabel2">Techos</label>
                <select name="techos" id="techos">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorTechos" class="form3" disabled="true">
              </div>

              <div>
                <label for="" class="cajalabel2">Pisos</label>
                <select name="pisos" id="pisos">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorPisos" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Puertas y Ventanas</label>
                <select name="puertasVentanas" id="puertasVentanas">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorPuertasyVentanas" class="form3" disabled="true">
              </div>

              <div>
                <label for="" class="cajalabel2">Revestimientos</label>
                <select name="revestimiento" id="revestimiento">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorRevestimientos" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Baños</label>
                <select name="banios" id="banios">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorBaños" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Instalaciones</label>
                <select name="OtrasInsta" id="OtrasInsta">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorOtrasInsta" class="form3">
              </div>

            </fieldset>
          </div>

          <!-- Categorias del Piso -->
          <div class="row2 col-md-6">
            <div> <label for="" class="cajalabel2">Valor Unitario</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valUnitariosCal" id="valUnitariosCal"></div>
            <!--<div> <label for="" class="cajalabel2">Incrementos</label><input type="text" value="S/." class="form4" disabled><input type="text" name="" id="" disabled="true"></div>-->
            <div> <label for="" class="cajalabel2">Tasa de Depreciacion</label><input type="text" name="tasaDepreCal" id="tasaDepreCal" class="form4" disabled="true"><input type="text" name="depresiacionInp" id="depresiacionInp"><input type="button" value="Depreciar" id="btnDepreciar" class="btn btn-info"></div>
            <div> <label for="" class="cajalabel2">Valor Unit. Depreciado</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valUniDepreciadoImp" id="valUniDepreciadoImp"></div>
            <div> <label for="" class="cajalabel2">Area Construida</label><input type="text" value="m2" class="form4" disabled><input type="text" class="input_import" name="areaConstruidaImp" id="areaConstruidaImp"></div>
            <div> <label for="" class="cajalabel2">Valor Area Construida </label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorAreaConstruImp" id="valorAreaConstruImp"></div>
            <div> <label for="" class="cajalabel2">Areas Comunes</label><input type="text" value="m2" class="form4" disabled><input type="text" name="areaComunesImp" id="areaComunesImp"></div>
            <div> <label for="" class="cajalabel2">Valores Areas Comunes</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorAreComunImp" id="valorAreComunImp"></div>
            <div> <label for="" class="cajalabel2">Valor de Construcion </label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorConstrucionCal" id="valorConstrucionCal"></div>
          </div>

          <div class="modal-footer">
            <button type="button" id="salirRegistroModal" class="btn btn-secondary btn-cancelar">Salir</button>
            <button type="button" class="btn btn-primary" id="btnRegistrarPiso">Registrar</button>
          </div>
          <div class="row2 col-md-12" id="errorPiso">
            <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
</div>
<!--====== FIN DEL MODAL AGREGAR PISO ============-->
<!--====== MODAL EDITAR PISO =============-->
<div class="modal" id="modalEditarPiso">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> EDITAR PISO</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" enctype="multipart/form-data" class="formEditarPiso" id="formEditarPiso">
          <div class="row2"> <!--Datos del Predio-->
            <label class="cajalabel" for=""> Codigo Predio: </label>
            <input type="text" class="form2" name="idCatastroEdit" id="idCatastroEdit" disabled="true">
            <label class="cajalabel" for=""> Año Fiscal: </label>
            <input type="text" class="form2" name="anioFiscalEdit" id="anioFiscalEdit" disabled="true">
            <button type="button" class="btn btn-primary " id="btnEditarCuadroValor">
            Ver Cuadro Valor
          </button>

          </div>
          <div class="row"> <!--Datos del Piso-->
            <fieldset style="border: 1px dotted #000;">
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Estado Conservacion:</label>
                <select name="estadoConservaEdit" class="form2" id="estadoConservaEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'estado_conservacion';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Estado_Conservacion'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Clasificacion Piso: </label>
                <select name="clasificaPisoEdit" class="form2" id="clasificaPisoEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'clasificacion_piso';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Clasificacion_Piso'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Numero Piso: </label>
                <input type="text" name="numeroPisoEdit" id="numeroPisoEdit" class="form2" disabled="true">
              </div>

              <!--<div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Incrememto: </label>
                <input type="text" class="form2" value="1" disabled="true">
              </div> -->
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Años Antiguedad: </label>
                <input id="aniosAntiguedadEdit" name="aniosAntiguedadEdit" type="text" class="form2" disabled>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Material Predominante: </label>
                <select name="materialConsEdit" class="form2" id="materialConsEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'material_piso';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Material_Piso'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Antifuedad: </label>
                <input id="fechaAntiguedadEdit" name="fechaAntiguedadEdit" type="date" class="form2">
              </div>
            </fieldset>
          </div>
          <!-- Valores de Edificacion del Piso -->
          <div class="row2 col-md-6">
            <fieldset style="border: 1px dotted #000; padding: 5px;">
              <legend>Valores Unitarios de Edificacion</legend>
              <div>
                <label for="" class="cajalabel2">Muros y Columnas</label>
                <select name="murosColumnasEdit" id="murosColumnasEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorMurosEdit" class="form3" disabled="">
              </div>

              <div>
                <label for="techos" class="cajalabel2">Techos</label>
                <select name="techosEdit" id="techosEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorTechosEdit" class="form3" disabled="">
              </div>

              <div>
                <label for="" class="cajalabel2">Pisos</label>
                <select name="pisosEdit" id="pisosEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorPisosEdit" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Puertas y Ventanas</label>
                <select name="puertasVentanasEdit" id="puertasVentanasEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorPuertasyVentanasEdit" class="form3" disabled="">
              </div>

              <div>
                <label for="" class="cajalabel2">Revestimientos</label>
                <select name="revestimientoEdit" id="revestimientoEdit">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorRevestimientosEdit" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Baños</label>
                <select name="baniosEdit" id="baniosEdit">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorBaniosEdit" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Instalaciones</label>
                <select name="OtrasInstaEdit" id="OtrasInstaEdit">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorOtrasInstaEdit" class="form3">
              </div>

            </fieldset>
          </div>
          <!-- Categorias del Piso -->
          <div class="row2 col-md-6">
            <div> <label for="" class="cajalabel2">Valor Unitario</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valUnitariosEdit" id="valUnitariosEdit" disabled=""></div>
            <!--<div> <label for="" class="cajalabel2">Incrementos</label><input type="text" value="S/." class="form4" disabled><input type="text" name="" id=""></div>-->
            <div> <label for="" class="cajalabel2">Tasa de Depreciacion</label><input type="text" name="tasaDepreEdit" id="tasaDepreEdit" class="form4" disabled><input type="text" name="depresiacionEdit" id="depresiacionEdit" disabled=""><input type="button" value="Depreciar" id="btnDepreciarEdit" class="btn btn-info"></div>
            <div> <label for="" class="cajalabel2">Valor Unit. Depreciado</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valUniDepreciadoEdit" id="valUniDepreciadoEdit" disabled=""></div>
            <div> <label for="" class="cajalabel2">Area Construida</label><input type="text" value="m2" class="form4" disabled><input type="text" name="areaConstruidaEdit" id="areaConstruidaEdit"></div>
            <div> <label for="" class="cajalabel2">Valor Area Construida </label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorAreaConstruEdit" id="valorAreaConstruEdit" disabled=""></div>
            <div> <label for="" class="cajalabel2">Areas Comunes</label><input type="text" value="m2" class="form4" disabled><input type="text" name="areaComunesEdit" id="areaComunesEdit" disabled=""></div>
            <div> <label for="" class="cajalabel2">Valores Areas Comunes</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorAreComunEdit" id="valorAreComunEdit" disabled=""></div>
            <div> <label for="" class="cajalabel2">Valor de Construcion </label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorConstrucionEdit" id="valorConstrucionEdit" disabled=""></div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSalirModalEditar" class="btn btn-secondary btn-cancelar">Salir</button>

            <button type="button" class="btn btn-primary" id="btnRegistrarEditar">Registrar Cambios</button>
          </div>
          <div class="row2 col-md-12" id="errorPiso">
            <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
          </div>
        </form>
      </div>
      <div id="respuestaFechaEdit"></div>
    </div>
  </div>
</div>
<!--====== FIN DEL MODAL EDITAR PISO =============-->
<?php
        } else {
          echo "<div>error al cargar la pagina</div>";
        } ?>
<!--====== MODAL BUSCAR PROPIETARIO - LISTA PREDIOS-->
<div class="modal" id="modalPropietarios">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> BUSCAR PROPIETARIO</h5>
      </div>

      <div class="modal-body">
        <div class="col-12">
          <?php include_once "table-propietarios.php";  ?>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary btn-guardar" data-dismiss="modal">Guardar</button>
      </div>

    </div>
  </div>
</div>


<!--  MODAL VIAS -->
<div class="modal" id="modalViacalle_Predio">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> UBICACION DEL PREDIO</h5>
      </div>
      <div class="modal-body">
        <div class="col-12">
          <?php include_once "table-viacallePredioEdit.php";  ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>


<!--====== MODAL BUSCAR UBICACION PREDIO URBANO-->
<div class="modal" id="modalViacalle_Predioe">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> UBICACION DEL PREDIO</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="clasificador_descripcion" class="bmd-label-floating">Localidad</label>
          <input type="text" class="form-control" name="localidad" id="localidad" maxlength="50" required="" disabled="" value="Puquio">
        </div>
        <div class="col-12">
          <?php include_once "table-viacallePredio.php";  ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="moda_PredioRusticoe">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> UBICACION DEL RUSTICO EDITAR</h5>
      </div>
      <div class="modal-body">
        <div class="col-12">
          <?php include_once "table-viaPredioRusticoe.php";  ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>





<!-- MODAL CONFIRMAR LA TRANSFERENCIA SI O NO -->
<div class="modal fade" id="modal_transferir_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        CONFIRMAR TRANSFERIR PREDIO
      </div>
      <div class="modal-body">
        <h7>Estas Seguro Transferir el Predio ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary confirmar_transferencia_si">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL  CONFIRMAR TRANSFERENCIA SI O NO -->

<!-- MODAL CONFIRMAR LA COPIAR FORZOSAMENTE SI O NO -->
<div class="modal fade" id="modal_forzosamente_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        COPEAR PREDIO FORZOSAMENTE
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de remplazar el Predio ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary confirmar_copear_forzosamente_si">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL  CONFIRMAR TRANSFERENCIA SI O NO -->


<!--====== VER CUADRO DE VALORES =======-->
<div class="modal" id="modalVerCuadroValor" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form role="form" id="formPredioLitigio" method="post" enctype="multipart/form-data">
      
      <div class="modal-header">
        <label class="modal-title">Cuadro de valores unitarios oficiales de edificaciones de la sierra</label>
      </div>
          <div class="modal-body">
            <p style="text-align: center;">Cuadro de valores unitarios oficiales de edificacion para la sierra (Vigente desde 01 al 31 de julio del 2025)</p>
              <div style="max-height: 600px; overflow-y: auto;">
            <table class="table table-bordered">
              <thead>
                <tr >
                  <th> </th>
                  <th style="text-align: center;">Muros y columnas</th>
                  <th style="text-align: center;">Techos</th>
                  <th style="text-align: center;">Puertas y ventanas</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td> <strong>A</strong> </td>
                  <td>
                      <p style="text-align: center;">  Estructuras laminares curvadas de concreto armado que incluyen en una sola armadura la cimentación y el techo, para este caso no se considera los valores de la columna N° 2
                      </p>
                      <p style="text-align: center;"><strong> 715.43</strong> </p>

                  </td>

                  <td>
                    <p style="text-align: center;">
                      Losa o aligerado de concreto armado con luces mayores de 6 m. con sobrecarga mayor a 300 kg/m2
                    </p>
                      <p style="text-align: center;"><strong> 372.01</strong> </p>
                    
                  </td>
                 
                 
                  <td>
                    <p style="text-align: center;">
                      Aluminio pesado con perfiles especiales madera fina ornamental (caoba, cedro o pino selecto) vidrio insulado.
                
                    </p>
                    <p style="text-align: center;"><strong> 282.37 </strong> </p>
                    
                  </td>
                </tr>
                <tr>
                  <td> <strong>B</strong> </td>
                  <td>
                    <p style="text-align: center;">
                      columnas, vigas y/o placas de concreto armado y/o metálicas.
                    </p>

                     <p style="text-align: center;"><strong> 425.64 </strong> </p>
                    
                  </td>


                  <td>
                    <P style="text-align: center;">aligerados o losas de concreto armado inclinadas</P>
                     <p style="text-align: center;"><strong> 255.75 </strong> </p>
                  </td>
                  <td>
                    <P style="text-align: center;">Aluminio o madera fina (caoba o similar) de diseño especial, vidrio tratado polarizado (2) y curvado, laminado o templado</P>
                    <p style="text-align: center;"><strong> 249.87 </strong> </p>
                
                  </td>
                </tr>
                 <tr>
                  <td> <strong>C</strong> </td>
                  <td>
                    <p style="text-align: center;">
                      Placas de concreto de 10 a 15 cm albñilería armada, ladrillo o similar con columnas y vigas de amarre de concreto armado
                    </p>

                     <p style="text-align: center;"><strong> 308.81 </strong> </p>
                    
                  </td>


                  <td>
                    <P style="text-align: center;">Aligerado o losas de concreto armado horizontales</P>
                     <p style="text-align: center;"><strong> 178.97 </strong> </p>
                  </td>
                  <td>
                    <P style="text-align: center;">
                     Aluminio o madera fina (caoba o similar) vidrio tratado polarizado (2) laminado o templado
                    </P>
                    <p style="text-align: center;"><strong> 182.31 </strong> </p>
                
                  </td>
                </tr>

                  <tr>
                  <td style="text-align: center;"> <strong>D</strong> </td>
                  <td>
                    <p style="text-align: center;">
                     ladrillo o similar sin elementos de concreto armado, drywall o similar incluye techo (5)
                    </p>

                     <p style="text-align: center;"><strong> 285.24 </strong> </p>
                    
                  </td>


                  <td>
                    <P style="text-align: center;">Calamina metálica fibrocemento sobre viguería metálica</P>
                     <p style="text-align: center;"><strong> 135.44 </strong> </p>
                  </td>
                  <td>
                    <P style="text-align: center;">
                     Ventanas de aluminio, puertas de madera selecta, vidrio tratado trasnparente (3)
                    </P>
                    <p style="text-align: center;"><strong> 106..92 </strong> </p>
                
                  </td>
                </tr>
                <!-- Agrega más filas aquí -->

                  <tr>
                  <td> <strong>E</strong> </td>
                  <td>
                    <p style="text-align: center;">
                   Adobe, tapial o quincha banbú estructural.
                    </p>

                     <p style="text-align: center;"><strong> 223.92 </strong> </p>
                    
                  </td>


                  <td>
                    <P style="text-align: center;">
                     Madera con material impermeabilizante policarbonato.

                    </P>
                     <p style="text-align: center;"><strong> 55.62 </strong> </p>
                  </td>
                  <td>
                    <P style="text-align: center;">
                    Ventanas de fierro, puertas de madera selecta(Kaobra o similar) vidrio simple transparente(4)
                    </P>
                    <p style="text-align: center;"><strong> 81.68 </strong> </p>
                
                  </td>
                </tr>

                
                  <tr>
                  <td> <strong>F</strong> </td>
                  <td>
                    <p style="text-align: center;">
                   Madera (estoraque, pumaquiro, huayruro, machinga, catahua amarillo, copaiba, diablo fuerte, tornillo o similares), dry wall o similar (sin techo)
                    </p>

                     <p style="text-align: center;"><strong> 139.63 </strong> </p>
                    
                  </td>


                  <td>
                    <P style="text-align: center;">
                    Calamina metálica fibrocemento o teja sobre viguería de madera corriente

                    </P>
                     <p style="text-align: center;"><strong> 44.44 </strong> </p>
                  </td>
                  <td>
                    <P style="text-align: center;">
                 ventanas de fierro o aluminio industrial, puertas de fierro, puertas contraplacadas de madera (cedro o similar), puertas material mdf o hdf, vidrio simple transparente (4).
                  </P>
                    <p style="text-align: center;"><strong> 63.17 </strong> </p>
                
                  </td>
                </tr>

                   
                  <tr>
                  <td>G</td>
                  <td>
                    <p style="text-align: center;">
                     Pircado con mezcla de barro
                  </p>

                     <p style="text-align: center;"><strong> 82.27 </strong> </p>
                    
                  </td>


                  <td>
                    <P style="text-align: center;"  >
                    Sin techo

                    </P>
                     <p style="text-align: center;"><strong> 0.00 </strong> </p>
                  </td>
                  <td>
                    <P style="text-align: center;">
                MAdera corriente con marcos en puerta y ventanas de pvc o madera corriente.
                </P>
                    <p style="text-align: center;"><strong> 37.22 </strong> </p>
                
                  </td>
                </tr>

                <tr>
                  <td>H</td>
                  <td>
                    <p>
                 
                  </p>

                     <p style="text-align: center;"><strong> - </strong> </p>
                    
                  </td>


                  <td>
                    <P>


                    </P>
                     <p style="text-align: center;"><strong> - </strong> </p>
                  </td>
                  <td>
                    <P style="text-align: center;">
                Madera rústica
                </P>
                    <p style="text-align: center;"><strong> 18.61 </strong> </p>
                
                  </td>
                </tr>


                
                <tr>
                  <td>I</td>
                  <td>
                    <p>
                 
                  </p>

                     <p style="text-align: center;"><strong> - </strong> </p>
                    
                  </td>


                  <td>
                    <P>
                    

                    </P>
                     <p style="text-align: center;"><strong> - </strong> </p>
                  </td>
                  <td>
                    <P style="text-align: center;">
                  Sin puerta ni ventanas
                </P>
                    <p style="text-align: center;"><strong> 0.00 </strong> </p>
                
                  </td>
                </tr>


              </tbody>
            </table>
            </div>

          </div>


      <div class="modal-footer">

      <div class="row">

       

         <div class="col-12 col-md-">
           <button type="button" class="btn btn-secondary" id="salir_modal_litigio" data-dismiss="modal">Salir</button>
      
          
        </div>

      </div>

     
       
      </div>

      </form>

    </div>
  </div>
</div>

<!--====== VER CUADRO DE VALORES =======-->




<!--=============== MODAL EDITAR CONTRIBUYENTE===============-->
<div id="modalEditarcontribuyente" class="modal fade modal-forms  fullscreen-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" id="formEmpresa" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idc" id="idc">
        <input type="hidden" name="iduc" id="iduc">
        <input type="hidden" name="idrc" id="idrc" value="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>EDITAR CONTRIBUYENTE</caption>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="text-bordeada">
              <caption>Datos del Contribuyente</caption>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="" class="lbl-text">Tipo Contribuyente</label>
                <div class="input-group">
                  <select class="form-control" name="e_tipoContribuyente" id="e_tipoContribuyente" value="">
                    <?php
                    $tabla_tipo = 'tipo_contribuyente';
                    $tipo = ControladorContribuyente::ctrMostrarData($tabla_tipo);
                    foreach ($tipo as $data_tipo) {
                      echo "<option value='" . $data_tipo['Id_Tipo_Contribuyente'] . "'>" . $data_tipo['Tipo'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="" class="lbl-text">Tipo Documento</label>
                <div class="input-group">
                  <select class="form-control" name="e_tipoDoc" id="e_tipoDoc">
                    <?php
                    $tabla_documento = 'tipo_documento_siat';
                    $documento = ControladorContribuyente::ctrMostrarData($tabla_documento);
                    foreach ($documento as $data_d) {
                      echo "<option value='" . $data_d['Id_Tipo_Documento'] . "'>" . $data_d['descripcion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="" class="lbl-text">N° Documento</label>
                <div class="input-group">
                  <input type="text" class="form-control"  style="transition: all 0.5s ease; border-radius: 5px;"  id="e_docIdentidad" name="e_docIdentidad" placeholder="Número de documento...">
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="" class="lbl-text">Cod. Antiguo</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="e_codigo_sa" name="e_codigo_sa" placeholder="Codigo antiguo">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="" class="lbl-text">Nombre o Razon social</label>
                <div class="input-group-adddon">
                  <input type="text" class="form-control" id="e_razon_social" name="e_razon_social" placeholder="Ingrese nombre o razón social...">
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="e_clasificacion" class="lbl-text">Clasificacion</label>
                <div class="input-group">
                  <select class="form-control" name="e_clasificacion" id="e_clasificacion" value="">
                    <?php
                    $tabla_cla = 'clasificacion_contribuyente';
                    $clasificacion = ControladorContribuyente::ctrMostrarData($tabla_cla);
                    foreach ($clasificacion as $data_cla) {
                      echo "<option value='" . $data_cla['Id_Clasificacion_Contribuyente'] . "'>" . $data_cla['Clasificacion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="" class="lbl-text">Apellido Paterno</label>
                <div class="input-group-adddon">
                  <input type="text" class="form-control" id="e_apellPaterno" name="e_apellPaterno" placeholder="Ingrese Apellido Paterno ...">
                  <!-- <span class="input-group-addon"></span>  -->
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="e_condicionContri" class="lbl-text">Condicion Contribuyente</label>
                <div class="input-group">
                  <select class="form-control" name="e_condicionContri" id="e_condicionContri" value="">
                    <?php
                    $tabla_cla = 'condicion_contribuyente';
                    $clasificacion = ControladorContribuyente::ctrMostrarData($tabla_cla);
                    foreach ($clasificacion as $data_cla) {
                      echo "<option value='" . $data_cla['Id_Condicion_Contribuyente'] . "'>" . $data_cla['Condicion_Contribuyente'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="e_apellMaterno" class="lbl-text">Apellido Materno</label>
                <div class="input-group-adddon">
                  <input type="text" class="form-control" id="e_apellMaterno" name="e_apellMaterno" placeholder="Ingrese Apellido Materno ...">
                </div>
              </div>
            </div>


            
            <div class="col-md-5">
              <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                <label for="e_apellMaterno" class="lbl-text">Coactivo</label>
                <div class="input-group">
                  <input type="checkbox" data-toggle="toggle" id="usuarioCoactivo" check="1" uncheck="0" data-size="mini" data-width="110">
                </div>
              </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                    <label for="e_afallecido" class="lbl-text">Fallecido</label>
                    <div class="input-group">
                      <input type="checkbox" data-toggle="toggle" id="usuarioFallecida" check="1" uncheck="0" data-size="mini" data-width="110">
                    </div>
                  </div>

                </div>

                  </div>
              
              
            </div>



          </div>


          <div class="box-body">
            <div class="row nuevoVia">

              <div class="text-bordeada">
                <caption>Domicilo Fiscal del Contribuyente</caption>
                <button type="button" class="pull-right boton-direccion" data-toggle="modal" data-target="#modalViascalles">Direccion<img src='./vistas/img/iconos/direccion4.png' class="icon-direccion pull-right"></button>
              </div>
            </div>
            <div class="row">
              <div class="items-c">
                <table class="table-container" style="box-sizing: border-box;">
                  <thead>
                    <tr>
                      <th class="text-center">Nombre Via</th>
                      <th class="text-center">Manzana</th>
                      <th class="text-center">Cuadra</th>
                      <th class="text-center">Lado</th>
                      <th class="text-center">Zona</th>
                      <th class="text-center">Habilitacion</th>
                      <th class="text-center">Cod. Via</th>
                    </tr>
                  </thead>
                  <tbody id="itemsRC">
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <label for="" class="lbl-text">Numeracion</label>
                <div class="form-group">
                  <input type="text" class="form-control" id="e_nroUbicacion" name="e_nroUbicacion" placeholder="Nro. Ubicacion...">
                </div>
              </div>
              <div class="col-md-2">
                <label for="" class="lbl-text">N° Lote</label>
                <div class="form-group">
                  <input type="text" class="form-control" id="e_nroLote" name="e_nroLote" placeholder="Nro. Lote ...">
                </div>
              </div>
              <div class="col-md-2">
                <label for="e_nroDepartamento" class="lbl-text">N° Dept.</label>
                <div class="form-group">
                  <input type="text" class="form-control" id="e_nroDepartamento" name="e_nroDepartamento" placeholder="Nro. Departamento...">
                </div>
              </div>
              <div class="col-md-2">
                <label for="e_nrobloque" class="lbl-text">N° Bloque</label>
                <div class="form-group">
                  <input type="text" class="form-control" id="e_nrobloque" name="e_nrobloque" placeholder="Nro. Bloque...">
                </div>
              </div>
              <div class="col-md-2">
                <label for="e_nroLuz" class="lbl-text">N° Luz</label>
                <div class="form-group">
                  <input type="text" class="form-control" id="e_nroLuz" name="e_nroLuz" placeholder="Nro. Recibo Luz...">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <label for="e_referencia" class="lbl-text">Referencia</label>
              <div class="form-group">
                <input type="text" class="form-control" id="e_referencia" name="e_referencia" placeholder="Referencia...">
              </div>
            </div>
            <div class="col-md-4 col-xs-3">
              <div class="form-group">
                <label for="e_condicionpredio" class="lbl-text">Cond. Propietario</label>
                <div class="input-group">
                  <select class="form-control" name="e_condicionpredio" id="e_condicionpredio" value="">
                    <?php
                    $tabla = 'condicion_predio_fiscal';
                    $condicion = ControladorContribuyente::ctrMostrarData($tabla);
                    foreach ($condicion as $data_c) {
                      echo "<option value='" . $data_c['Id_Condicon_Predio_Fiscal'] . "'>" . $data_c['Descripcion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-body">

            <div class="text-bordeada">
              <caption>Datos de Contacto</caption>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="" class="lbl-text">N° Celular</label>
                <div class="input-group-adddon">
                  <!-- <input type="text" class="form-control" id="e_telefono" name="e_telefono" placeholder="Nro  Celular/Telefono..."> -->
                  <input type="text" class="form-control" style="transition: all 0.5s ease; border-radius: 5px;" id="e_telefono" name="e_telefono" placeholder="celular...">
              

                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="" class="lbl-text">Correo</label>
                <div class="input-group-adddon">
                  <input type="text" class="form-control" style="transition: all 0.5s ease; border-radius: 5px;"   id="e_correo" name="e_correo" placeholder="Correo Electronico...">
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="" class="lbl-text">Observaciones</label>
                <div class="input-group-adddon">
                  <input type="text" class="form-control" id="e_observacion" name="e_observacion" placeholder="Observacioenes...">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <label class="btn btn-danger pull-left" data-dismiss="modal">Salir</label>
          <button type="sudmit" class="btn btn-primary">Guardar cambios</button>
        </div>
        <?php
        //  $editarProducto = new ControladorContribuyente();
        //  $editarProducto->ctrEditarContribuyente();
        ?>
      </form>
    </div>
  </div>
</div>



<!--FIN DE MODAL EDITAR CONTRIBUYENTE -->

<!-- editar direccion del contribuyente -->
<div class="modal fade bd-example-modal-lg" id="modalViascalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <caption>DIRECCION FISCAL</caption>
      </div>
      <div class="modal-body table-responsive">
        <div class="row">
          <div class="contenedor-busqueda">
            <div class="input-group-search">
              <div class="input-search">
                <input type="search" class="search_direccion" id="searchViacalle" name="searchViacalle" placeholder="Ingrese Nombre de Via o Calle..." onkeyup="loadViacalle(1,'#itemsRC')">
                <input type="hidden" id="perfilOculto_v" value="<?php echo $_SESSION['perfil'] ?>">
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 divDetallePredio">
          <?php include_once "table-viacalle.php";  ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>

      </div>
    </div>
  </div>
</div>
<!-- fin de editar direccion de contribuyente -->





<!-- MODAL ELIMINAR PISO -->
<div class="modal fade" id="modal_eliminar_piso" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
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
            <h7>¿Estás seguro de que deseas eliminar este piso?</h7>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary" id="confirmarEliminarPiso">Sí, Eliminar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!--end  MODAL ELIMINAR PISO -->


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


<!--FIN MODAL ANEXO 17 -->abrirResoSuspencion
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

<!-- modal donde se genera el pdf oden pago - impuesto-->
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


<!-- SECCION DE CALCULAR IMPUESTO - FORMATOS Y TIM -->
<div class="modal fade" id="modal_predio_propietario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-content-e">
      <div class="modal-body">
        <table class="table-container">
          <thead>
            <th class="text-center">Calcular Impuesto-Arbitrios</th>
            <th class="text-center">Imprimir Formatos</th>
            <th class="text-center">Calcular TIM</th>
          </thead>
          <tbody class="m_predio_propietario">
            <tr>
              <th class="text-center"> <img src="./vistas/img/iconos/calcular_impuesto.png" class="t-icon-tbl-imprimir btnCalcular_impuesto" title="Calcular Impuesto"></th>
              <th class="text-center"> <img src="./vistas/img/iconos/FORMATO.png" class="t-icon-tbl-imprimir btnImprimir_cartilla" title="Imprimir Formato" data-toggle="modal" data-target="#modalImprimirFormato"></th>
              <th class="text-center"> <img src="./vistas/img/iconos/PORCENTAJE.png" class="t-icon-tbl-imprimir_tim btnCalcularTim_img" title="Calcular T.I.M" data-toggle="modal" data-target="#modalCalcularTim"></th>
            </tr>

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
      </div>

    </div>
  </div>
</div>
<!-- CALCULAR IMPUESTO SECCION DE ICONOS FIN -->

<!-- SECCION DE FOTO-->
<!-- <div class="modal fade" id="modal_foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-content-e">
      <div class="modal-header">
        Gestionar Fotos
      </div>
      <div class="modal-body">
        <span>Sube tus imágenes (máximo 3)</span>
        <input type="file" id="imageInput" multiple accept="image/*" capture="environment">
        
        <span>Toma (máximo 3)</span>

          <input type="file" id="imageInput" accept="image/*" capture="environment" >


        <div class="image-container" id="imageContainer"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" id="popiguardarfoto">Guardar</button>
      </div>
    </div>
  </div>
</div> -->


    <div class="modal fade" id="modal_foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);">
          <!-- Encabezado del modal con color suave y texto centrado -->
          <div class="modal-header" style="background-color: #6c757d; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <h4 class="modal-title" id="exampleModalCenterTitle" style="text-align: center;">Gestionar Foto</h4>
          </div>

          <!-- Cuerpo del modal con contenido y espacio más organizado -->
          <div class="modal-body" style="padding: 25px; text-align: center;">
            <p style="font-size: 18px; font-weight: 500; color: #555;">Sube tu imagen (máximo 1)</p>
            
            <!-- Input de imagen con estilo sencillo y moderno -->
            <input type="file" id="imageInput" accept="image/*" capture="environment" 
                  class="form-control" >
            
            <!-- Contenedor para las imágenes subidas -->
            <div class="image-container" id="imageContainer" style="margin-top: 20px; text-align: center;"></div>
          </div>

          <!-- Pie del modal con botones con bordes suaves -->
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
            <button type="button" class="btn btn-primary" id="popiguardarfoto">Guardar</button>
          </div>
        </div>
      </div>
    </div>
<!-- FIN DE SECCION DE FOTO -->





<!-- SECCION DE FOTO-->
<div class="modal fade" id="modal_foto_ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-content-e">
      <div class="modal-body">
        <div class="row div_fotos">
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
            </ol>
            <div class="carousel-inner">
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span></a><a class="right carousel-control"
              href="#carousel-example-generic" data-slide="next"><span class="glyphicon glyphicon-chevron-right">
              </span></a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN DE SECCION DE FOTO -->



<!-- modal cargando -->
<?php include_once "proceso-calcular-impuesto.php";  ?>
<!-- fin de modal cargando-->

<!-- modal cargando -->
<?php include_once "modalcargar.php";  ?>
<!-- fin de modal cargando-->