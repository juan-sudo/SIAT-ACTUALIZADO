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







