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
        $query = "SELECT l.Id_Licencia_Agua, l.Lote, l.Luz, l.Nombres_Licencia, l.Id_Ubica_Vias_Urbano, na.Numero_Notificacion, t.Codigo as tipo_via,
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


    // MOSTRAR
    // public static function mdlMostrarNotificacion($filtro_nombre = '', $filtro_fecha = '', $filtro_estado = '') {
    //     try {
    //         $query = "SELECT l.Id_Licencia_Agua, l.Lote, l.Luz, l.Nombres_Licencia, l.Id_Ubica_Vias_Urbano, na.Numero_Notificacion, t.Codigo as tipo_via,
    //                 nv.Nombre_Via as nombre_calle, m.NumeroManzana as numManzana, cu.Numero_Cuadra as cuadra,
    //                 z.Nombre_Zona as zona, h.Habilitacion_Urbana as habilitacion, u.Id_Ubica_Vias_Urbano as id,
    //                 na.Fecha_Registro, na.fecha_corte, na.estado, na.Id_Notificacion_Agua
    //             FROM notificacion_agua na
    //             INNER JOIN licencia_agua l ON l.Id_Licencia_Agua = na.Id_Licencia_Agua
    //             INNER JOIN categoria_agua ca ON ca.Id_Categoria_Agua = l.Id_Categoria_Agua
    //             INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = l.Id_Ubica_Vias_Urbano
    //             INNER JOIN direccion d ON u.Id_Direccion = d.Id_Direccion
    //             INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via
    //             INNER JOIN zona z ON u.Id_Zona = z.Id_Zona
    //             INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana
    //             INNER JOIN cuadra cu ON cu.Id_cuadra = u.Id_Cuadra
    //             INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana
    //             INNER JOIN nombre_via nv ON nv.Id_Nombre_Via = d.Id_Nombre_Via
    //         ";

    //         // Filtrar por nombre
    //         if ($filtro_nombre != '') {
    //             $query .= " WHERE l.Nombres_Licencia LIKE :filtro_nombre";
    //         }

    //         // Filtrar por fecha si se proporciona
    //         if ($filtro_fecha != '') {
    //             $query .= ($filtro_nombre != '') ? " AND DATE(na.Fecha_Registro) = :filtro_fecha" : " WHERE DATE(na.Fecha_Registro) = :filtro_fecha";
    //         }

    //         // Filtrar por estado si se proporciona
    //         if ($filtro_estado != '' && $filtro_estado != 'todos') {
    //             $query .= ($filtro_nombre != '' || $filtro_fecha != '') ? " AND na.estado = :filtro_estado" : " WHERE na.estado = :filtro_estado";
    //         }

    //         // Preparar la consulta
    //         $stmt = Conexion::conectar()->prepare($query);

    //         // Bindear parámetros
    //         if ($filtro_nombre != '') {
    //             $stmt->bindValue(':filtro_nombre', "%$filtro_nombre%", PDO::PARAM_STR);
    //         }
    //         if ($filtro_fecha != '') {
    //             $stmt->bindValue(':filtro_fecha', $filtro_fecha, PDO::PARAM_STR);
    //         }
    //         if ($filtro_estado != '' && $filtro_estado != 'todos') {
    //             $stmt->bindValue(':filtro_estado', $filtro_estado, PDO::PARAM_STR);
    //         }

    //         // Ejecutar la consulta
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



}