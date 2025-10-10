<?php
session_start();
require_once "../vendor/autoload.php";

//use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorReporteGeneralArea;
class AjaxReporte
{
   

     //total tribuitario
    public function ajaxMostrar_reporte_general_tributaria()
    {
      $fechaInicio=$_POST['fechaInicio'];
      $fechaFin=$_POST['fechaFin'];

      $respuesta = ControladorReporteGeneralArea::ctrMostrar_reporte_general_tributaria($fechaInicio,$fechaFin );
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

    
    //GERENCIA DE ADMINISACION TRIBUTARIA PROVEIDOS
      public function ajaxMostrar_reporte_tributaria_proveidos()
      {
        $fechaInicio=$_POST['fechaInicio'];
        $fechaFin=$_POST['fechaFin'];
        $especieValorada=$_POST['especiesValoradas'];
        $idArea=$_POST['idArea'];
  
        $respuesta = ControladorReporteGeneralArea::ctrMostrar_reporte_tributaria_proveidos($fechaInicio,$fechaFin, $especieValorada,$idArea );
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;    
      }


    //total de agua potable
     public function ajaxMostrar_reporte_general_agua()
    {
      $fechaInicio=$_POST['fechaInicio'];
      $fechaFin=$_POST['fechaFin'];

      $respuesta = ControladorReporteGeneralArea::ctrMostrar_reporte_general_agua($fechaInicio,$fechaFin );
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }
    



    

    
    

}
// estado cuenta caja - modulo caja



// REPORTE ADMINISTRACION TRIBUTARIA
if (isset($_POST['reporte_general_tributaria'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_general_tributaria();
}

// REPORTE ADMINISTRACION TRIBUTARIA
if (isset($_POST['reporte_tributaria_proveido'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_tributaria_proveidos();
}



//REPORTE DE AGUA POTABLE
if (isset($_POST['reporte_general_agua'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_general_agua();
}
