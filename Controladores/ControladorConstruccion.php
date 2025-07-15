<?php

namespace Controladores;

use Modelos\ModeloConstruccion;

class ControladorConstruccion
{
	// REGISTRO DE CONTRIBUYENTE
	public static function ctrCrearContruccion($datos)
	{
		
		$respuesta = ModeloConstruccion::mdlNuevoContruccion( $datos);

		


		if ($respuesta == 'ok') {
			$respuesta = array(
				"tipo" => "correcto",
				"mensaje" => '<div class="alert success">
			    <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
		        <span aria-hidden="true" class="letra">×</span>
	            </button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se registro el piso de forma correcta</span></p></div>'
			);
			return $respuesta;
		} else {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="alert error">
			    <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
		        <span aria-hidden="true" class="letra_error">×</span>
	            </button><p class="inner"><strong class="letra_error">Error!</strong> <span class="letra_error">Algo salio mal comunicate con el Administrador</span></p></div>'
			);
			return $respuesta;
		}
	}



}
