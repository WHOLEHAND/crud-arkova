<?php
session_start();
require '../config/database.php';
require '../libs/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Consulta SQL
$sql_types = "SELECT name FROM report_type";
$resultado = mysqli_query($conn, $sql_types) or die("Error al consultar Tipos de Reporte: " . mysqli_error($conn));

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezado principal
$fecha = date("d-m-Y");
$hora = date("H:i:s");
$sheet->mergeCells('A1:G1');
$sheet->setCellValue('A1', 'Informe de Tipos de Reporte en ' . $fecha . ' a las ' . $hora);
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

// Encabezado de la tabla
$sheet->mergeCells('A3:G3');
$sheet->setCellValue('A3', 'Nombre');
$sheet->getStyle('A3:G3')->applyFromArray([
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

// Cuerpo de la tabla
$rowNumber = 4;
while ($row_report_type = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
    $nombre_tipo = $row_report_type['name'];
    $sheet->mergeCells('A' . $rowNumber . ':G' . $rowNumber); // Combina las celdas de A hasta G
    $sheet->setCellValue('A' . $rowNumber, $nombre_tipo);
    $sheet->getStyle('A' . $rowNumber . ':G' . $rowNumber)->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'size' => 12,
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
    $rowNumber++;
}

// Ajustar ancho de columna
$sheet->getColumnDimension('A')->setWidth(50);

// Guardar el archivo
$writer = new Xlsx($spreadsheet);
$filename = 'Tipos_de_Reporte_ARKOVA_' . date("d-m-Y_H-i-s") . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

// Registro de auditoría
$username = $_SESSION['user_name'];
$fecha = date("Y-m-d H:i:s");
$sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES ('$username', '$fecha', 'El usuario [$username] generó un informe general de Tipo de Reportes en formato Excel')";
mysqli_query($conn, $sql_aud);

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>