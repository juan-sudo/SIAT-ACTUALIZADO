<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorAdministracionCoactivo;

class AjaxAdministracionCoactivo
{

    //mostrar lista de usuarios
    public function ajaxLista_Coactivo()
    {   
        // $filtroNombre = isset($_POST['filtro_nombre']) ? $_POST['filtro_nombre'] : '';
        // $filtro_op = isset($_POST['filtro_op']) ? $_POST['filtro_op'] : '';
        // $filtro_ex = isset($_POST['filtro_ex']) ? $_POST['filtro_ex'] : '';
        // $pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1; // Obtener página actual
        // $resultados_por_pagina = isset($_POST['resultados_por_pagina']) ? (int)$_POST['resultados_por_pagina'] : 15;

        $filtroNombre = $_POST['filtro_nombre'] ?? ''; 
        $filtro_op = $_POST['filtro_op'] ?? '';
        $filtro_ex = $_POST['filtro_ex'] ?? '';
        $pagina = (int) ($_POST['pagina'] ?? 1);  // Asegúrate de que 'pagina' sea un número entero
        $resultados_por_pagina = (int) ($_POST['resultados_por_pagina'] ?? 15);

    
        // Llamamos al controlador para obtener las notificaciones con filtros y paginación
        $respuesta = ControladorAdministracionCoactivo::ctrMostrarAdministracionCoactivo($filtroNombre, $filtro_op,$filtro_ex, $pagina, $resultados_por_pagina);
    
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
     //MOSTRAR PARA EDITAR
    public function AjaxEditarMoatrarCoactivo() 
    {   
    $idCoactivo = isset($_POST['idCoactivo']) ? $_POST['idCoactivo'] : '';
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionCoactivo::ctrMostrarEditar($idCoactivo);
  
    echo $respuesta;
  
    
    }

    //MOSTRAR PARA ARCHIVAR
    public function AjaxEditarMoatrarCoactivoArchivar() 
    {   
    $idCoactivo = isset($_POST['idCoactivo']) ? $_POST['idCoactivo'] : '';
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionCoactivo::ctrMostrarEditarArchivar($idCoactivo);
  
    echo $respuesta;
  
    
    }

    

      //MOSTRAR PARA EDITAR
    public function AjaxGuardarMoatrarCoactivo() 
    {   
    $idcoactivo = isset($_POST['idcoactivo']) ? $_POST['idcoactivo'] : '';
    $expediente = isset($_POST['expediente']) ? $_POST['expediente'] : '';
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionCoactivo::ctrGuardarEditar($idcoactivo, $expediente, $estado);
 
    echo $respuesta;
  
    
    }

        public function AjaxGuardarMoatrarCoactivoArchivar() 
    {   
    $idcoactivo = isset($_POST['idcoactivo']) ? $_POST['idcoactivo'] : '';
   $idcontribuyente = isset($_POST['idcontribuyente']) ? $_POST['idcontribuyente'] : '';
    
    $numeroInforme = isset($_POST['numeroInforme']) ? $_POST['numeroInforme'] : '';
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
   
    // Llamamos al controlador para obtener las notificaciones con filtros y paginación
    $respuesta = ControladorAdministracionCoactivo::ctrGuardarEditarArchivar($idcoactivo, $numeroInforme, $estado,  $idcontribuyente);
 
    echo $respuesta;
  
    
    }


    

    


}

//MOSTRAR LSITA DE COACTIVO
if (isset($_POST['lista_coactivo'])) {
    $objlistapaginaa = new AjaxAdministracionCoactivo();
    $objlistapaginaa->ajaxLista_Coactivo();
}

//MOSTRAR LSITA DE COACTIVO
if (isset($_POST['lista_montos_coactivo'])) {
    $objlistapaginaa = new AjaxAdministracionCoactivo();
    $objlistapaginaa->AjaxAdministracionCoactivoMontosAnios();
}

//MOSTRAR PARA EDITAR
if (isset($_POST['editar_coactivo'])) {
    $objlistapaginaa = new AjaxAdministracionCoactivo();
    $objlistapaginaa->AjaxEditarMoatrarCoactivo();
}


//MOSTRAR PARA ARCHIVAR
//MOSTRAR PARA EDITAR
if (isset($_POST['editar_coactivo_archivar'])) {
    $objlistapaginaa = new AjaxAdministracionCoactivo();
    $objlistapaginaa->AjaxEditarMoatrarCoactivoArchivar();
}


//MOSTRAR PARA EDITAR
if (isset($_POST['guardar_coactivo'])) {
    $objlistapaginaa = new AjaxAdministracionCoactivo();
    $objlistapaginaa->AjaxGuardarMoatrarCoactivo();
}

//GUARDAR Y ARCHIVAR COACTIVO
if (isset($_POST['guardar_coactivo_archivar'])) {
    $objlistapaginaa = new AjaxAdministracionCoactivo();
    $objlistapaginaa->AjaxGuardarMoatrarCoactivoArchivar();
}











