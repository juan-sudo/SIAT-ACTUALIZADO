<?php
namespace Modelos;
use Conect\Conexion;
use PDO;
use PDOException;

use Exception;

class ModeloNotificacion {


    

public static function mdlEliminarNotificacion($datos)
{
    try {
        $pdo = Conexion::conectar();
        // Corregimos la sintaxis del DELETE
        $stmt = $pdo->prepare("DELETE FROM notificacion_agua WHERE Id_Notificacion_Agua = :idNotificacion");

        $stmt->bindParam(":idNotificacion", $datos['idNotificacion']);
        $stmt->execute();

        $pdo = null; // Cerrar la conexión después de ejecutar la consulta
        return "ok";
    } catch (Exception $e) {
        throw new Exception("Error en la base de datos al eliminar la notificación: " . $e->getMessage());
    }
}



 public static function mdlMostrarTipoPago()
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM notificacion_t_pago ");
    //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
    $stmt->execute();
    return $stmt->fetchall();
    $stmt = null;
  }

   public static function mdlMostrarCuotas()
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM cuota_pago ");
    //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
    $stmt->execute();
    return $stmt->fetchall();
    $stmt = null;
  }


  //estado de cuenta para notificacion
  
    // Muestra el estado de Agua
	public static function mdlEstadoCuenta_agua($idlicenciaagua)
	{
		$pdo =  Conexion::conectar();
		$stmt = $pdo->prepare("SELECT * from estado_cuenta_agua   
		where Id_Licencia_Agua =$idlicenciaagua AND Estado_notificacion='N'");
		$stmt->execute();
		return  $stmt->fetchall();
		
	}

    //MOSTRAR SEGUDO CUOTA
    public static function mdlMostrar_segunda_cuota($idNotificionAgua)
	{
		$pdo =  Conexion::conectar();
		$stmt = $pdo->prepare("SELECT * from notificacion_pago   
		where Id_Notificacion_Agua =$idNotificionAgua ");
		$stmt->execute();
		return  $stmt->fetchall();
		
	}


    

  



//MOSTRAR DOS PAGOS DE CUOTA


public static function mdlPagoPorCuotas($datos)
{
    try {
        $pdo = Conexion::conectar();
        
        // Consulta para calcular la suma total de las cuotas
        $stmt = $pdo->prepare("SELECT SUM(Total_Aplicar) / :cuotas AS Suma_Cuotas 
                               FROM estado_cuenta_agua 
                               WHERE Id_Licencia_Agua = :idLicencia AND Estado_notificacion='N'");

        // Vinculamos los parámetros con los valores pasados en $datos
        $stmt->bindParam(":idLicencia", $datos['idLicencia']);
        $stmt->bindParam(":cuotas", $datos['cuotas']);

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtenemos el resultado
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Cerramos la conexión
        $pdo = null;

        // Verificamos si el resultado es válido y lo retornamos
        return isset($resultado['Suma_Cuotas']) ? $resultado['Suma_Cuotas'] : null;

    } catch (Exception $e) {
        // En caso de error, lanzamos una excepción
        throw new Exception("Error en la base de datos: " . $e->getMessage());
    }
}


public static function mdlMostrarGuardarIdNotificacion($datos)
{
   
  try {
      $pdo = Conexion::conectar();
      
      $stmt = $pdo->prepare("UPDATE notificacion_agua SET estado = :estado, observacion = :observacion WHERE Id_Notificacion_Agua = :idNotificacion");
      $stmt->bindParam(":idNotificacion", $datos['idNotificacion']);

        $stmt->bindParam(":estado", $datos['estado']);

        $stmt->bindParam(":observacion", $datos['observacion']);
      $stmt->execute();
      $pdo = null; // Mueve esta línea al final para cerrar la conexión después de ejecutar la consulta
      return "ok";
   } catch (Exception $e) {
      throw new Exception("Error en la base de datos al modificar los valores de Edificacion: " . $e->getMessage());
   }

}


//GUARDAR PAGO ´POR PARTICION.

public static function mdlGuardarIdNotificacionParticion($datos)
{
  
    try {
        // Establecer la conexión
        $pdo = Conexion::conectar();

        // Obtener la fecha actual (solo fecha)
        $fechaRegistro = date('Y-m-d');  // Para la fecha sin hora, solo la fecha actual

      

        // Consultar el Id_Notificacion_Agua
        $query = "SELECT Id_Notificacion_Agua FROM notificacion_agua WHERE Id_Licencia_Agua = :idLicencia";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":idLicencia", $datos['idLicencia'], PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se obtuvo el Id_Notificacion_Agua
        if ($resultado) {
            $idNotificacion = $resultado['Id_Notificacion_Agua'];
            
            // Realizar el UPDATE con el idNotificacion obtenido
            $stmt = $pdo->prepare("UPDATE notificacion_agua SET estado = :estadoReconectarParticion, 	fecha_corte=:fechaVencimiento WHERE Id_Notificacion_Agua = :idNotificacion");
            $stmt->bindParam(":idNotificacion", $idNotificacion);
            $stmt->bindParam(":estadoReconectarParticion", $datos['estadoReconectarParticion']);
             $stmt->bindParam(":fechaVencimiento", $datos['fechaVencimiento2']);
            // Ejecutar el UPDATE
            $stmt->execute();

            // INSERT PARA PRIMERA CUOTA
            $queryInsert = "INSERT INTO notificacion_pago (monto, Fecha_Registro, numero_proveido, Id_Notificacion_Agua, Id_Notificacion_t_Pago, Fecha_Vencimiento) 
                            VALUES (:monto, :Fecha_Registro, :numero_proveido, :Id_Notificacion_Agua, :idtipoPago, :fechaVencimiento)";
           
            $stmtInsert = $pdo->prepare($queryInsert);
            $stmtInsert->bindParam(":monto", $datos['particionAplicar']);
            $stmtInsert->bindParam(":Fecha_Registro", $fechaRegistro);
            $stmtInsert->bindParam(":numero_proveido", $datos['numeroProveido']);
            $stmtInsert->bindParam(":Id_Notificacion_Agua", $idNotificacion);
            $stmtInsert->bindParam(":idtipoPago", $datos['idtipoPago']);
            $stmtInsert->bindParam(":fechaVencimiento", $datos['fechaVencimiento']);

            // Ejecutar el primer INSERT
            if ($stmtInsert->execute()) {

                // INSERT PARA SEGUNDA CUOTA CON FECHA DIFERENTE
                $queryInserts = "INSERT INTO notificacion_pago (monto, Fecha_Registro, Id_Notificacion_Agua, Id_Notificacion_t_Pago, Fecha_Vencimiento) 
                                VALUES (:monto, :Fecha_Registro, :Id_Notificacion_Agua, :idtipoPago, :fechaVencimiento)";
                
                $stmtInserts = $pdo->prepare($queryInserts);
                $stmtInserts->bindParam(":monto", $datos['totalAplicar2']);
                $stmtInserts->bindParam(":Fecha_Registro", $fechaRegistro);
                $stmtInserts->bindParam(":Id_Notificacion_Agua", $idNotificacion);
                $stmtInserts->bindParam(":idtipoPago", $datos['idtipoPago']);
                $stmtInserts->bindParam(":fechaVencimiento", $datos['fechaVencimiento2']);
                
                // Ejecutar el segundo INSERT
                if ($stmtInserts->execute()) {
                    return "ok"; // Si ambos INSERTS se ejecutan correctamente, retorna "ok"
                } else {
                    throw new Exception("Error al insertar el segundo registro en notificacion_pago.");
                }
            } else {
                throw new Exception("Error al insertar el primer registro en notificacion_pago.");
            }
        } else {
            throw new Exception("No se encontró el Id_Notificacion_Agua para la licencia proporcionada.");
        }
    } catch (Exception $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
    }
}




// public static function mdlGuardarIdNotificacionParticion($datos)
// {
//     try {
//         // Establecer la conexión
//         $pdo = Conexion::conectar();

//         // Obtener la fecha actual (solo fecha)
//         $fechaRegistro = date('Y-m-d');  // Para la fecha sin hora, solo la fecha actual

//         // Consultar el Id_Notificacion_Agua
//         $query = "SELECT Id_Notificacion_Agua FROM notificacion_agua WHERE Id_Licencia_Agua = :idLicencia";
//         $stmt = $pdo->prepare($query);
//         $stmt->bindParam(":idLicencia", $datos['idLicencia'], PDO::PARAM_INT);

//         // Ejecutar la consulta
//         $stmt->execute();

//         // Obtener el resultado
//         $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

//         // Verificar si se obtuvo el Id_Notificacion_Agua
//         if ($resultado) {
//             $idNotificacion = $resultado['Id_Notificacion_Agua'];
            
//             // Realizar el UPDATE con el idNotificacion obtenido
//             $stmt = $pdo->prepare("UPDATE notificacion_agua SET estado = :estadoReconectarParticion WHERE Id_Notificacion_Agua = :idNotificacion");
//             $stmt->bindParam(":idNotificacion", $idNotificacion);
//             $stmt->bindParam(":estadoReconectarParticion", $datos['estadoReconectarParticion']);
//             // Ejecutar el UPDATE
//             $stmt->execute();










//             // INSERT PARA PRIMERA CUOTA
//             $queryInsert = "INSERT INTO notificacion_pago (monto, Fecha_Registro, numero_proveido, Id_Notificacion_Agua,Id_Notificacion_t_Pago, Fecha_Vencimiento) 
//                             VALUES (:monto, :Fecha_Registro, :numero_proveido, :Id_Notificacion_Agua, :idtipoPago, :fechaVencimiento )";
           
//             $stmtInsert = $pdo->prepare($queryInsert);
//             $stmtInsert->bindParam(":monto", $datos['particionAplicar']);
//             $stmtInsert->bindParam(":Fecha_Registro", $fechaRegistro);
//             $stmtInsert->bindParam(":numero_proveido", $datos['numeroProveido']);
//             $stmtInsert->bindParam(":Id_Notificacion_Agua", $idNotificacion);
//             $stmtInsert->bindParam(":idtipoPago", $datos['idtipoPago']);
//              $stmtInsert->bindParam(":fechaVencimiento", $datos['fechaVencimiento']);

             
//             // INSERT PARA PRIMERA CUOTA
//             $queryInserts = "INSERT INTO notificacion_pago (monto, Fecha_Registro,  Id_Notificacion_Agua,Id_Notificacion_t_Pago,Fecha_Vencimiento ) 
//                             VALUES (:monto, :Fecha_Registro,  :Id_Notificacion_Agua, :idtipoPago,:fechaVencimiento  )";
           
//             $stmtInserts = $pdo->prepare($queryInserts);
//             $stmtInserts->bindParam(":monto", $datos['totalAplicar2']);
//             $stmtInserts->bindParam(":Fecha_Registro", $fechaRegistro);
//             $stmtInserts->bindParam(":Id_Notificacion_Agua", $idNotificacion);
//             $stmtInserts->bindParam(":idtipoPago", $datos['idtipoPago']);
//             $stmtInsert->bindParam(":fechaVencimiento", $datos['fechaVencimiento2']);
//             $stmtInserts->execute();




            
//             // Ejecutar el INSERT y verificar si se ejecutó correctamente
//             if ($stmtInsert->execute()) {
//                 // Si la ejecución fue exitosa, devolver "ok"
//                 return "ok";
//             } else {
//                 // Si la ejecución falló, devolver un mensaje de error
//                 throw new Exception("Error al insertar el registro en notificacion_pago.");
//             }
//         } else {
//             throw new Exception("No se encontró el Id_Notificacion_Agua para la licencia proporcionada.");
//         }
//     } catch (Exception $e) {
//         // Manejo de errores
//         echo "Error: " . $e->getMessage();
//     }
// }



//GUARDAR SEGUNDA RECAUDACION
public static function mdlSegundaGuardarIdNotificacion($datos)
{
    try {
        // Establecer la conexión
        $pdo = Conexion::conectar();

        // Obtener la fecha actual (solo fecha)
        $fechaRegistro = date('Y-m-d');  // Para la fecha sin hora, solo la fecha actual

           $idNotificacion = $datos['idNotificaionAgua'];
           $estadoReconectaSegundo= $datos['estadoReconectarSeg'];

            
            // Realizar el UPDATE con el idNotificacion obtenido
            $stmt = $pdo->prepare("UPDATE notificacion_agua SET estado = :estadoReconectarSegundo WHERE Id_Notificacion_Agua = :idNotificacion");
            $stmt->bindParam(":idNotificacion", $idNotificacion);
            $stmt->bindParam(":estadoReconectarSegundo",$estadoReconectaSegundo );
            // Ejecutar el UPDATE
            $stmt->execute();

            $numeroProveido= $datos['numeroProveido'];

            $stmtInsert = $pdo->prepare("UPDATE notificacion_pago SET numero_proveido = :numeroProveido WHERE Id_Notificacion_Agua = :idNotificacion AND numero_proveido IS NULL");
            $stmtInsert->bindParam(":idNotificacion", $idNotificacion, PDO::PARAM_INT);
            $stmtInsert->bindParam(":numeroProveido",$numeroProveido , PDO::PARAM_INT);

            
            // Ejecutar el INSERT y verificar si se ejecutó correctamente
            if ($stmtInsert->execute()) {
                // Si la ejecución fue exitosa, devolver "ok"
                return "ok";
            } else {
                // Si la ejecución falló, devolver un mensaje de error
                throw new Exception("Error al insertar el registro en notificacion_pago.");
            }
       
    } catch (Exception $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
    }
}



//GUARDAR TOTAL RECAUDACION
public static function mdlTotalGuardarIdNotificacion($datos)
{
    try {
        // Establecer la conexión
        $pdo = Conexion::conectar();

        // Obtener la fecha actual (solo fecha)
        $fechaRegistro = date('Y-m-d');  // Para la fecha sin hora, solo la fecha actual

        // Consultar el Id_Notificacion_Agua
        $query = "SELECT Id_Notificacion_Agua FROM notificacion_agua WHERE Id_Licencia_Agua = :idLicencia";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":idLicencia", $datos['idLicencia'], PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se obtuvo el Id_Notificacion_Agua
        if ($resultado) {
            $idNotificacion = $resultado['Id_Notificacion_Agua'];
            
            // Realizar el UPDATE con el idNotificacion obtenido
            $stmt = $pdo->prepare("UPDATE notificacion_agua SET estado = :estadoReconectarTotal WHERE Id_Notificacion_Agua = :idNotificacion");
            $stmt->bindParam(":idNotificacion", $idNotificacion);
            $stmt->bindParam(":estadoReconectarTotal", $datos['estadoReconectarTotal']);
            // Ejecutar el UPDATE
            $stmt->execute();

            // Realizar el INSERT en la tabla notificacion_pago
            $queryInsert = "INSERT INTO notificacion_pago (monto, Fecha_Registro, numero_proveido, Id_Notificacion_Agua,Id_Notificacion_t_Pago ) 
                            VALUES (:monto, :Fecha_Registro, :numero_proveido, :Id_Notificacion_Agua, :idtipoPago )";
            $stmtInsert = $pdo->prepare($queryInsert);
            $stmtInsert->bindParam(":monto", $datos['totalAplicar']);
            $stmtInsert->bindParam(":Fecha_Registro", $fechaRegistro);
            $stmtInsert->bindParam(":numero_proveido", $datos['numeroProveido']);
            $stmtInsert->bindParam(":Id_Notificacion_Agua", $idNotificacion);
             $stmtInsert->bindParam(":idtipoPago", $datos['idtipoPago']);

            
            // Ejecutar el INSERT y verificar si se ejecutó correctamente
            if ($stmtInsert->execute()) {
                // Si la ejecución fue exitosa, devolver "ok"
                return "ok";
            } else {
                // Si la ejecución falló, devolver un mensaje de error
                throw new Exception("Error al insertar el registro en notificacion_pago.");
            }
        } else {
            throw new Exception("No se encontró el Id_Notificacion_Agua para la licencia proporcionada.");
        }
    } catch (Exception $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
    }
}





   

    // MOSTRAR PARA EDITAR NOTIFICACIONES
  
    public static function mdlMostrarIdNotificacion($idNotificacion) {
         
    try {
        // Preparar la consulta
        $query = "SELECT * FROM notificacion_agua WHERE Id_Notificacion_Agua = :idNotificacion";
        $stmt = Conexion::conectar()->prepare($query);

        // Vincular el parámetro
        $stmt->bindParam(":idNotificacion", $idNotificacion, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar el resultado
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Liberar el objeto statement
        $stmt = null;
    }
}

public static function mdlMostrarNotificacion($filtro_nombre = '', $filtro_fecha = '', $filtro_estado = '', $inicio = 0, $resultados_por_pagina = 10) {
    try {
        $query = "SELECT l.Id_Licencia_Agua, l.Id_Contribuyente , l.Lote, l.Luz, l.Nombres_Licencia, l.Id_Ubica_Vias_Urbano, na.Numero_Notificacion, t.Codigo as tipo_via,
                nv.Nombre_Via as nombre_calle, m.NumeroManzana as numManzana, cu.Numero_Cuadra as cuadra,
                z.Nombre_Zona as zona, h.Habilitacion_Urbana as habilitacion, u.Id_Ubica_Vias_Urbano as id,
                na.Fecha_Registro, na.fecha_corte, na.estado, na.Id_Notificacion_Agua
            FROM notificacion_agua na
            INNER JOIN licencia_agua l ON l.Id_Licencia_Agua = na.Id_Licencia_Agua
            INNER JOIN categoria_agua ca ON ca.Id_Categoria_Agua = l.Id_Categoria_Agua
            INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = l.Id_Ubica_Vias_Urbano
            INNER JOIN direccion d ON u.Id_Direccion = d.Id_Direccion
            INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via
            INNER JOIN zona z ON u.Id_Zona = z.Id_Zona
            INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana
            INNER JOIN cuadra cu ON cu.Id_cuadra = u.Id_Cuadra
            INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana
            INNER JOIN nombre_via nv ON nv.Id_Nombre_Via = d.Id_Nombre_Via
        ";

        // Filtrar por nombre
        if ($filtro_nombre != '') {
            $query .= " WHERE l.Nombres_Licencia LIKE :filtro_nombre";
        }

        // Filtrar por fecha si se proporciona
        if ($filtro_fecha != '') {
            $query .= ($filtro_nombre != '') ? " AND DATE(na.Fecha_Registro) = :filtro_fecha" : " WHERE DATE(na.Fecha_Registro) = :filtro_fecha";
        }

        // Filtrar por estado si se proporciona
        if ($filtro_estado != '' && $filtro_estado != 'todos') {
            $query .= ($filtro_nombre != '' || $filtro_fecha != '') ? " AND na.estado = :filtro_estado" : " WHERE na.estado = :filtro_estado";
        }

        $query .= " ORDER BY na.Fecha_Registro DESC"; 
          
        // Limitar los resultados según la paginación
        $query .= " LIMIT :inicio, :resultados_por_pagina";

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

        // Bindear parámetros
        if ($filtro_nombre != '') {
            $stmt->bindValue(':filtro_nombre', "%$filtro_nombre%", PDO::PARAM_STR);
        }
        if ($filtro_fecha != '') {
            $stmt->bindValue(':filtro_fecha', $filtro_fecha, PDO::PARAM_STR);
        }
        if ($filtro_estado != '' && $filtro_estado != 'todos') {
            $stmt->bindValue(':filtro_estado', $filtro_estado, PDO::PARAM_STR);
        }

        // Bindear los parámetros de paginación
        $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindValue(':resultados_por_pagina', $resultados_por_pagina, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar todos los resultados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $stmt = null;
    }
}


public static function mdlContarNotificaciones($filtro_nombre = '', $filtro_fecha = '', $filtro_estado = '') {
    try {
        $query = "SELECT COUNT(*) as total FROM notificacion_agua na
                INNER JOIN licencia_agua l ON l.Id_Licencia_Agua = na.Id_Licencia_Agua
                INNER JOIN categoria_agua ca ON ca.Id_Categoria_Agua = l.Id_Categoria_Agua
                INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = l.Id_Ubica_Vias_Urbano
                INNER JOIN direccion d ON u.Id_Direccion = d.Id_Direccion
                INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via
                INNER JOIN zona z ON u.Id_Zona = z.Id_Zona
                INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana
                INNER JOIN cuadra cu ON cu.Id_cuadra = u.Id_Cuadra
                INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana
                INNER JOIN nombre_via nv ON nv.Id_Nombre_Via = d.Id_Nombre_Via
        ";

        // Filtrar por nombre
        if ($filtro_nombre != '') {
            $query .= " WHERE l.Nombres_Licencia LIKE :filtro_nombre";
        }

        // Filtrar por fecha si se proporciona
        if ($filtro_fecha != '') {
            $query .= ($filtro_nombre != '') ? " AND DATE(na.Fecha_Registro) = :filtro_fecha" : " WHERE DATE(na.Fecha_Registro) = :filtro_fecha";
        }

        // Filtrar por estado si se proporciona
        if ($filtro_estado != '' && $filtro_estado != 'todos') {
            $query .= ($filtro_nombre != '' || $filtro_fecha != '') ? " AND na.estado = :filtro_estado" : " WHERE na.estado = :filtro_estado";
        }

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

        // Bindear parámetros
        if ($filtro_nombre != '') {
            $stmt->bindValue(':filtro_nombre', "%$filtro_nombre%", PDO::PARAM_STR);
        }
        if ($filtro_fecha != '') {
            $stmt->bindValue(':filtro_fecha', $filtro_fecha, PDO::PARAM_STR);
        }
        if ($filtro_estado != '' && $filtro_estado != 'todos') {
            $stmt->bindValue(':filtro_estado', $filtro_estado, PDO::PARAM_STR);
        }

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar el número total de registros
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $stmt = null;
    }
}





}