<?php
session_start();

// Incluir la librería FPDF
require "../libs/fpdf/fpdf.php";

// Verificar si la solicitud tiene la imagen en el POST
if (isset($_POST['image'])) {
    $imgData = $_POST['image'];

    // Decodificar la imagen Base64
    $imgData = str_replace('data:image/png;base64,', '', $imgData);
    $imgData = str_replace(' ', '+', $imgData);
    $data = base64_decode($imgData);

    // Guardar la imagen temporalmente
    $filePath = 'chart_image.png';
    file_put_contents($filePath, $data);

    // Generar un archivo temporal con el nombre del archivo
    $_SESSION['image_path'] = $filePath;
}

// Manejo de fechas en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir las fechas desde POST
    $_SESSION['start_date'] = isset($_POST['start_date']) ? $_POST['start_date'] : null;
    $_SESSION['end_date'] = isset($_POST['end_date']) ? $_POST['end_date'] : null;

    // Depuración: Log para verificar qué datos llegan
    //$logfile = 'debug_log.txt';
    //file_put_contents($logfile, "Start Date: " . ($_SESSION['start_date'] ?? 'null') . "\n", FILE_APPEND);
    //file_put_contents($logfile, "End Date: " . ($_SESSION['end_date'] ?? 'null') . "\n", FILE_APPEND);
}

// Si la URL tiene el parámetro 'generate', entonces se genera el PDF
if (isset($_GET['generate'])) {
    $start_date = isset($_SESSION['start_date']) ? $_SESSION['start_date'] : null;
    $end_date = isset($_SESSION['end_date']) ? $_SESSION['end_date'] : null;

    // Verificar y formatear fechas
    // Convertir las fechas al formato d-m-Y si están definidas
    $start_date_formatted = ($start_date) ? DateTime::createFromFormat('Y-m-d', $start_date)->format('d-m-Y') : 'Fecha no definida';
    $end_date_formatted = ($end_date) ? DateTime::createFromFormat('Y-m-d', $end_date)->format('d-m-Y') : 'Fecha no definida';
    //$start_date_formatted = $start_date ?? 'Fecha no definida';
    //$end_date_formatted = $end_date ?? 'Fecha no definida';

    if (isset($_SESSION['image_path'])) {
        $filePath = $_SESSION['image_path'];

        // Crear el PDF con FPDF
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
                $this->Write(5, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', '| Informe Gráfico de las Métricas de Rendimiento del Sistema en ' . $fecha . ' a las ' . $hora));
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
                // Autoría del documento
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

        // Agregar la imagen de la gráfica al PDF
        $pdf->Image($filePath, 10, 30, 180, 0, 'PNG'); // Ajusta posición y tamaño de la imagen

        // Agregar el texto de las fechas seleccionadas debajo de la imagen
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(10, 110); // Establecer la posición para el texto
        $pdf->MultiCell(0, 10, "Consulta realizada con los periodos de:\nFecha de Inicio: $start_date_formatted\nFecha de Fin: $end_date_formatted", 0, 'L');

        // Generar el nombre del archivo
        $fechaHora = date("d-m-Y _ H-i-s");
        $nombreArchivo = "Informe Gráfico de las Métricas de Rendimiento del Sistema - ARKOVA en " . $fechaHora . ".pdf";

        // Convertir a ISO-8859-1 para asegurar caracteres especiales
        $nombreArchivo = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombreArchivo);

        // Eliminar la imagen temporal
        unlink($filePath);

        // Establecer los encabezados para la salida del archivo PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $nombreArchivo . '"');

        // Salida del PDF con el nombre personalizado
        $pdf->Output('I', $nombreArchivo); // 'I' envía el archivo al navegador con el nombre especificado
    }

    // Cerrar la conexión a la base de datos
    require '../config/database.php';
    $username = $_SESSION['user'];
    $query = "DELETE FROM informes_grafica WHERE usuario = '$username';";
    $mysqli->query($query);
}
?>