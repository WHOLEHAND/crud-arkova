<?php 
require '../config/database.php';
session_start();

// Inicializar la respuesta
$response = [
    'error' => false,
    'message' => '',
    'reload' => false
];

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se recibió el ID
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Primero, obtenemos el estado actual del usuario y el nombre
        $sql = "SELECT state_user, user_name FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentState = $row['state_user'];
            $userName = $row['user_name'];

            // Cambiamos el estado (0 <-> 1)
            $newState = $currentState == 0 ? 1 : 0;

            // Ejecutar la consulta para inhabilitar o habilitar el usuario
            $sqlUpdate = "UPDATE users SET state_user = ? WHERE id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("ii", $newState, $id);

            if ($stmtUpdate->execute()) {
                // Registrar acción de auditoría
                $fecha = date("Y-m-d H:i:s");
                $username = $_SESSION['user_name']; // Suponiendo que el nombre de usuario está en la sesión

                // Mensaje de auditoría
                $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
                $stmt_auditoria = $conn->prepare($sql_aud);
                $accion = "El usuario [$username] ha " . ($newState == 1 ? "habilitado" : "inhabilitado") . " el perfil llamado '$userName'";
                $stmt_auditoria->bind_param("sss", $username, $fecha, $accion);
                $stmt_auditoria->execute();
                $stmt_auditoria->close();

                // Respuesta exitosa
                $response['message'] = "El usuario '$userName' ha sido " . ($newState == 1 ? "habilitado" : "inhabilitado") . " exitosamente.";
                $response['reload'] = true;
            } else {
                $response['error'] = true;
                $response['message'] = "Error al actualizar el estado del usuario: " . $stmtUpdate->error;
            }

            $stmtUpdate->close();
        } else {
            $response['error'] = true;
            $response['message'] = "No se encontró el usuario con el ID proporcionado.";
        }

        $stmt->close();
    } else {
        $response['error'] = true;
        $response['message'] = "ID no recibido.";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Método de solicitud no válido.";
}

// Cerrar conexión
$conn->close();

// Enviar respuesta en formato JSON
echo json_encode($response);
exit();
?>