<?php
namespace Modelos;
use Conect\Conexion;
use PDO;
use PDOException;
use Exception;
class ModeloAdministracionOrdenPago {

    //GUARDAR ENVIAR COACTIVO
 
    public static function mdlGuardarEditarEnviarCoactivo($numeroImforme, $estadoCoactivo, $idContribueyentes, $ordencompleta) {

    try {
        $pdo = Conexion::conectar();
        $estado = '1';
        $coactivo='1';
        $fecha_actual = date('Y-m-d');
        $arrayContribuyentes = array_map('intval', explode('-', $idContribueyentes));

        // PRIMERO: UPDATE en orden_pago_detalle
        $updateResult = true;
        $updateErrors = [];

        foreach($arrayContribuyentes as $contribuyenteId) {
            $queryUpdate = "UPDATE orden_pago_detalle
                           SET coactivo = :coactivo, numero_informe = :numero_informe
                           WHERE Concatenado_idc = :Concatenado_idc";

            $stmtUpdate = $pdo->prepare($queryUpdate);
            $stmtUpdate->bindParam(':coactivo', $estadoCoactivo, PDO::PARAM_STR);
            $stmtUpdate->bindParam(':numero_informe', $numeroImforme, PDO::PARAM_STR);
            $stmtUpdate->bindParam(':Concatenado_idc', $contribuyenteId, PDO::PARAM_INT);

            if (!$stmtUpdate->execute()) {
                $updateResult = false;
                $updateErrors[] = "Error UPDATE en contribuyente: " . $contribuyenteId;
            }
            $stmtUpdate = null;
        }

        // SEGUNDO: INSERT en coactivo
        $insertResult = false;
        $id_coactivo = null;

        $queryInsert = "INSERT INTO coactivo (estado, fecha_registro, numero_orden_pago)
                       VALUES (:estado, :fecha_registro, :numero_orden_pago)";

        $stmtInsert = $pdo->prepare($queryInsert);
        $stmtInsert->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmtInsert->bindParam(':fecha_registro', $fecha_actual, PDO::PARAM_STR);
        $stmtInsert->bindParam(':numero_orden_pago', $ordencompleta, PDO::PARAM_STR);

        if ($stmtInsert->execute()) {
            $insertResult = true;
            $id_coactivo = $pdo->lastInsertId();
        }
        $stmtInsert = null;

        // TERCERO: INSERT en detalle_coactivo
        $insertResult2 = true;
        $detailErrors = [];
        
        foreach($arrayContribuyentes as $numero) { 
            $queryInsert2 = "INSERT INTO detalle_coactivo (id_coactivo, id_contribuyente) 
                           VALUES (:id_coactivo, :id_contribuyente)";

            $stmtInsert2 = Conexion::conectar()->prepare($queryInsert2);
            $stmtInsert2->bindParam(':id_contribuyente', $numero, PDO::PARAM_INT);
            $stmtInsert2->bindParam(':id_coactivo', $id_coactivo, PDO::PARAM_INT);

            if (!$stmtInsert2->execute()) {
                $insertResult2 = false;
                $detailErrors[] = "Error INSERT detalle en contribuyente: " . $numero;
            }
            $stmtInsert2 = null;
        }

        //ACTUALIZAR CONTRIBUEYENTE
        //CUARTO: INSERT en detalle_coactivo
        $insertResult3 = true;
        $detailErrors1 = [];
        
        foreach($arrayContribuyentes as $numero) { 
            $queryInsert2 = "UPDATE contribuyente
                           SET Coactivo = :coactivo
                           WHERE Id_Contribuyente = :id_contribuyente";

            $stmtInsert2 = Conexion::conectar()->prepare($queryInsert2);
            $stmtInsert2->bindParam(':id_contribuyente', $numero, PDO::PARAM_INT);
            $stmtInsert2->bindParam(':coactivo', $coactivo, PDO::PARAM_STR);

            if (!$stmtInsert2->execute()) {
                $insertResult3 = false;
                $detailErrors1[] = "Error INSERT detalle en contribuyente: " . $numero;
            }
            $stmtInsert2 = null;
        }

        // VERIFICAR SI TODO SE HA INSERTADO
        if ($updateResult && $insertResult && $insertResult2 && $insertResult3 ) {
            return "ok";
        } else {
            // Construir mensaje de error detallado
            $errorMsg = "Error en: ";
            $errors = [];
            
            if (!$updateResult) {
                $errors[] = "UPDATE orden_pago_detalle - " . implode(", ", $updateErrors);
            }
            if (!$insertResult) {
                $errors[] = "INSERT coactivo";
            }
            if (!$insertResult2) {
                $errors[] = "INSERT detalle_coactivo - " . implode(", ", $detailErrors);
            }
            
            error_log("Errores en mdlGuardarEditarEnviarCoactivo: " . implode(" | ", $errors));
            return "error: " . implode(" | ", $errors);
        }

    } catch (Exception $e) {
        $errorMsg = "Excepción: " . $e->getMessage();
        error_log("Error en mdlGuardarEditarEnviarCoactivo: " . $errorMsg);
        return "error: " . $errorMsg;
    }
}

