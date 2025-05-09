<?php
session_start();
// Incluir la conexión a la base de datos
require '../config/database.php';

// Incluir la librería FPDF
require "../libs/fpdf/fpdf.php";

// Consulta SQL para obtener los usuarios activos
$sqlUsers = "SELECT user_name, names, last_names, identity_card, email, 
                    CASE 
                        WHEN level_user = 0 THEN 'Administrador' 
                        WHEN level_user = 1 THEN 'Técnico' 
                        ELSE 'Desconocido' 
                    END AS role
             FROM users
             WHERE state_user = 1"; // Solo selecciona usuarios activos

// Ejecutar la consulta y obtener los resultados
$resultado = mysqli_query($conn, $sqlUsers) or die("Error al consultar Usuarios Activos: " . mysqli_error($conn));

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
        $this->Write(5, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', '| Informe de Usuarios Activos en ' . $fecha . ' a las ' . $hora));
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
}

// Crear un nuevo PDF
$pdf = new PDF();
$pdf->SetCreator('ARKOVA v1.0');
$pdf->SetAuthor('A.C. BBVVA');
$pdf->AliasNbPages();
$pdf->AddPage('L', 'Letter'); // Configuración para hoja horizontal
$pdf->SetFont('Arial', '', 12);
$pdf->SetRightMargin(20);
$pdf->SetAutoPageBreak(true, 15);

// Títulos de la tabla
$pdf->SetFillColor(79, 78, 77);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(40, 10, 'Usuario', 1, 0, 'C', 1);
$pdf->Cell(45, 10, 'Nombres', 1, 0, 'C', 1);
$pdf->Cell(45, 10, 'Apellidos', 1, 0, 'C', 1);
$pdf->Cell(30, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Cédula'), 1, 0, 'C', 1);
$pdf->Cell(65, 10, 'Correo', 1, 0, 'C', 1);
$pdf->Cell(34, 10, 'Rol', 1, 1, 'C', 1);

// Relleno de los datos
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(255, 255, 255);

while ($row = mysqli_fetch_assoc($resultado)) {
    $userName = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['user_name']);
    $names = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['names']);
    $lastNames = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['last_names']);
    $identityCard = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['identity_card']);
    $email = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['email']);
    $role = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['role']);

    $pdf->Cell(40, 10, $userName, 1, 0, 'C');
    $pdf->Cell(45, 10, $names, 1, 0, 'C');
    $pdf->Cell(45, 10, $lastNames, 1, 0, 'C');
    $pdf->Cell(30, 10, $identityCard, 1, 0, 'C');
    $pdf->Cell(65, 10, $email, 1, 0, 'C');
    $pdf->Cell(34, 10, $role, 1, 1, 'C');
}

// Generar el nombre del archivo
$fechaHora = date("d-m-Y_H-i-s");
$nombreArchivo = "Usuarios Activos - ARKOVA en " . $fechaHora . ".pdf";
$nombreArchivo = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombreArchivo);

// Salida del PDF
$pdf->Output('I', $nombreArchivo);

// Registrar en auditoría
require '../config/database.php';
$username = $_SESSION['user_name'];
$fecha = date("Y-m-d H:i:s");
$sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES ('$username', '$fecha', 'El usuario [$username] generó un informe de Usuarios Activos en formato PDF')";
mysqli_query($conn, $sql_aud);
mysqli_close($conn);
?>