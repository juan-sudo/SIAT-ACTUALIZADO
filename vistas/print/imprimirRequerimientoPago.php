<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');

use Controladores\ControladorConfiguracion;
use Modelos\ModeloEstadoCuenta;

class MYPDFC extends TCPDF {

    //Page header

    // Page footer
    public function Footer() {
        $configuracion = ControladorConfiguracion::ctrConfiguracion();
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->SetX(-5); // Ajusta el valor para mover el número de página a la derecha
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
        
        // Para agregar contenido en el centro
        $this->SetX(10); // Ajusta el valor para centrar tu contenido en el medio de la página
        $this->Cell(0, 10, $configuracion['Nombre_Empresa'] . " - Consulta: 966004730", 0, 0, 'C');

    }
}
$pdf = new MYPDFC(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

setlocale(LC_TIME, 'es_ES.UTF-8');

// Establecer la información del PDF
$pdf->SetCreator('TuNombre');
$pdf->SetAuthor('TuNombre');
$pdf->SetTitle('Mi PDF');
// Agregar una página
$pdf->AddPage();

$id_usuario=$_POST['id_usuario'];
$carpeta=$_POST['carpeta'];
$id_area=$_POST['id_area']; 
$id_cuenta=$_POST['id_cuenta']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor

$propietarios=$_POST['propietarios']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor

$numero_cuota_asig=$_POST['numeroCuota']; 
$anio_fiscal_asig=$_POST['anioFiscalg']; 
$fecha_venci_asig=$_POST['fechaVencimiento'];
$dias_asig=$_POST['plazodias'];
$periodo_asig=$_POST['periodo'];


//$estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuenta_pdf($propietarios,$id_cuenta,"null","null",'null');

$estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuenta_pdfcaI($propietarios,$id_cuenta,null,null,null);
$estado_cuentaA = ModeloEstadoCuenta::mdlEstadoCuenta_pdfcaA($propietarios,$id_cuenta,null,null,null);


$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios);

$configuracion = ControladorConfiguracion::ctrConfiguracion();



// Inicio de la tabla HTML
$html="<style>
th {
    font-size: 9px;
    font-family: Arial, sans-serif;
    font-weight: bold;
}
.totales{
    font-family: Arial, sans-serif;
    font-weight: bold;
    font-size: 9px;
}


td {
    font-size: 8px;
}
.mi-tabla thead {
    border-bottom: 3px solid black; /* Agrega una línea sólida debajo de la fila thead */
}
.espacio{
    margin-top:-10px;
    margin-bottom: 50px;
}
div{
    justify-content: center; /* Centra horizontalmente */
        align-items: center;
}


</style>";

$fechaActual = date('d/m/Y');
$anio_impresion = date('Y');
$dia_impresion = date('d');
//$mes_impresion = date('m');
$meses = array(
    "01" => "enero", "02" => "febrero", "03" => "marzo", "04" => "abril", "05" => "mayo", "06" => "junio",
    "07" => "julio", "08" => "agosto", "09" => "setiembre", "10" => "octubre", "11" => "noviembre", "12" => "diciembre"
);

$mes_impresion = date('m');  // Obtiene el mes en formato numérico (01-12)
$mes_nombre = $meses[$mes_impresion];  // Obtiene el nombre del mes co


$numeroPagina = $pdf->PageNo();

// Logo
$file = 'C:/xampp/htdocs/SIAT/vistas/img/logo/logou.jpg'; 
$imageData = base64_encode(file_get_contents($file));
$imgBase64 = 'data:image/jpeg;base64,' . $imageData;

$pdf->SetFont('helvetica', '', 8);
$pdf->SetX(40); 
$pdf->Image('logo.jpg', 15, 6, 22, 28, 'JPG', 'https://perudigitales.com/', '', true, 150, '', false, false, 0, false, false, false);
$html_head='<table align="left" >
                    <tr >
                       <th width="430"><h3>'.$configuracion['Nombre_Empresa'].'</h3></th>
                    </tr>
                    <tr>
                       <th width="380"><H4>GERENCIA DE ADMINISTRACION TRIBUTARIA</H4></th>
                       <th style="font-size:7px;">FECHA DE EMISION</th> 
                    </tr>

                    <tr>

                    <th width="380">SISTEMA DE RECAUDACIÓN MUNICIPAL</th>
                     <th  align="center" border="0.1">'.$fechaActual.'</th> 
                      
                    </tr>

                     <tr>
                     <th width="380"></th>
                     <th  align="center" style="background-color: #ffd439; " border="0.1"> &nbsp;Carpeta :'.$carpeta.'</th> 
                    
                    </tr>
                    
                   
                    
                    
             </table>';
$pdf->writeHTML($html_head);

