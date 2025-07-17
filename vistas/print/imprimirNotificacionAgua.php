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
$filtroFecha = $_POST['fecha_notificacion'];  // Capturamos la fecha de notificación
$filtroEstado = $_POST['estado'];  // Capturamos el estado

switch ($filtroEstado) {
    case 'N':
        $estadoCompleto = 'Notificado';
        break;
    case 'C':
        $estadoCompleto = 'Afecto a corte';
        break;
    case 'S':
        $estadoCompleto = 'Sin servicio';
        break;
    case 'P':
        $estadoCompleto = 'Pagado';
        break;
    default:
        $estadoCompleto = 'Todos';  // Si no hay filtro o no es ninguno de los anteriores
}

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

// Tabla de estado con los valores de los filtros
$html_propietario = '<table align="center" >
                        <tr style="background-color:#e3eff3;">
                            <td width="100"><h4>Estado</h4></td>
                            <td width="100"><h4>Fecha</h4></td>
                        </tr>
                        <tr>
                             <td>' . $estadoCompleto . '</td> <!-- Muestra el estado -->
                            <td>' . ($filtroFecha ? $filtroFecha : 'No especificada') . '</td> <!-- Muestra la fecha -->
                        </tr>
                    </table>';

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html_propietario, true, false, false, false, '');




//TABLA DE NOBRES Y APELLIDOS

$colWidths = [10, 60, 15, 100]; // Quitamos dos columnas

// Imprimir encabezados
$pdf->SetFont('helvetica', 'B', 9);

$pdf->Cell($colWidths[0], 7, 'Nro', 0, 0, 'C');
$pdf->Cell($colWidths[1], 7, 'Nombres', 0, 0, 'C');
$pdf->Cell($colWidths[2], 7, 'Nro notif.', 0, 0, 'C');
$pdf->Cell($colWidths[3], 7, 'Direccion', 0, 1, 'C'); // Salto de línea

  $pdf->Line(10, $pdf->getY(),190, $pdf->getY());
        //    $pdf->MultiCell(0, 0, '', 0, 'C');
          
// Imprimir filas de datos
$pdf->SetFont('helvetica', '', 8);
foreach ($tabla_datos as $row) {
    $pdf->Cell($colWidths[0], 6, $row[0], 0, 0, 'C');
    $pdf->Cell($colWidths[1], 6, $row[1], 0, 0, 'C');
    $pdf->Cell($colWidths[2], 6, $row[2], 0, 0, 'C');
    $pdf->Cell($colWidths[3], 6, $row[3], 0, 1, 'C'); // Salto de línea
}

            

            
           
           // $pdf->MultiCell(0, 0, '', 0, 'L');
            $pdf->Line(10, $pdf->getY(),190, $pdf->getY());
            $pdf->MultiCell(0, 0, '', 0, 'C');
          
         
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
