<?php
namespace Modelos;
use Conect\Conexion;
use PDO;
use PDOException;

class ModeloAdministracionCoactivo {



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


//   public static function mdlMostrarAdministracionCoactivoTotalAnio($idContribuyente) {
//     try {
//         // Consulta SQL con el parámetro dinámico
//         $query = "SELECT Anio, SUM(Total_Aplicar), SUM(TIM_Aplicar) 
//                   FROM estado_cuenta_corriente
//                   WHERE Concatenado_idc = :idContribuyente
//                   GROUP BY Anio";

//         // Preparar la consulta
//         $stmt = Conexion::conectar()->prepare($query);

//         // Asignar el valor del parámetro
//         $stmt->bindParam(':idContribuyente', $idContribuyente, PDO::PARAM_STR);

//         // Ejecutar la consulta
//         $stmt->execute();

//         // Retornar todos los resultados como un array asociativo
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     } catch (PDOException $e) {
//         // Manejo de errores
//         echo "Error: " . $e->getMessage();
//         return null;
//     } finally {
//         // Liberar recursos
//         $stmt = null;
//     }
// }


public static function mdlMostrarAdministracionCoactivo($filtro_nombre = '', $filtro_fecha = '', $filtro_estado = '', $inicio = 0, $resultados_por_pagina = 10) {
    try {
        $query = "SELECT DISTINCT
                c.Id_Ubica_Vias_Urbano as ubicacionvia,
                c.Estado,
                c.Id_Contribuyente as id_contribuyente,
                td.descripcion as tipo_documento,
                c.Documento as documento, 
                CONCAT(c.Nombres, ' ', c.Apellido_Paterno, ' ', c.Apellido_Materno) AS nombre_completo,
                c.Direccion_completo as direccion_completo,
                c.Coactivo as coactivo
            FROM propietario pro
            INNER JOIN predio p ON pro.Id_Predio = p.Id_Predio
            INNER JOIN contribuyente c ON pro.Id_Contribuyente = c.Id_Contribuyente
            INNER JOIN tipo_documento_siat td ON c.Id_Tipo_Documento = td.Id_Tipo_Documento
            WHERE pro.Baja=1 AND c.Coactivo=1
          
      
        ";

       
        $stmt = Conexion::conectar()->prepare($query);

      
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


public static function mdlContarAdministracionCoactivo($filtro_nombre = '', $filtro_fecha = '', $filtro_estado = '') {
    try {
        $query = "SELECT COUNT(*) as total  FROM propietario pro
            INNER JOIN predio p ON pro.Id_Predio = p.Id_Predio
            INNER JOIN contribuyente c ON pro.Id_Contribuyente = c.Id_Contribuyente
            INNER JOIN tipo_documento_siat td ON c.Id_Tipo_Documento = td.Id_Tipo_Documento
            WHERE pro.Baja=1 AND c.Coactivo=1
            ORDER BY p.Direccion_completo
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