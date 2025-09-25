<?php
session_start();
require_once "../vendor/autoload.php";

//use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorReporteActualizacion;
class AjaxReporte
{
  
    public function ajaxReport_actualizacion_carpeta()
    {

      $id = isset($_POST['idUsuarioFiltro']) ? $_POST['idUsuarioFiltro'] : '';
      $estado = isset($_POST['estadoFiltro']) ? $_POST['estadoFiltro'] : '';
      $respuesta = ControladorReporteActualizacion::ctrMostrar_Reporte_actualizacion($id, $estado);
      echo $respuesta;
  
    }
}


if (isset($_POST['reporteActualizacion'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxReport_actualizacion_carpeta();
}