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


public static function ctrMostrarTipoPagoNo()
	{
		$respuesta = ModeloNotificacion::mdlMostrarTipoPago();
		return $respuesta;
	}
    public static function ctrMostrarCuotas()
	{
		$respuesta = ModeloNotificacion::mdlMostrarCuotas();
		return $respuesta;
	}


public static function ctrPagoPorCuotas($datos) {

    $cantidadCuotas = $datos['cuotas'];

      if ($cantidadCuotas == 0) {
        return array(
            "tipo" => "correcto",
            "cuotasHTML" => "" // No hay cuotas que mostrar
        );
    }


    // Se pasa los datos al modelo que se encargará de calcular la suma de las cuotas
    $respuesta = ModeloNotificacion::mdlPagoPorCuotas($datos);

    // Verificamos si el valor de $respuesta es válido (debería ser un número)
    if ($respuesta !== null && $respuesta !== false) {
        // Generar el HTML para las cuotas
        $cuotasHTML = '';
        // Usamos el valor de la cuota calculado para mostrarlo dinámicamente
        $valorCuota = $respuesta;  // Aquí $respuesta es la suma de las cuotas dividida entre la cantidad de cuotas

        // Empezamos con la fecha actual para la primera cuota
        $fechaVencimiento = date('Y-m-d'); // Fecha actual para la primera cuota

        for ($i = 1; $i <= $cantidadCuotas; $i++) {
            // Aquí generamos los valores dinámicos de cada cuota
            $cuotasHTML .= '
    <div class="row">
        <div class="col-md-2">
            <label for="estadoN" class="col-form-label" id="montoPrimera" name="montoPrimera">Cuota ' . $i . ': </label>
            <span>S/.' . number_format($valorCuota, 2) . '</span>
        </div>

        <div class="col-md-3">
            <label for="estadoN" class="col-form-label" >Fecha ven.: </label>
            <span>' . date('d/m/Y', strtotime($fechaVencimiento)) . '</span>';

            // Si es la primera cuota, agregamos "Pagar hoy"
          

        $cuotasHTML .= '
        </div>

        <div class="col-md-3 cuotas" style="display: none;">
            <label for="numeroProveidoP" class="col-form-label">Nro proveido: </label>
            <input type="text" style="width: 60px;" id="numeroProveidoP" name="numeroProveidoP">
        </div>

         <div class="col-md-4 cuotas" style="display: none;">
                                    <label for="estadoNP" class="col-md-7 col-form-label">Reconexion de agua</label>
                                    <div class="col-md-5">
                                        <select class="form-control" id="estadoNP" name="estadoNP">
                                            <option value=" ">Selecionar</option>
                                            <option value="R">Reconectar</option>
                                          
                                        </select>
                                     </div>
    </div>
    </div>
';

            // Actualizamos la fecha de vencimiento para la siguiente cuota, sumando un mes
            $fechaVencimiento = date('Y-m-d', strtotime("+1 month", strtotime($fechaVencimiento)));
        }

        // Si todo salió bien, devolvemos la respuesta con el HTML generado
        $respuesta = array(
            "tipo" => "correcto",           
            "cuotasHTML" => $cuotasHTML // Agregamos el HTML generado al array de respuesta
        );
        return $respuesta;
    } else {
        // En caso de error, devolvemos el mensaje de error
        $respuesta = array(
            "tipo" => "error",
            "mensaje" => '
                <div class="alert error">
                    <input type="checkbox" id="alert1"/> 
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true" class="letra_error">×</span>
                    </button>
                    <p class="inner"><strong class="letra_error">Error!</strong> 
                    <span class="letra_error">Algo salió mal, comunícate con el Administrador</span></p>
                </div>'
        );
        return $respuesta;
    }
}




