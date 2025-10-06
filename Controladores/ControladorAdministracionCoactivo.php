<?php

namespace Controladores;

use Modelos\ModeloAdministracionCoactivo;

class ControladorAdministracionCoactivo
{

    //GUADAR ARCHIVAR COACTIVO

    

    public static function ctrGuardarEditarArchivar($idcoactivo, $expediente, $estado,  $idcontribuyente) 
    {
    
    // Llamamos al modelo y pasamos los filtros y la paginación
    $respuesta = ModeloAdministracionCoactivo::mdlGuardarEditarArchivar($idcoactivo, $expediente, $estado,  $idcontribuyente);

 
      if ($respuesta == 'ok') {
            echo json_encode([
                "status" => "ok",
                "message" => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">El expediente se registro de manera correcta</span></p></div>'
            ]);
        } else {
            echo json_encode([
                "status" => "error", 
                "message" => '<div class="alert warning">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Algo salio mal comunicate con el Administrador</span></p></div>'
            ]);
        }
 
 
    }

    //GUATRADR EDIATAR
        public static function ctrGuardarEditar($idcoactivo, $expediente, $estado) 
    {
    
    // Llamamos al modelo y pasamos los filtros y la paginación
    $respuesta = ModeloAdministracionCoactivo::mdlGuardarEditar($idcoactivo, $expediente, $estado);

 
      if ($respuesta == 'ok') {
            echo json_encode([
                "status" => "ok",
                "message" => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">El expediente se registro de manera correcta</span></p></div>'
            ]);
        } else {
            echo json_encode([
                "status" => "error", 
                "message" => '<div class="alert warning">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Algo salio mal comunicate con el Administrador</span></p></div>'
            ]);
        }
 
 
    }


    public static function ctrMostrarEditar($idCoactivo) 
{
    // Llamamos al modelo y pasamos los filtros y la paginación
    $respuesta = ModeloAdministracionCoactivo::mdlMostrarEditar($idCoactivo);

    echo json_encode(array('data' => $respuesta));
 
    }

    //mostrar para archivar
      public static function ctrMostrarEditarArchivar($idCoactivo) 
{
    // Llamamos al modelo y pasamos los filtros y la paginación
    $respuesta = ModeloAdministracionCoactivo::mdlMostrarEditarArchivar($idCoactivo);

    echo json_encode(array('data' => $respuesta));
 
    }

    



    public static function ctrMostrarAdministracionCoactivoTotalAnio($idContribuyente) 
{
    // Llamamos al modelo y pasamos los filtros y la paginación
    $respuesta = ModeloAdministracionCoactivo::mdlMostrarAdministracionCoactivoTotalAnio($idContribuyente);

    // Comienza la primera tabla
    $tabla = '<table border="1" style="border-collapse: collapse;">';
    $tabla .= '<thead>
                <tr>
                    <th style="width:20%">Año</th>
                    <th style="width:40%">TIM a Aplicar</th>
                    <th style="width:40%">Total a Aplicar</th>
                </tr>
              </thead>';
    
    // Recorre cada fila del array de respuesta
    if ($respuesta) {
        foreach ($respuesta as $row) {
            // Añadimos una fila por cada resultado
            $tabla .= '<tr>';
            $tabla .= '<td>' . $row['Anio'] . '</td>';
            $tabla .= '<td>' . number_format($row['TIM_Aplicar'], 2) . '</td>'; 
            $tabla .= '<td>' . number_format($row['Total_Aplicar'], 2) . '</td>';  // Formateamos a 2 decimales
            $tabla .= '</tr>';
        }
    } else {
        // Si no hay resultados, mostramos un mensaje
        $tabla .= '<tr><td colspan="3">No se encontraron datos.</td></tr>';
    }

    // Cierra la primera tabla
    $tabla .= '</table>';

    $tablat = '';
   // Añadimos la fila de los totales al final
    $total_registros = ModeloAdministracionCoactivo::mdlTotalTimTotalCoactivo($idContribuyente);


  //  var_dump($total_registros);

    // Verifica si se obtuvieron resultados de la consulta
  if ($total_registros) {
    // Usar los índices correctos de la consulta
    $total_tim_aplicar = $total_registros[0]['SUM(ord.TIM )'] ?? 0;  // Índice correcto para TIM_Aplicar
    $total_a_aplicar = $total_registros[0]['SUM(ord.Total)'] ?? 0;  // Índice correcto para Total_Aplicar
    
    $tablat .= '<tr>';
    $tablat .= '<td style="width:20%; font-size: 18px;"> <strong>Total: </strong></td>';
    $tablat .= '<td style="width:40%; font-size: 18px;">  <strong>' . number_format($total_tim_aplicar, 2) . '</strong></td>';  // Total TIM aplicar
    $tablat .= '<td style="width:40%; font-size: 18px;"> <strong>' . number_format($total_a_aplicar, 2) . '</strong></td>';  // Total a aplicar
    $tablat .= '</tr>';
} else {
    $tablat .= '<tr><td colspan="3">No se encontraron datos para los totales.</td></tr>';
}
    // Devuelves ambas tablas (primera tabla y segunda tabla)
    echo json_encode(array('data' => $tabla, 'pagination' => $tablat));
}







