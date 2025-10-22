<?php

namespace Modelos;

use Conect\Conexion;
use PDO;
use Exception;

class ModeloCalculoEstadoAgua
{
    public static function mdlCalculoEstadoAgua($anioBase, $anioCalcular)
    {
        try {
            $PDO = Conexion::conectar();
            $PDO->beginTransaction();

           // ANIO BASE
            $sqlContribuyentes = "
                SELECT NomAnio
                FROM anio
                WHERE Id_Anio = :anioBase
            ";

            $stmtContrib = $PDO->prepare($sqlContribuyentes);
            $stmtContrib->bindParam(':anioBase', $anioBase, PDO::PARAM_INT);
            $stmtContrib->execute();

            // Capturamos el resultado
            $resultado1 = $stmtContrib->fetch(PDO::FETCH_ASSOC);

            if ($resultado1) {
                $nomAnioBase = $resultado1['NomAnio']; // 👈 Aquí capturas NomAnio
            } else {
                $nomAnioBase = null; // En caso de que no se encuentre el año
            }


            //ANIO CALCULAR
              $sqlContribuyentes1 = "
                SELECT NomAnio
                FROM anio
                WHERE Id_Anio = :anioBase
            ";

            $stmtContrib = $PDO->prepare($sqlContribuyentes1);
            $stmtContrib->bindParam(':anioBase', $anioCalcular, PDO::PARAM_INT);
            $stmtContrib->execute();

            // Capturamos el resultado
            $resultado2 = $stmtContrib->fetch(PDO::FETCH_ASSOC);

            if ($resultado2) {
                $nomAnioCal = $resultado2['NomAnio']; // 👈 Aquí capturas NomAnio
            } else {
                $nomAnioCal = null; // En caso de que no se encuentre el año
            }




            //ANIO A CALCULAR

            // 1️⃣ Buscar todos los contribuyentes con los 12 periodos del año base
            $sqlContribuyentes = "SELECT Id_Contribuyente
                FROM estado_cuenta_agua
                WHERE Anio = :anioBase
                GROUP BY Id_Contribuyente
                HAVING COUNT(*) = 12
            ";
            $stmtContrib = $PDO->prepare($sqlContribuyentes);
            $stmtContrib->bindParam(':anioBase', $nomAnioBase, PDO::PARAM_INT);
            $stmtContrib->execute();

            $totalContribuyentes = 0;
            $totalInsertados = 0;
            $contribuyentesInsertados = []; // 👈 Nuevo arreglo para registrar los IDs insertados

            while ($rowContrib = $stmtContrib->fetch(PDO::FETCH_ASSOC)) {
                $idContribuyente = $rowContrib['Id_Contribuyente'];
                $totalContribuyentes++;

                // 2️⃣ Verificar que no existan registros del año nuevo (evita duplicar)
                $sqlExiste = "SELECT COUNT(*) FROM estado_cuenta_agua
                    WHERE Id_Contribuyente = :idContrib AND Anio = :anioNuevo
                ";
                $stmtExiste = $PDO->prepare($sqlExiste);
                $stmtExiste->bindParam(':idContrib', $idContribuyente, PDO::PARAM_INT);
                $stmtExiste->bindParam(':anioNuevo', $nomAnioCal, PDO::PARAM_INT);
                $stmtExiste->execute();
                $yaExiste = $stmtExiste->fetchColumn();

                if ($yaExiste > 0) {
                    continue; // Ya tiene registros del nuevo año
                }

                // 3️⃣ Obtener los registros base (año base)
                $sqlGet = "SELECT * FROM estado_cuenta_agua 
                    WHERE Id_Contribuyente = :idContrib AND Anio = :anioBase
                    ORDER BY Periodo ASC
                ";
                $stmtGet = $PDO->prepare($sqlGet);
                $stmtGet->bindParam(':idContrib', $idContribuyente, PDO::PARAM_INT);
                $stmtGet->bindParam(':anioBase', $nomAnioBase, PDO::PARAM_INT);
                $stmtGet->execute();

                // 4️⃣ Insertar nuevos registros para el año calculado
                $sqlInsert = "INSERT INTO estado_cuenta_agua 
                    (Tipo_Tributo, Numero_Recibo, Anio, Periodo, Importe, Gasto_Emision, Saldo, Total, Estado, 
                     Fecha_Registro, Fecha_Vencimiento, User_Pago, Fecha_pago, Id_Usuario, Fecha_ReCalculo, 
                     Id_Contribuyente, Id_Descuento, Descuento, Total_Aplicar, DNI, Nombres, 
                     Id_Licencia_Agua, Estado_notificacion)
                    VALUES (:Tipo_Tributo, :Numero_Recibo, :Anio, :Periodo, :Importe, :Gasto_Emision, :Saldo, :Total, 
                            :Estado, NOW(), :Fecha_Vencimiento, :User_Pago, :Fecha_pago, :Id_Usuario, 
                            :Fecha_ReCalculo, :Id_Contribuyente, :Id_Descuento, :Descuento, :Total_Aplicar, 
                            :DNI, :Nombres, :Id_Licencia_Agua, :Estado_notificacion)
                ";
                $stmtInsert = $PDO->prepare($sqlInsert);

                $insertado = false; // bandera para saber si este contribuyente tuvo inserciones

                while ($rowBase = $stmtGet->fetch(PDO::FETCH_ASSOC)) {
                    $estadoNuevo = 'D'; // Forzar estado a 'D'
                    $numeroRecibo = null;
                    $fechaVencimiento = null;
                    $userPago = null;
                    $idUsuario = null;
                    $fechaRecalculo = date('Y-m-d H:i:s'); // ✅ formato compatible con DATETIME
                    $estadoNotificacion = null;

                    $stmtInsert->bindParam(':Tipo_Tributo', $rowBase['Tipo_Tributo']);
                    $stmtInsert->bindParam(':Numero_Recibo', $numeroRecibo);
                    $stmtInsert->bindParam(':Anio', $nomAnioCal);
                    $stmtInsert->bindParam(':Periodo', $rowBase['Periodo']);
                    $stmtInsert->bindParam(':Importe', $rowBase['Importe']);
                    $stmtInsert->bindParam(':Gasto_Emision', $rowBase['Gasto_Emision']);
                    $stmtInsert->bindParam(':Saldo', $rowBase['Saldo']);
                    $stmtInsert->bindParam(':Total', $rowBase['Total']);
                    $stmtInsert->bindParam(':Estado', $estadoNuevo);
                    $stmtInsert->bindParam(':Fecha_Vencimiento', $fechaVencimiento);
                    $stmtInsert->bindParam(':User_Pago', $userPago);
                    $stmtInsert->bindParam(':Fecha_pago', $rowBase['Fecha_pago']);
                    $stmtInsert->bindParam(':Id_Usuario', $idUsuario);
                    $stmtInsert->bindParam(':Fecha_ReCalculo', $fechaRecalculo);
                    $stmtInsert->bindParam(':Id_Contribuyente', $rowBase['Id_Contribuyente']);
                    $stmtInsert->bindParam(':Id_Descuento', $rowBase['Id_Descuento']);
                    $stmtInsert->bindParam(':Descuento', $rowBase['Descuento']);
                    $stmtInsert->bindParam(':Total_Aplicar', $rowBase['Total_Aplicar']);
                    $stmtInsert->bindParam(':DNI', $rowBase['DNI']);
                    $stmtInsert->bindParam(':Nombres', $rowBase['Nombres']);
                    $stmtInsert->bindParam(':Id_Licencia_Agua', $rowBase['Id_Licencia_Agua']);
                    $stmtInsert->bindParam(':Estado_notificacion', $estadoNotificacion);
                    $stmtInsert->execute();

                    $insertado = true;
                    $totalInsertados++;
                }

                // Si tuvo inserciones, agregarlo a la lista
                if ($insertado) {
                    $contribuyentesInsertados[] = $idContribuyente;
                }
            }

            $PDO->commit();

            return [
                "status" => "ok",
                "mensaje" => "Proceso completado correctamente",
                "contribuyentes_procesados" => $totalContribuyentes,
                "contribuyentes_insertados" => count($contribuyentesInsertados),
                "registros_insertados" => $totalInsertados,
                "lista_contribuyentes_insertados" => $contribuyentesInsertados
            ];

        } catch (Exception $e) {
            if ($PDO->inTransaction()) {
                $PDO->rollBack();
            }
            return [
                "status" => "error",
                "mensaje" => "Error en el cálculo automático: " . $e->getMessage()
            ];
        }
    }
}