    //GUARDAR NOTIFICAICON DE ORDEN 
    public static function mdlGuardarEditarNotificacionFecha($idContribueyentes, $fechaNotificacion) {

    try {
        // Quitar los espacios en blanco antes y después de la cadena
      

        // Consulta SQL para actualizar los datos de expediente_coactivo y estado_coactivo
        $query = "UPDATE orden_pago_detalle
                  SET fecha_notificacion = :fecha_notificacion
                  WHERE Concatenado_idc =:Concatenado_idc";


        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

        $stmt->bindParam(':fecha_notificacion', $fechaNotificacion, PDO::PARAM_STR);
        
        $stmt->bindParam(':Concatenado_idc', $idContribueyentes, PDO::PARAM_STR);


        // Ejecutar la consulta
        if ($stmt->execute()) {
                return "ok";
        } else {
                return "error";
        }
                $stmt = null;

    } catch (Exception $e) {
            // Manejo de excepciones
            return "error";
    }
}



    public static function mdlGuardarEditar($idcoactivo, $expediente, $estado) {

    try {
        // Quitar los espacios en blanco antes y después de la cadena
      

        // Consulta SQL para actualizar los datos de expediente_coactivo y estado_coactivo
        $query = "UPDATE coactivo
                  SET expediente_coactivo = :expediente, estado_coactivo = :estado
                  WHERE id_coactivo =:idcoactivo";


        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

        $stmt->bindParam(':expediente', $expediente, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':idcoactivo', $idcoactivo, PDO::PARAM_INT);


        // Ejecutar la consulta
        if ($stmt->execute()) {
                return "ok";
        } else {
                return "error";
        }
                $stmt = null;

    } catch (Exception $e) {
            // Manejo de excepciones
            return "error";
    }
}



    //MOSTRAR PARA EDITAR
 public static function mdlMostrarEditar($idCoactivo) {
    try {
        // Consulta SQL utilizando IN para múltiples valores
        $query = "SELECT expediente_coactivo as expediente, estado_coactivo as estado
                  FROM coactivo
                  WHERE Id_Coactivo = :idcoactivo";  // Corregido el nombre del campo

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

        // Vincular el parámetro con el valor
        $stmt->bindParam(':idcoactivo', $idCoactivo, PDO::PARAM_INT); // Especifica el tipo correcto de parámetro

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar todos los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Liberar recursos, no es necesario asignar null aquí
        $stmt = null;
    } 
}

   //MOSTRAR PARA EDITAR
 public static function mdlMostrarEditarFechaNo($idContribueynte) {
    try {
        // Consulta SQL utilizando IN para múltiples valores
        $query = " SELECT * FROM `orden_pago_detalle` 
                  WHERE  Concatenado_idc=:idcontribueynte
                   GROUP BY Concatenado_idc
                
                  ";  // Corregido el nombre del campo

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

        // Vincular el parámetro con el valor
        $stmt->bindParam(':idcontribueynte', $idContribueynte, PDO::PARAM_STR); // Especifica el tipo correcto de parámetro

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar todos los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Liberar recursos, no es necesario asignar null aquí
        $stmt = null;
    } 
}

//VER ENVIAR A COACTIVO

