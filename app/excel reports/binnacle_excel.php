<?php
session_start();
require '../config/database.php';
require '../libs/vendor/autoload.php'; // Incluye la librería PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Consultar los datos de la tabla auditory
$sqlBinnacle = "SELECT id, aud_user, aud_registereddate, aud_action FROM auditory";
$binnacle = mysqli_query($conn, $sqlBinnacle) or die("Error al consultar la Auditoria: " . mysqli_error($conn));

// Crear el objeto de hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Bitácora del Sistema');

// Encabezado principal
$fecha = date("d-m-Y");
$hora = date("H:i:s");
$sheet->mergeCells('A1:D1');
$sheet->setCellValue('A1', 'Informe de Bitácora del Sistema en ' . $fecha . ' a las ' . $hora);
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
$headers = ['ID', 'Usuario', 'Fecha del Registro', 'Acción'];
$columnIndex = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($columnIndex . '3', $header);
    $sheet->getStyle($columnIndex . '3')->applyFromArray([
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

// Llenar los datos de la bitácora
$rowIndex = 4;
while ($row_binnacle = mysqli_fetch_array($binnacle, MYSQLI_ASSOC)) {
    $sheet->setCellValue('A' . $rowIndex, $row_binnacle['id']);
    $sheet->setCellValue('B' . $rowIndex, $row_binnacle['aud_user']);
    $sheet->setCellValue('C' . $rowIndex, $row_binnacle['aud_registereddate']);
    $sheet->setCellValue('D' . $rowIndex, $row_binnacle['aud_action']);
    $sheet->getStyle('A' . $rowIndex . ':D' . $rowIndex)->applyFromArray([
        'alignment' => [
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ]
        ]
    ]);
    $rowIndex++;
}

// Generar el archivo Excel
$fechaHora = date("d-m-Y_H-i-s");
$nombreArchivo = "Bitácora_del_Sistema_" . $fechaHora . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Cerrar la conexión
mysqli_close($conn);
?>