public static function ctrGuardarNotificacionesParticion($datos) {

    
    // Se pasa los datos al modelo que se encargará de guardar la notificación
    $respuesta = ModeloNotificacion::mdlGuardarIdNotificacionParticion($datos);

 	
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


//REGISTRAR SEGUNDA CUOTA PAGADO ---- RECONEXION
public static function ctrSegundaGuardarNotificaciones($datos) {

    
    // Se pasa los datos al modelo que se encargará de guardar la notificación
    $respuesta = ModeloNotificacion::mdlSegundaGuardarIdNotificacion($datos);

 	
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


//REGISTRAR TOTAL PAGADO ---- RECONEXION
public static function ctrTotalGuardarNotificaciones($datos) {

    
    // Se pasa los datos al modelo que se encargará de guardar la notificación
    $respuesta = ModeloNotificacion::mdlTotalGuardarIdNotificacion($datos);

 	
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

    

    //mostrar segunda cuota
public static function ctrMostrar_mostrar_pago_segunda_cuota($idNotificionAgua)
{

    $respuesta = ModeloNotificacion::mdlMostrar_segunda_cuota($idNotificionAgua);

   
    if (count($respuesta) > 0) {
          $contador = 1; 
        foreach ($respuesta as $fila) {
            // Verifica si el estado es 'H' para aplicar la clase red-background
           
               if (!empty($fila['numero_proveido'])) {
                // Si tiene valor, mostrar el span con el valor
                $numeroProveido = '<span id="fechaVenCuot" name="fechaVenCuot">' . $fila['numero_proveido'] . '</span>';
            } else {
                // Si no tiene valor, mostrar el input vacío
                $numeroProveido = '<input type="text" style="width: 60px;" id="numeroProveidoCuotaSegundo" name="numeroProveidoCuotaSegundo">';
            }

            // Deshabilitar el primer "option" solo en la primera iteración
            $disabled = ($contador == 1) ? 'disabled' : '';

            // Imprime las filas de la tabla con la clase correspondiente
            echo '                     
                           <div class="row">
                              <div class="col-md-2">
                                  <label for="estadoN" class="col-form-label" >Cuota :  </label>
                                S/. <span id="montoCuot" name="montoCuot">'. $fila['monto'] . '</span>
                              </div>

                              <div class="col-md-3">
                                  <label for="estadoN" class="col-form-label">Fecha ven.: </label>
                                  <span id="fechaVenCuot" name="fechaVenCuot" > '. $fila['Fecha_Vencimiento'] . ' </span>
                              </div>

                               <div class="col-md-3 cuotas">
                                    <label class="col-form-label">Nro proveído: </label>
                                    ' . $numeroProveido . '  <!-- Se muestra el span si existe el valor, o el input si está vacío -->
                                </div>
                              
                               <div class="col-md-4 cuotas">
                                    <label for="estadoNP" class="col-md-7 col-form-label">Reconexión de agua</label>
                                    <div class="col-md-5">
                                        <select class="form-control" id="estadoNS" name="estadoNS" ' . $disabled . '>
                                            <option value=" ">Seleccionar</option>
                                            <option value="R" selected>Reconectar</option> 
                                        </select>
                                    </div>
                                </div>


                          </div>
                
                
                ';
                $contador++;
        }
    } else {
        echo '<tr><td class="text-center" colspan="10">No registra Deuda de Agua</td></tr>';
    }
}


    public static function ctrMostrar_licencia_estadocuenta_n($idlicenciaagua)
{

    $respuesta = ModeloNotificacion::mdlEstadoCuenta_agua($idlicenciaagua);

   
    if (count($respuesta) > 0) {
        foreach ($respuesta as $fila) {
            // Verifica si el estado es 'H' para aplicar la clase red-background
            $estadoFila = $fila['Estado'];
            $rowClass = '';  // No se aplica clase si no es 'H' o 'D'
            
            // Si el estado es 'H', le asignamos la clase para el fondo verde
            if ($estadoFila == 'H') {
                $rowClass = 'green-background';  // Clase para fondo verde
            } 
            // Si el estado es 'D', no se cambia el fondo (se mantiene como está)
            elseif ($estadoFila == 'D') {
                $rowClass = '';  // No se aplica clase, lo deja con el estilo predeterminado
            }

            // Imprime las filas de la tabla con la clase correspondiente
            echo '<tr id="' . $fila['Id_Estado_Cuenta_Agua'] . '" class="' . $rowClass . '">
                    <td class="text-center" style="width:30px;">' . $fila['Tipo_Tributo'] . '</td>
                    <td class="text-center" style="width:50px;">Agua</td>
                    <td class="text-center" style="width:50px;">' . $fila['Anio'] . '</td>
                    <td class="text-center" style="width:50px;">' . $fila['Periodo'] . '</td>
                    <td class="text-center" style="width:50px;">' . $fila['Importe'] . '</td>
                    <td class="text-center" style="width:50px;">' . $fila['Gasto_Emision'] . '</td>
                    <td class="text-center" style="width:50px;">' . $fila['Total'] . '</td>
                    <td class="text-center" style="width:50px;">' . $fila['Descuento'] . '</td>
                    <td class="text-center" style="width:50px;">' . $fila['Total_Aplicar'] . '</td>
                    <td class="text-center" style="width:20px;"></td>
                </tr>';
        }
    } else {
        echo '<tr><td class="text-center" colspan="10">No registra Deuda de Agua</td></tr>';
    }
}




public static function ctrMostrarNotificaciones($filtro_nombre = '', $filtro_fecha = '', $filtro_estado = '', $pagina = 1, $resultados_por_pagina = 10)
{
    // Calcular el inicio de la consulta según la página actual
    $inicio = ($pagina - 1) * $resultados_por_pagina;

    // Llamamos al modelo y pasamos los filtros y la paginación
    $respuesta = ModeloNotificacion::mdlMostrarNotificacion($filtro_nombre, $filtro_fecha, $filtro_estado, $inicio, $resultados_por_pagina);


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
                                : ($row['estado'] == 'R' 
                                    ? '<span style="background-color: #26a1d1; padding: 2px 5px;">Reconectado</span>' 
                                    : ($row['estado'] == 'R1' 
                                          ? '<span style="background: linear-gradient(to right, #26a1d1 50%, red 50%); padding: 2px 5px;">1ra cuota</span>' 
                                            : ($row['estado'] == 'MC' 
                                          ? '<span style="background: #d95218; color:#ffffff; padding: 2px 5px;">Cerrado</span>' 
                                                   : ($row['estado'] == 'RC' 
                                          ? '<span style="background: #6fbdde; color:#ffffff; padding: 2px 5px;">Recon. medidor</span>' 
   
                                         : $row['estado']))))))) ;

                               // Crear botones dependiendo del estado
                        $botonReconectarAgua = '';  // Para el primer botón
                        $botonReconectarAguasdacuota = '';  // Para el segundo botón
                        $botonEditarNotificacion = '';  // Variable para el botón de edición
                       

                        if ($row['estado'] == 'R1') {
                            // Si el estado es R1, mostrar el botón de "Reconexion agua segunda cuota" y ocultar el otro
                            $botonReconectarAguasdacuota = '<button class="btn btn-danger btnReconectarAguaseCuota" style="padding: 6px 15px;"
                                                                data-idnotificacionrp="' . $row['Id_Notificacion_Agua'] . '" 
                                                                data-idlicenciarp="' . $row['Id_Licencia_Agua'] . '" 
                                                                data-idcontribuyentep="' . $row['Id_Contribuyente'] . '" 
                                                                data-toggle="modal" data-target="#modalReconectarAguasdacuota"
                                                                title="Reconexion agua segunda cuota">
                                                                <i class="fas fa-tint "></i> 
                                                            </button>';
                        } elseif ($row['estado'] == 'S') {
                            // Si el estado es R, mostrar el botón de "Reconexion agua" y ocultar el otro
                            $botonReconectarAgua = '<button class="btn btn-info btnReconectarAgua" style="padding: 6px 15px;"
                                                        data-idnotificacionr="' . $row['Id_Notificacion_Agua'] . '" 
                                                        data-idlicenciar="' . $row['Id_Licencia_Agua'] . '" 
                                                        data-idcontribuyenter="' . $row['Id_Contribuyente'] . '" 
                                                        data-toggle="modal" data-target="#modalReconectarAgua"
                                                        title="Reconexion agua">
                                                        <i class="fas fa-tint "></i> 
                                                    </button>';
                        }

                        // Solo mostrar el botón de "Editar Notificación" si el estado no es R1 ni S
                if ($row['estado'] != 'R1' && $row['estado'] != 'S') {
                    $botonEditarNotificacion = '<button class="btn btn-warning btnEditarNotificacion " 
                                                data-idNotificacionA="' . $row['Id_Notificacion_Agua'] . '"
                                                data-toggle="modal" data-target="#modalEditarNotificacion"
                                                title="Editar Notificación">
                                                <i class="fas fa-edit"></i>
                                            </button>';
                }


            $tabla .= '<tr id="' . $row['Id_Licencia_Agua'] . '" >

                       
                         <td style="text-align: center;">
                            <input type="checkbox" class="checkbox-notificacion" value="' . $row['Id_Notificacion_Agua'] . '">
                        </td>
                        
                        <td style="text-align: center;" class="id-contribuyente" data-id="' . $row['Id_Contribuyente'] . '">
                                <button class="btn-enlace">' . $row['Id_Contribuyente'] . '</button>
                            </td>
                        <td style="text-align: center;">' . $row['Nombres_Licencia'] . '</td>
                        <td style="text-align: center;">' . $row['Numero_Notificacion'] . '</td>
                        <td style="text-align: center;">' . $row['tipo_via'] . ' ' . $row['nombre_calle'] . ' Mz. ' . $row['numManzana'] . ' Lt. ' . $row['Lote'] . ' Nro Luz. ' . $row['Luz'] . ' Cdra.' . $row['cuadra'] . ' ' . $row['zona'] . ' ' . $row['habilitacion'] . '</td>
                        <td style="text-align: center;">' . $row['Fecha_Registro'] . '</td>
                        <td style="text-align: center;">' . $row['fecha_corte'] . '</td>
                         <td style="text-align: center;">' . $estado . '</td>
                             <td style="text-align: center;">

                            <div class="btn-group"  >
                           <button class="btn btn-danger btnVerNotificacion" 
                                data-idnotificacionver="' . $row['Id_Notificacion_Agua'] . '" 
                                data-idlicenciaver="' . $row['Id_Licencia_Agua'] . '" 
                                data-idcontribuyentever="' . $row['Id_Contribuyente'] . '" 
                                data-toggle="modal" data-target="#modalVerAgua"
                                title="Ver Notificación"
                                
                                >
                            <i class="fas fa-eye"></i>
                        </button>

                            
                             ' . $botonReconectarAgua . '
                             ' . $botonReconectarAguasdacuota . '
                             ' . $botonEditarNotificacion . '
                                

                              <button class="btn btn-danger btnAbrirNotificacion" 
                                    data-idnotificacion="' . $row['Id_Notificacion_Agua'] . '" 
                                    data-toggle="modal" data-target="#modalEliminarNotificacion"
                                     title="Eliminar Notificación"
                                    >
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


        // Rango de páginas
        $rangos = 5;

        // Calcular resumen
        $registro_inicio = $inicio + 1;
        $registro_fin = $inicio + count($respuesta);

        // Estructura flex con resumen + paginación
        $pagination = '
        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
            <div class="registro-resumen" style="color:#969493">Mostrando del ' . $registro_inicio . ' al ' . $registro_fin . ' de un total de ' . $total_registros . ' registros</div>
        
            <nav aria-label="Page navigation example">
                <ul class="pagination mb-0">
        ';

        if ($pagina > 1) {
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . ($pagina - 1) . ')">Anterior</a></li>';
        }

        if ($pagina > $rangos + 1) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        for ($i = max(1, $pagina - $rangos); $i < $pagina; $i++) {
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . $i . ')">' . $i . '</a></li>';
        }

        $pagination .= '<li class="page-item active"><a class="page-link" href="javascript:void(0);">' . $pagina . '</a></li>';

        for ($i = $pagina + 1; $i <= min($total_paginas, $pagina + $rangos); $i++) {
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . $i . ')">' . $i . '</a></li>';
        }

        if ($pagina < $total_paginas - $rangos) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        if ($pagina < $total_paginas) {
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="notificacionUsuario.lista_notificacion(\'' . $filtro_nombre . '\', \'' . $filtro_fecha . '\', \'' . $filtro_estado . '\', ' . ($pagina + 1) . ')">Siguiente</a></li>';
        }

        $pagination .= '
                </ul>
            </nav>
        </div>
    ';

        // Devolver los resultados y la paginación
        echo json_encode(array('data' => $tabla, 'pagination' => $pagination));

    }

    }
