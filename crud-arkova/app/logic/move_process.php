<?php
session_start();
require '../config/database.php';

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se recibió el ID
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $redirectUrl = isset($_POST['redirect']) ? $_POST['redirect'] : '/crud-arkova/app/views/current_reports.php'; // URL por defecto

        // Primero, obtenemos el estado actual del reporte
        $sql = "SELECT state_report, name FROM reports WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentState = $row['state_report'];
            $reportName = $row['name']; // Nombre del reporte

            // Cambiamos el estado (0 <-> 1)
            $newState = $currentState == 0 ? 1 : 0;

            // Ejecutar la consulta para archivar el registro
            $sqlUpdate = "UPDATE reports SET state_report = ? WHERE id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("ii", $newState, $id);

            if ($stmtUpdate->execute()) {
                // Si la ejecución es exitosa, registrar la acción en auditoría
                $fecha = date("Y-m-d H:i:s");
                $username = $_SESSION['user_name']; // Usuario actual
                $accion = $newState == 1 
                    ? "El usuario [$username] restauró el reporte '$reportName'."
                    : "El usuario [$username] archivó el reporte '$reportName'.";

                $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
                $stmt_auditoria = $conn->prepare($sql_aud);
                $stmt_auditoria->bind_param("sss", $username, $fecha, $accion);
                $stmt_auditoria->execute();
                $stmt_auditoria->close();

                // Mensaje de éxito
                $_SESSION['msg'] = "El registro ha sido actualizado exitosamente.";
            } else {
                $_SESSION['msg'] = "Error al actualizar el registro: " . $stmtUpdate->error;
            }

            $stmtUpdate->close();
        } else {
            $_SESSION['msg'] = "No se encontró el registro con el ID proporcionado.";
        }

        $stmt->close();
    } else {
        $_SESSION['msg'] = "ID no recibido.";
    }

    // Redirigir a la URL de origen
    header("Location: " . $redirectUrl);
    exit();
}
?>