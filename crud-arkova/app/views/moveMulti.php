<?php
require '../config/database.php';
session_start();

if (isset($_POST['selected_ids'])) {
    $selected_ids = explode(',', $_POST['selected_ids']);
    error_log(print_r($selected_ids, true)); // Para depuración

    // Empezamos una transacción para asegurar que todas las operaciones de actualización se realicen juntas
    $conn->begin_transaction();

    try {
        $sqlGetState = "SELECT id, state_report, name FROM reports WHERE id = ?";
        $sqlUpdateState = "UPDATE reports SET state_report = ? WHERE id = ?";
        $sqlAuditory = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";

        $stmtGetState = $conn->prepare($sqlGetState);
        $stmtUpdateState = $conn->prepare($sqlUpdateState);
        $stmtAuditory = $conn->prepare($sqlAuditory);

        $username = $_SESSION['user_name']; // Usuario actual de la sesión
        $fecha = date("Y-m-d H:i:s");

        foreach ($selected_ids as $id) {
            // Obtener el estado actual y el nombre del reporte
            $stmtGetState->bind_param("i", $id);
            $stmtGetState->execute();
            $result = $stmtGetState->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $currentState = $row['state_report'];
                $reportName = $row['name'];

                // Cambiar el estado: 0 <-> 1
                $newState = $currentState == 0 ? 1 : 0;

                // Actualizar el estado del reporte
                $stmtUpdateState->bind_param("ii", $newState, $id);
                $stmtUpdateState->execute();

                // Registrar acción de auditoría
                $accion = $newState == 1 
                    ? "El usuario [$username] restauró el reporte '$reportName'." 
                    : "El usuario [$username] archivó el reporte '$reportName'.";
                $stmtAuditory->bind_param("sss", $username, $fecha, $accion);
                $stmtAuditory->execute();
            } else {
                throw new Exception("No se encontró el registro con ID: $id");
            }
        }

        // Si todo se ejecuta correctamente, confirmamos la transacción
        $conn->commit();
        $_SESSION['msg'] = "Reportes actualizados con éxito.";
    } catch (Exception $e) {
        // Si ocurre un error, revertimos los cambios
        $conn->rollback();
        $_SESSION['msg'] = "Error al actualizar los reportes: " . $e->getMessage();
        error_log($e->getMessage());
    }

    // Cerramos las declaraciones
    $stmtGetState->close();
    $stmtUpdateState->close();
    $stmtAuditory->close();
}

// Captura la URL de redirección
$redirectUrl = isset($_POST['redirect']) ? $_POST['redirect'] : '/crud-arkova/app/views/current_reports.php';

// Redirigir a la URL de origen
header("Location: " . $redirectUrl);
exit;
?>