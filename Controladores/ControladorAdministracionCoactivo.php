<?php

namespace Controladores;

use Modelos\ModeloAdministracionCoactivo;

class ControladorAdministracionCoactivo
{

    public static function ctrMostrarAdministracionCoactivoTotalAnio($idContribuyente) 
{
    // Llamamos al modelo y pasamos los filtros y la paginación
    $respuesta = ModeloAdministracionCoactivo::mdlMostrarAdministracionCoactivoTotalAnio($idContribuyente);

    // Inicializamos las variables para acumular los totales
    $totalAplicar = 0;
    $totalTIM = 0;
    
    // Comienza la primera tabla
    $tabla = '<table border="1" style="border-collapse: collapse;">';
    $tabla .= '<thead>
                <tr>
                    <th>Año</th>
                     <th>TIM a Aplicar</th>
                    <th>Total a Aplicar</th>
                   
                </tr>
              </thead>';
    
    // Recorre cada fila del array de respuesta
    foreach ($respuesta as $row) {
        // Acumulamos los totales
        $totalAplicar += $row['SUM(Total_Aplicar)'];
        $totalTIM += $row['SUM(TIM_Aplicar)'];

        // Añadimos una fila por cada resultado
        $tabla .= '<tr>';
        $tabla .= '<td>' . $row['Anio'] . '</td>';
        $tabla .= '<td>' . number_format($row['SUM(TIM_Aplicar)'], 2) . '</td>'; 
        $tabla .= '<td>' . number_format($row['SUM(Total_Aplicar)'], 2) . '</td>';  // Formateamos a 2 decimales
         // Formateamos a 2 decimales
        $tabla .= '</tr>';
    }

    // Añadimos la fila de los totales al final
    $tabla .= '<tr>';
    $tabla .= '<th>Total:</th>';
    
    $tabla .= '<th>' . number_format($totalTIM, 2) . '</th>';  // Total TIM aplicar
    $tabla .= '<th>' . number_format($totalAplicar, 2) . '</th>'; // Total a aplicar
    $tabla .= '</tr>';

    // Cierra la primera tabla
    $tabla .= '</table>';

   

    // Devuelves ambas tablas (primera tabla y segunda tabla)
    echo $tabla;
}





    public static function ctrMostrarAdministracionCoactivo($filtro_nombre = '', $filtro_fecha = '', $filtro_estado = '', $pagina = 1, $resultados_por_pagina = 10) 
  {
    // Calcular el inicio de la consulta según la página actual
    $inicio = ($pagina - 1) * $resultados_por_pagina;

    // Llamamos al modelo y pasamos los filtros y la paginación
    $respuesta = ModeloAdministracionCoactivo::mdlMostrarAdministracionCoactivo($filtro_nombre, $filtro_fecha, $filtro_estado, $inicio, $resultados_por_pagina);

    // var_dump($respuesta); // Imprime la respuesta para ver los datos

    // Inicializar variables para agrupar valores
    $tabla = '';
    $ubicacionvia_prev = '';
 
    $codigos = [];
    $documentos = [];
    $nombres = [];
    $direcciones = [];
     // Inicializar el contador
    $contador = 0;

    if ($respuesta) {
        foreach ($respuesta as $row) {
            // Agrupar los valores
            if ($ubicacionvia_prev != $row['ubicacionvia']) {

               
                // Si la ubicación cambia, mostrar los valores acumulados
                if (!empty($codigos)) {
                    // Unir códigos por coma
                    $codigos_str = implode(', ', $codigos);
                    $documentos_str = implode(', ', $documentos);
                    $nombres_str = implode(', ', $nombres);
                    $direcciones_str = implode(', ', $direcciones);

                    // Agregar la fila a la tabla con los valores concatenados
                    $tabla .= '<tr id="' . $ubicacionvia_prev . '">
                                <td style="text-align: center;">
                                    ' . $contador . '
                                </td>
                                <td style="text-align: center; display: none;" class="id-contribuyente" data-id="' . $ubicacionvia_prev . '">
                                    <button class="btn-enlace">' . $ubicacionvia_prev . '</button>
                                </td>
                                <td style="text-align: center;">' . $codigos_str . '</td>
                                 <td style="text-align: center;">76-2025</td>
                                  <td style="text-align: center;">876-2025</td>
                                <td style="text-align: left;">' . $nombres_str . '</td>
                                <td style="text-align: left;">' . $direcciones_str . '</td>

                                <td style="text-align: center;">

                                <div class="btn-group">
                                  
                                       <button class="btn btn-danger btnVerAdministracionCoactivo" 
                                            data-idcontribuyente="' . $codigos_str . '" 
                                          
                                            data-toggle="modal" data-target="#modalVerAgua"
                                            title="Pago por años coactivo"
                                            
                                            >
                                       <i class="fas fa-folder"></i> 
                                    </button>

                                </div>


                                                  
                                </td>


                            </tr>';
                }

                // Resetear las variables para la nueva ubicación
                $codigos = [];
                $documentos = [];
                $nombres = [];
                $direcciones = [];
                $ubicacionvia_prev = $row['ubicacionvia'];

            }

            // Acumular los valores
            $codigos[] = $row['id_contribuyente'];  // o cualquier columna que quieras
            $documentos[] = $row['documento'];
            $nombres[] = $row['nombre_completo'];
            $direcciones[] = isset($row['direccion_completo']) ? $row['direccion_completo'] : 'No disponible';
             $contador++;
        }

       
    } else {
        $tabla = '<tr><td colspan="12">No se encontraron notificaciones.</td></tr>';
    }

    // Devolver el HTML con los datos acumulados
    echo $tabla;
  }




    }
