<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorAdministracionCoactivo;

class AjaxAdministracionCoactivo
{

    //mostrar lista de usuarios
    public function ajaxLista_Coactivo()
{   
    $filtroNombre = isset($_POST['filtro_nombre']) ? $_POST['filtro_nombre'] : '';
    $filtroFecha = isset($_POST['filtro_fecha']) ? $_POST['filtro_fecha'] : '';
    $filtroEstado = isset($_POST['filtro_estado']) ? $_POST['filtro_estado'] : '';
    $pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1; // Obtener página actual
    
    $resultados_por_pagina = isset($_POST['resultados_por_pagina']) ? (int)$_POST['resultados_por_pagina'] : 15;

   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionCoactivo::ctrMostrarAdministracionCoactivo($filtroNombre, $filtroFecha, $filtroEstado, $pagina, $resultados_por_pagina);
  
 

    echo $respuesta;
  
    
}

    //mostrar lista de usuarios
    public function AjaxAdministracionCoactivoMontosAnios() 
    {   
    $idContribuyente = isset($_POST['idContribuyente']) ? $_POST['idContribuyente'] : '';
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionCoactivo::ctrMostrarAdministracionCoactivoTotalAnio($idContribuyente);
  
  
 

    echo $respuesta;
  
    
    }


}

//MOSTRAR LSITA DE COACTIVO
if (isset($_POST['lista_coactivo'])) {
    $objlistapagina = new AjaxAdministracionCoactivo();
    $objlistapagina->ajaxLista_Coactivo();
}

//MOSTRAR LSITA DE COACTIVO
if (isset($_POST['lista_montos_coactivo'])) {
    $objlistapagina = new AjaxAdministracionCoactivo();
    $objlistapagina->AjaxAdministracionCoactivoMontosAnios();
}










