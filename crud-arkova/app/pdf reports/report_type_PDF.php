<?php
session_start();
// Incluir la conexión a la base de datos
require '../config/database.php';

// Incluir la librería FPDF
require "../libs/fpdf/fpdf.php";

// Consulta para obtener los datos de los tipos de reporte
$sql_types = "SELECT name FROM report_type";

// Ejecutar la consulta y obtener los resultados
$resultado = mysqli_query($conn, $sql_types) or die("Error al consultar Tipos de Reporte: " . mysqli_error($conn));

$fecha = date("d-m-Y");
$hora = date("H:i:s");

class PDF extends FPDF {
    // Header
    function Header() {
        global $fecha; // Usamos la fecha global
        global $hora; // Usamos la hora global
        // Barra negra (rectángulo negro)
        $this->SetFillColor(0, 0, 0); // Color negro
        $this->Rect(0, 0, $this->GetPageWidth(), 20, 'F'); // Dibuja un rectángulo negro al principio de la página

        // Ruta del logo
        $this->Image('../assets/brand/ARKOVA-logo-WT.png', 10, 5, 25);

        
        $this->SetXY(40, 7); // Cambiar la posición del texto después del logo
        // Arial bold 16
        $this->SetFont('Arial', 'B', 16);
        // Título (en blanco sobre la barra negra)
        $this->SetTextColor(255, 255, 255); // Color de texto blanco
        $this->Write(5, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', '| Informe de Tipos de Reporte en ' . $fecha . ' a las ' . $hora));
        // Salto de línea
        $this->Ln(20);
        $this->SetTextColor(0, 0, 0); // Restablecer color de texto a negro
    }

    // Footer
    function Footer() {
        global $fecha; // Usamos la fecha global
        global $hora; // Usamos la hora global
        // Posicionar a 1.5 cm del pie
        $this->SetY(-18); // Aumenta el valor a -18 para separar más el pie de la página
        // Arial itálica 8
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(169, 169, 169); // Gris claro
        // Número de página
        $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Pág ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        // Autoria del documento
        $this->Ln(5);  // Salto de línea antes de la autoría, ajusta según lo necesites
        $this->Cell(0, 10, 'ARKOVA v1.0 (' . $fecha . ' - ' . $hora . iconv('UTF-8', 'ISO-8859-1//TRANSLIT', ') © A.C. BBVVA'), 0, 0, 'C');
    }
}

// Crear un nuevo PDF
$pdf = new PDF();
$pdf->SetCreator('ARKOVA v1.0'); // Software o sistema que generó el PDF
$pdf->SetAuthor('A.C. BBVVA'); // Autor o entidad responsable del contenido
$pdf->AliasNbPages();
$pdf->AddPage('P', 'Letter'); // Añadir nueva página
$pdf->SetRightMargin(20); // Establecer margen derecho de 20mm

// Establecer el margen inferior a 1.5 cm
$pdf->SetAutoPageBreak(true, 15); // El segundo parámetro es el margen inferior, en mm

// Agregar los datos de los tipos de reporte en una tabla
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->SetFillColor(79, 78, 77);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(195, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Nombre'), 1, 0, 'C', 1);
$pdf->Ln();

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(255, 255, 255);

// Recorrer los resultados y agregar los datos a la tabla
while ($row_report_type = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
    $nombre_tipo = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row_report_type['name']);
    $pdf->Cell(195, 10, $nombre_tipo, 1, 0, 'C', 1);
    $pdf->Ln();
}

// Generar la fecha y hora en el formato deseado
$fechaHora = date("d-m-Y _ H-i-s");
$nombreArchivo = "Tipos de Reporte - ARKOVA en " . $fechaHora . ".pdf";

// Convertir a ISO-8859-1 para asegurar caracteres especiales
$nombreArchivo = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombreArchivo);

// Salida del PDF con el nombre personalizado
$pdf->Output('I', $nombreArchivo); // 'I' envía el archivo al navegador con el nombre especificado
?>

<?php 
// Incluir la conexión a la base de datos
require '../config/database.php';
$username = $_SESSION['user_name'];

    // Obtener la fecha y hora actual
    $fecha = date("Y-m-d H:i:s");

    // Construir la consulta de inserción en la tabla auditory
    $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES ('$username', '$fecha', 'El usuario [$username] generó un informe general de Tipo de Reportes en formato PDF')";

    $auditoria = mysqli_query($conn, $sql_aud);

    // Cierra la conexión
    mysqli_close($conn);
?>