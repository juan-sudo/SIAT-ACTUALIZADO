<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');
//--------------------------------------------------------(ANEXO 19)
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


//VALORES ASIFNADOS
$resolucion_Ejecucion_asig=strtoupper($_POST['resolucionEjecucion']);
$resolucion_medida_asig=strtoupper($_POST['resolucionMedida']);

$placa_vehiculo_asig=strtoupper($_POST['placaVehiculo']);
$ubicacion_predio_asig=strtoupper($_POST['ubicacionPredio']);
$partida_registral_asig=strtoupper($_POST['partidaRegistral']);

$fundamento_asig=$_POST['fundamento'];

$anexos_asig = json_decode($_POST['anexos'], true); // Decodificar JSON a array en PHP
$mueble_inmueble_asig = json_decode($_POST['numebleInmueble'], true); // Decodificar JSON a array en PHP



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
$anio_actual=date('Y');
$dia_impresion = date('d');
//$mes_impresion = date('m');
$meses = array(
    "01" => "enero", "02" => "febrero", "03" => "marzo", "04" => "abril", "05" => "mayo", "06" => "junio",
    "07" => "julio", "08" => "agosto", "09" => "setiembre", "10" => "octubre", "11" => "noviembre", "12" => "diciembre"
);

$mes_impresion = date('m');  // Obtiene el mes en formato numérico (01-12)
$mes_nombre = $meses[$mes_impresion];  // Obtiene el nombre del mes co

$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 7);




// Logo
$file = 'C:/xampp/htdocs/SIAT/vistas/img/logo/logou.jpg'; 
$imageData = base64_encode(file_get_contents($file));
$imgBase64 = 'data:image/jpeg;base64,' . $imageData;
$pdf->Image($file, 10, 5, 25, 25, 'JPG', '', '', true);

// Resolución
$pdf->MultiCell(0, 5, '', 0, 'C');


$pdf->Ln(2); // También reducido a 1
$pdf->SetX(40); 
$pdf->SetFont('helvetica', 'B', 12);  
$pdf->Cell(120, 0, 'Solicitud de terceria de propiedad por deuda tributaria ', 0, 1, 'C');
$pdf->Ln(4); // También reducido a 1

//UBICACION Y FECHA

// Escribir la primera tabla
// $pdf->SetX(10);
// $pdf->SetFont('helvetica', ' ', 10);
// $html_head ='<table cellpadding="2" cellspacing="0" style="margin-bottom: 0;"><tr>
//                 <td colspan="2">Puquio, ' . $dia_impresion .' de '.$mes_nombre.' del '.$anio_actual.'</td>
//              </tr>
//            </table>';
// $pdf->writeHTML($html_head);

$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', ' ', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, 'Puquio, ' . $dia_impresion .' de '.$mes_nombre.' del '.$anio_actual.' ', 0, 1, 'L');






//----------------------------------------------- ESTIMADO CONTRIBUEYNTE
$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '1. IDENTIFICACION DE CONTRIBUYENTES: ', 0, 1, 'L');



$pdf->Ln(2);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 

$html_propietario='<table cellpadding="1" align="center">
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

//----------------------------------TABLA IMPUESTO PREDIA------



//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '2. RESOLUCIONES: ', 0, 1, 'L');
$pdf->Ln(2);

$pdf->SetFont('helvetica', '', 6.5);  // Establecer a fuente normal (sin negrita)

$html_propietario='<table cellpadding="1" align="left">
                     ';
               
$html_propietario .='<tr>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="150">Resolucion de ejecucion coactiva REC N°</th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="120">'.$resolucion_Ejecucion_asig.'</th>';

$html_propietario .='</tr>';
$html_propietario .='<tr>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="150">Resolucion de medida cutelar </th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="120">'.$resolucion_medida_asig.'</th>';
$html_propietario .='</tr>';

             
$html_propietario .='</table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '3. RESPECTO DEL BIEN AFECTADO POR LA MEDIDA CAUTELAR: ', 0, 1, 'L');


$pdf->Ln(2);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 