$pdf->Image($file, 10, 5, 25, 25, 'JPG', '', '', true);

// Resolución
$pdf->MultiCell(0, 5, '', 0, 'C');

$pdf->SetX(40); 
$pdf->SetFont('helvetica', 'B', 14);  
$pdf->Cell(120, 0, 'REQUERIMIENTO DE PAGO N° 001-2025 GAT - MPLP', 0, 1, 'C');
//-------------------
$pdf->Ln(2);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 9);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, 'Puquio, ' . $dia_impresion .' de '.$mes_nombre.' del '.$anio_impresion.' ', 0, 1, 'L');

//---------------------

$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 9);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '1. Identificación del deudor tributario ', 0, 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 

$html_propietario='<table align="center">
                     <tr style="background-color:#e3eff3;">
                       <td border="0.1" width="40"><h4>Codigo</h4></td>
                       <td border="0.1" width="50"><h4>Dni</h4></td>
                       <td border="0.1" width="150"><h4>Propietario(s)</h4></td>
                       <td border="0.1" width="300"><h4>Direccion Fiscal</h4></td>
                     </tr>';
                     foreach ($propietarios as $valor => $filas) {
                        foreach ($filas as $fila) {
$html_propietario .='<tr>';
$html_propietario .='<td style=" border-left: 0.1px solid black; border-bottom: 0.1px solid black;" width="40">'.$fila['id_contribuyente'].'</td>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="50">'.$fila['documento'].'</th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="150">'.$fila['nombre_completo'].'</th>';
$html_propietario .='<th style=" border-right: 0.1px solid black; border-bottom: 0.1px solid black;" width="300">'. $fila['direccion_completo'] . '</th>';
$html_propietario .='</tr>';
                    }
                }
$html_propietario .='</table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');


//end propiertario
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(1); // Salto de línea
// Obtener la fecha actual
$textoLargo = "Estimado contribuyente:";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- ESTIMADO CONTRIBUEYNTE
//end propiertario
//------------------------------------------ PRIMER PARRAFO

$pdf->Ln(1); // Salto de línea
// Obtener la fecha actual
$textoLargo = 'La presente es para saludarlo cordialmente deseándole bienestar y salud para usted y su familia; asimismo, informarle que el día '.$fecha_venci_asig.' venció el plazo para el pago de la '.$numero_cuota_asig.' cuota del Impuesto Predial correspondiente al periodo '.$anio_fiscal_asig.'-'.$periodo_asig.', que asciende a S/. ' . $_POST['totalTotalI'] . '., por lo que se sugiere regularice su deuda dentro de un plazo de '.$dias_asig.' dias hábiles, contados desde la recepción del presente documento de cobranza, para así evitar acciones de cobranza posteriores. El detalle se indica a continuación:';

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos
$pdf->Ln(1); // Salto de línea
//----------------------------------------------- EN PRIMER PARRAFO


//----------------------------------TABLA IMPUESTO PREDIA------

$pdf->SetX(9); // Margen izquierdo
$textoLargo = "Impuesto predial";
$pdf->SetFont('helvetica', 'B', 9); // Tamaño de fuente más legible
$pdf->MultiCell(192, 6, $textoLargo, 0, 'L'); // Ancho ajustado a 192 mm

// Dibuja la línea separadora justo después del texto
$pdf->Line(9, $pdf->getY(), 200, $pdf->getY()); // Usamos el ancho 192 mm desde el margen izquierdo
$pdf->SetFont('helvetica', '', 7.5); // Cambiar el tamaño de la fuente



$html_estado = '<table align="center">
    <thead>
        <tr>
            <th ><b>Año</b></th>
            <th><b>Importe</b></th>
            <th><b>Gasto</b></th>
            <th><b>Subtotal</b></th>
            <th><b>Descuento</b></th>
            <th><b>T.I.M</b></th>
            <th><b>Total</b></th>
        </tr>
    </thead>
</table>';

$pdf->writeHTML($html_estado, true, false, false, false, '');

// Línea separadora después de la tabla de encabezado
$pdf->Line(9, $pdf->getY()-3, 8 + 192, $pdf->getY()-3); // Mismo ancho 192 mm

$pdf->setX(9);

// Tabla de datos
$html = '<table align="center" width="100%">';

$sin_descuento = 0; 
$tim = 0;        

foreach ($estado_cuenta as $row) {
    $html .= "<tr>";
    $html .= "<th>".$row['Anio']."</th>";
    $html .= "<th>".$row['Total_Importe']."</th>";
    $html .= "<th>".$row['Total_Gasto_Emision']."</th>";
    $html .= "<th>".$row['Total_Saldo']."</th>";
    $html .= "<th>".$row['Total_Descuento']."</th>"; // CAMBIO 1
    $html .= "<th>".$row['Total_TIM']."</th>";
    $html .= "<th>".$row['Total_Pagado']."</th>";
    $html .= "</tr>";
}

