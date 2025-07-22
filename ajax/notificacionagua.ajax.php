<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorNotificacion;
use Modelos\ModeloUsuarios;

class AjaxNotificacion
{

    //mostrar lista de usuarios
    public function ajaxLista_Notificion()
{   
    $filtroNombre = isset($_POST['filtro_nombre']) ? $_POST['filtro_nombre'] : '';
    $filtroFecha = isset($_POST['filtro_fecha']) ? $_POST['filtro_fecha'] : '';
    $filtroEstado = isset($_POST['filtro_estado']) ? $_POST['filtro_estado'] : '';
    $pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1; // Obtener página actual
    
    // Paginación: resultados por página
    $resultados_por_pagina = 15; // Establecer el número de resultados por página

    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorNotificacion::ctrMostrarNotificaciones($filtroNombre, $filtroFecha, $filtroEstado, $pagina, $resultados_por_pagina);
  
  
    echo $respuesta;
  
    
}



    // public function ajaxLista_Notificion()
    // {   
    //       $filtroNombre = isset($_POST['filtro_nombre']) ? $_POST['filtro_nombre'] : '';
    //        $filtroFecha = isset($_POST['filtro_fecha']) ? $_POST['filtro_fecha'] : '';
    //         $filtroEstado = isset($_POST['filtro_estado']) ? $_POST['filtro_estado'] : '';
    
       
    //     $respuesta = ControladorNotificacion::ctrMostrarNotificaciones($filtroNombre, $filtroFecha,$filtroEstado);
    //     echo $respuesta;
    // }

     //mostrar lista de usuarios
        public function ajaxEditar_Notificion_guardar() {   
            // Se obtiene el ID, el estado y la observación del formulario enviado mediante AJAX
            $datos = array(
                'idNotificacion' => $_POST["idNotificacionA"],
                'estado' => $_POST["estadoN"],
                'observacion' => $_POST["observacionN"]
            );

            // Se llama a la función del controlador que maneja la lógica de guardar la notificación
            $respuesta = ControladorNotificacion::ctrMostrarGuardarNotificaciones($datos);

                    $respuesta_json = json_encode($respuesta);
                    header('Content-Type: application/json');
                    echo $respuesta_json;
        }

          public function ajaxEliminar_Notificion() {   
            // Se obtiene el ID, el estado y la observación del formulario enviado mediante AJAX
            $datos = array(
                'idNotificacion' => $_POST["idNotificacion"]
                
            );

            // Se llama a la función del controlador que maneja la lógica de guardar la notificación
            $respuesta = ControladorNotificacion::ctrEliminarNotificaciones($datos);

                    $respuesta_json = json_encode($respuesta);
                    header('Content-Type: application/json');
                    echo $respuesta_json;
        } 
            public function ajaxPagoCuotas_Notificion() {   
            // Se obtiene el ID, el estado y la observación del formulario enviado mediante AJAX
            $datos = array(
                'idLicencia' => $_POST["idLicencia"],
                'cuotas' => $_POST["cuotas"]

                
            );

            // Se llama a la función del controlador que maneja la lógica de guardar la notificación
            $respuesta = ControladorNotificacion::ctrPagoPorCuotas($datos);

                   // Convertir la respuesta a JSON para enviarla al frontend
                    $respuesta_json = json_encode($respuesta);

                    // Establecer el tipo de contenido de la respuesta como JSON
                    header('Content-Type: application/json');
                    echo $respuesta_json;  // Enviar la respuesta JSON al frontend
        } 



        //MOSTRAR NOTIFICADO ESTADOD ECUENTA
        public function ajaxMostrarLicenciaAgua_estado_cuenta_n()
        {   $idlicenciaagua=$_POST['idlicenciaagua_estadocuenta'];
            $respuesta = ControladorNotificacion::ctrMostrar_licencia_estadocuenta_n($idlicenciaagua);
            echo $respuesta;
        
        }

         //MOSTRAR SEGUNDA CUOTA
        public function ajaxMostrarSegundaNotificacionParticion()
        {   $idNotificionAgua=$_POST['idNotificionAgua'];
            $respuesta = ControladorNotificacion::ctrMostrar_mostrar_pago_segunda_cuota($idNotificionAgua);
            echo $respuesta;
        
        }
                  
