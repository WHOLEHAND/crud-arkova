<?php
session_start();
// edit_ReportType_process.php

// Incluye la conexión a la base de datos
require '../config/database.php';

// Verifica si se recibieron los datos necesarios
if (isset($_POST['id'], $_POST['name'])) {
    // Escapa los datos para evitar inyección SQL
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // Validaciones:
    // Validar que los campos no estén vacíos
    if (empty(trim($_POST['id'])) || empty(trim($_POST['name']))) {
        $response['error'] = true;
        $response['message'] = "Llenar el campo es obligatorio.";
        echo json_encode($response);
        exit;
    }

    // Validar si el nombre de usuario ya existe
    $sql_name = "SELECT name FROM report_type WHERE name = ? AND id != ?";
    $stmt_name = $conn->prepare($sql_name);
    $stmt_name->bind_param("si", $name, $id);
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

    // Validar nombres y apellidos
    if (strlen($name) < 4 || strlen($name) > 25 || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $name)) {
        $response['error'] = true;
        $response['message'] = "El nombre debe tener entre 3 y 25 caracteres y solo contener letras y espacios.";
        echo json_encode($response);
        $conn->close();
        exit;
    }

    // Obtener el nombre actual del tipo de reporte
    $sqlGetName = "SELECT name FROM report_type WHERE id = '$id'";
    $result = mysqli_query($conn, $sqlGetName);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentName = $row['name'];

        // Si el nombre es diferente, actualiza el nombre
        if ($currentName !== $name) {
            // Actualiza el nombre del tipo de reporte
            $sql = "UPDATE report_type SET name = '$name' WHERE id = '$id'";
            
            // Ejecuta la consulta de actualización
            if (mysqli_query($conn, $sql)) {
                // Registrar acción de auditoría con el cambio
                $fecha = date("Y-m-d H:i:s");
                $username = $_SESSION['user_name'];

                // Define la acción de auditoría con el cambio de nombre
                $accion = "El usuario [$username] editó un tipo de reporte: Nombre cambiado de '$currentName' a '$name'";

                // Inserta el registro de auditoría
                $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
                $stmt_auditoria = mysqli_prepare($conn, $sql_aud);
                mysqli_stmt_bind_param($stmt_auditoria, "sss", $username, $fecha, $accion);
                mysqli_stmt_execute($stmt_auditoria);
                mysqli_stmt_close($stmt_auditoria);

                // Redirigir a la URL de origen
                //header("Location: /crud-arkova/app/pages/report_type.php");
                // Mensaje si la consulta de actualización es correcta.
                $response['message'] = "Tipo de Reporte actualizado correctamente.";
                echo json_encode($response);
                $response['reload'] = true;
                exit;
            } else {
                // Si la consulta de actualización falla
                $response['error'] = true;
                $response['message'] = "Error al actualizar el tipo de reporte: " . mysqli_error($conn);
                echo json_encode($response);
            }
        } else {
            // Redirigir si no hubo cambio en el nombre
            //header("Location: /crud-arkova/app/pages/report_type.php");
            $response['error'] = true;
            $response['message'] = "El nombre del tipo de reporte no ha cambiado.";
            echo json_encode($response);
            $response['reload'] = true;
            exit;
        }
    } else {
        // Si la consulta de busqueda falla
        $response['error'] = true;
        $response['message'] = "Tipo de reporte no encontrado.";
        echo json_encode($response);
        exit;
    }

    // Cerrar conexiones
    $conn->close();
} else {
    $response['error'] = true;
    $response['message'] = "Datos incompletos.";
    echo json_encode($response);
    exit;
}
?>