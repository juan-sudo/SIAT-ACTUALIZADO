<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;

class ModeloConstruccion
{
 public static function mdlNuevoContruccion($datos)
{
   $pdo1 = Conexion::conectar();
   
   try {

      $numero=1;
      
    $stmt1 = $pdo1->prepare("SELECT MAX(numero_construccion) AS max_construccion FROM construccion WHERE Id_Predio = :idPredio");
    $stmt1->bindParam(":idPredio", $datos['idPredio']);
    $stmt1->execute();
    $resultado = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($resultado && $resultado['max_construccion'] !== null) {
       

        $mayor=$resultado['max_construccion']+1;

       
      $stmt1 = $pdo1->prepare("INSERT INTO construccion(Nombre_Construccion, Observaciones, Id_Predio,numero_construccion) VALUES (:Nombre_Construccion, :Observaciones,:idPredio,:numero_construccion)");
      $stmt1->bindParam(":Nombre_Construccion", $datos['Nombre_Construccion']);
      $stmt1->bindParam(":Observaciones", $datos['Observaciones']);
      $stmt1->bindParam(":idPredio", $datos['idPredio']);
      $stmt1->bindParam(":numero_construccion",$mayor );

    } else {
      $stmt1 = $pdo1->prepare("INSERT INTO construccion(Nombre_Construccion, Observaciones, Id_Predio,numero_construccion) VALUES (:Nombre_Construccion, :Observaciones,:idPredio,:numero_construccion)");
      $stmt1->bindParam(":Nombre_Construccion", $datos['Nombre_Construccion']);
      $stmt1->bindParam(":Observaciones", $datos['Observaciones']);
      $stmt1->bindParam(":idPredio", $datos['idPredio']);
      $stmt1->bindParam(":numero_construccion", $numero);

    }

      if ($stmt1->execute()) {
         return "ok";
      } else {
         return "error";
      }

   } catch (Exception $e) {
      return "Error en BD al registrar piso: " . $e->getMessage();
   }
}


}


