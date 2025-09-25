<?php
namespace Modelos;
use Conect\Conexion;
use PDO;
use PDOException;
use Exception;
class ModeloAdministracionCoactivo {


    public static function mdlGuardarEditar($idContribuyente, $expediente, $estado) {

    try {
        // Quitar los espacios en blanco antes y después de la cadena
        $idContribuyente = str_replace(' ', '', $idContribuyente);

        // Verificar si $idContribuyente contiene varios valores separados por comas
        if (strpos($idContribuyente, ',') !== false) {
            // Si contiene comas, limpiamos y preparamos el valor para la cláusula IN
            $idContribuyente = implode(',', array_map('intval', explode(',', $idContribuyente)));
        } else {
            // Si es un solo valor, lo convertimos a entero para evitar inyecciones SQL
            $idContribuyente = intval($idContribuyente);
        }

        // Consulta SQL para actualizar los datos de expediente_coactivo y estado_coactivo
        $query = "UPDATE contribuyente
                  SET expediente_coactivo = :expediente, estado_coactivo = :estado
                  WHERE Id_Contribuyente IN ($idContribuyente)";

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

        // Vincular los parámetros para evitar inyecciones SQL
        $stmt->bindParam(':expediente', $expediente, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);

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
    public static function mdlMostrarEditar($idContribuyente) {
    try {
        // Quitar los espacios en blanco antes y después de la cadena
        $idContribuyente = str_replace(' ', '', $idContribuyente);

        // Verificar si $idContribuyente contiene varios valores separados por comas
        if (strpos($idContribuyente, ',') !== false) {
            // Si contiene comas, limpiamos y preparamos el valor para la cláusula IN
            $idContribuyente = implode(',', array_map('intval', explode(',', $idContribuyente)));
        } else {
            // Si es un solo valor, lo convertimos a entero para evitar inyecciones SQL
            $idContribuyente = intval($idContribuyente);
        }

        // Consulta SQL utilizando IN para múltiples valores
        $query = "SELECT expediente_coactivo as expediente, estado_coactivo as estado
                  FROM contribuyente
                  WHERE Id_Contribuyente IN ($idContribuyente)";

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

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




 public static function mdlTotalTimTotalCoactivo($idContribuyente) {
    try {
        // Quitar los espacios en blanco antes y después de la cadena
        $idContribuyente = str_replace(' ', '', $idContribuyente);

        // Verificar si $idContribuyente contiene varios valores separados por comas
        if (strpos($idContribuyente, ',') !== false) {
            // Si contiene comas, limpiamos y preparamos el valor para la cláusula IN
            $idContribuyente = implode(',', array_map('intval', explode(',', $idContribuyente)));
        } else {
            // Si es un solo valor, lo convertimos a entero para evitar inyecciones SQL
            $idContribuyente = intval($idContribuyente);
        }

        // Consulta SQL utilizando IN para múltiples valores
        $query = "SELECT SUM(Total_Aplicar), SUM(TIM_Aplicar) 
                  FROM estado_cuenta_corriente
                  WHERE Concatenado_idc IN ($idContribuyente)  AND Tipo_tributo='006'";

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

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

    public static function mdlMostrarAdministracionCoactivoTotalAnio($idContribuyente) {
    try {
        // Quitar los espacios en blanco antes y después de la cadena
        $idContribuyente = str_replace(' ', '', $idContribuyente);

        // Verificar si $idContribuyente contiene varios valores separados por comas
        if (strpos($idContribuyente, ',') !== false) {
            // Si contiene comas, limpiamos y preparamos el valor para la cláusula IN
            $idContribuyente = implode(',', array_map('intval', explode(',', $idContribuyente)));
        } else {
            // Si es un solo valor, lo convertimos a entero para evitar inyecciones SQL
            $idContribuyente = intval($idContribuyente);
        }

        // Consulta SQL utilizando IN para múltiples valores
        $query = "SELECT Anio, SUM(Total_Aplicar), SUM(TIM_Aplicar) 
                  FROM estado_cuenta_corriente
                  WHERE Concatenado_idc IN ($idContribuyente)  AND Tipo_tributo='006'
                  GROUP BY Anio";

        // Preparar la consulta
        $stmt = Conexion::conectar()->prepare($query);

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
   
        $query = "SELECT DISTINCT
                c.Id_Ubica_Vias_Urbano as ubicacionvia,
                c.Estado,
                c.Id_Contribuyente as id_contribuyente,
                td.descripcion as tipo_documento,
                c.Documento as documento, 
                CONCAT(c.Nombres, ' ', c.Apellido_Paterno, ' ', c.Apellido_Materno) AS nombre_completo,
                c.Direccion_completo as direccion_completo,
                c.Coactivo as coactivo,
                c.expediente_coactivo as expediente,
                c.estado_coactivo as estado_c,
                c.numero_orden_pago as orden_pago
            FROM propietario pro
            INNER JOIN predio p ON pro.Id_Predio = p.Id_Predio
            INNER JOIN contribuyente c ON pro.Id_Contribuyente = c.Id_Contribuyente
            INNER JOIN tipo_documento_siat td ON c.Id_Tipo_Documento = td.Id_Tipo_Documento
            WHERE pro.Baja=1 AND c.Coactivo=1

            
        ";

            if ($filtro_nombre != '') {
                $query .= " AND CONCAT(c.Nombres, ' ', c.Apellido_Paterno, ' ', c.Apellido_Materno) LIKE :filtro_nombre";
            }

             if ($filtro_op != '') {
             
                $query .= " AND CONCAT(c.numero_orden_pago) LIKE :filtro_op";
            }

            
             if ($filtro_ex != '') {
             
                $query .= " AND CONCAT(c.expediente_coactivo) LIKE :filtro_ex";
            }
         
         
         

              $query .= " ORDER BY pro.Fecha_Registro DESC"; 
          
        // Limitar los resultados según la paginación
        $query .= " LIMIT :inicio, :resultados_por_pagina";

        $stmt = Conexion::conectar()->prepare($query);
        
        // PARAMETRO PARA FILTRO CON NOMBRE
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
        

         // Bindear los parámetros de paginación
        $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindValue(':resultados_por_pagina', $resultados_por_pagina, PDO::PARAM_INT);

       
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