<?php
session_start();
// Conexión a la base de datos
require '../config/database.php';

// Inicializar la respuesta
$response = [
    'error' => false,
    'message' => ''
];

// Validar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar datos del formulario
    $name = trim($_POST["name"]);

    // Validar que el campo esté completo
    if (empty($name)) {
        $response['error'] = true;
        $response['message'] = "El campo es obligatorio.";
        echo json_encode($response);
        exit;
    }

    // Validar si el nombre de usuario ya existe
    $sql_name = "SELECT name FROM report_type WHERE name = ?";
    $stmt_name = $conn->prepare($sql_name);
    $stmt_name->bind_param("s", $name);
    $stmt_name->execute();
    $stmt_name->store_result();
    if ($stmt_name->num_rows > 0) {
        $response['error'] = true;
        $response['message'] = "El nombre del tipo de reporte ya existe en el sistema.";
        echo json_encode($response);
        $stmt_name->close();
        $conn->close();
        exit;
    }
    $stmt_name->close();

    // Validar nombre
    if (strlen($name) < 4 || strlen($name) > 50 || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $name)) {
        $response['error'] = true;
        $response['message'] = "El nombre debe tener entre 4 y 50 caracteres y solo contener letras y espacios.";
        echo json_encode($response);
        $conn->close();
        exit;
    }

    // Preparar la consulta SQL para insertar un tipo de reporte
    $sql = "INSERT INTO report_type (name)
            VALUES (?)";

    // Preparar la declaración para evitar inyecciones SQL
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $response['error'] = true;
        $response['message'] = "Error en la preparación de la consulta: " . $conn->error;
        echo json_encode($response);
        exit;
    }

    // Vincular los parámetros con los valores del formulario
    $stmt->bind_param("s", $name);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Registrar acción de auditoría
        $fecha = date("Y-m-d H:i:s"); 
        // Supongo que tienes la variable $username almacenada en la sesión
        $username = $_SESSION['user_name'];

        $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
        $stmt_auditoria = mysqli_prepare($conn, $sql_aud);
        $accion = "El usuario [$username] creó un nuevo tipo de reporte llamado '$name'";
        mysqli_stmt_bind_param($stmt_auditoria, "sss", $username, $fecha, $accion);
        mysqli_stmt_execute($stmt_auditoria);
        mysqli_stmt_close($stmt_auditoria);

        // Redirigir usuario si el registro es exitoso
        //header("Location: /crud-arkova/app/pages/report_type.php");
        $response['message'] = "Tipo de Reporte creado exitosamente.";
        echo json_encode($response);
        $response['reload'] = true;
        exit;
    } else {
        $response['error'] = true;
        $response['message'] = "Error al registrar nuevo tipo de reporte: " . $stmt->error;
        echo json_encode($response);
        exit;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>