<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');

use Controladores\ControladorConfiguracion;
use Modelos\ModeloEstadoCuenta;
class MYPDFC extends TCPDF {
//-----------------------------------------ANEXO 12------------------
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

$detalleD_dcumento_asig=json_decode($_POST['detalleDocumentos']); //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor

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
$pdf->SetFont('helvetica', 'B', 12);  
$pdf->Cell(120, 0, 'CONSTANCIA N° 005-2025 GAT - MPLP', 0, 1, 'C');


//------------------------------------------ PRIMER PARRAFO

$pdf->Ln(1); // Salto de línea
// Obtener la fecha actual

$textoLargo = "Puquio, 12 de setiembre del 2025";

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
$textoLargo = "Señor ejecutor coactivo Dr. Hector Alberto Huarcaya Cotaquispe de la Municipalidad Provincial de Lucanas - Puquio";

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

$textoLargo = "En cumplimientoa lo dispuesto por el numeral 15.2 del Art.15° del T.U.O. de la Ley de Procedimiento de Ejecución Coactiva aprobadopor D.S.N°018-2008-JUS; comunico a usted que las obligaciones contenidas en los documentos que se detallan al final del apresente,han quedado con sentidos y/o han causado estado, al no haber se interpuesto recurso impugnativo dentro del plazo de ley y encontrarse pendiente de pago.";

$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$textoLargo .= "\n";

// Calculamos el ancho disponible para el texto
$anchoDisponible = 210 - 8 - 10; // Ancho de la página A4 menos los márgenes

// Usamos el ancho disponible para MultiCell
$pdf->MultiCell($anchoDisponible, 6, $textoLargo, 0, 'J'); // Justificado, con márgenes definidos

//----------------------------------------------- EN PRIMER PARRAFO



$pdf->Ln(4); // Salto de línea

//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', '', 6.5);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, 'Detalle de los documentos', 0, 1, 'L');


$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 

$html_propietario = '<table align="start" style="border: 0.1px solid black;">'; // Borde de la tabla más delgado

$contador = 1; // Inicializamos el contador
foreach ($detalleD_dcumento_asig as $item) {
    $html_propietario .= '<tr>';
    $html_propietario .= '<td style="border: 0.1px solid black; border-left: 0.1px solid black; border-bottom: 0.1px solid black; width: 100%; height: 10px;">' . $contador . '. ' . $item->detalle . '</td>';
    $html_propietario .= '</tr>';
    $contador++; // Incrementamos el contador
}

$html_propietario .= '</table>';



$pdf->writeHTML($html_propietario, true, false, false, false, '');


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
