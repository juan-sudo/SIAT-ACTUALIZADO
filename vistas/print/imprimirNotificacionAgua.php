<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');
use Conect\Conexion;
use Controladores\ControladorPredio;
use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorConfiguracion;
use Modelos\ModeloContribuyente;
use Modelos\ModeloEstadoCuenta;

class MYPDF extends TCPDF {

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
        $this->Cell(0, 10,$configuracion['Nombre_Empresa'] , 0, 0, 'C');
    }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer la información del PDF
$pdf->SetCreator('TuNombre');
$pdf->SetAuthor('TuNombre');
$pdf->SetTitle('Mi PDF');
// Agregar una página
$pdf->AddPage();

// $id_usuario=$_POST['id_usuario'];
// $carpeta=$_POST['carpeta'];
// $id_area=$_POST['id_area']; 
// $id_cuenta=$_POST['id_cuenta']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
// $propietarios=$_POST['propietarios']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
// //$estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuenta_pdf($propietarios,$id_cuenta,"null","null",'null');

//$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios);
$configuracion = ControladorConfiguracion::ctrConfiguracion();

$tabla_datos = json_decode($_POST['tabla_datos'], true);  // Decodificar el JSON recibido

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
$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 7);
$html_head ='<table><tr>
                       <th colspan="4">'.$configuracion['Nombre_Sistema'].'</th>
                       <th colspan="4">Versión '.$configuracion['Version'].'</th>
                        <th colspan="2">pagina: '.$numeroPagina.'</th>
                    </tr>
                    <tr>
                       <th colspan="8">'.$configuracion['Nombre_Empresa'].'</th>
                        <th colspan="2">Fecha: '.$fechaActual.'</th>
                    </tr>
                   
                  
             </table>';
$pdf->writeHTML($html_head);
$pdf->MultiCell(0, 5, '', 0, 'L');
$pdf->SetX(40); 
$pdf->SetFont('helvetica', '', 9);  // Establecer el tamaño de letra a 8
$pdf->Cell(120, 0, 'CONSULTA  NOTIFICACION DE AGUA ', 0, 1, 'C', 0, '', 8);
$pdf->Ln(3);
$pdf->SetFont('helvetica', '', 8);



$html_estado= '<table align="center">
            <thead>
            <tr>
                <th><b>Nro</b></th>
                <th><b>Nombres</b></th>
                <th><b>Nro notif.</b></th>
                <th><b>direccion</b></th>
                <th><b>fecha notif.</b></th>
                <th><b>Fecha corte</b></th>
             
            </tr>
            </thead>
            </table>';
            
            $pdf->writeHTML($html_estado, true, false, false, false, '');
            $pdf->Line(15, $pdf->getY()-3,200, $pdf->getY()-3);
           $html = '<table align="center">
            <colgroup>
                <col width="10">
                <col width="100">
                <col width="60">
                <col width="250">
                <col width="80">
                <col width="70">
            </colgroup>
            ';
            $sin_descuento=0; 
            $tim=0;         
           foreach ($tabla_datos as $row) {
                $html .= "<tr>";
                $html .= "<td >" . $row[0] . "</td>";   // Nro
                $html .= "<td >" . $row[1] . "</td>";   // Nombres
                $html .= "<td >" . $row[2] . "</td>";   // Nro de notificación
                $html .= "<td >" . $row[3] . "</td>";  // Dirección
                $html .= "<td >" . substr($row[4], 0, 10) . "</td>"; // Fecha notificación
                $html .= "<td >" . $row[5] . "</td>";   // Fecha de corte
                $html .= "</tr>";
            }
            $html .= '</table>';
           
            $pdf->writeHTML($html, true, false, false, false, '');
         
          


            

            
           
           // $pdf->MultiCell(0, 0, '', 0, 'L');
            $pdf->Line(10, $pdf->getY(),200, $pdf->getY());
            $pdf->MultiCell(0, 10, '', 0, 'L');
          
         
$pdf->SetX(45); 
$pdf->SetFont('helvetica', '', 8);  // Establecer el tamaño de letra a 8
$pdf->Cell(120, 0, 'INFORMACION VALIDA SOLO COMO CONSULTA', 0, 1, 'C', 0, '', 8);
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
