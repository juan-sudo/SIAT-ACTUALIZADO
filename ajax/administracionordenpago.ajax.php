<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorAdministracionOrdenPago;

class AjaxAdministracionOrdenPago
{

    //mostrar lista de usuarios
    public function ajaxLista_ordenpago()
    {   
        
        $filtroNombre = $_POST['filtro_nombre'] ?? ''; 
        $filtro_op = $_POST['filtro_op'] ?? '';
        $filtro_ex = $_POST['filtro_ex'] ?? '';
        $pagina = (int) ($_POST['pagina'] ?? 1);  // Asegúrate de que 'pagina' sea un número entero
        $resultados_por_pagina = (int) ($_POST['resultados_por_pagina'] ?? 15);

    
        // Llamamos al controlador para obtener las notificaciones con filtros y paginación
        $respuesta = ControladorAdministracionOrdenPago::ctrMostrarAdministracionCoactivo($filtroNombre, $filtro_op,$filtro_ex, $pagina, $resultados_por_pagina);
    
        echo $respuesta;
    
        
    }




    //mostrar lista de usuarios
    public function AjaxAdministracionCoactivoMontosAnios() 
    {   
    $idContribuyente = isset($_POST['idContribuyente']) ? $_POST['idContribuyente'] : '';
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionOrdenPago::ctrMostrarAdministracionCoactivoTotalAnio($idContribuyente);
  
    echo $respuesta;
  
    
    }
     //MOSTRAR PARA EDITAR
    public function AjaxEditarMoatrarCoactivo() 
    {   
    $idCoactivo = isset($_POST['idCoactivo']) ? $_POST['idCoactivo'] : '';
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionOrdenPago::ctrMostrarEditar($idCoactivo);
  
    echo $respuesta;
  
    
    }

      //MOSTRAR PARA EDITAR NOTIFICACION 
    public function AjaxEditarMoatrarFechaNotificacion() 
    {   
    $idContribueynte = isset($_POST['idContribueynte']) ? $_POST['idContribueynte'] : '';
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionOrdenPago::ctrMostrarEditarFechaNo($idContribueynte);
  
    echo $respuesta;
  
    }

    public function AjaxEditarMoatrarEnviarCoactivo() 
    {   
    $idContribueynte = isset($_POST['idContribueynte']) ? $_POST['idContribueynte'] : '';
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionOrdenPago::ctrMostrarEditarEnviarCoactivo($idContribueynte);
  
    echo $respuesta;
  
    }

    
      //MOSTRAR PARA EDITAR
    public function AjaxGuardarMoatrarOrdenPago() 
    {   

    $idContribueyentes = isset($_POST['idContribueyentes']) ? $_POST['idContribueyentes'] : '';
    $fechaNotificacion = isset($_POST['fechaNotificacion']) ? $_POST['fechaNotificacion'] : '';
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionOrdenPago::ctrGuardarEditarNotficiacionFecha($idContribueyentes, $fechaNotificacion);
 
    echo $respuesta;
  
    
    }

       public function AjaxGuardarEnviarCoactivo() 
    {   

    $numeroImforme = isset($_POST['numeroImforme']) ? $_POST['numeroImforme'] : '';
    $estadoCoactivo = isset($_POST['estadoCoactivo']) ? $_POST['estadoCoactivo'] : '';
    $idContribueyentes = isset($_POST['idContribueyentes']) ? $_POST['idContribueyentes'] : '';
    $ordencompleta = isset($_POST['ordencompleta']) ? $_POST['ordencompleta'] : '';

    
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionOrdenPago::ctrGuardarEditarEnviarCoactivo($numeroImforme, $estadoCoactivo, $idContribueyentes, $ordencompleta);
 
    echo $respuesta;
  
    
    }


    

    


}

//MOSTRAR LSITA DE COACTIVO
if (isset($_POST['lista_coactivo'])) {
    $objlistapaginaa = new AjaxAdministracionOrdenPago();
    $objlistapaginaa->ajaxLista_ordenpago();
}

//MOSTRAR LSITA DE COACTIVO
if (isset($_POST['lista_montos_coactivo'])) {
    $objlistapaginaa = new AjaxAdministracionOrdenPago();
    $objlistapaginaa->AjaxAdministracionCoactivoMontosAnios();
}

//MOSTRAR PARA EDITAR
if (isset($_POST['editar_coactivo'])) {
    $objlistapaginaa = new AjaxAdministracionOrdenPago();
    $objlistapaginaa->AjaxEditarMoatrarCoactivo();
}

//MOSTRAR PARA EDITAR NOTIFICACION
if (isset($_POST['editar_notificacion'])) {
    $objlistapaginaa = new AjaxAdministracionOrdenPago();
    $objlistapaginaa->AjaxEditarMoatrarFechaNotificacion();
}




// //GUARDAR FECHA COTIZACION
if (isset($_POST['guardar_orden_fecha_no'])) {
    $objlistapaginaa = new AjaxAdministracionOrdenPago();
    $objlistapaginaa->AjaxGuardarMoatrarOrdenPago();
}

//VER ENVIAR A COACTIVO
if (isset($_POST['editar_enviar_coactivo'])) {
    $objlistapaginaa = new AjaxAdministracionOrdenPago();
    $objlistapaginaa->AjaxEditarMoatrarEnviarCoactivo();
}

// //ENVIAR COTIZACION
if (isset($_POST['guardar_orden_en_coactivo'])) {
    $objlistapaginaa = new AjaxAdministracionOrdenPago();
    $objlistapaginaa->AjaxGuardarEnviarCoactivo();
}










