<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorPredioLitigio;

class AjaxLitigioPredio
{
  
        public function ajaxGuardar_predio_litigio()
        {
            
                $datos = array(
                   "ids" => isset($_POST["ids"]) ? $_POST["ids"] : null,
                    "observacion" => isset($_POST["observacion_predio"]) ? $_POST["observacion_predio"] : null,
                    "id_usuario" => isset($_POST["id_usuario"]) ? $_POST["id_usuario"] : null,
                    "id_predio" => isset($_POST["id_predio"]) ? $_POST["id_predio"] : null
                 );
                $respuesta = ControladorPredioLitigio::ctrGuardarPredioLitigio( $datos);
                $respuesta_json = json_encode($respuesta);
                header('Content-Type: application/json');
                echo $respuesta_json;
               
             // }
            
        }

   public function ajaxEditarPredioLitigio()
   {
          $datos = array(
                     "ids" => isset($_POST["ids"]) ? $_POST["ids"] : null
                  );
              
      $respuesta = ControladorPredioLitigio::ctrEditarPredioLitigio($datos);
      echo json_encode($respuesta);
   }

  
      

}

// OBJETO EDITAR DATOS CARPETA--------------------------------------------
if (isset($_POST['mostrar_predio_litigio'])) {
   $editarL = new AjaxLitigioPredio();

   $editarL->ajaxEditarPredioLitigio();
}

// guardar editar contribuyente
if (isset($_POST['guardar_predio_litigio'])) {
   $editarL = new AjaxLitigioPredio();
   $editarL->ajaxGuardar_predio_litigio();
}

