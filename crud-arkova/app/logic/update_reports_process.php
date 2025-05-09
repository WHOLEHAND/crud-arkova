<?php
require '../config/database.php';
session_start();

$id = $conn->real_escape_string($_POST['id']);
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

// Normalizar el formato de la fecha ingresada
$datetime = str_replace("T", " ", $datetime);

// Validaciones generales
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
    // Verificar si hay un cambio en la imagen
    $imageChanged = false;
    $newImagePath = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $image = $_FILES['imagen'];
        $allowedTypes = ['image/jpeg', 'image/jpg'];

        if (!in_array($image['type'], $allowedTypes)) {
            $response['error'] = true;
            $response['message'] = "Formato de imagen no permitido. Use JPG o JPEG.";
        } else {
            $destination = "../assets/img/reports/{$id}.jpg";
            // Intentar mover el archivo
            if (move_uploaded_file($image['tmp_name'], $destination)) {
                // Si el archivo se mueve correctamente
                $imageChanged = true;
                $response['message'] = "La imagen ha sido actualizada correctamente.";
                $response['reload'] = true;
            } else {
                // Si ocurre un error al mover el archivo
                $response['error'] = true;
                $response['message'] = "No se pudo guardar la imagen. Verifique los permisos de la carpeta.";
            }
        }
    }

    if (!$response['error']) {
        // Obtener datos actuales del reporte
        $sqlGetCurrent = "SELECT id_report_type, name, description, date FROM reports WHERE id = ?";
        $stmtGetCurrent = $conn->prepare($sqlGetCurrent);
        $stmtGetCurrent->bind_param("i", $id);
        $stmtGetCurrent->execute();
        $resultCurrent = $stmtGetCurrent->get_result();

        if ($resultCurrent->num_rows > 0) {
            $currentData = $resultCurrent->fetch_assoc();

            // Obtener nombres del tipo de reporte
            $sqlTypeNames = "SELECT id, name FROM report_type WHERE id IN (?, ?)";
            $stmtTypeNames = $conn->prepare($sqlTypeNames);
            $stmtTypeNames->bind_param("ii", $currentData['id_report_type'], $tipo_reporte);
            $stmtTypeNames->execute();
            $resultTypeNames = $stmtTypeNames->get_result();
            $typeNames = [];
            while ($row = $resultTypeNames->fetch_assoc()) {
                $typeNames[$row['id']] = $row['name'];
            }

            // Normalizar las fechas para comparar
            $currentDate = substr($currentData['date'], 0, 16);
            $submittedDate = substr($datetime, 0, 16);

            // Verificar cambios
            $changes = [];
            if ($currentData['id_report_type'] != $tipo_reporte) {
                $currentTypeName = $typeNames[$currentData['id_report_type']] ?? "Desconocido";
                $newTypeName = $typeNames[$tipo_reporte] ?? "Desconocido";
                $changes[] = "Tipo de reporte: pasó de '$currentTypeName' a '$newTypeName'";
            }
            if ($currentData['name'] != $nombre) {
                $changes[] = "Nombre: pasó de '{$currentData['name']}' a '$nombre'";
            }
            if ($currentData['description'] != $descripcion) {
                $changes[] = "Descripción: pasó de '{$currentData['description']}' a '$descripcion'";
            }
            if ($currentDate != $submittedDate) {
                $changes[] = "Fecha: pasó de '{$currentDate}' a '$submittedDate'";
            }

            // Si hubo cambios en la imagen
            if ($imageChanged) {
                $changes[] = "La imagen del reporte fue actualizada.";
            }

            // Si hubo cambios, realizar la actualización
            if (!empty($changes) && !$response['error']) {
                $sqlUpdate = "UPDATE reports SET id_report_type = ?, name = ?, description = ?, date = ? WHERE id = ?";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bind_param("isssi", $tipo_reporte, $nombre, $descripcion, $datetime, $id);

                if ($stmtUpdate->execute()) {
                    // Auditoría
                    $username = $_SESSION['user_name'];
                    $fecha = date("Y-m-d H:i:s");
                    $changesListStr = implode(", ", $changes);
                    $accion = "El usuario [$username] ha realizado los siguientes cambios en el reporte '$nombre': $changesListStr.";

                    $sqlAuditory = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
                    $stmtAuditory = $conn->prepare($sqlAuditory);
                    $stmtAuditory->bind_param("sss", $username, $fecha, $accion);
                    $stmtAuditory->execute();

                    $response['message'] = "Reporte actualizado exitosamente.";
                    $response['reload'] = true;
                } else {
                    $response['error'] = true;
                    $response['message'] = "Error al actualizar el reporte: " . $stmtUpdate->error;
                }
            } elseif (empty($changes)) {
                // Sin cambios
                $username = $_SESSION['user_name'];
                $fecha = date("Y-m-d H:i:s");
                $accion = "El usuario [$username] intentó editar el reporte '$nombre', pero no se realizaron cambios.";

                $sqlAuditory = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
                $stmtAuditory = $conn->prepare($sqlAuditory);
                $stmtAuditory->bind_param("sss", $username, $fecha, $accion);
                $stmtAuditory->execute();

                $response['error'] = true;
                $response['message'] = "No se realizaron cambios en el reporte.";
            }
        } else {
            $response['error'] = true;
            $response['message'] = "Reporte no encontrado.";
        }

        $stmtGetCurrent->close();
    }
}

echo json_encode($response);
exit();
?>