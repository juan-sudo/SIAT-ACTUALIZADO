<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');

use Controladores\ControladorConfiguracion;
use Modelos\ModeloEstadoCuenta;
//------------------------------------------ANEXO 15
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



//MONTO EN LETRAS
function numeroALetras($numero) {
    $unidad = array('', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE', 'DIEZ', 
                    'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISÉIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE', 'VEINTE');
    $decena = array('', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA');
    $centena = array('', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS');

    $numero = number_format($numero, 2, '.', '');
    list($entero, $decimal) = explode('.', $numero);

    if ($entero == 0) {
        $texto = 'CERO';
    } else {
        $texto = convertirNumero($entero, $unidad, $decena, $centena);
    }

    return trim($texto . ' CON ' . $decimal . '/100 SOLES');
}

function convertirNumero($num, $unidad, $decena, $centena) {
    if ($num < 21) {
        return $unidad[$num];
    } elseif ($num < 100) {
        $d = intval($num / 10);
        $u = $num % 10;
        if ($u == 0) return $decena[$d];
        return $decena[$d] . ' Y ' . $unidad[$u];
    } elseif ($num < 1000) {
        $c = intval($num / 100);
        $r = $num % 100;
        if ($num == 100) return 'CIEN';
        return trim($centena[$c] . ' ' . convertirNumero($r, $unidad, $decena, $centena));
    } elseif ($num < 1000000) {
        $m = intval($num / 1000);
        $r = $num % 1000;
        if ($m == 1) $texto = 'MIL';
        else $texto = convertirNumero($m, $unidad, $decena, $centena) . ' MIL';
        return trim($texto . ' ' . convertirNumero($r, $unidad, $decena, $centena));
    } elseif ($num < 1000000000) {
        $m = intval($num / 1000000);
        $r = $num % 1000000;
        if ($m == 1) $texto = 'UN MILLÓN';
        else $texto = convertirNumero($m, $unidad, $decena, $centena) . ' MILLONES';
        return trim($texto . ' ' . convertirNumero($r, $unidad, $decena, $centena));
    }
    return '';
}


//ASIGNARDOS
$expediente_asig=strtoupper($_POST['expediente']);
$numero_expediente_asig=strtoupper($_POST['numeroExpediente']);
$numero_rodaje_asig=strtoupper($_POST['numeroPlaca']);

$monto_asig=$_POST['totalTotal']; //2000.12
$monto_letras_asig = numeroALetras($monto_asig);



$monto_formateado = number_format($monto_asig, 2, '.', ',');

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
$html_head='<table align="left" cellpadding="1"  >
                    <tr >
                       <th width="430"><h3>'.$configuracion['Nombre_Empresa'].'</h3></th>
                    </tr>
                    <tr>
                       <th width="380"><H4>GERENCIA DE ADMINISTRACION TRIBUTARIA</H4></th>
                       <th style="font-size:7px;"></th> 
                    </tr>

                    <tr>

                    <th width="320">SISTEMA DE RECAUDACIÓN MUNICIPAL</th>
                     <th width="140"  align="left" border="0.1">Expediente: '.$numero_expediente_asig.' , ACUM</th> 
                      
                    </tr>

                    <tr>
                     <th width="320"></th>
                       <th width="140"  align="left" border="0.1">Auxiliar: David Eugenio Jalixto Huasco</th> 
                      
                    </tr>
                    
                      <tr>
                     <th width="320"></th>
                       <th width="140"  align="left" border="0.1">CC:  </th> 
                      
                    </tr>
                   
                    
                    
             </table>';
$pdf->writeHTML($html_head);

$pdf->Image($file, 10, 5, 25, 25, 'JPG', '', '', true);

// Resolución
$pdf->MultiCell(0, 5, '', 0, 'C');

$pdf->SetX(40); 
$pdf->SetFont('helvetica', 'B', 12);  
$pdf->Cell(120, 0, 'CÉDULA DE NOTIFICACIÓN N° 001-2025 GAT - MPLP', 0, 1, 'C');


//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(2);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 8);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, 'Puquio, ' . $dia_impresion .' de '.$mes_nombre.' del '.$anio_impresion.' ', 0, 1, 'L');




//------------------------------------------ ESTIMADO CONTRIBUEYNTE
$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '1. IDENTIFICACION DE DEUDOR TRIBUTARIO ', 0, 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 

$html_propietario='<table align="center" cellpadding="1" >
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
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

//end propiertario
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "El Ejecutor Coactivo de la Municipalidadde Provincial Lucanas Puquio, Abogado Dr. Hector Alberto Huarcaya Cotaquispe, ha resuelto lo siguiente:";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- ESTIMADO CONTRIBUEYNTE
$pdf->Ln(2); // Salto de línea
$pdf->SetDrawColor(0, 0, 0); // Color negro (RGB)
$pdf->SetLineWidth(0.3); // Grosor más delgado
$pdf->Line(9, $pdf->getY(), 200, $pdf->getY());

//end propiertario
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

//----------------------------------------------- ESTIMADO CONTRIBUEYNTE
//end propiertario
$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "RESOLUCION NUMERO DOS:";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', 'B', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//--------------------

//end propiertario
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(1); // Salto de línea
// Obtener la fecha actual
$textoLargo = 'En puquio, a los '.$dia_impresion.' dias del '.$mes_nombre.' del '.$anio_impresion.'';

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- ESTIMADO CONTRIBUEYNTE
//end propiertario


//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(1); // Salto de línea
// Obtener la fecha actual
$textoLargo = 'VISTOS: Los actuados en el presente Procedimiento, estando a lo que expresa; y CONSIDERANDO: Primero.- Que, la persona, objeto y naturaleza de los expedientes '.$expediente_asig.' son los mismos, por lo que procede su acumulación; Segundo.- Que de la verificación en el Sistema de Recaudación Municipal, se evidencia que el obligado ';

$nombresContribuyentes1 = [];

foreach ($propietarios as $valor => $filas) {
    foreach ($filas as $fila) {
        // Combinar nombre completo con su DNI
        $nombresContribuyentes1[] = $fila['nombre_completo'] . ' (DNI N° ' . $fila['documento'] . ')';
    }
}

// Concatenar nombres con coma y "y" antes del último
if (count($nombresContribuyentes1) > 1) {
    $textoLargo .= implode(', ', array_slice($nombresContribuyentes1, 0, -1))
        . ' y ' . end($nombresContribuyentes1);
} else {
    $textoLargo .= $nombresContribuyentes1[0];
}

$textoLargo.=', registra a la fecha deuda en cobranza coactiva, por lo que es necesario asegurar el cumplimiento de dicha obligación tributaria, en consecuencia debe procederse con trabarse las medidas cautelares que sean necesarias. Tercero.- Que el Ejecutor Coactivo en cualquier estado del procedimiento podrá trabar y/o variar la Medida Cautelar correspondiente, a fin de garantizar la deuda Tributaria materia del presente procedimiento; y de conformidad con lo dispuesto en <los artículos 3º, 20º, 32º y 33º de la Ley N° 26979 – Ley de Procedimiento de Ejecución Coactiva, modificada por la Ley Nº 28165 y la Ley Nº 28892>;';

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- ESTIMADO CONTRIBUEYNTE
//end propiertario
//end propiertario
$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "SE RESUELVE:";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', 'B', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//--------------------

$pdf->Ln(1); // Salto de línea
// Obtener la fecha actual

$textoLargo = 'PRIMERO.-';

$textoLargo .='ACUMULAR los expedientes señalados en el considerando primero del presente mandato, entendiéndose en adelante como uno solo bajo el expediente Nº '.$numero_expediente_asig.'-ACUM;

SEGUNDO.- TRABAR LA MEDIDA CAUTELAR DE EMBARGO DEFINITIVO EN FORMA DE RETENCIÓN, hasta por la suma de S/. '.$monto_formateado.' ('.$monto_letras_asig.'),';



$textoLargo.=' respecto al vehículo de placa de rodaje número N° '.$numero_rodaje_asig.', correspondiente al obligado ';
$nombresContribuyentes2 = [];

foreach ($propietarios as $valor => $filas) {
    foreach ($filas as $fila) {
        // Combinar nombre completo con su DNI
        $nombresContribuyentes2[] = $fila['nombre_completo'] . ' (DNI N° ' . $fila['documento'] . ')';
    }
}

// Concatenar nombres con coma y "y" antes del último
if (count($nombresContribuyentes2) > 1) {
    $textoLargo .= implode(', ', array_slice($nombresContribuyentes2, 0, -1))
        . ' y ' . end($nombresContribuyentes2);
} else {
    $textoLargo .= $nombresContribuyentes2[0];
}


$textoLargo .= "\n";
$textoLargo .= "\n";

$textoLargo.='TERCERO.- REQUERIR al obligado';

// Crear un arreglo para los nombres con DNI
$nombresContribuyentes = [];

foreach ($propietarios as $valor => $filas) {
    foreach ($filas as $fila) {
        // Combinar nombre completo con su DNI
        $nombresContribuyentes[] = $fila['nombre_completo'] . ' (DNI N° ' . $fila['documento'] . ')';
    }
}

// Concatenar nombres con coma y "y" antes del último
if (count($nombresContribuyentes) > 1) {
    $textoLargo .= implode(', ', array_slice($nombresContribuyentes, 0, -1))
        . ' y ' . end($nombresContribuyentes);
} else {
    $textoLargo .= $nombresContribuyentes[0];
}



$textoLargo.=', para que inmediatamente luego de notificada la presente, CUMPLA con CANCELAR y/o FRACCIONAR la obligación tributaria materia del presente procedimiento de ejecución coactiva; bajo apercibimiento de proceder a la Ejecución Forzada de las Medidas Cautelares de Embargo trabadas, conforme a ley; notificándose. F Firmado. Dr. Hector Alberto Huarcaya Cotaquispe, Ejecutor Coactivo; David Eugenio Jalixto Huasco, Auxiliar Coactivo. Lo que notifico a usted conforme a ley.';

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- EN PRIMER PARRAFO


$pdf->Ln(40); // Salto de línea


// Escribir la tabla
$pdf->SetX(9);
$fechaActual = date('d/m/Y');
//$numeroPagina = $pdf->PageNo();

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
                        <th width="70" border="0.5" style="text-align: center; font-size:11px; "> <b>'.$monto_formateado.'</b></th>
                  
                    </tr>
                   
                 
             </table>';
$pdf->writeHTML($html_head);


///---------------------------------


$sector_2='<table align="left">
                     <tr>
                       <th colspan="2"><b>3. BASE LEGAL:</b>
                       </th> 
                     </tr>
                     <tr>
                       <th align="left">&nbsp;&nbsp;-Art. 70 de la ley órganica de la Municipalidad N° 27972<br>
                           -Art. 8° al 20° Ley de Tribatación Municipal. N° 776 <br>
                           -Art. 78° inc. 1 D.S. 133-2013-EF TUO del Código Tributario
                       </th> 
                       <th align="left">&nbsp;&nbsp;-TUO de la Ley 26979 de Procedimiento de Ejecución Coactiva<br>
                           -Plazo para presentar recursos de reclamación: 03 días hábiles <br>
                           (desde el día siguiente de notificación la presente)
                       </th>
                     </tr>
                   
             </table>';
$pdf->writeHTML($sector_2, true, false, false, false, '');

$sector_2='<table align="left">
                     <tr>
                       <th colspan="2" align="center"><b>CONSTANCIA DE NOTIFICACIÓN</b></th> 
                     </tr>
                     <tr>
                       <th width="100" align="left">Fecha de Recepción</th> 
                       <th width="440">: Puquio,....de..................................................del '.$anio_impresion.'</th> 
                     </tr> <br>
                     <tr>
                       <th width="100"  align="left">Domicilio</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                     <tr>
                       <th width="100"  align="left">Apellidos y Nombres</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Parentesco</th>
                       <th>: .................................................................................................. DNI:...................................... </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Firma de Recepción</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Notificado Por</th>
                       <th>: .................................................................................................. DNI:.....................................  </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Firma Notificador</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Referencia</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                     <tr>
                       <th width="100"  align="left">N° de suministro de Luz</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Correo Electronico</th>
                       <th>: .................................................................................................. Celular:.................................  </th>
                     </tr>
             </table>';
$pdf->writeHTML($sector_2, true, false, false, false, '');


//end propiertario

//---------------------END TABLA DE LIQUIDACION


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
