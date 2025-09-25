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

//VALORES ASIFNADOS
$resolucion_Ejecucion_asig=$_POST['resolucionEjecucion'];
$resolucion_medida_asig=$_POST['resolucionMedida'];
$numero_documento_asig=$_POST['numeroDocumento'];
$fundamentoLegal = json_decode($_POST['fundamentoLegal'], true); // Decodificar JSON a array en PHP

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
                       <th style="font-size:7px;"></th> 
                    </tr>

                    <tr>

                    <th width="340">SISTEMA DE RECAUDACIÓN MUNICIPAL</th>
                     <th width="120"  align="left" ></th> 
                      
                    </tr>

                   
                    
                   
                   
                    
                    
             </table>';
$pdf->writeHTML($html_head);

$pdf->Image($file, 10, 5, 25, 25, 'JPG', '', '', true);

// Resolución
$pdf->MultiCell(0, 5, '', 0, 'C');

$pdf->SetX(40); 
$pdf->SetFont('helvetica', 'B', 16);  
$pdf->Cell(120, 0, 'Oficina de Ejecucion Coactiva', 0, 1, 'C');
$pdf->Ln(2); // También reducido a 1
$pdf->SetX(40); 
$pdf->SetFont('helvetica', 'B', 10);  
$pdf->Cell(120, 0, 'Solicitud de suspencion del procedimiento de ejecucion coactiva por deuda tributaria', 0, 1, 'C');

//end propiertario
//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->Ln(2);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, 'Puquio, ' . $dia_impresion .' de '.$mes_nombre.' del '.$anio_impresion.' ', 0, 1, 'L');




$pdf->SetX(8); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible



//----------------------------------------------- ESTIMADO CONTRIBUEYNTE


$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '1. Identificacion del deudor tributario ', 0, 1, 'L');


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





//----------------------------------TABLA IMPUESTO PREDIA------



$pdf->Ln(3);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '2. Respecto de la deuda de Impuesto predial: ', 0, 1, 'L');



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


//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '3. Resoluciones: ', 0, 1, 'L');


//------------------------------------------ ESTIMADO CONTRIBUEYNTE

$pdf->SetFont('helvetica', '', 6.5);  // Establecer a fuente normal (sin negrita)

$html_propietario='<table align="left" cellpadding="1" >
                     ';
               
$html_propietario .='<tr>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="150">Resolucion de ejecucion coactiva REC N°</th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="120">'.$resolucion_Ejecucion_asig.'</th>';

$html_propietario .='</tr>';
$html_propietario .='<tr>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="150">Resolucion de medida cutelar </th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="120">'.$resolucion_medida_asig.'</th>';

$html_propietario .='</tr>';
$html_propietario .='<tr>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="150">Numero de documento de deuda</th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" border="0.1" width="120">'.$numero_documento_asig.'</th>';

$html_propietario .='</tr>';
             
$html_propietario .='</table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');
//------------------------------------------ ESTIMADO CONTRIBUEYNTE



//------------------------------------------ ESTIMADO CONTRIBUEYNTE
$pdf->Ln(2);
//pripetario
$pdf->SetX(8); 
$pdf->SetFont('helvetica', 'B', 7);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '4. Fundamento: ', 0, 1, 'L');


$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 


// Verificar que el JSON contiene datos válidos
if (is_array($fundamentoLegal) && count($fundamentoLegal) > 0) {
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
             
                .mi-tabla thead {
                    border-bottom: 0.3px solid black;
                }
            </style>";

    $html .= '<table border="0.3" style="width:100%; border-collapse: collapse;"cellpadding="1" >';
    $html .= '<thead>
                <tr>
                  
                     <th width="60%">Descripción</th> <!-- Hacemos la columna descripción más ancha -->
                    <th width="15%">N° Expediente</th>
                    <th width="15%">N° Resolución</th>
                    <th width="10%">Fecha</th>
                </tr>
              </thead><tbody>';

    // Iteramos a través de los elementos del JSON
    foreach ($fundamentoLegal as $item) {
        $html .= '<tr>';
        
        // Descripción
        $html .= '<td width="60%">' . $item['descripcion'] . '</td>';

        // Nro Expediente: Si existe
        $expediente = isset($item['expediente']) ? $item['expediente'] : '-';
        $html .= '<td width="15%" class="uno">' . $expediente . '</td>';

        // Nro Resolución: Si existe
        $resolucion = isset($item['resolucion']) ? $item['resolucion'] : '-';
        $html .= '<td width="15%">' . $resolucion . '</td>';

        // Fecha: Si existe
        $fecha = isset($item['fecha']) ? $item['fecha'] : '-';
        $html .= '<td width="10%">' . $fecha . '</td>';

        $html .= '</tr>';
    }

    $html .= '</tbody></table>';
} else {
    // Si el JSON no tiene datos o está vacío
    $html = '<p>No se recibieron datos válidos para el fundamento legal.</p>';
}




$pdf->writeHTML($html, true, false, false, false, '');
//------------------------------------------ ESTIMADO CONTRIBUEYNTE





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