$html .= '</table>'; // Cerramos la tabla

// Escribir la tabla de datos en el PDF
$pdf->writeHTML($html, true, false, false, false, '');



// Dibuja la línea separadora justo después de la tabla de datos
$pdf->Line(8, $pdf->getY(), 8 + 192, $pdf->getY()); // Mismo ancho 192 mm



//----------------------------------END TABLA IMPUESTO PREDIA------



$pdf->Line(20, $pdf->getY(), 198, $pdf->getY());
$pdf -> Ln(1);
$pdf->SetX(8);



  // 🔹 Agregamos la tabla con la fila de totales (en una nueva tabla para evitar problemas de formato)
 $html_totales = '<table align="center" style=" " cellspacing="0" cellpadding="0" >'; // Sin bordes en la tabla general
  $html_totales .= '<tr>'; // Solo borde arriba
  $html_totales .= "<td><b>Total </b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalImporteI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalGastoI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalSubtotalI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totaldescuentoI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalTIMI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalTotalI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "</tr>";
  
  $html_totales .= '</table>';
  

$pdf->writeHTML($html_totales, true, false, false, false, '');


//PARA LA SUNFAA


// Variables para acumular los totales
$totalImportea = 0;
$totalGastoEmisiona = 0;
$totalSaldoa = 0;
$totalTIMDescuentoa = 0;
$totalTIMa = 0;
$totalPagadoa = 0;

// Sumamos los valores de $estado_cuenta
foreach ($estado_cuentaA as $row) {
    $totalImportea += $row['Total_Importe'];
    $totalGastoEmisiona += $row['Total_Gasto_Emision'];
    $totalSaldoa += $row['Total_Saldo'];
    $totalTIMDescuentoa += $row['Total_TIM_Descuento'];
    $totalTIMa += $row['Total_TIM'];
    $totalPagadoa += $row['Total_Pagado'];
}



//------------------------------------------------------------ARBITRIO MUNICIAPL---------


//linia

$pdf->SetDrawColor(0, 0, 0); // Color negro (RGB)
$pdf->SetLineWidth(0.2); // Grosor más delgado
$pdf->Line(105, $pdf->getY(), 200, $pdf->getY());

          
            $pdf->SetFont('helvetica', 'B', 6);  // Establecer el tamaño de letra a 8

           // $pdf->MultiCell(0, 1, '', 0, 'L');
            $totalFormateado = number_format($_POST['totalTotalI'], 2, '.', ',');

         $text = str_replace('  ', ' ', 'T O T A L   D E U D A'); 

         // Configurar fuente más grande
        $pdf->SetFont('Helvetica', 'B', 12); // Fuente en negrita y tamaño 14

      // Definir un margen derecho manualmente restando unos píxeles
        $margenDerecho = 25; // Ajusta este valor según tu necesidad
        $anchoPagina = $pdf->GetPageWidth(); // Obtiene el ancho de la página
        $anchoCelda = $anchoPagina - $margenDerecho; // Reduce el ancho para dejar margen

        $pdf->Cell($anchoCelda, 10, $text . ' S/. = ' . $totalFormateado, 0, 1, 'R');
            
          
         //PRIMER REGISTRO
$pdf->SetX(45); 
$pdf->SetFont('helvetica', '', 8);  // Establecer el tamaño de letra a 8




$pdf->Ln(2); // Salto de línea


//------------------------------------------ PRIMER PARRAFO

// Obtener la fecha actual
$textoLargo = "Nos permitimos recordarle que, para cualquier consulta adicional, puede dirigirse a nuestra Oficina de Ejecución Coactiva, la cual se encuentra disponible en los siguientes horarios de atención: de lunes a viernes, en la mañana de 8:00 AM a 1:00 PM y en la tarde de 3:00 PM a 6:00 PM. Asimismo, puede comunicarse con nosotros al teléfono 966 004 730/ 966 002 552 o, si lo prefiere, a través de WhatsApp al número 966 004 730.";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos



//---------------------------------------- ATENTAMENTE
$pdf->Ln(2); // Salto de línea


// Obtener la fecha actual
$textoLargo = "Atentamente";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos





// Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
//$ids = implode("-", $_POST['propietarios']);//CONVIERTE EN UN STRING
//$a=$propietarios;
// Ruta donde guardar el PDF (ajusta la ruta según tu proyecto)
$rutaPDF = 'pdfs/mi'.uniqid().'.pdf';

// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);

// Devolver la ruta del PDF guardado
echo $rutaPDF;
