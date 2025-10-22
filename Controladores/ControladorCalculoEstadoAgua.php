<?php

namespace Controladores;

use Modelos\ModeloCalculoEstadoAgua;

class ControladorCalculoEstadoAgua
{

   public static function ctrCalculoEsatdoAgua($anioBase, $anioCalcular)
    {
        // Obtenemos los datos desde el modelo
        $respuesta = ModeloCalculoEstadoAgua::mdlCalculoEstadoAgua($anioBase, $anioCalcular);
        
        
      
        // Retornamos el HTML generado
        return $respuesta;
    }

}
