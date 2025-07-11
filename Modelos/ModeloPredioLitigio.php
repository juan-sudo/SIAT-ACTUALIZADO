<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;
use PDOException;

class ModeloPredioLitigio
{


	public static function mdlEditarPredioLitigio($valor)
{
    $conexion = Conexion::conectar();

    // 1. Obtener el string "423,424"
    $idsString = $valor['ids'];

    // 2. Convertirlo en array
    $idsArray = explode(',', $idsString); // ['423', '424']

    // 3. Limpiar espacios (por si acaso)
    $idsArray = array_map('trim', $idsArray);

    // 4. Generar placeholders dinámicos (?, ?, ...)
    $placeholders = implode(',', array_fill(0, count($idsArray), '?'));

    // 5. Preparar consulta SQL con IN (...)
    $sql = "SELECT pl.*
        FROM predio p
        INNER JOIN predio_litigio pl ON p.Id_Predio = pl.Id_Predio
        INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio
        WHERE pro.Id_Contribuyente IN ($placeholders)
          AND pro.Baja = '1'
    ";

    $stmtObtener = $conexion->prepare($sql);

    // 6. Ejecutar pasando los valores del array
    $stmtObtener->execute($idsArray);

    // 7. Retornar los resultados
    return $stmtObtener->fetchAll(PDO::FETCH_ASSOC);
}


public static function mdlEliminarPredioLitigio($datos)
{ 
	
    try {
        $conexion = Conexion::conectar();

        // 1. Obtener el string "423,424"
        $idLitigio = $datos['id_predio_litigio'];

            // Eliminar el registro de predio_litigio usando Id_predio_litigio
            $stmtDelete = $conexion->prepare("DELETE FROM predio_litigio WHERE Id_predio_litigio = :id_predio_litigio");
            $stmtDelete->bindParam(":id_predio_litigio", $idLitigio, PDO::PARAM_INT);
            $stmtDelete->execute();

          

                // Verificar si la inserción fue exitosa
                if ($stmtDelete->rowCount() > 0) {
                    return 'ok'; // Todo salió bien
                } else {
                    return 'error'; // Error al insertar
                }
           
       

    } catch (PDOException $e) {
        // Capturar y devolver el mensaje de error si ocurre una excepción
        return 'error: ' . $e->getMessage(); // Mostrar el mensaje de error completo
    }
}



public static function mdlGuardarPredioLitigio($datos)
{ 
	
    try {
        $conexion = Conexion::conectar();

        // 1. Obtener el string "423,424"
        $idsString = $datos['ids'];

        // 2. Convertirlo en array
        $idsArray = explode(',', $idsString); // ['423', '424']

        // 3. Limpiar espacios (por si acaso)
        $idsArray = array_map('trim', $idsArray);

        // 4. Generar placeholders dinámicos (?, ?, ...)
        $placeholders = implode(',', array_fill(0, count($idsArray), '?'));

        // Asignar NULL a los valores vacíos o no definidos
        $id_usuario = isset($datos['id_usuario']) && !empty($datos['id_usuario']) ? $datos['id_usuario'] : null;
        $id_predio = isset($datos['id_predio']) && !empty($datos['id_predio']) ? $datos['id_predio'] : null;
        $observacion = isset($datos['observacion']) && !empty($datos['observacion']) ? $datos['observacion'] : null;

        // Verificar si el predio ya existe en la tabla predio_litigio
        $stmtCheck = $conexion->prepare("SELECT pl.*
                                         FROM predio p
                                         INNER JOIN predio_litigio pl ON p.Id_Predio = pl.Id_Predio
                                         INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio
                                         WHERE pro.Id_Contribuyente IN ($placeholders)
                                         AND pro.Baja = '1'");

        // Ejecutar pasando los valores del array de IDs
        $stmtCheck->execute($idsArray);

        // Obtener el resultado
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        // Depuración: Verificar si hay resultados
        if ($result) {
            // Si el predio ya existe, eliminar el registro
            $idPredioLitigio = $result['Id_predio_litigio']; // Asegúrate de que 'Id_predio_litigio' sea el nombre correcto de la columna
            
            // Eliminar el registro de predio_litigio usando Id_predio_litigio
            $stmtDelete = $conexion->prepare("DELETE FROM predio_litigio WHERE Id_predio_litigio = :id_predio_litigio");
            $stmtDelete->bindParam(":id_predio_litigio", $idPredioLitigio, PDO::PARAM_INT);
            $stmtDelete->execute();

            // Verificar si la eliminación fue exitosa
            if ($stmtDelete->rowCount() > 0) {


                // Proceder con la inserción después de eliminar
                $stmtInsert = $conexion->prepare("INSERT INTO predio_litigio (Observaciones, Id_Predio, Id_Usuario) 
                                                  VALUES (:observacion, :id_predio, :id_usuario)");
                $stmtInsert->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
                $stmtInsert->bindParam(":id_predio", $id_predio, PDO::PARAM_INT);
                $stmtInsert->bindParam(":observacion", $observacion, PDO::PARAM_STR);




                $stmtInsert->execute();

                // Verificar si la inserción fue exitosa
                if ($stmtInsert->rowCount() > 0) {
                    return 'ok'; // Todo salió bien
                } else {
                    return 'error'; // Error al insertar
                }
            } else {
                return 'error'; // Error al eliminar
            }
        } else {
           $stmtInsert = $conexion->prepare("INSERT INTO predio_litigio (Observaciones, Id_Predio, Id_Usuario) 
                                                  VALUES (:observacion, :id_predio, :id_usuario)");
                $stmtInsert->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
                $stmtInsert->bindParam(":id_predio", $id_predio, PDO::PARAM_INT);
                $stmtInsert->bindParam(":observacion", $observacion, PDO::PARAM_STR);
                $stmtInsert->execute();

                // Verificar si la inserción fue exitosa
                if ($stmtInsert->rowCount() > 0) {
                    return 'ok'; // Todo salió bien
                } else {
                    return 'error'; // Error al insertar
                }
        }

    } catch (PDOException $e) {
        // Capturar y devolver el mensaje de error si ocurre una excepción
        return 'error: ' . $e->getMessage(); // Mostrar el mensaje de error completo
    }
}


	public static function mdlListarPredioLitigio($valor, $anio_actual)
	{
		$pdo = Conexion::conectar();
		//$anio_actual = implode(',', $anio);

		// Preparar la consulta SQL
		if (count($valor) === 1) {
			$id = $valor[0];
			$query = "SELECT 
						p.predio_UR as tipo_ru, 
						p.Direccion_completo as direccion_completo,
						IF(p.predio_UR = 'U', ca.Codigo_Catastral, car.Codigo_Catastral) as catastro,
						p.Id_Predio as id_predio,
						p.Area_Terreno as a_terreno,
						p.Area_Construccion as a_construccion,
						p.Valor_Predio_Aplicar as v_predio_aplicar,
						 pl.Id_predio_litigio,
                        pl.Observaciones
					FROM 
						predio p 
						LEFT JOIN catastro ca ON p.predio_UR = 'U' AND ca.Id_Catastro = p.Id_Catastro 
						LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
						INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
						INNER JOIN anio an ON an.Id_Anio = p.Id_Anio 
						LEFT JOIN predio_litigio pl ON pl.Id_Predio=p.Id_Predio
					WHERE 
						pro.Id_Contribuyente = :id AND an.NomAnio =:anio
						AND p.ID_Predio NOT IN (
							SELECT ID_Predio 
							FROM Propietario 
							WHERE ID_Contribuyente <> :id AND Baja='1'
						)and pro.Baja='1';";
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":anio", $anio_actual);
		} else {
			$ids = implode(",", $valor);
			$count = count($valor);
			$query = "SELECT
			p.predio_UR as tipo_ru, 
						p.Direccion_completo as direccion_completo,
						IF(p.predio_UR = 'U', ca.Codigo_Catastral, car.Codigo_Catastral) as catastro,
						p.Id_Predio as id_predio,
						p.Area_Terreno as a_terreno,
						p.Area_Construccion as a_construccion,
						p.Valor_Predio_Aplicar as v_predio_aplicar,
						 pl.Id_predio_litigio,
                        pl.Observaciones
		  FROM 
			predio p 
			LEFT JOIN catastro ca ON p.predio_UR = 'U' AND ca.Id_Catastro = p.Id_Catastro 
            LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
			INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
			INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
			LEFT JOIN predio_litigio pl ON pl.Id_Predio=p.Id_Predio
			WHERE pro.Id_Contribuyente IN ($ids) and an.NomAnio=:anio  AND pro.Baja='1' 
			GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor) . " ORDER BY p.predio_UR";
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(":anio", $anio_actual);
		}
		// Ejecutar la consulta
		$stmt->execute();
		$campos = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$total_predios=0;

		// Generar el contenido HTML
		$content = '';
		if (count($campos) > 0) {
			foreach ($campos as $key => $value) {
				$content .= self::generateRowHTMLL($value, $key + 1,$anio_actual);
				$total_predios++;
			}
			$content .= sprintf(
				'<tr>
					<td colspan="6" style="background-color:#ffffff" class="text-start">
						<span class="caption_" style="padding-left:1rem;">
							<i class="bi bi-house-door-fill"></i> Total de Predios: %d
						</span>
					</td>
				</tr>',
				$total_predios
			);
		} else {
			$content .= "<td colspan='10' style='text-align:center;'>No hay Registro de Predio(s) en el año <b>" . $anio_actual . "</b></td>";
		}

		$pdo = null;
		return $content;
	}


	private static function generateRowHTMLL($value, $key, $anio_actual)
{
	return sprintf(
		'<tr id_predio="%s" id_catastro="%s" id_tipo="%s" id="fila" data-id_predio="%s">
			<td class="text-center">
				<input type="radio" 
					   class="radio-predio" 
					   name="predio_seleccionado" 
					   value="%s" 
					   data-id_predio="%s" 
					   data-onstyle="success" 
					   data-offstyle="danger" 
					   data-size="mini" 
					   data-width="110">
			</td>
			
			<td class="text-center" style="display:none;">%d</td>
			<td class="text-center">%s</td>
			<td>%s</td>
			<td class="text-center" style="display:none;">%s</td>
			<td class="text-center">%s</td>
			<td class="text-center">%s</td>
			<td class="text-center">%s</td>
			<td class="text-center"><i class="bi bi-trash-fill icono-eliminar-litigio"  data-id_predioL_eliminar="%s"></i></i></td>
			<td class="text-center" style="display:none;">%s</td> 
		</tr>',
		$value['id_predio'],
		$value['catastro'],
		$value['tipo_ru'],
		$value['id_predio'],
		$value['id_predio'],      // value para el input
		$value['id_predio'],      // data-id_predio
		$key,
		$value['tipo_ru'],
		$value['direccion_completo'],
		$value['catastro'],
		$value['a_terreno'],
		$value['a_construccion'],
		$value['v_predio_aplicar'],
		 $value['Id_predio_litigio'],
		$anio_actual
	);
}


}