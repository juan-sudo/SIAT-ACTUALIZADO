<?php

namespace Modelos;
use Conect\Conexion;
use Exception;
use PDO;

class ModeloReporteActualizacion
{
 public static function mdlMostrar_actualizacion_carpeta($id , $estado)
    {
        try {

            if($id == " " && $estado == " "){
                 // Creamos la conexión
            $conn = Conexion::conectar();

            // Comenzamos con la consulta base sin filtros
            $sql = "SELECT 
                        ca.Codigo_Carpeta, 
                        ca.Estado_progreso, 
                        pr.completado_oficina,
                        pr.completado_campo,
                        pr.fecha_registro AS fecha_act,  
                        ca.Fecha_Registro AS fecha_re,
                        us.usuario 
                    FROM carpeta ca
                    LEFT JOIN progreso pr ON ca.Id_Carpeta = pr.Id_Carpeta
                    LEFT JOIN usuarios us ON pr.id_usuario = us.id";

          

            // Preparamos la sentencia
            $stmt = $conn->prepare($sql);

          
            // Ejecutamos la consulta
            $stmt->execute();

            // Obtenemos los resultados
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Verificar si la consulta devolvió resultados
            if (empty($result)) {
                echo "No se encontraron resultados.<br>";
            }

            // Cerramos la conexión
            $stmt = null;

            return $result;



            }else if($id !== " " && $estado !== " "){
                 // Creamos la conexión
            $conn = Conexion::conectar();

            // Comenzamos con la consulta base sin filtros
            $sql = "SELECT 
                        ca.Codigo_Carpeta, 
                        ca.Estado_progreso, 
                        pr.completado_oficina,
                        pr.completado_campo,
                        pr.fecha_registro AS fecha_act,  
                        ca.Fecha_Registro AS fecha_re,
                        us.usuario 
                    FROM carpeta ca
                    LEFT JOIN progreso pr ON ca.Id_Carpeta = pr.Id_Carpeta
                    LEFT JOIN usuarios us ON pr.id_usuario = us.id";

            // Creamos una variable para almacenar las condiciones
            $conditions = [];

            // Limpiar el valor de $estado, eliminando espacios en blanco al principio y final
            $estado = trim($estado);

            // Agregar filtros solo si los parámetros no están vacíos
            if ($id !== '') {
                $conditions[] = "pr.id_usuario = :id_usuario";
            }
            if ($estado !== '') {
                $conditions[] = "ca.Estado_progreso = :progreso";
            }

            // Si hay condiciones, agregamos WHERE al SQL
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            // Preparamos la sentencia
            $stmt = $conn->prepare($sql);

            // Bind los parámetros solo si no están vacíos
            if ($id !== '') {
                $stmt->bindValue(':id_usuario', $id, PDO::PARAM_INT);
            }
            if ($estado !== '') {
                $stmt->bindParam(":progreso", $estado, PDO::PARAM_STR);
            }

            // Ejecutamos la consulta
            $stmt->execute();

            // Obtenemos los resultados
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Verificar si la consulta devolvió resultados
            if (empty($result)) {
                echo "No se encontraron resultados.<br>";
            }

            // Cerramos la conexión
            $stmt = null;

            return $result;

            }
            else if($estado !== " "){
                 // Creamos la conexión
            $conn = Conexion::conectar();

            // Comenzamos con la consulta base sin filtros
            $sql = "SELECT 
                        ca.Codigo_Carpeta, 
                        ca.Estado_progreso, 
                        pr.completado_oficina,
                        pr.completado_campo,
                        pr.fecha_registro AS fecha_act,  
                        ca.Fecha_Registro AS fecha_re,
                        us.usuario 
                    FROM carpeta ca
                    LEFT JOIN progreso pr ON ca.Id_Carpeta = pr.Id_Carpeta
                    LEFT JOIN usuarios us ON pr.id_usuario = us.id";

            // Creamos una variable para almacenar las condiciones
            $conditions = [];

            // Limpiar el valor de $estado, eliminando espacios en blanco al principio y final
            $estado = trim($estado);

          
            if ($estado !== '') {
                $conditions[] = "ca.Estado_progreso = :progreso";
            }

            // Si hay condiciones, agregamos WHERE al SQL
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            // Preparamos la sentencia
            $stmt = $conn->prepare($sql);

          
            if ($estado !== '') {
                $stmt->bindParam(":progreso", $estado, PDO::PARAM_STR);
            }

            // Ejecutamos la consulta
            $stmt->execute();

            // Obtenemos los resultados
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Verificar si la consulta devolvió resultados
            if (empty($result)) {
                echo "No se encontraron resultados.<br>";
            }

            // Cerramos la conexión
            $stmt = null;

            return $result;

            }
            else if($id !== " "){
                 // Creamos la conexión
            $conn = Conexion::conectar();

            // Comenzamos con la consulta base sin filtros
            $sql = "SELECT 
                        ca.Codigo_Carpeta, 
                        ca.Estado_progreso, 
                        pr.completado_oficina,
                        pr.completado_campo,
                        pr.fecha_registro AS fecha_act,  
                        ca.Fecha_Registro AS fecha_re,
                        us.usuario 
                    FROM carpeta ca
                    LEFT JOIN progreso pr ON ca.Id_Carpeta = pr.Id_Carpeta
                    LEFT JOIN usuarios us ON pr.id_usuario = us.id";

            // Creamos una variable para almacenar las condiciones
            $conditions = [];

            // Limpiar el valor de $estado, eliminando espacios en blanco al principio y final
            $estado = trim($estado);

            // Agregar filtros solo si los parámetros no están vacíos
            if ($id !== '') {
                $conditions[] = "pr.id_usuario = :id_usuario";
            }
          

            // Si hay condiciones, agregamos WHERE al SQL
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            // Preparamos la sentencia
            $stmt = $conn->prepare($sql);

            // Bind los parámetros solo si no están vacíos
            if ($id !== '') {
                $stmt->bindValue(':id_usuario', $id, PDO::PARAM_INT);
            }
          

            // Ejecutamos la consulta
            $stmt->execute();

            // Obtenemos los resultados
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Verificar si la consulta devolvió resultados
            if (empty($result)) {
                echo "No se encontraron resultados.<br>";
            }

            // Cerramos la conexión
            $stmt = null;

            return $result;

            }
           
        } catch (Exception $e) {
            // Manejo de excepciones
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

// public static function mdlMostrar_actualizacion_carpeta($id, $estado)
//     {
       
//         // Creamos la consulta SQL correctamente
//         $stmt = Conexion::conectar()->prepare("SELECT 
//                         ca.Codigo_Carpeta, 
//                         ca.Estado_progreso, 
//                         pr.completado_oficina,
//                         pr.completado_campo,
//                         pr.fecha_registro AS fecha_act,  
//                         ca.Fecha_Registro AS fecha_re,
//                         us.usuario 
//                     FROM carpeta ca
//                     LEFT JOIN progreso pr ON ca.Id_Carpeta = pr.Id_Carpeta
//                     LEFT JOIN usuarios us ON pr.id_usuario = us.id
//                     WHERE pr.id_usuario = :id_usuario AND ca.Estado_progreso = :progreso"); 

//         // Bind del parámetro
//         $stmt->bindParam(":id_usuario", $id, PDO::PARAM_INT);
//         $stmt->bindParam(":progreso", $estado, PDO::PARAM_STR);

//         // Ejecutamos la consulta
//         $stmt->execute();

//         // Obtenemos los resultados
//         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         // Cerramos la conexión
//         $stmt = null;

//         return $result;
//     }
    
}
