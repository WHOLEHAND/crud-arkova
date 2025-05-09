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

// Consulta SQL para obtener los usuarios Inhabilitados
$sqlUsers = "SELECT user_name, names, last_names, identity_card, email, 
                CASE 
                    WHEN level_user = 0 THEN 'Administrador' 
                    WHEN level_user = 1 THEN 'Técnico' 
                    ELSE 'Desconocido' 
                END AS role
             FROM users
             WHERE state_user = 0"; // Solo selecciona usuarios Inhabilitados

$resultado = mysqli_query($conn, $sqlUsers) or die("Error al consultar Usuarios Inhabilitados: " . mysqli_error($conn));

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezado principal
$fecha = date("d-m-Y");
$hora = date("H:i:s");
$sheet->mergeCells('A1:F1');
$sheet->setCellValue('A1', 'Informe de Usuarios Inhabilitados en ' . $fecha . ' a las ' . $hora);
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
$headers = ['Usuario', 'Nombres', 'Apellidos', 'Cédula', 'Correo', 'Rol'];
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

// Cuerpo de la tabla
$rowNumber = 4;
while ($row = mysqli_fetch_assoc($resultado)) {
    $columnIndex = 'A';
    foreach ($row as $cellValue) {
        $sheet->setCellValue($columnIndex . $rowNumber, $cellValue);
        $sheet->getStyle($columnIndex . $rowNumber)->applyFromArray([
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
        $columnIndex++;
    }
    $rowNumber++;
}

// Guardar el archivo
$writer = new Xlsx($spreadsheet);
$filename = 'Usuarios_Inhabilitados_ARKOVA_' . date("d-m-Y_H-i-s") . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

// Registro de auditoría
$username = $_SESSION['user_name'];
$fecha = date("Y-m-d H:i:s");
$sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES ('$username', '$fecha', 'El usuario [$username] generó un informe de Usuarios Inhabilitados en formato Excel')";
mysqli_query($conn, $sql_aud);

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>