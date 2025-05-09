<?php
require '../config/database.php';
session_start();

if (isset($_POST['selected_ids'])) {
    $selected_ids = explode(',', $_POST['selected_ids']);
    error_log(print_r($selected_ids, true)); // Para depuración

    // Empezamos una transacción para asegurar que todas las operaciones de actualización se realicen juntas
    $conn->begin_transaction();

    try {
        $sqlGetState = "SELECT id, user_name, state_user FROM users WHERE id = ?";
        $sqlUpdateState = "UPDATE users SET state_user = ? WHERE id = ?";
        $sqlInsertAudit = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";

        $stmtGetState = $conn->prepare($sqlGetState);
        $stmtUpdateState = $conn->prepare($sqlUpdateState);
        $stmtInsertAudit = $conn->prepare($sqlInsertAudit);

        // Recorremos todos los usuarios seleccionados
        foreach ($selected_ids as $id) {
            // Obtener el estado actual del usuario y su nombre
            $stmtGetState->bind_param("i", $id);
            $stmtGetState->execute();
            $result = $stmtGetState->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $currentState = $row['state_user'];
                $userName = $row['user_name'];

                // Cambiar el estado: 0 <-> 1
                $newState = $currentState == 0 ? 1 : 0;

                // Actualizar el estado del usuario
                $stmtUpdateState->bind_param("ii", $newState, $id);
                $stmtUpdateState->execute();

                // Registrar la acción en la auditoría
                $fecha = date("Y-m-d H:i:s");
                $username = $_SESSION['user_name']; // Suponiendo que el nombre de usuario está en la sesión

                // Definir la acción para la auditoría
                $accion = "El usuario [$username] ha " . ($newState == 1 ? "habilitado" : "inhabilitado") . " el perfil llamado '$userName'";

                // Insertar registro de auditoría
                $stmtInsertAudit->bind_param("sss", $username, $fecha, $accion);
                $stmtInsertAudit->execute();
            } else {
                throw new Exception("No se encontró el registro con ID: $id");
            }
        }

        // Si todo se ejecuta correctamente, confirmamos la transacción
        $conn->commit();
        $_SESSION['msg'] = "Usuarios actualizados con éxito.";
    } catch (Exception $e) {
        // Si ocurre un error, revertimos los cambios
        $conn->rollback();
        $_SESSION['msg'] = "Error al actualizar los usuarios: " . $e->getMessage();
        error_log($e->getMessage());
    }

    // Cerramos las declaraciones
    $stmtGetState->close();
    $stmtUpdateState->close();
    $stmtInsertAudit->close();
}

// Captura la URL de redirección
$redirectUrl = isset($_POST['redirect']) ? $_POST['redirect'] : '/crud-arkova/app/views/users.php';

// Redirigir a la URL de origen
header("Location: " . $redirectUrl);
exit;
?>