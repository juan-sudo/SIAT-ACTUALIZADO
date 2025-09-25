<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');

use Controladores\ControladorConfiguracion;
use Modelos\ModeloEstadoCuenta;

class MYPDFC extends TCPDF {

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

$numero_resolucion_1_asig=$_POST['numeroResolucion1']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$numero_solicitud_asig=$_POST['numeroSolictud']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$fecha_fraccionado_asig=$_POST['fechaFraccionamiento']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$fecha_aprobacion_asig=$_POST['fechaAprobacion']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$numero_resolucion_2_asig=$_POST['numeroResolcion2']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$detallePerdida = json_decode($_POST['detallePerdida']);  // Obtener datos de la solicitud
$totalFraccionado=$_POST['totalFraccionado']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor


$propietarios=$_POST['propietarios']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor

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
$pdf->Cell(120, 0, 'RESOLUCION DE PERDIDA DE FRACCIONAMIENTO N° 005-2025 GAT - MPLP', 0, 1, 'C');

//------------------------------------------ PRIMER PARRAFO

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = 'VISTA, la Resolución N° '.$numero_resolucion_1_asig.' que aprobó la solicitud N°'.$numero_solicitud_asig.' de fecha '.$fecha_fraccionado_asig.', presentada por los contribuyentes, sobre fraccionamiento de deudas tributarias;';   

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos






$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', '', 6.5);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '1. IDENTIFICACION DE DEUDOR TRIBUTARIO ', 0, 1, 'L');


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



//-----------------------------------------------SEGUNDO PARRAFO
$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "CONSIDERANDO; ";   

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos



//-----------------------------------------------TERCER PARRAFO
$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = 'Que al verificar el cumplimiento de las obligaciones vinculadas al otorgamiento del fraccionemiento,se ha constatado que el deudor ha incurrido en causal de pérdida según lo establecido en Base legal, aprobada por, en la '.$fecha_aprobacion_asig.' ';   

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos



//end propiertario
//------------------------------------------ CUARTO PARRAFO

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "De conformidad con lo dispuesto en la Ley N° 26979, ";   

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//------------------------------------------ QUINTO PARRAFO

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "SE RESUELVE:";   

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//------------------------------------------ SEXTO PARRAFO

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = 'ARTÍCULO PRIMERO: Declarar la pérdida del fraccionamiento de deudas tributarias otorgado a ';

// Aquí generamos el nombre del contribuyente y lo añadimos al texto
$nombresContribuyentes = []; // Crear un arreglo para los nombres
foreach ($propietarios as $valor => $filas) {
    foreach ($filas as $fila) {
        $nombresContribuyentes[] = $fila['nombre_completo']; // Agregar nombre completo del contribuyente
    }
}

// Concatenar los nombres con coma y "y" antes del último nombre
if (count($nombresContribuyentes) > 1) {
    $textoLargo .= implode(', ', array_slice($nombresContribuyentes, 0, -1)) . ' y ' . end($nombresContribuyentes);
} else {
    $textoLargo .= $nombresContribuyentes[0]; // Si hay solo un contribuyente, usar directamente el nombre
}

$textoLargo .= ' mediante Resolución N° '.$numero_resolucion_2_asig.' ; téngase por vencidos los plazos, cuotas pendientes de pago y genérense los intereses moratorios correspondientes.';   

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//------------------------------------------ SETIMO PARRAFO

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "ARTICULO SEGUNDO: Prosígase con la cobranza de la deuda correspondiente al total de cada una de las deudas tributarias que conforman el fraccionamiento pendientes de pago, después de la imputación efectuada de las cuotas del fraccionamiento pagadas y ejecútense la(s) garantías que se haya(n) otorgado.  ";   

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos


$pdf->Ln(4); // Salto de línea

//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', '', 6.5);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '2. DETALLE(S) QUE OCASIONA(N) LA PERDIDA AL '.$fechaActual.'', 0, 1, 'L');


$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 

$html_propietario = '<table align="center" cellpadding="5" cellspacing="0" style="border: 1px solid black;">';
$html_propietario .= '<tr style="background-color:#e3eff3;">';
$html_propietario .= '<td style="border: 0.1px solid black; width: 25%"><h4>N° Cuota</h4></td>';
$html_propietario .= '<td style="border: 0.1px solid black; width: 25%"><h4>Documento de cuota</h4></td>';
$html_propietario .= '<td style="border: 0.1px solid black; width: 25%"><h4>Feha vencimiento</h4></td>';
$html_propietario .= '<td style="border: 0.1px solid black; width: 25%"><h4>Monto total</h4></td>';

$html_propietario .= '</tr>';

// Recorrer el detallePerdida y agregar una fila por cada entrada
foreach ($detallePerdida as $item) {
    $html_propietario .= '<tr>';
    $html_propietario .= '<td style="border: 0.1px solid black; border-left: 0.1px solid black; border-bottom: 0.1px solid black; width: 25%">' . $item->numeroCuota . '</td>';
    $html_propietario .= '<td style="border: 0.1px solid black; border-bottom: 0.1px solid black; width: 25%">' . $item->documentoDeuda . '</td>';
    $html_propietario .= '<td style="border: 0.1px solid black; border-bottom: 0.1px solid black; width: 25%">' . $item->fechaVencimiento . '</td>';
    $html_propietario .= '<td style="border: 0.1px solid black; border-bottom: 0.1px solid black; width: 25%">' . $item->montoTotal . '</td>';
    $html_propietario .= '</tr>';
}


$html_propietario .= '</table>';



$pdf->writeHTML($html_propietario, true, false, false, false, '');


//end propiertario

//---------------------END TABLA DE LIQUIDACION


//------------------------------------------ PRIMER PARRAFO

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "Regístrese, notifíquese al administrado y remítase copia al área correspondiente para sus efectos.";   

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//-----------------------------------------------SEGUNDO PARRAFO


// Obtener la fecha actual
$textoLargo = "El presente acto tiene vigencia desde el día de su notificación. Contra el mismo puede interponerse recurso de reclamación dentro del plazo de veinte(20) día hábiles contados desde el día siguiente de su notificación.";   

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos






//end propiertario



//------------------------------------------ PRIMER PARRAFO


//----------------------------------------------- EN PRIMER PARRAFO

$pdf->Ln(50); // Salto de línea


// Luego de escribir, puedes dejar un poco de espacio si quieres
// 👇 Espacio estimado necesario para tabla + constancia
$espacioNecesario = 10; // Ajusta si es necesario

// Si no hay espacio suficiente, pasa a la siguiente página
if ($pdf->GetY() + $espacioNecesario > $pdf->getPageHeight() - 15) {
    $pdf->AddPage();
    $pdf->SetY(20);
   
    
}

// Escribir la tabla
$pdf->SetX(9);
$fechaActual = date('d/m/Y');
$numeroPagina = $pdf->PageNo();

$pdf->SetFont('helvetica', '', 7);
$html_head ='<table cellpadding="2" >

                    <tr>
                       <th colspan="8" style="text-transform: lowercase;"> <strong>Oficinas de atencion:</strong> '.$configuracion['Nombre_Empresa'].'</th>
                       <th colspan="2"></th>
                    </tr>
                      <tr>
                       <th colspan="8"> <strong>Ubicado:</strong> Jr. Ayacucho N° 136 </th>
                       <th colspan="2"><strong>TOTAL (s/.)</strong></th>
                       
                    </tr>

                    <tr>
                       <th colspan="8"> <strong>Para mayor información:</strong>'.'Oficina de ejecucion coactiva celular 966004730 / 966002552'.'</th>
                        <th width="70" border="0.5" style="text-align: center; font-size:11px; "> <b>'.$totalFraccionado.'</b></th>
                  
                    </tr>
                   
                 
             </table>';
$pdf->writeHTML($html_head);


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
