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

//ASIGNADOS
$expediente=$_POST['expediente']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$numero_expediente=$_POST['numeroExpediente']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor

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
                       <th style="font-size:7px;"></th> 
                    </tr>

                    <tr>

                    <th width="340">SISTEMA DE RECAUDACIÓN MUNICIPAL</th>
                     <th width="120"  align="left" border="0.1">Expediente: 754771 , ACUM</th> 
                      
                    </tr>

                    <tr>
                     <th width="340"></th>
                       <th width="120"  align="left" border="0.1">Auxiliar: David Jalixto Huasco</th> 
                      
                    </tr>
                    
                      <tr>
                     <th width="340"></th>
                       <th width="120"  align="left" border="0.1">CC: </th> 
                      
                    </tr>
                   
                    
                    
             </table>';
$pdf->writeHTML($html_head);

$pdf->Image($file, 10, 5, 25, 25, 'JPG', '', '', true);

// Resolución
$pdf->MultiCell(0, 5, '', 0, 'C');

$pdf->SetX(40); 
$pdf->SetFont('helvetica', 'B', 12);  
$pdf->Cell(120, 0, 'CEDULA DE NOTIFICACION N° 005-2025 GAT - MPLP', 0, 1, 'C');



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



//------------------------------------------ ESTIMADO CONTRIBUEYNTE
$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', '', 6.5);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '1. DEUDA TRIBUTARIA COACTIVA ', 0, 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 

$html_propietario='<table align="center">
                     <tr style="background-color:#e3eff3;">
                       <td border="0.1" width="340"><h4>Lugar y fecha expediencion de documento</h4></td>
                       <td border="0.1" width="200"><h4>Distrito </h4></td>
               
                     </tr>';
               
$html_propietario .='<tr>';
$html_propietario .='<td  border="0.1" style=" border-left: 0.1px solid black; border-bottom: 0.1px solid black;" width="340"> '.$fechaActual.'</td>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="200"> Puquio</th>';

$html_propietario .='</tr>';
             
$html_propietario .='</table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

//end propiertario
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "El Ejecutor Coactivo, de la Municipalidad Provincial de Lucanas de Puquio, Abogado <nombredelEjecutor Coactivo>, ha resuelto lo siguiente:";

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

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = "RESOLUCION NUMERO DOS";

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
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = ' a los '.$fechaActual.'';

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

$pdf->Ln(2); // Salto de línea
// Obtener la fecha actual
$textoLargo = 'VISTOS: 
Los actuados en el presente procedimiento, estando a lo que expresa; 

CONSIDERANDO: 
Primero.- Que la persona, objeto y naturaleza de los expedientes '.$expediente.' son los mismos, por lo que procede su acumulación; Segundo.- Que de la verificación en el Sistema [nombre del sistema informático de la Administración Tributaria], se evidencia que el obligado [nombre del contribuyente], con DNI [número de documento de identidad], registra a la fecha deuda en cobranza activa, por lo que es necesario asegurar el cumplimiento de dicha obligación tributaria, en consecuencia, debe procederse con trabarse las medidas cautelares que sean necesarias; Tercero.- Que el Ejecutor Coactivo, en cualquier estado del procedimiento, podrá trabar y/o variar la medida cautelar correspondiente, a fin de garantizar la deuda tributaria materia del presente procedimiento, y de conformidad con lo dispuesto en los artículos 3º, 20º, 32º y 33º de la Ley N° 26979 – Ley de Procedimiento de Ejecución Coactiva, modificada por la Ley N° 28165 y la Ley N° 28892.';

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

$textoLargo = 'SE RESUELVE:
PRIMERO.- Acumular los expedientes señalados en el considerando primero del presente mandato, entendiéndose en adelante como uno solo bajo el expediente N° '.$numero_expediente.' - ACUM; notificándose.
Firmado:
Hector Alrberto Huarcaya Cotaquispe, Ejecutor Coactivo;
David Jalixto, Auxiliar Coactivo.

Lo que notifico a usted conforme a ley.';

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- EN PRIMER PARRAFO


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
                        <th width="70"> <b></b></th>
                  
                    </tr>
                   
                 
             </table>';
$pdf->writeHTML($html_head);


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
