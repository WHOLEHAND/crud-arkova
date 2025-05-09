<?php
// edit_user_process.php

// Incluye la conexión a la base de datos
require '../config/database.php';
session_start();

// Inicializar la respuesta
$response = [
    'error' => false,
    'message' => ''
];

// Verifica si se recibieron los datos necesarios
if (
    isset($_POST['id'], $_POST['user_name'], $_POST['names'], $_POST['last_names'],
    $_POST['identity_card'], $_POST['email'], $_POST['level_user'])
) {
    // Escapa los datos para evitar inyección SQL
    $user_id = mysqli_real_escape_string($conn, $_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['user_name']);
    $names = mysqli_real_escape_string($conn, $_POST['names']);
    $last_names = mysqli_real_escape_string($conn, $_POST['last_names']);
    $identity_card = mysqli_real_escape_string($conn, $_POST['identity_card']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['level_user']);

    // Verifica si se proporcionó una nueva contraseña
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validaciones:
    // Validar que los campos no estén vacíos
    $requiredFields = ['user_name', 'names', 'last_names', 'identity_card', 'email', 'level_user'];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            $response['error'] = true;
            $response['message'] = "Todos los campos son obligatorios.";
            echo json_encode($response);
            exit;
        }
    }

    // Validar si el nombre de usuario ya existe
    $sql_username = "SELECT user_name FROM users WHERE user_name = ? AND id != ?";
    $stmt_username = $conn->prepare($sql_username);
    $stmt_username->bind_param("si", $username, $user_id);
    $stmt_username->execute();
    $stmt_username->store_result();
    if ($stmt_username->num_rows > 0) {
        $response['error'] = true;
        $response['message'] = "El nombre de usuario ya está registrado.";
        echo json_encode($response);
        $stmt_username->close();
        $conn->close();
        exit;
    }
    $stmt_username->close();

    // Validar nombres y apellidos
    if (strlen($names) < 3 || strlen($names) > 25 || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $names)) {
        $response['error'] = true;
        $response['message'] = "El nombre debe tener entre 3 y 25 caracteres y solo contener letras y espacios.";
        echo json_encode($response);
        $conn->close();
        exit;
    }
    if (strlen($last_names) < 2 || strlen($last_names) > 25 || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $last_names)) {
        $response['error'] = true;
        $response['message'] = "El apellido debe tener entre 2 y 25 caracteres y solo contener letras y espacios.";
        echo json_encode($response);
        $conn->close();
        exit;
    }

    // Validar cédula de identidad
    if (strlen($identity_card) < 7 || !ctype_digit($identity_card)) {
        $response['error'] = true;
        $response['message'] = "La cédula debe tener al menos 7 caracteres y solo contener números.";
        echo json_encode($response);
        $conn->close();
        exit;
    }
    $sql_identity_card = "SELECT identity_card FROM users WHERE identity_card = ? AND id != ?";
    $stmt_identity_card = $conn->prepare($sql_identity_card);
    $stmt_identity_card->bind_param("si", $identity_card, $user_id);
    $stmt_identity_card->execute();
    $stmt_identity_card->store_result();
    if ($stmt_identity_card->num_rows > 0) {
        $response['error'] = true;
        $response['message'] = "La cédula ya está registrada.";
        echo json_encode($response);
        $stmt_identity_card->close();
        $conn->close();
        exit;
    }
    $stmt_identity_card->close();

    // Validar correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error'] = true;
        $response['message'] = "El correo no tiene un formato válido.";
        echo json_encode($response);
        $conn->close();
        exit;
    }
    $sql_email = "SELECT email FROM users WHERE email = ? AND id != ?";
    $stmt_email = $conn->prepare($sql_email);
    $stmt_email->bind_param("si", $email, $user_id);
    $stmt_email->execute();
    $stmt_email->store_result();
    if ($stmt_email->num_rows > 0) {
        $response['error'] = true;
        $response['message'] = "El correo ya está registrado.";
        echo json_encode($response);
        $stmt_email->close();
        $conn->close();
        exit;
    }
    $stmt_email->close();

    // Validar contraseña si se proporcionó una nueva
    if ($password !== '') {
        // Validar la longitud de caracteres en la contraseña
        if (strlen($password) < 5) {
            $response['error'] = true;
            $response['message'] = "La contraseña debe tener al menos 5 caracteres.";
            echo json_encode($response);
            $conn->close();
            exit;
        }

        // Validar que las contraseñas ingresadas coincidan
        if ($password !== $confirm_password) {
            $response['error'] = true;
            $response['message'] = "Las contraseñas no coinciden.";
            echo json_encode($response);
            $conn->close();
            exit;
        }
    }

    // Comparar datos antiguos para registrar auditoría
    $sqlGetUser = "SELECT user_name, names, last_names, identity_card, email, level_user, password FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sqlGetUser);
    $oldData = mysqli_fetch_assoc($result);

    $changes = [];
    if ($username !== $oldData['user_name']) $changes['user_name'] = [$oldData['user_name'], $username];
    if ($names !== $oldData['names']) $changes['names'] = [$oldData['names'], $names];
    if ($last_names !== $oldData['last_names']) $changes['last_names'] = [$oldData['last_names'], $last_names];
    if ($identity_card !== $oldData['identity_card']) $changes['identity_card'] = [$oldData['identity_card'], $identity_card];
    if ($email !== $oldData['email']) $changes['email'] = [$oldData['email'], $email];
    if ($role !== $oldData['level_user']) {
        $roleMapping = ['0' => 'Administrador', '1' => 'Técnico'];
        $changes['role'] = [$roleMapping[$oldData['level_user']], $roleMapping[$role]];
    }

    // Construir la consulta de actualización
    $updatePassword = $password !== '' ? ", password = '" . password_hash($password, PASSWORD_DEFAULT) . "'" : '';
    $sql = "UPDATE users SET user_name = '$username', names = '$names', last_names = '$last_names', 
            identity_card = '$identity_card', email = '$email', level_user = '$role' $updatePassword WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        // Formatear mensaje de auditoría
        $usernameAdmin = $_SESSION['user_name'];

        // Comprobar si hay cambios
        if (!empty($changes)) {
            // Si hubo cambios, procesamos la lista de cambios
            $changesList = [];
            foreach ($changes as $key => $value) {
                // Mapear las claves a nombres más legibles (opcional si las claves no son claras)
                $keyMapping = [
                    'user_name' => 'Nombre de usuario',
                    'names' => 'Nombres',
                    'last_names' => 'Apellidos',
                    'identity_card' => 'Cédula de Identidad',
                    'email' => 'Correo electrónico',
                    'role' => 'Rol'
                ];
                $fieldName = $keyMapping[$key] ?? ucfirst($key); // Usar el nombre mapeado o el original
                $changesList[] = "$fieldName pasó de '{$value[0]}' a '{$value[1]}'";
            }
            $changesListStr = implode(", ", $changesList);

            // Mensaje de auditoría para cambios realizados
            $auditMessage = "El usuario [$usernameAdmin] ha realizado los siguientes cambios en el perfil de usuario '$username': $changesListStr.";
        } else {
            // Mensaje de auditoría si no se realizaron cambios
            $auditMessage = "El usuario [$usernameAdmin] intentó editar el perfil de '$username' pero no realizó ningún cambio.";
        }

        // Registrar mensaje de auditoría en la base de datos
        $auditSql = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES ('$usernameAdmin', NOW(), '" . mysqli_real_escape_string($conn, $auditMessage) . "')";
        mysqli_query($conn, $auditSql);

        // Mensaje si la consulta de actualización es correcta.
        $response['message'] = "Usuario actualizado exitosamente.";
        echo json_encode($response);
    } else {
        // Si la consulta de actualización falla
        $response['error'] = true;
        $response['message'] = "Error al actualizar los datos del usuario.";
        echo json_encode($response);
    }

    // Cerrar conexiones
    $conn->close();
} else {
    $response['error'] = true;
    $response['message'] = "Datos incompletos.";
    echo json_encode($response);
}
?>