<?php

namespace Controladores;

use Modelos\ModeloReporteActualizacion;

class ControladorReporteActualizacion
{

   public static function ctrMostrar_Reporte_actualizacion($id, $estadoe)
    {
        // Obtenemos los datos desde el modelo
        $respuesta = ModeloReporteActualizacion::mdlMostrar_actualizacion_carpeta($id, $estadoe);
        
        $html = '';
		$cont=1;
        $totalFilas = 0; // Variable para contar el total de filas

        foreach ($respuesta as $value) {
            // Condicional para mostrar el estado de progreso con su texto y color de fondo correspondiente
            $estado = '';
            $fondo = ''; // Variable para almacenar el color de fondo
            if ($value['Estado_progreso'] == 'P') {
                $estado = 'Pendiente';
                $fondo = 'background-color: red; color: white; padding: 2px 3px; border-radius: 5px;';
            } elseif ($value['Estado_progreso'] == 'E') {
                $estado = 'En Progreso';
                $fondo = 'background-color: orange; color: white; padding: 2px 3px; border-radius: 5px;';
            } elseif ($value['Estado_progreso'] == 'C') {
                $estado = 'Completado';
                $fondo = 'background-color: green; color: white; padding: 2px 3px; border-radius: 5px;';
            }

			 $completado_oficina = ($value['completado_oficina'] == 'on') ? 'Sí' : $value['completado_oficina'];
			 
			 $completado_campo = ($value['completado_campo'] == 'on') ? 'Sí' : $value['completado_campo'];

            // Generamos el HTML de la fila con el estado procesado y el fondo de color y padding
            $html .= '
                <tr>
					
                    <td class="text-center">' . $value['Codigo_Carpeta'] . '</td>
                    <td class="text-center"><span style="' . $fondo . '">' . $estado . '</span></td>
                    <td class="text-center">' . $completado_oficina   . '</td>
                    <td class="text-center">' . $completado_campo . '</td>
                    <td class="text-center">' . $value['observacion_pendiente'] . '</td>
                     <td class="text-center">' . $value['observacion_progreso'] . '</td>
                    <td class="text-center">' . $value['fecha_act'] . '</td>
                   
                    <td class="text-center">' . $value['usuario'] . '</td>
                </tr>';
                $totalFilas++; // Incrementamos el contador de filas
        }

              // Agregar el total de filas al final
        $html .= '
            <tr>
                <td colspan="8" class="text-start"><strong>Total de carpetas: ' . $totalFilas . '</strong></td>
            </tr>';

        // Retornamos el HTML generado
        return $html;
    }

}
