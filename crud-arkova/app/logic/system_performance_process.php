<?php
// Incluir la conexión a la base de datos
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener las fechas del formulario
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;

    // Consultar los datos según las fechas proporcionadas
    if ($start_date && $end_date) {
        $query = "
            SELECT DATE(date) AS report_date, COUNT(*) AS total_reports
            FROM reports
            WHERE date BETWEEN ? AND ? AND state_report != 0
            GROUP BY report_date
            ORDER BY report_date ASC
        ";

        if ($stmt = $conn->prepare($query)) {
            // Enlazar las variables a la consulta preparada
            $stmt->bind_param("ss", $start_date, $end_date);

            // Ejecutar la consulta
            $stmt->execute();
            $result = $stmt->get_result();

            // Crear un array para almacenar los datos
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    'report_date' => $row['report_date'],
                    'total_reports' => $row['total_reports']
                ];
            }

            // Enviar los datos como respuesta JSON
            echo json_encode($data);
        } else {
            // Error al preparar la consulta
            echo json_encode(['error' => 'Error en la consulta']);
        }
    } else {
        echo json_encode(['error' => 'Fechas no válidas']);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}