<?php
require_once "../vendor/autoload.php";

use Controladores\ControladorConstruccion;

class AjaxConstruccion
{
	public function ajaxRegistrarContruccion()
	{
			$datos = array(
				'Nombre_Construccion' => $_POST["nombreConstruccion"], //2
				'Observaciones' => $_POST["observacion"],//3	
				'idPredio' => $_POST["idPredio"]//3	

				
				
			);

			$respuesta = ControladorConstruccion::ctrCrearContruccion($datos);
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
		
	}
}

//======== Registrar Pisos
if (isset($_POST["registrarConstruccion"])) {
	$nuevoPiso = new AjaxConstruccion();
	$nuevoPiso->ajaxRegistrarContruccion();
}
