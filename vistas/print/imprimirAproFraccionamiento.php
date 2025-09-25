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


//ASGINADO
$numero_fraccionado_asig=$_POST['numeroFraccionado']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$numero_cuota_asig=$_POST['numeroCuota']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$numero_convenio_asig=$_POST['numeroConvenio']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$importeFraccionado=$_POST['importeFraccionado']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor




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
$pdf->SetFont('helvetica', 'B', 12);  
$pdf->Cell(120, 0, 'RESOLUCION DE APROBACION DE FRACCIONAMIENTO N° 005-2025 GAT - MPLP', 0, 1, 'C');


//------------------------------------------ PRIMER PARRAFO

$pdf->Ln(1); // Salto de línea
// Obtener la fecha actual

$textoLargo = 'VISTA, la solicitud de fracionamiento N° '.$numero_fraccionado_asig.' presentado por;';

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- EN PRIMER PARRAFO

//------------------------------------------ ESTIMADO CONTRIBUEYNTE
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
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

//end propiertario
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "CONSIDERANDO:";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- ESTIMADO CONTRIBUEYNTE
//end propiertario


$pdf->Ln(1); // Salto de línea
// Obtener la fecha actual

$textoLargo = "Que, mediante <Baselegalquenormael fraccionamiento>, la Municipalidad Provincial Lucanas - puquio en la que el ejecutor coactivo aprobó el Reglamento de Fraccionamiento,
 para brindar facilidades de pago a los contribuyentes;";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- EN PRIMER PARRAFO

//----------------------------------------------- EN PRIMER PARRAFO


$pdf->Ln(1); // Salto de línea
// Obtener la fecha actual

$textoLargo = '
Que, de conformidad con el artículo 36 del codigo tributario del Reglamentode Fraccionamiento, aprobado mediante <normativa>,el deudor ha cumplido con la presentación de los requisitos para el acogimiento del fraccionamiento desudeuda,ascendente a la suma de '.$importeFraccionado.' importe total dela deuda fraccionada y cancelaren '.$numero_cuota_asig.' cuotas mensuales a través del Convenio de Fraccionamiento N° '.$numero_convenio_asig.', según la proforma adjunta a la solicitud; Que,en uso de las facultades con feridas en el artículo <Número de la rtículo >de la Ordenanza N°<Número de la Ordenanza que aprueba el ROF >que aprueba el Reglamento de Organización y Funciones de la Municipalidad <Distrital/Provincial> de <Nombre de la Municipalidad> y modificatorias establecidas en el presente documento';

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

$pdf->Ln(2); // Salto de línea
//------------------------------------------ PRIMER PARRAFO

// Obtener la fecha actual
$textoLargo = "SE RESUELVE";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- EN PRIMER PARRAFO

//----------------------------------------------- EN PRIMER PARRAFO

$pdf->Ln(2); // Salto de línea
//------------------------------------------ PRIMER PARRAFO

// Obtener la fecha actual
$textoLargo = 'ARTÍCULO1°:APROBAR la solicitud de fraccionamiento N° '.$numero_fraccionado_asig.' ,presentada por el <datos del contribuyente >,con código N°<código de contribuyente> por S/.'.$importeFraccionado.' importe totalde ladeuda fraccionada>,otorgándoseel fraccionamiento conel númerodecuotas,montosdeamortización, interesesy fechas de vencimientos de acuerdo con el plan de pagos adjunto que forma parte de esta resolución.';

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- EN PRIMER PARRAFO

$pdf->Ln(2); // Salto de línea
//------------------------------------------ PRIMER PARRAFO

// Obtener la fecha actual
$textoLargo = "ARTÍCULO 2°: Notificar la presente resolución al contribuyente, a fin de que cumpla con el pago de la deuda fraccionada dentro de los plazos establecidos, así como con las condiciones establecidas en el presente documento, para mantener la vigencia del fraccionamiento. 

El presente acto tiene vigencia desde el día de su emisión.";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

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
                       <th colspan="2"><strong></strong></th>
                    </tr>

                    <tr>
                       <th colspan="8"> <strong>Para mayor información:</strong>'.'Oficina de ejecucion coactiva celular 966004730 / 966002552'.'</th>
                        <th width="70" style="text-align: center; font-size:11px; "> <b></b></th>
                  
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