      public static function ctrMostrarAdministracionCoactivo($filtro_nombre,$filtro_op, $filtro_ex, $pagina, $resultados_por_pagina ) 
  {

 
    
    // Calcular el inicio de la consulta según la página actual
    $inicio = ($pagina - 1) * $resultados_por_pagina;

    // Llamamos al modelo y pasamos los filtros y la paginación
    $respuesta = ModeloAdministracionCoactivo::mdlMostrarAdministracionCoactivo($filtro_nombre,$filtro_op, $filtro_ex, $inicio, $resultados_por_pagina);

   // $fondo_fila = 'background-color: red;'; // Puedes cambiar este color a lo que prefieras
      //  $contador = 0; // Contador para alternar colores

     // Inicializar la variable para almacenar las filas de la tabla
    $tabla = '';
   
    if ($respuesta) {
        
        
        // Recorrer los resultados de la consulta directamente
        foreach ($respuesta as $row) {

         
          

            $estado=$row['estado_c'];
            if($estado==='M'){
                 $estado = '<span style="background-color: #57c957; color: #ffffff; padding: 5px 10px; border-radius: 5px;">M. cautelar</span>';
            }
            else if($estado==='I'){
                 $estado = '<span style="background-color: #cc9547; color: #ffffff; padding: 5px 10px; border-radius: 5px;">Iniciado</span>';
            }
            else if($estado==='A'){
                 $estado = '<span style="background-color: red; color: #ffffff; padding: 5px 10px; border-radius: 5px;">Archivado</span>';
            }
            else{
                $estado = '';


            }

            //enerar la fila de la tabla sin utilizar arrays para agrupar
            $tabla .= '<tr >
                        
                       
                          <td style="text-align: center;">' . $row['id_contribuyente'] . '</td>
                        <td style="text-align: center;">' . $row['expediente'] . '</td>
                        <td style="text-align: center;">' . $row['orden_pago'] . '</td>
                        <td style="text-align: left;">' . $row['nombre_completo'] . '</td>
                       
                        <td style="text-align: center;">' . $estado. '</td>
                        <td style="text-align: center;">
                            <div class="btn-group">

                                <button class="btn btn-danger btn-sm btnVerAdministracionCoactivo" 
                                        data-idcontribuyente="' . $row['id_contribuyente'] . '" 
                                        data-toggle="modal" data-target="#modalEstadoCuentaVer"
                                        title="Pago por años coactivo">
                                    <i class="fas fa-eye"></i> 
                                </button>

                                <button class="btn btn-danger btn-sm btnEditarAdministracionCoactivo" 
                                        data-idcoactivo="' . $row['id_coactivo'].'" 
                                        data-toggle="modal" data-target="#modalEditarEstadoCuenta"
                                        title="Pago por años coactivo">
                                    <i class="fas fa-edit"></i> 
                                </button>

                                 <button class="btn btn-danger btn-sm btnEditarAdministracionArchivar" 
                                        data-idcoactivo="' . $row['id_coactivo'].'" 
                                        data-idcontribuyente="' . $row['id_contribuyente'] . '" 
                                        data-toggle="modal" data-target="#modalEditarEstadoCuentaArchivar"
                                        title="Pago por años coactivo">
                                    <i class="fas fa-file"></i> 
                                </button>

                                <button class="btn btn-danger btn-sm btnAdministracionCoactivo" 
                                        data-idcontribuyente="' .  $row['id_contribuyente']  . '" 
                                        title="Pago por años coactivo">
                                    <i class="fas fa-arrow-right"></i>
                                </button>


                            </div>
                        </td>
                    </tr>';
                     // Actualizar el último valor de 'ubicacionvia'
          
              
        }
    } else {
        $tabla = '<tr><td colspan="12">No se encontraron contribuyentes.</td></tr>';
    }
          // Obtener el total de registros para la paginación
        $total_registros = ModeloAdministracionCoactivo::mdlContarAdministracionCoactivo($filtro_nombre,$filtro_op, $filtro_ex);

       

        // Calcular el número total de páginas
        $total_paginas = ceil($total_registros / $resultados_por_pagina);

        // Asegurarse de que la página no sea mayor que el total de páginas
        if ($pagina > $total_paginas) {
            $pagina = $total_paginas;
        } elseif ($pagina < 1) {
            $pagina = 1;
        }


        // Rango de páginas
        $rangos = 5;

        // Calcular resumen
        $registro_inicio = $inicio + 1;
        $registro_fin = $inicio + count($respuesta);

          $pagination = '';
        
    //     // Estructura flex con resumen + paginación
    //     $pagination = '
    //     <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
    //         <div class="registro-resumen" style="color:#969493">
    //             Mostrando del ' . $registro_inicio . ' al ' . $registro_fin . ' de un total de ' . $total_registros . ' registros. 
    //             <strong id="paginal_Actual_c" style="display: none;"> Página ' . $pagina . ' de ' . $total_paginas . '</strong> <!-- Mostrar la página actual -->
    //         </div>
    
    //         <nav aria-label="Page navigation example">
    //             <ul class="pagination mb-0">
    //              <li class="page-item">
    //                 <a class="page-link" href="javascript:void(0);" onclick="administracionCoactivo_.lista_coactivo(\'' . $filtro_nombre . '\', \'' . $filtro_op . '\' ,  \'' . $filtro_ex . '\', 1)">Primero</a>
    //             </li>';

        

    //     if ($pagina > 1) {
    //         $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="administracionCoactivo_.lista_coactivo(\'' . $filtro_nombre . '\', \'' . $filtro_op . '\' ,  \'' . $filtro_ex . '\',' . ($pagina - 1) . ')">Anterior</a></li>';
    //     }

    //     if ($pagina > $rangos + 1) {
    //         $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
    //     }

    //     for ($i = max(1, $pagina - $rangos); $i < $pagina; $i++) {
    //         $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="administracionCoactivo_.lista_coactivo(\'' . $filtro_nombre . '\',  \'' . $filtro_op . '\',  \'' . $filtro_ex . '\',' . $i . ')">' . $i . '</a></li>';
    //     }

    //     $pagination .= '<li class="page-item active"><a class="page-link" href="javascript:void(0);">' . $pagina . '</a></li>';

    //     for ($i = $pagina + 1; $i <= min($total_paginas, $pagina + $rangos); $i++) {
    //         $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="administracionCoactivo_.lista_coactivo(\'' . $filtro_nombre . '\',  \'' . $filtro_op . '\' ,  \'' . $filtro_ex . '\', ' . $i . ')">' . $i . '</a></li>';
    //     }

    //     if ($pagina < $total_paginas - $rangos) {
    //         $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
    //     }

    //     if ($pagina < $total_paginas) {
    //         $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="administracionCoactivo_.lista_coactivo(\'' . $filtro_nombre . '\', ,  \'' . $filtro_op . '\', ,  \'' . $filtro_ex . '\', ' . ($pagina + 1) . ')">Siguiente</a></li>';
    //     }

    //     $pagination .= '
    //                  <li class="page-item">
    //                 <a class="page-link" href="javascript:void(0);" onclick="administracionCoactivo_.lista_coactivo(\'' . $filtro_nombre . '\', \'' . $filtro_op . '\' ,  \'' . $filtro_ex . '\', ' . $total_paginas . ')">Último</a>
    //             </li>
    //             </ul>
    //         </nav>
    //     </div>
    // ';



         echo json_encode(array('data' => $tabla, 'pagination' => $pagination));
        // Devolver los resultados y la paginación
      

    

  }

//     public static function ctrMostrarAdministracionCoactivo($filtro_nombre,$pagina, $resultados_por_pagina ) 
//   {

    
//     // Calcular el inicio de la consulta según la página actual
//     $inicio = ($pagina - 1) * $resultados_por_pagina;

//     // Llamamos al modelo y pasamos los filtros y la paginación
//     $respuesta = ModeloAdministracionCoactivo::mdlMostrarAdministracionCoactivo($filtro_nombre, $inicio, $resultados_por_pagina);

//     //var_dump($respuesta); // Imprime la respuesta para ver los datos

//     // Inicializar variables para agrupar valores
//     $tabla = '';
//     $ubicacionvia_prev = '';
 
//     $codigos = [];
//     $documentos = [];
//     $nombres = [];
//     $direcciones = [];
//     $orden_pago=[];
//     $expediente=[];
//     $estado=[];
//      // Inicializar el contador
//     $contador = 0;

//     if ($respuesta) {
//         foreach ($respuesta as $row) {
//             // Agrupar los valores
//             if ($ubicacionvia_prev != $row['ubicacionvia']) {

               
//                 // Si la ubicación cambia, mostrar los valores acumulados
//                 if (!empty($codigos)) {
//                     // Unir códigos por coma
//                     $codigos_str = implode(', ', $codigos);
//                     $documentos_str = implode(', ', $documentos);
//                     $nombres_str = implode(', ', $nombres);
//                     $direcciones_str = implode(', ', $direcciones);
//                     $orden_pago_str = isset($orden_pago[0]) ? $orden_pago[0] : '';
//                     $expediente_str = isset($expediente[0]) ? $expediente[0] : '';
//                     $estado_str = isset($estado[0]) ? $estado[0] : '';

//                     // Agregar la fila a la tabla con los valores concatenados
//                     $tabla .= '<tr id="' . $ubicacionvia_prev . '">
                                
//                                 <td style="text-align: center; display: none;" class="id-contribuyente" data-id="' . $ubicacionvia_prev . '">
//                                     <button class="btn-enlace">' . $ubicacionvia_prev . '</button>
//                                 </td>
//                                 <td style="text-align: center;">' . $codigos_str . '</td>
//                                <td style="text-align: center;">' .$expediente_str. '</td>
//                                   <td style="text-align: center;">'.$orden_pago_str .'</td>
//                                 <td style="text-align: left;">' . $nombres_str . '</td>
//                                 <td style="text-align: left;">' . $direcciones_str . '</td>
//                                 <td style="text-align: center;">'.$estado_str .'</td>

//                                 <td style="text-align: center;">

//                            <div class="btn-group">
//                              <button class="btn btn-danger btn-sm btnVerAdministracionCoactivo" 
//                                 data-idcontribuyente="' . $codigos_str . '" 
//                                 data-toggle="modal" data-target="#modalEstadoCuenta"
//                                 title="Pago por años coactivo">
//                                 <i class="fas fa-eye"></i> 
//                             </button>

//                              <button class="btn btn-danger btn-sm btnEditarAdministracionCoactivo" 
//                                 data-idcontribuyente="' . $codigos_str . '" 
//                                 data-toggle="modal" data-target="#modalEditarEstadoCuenta"
//                                 title="Pago por años coactivo">
//                                 <i class="fas fa-edit"></i> 
//                             </button>


//                             <button class="btn btn-danger btn-sm  btnAdministracionCoactivo" 
//                                     data-idcontribuyente="' . $codigos_str . '" 
//                                     title="Pago por años coactivo">
//                                     <i class="fas fa-arrow-right"></i>
//                               </button>


//                             </div>



                                                  
//                                 </td>


//                             </tr>';
//                 }

//                 // Resetear las variables para la nueva ubicación
//                 $codigos = [];
//                 $documentos = [];
//                 $nombres = [];
//                 $direcciones = [];
//                 $orden_pago = [];
//                 $expediente = [];
//                 $estado = [];
//                 $ubicacionvia_prev = $row['ubicacionvia'];

//             }

//             // Acumular los valores
//             $codigos[] = $row['id_contribuyente'];  // o cualquier columna que quieras
//             $documentos[] = $row['documento'];
//             $nombres[] = $row['nombre_completo'];
//             $orden_pago[] = $row['orden_pago'];
//             $expediente[] = $row['expediente'];
//             $estado[] = $row['estado_c'];
//             $direcciones[] = isset($row['direccion_completo']) ? $row['direccion_completo'] : 'No disponible';
//              $contador++;
//         }

       
//     } else {

//         $tabla = '<tr><td colspan="12">No se encontraron contribuyentes.</td></tr>';
//     }

//           // Obtener el total de registros para la paginación
//         $total_registros = ModeloAdministracionCoactivo::mdlContarAdministracionCoactivo($filtro_nombre);

//         // Calcular el número total de páginas
//         $total_paginas = ceil($total_registros / $resultados_por_pagina);

//         // Asegurarse de que la página no sea mayor que el total de páginas
//         if ($pagina > $total_paginas) {
//             $pagina = $total_paginas;
//         } elseif ($pagina < 1) {
//             $pagina = 1;
//         }


//         // Rango de páginas
//         $rangos = 5;

//         // Calcular resumen
//         $registro_inicio = $inicio + 1;
//         $registro_fin = $inicio + count($respuesta);

//         // Estructura flex con resumen + paginación
//         $pagination = '
//         <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
//             <div class="registro-resumen" style="color:#969493">
//                 Mostrando del ' . $registro_inicio . ' al ' . $registro_fin . ' de un total de ' . $total_registros . ' registros. 
//                 <strong id="paginal_Actual_c" style="display: none;"> Página ' . $pagina . ' de ' . $total_paginas . '</strong> <!-- Mostrar la página actual -->
//             </div>
    
//             <nav aria-label="Page navigation example">
//                 <ul class="pagination mb-0">
//         ';

//         if ($pagina > 1) {
//             $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="administracionCoactivo_.lista_coactivo(\'' . $filtro_nombre . '\',' . ($pagina - 1) . ')">Anterior</a></li>';
//         }

//         if ($pagina > $rangos + 1) {
//             $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
//         }

//         for ($i = max(1, $pagina - $rangos); $i < $pagina; $i++) {
//             $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="administracionCoactivo_.lista_coactivo(\'' . $filtro_nombre . '\', ' . $i . ')">' . $i . '</a></li>';
//         }

//         $pagination .= '<li class="page-item active"><a class="page-link" href="javascript:void(0);">' . $pagina . '</a></li>';

//         for ($i = $pagina + 1; $i <= min($total_paginas, $pagina + $rangos); $i++) {
//             $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="administracionCoactivo_.lista_coactivo(\'' . $filtro_nombre . '\',  ' . $i . ')">' . $i . '</a></li>';
//         }

//         if ($pagina < $total_paginas - $rangos) {
//             $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
//         }

//         if ($pagina < $total_paginas) {
//             $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="administracionCoactivo_.lista_coactivo(\'' . $filtro_nombre . '\', ' . ($pagina + 1) . ')">Siguiente</a></li>';
//         }

//         $pagination .= '
//                 </ul>
//             </nav>
//         </div>
//     ';



//          echo json_encode(array('data' => $tabla, 'pagination' => $pagination));
//         // Devolver los resultados y la paginación
      

    

//   }




    }
