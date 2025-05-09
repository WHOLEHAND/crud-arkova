<?php
session_start();
require '../config/database.php'; // Incluye la conexión a la base de datos
require '../libs/vendor/autoload.php'; // Incluye la librería PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Consulta SQL para obtener los reportes activos
$sqlReports = "SELECT r.id_report_type, r.name, r.description, r.date, rt.name AS rt 
               FROM reports AS r
               INNER JOIN report_type AS rt ON r.id_report_type = rt.id
               WHERE r.state_report = 1"; // Solo selecciona reportes activos

$resultado = mysqli_query($conn, $sqlReports) or die("Error al consultar Reportes Vigentes: " . mysqli_error($conn));

// Crear un nuevo objeto de hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezado principal
$fecha = date("d-m-Y");
$hora = date("H:i:s");
$sheet->mergeCells('A1:D1');
$sheet->setCellValue('A1', 'Informe de Reportes Vigentes en ' . $fecha . ' a las ' . $hora);
$sheet->getStyle('A1')->applyFromArray([
    'font' => [
        'name' => 'Arial',
        'bold' => true,
        'size' => 14,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '000000'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ]
]);

// Encabezados de la tabla
$headers = ['Tipo de Reporte', 'Nombre del Reporte', 'Descripción', 'Fecha y Hora'];
$columnIndex = 'A';
$rowIndex = 3;

foreach ($headers as $header) {
    $sheet->setCellValue($columnIndex . $rowIndex, $header);
    $sheet->getStyle($columnIndex . $rowIndex)->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'bold' => true,
            'size' => 12,
            'color' => ['rgb' => 'FFFFFF'],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4F4E4D'],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ]
        ]
    ]);
    $sheet->getColumnDimension($columnIndex)->setAutoSize(true);
    $columnIndex++;
}

// Relleno de los datos
$rowIndex = 4;

while ($row = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $rowIndex, $row['rt']);
    $sheet->setCellValue('B' . $rowIndex, $row['name']);
    $sheet->setCellValue('C' . $rowIndex, $row['description']);
    $sheet->setCellValue('D' . $rowIndex, date("d-m-Y H:i", strtotime($row['date'])));

    // Estilo de las celdas
    $sheet->getStyle("A$rowIndex:D$rowIndex")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ]
        ]
    ]);
    $rowIndex++;
}

// Guardar el archivo Excel
$fechaHora = date("d-m-Y_H-i-s");
$nombreArchivo = "Reportes Vigentes - ARKOVA en $fechaHora.xlsx";

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
$writer->save('php://output');

// Registrar en auditoría
$username = $_SESSION['user_name'];
$fecha = date("Y-m-d H:i:s");
$sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES ('$username', '$fecha', 'El usuario [$username] generó un informe de los Reportes Vigentes en formato Excel')";
mysqli_query($conn, $sql_aud);
mysqli_close($conn);
?>