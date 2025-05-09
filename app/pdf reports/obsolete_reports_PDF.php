<?php
session_start();
// Incluir la conexión a la base de datos
require '../config/database.php';

// Incluir la librería FPDF
require "../libs/fpdf/fpdf.php";

// Consulta SQL para obtener los reportes inactivos
$sqlReports = "SELECT r.id_report_type, r.name, r.description, r.date, rt.name AS rt 
               FROM reports AS r
               INNER JOIN report_type AS rt ON r.id_report_type = rt.id
               WHERE r.state_report = 0"; // Solo selecciona reportes inactivos

// Ejecutar la consulta y obtener los resultados
$resultado = mysqli_query($conn, $sqlReports) or die("Error al consultar Reportes Obsoletos: " . mysqli_error($conn));

$fecha = date("d-m-Y");
$hora = date("H:i:s"); 

class PDF extends FPDF {
    // Header
    function Header() {
        global $fecha, $hora;
        // Barra negra (rectángulo negro)
        $this->SetFillColor(0, 0, 0);
        $this->Rect(0, 0, $this->GetPageWidth(), 20, 'F');

        // Ruta del logo
        $this->Image('../assets/brand/ARKOVA-logo-WT.png', 10, 5, 25);

        $this->SetXY(40, 7);
        $this->SetFont('Arial', 'B', 15.9);
        $this->SetTextColor(255, 255, 255);
        $this->Write(5, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', '| Informe de Reportes Obsoletos en ' . $fecha . ' a las ' . $hora));
        $this->Ln(20);
        $this->SetTextColor(0, 0, 0);
    }

    // Footer
    function Footer() {
        global $fecha, $hora;
        $this->SetY(-18);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(169, 169, 169);
        $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Pág ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, 'ARKOVA v1.0 (' . $fecha . ' - ' . $hora . iconv('UTF-8', 'ISO-8859-1//TRANSLIT', ') © A.C. BBVVA'), 0, 0, 'C');
    }

    // Función para calcular la altura de una fila
    function getRowHeight($text, $width) {
        $lineHeight = 10;
        $nbLines = $this->NbLines($width, $text);
        return max(10, $nbLines * $lineHeight);
    }

    // Función para calcular las líneas necesarias para un texto
    function NbLines($width, $text) {
        $cw = &$this->CurrentFont['cw'];
        if ($width == 0)
            $width = $this->w - $this->rMargin - $this->x;
        $wmax = ($width - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $text);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}

// Crear un nuevo PDF
$pdf = new PDF();
$pdf->SetCreator('ARKOVA v1.0'); // Software o sistema que generó el PDF
$pdf->SetAuthor('A.C. BBVVA'); // Autor o entidad responsable del contenido
$pdf->AliasNbPages();
$pdf->AddPage('P', 'Letter');
$pdf->SetFont('Arial', '', 12);
$pdf->SetRightMargin(20);
$pdf->SetAutoPageBreak(true, 15);

// Títulos de la tabla
$pdf->SetFillColor(79, 78, 77);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(45, 10, 'Tipo de Reporte', 1, 0, 'C', 1);
$pdf->Cell(55, 10, 'Nombre del Reporte', 1, 0, 'C', 1);
$pdf->Cell(60, 10, 'Descripcion', 1, 0, 'C', 1);
$pdf->Cell(35, 10, 'Fecha y Hora', 1, 1, 'C', 1);

// Relleno de los datos
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(255, 255, 255);

while ($row = mysqli_fetch_assoc($resultado)) {
    // Convertir datos para soportar caracteres especiales
    $tipo = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['rt']);
    $nombre = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['name']);
    $descripcion = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['description']);
    $fechaHora = date("d-m-Y H:i", strtotime($row['date']));

    // Determinar la altura máxima de la fila
    $heightTipo = $pdf->getRowHeight($tipo, 45);
    $heightNombre = $pdf->getRowHeight($nombre, 55);
    $heightDescripcion = $pdf->getRowHeight($descripcion, 60);
    $heightFechaHora = 10; // Fecha y hora suele ser corta, altura fija

    $rowHeight = max($heightTipo, $heightNombre, $heightDescripcion, $heightFechaHora);

    // Guardar posición inicial de la fila
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Columna: Tipo de Reporte
    $pdf->MultiCell(45, $rowHeight / ceil($heightTipo / 10), $tipo, 1, 'C');
    $pdf->SetXY($x + 45, $y);

    // Columna: Nombre del Reporte
    $x = $pdf->GetX();
    $pdf->MultiCell(55, $rowHeight / ceil($heightNombre / 10), $nombre, 1, 'C');
    $pdf->SetXY($x + 55, $y);

    // Columna: Descripción
    $x = $pdf->GetX();
    $pdf->MultiCell(60, $rowHeight / ceil($heightDescripcion / 10), $descripcion, 1, 'C');
    $pdf->SetXY($x + 60, $y);

    // Columna: Fecha y Hora
    $pdf->Cell(35, $rowHeight, $fechaHora, 1, 1, 'C'); // Mueve a la siguiente línea
}

// Generar el nombre del archivo
$fechaHora = date("d-m-Y_H-i-s");
$nombreArchivo = "Reportes Obsoletos - ARKOVA en " . $fechaHora . ".pdf";
$nombreArchivo = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombreArchivo);

// Salida del PDF
$pdf->Output('I', $nombreArchivo);

// Registrar en auditoría
require '../config/database.php';
$username = $_SESSION['user_name'];
$fecha = date("Y-m-d H:i:s");
$sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES ('$username', '$fecha', 'El usuario [$username] generó un informe de los Reportes Obsoletos en formato PDF')";
mysqli_query($conn, $sql_aud);
mysqli_close($conn);
?>