      public function ajaxRegistrarNotificacionTotal()
    {   
         $datos = array(
                'numeroProveido' => $_POST["numeroProveido"],
                'estadoReconectarTotal' => $_POST["estadoReconectarTotal"],
                'totalAplicar' => $_POST["totalAplicar"],
                'idLicencia' => $_POST["idLicencia"],
                'idtipoPago' => $_POST["idtipoPago"]
                
          );
            
            $respuesta = ControladorNotificacion::ctrTotalGuardarNotificaciones($datos);
           // echo $respuesta;
            $respuesta_json = json_encode($respuesta);
            header('Content-Type: application/json');
            echo $respuesta_json;
     
    }

       public function ajaxRegistrarNotificacionSegunda()
    {   
         $datos = array(
                'numeroProveido' => $_POST["numeroProveidoSegundo"],
                'estadoReconectarSeg' => $_POST["estadoReconectarSeg"],
                'idNotificaionAgua' => $_POST["idNotificaionAgua"],
                'idLicencia' => $_POST["idLicencia"]
                
          );
            
            $respuesta = ControladorNotificacion::ctrSegundaGuardarNotificaciones($datos);
           // echo $respuesta;
           $respuesta_json = json_encode($respuesta);
            header('Content-Type: application/json');
            echo $respuesta_json;
     
    }

          public function ajaxRegistrarNotificacionParticion()
    {   
         $datos = array(
                 'idLicencia' => $_POST["idLicencia"],
                'idtipoPago' => $_POST["idtipoPago"],

                'numeroProveido' => $_POST["numeroProveido"],
                'estadoReconectarParticion' => $_POST["estadoReconectarParticion"],
                'particionAplicar' => $_POST["particionAplicar"],
                'fechaVencimiento' => $_POST["fechaVencimiento"],

                'totalAplicar2' => $_POST["totalAplicar2"],
                'fechaVencimiento2' => $_POST["fechaVencimiento2"]
   
          );
            $respuesta = ControladorNotificacion::ctrGuardarNotificacionesParticion($datos);
          //  echo $respuesta;
            $respuesta_json = json_encode($respuesta);
            header('Content-Type: application/json');
            echo $respuesta_json;
         


    }

    
                



    
      //mostrar lista de usuarios
    public function ajaxEditar_Notificion()
    {   
          $idNotificacion = isset($_POST['idNotificacion_selet']) ? $_POST['idNotificacion_selet'] : '';
        
        $respuesta = ControladorNotificacion::ctrEditarNotificaciones($idNotificacion);

        
      

     echo json_encode($respuesta);

    }

    

}


//mostrar lista de usuarios
if (isset($_POST['lista_notificacion'])) {
    $objlistapagina = new AjaxNotificacion();
    $objlistapagina->ajaxLista_Notificion();
}

//mostrar lista de usuarios
if (isset($_POST['idNotificacion_seleccionado'])) {
    $objlistapagina = new AjaxNotificacion();
    $objlistapagina->ajaxEditar_Notificion();
}

//mostrar lista de usuarios
if (isset($_POST['guardar_datos_editar'])) {
    $objlistapagina = new AjaxNotificacion();
    $objlistapagina->ajaxEditar_Notificion_guardar();
}

//mostrar lista de usuarios
if (isset($_POST['eliminar_notificacion'])) {
    $objlistapagina = new AjaxNotificacion();
    $objlistapagina->ajaxEliminar_Notificion();
}


//mostrar dos cuotas
if (isset($_POST['mostrar_cuotas'])) {
    $objlistapagina = new AjaxNotificacion();
    $objlistapagina->ajaxPagoCuotas_Notificion();
}

//mostrar estado de cuenta

if (isset($_POST["idlicenciaagua_estadocuenta"])) {
  $pisoEdit = new AjaxNotificacion();
  $pisoEdit->ajaxMostrarLicenciaAgua_estado_cuenta_n();
}

//REGISTRAR TOTAL
if (isset($_POST["registrar_notificacion_total"])) {
  $pisoEdit = new AjaxNotificacion();
  $pisoEdit->ajaxRegistrarNotificacionTotal();
}

//REGISTRAR PARTICION 
if (isset($_POST["registrar_notificacion_particion"])) {
  $pisoEdit = new AjaxNotificacion();
  $pisoEdit->ajaxRegistrarNotificacionParticion();
}

//MOSTRAR PARA PAGO DE SEGUNDA CUOTA
if (isset($_POST["mostrar_cuotas_segundo"])) {
  $pisoEdit = new AjaxNotificacion();
  $pisoEdit->ajaxMostrarSegundaNotificacionParticion();
}

//REGISTRAR SEGUNDA CUOTA
if (isset($_POST["registrar_notificacion_segundo"])) {
  $pisoEdit = new AjaxNotificacion();
  $pisoEdit->ajaxRegistrarNotificacionSegunda();
}











