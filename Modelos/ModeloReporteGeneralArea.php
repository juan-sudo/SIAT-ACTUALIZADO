<?php

namespace Modelos;
use Conect\Conexion;
use Exception;
use PDO;
use PDOException;

class ModeloReporteGeneralArea
{
	
    //total tribuitario
       public static function mdlMostrar_reporte_general_tributaria($fechaInicio, $fechaFin)
{
   
    try {
        $stmt = Conexion::conectar()->prepare("SELECT SUM(Total_Pagar) AS suma_total 
            FROM ingresos_tributos 
            WHERE Estado = 'P' 
              AND Cierre = 1 
              AND Fecha_Pago BETWEEN DATE(:fechaInicio) AND DATE(:fechaFin)
        ");

        // Vinculamos los parámetros
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);

        $stmt->execute();

        // Obtenemos los resultados
        $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

        return $resultado;
    } catch (PDOException $e) {
        // Captura de error opcional
        error_log("Error en mdlMostrar_reporte_general_tributaria: " . $e->getMessage());
        return [];
    }
}

   //total tribuitario

   public static function mdlMostrar_reporte_general_proveidos($fechaInicio, $fechaFin, $especieValorada, $idArea)
{
    try {
        // 🔹 1. Convertir la cadena en array y limpiar espacios
        $ids = array_map('trim', explode(',', $especieValorada));

        // 🔹 2. Generar placeholders dinámicos :id0, :id1, etc.
        $placeholders = implode(',', array_map(fn($i) => ":id{$i}", array_keys($ids)));

        // 🔹 3. Armar la consulta
        $sql = "
            SELECT 
                ie.Id_Especie_Valorada, 
                ev.Nombre_Especie,
                SUM(ie.Valor_Total) AS valor_total
            FROM ingresos_especies_valoradas ie
            INNER JOIN especie_valorada ev 
                ON ie.Id_Especie_Valorada = ev.Id_Especie_Valorada
            WHERE 
                ie.Estado = 'P'
                AND ie.Cierre = 1
                AND ev.Id_Area = :idArea
                AND ie.Id_Especie_Valorada IN ($placeholders)
                AND Fecha_Pago BETWEEN DATE(:fechaInicio) AND DATE(:fechaFin)
            GROUP BY ie.Id_Especie_Valorada, ev.Nombre_Especie
        ";

        $stmt = Conexion::conectar()->prepare($sql);

        // 🔹 4. Enlazar los parámetros normales
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);

        // 🔹 5. Enlazar cada ID por separado
        foreach ($ids as $i => $id) {
            $stmt->bindValue(":id{$i}", (int)$id, PDO::PARAM_INT);
        }

        // 🔹 6. Ejecutar y retornar
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultado;
    } catch (PDOException $e) {
        error_log("Error en mdlMostrar_reporte_general_proveidos: " . $e->getMessage());
        return [];
    }
}

//        public static function mdlMostrar_reporte_general_proveidos($fechaInicio, $fechaFin, $especieValorada,$idArea)
// {
 
//     var_dump($especieValorada);
//     var_dump($idArea);

   
//     try {
//         $stmt = Conexion::conectar()->prepare("SELECT ie.Id_Especie_Valorada, ev.Nombre_Especie,
//          SUM(ie.Valor_Total) as valor_total FROM ingresos_especies_valoradas ie 
//          INNER JOIN especie_valorada ev ON ie.Id_Especie_Valorada= ev.Id_Especie_Valorada
//           WHERE ie.Estado='P' AND ie.Cierre=1 AND ev.Id_Area=:idArea AND ie.Id_Especie_Valorada IN 
//           (:especieValorada) AND Fecha_Pago
//            BETWEEN DATE(:fechaInicio) AND DATE(:fechaFin) GROUP BY ie.Id_Especie_Valorada, 
//            ev.Nombre_Especie;
              
//         ");

//         // Vinculamos los parámetros
//         $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
//         $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
//            $stmt->bindParam(":especieValorada", $especieValorada, PDO::PARAM_STR);
//            $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);

//         $stmt->execute();

//         // Obtenemos los resultados
//         $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

//         return $resultado;
//     } catch (PDOException $e) {
//         // Captura de error opcional
//         error_log("Error en mdlMostrar_reporte_general_tributaria: " . $e->getMessage());
//         return [];
//     }
// }




//TOTAL DE AGUA

    //total tribuitario
       public static function mdlMostrar_reporte_general_agua($fechaInicio, $fechaFin)
{
   
    try {
        $stmt = Conexion::conectar()->prepare("SELECT  SUM(Total_Pagar) AS suma_total FROM ingresos_agua WHERE Estado='P' AND Cierre=1 AND Fecha_Pago BETWEEN  DATE(:fechaInicio) AND DATE(:fechaFin)
        ");

        // Vinculamos los parámetros
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);

        $stmt->execute();

        // Obtenemos los resultados
        $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

        return $resultado;
    } catch (PDOException $e) {
        // Captura de error opcional
        error_log("Error en mdlMostrar_reporte_general_tributaria: " . $e->getMessage());
        return [];
    }
}



     
}