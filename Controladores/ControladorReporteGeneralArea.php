<?php

namespace Controladores;

use Modelos\ModeloReporteGeneralArea;
use Conect\Conexion;
use PDO;


class ControladorReporteGeneralArea
{
	//total tribuitario
	public static function ctrMostrar_reporte_general_tributaria($fechaInicio,$fechaFin)
	{
		$respuesta = ModeloReporteGeneralArea::mdlMostrar_reporte_general_tributaria($fechaInicio,$fechaFin);

		return $respuesta;
		
	}

	//total tribuitario provedidos
	public static function ctrMostrar_reporte_tributaria_proveidos($fechaInicio,$fechaFin, $especieValorada,$idArea)
	{
		$respuesta = ModeloReporteGeneralArea::mdlMostrar_reporte_general_proveidos($fechaInicio,$fechaFin, $especieValorada,$idArea);

		return $respuesta;
		
	}

	//total agua potable
	public static function ctrMostrar_reporte_general_agua($fechaInicio,$fechaFin)
	{
		$respuesta = ModeloReporteGeneralArea::mdlMostrar_reporte_general_agua($fechaInicio,$fechaFin);

		return $respuesta;
		
	}


}