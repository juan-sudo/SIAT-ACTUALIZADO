<?php

namespace Controladores;

use Modelos\ModeloNotificacion;
use Controladores\ControladorEmpresa;
use Modelos\ModeloEmpresa;

class ControladorNotificacion
{


    public static function ctrEliminarNotificaciones($datos) {

    
    // Se pasa los datos al modelo que se encargará de guardar la notificación
    $respuesta = ModeloNotificacion::mdlEliminarNotificacion($datos);

 	
		if ($respuesta == "ok") {
			$respuesta = array(
				"tipo" => "correcto",
				"mensaje" => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
			<span aria-hidden="true" class="letra">×</span>
		    </button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">La notificacion se actualizo de forma correcta</span></p></div>'
			
			);
			return $respuesta;
		} else {
			$respuesta = array(
				"tipo" => "error",
				"mensaje" => '<div class="alert error">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
			<span aria-hidden="true" class="letra_error">×</span>
		    </button><p class="inner"><strong class="letra_error">error!</strong> <span class="letra_error">Algo salio mal, comunicate con el Administrador</span></p></div>'
		);
			return $respuesta;
		}
}

public static function ctrMostrarGuardarNotificaciones($datos) {

    
    // Se pasa los datos al modelo que se encargará de guardar la notificación
    $respuesta = ModeloNotificacion::mdlMostrarGuardarIdNotificacion($datos);

 	
		if ($respuesta == "ok") {
			$respuesta = array(
				"tipo" => "correcto",
				"mensaje" => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
			<span aria-hidden="true" class="letra">×</span>
		    </button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">La notificacion se actualizo de forma correcta</span></p></div>'
			
			);
			return $respuesta;
		} else {
			$respuesta = array(
				"tipo" => "error",
				"mensaje" => '<div class="alert error">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
			<span aria-hidden="true" class="letra_error">×</span>
		    </button><p class="inner"><strong class="letra_error">error!</strong> <span class="letra_error">Algo salio mal, comunicate con el Administrador</span></p></div>'
		);
			return $respuesta;
		}
}

    
     public static function ctrEditarNotificaciones($idNotificacion)
    {
       
        // Llamamos al modelo y pasamos el filtro de nombre y fecha
        $respuesta = ModeloNotificacion::mdlMostrarIdNotificacion($idNotificacion); 

      
        return $respuesta;
    }


public static function ctrMostrarNotificaciones($filtro_nombre = '', $filtro_fecha = '', $filtro_estado = '', $pagina = 1, $resultados_por_pagina = 10)
{
    // Calcular el inicio de la consulta según la página actual
    $inicio = ($pagina - 1) * $resultados_por_pagina;

    // Llamamos al modelo y pasamos los filtros y la paginación
    $respuesta = ModeloNotificacion::mdlMostrarNotificacion($filtro_nombre, $filtro_fecha, $filtro_estado, $inicio, $resultados_por_pagina);

    $contador = $inicio + 1;  // Inicializamos el contador

    // Recorrer todos los resultados y mostrarlos en la tabla HTML
    $tabla = '';
    if ($respuesta) {
        foreach ($respuesta as $row) {
            $estado = $row['estado'] == 'N' 
                ? '<span style="background-color: orange; padding: 2px 5px;">Notificado</span>' 
                : ($row['estado'] == 'C' 
                    ? '<span style="background-color: red; padding: 2px 5px;">Afecto corte</span>' 
                    : ($row['estado'] == 'S' 
                        ? '<span style="background-color: gray; padding: 2px 5px;">Sin servicio</span>' 
                        : ($row['estado'] == 'P' 
                            ? '<span style="background-color: green; padding: 2px 5px;">Pagado</span>' 
                            : $row['estado'])));

            $tabla .= '<tr id="' . $row['Id_Licencia_Agua'] . '" >
                         <td style="text-align: center;">' . $contador++ . '</td>  
                        <td style="text-align: center;">' . $row['Nombres_Licencia'] . '</td>
                        <td style="text-align: center;">' . $row['Numero_Notificacion'] . '</td>
                        <td style="text-align: center;">' . $row['tipo_via'] . ' ' . $row['nombre_calle'] . ' Mz. ' . $row['numManzana'] . ' Lt. ' . $row['Lote'] . ' Nro Luz. ' . $row['Luz'] . ' Cdra.' . $row['cuadra'] . ' ' . $row['zona'] . ' ' . $row['habilitacion'] . '</td>
                        <td style="text-align: center;">' . $row['Fecha_Registro'] . '</td>
                        <td style="text-align: center;">' . $row['fecha_corte'] . '</td>
                         <td style="text-align: center;">' . $estado . '</td>
                             <td>
                            <div class="btn-group">
                                <button class="btn btn-warning btnEditarNotificacion" 
                                         data-idNotificacionA="' . $row['Id_Notificacion_Agua'] . '"
                                        data-toggle="modal" data-target="#modalEditarNotificacion">
                                        <i class="fas fa-edit"></i>
                                </button>
                              <button class="btn btn-danger btnAbrirNotificacion" 
                                    data-idnotificacion="' . $row['Id_Notificacion_Agua'] . '" 
                                    data-toggle="modal" data-target="#modalEliminarNotificacion">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            </div>
                        </td>
                    </tr>';
        }
    } else {
        $tabla = '<tr><td colspan="12">No se encontraron notificaciones.</td></tr>';
    }

            // Obtener el total de registros para la paginación
        $total_registros = ModeloNotificacion::mdlContarNotificaciones($filtro_nombre, $filtro_fecha, $filtro_estado);

        // Calcular el número total de páginas
        $total_paginas = ceil($total_registros / $resultados_por_pagina);

        // Asegurarse de que la página no sea mayor que el total de páginas
        if ($pagina > $total_paginas) {
            $pagina = $total_paginas;
        } elseif ($pagina < 1) {
            $pagina = 1;
        }

        // Rango de páginas que vamos a mostrar (3 anteriores, 3 posteriores)
        $rangos = 5;

        // Iniciamos la variable para contener los enlaces de paginación
        $pagination = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

        // Enlace de "Anterior"
        if ($pagina > 1) {
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . ($pagina - 1) . ')">Anterior</a></li>';
        }

        // Páginas anteriores y siguientes
        // Si la diferencia entre la página actual y la primera página es mayor que 6, agregar puntos suspensivos
        if ($pagina > $rangos + 1) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        // Mostrar las páginas anteriores (hasta 3 páginas)
        for ($i = max(1, $pagina - $rangos); $i < $pagina; $i++) {
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . $i . ')">' . $i . '</a></li>';
        }

        // Página actual (marcada como activa)
        $pagination .= '<li class="page-item active"><a class="page-link" href="javascript:void(0);">' . $pagina . '</a></li>';

        // Mostrar las páginas siguientes (hasta 3 páginas)
        for ($i = $pagina + 1; $i <= min($total_paginas, $pagina + $rangos); $i++) {
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . $i . ')">' . $i . '</a></li>';
        }

        // Si la diferencia entre la página actual y la última página es mayor que 6, agregar puntos suspensivos
        if ($pagina < $total_paginas - $rangos) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        // Enlace de "Siguiente"
        if ($pagina < $total_paginas) {
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . ($pagina + 1) . ')">Siguiente</a></li>';
        }

        $pagination .= '</ul></nav>';

        // Devolver los resultados y la paginación
        echo json_encode(array('data' => $tabla, 'pagination' => $pagination));


//     $total_registros = ModeloNotificacion::mdlContarNotificaciones($filtro_nombre, $filtro_fecha, $filtro_estado);

//     // Calcular el número total de páginas
// $total_paginas = ceil($total_registros / $resultados_por_pagina);

// // Asegurarse de que la página no sea mayor que el total de páginas
// if ($pagina > $total_paginas) {
//     $pagina = $total_paginas;
// } elseif ($pagina < 1) {
//     $pagina = 1;
// }

// // Rango de páginas que vamos a mostrar
// $rangos = 2; // Cuántas páginas anteriores y siguientes mostrar

// $pagination = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

// // Enlace de "Anterior"
// if ($pagina > 1) {
//     $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . ($pagina - 1) . ')">Anterior</a></li>';
// }

// // Páginas anteriores y siguientes
// for ($i = max(1, $pagina - $rangos); $i <= min($total_paginas, $pagina + $rangos); $i++) {
//     if ($i == $pagina) {
//         $pagination .= '<li class="page-item active"><a class="page-link" href="javascript:void(0);">' . $i . '</a></li>';
//     } else {
//         $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . $i . ')">' . $i . '</a></li>';
//     }
// }

// // Enlace de "Siguiente"
// if ($pagina < $total_paginas) {
//     $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . ($pagina + 1) . ')">Siguiente</a></li>';
// }

// $pagination .= '</ul></nav>';

// // Devolver los resultados y la paginación
// echo json_encode(array('data' => $tabla, 'pagination' => $pagination));

    // // Obtener el total de registros para la paginación
    // $total_registros = ModeloNotificacion::mdlContarNotificaciones($filtro_nombre, $filtro_fecha, $filtro_estado);

    // // Calcular el número total de páginas
    // $total_paginas = ceil($total_registros / $resultados_por_pagina);

    // // Asegurarse de que el número de página no sea mayor que el total de páginas
    // if ($pagina > $total_paginas) {
    //     $pagina = $total_paginas;
    // }

    // // Crear los enlaces de paginación
    // $pagination = '<div>';
    // if ($pagina > 1) {
    //     $pagination .= '<a href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . ($pagina - 1) . ')">Anterior</a> ';
    // }
    // if ($pagina < $total_paginas) {
    //     $pagination .= '<a href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . ($pagina + 1) . ')">Siguiente</a>';
    // }
    // $pagination .= '</div>';

    // // Devolver los resultados y la paginación
    // echo json_encode(array('data' => $tabla, 'pagination' => $pagination));


    
}