// Verificar que el JSON contiene datos válidos
if (is_array($mueble_inmueble_asig ) && count($mueble_inmueble_asig) > 0) {
    // Inicio de la tabla HTML
    $html = "<style>
                th {
                    font-size: 7px;
                    font-family: Arial, sans-serif;
                    font-weight: bold;
                   
                }
                td {
                    font-size: 7px;
              
                }
             
                
            </style>";

    $html .= '<table style="width:100%; border-collapse: collapse;">';
    $html .= '
              
              <tbody>';

    // Iteramos a través de los elementos del JSON
    foreach ($mueble_inmueble_asig as $item) {
        $html .= '<tr>';
        
        // Descripción
        $html .= '<td width="60%"> - ' . $item['descripcion'] . '</td>';

        
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';
} else {
    // Si el JSON no tiene datos o está vacío
    $html = '<p>No se recibieron datos válidos para el fundamento legal.</p>';
}

$pdf->writeHTML($html, true, false, false, false, '');

//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '4. DOCUMENTOS: ', 0, 1, 'L');

$pdf->Ln(2);
$pdf->SetFont('helvetica', '', 6.5);  // Establecer a fuente normal (sin negrita)

$html_propietario='<table cellpadding="1" align="left">
                     ';
               
$html_propietario .='<tr>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="110">Placa del vehiculo</th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1; padding-left:20px" width="120">'.$placa_vehiculo_asig.'</th>';
$html_propietario .='</tr>';

$html_propietario .='<tr>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="110">Ubicacion del predio </th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="120">'.$ubicacion_predio_asig.'</th>';
$html_propietario .='</tr>';

$html_propietario .='<tr>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="110">Partida registral </th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="120">'.$partida_registral_asig.'</th>';
$html_propietario .='</tr>';


             
$html_propietario .='</table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');
//------------------------------------------ ESTIMADO CONTRIBUEYNTE


//------------------------------------------ ESTIMADO CONTRIBUEYNTE
$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, 'Fundamentos: ', 0, 1, 'L');


$pdf->Ln(2);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 


    // Inicio de la tabla HTML
    $html = "<style>
                th {
                    font-size: 7px;
                    font-family: Arial, sans-serif;
                    font-weight: bold;
                   
                }
                td {
                    font-size: 7px;
              
                }
             
                
            </style>";

    $html .= '<table style="width:100%; border-collapse: collapse;">';
    $html .= '
              
              <tbody>';

    // Iteramos a través de los elementos del JSON
   
        $html .= '<tr>';
        
        // Descripción
        $html .= '<td width="100%"> ' . $fundamento_asig. '</td>';

        
        $html .= '</tr>';
    

    $html .= '</tbody></table>';


$pdf->writeHTML($html, true, false, false, false, '');
//------------------------------------------ ESTIMADO CONTRIBUEYNTE



//------------------------------------------ ESTIMADO CONTRIBUEYNTE
$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, ' Anexos: ', 0, 1, 'L');


$pdf->Ln(2);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 


// Verificar que el JSON contiene datos válidos
if (is_array($anexos_asig) && count($anexos_asig) > 0) {
    // Inicio de la tabla HTML
    $html = "<style>
                th {
                    font-size: 7px;
                    font-family: Arial, sans-serif;
                    font-weight: bold;
                   
                }
                td {
                    font-size: 7px;
              
                }
             
                
            </style>";

    $html .= '<table style="width:100%; border-collapse: collapse;">';
    $html .= '
              
              <tbody>';

    // Iteramos a través de los elementos del JSON
    foreach ($anexos_asig as $item) {
        $html .= '<tr>';
        
        // Descripción
        $html .= '<td width="60%"> - ' . $item['descripcion'] . '</td>';

        
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';
} else {
    // Si el JSON no tiene datos o está vacío
    $html = '<p>No se recibieron datos válidos para el fundamento legal.</p>';
}

$pdf->writeHTML($html, true, false, false, false, '');
//------------------------------------------ ESTIMADO CONTRIBUEYNTE


//------------------------------------------ ESTIMADO CONTRIBUEYNTE




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
