<?php
session_start();
// Iniciar la sesión si no ha sido iniciada
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Comprobar si el usuario está autenticado
if (isset($_SESSION['user_id'])) {
    // Obtener el nombre de usuario desde la sesión
    $username = $_SESSION['user_name'];

    // Obtener la fecha y hora actual
    $fecha = date("Y-m-d H:i:s");

    // Conectar a la base de datos
    require '../config/database.php';

    // Construir la consulta de inserción para la auditoría
    $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
    $stmt_auditoria = mysqli_prepare($conn, $sql_aud);

    // Definir la acción de auditoría (el cierre de sesión)
    $accion = "El usuario [$username] cerró sesión";

    // Ejecutar la consulta de auditoría
    mysqli_stmt_bind_param($stmt_auditoria, "sss", $username, $fecha, $accion);
    mysqli_stmt_execute($stmt_auditoria);

    // Cerrar la consulta de auditoría
    mysqli_stmt_close($stmt_auditoria);

    // Destruir la sesión
    session_destroy();
}

// Redirigir al login
header("Location: /crud-arkova/app/views/login.php");
exit();
?>