    //  public static function ctrMostrarNotificaciones($filtro_nombre = '', $filtro_fecha = '',$filtro_estado='')
    // {
    //     // Llamamos al modelo y pasamos el filtro de nombre y fecha
    //     $respuesta = ModeloNotificacion::mdlMostrarNotificacion($filtro_nombre, $filtro_fecha,$filtro_estado);

    //     $contador = 1;  // Inicializamos el contador

    //     // Recorrer todos los resultados y mostrarlos en la tabla HTML
    //     if ($respuesta) {
    //         foreach ($respuesta as $row) {

    //        $estado = $row['estado'] == 'P' 
    //         ? '<span style="background-color: orange; padding: 2px 5px;">Pendiente</span>' 
    //         : ($row['estado'] == 'C' 
    //             ? '<span style="background-color: red; padding: 2px 5px;">Afecto corte</span>' 
    //             : ($row['estado'] == 'S' 
    //                 ? '<span style="background-color: gray; padding: 2px 5px;">Sin servicio</span>' 
    //                 : ($row['estado'] == 'PA' 
    //                     ? '<span style="background-color: green; padding: 2px 5px;">Pagado</span>' 
    //                     : $row['estado'])));



             
    //             echo '<tr id="' . $row['Id_Licencia_Agua'] . '" >
    //                      <td style="text-align: center;">' . $contador++ . '</td>  
    //                     <td style="text-align: center;">' . $row['Nombres_Licencia'] . '</td>
    //                     <td style="text-align: center;">' . $row['Numero_Notificacion'] . '</td>
    //                    <td style="text-align: center;">' . $row['tipo_via'] . ' ' . $row['nombre_calle'] . ' Mz. ' . $row['numManzana'] . ' Lt. ' . $row['Lote'].  ' Nro Luz. ' . $row['Luz']. ' Cdra.' . $row['cuadra'] . ' ' . $row['zona'] . ' ' . $row['habilitacion'] . '</td>
    //                     <td style="text-align: center;">' . $row['Fecha_Registro'] . '</td>
    //                     <td style="text-align: center;">' . $row['fecha_corte'] . '</td>
    //                      <td style="text-align: center;">' . $estado . '</td>
    //                          <td>
    //                         <div class="btn-group">
    //                             <button class="btn btn-warning btnEditarNotificacion" 
    //                                      data-idNotificacionA="' . $row['Id_Notificacion_Agua'] . '"
    //                                     data-toggle="modal" data-target="#modalEditarNotificacion">
    //                                     <i class="fas fa-edit"></i>
    //                             </button>
    //                           <button class="btn btn-danger btnAbrirNotificacion" 
    //                                 data-idnotificacion="' . $row['Id_Notificacion_Agua'] . '" 
    //                                 data-toggle="modal" data-target="#modalEliminarNotificacion">
    //                             <i class="fas fa-trash-alt"></i>
    //                         </button>

    //                         </div>
    //                     </td>
    //                 </tr>';
    //         }
    //     } else {
    //         echo '<tr><td colspan="12">No se encontraron notificaciones.</td></tr>';
    //     }
    // }






    }