   //MOSTRAR PARA EDITAR
 public static function mdlMostrarEditarEnviarCoactivo($idContribueynte) {
    try {
        // Consulta SQL utilizando IN para múltiples valores
        $query = " SELECT id,coactivo,numero_informe FROM `orden_pago_detalle` 
                  WHERE  Concatenado_idc=:idcontribueynte
                   GROUP BY Concatenado_idc
                
                  ";  // Corregido el nombre del campo

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

        // Vincular el parámetro con el valor
        $stmt->bindParam(':idcontribueynte', $idContribueynte, PDO::PARAM_STR); // Especifica el tipo correcto de parámetro

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar todos los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Liberar recursos, no es necesario asignar null aquí
        $stmt = null;
    } 
}







//NUEVO.. SUMAAAAA

public static function mdlTotalTimTotalCoactivo($idContribuyente) {
    try {
        // Quitar los espacios en blanco antes y después de la cadena
        $idContribuyente = str_replace(' ', '', $idContribuyente);

        // Verificar si $idContribuyente contiene varios valores separados por guiones
        if (strpos($idContribuyente, '-') !== false) {
            // Si contiene guiones, lo tratamos como una cadena simple
            $idContribuyente = str_replace('-', ',', $idContribuyente); // Cambiar los guiones por comas, si es necesario
        } elseif (strpos($idContribuyente, ',') !== false) {
            // Si contiene comas, lo tratamos como una lista de valores
            $idContribuyente = str_replace(',', '-', $idContribuyente); // Cambiar las comas por guiones
        } else {
            // Si es un solo valor, lo convertimos a entero para evitar inyecciones SQL
            $idContribuyente = intval($idContribuyente);
        }

      // var_dump($idContribuyente);

        // Consulta SQL utilizando IN para múltiples valores o un solo valor
        $query = "SELECT SUM(ord.TIM ), SUM(ord.Total)
                  FROM orden_pago ord 
                  INNER JOIN orden_pago_detalle pa ON ord.Orden_Pago = pa.id_orden_Pago 
                  WHERE pa.Concatenado_idc = :idContribueynete"; // Usamos '=' ya que ahora es un solo valor con guiones

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);
        $stmt->bindParam(':idContribueynete', $idContribuyente, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar todos los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Liberar recursos
        $stmt = null;
    } 
}



