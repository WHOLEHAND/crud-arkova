<?php
session_start();
require '../config/database.php';
header('Content-Type: application/json'); // Definir que la respuesta es JSON

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if (empty($username) || empty($password)) {
        $response['error'] = true;
        $response['message'] = "Por favor, complete todos los campos.";
        echo json_encode($response);
        exit();
    }

    $sql = "SELECT id, user_name, password, level_user, state_user FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($user['state_user'] == 0) {
            $response['error'] = true;
            $response['message'] = "Su usuario ha sido inhabilitado.";
            echo json_encode($response);
            exit();
        }

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['level_user'] = $user['level_user'];

            $fecha = date("Y-m-d H:i:s");
            $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
            $stmt_auditoria = mysqli_prepare($conn, $sql_aud);
            $accion = "El usuario [$username] inició sesión como usuario";
            mysqli_stmt_bind_param($stmt_auditoria, "sss", $username, $fecha, $accion);
            mysqli_stmt_execute($stmt_auditoria);
            mysqli_stmt_close($stmt_auditoria);

            $response['error'] = false;
            $response['message'] = "Inicio de sesión exitoso.";
            $response['redirect'] = "/crud-arkova/app/index.php";
            echo json_encode($response);
            exit();
        } else {
            $response['error'] = true;
            $response['message'] = "Contraseña incorrecta.";
            echo json_encode($response);
            exit();
        }
    } else {
        $response['error'] = true;
        $response['message'] = "El usuario no existe.";
        echo json_encode($response);
        exit();
    }
}
?>