<?php
session_start();
require '../config/database.php';
require "../libs/fpdf/fpdf.php";

/**
 * Script para generar PDF con FPDF v1.86
 *
 * @author wholehand
 * @link https://github.com/WHOLEHAND
 * @license: MIT
 * 
 * Querido amigo programador:
 * 
 * Cuando escribí este código, sólo Dios, Chat GPT y yo
 * sabíamos cómo funcionaba.
 * Ahora, ¡solo Dios y Chat GPT lo saben!
 * 
 * Así que si está tratando de 'optimizar'
 * esta estructura y fracasa (seguramente),
 * por favor, incremente el siguiente contador
 * como una advertencia para el siguiente programador:
 * 
 * Total de horas perdidas aquí = 200
 * 
 */

$sqlBinnacle = "SELECT id, aud_user, aud_registereddate, aud_action FROM auditory";
$binnacle = mysqli_query($conn, $sqlBinnacle) or die("Error al consultar la Auditoria: " . mysqli_error($conn));
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
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(255, 255, 255);
        $this->Write(5, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', '| Informe de Bitácora del Sistema en ' . $fecha . ' a las ' . $hora));
        $this->Ln(20);
        $this->SetTextColor(0, 0, 0);
    }

    // Footer
    function Footer() {
        global $fecha;
        global $hora;
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
        return max(10, $nbLines * $lineHeight); // Altura mínima de 10
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

$pdf = new PDF();
$pdf->SetCreator('ARKOVA v1.0'); // Software o sistema que generó el PDF
$pdf->SetAuthor('A.C. BBVVA'); // Autor o entidad responsable del contenido
$pdf->AliasNbPages();
$pdf->AddPage('L', 'Letter');
$pdf->SetRightMargin(20);
$pdf->SetAutoPageBreak(true, 15);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->SetFillColor(79, 78, 77);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(15, 10, 'ID', 1, 0, 'C', 1);
$pdf->Cell(60, 10, 'Usuario', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Fecha del Registro', 1, 0, 'C', 1);
$pdf->Cell(135, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Acción efectuada'), 1, 0, 'C', 1);
$pdf->Ln();

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(255, 255, 255);

while ($row_binnacle = mysqli_fetch_array($binnacle, MYSQLI_ASSOC)) {
    $heightAction = $pdf->getRowHeight(iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row_binnacle['aud_action']), 135);
    $rowHeight = max(10, $heightAction);

    $pdf->Cell(15, $rowHeight, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row_binnacle['id']), 1, 0, 'C', 1);
    $pdf->Cell(60, $rowHeight, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row_binnacle['aud_user']), 1, 0, 'C', 1);
    $pdf->Cell(50, $rowHeight, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row_binnacle['aud_registereddate']), 1, 0, 'C', 1);

    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(135, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row_binnacle['aud_action']), 1, 'C', 1);
    $pdf->SetXY($x + 135, $y);

    $pdf->Ln($rowHeight);
}

// Generar la fecha y hora en el formato deseado
$fechaHora = date("d-m-Y _ H-i-s");
$nombreArchivo = "Bitácora del Sistema - ARKOVA en " . $fechaHora . ".pdf";

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
    $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES ('$username', '$fecha', 'El usuario [$username] generó un informe general de Bitácora del Sistema en formato PDF')";

    $auditoria = mysqli_query($conn, $sql_aud);

    // Cierra la conexión
    mysqli_close($conn);
?>