    //MODTRAR POR AÑOS EN MOSAL TYOTAL

public static function mdlMostrarAdministracionCoactivoTotalAnio($idContribuyente) {
    try {
        // Quitar los espacios en blanco antes y después de la cadena
        $idContribuyente = str_replace(' ', '', $idContribuyente);

        // Verificar si $idContribuyente contiene varios valores separados por guiones
        if (strpos($idContribuyente, '-') !== false) {
            // Si contiene guiones, lo tratamos como una cadena simple
            $idContribuyente = str_replace('-', ',', $idContribuyente); // Cambiar los guiones por comas, si es necesario
        } elseif (strpos($idContribuyente, ',') !== false) {
            // Si contiene comas, lo tratamos como una lista de valores
            $idContribuyente = str_replace(',', '-', $idContribuyente); // Cambiar las comas por guiones
        } else {
            // Si es un solo valor, lo convertimos a entero para evitar inyecciones SQL
            $idContribuyente = intval($idContribuyente);
        }

      // var_dump($idContribuyente);

        // Consulta SQL utilizando IN para múltiples valores o un solo valor
        $query = "SELECT ord.Anio, ord.TIM as TIM_Aplicar, ord.Total as Total_Aplicar
                  FROM orden_pago ord 
                  INNER JOIN orden_pago_detalle pa ON ord.Orden_Pago = pa.id_orden_Pago 
                  WHERE pa.Concatenado_idc = :idContribueynete"; // Usamos '=' ya que ahora es un solo valor con guiones

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);
        $stmt->bindParam(':idContribueynete', $idContribuyente, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar todos los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Liberar recursos
        $stmt = null;
    } 
}




public static function mdlMostrarAdministracionCoactivo($filtro_nombre ,$filtro_op, $filtro_ex, $inicio , $resultados_por_pagina) {
    try {
        // Imprimir valores de los parámetros para depuración
   
        $query = "SELECT 
                    CONCAT(LPAD(ord.Numero_Orden, 3, '0'), '-', de.anio_actual) as ordencompleta,
                    de.Concatenado_idc,
                    SUM(ord.Importe) AS importe,
                    SUM(ord.Gastos) AS gasto,
                    SUM(ord.Total) AS total,
                    SUM(ord.TIM) AS total_tim,
                    DATE(ord.Fecha_Registro) as Fecha_Registro,
                    de.fecha_notificacion,
                    de.coactivo

                    
                FROM orden_pago ord
                INNER JOIN orden_pago_detalle de ON de.id_orden_Pago = ord.Orden_Pago
                WHERE de.anio_actual = '2025'
                GROUP BY de.Concatenado_idc, ord.Numero_Orden, de.anio_actual
                ORDER BY ord.Numero_Orden
              
        ";


        // SELECT 
        //         c.Id_Ubica_Vias_Urbano as ubicacionvia,
        //          GROUP_CONCAT(DISTINCT c.estado_coactivo ORDER BY c.estado_coactivo) as estado_c,
        //             GROUP_CONCAT(DISTINCT c.Id_Contribuyente ORDER BY c.Id_Contribuyente) as id_contribuyente,
        //         GROUP_CONCAT(DISTINCT c.numero_orden_pago ORDER BY c.numero_orden_pago) as orden_pago,
        //         GROUP_CONCAT(DISTINCT c.expediente_coactivo ORDER BY c.expediente_coactivo) as expediente,

        //         GROUP_CONCAT(DISTINCT c.Nombre_Completo ORDER BY c.Nombre_Completo) as nombre_completo
               
        //     FROM propietario pro
        //     INNER JOIN predio p ON pro.Id_Predio = p.Id_Predio
        //     INNER JOIN contribuyente c ON pro.Id_Contribuyente = c.Id_Contribuyente
        //     INNER JOIN tipo_documento_siat td ON c.Id_Tipo_Documento = td.Id_Tipo_Documento
        //     WHERE pro.Baja=1 AND c.Coactivo=1 
        //     GROUP BY c.Id_Ubica_Vias_Urbano;
          //SELECT DISTINCT
        //         c.Id_Ubica_Vias_Urbano as ubicacionvia,
        //         c.Estado,
        //         c.Id_Contribuyente as id_contribuyente,
        //         td.descripcion as tipo_documento,
        //         c.Documento as documento, 
        //         CONCAT(c.Nombres, ' ', c.Apellido_Paterno, ' ', c.Apellido_Materno) AS nombre_completo,
        //         c.Direccion_completo as direccion_completo,
        //         c.Coactivo as coactivo,
        //         c.expediente_coactivo as expediente,
        //         c.estado_coactivo as estado_c,
        //         c.numero_orden_pago as orden_pago
        //     FROM propietario pro
        //     INNER JOIN predio p ON pro.Id_Predio = p.Id_Predio
        //     INNER JOIN contribuyente c ON pro.Id_Contribuyente = c.Id_Contribuyente
        //     INNER JOIN tipo_documento_siat td ON c.Id_Tipo_Documento = td.Id_Tipo_Documento
        //     WHERE pro.Baja=1 AND c.Coactivo=1

            // if ($filtro_nombre != '') {
            //     $query .= " AND CONCAT(c.Nombres, ' ', c.Apellido_Paterno, ' ', c.Apellido_Materno) LIKE :filtro_nombre";
            // }

            //  if ($filtro_op != '') {
             
            //     $query .= " AND CONCAT(c.numero_orden_pago) LIKE :filtro_op";
            // }

            
            //  if ($filtro_ex != '') {
             
            //     $query .= " AND CONCAT(c.expediente_coactivo) LIKE :filtro_ex";
            // }
         
         
         

            //   $query .= " ORDER BY pro.Fecha_Registro DESC"; 
          
        // Limitar los resultados según la paginación
      //  $query .= " LIMIT :inicio, :resultados_por_pagina";

        $stmt = Conexion::conectar()->prepare($query);
        
        // // PARAMETRO PARA FILTRO CON NOMBRE
        // if ($filtro_nombre != '') {
        //     $stmt->bindValue(':filtro_nombre', "%$filtro_nombre%", PDO::PARAM_STR);
        // }

        //  // PARAMETRO PARA FILTRO CON OP
        // if ($filtro_op != '') {
          
        //      $stmt->bindValue(':filtro_op', "%$filtro_op%", PDO::PARAM_STR);
        // }

        //  // PARAMETRO PARA FILTRO CON ex
        // if ($filtro_ex != '') {
          
        //      $stmt->bindValue(':filtro_ex', "%$filtro_ex%", PDO::PARAM_STR);
        // }
        

        //  // Bindear los parámetros de paginación
        // $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        // $stmt->bindValue(':resultados_por_pagina', $resultados_por_pagina, PDO::PARAM_INT);

       
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




// public static function mdlMostrarAdministracionCoactivo($filtro_nombre ,$filtro_op, $filtro_ex, $inicio , $resultados_por_pagina) {
//     try {
//         // Imprimir valores de los parámetros para depuración
   
//         $query = "SELECT DISTINCT
//                 c.Id_Ubica_Vias_Urbano as ubicacionvia,
//                 c.Estado,
//                 c.Id_Contribuyente as id_contribuyente,
//                 td.descripcion as tipo_documento,
//                 c.Documento as documento, 
//                 CONCAT(c.Nombres, ' ', c.Apellido_Paterno, ' ', c.Apellido_Materno) AS nombre_completo,
//                 c.Direccion_completo as direccion_completo,
//                 c.Coactivo as coactivo,
//                 c.expediente_coactivo as expediente,
//                 c.estado_coactivo as estado_c,
//                 c.numero_orden_pago as orden_pago
//             FROM propietario pro
//             INNER JOIN predio p ON pro.Id_Predio = p.Id_Predio
//             INNER JOIN contribuyente c ON pro.Id_Contribuyente = c.Id_Contribuyente
//             INNER JOIN tipo_documento_siat td ON c.Id_Tipo_Documento = td.Id_Tipo_Documento
//             WHERE pro.Baja=1 AND c.Coactivo=1

            
//         ";

//             if ($filtro_nombre != '') {
//                 $query .= " AND CONCAT(c.Nombres, ' ', c.Apellido_Paterno, ' ', c.Apellido_Materno) LIKE :filtro_nombre";
//             }

//              if ($filtro_op != '') {
             
//                 $query .= " AND CONCAT(c.numero_orden_pago) LIKE :filtro_op";
//             }

            
//              if ($filtro_ex != '') {
             
//                 $query .= " AND CONCAT(c.expediente_coactivo) LIKE :filtro_ex";
//             }
         
         
         

//               $query .= " ORDER BY pro.Fecha_Registro DESC"; 
          
//         // Limitar los resultados según la paginación
//         $query .= " LIMIT :inicio, :resultados_por_pagina";

//         $stmt = Conexion::conectar()->prepare($query);
        
//         // PARAMETRO PARA FILTRO CON NOMBRE
//         if ($filtro_nombre != '') {
//             $stmt->bindValue(':filtro_nombre', "%$filtro_nombre%", PDO::PARAM_STR);
//         }

//          // PARAMETRO PARA FILTRO CON OP
//         if ($filtro_op != '') {
          
//              $stmt->bindValue(':filtro_op', "%$filtro_op%", PDO::PARAM_STR);
//         }

//          // PARAMETRO PARA FILTRO CON ex
//         if ($filtro_ex != '') {
          
//              $stmt->bindValue(':filtro_ex', "%$filtro_ex%", PDO::PARAM_STR);
//         }
        

//          // Bindear los parámetros de paginación
//         $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
//         $stmt->bindValue(':resultados_por_pagina', $resultados_por_pagina, PDO::PARAM_INT);

       
//         $stmt->execute();

//         // Retornar todos los resultados
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);

//     } catch (PDOException $e) {
//         // Manejo de errores
//         echo "Error: " . $e->getMessage();
//         return null;
//     } finally {
//         $stmt = null;
//     }
// }




public static function mdlContarAdministracionCoactivo($filtro_nombre,$filtro_op, $filtro_ex ) {


    try {
        // Usar COUNT(*) para contar los registros
        $query = "SELECT COUNT(DISTINCT c.Id_Contribuyente) 
                  FROM propietario pro
                  INNER JOIN predio p ON pro.Id_Predio = p.Id_Predio
                  INNER JOIN contribuyente c ON pro.Id_Contribuyente = c.Id_Contribuyente
                  INNER JOIN tipo_documento_siat td ON c.Id_Tipo_Documento = td.Id_Tipo_Documento
                  WHERE pro.Baja=1 AND c.Coactivo=1";


        if ($filtro_nombre != '') {
                $query .= " AND CONCAT(c.Nombres, ' ', c.Apellido_Paterno, ' ', c.Apellido_Materno) LIKE :filtro_nombre";
            }

               if ($filtro_op != '') {
             
                $query .= " AND c.numero_orden_pago LIKE :filtro_op";
            }

            
             if ($filtro_ex != '') {
             
                $query .= " AND c.expediente_coactivo LIKE :filtro_ex";
            }
         
         

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

          // Bindear parámetros
        if ($filtro_nombre != '') {
            $stmt->bindValue(':filtro_nombre', "%$filtro_nombre%", PDO::PARAM_STR);
        }

         // PARAMETRO PARA FILTRO CON OP
        if ($filtro_op != '') {
          
             $stmt->bindValue(':filtro_op', "%$filtro_op%", PDO::PARAM_STR);
        }

         // PARAMETRO PARA FILTRO CON ex
        if ($filtro_ex != '') {
          
             $stmt->bindValue(':filtro_ex', "%$filtro_ex%", PDO::PARAM_STR);
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