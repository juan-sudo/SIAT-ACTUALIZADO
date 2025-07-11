<?php

namespace Controladores;

use Modelos\ModeloContribuyente;
use Modelos\ModeloPredioLitigio;
use Conect\Conexion;
use Exception;
use PDO;

class ControladorPredioLitigio
{


	 public static function ctrEditarPredioLitigio($valor)
  {
    $respuesta = ModeloPredioLitigio::mdlEditarPredioLitigio( $valor);

	
    return $respuesta;
  }

  

//ELIMNAR PREDIO LITIGIO
    public static function ctrEliminarPredioLitigio($datos)
  {   
	
	
 
        $respuesta = ModeloPredioLitigio::mdlEliminarPredioLitigio($datos);
        
        if ($respuesta == "ok") {
          $respuesta = array(
             "tipo" => 'correcto',
             "mensaje" => '<div class="alert success">
             <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
             <span aria-hidden="true" class="letra">×</span>
             </button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se edito con exito al contribuyente</p></div>'
          );
       } else {
          $respuesta = array(
             "tipo" => 'error',
             "mensaje" => '<div class="alert error">
             <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
             <span aria-hidden="true" class="letra">×</span>
             </button><p class="inner"><strong class="letra">Error!</strong> <span class="letra">Ocurrio un error Comunicate con el Administrador</span></p></div>'
          );
       }
       return $respuesta;
    
  }

	  public static function ctrGuardarPredioLitigio($datos)
  {   
	
	
 
        $respuesta = ModeloPredioLitigio::mdlGuardarPredioLitigio($datos);
        
        if ($respuesta == "ok") {
          $respuesta = array(
             "tipo" => 'correcto',
             "mensaje" => '<div class="alert success">
             <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
             <span aria-hidden="true" class="letra">×</span>
             </button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se edito con exito al contribuyente</p></div>'
          );
       } else {
          $respuesta = array(
             "tipo" => 'error',
             "mensaje" => '<div class="alert error">
             <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
             <span aria-hidden="true" class="letra">×</span>
             </button><p class="inner"><strong class="letra">Error!</strong> <span class="letra">Ocurrio un error Comunicate con el Administrador</span></p></div>'
          );
       }
       return $respuesta;
    
  }





	public  static function ctrListarPredioLitigio($valor,$anio)
	{
		$respuesta = ModeloPredioLitigio::mdlListarPredioLitigio($valor,$anio);
		echo $respuesta;
	}



	
	

}