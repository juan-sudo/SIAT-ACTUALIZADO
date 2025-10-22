<?php
session_start();
require_once "../vendor/autoload.php";

//use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorCalculoEstadoAgua;
class AjaxReporte
{
  
    public function ajaxCAlculoEstadoAgua()
    {

      $anioCalcular = isset($_POST['anioCalcular']) ? $_POST['anioCalcular'] : '';
      $anioBase = isset($_POST['anioBase']) ? $_POST['anioBase'] : '';
      $respuesta = ControladorCalculoEstadoAgua::ctrCalculoEsatdoAgua($anioBase, $anioCalcular);
       header('Content-Type: application/json; charset=utf-8');
      echo json_encode($respuesta);
  
    }
}


if (isset($_POST['calcularEstadoAgua'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxCAlculoEstadoAgua();
}