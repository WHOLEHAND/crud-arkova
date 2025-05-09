<?php
session_start();
require '../config/database.php';

// Captura de datos del formulario
$tipo_reporte = $conn->real_escape_string($_POST['tipo_reporte']);
$nombre = $conn->real_escape_string($_POST['nombre']);
$descripcion = $conn->real_escape_string($_POST['descripcion']);
$datetime = $conn->real_escape_string($_POST['datetime']);

// Inicializar la respuesta
$response = [
    'error' => false,
    'message' => '',
    'reload' => false
];

// Validación del tipo de reporte en la tabla report_type
$checkSql = "SELECT id FROM report_type WHERE id = '$tipo_reporte'";
$result = $conn->query($checkSql);

if ($result->num_rows > 0) {
    // Asignación de valores adicionales
    $state_report = 1;
    $id_user = $_SESSION['user_id']; // Asegúrate de que la sesión contenga el id_user del usuario logeado

    // VALIDACIONES GENERALES
    if (empty($tipo_reporte) || empty($nombre) || empty($descripcion) || empty($datetime)) {
        $response['error'] = true;
        $response['message'] = "Todos los campos son obligatorios.";
    } elseif (strlen($nombre) < 7 || strlen($nombre) > 90) {
        $response['error'] = true;
        $response['message'] = "El nombre debe tener entre 7 y 90 caracteres.";
    } elseif (strlen($descripcion) < 20 || strlen($descripcion) > 300) {
        $response['error'] = true;
        $response['message'] = "La descripción debe tener entre 20 y 300 caracteres.";
    } else {
        // Inserción de datos en la tabla reports
        $sql = "INSERT INTO reports (id_report_type, name, description, date, state_report, id_user)
                VALUES ('$tipo_reporte', '$nombre', '$descripcion', '$datetime', '$state_report', '$id_user')";

        if ($conn->query($sql)) {
            $report_id = $conn->insert_id;

            // Verificación y guardado de la imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $image = $_FILES['imagen'];
                $allowedTypes = ['image/jpeg', 'image/jpg'];

                if (in_array($image['type'], $allowedTypes)) {
                    $destination = "../assets/img/reports/{$report_id}.jpg";
                    if (!move_uploaded_file($image['tmp_name'], $destination)) {
                        $response['error'] = true;
                        $response['message'] = "Reporte guardado, pero no se pudo guardar la imagen.";
                    }
                } else {
                    $response['error'] = true;
                    $response['message'] = "Formato de imagen no permitido. Use JPG.";
                }
            }

            // Registrar acción de auditoría
            $fecha = date("Y-m-d H:i:s");
            $username = $_SESSION['user_name'];

            // Obtener el nombre del tipo de reporte para la auditoría
            $sql_tipo_reporte = "SELECT name FROM report_type WHERE id = ?";
            $stmt_tipo = $conn->prepare($sql_tipo_reporte);
            $stmt_tipo->bind_param("i", $tipo_reporte);
            $stmt_tipo->execute();
            $stmt_tipo->bind_result($tipo_reporte_nombre);
            $stmt_tipo->fetch();
            $stmt_tipo->close();

            if (!$tipo_reporte_nombre) {
                $tipo_reporte_nombre = 'Desconocido'; // Evitar errores si no se encuentra el nombre
            }

            // Mensaje de auditoría
            $accion = "El usuario [$username] creó un nuevo reporte del tipo '$tipo_reporte_nombre' con el nombre '$nombre'";

            // Insertar en la tabla de auditoría
            $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
            $stmt_auditoria = $conn->prepare($sql_aud);
            $stmt_auditoria->bind_param("sss", $username, $fecha, $accion);
            $stmt_auditoria->execute();
            $stmt_auditoria->close();
        } else {
            $response['error'] = true;
            $response['message'] = "Error al guardar el reporte: " . $conn->error;
        }
    }
} else {
    $response['error'] = true;
    $response['message'] = "Tipo de reporte no válido.";
}

// Respuesta final: si no hubo errores, se envía "Reporte cargado exitosamente"
if (!$response['error']) {
    $response['message'] = "Reporte cargado exitosamente.";
    $response['reload'] = true; // Indicar al frontend que debe refrescar la página
}

$conn->close();
echo json_encode($response);
exit;
?>