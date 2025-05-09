<?php
// Conexión a la Base de Datos
require '../config/database.php';

$response = ['error' => false, 'message' => '']; // Inicializar la respuesta JSON

// Obtener el punto de restauración y limpiar la entrada
$restorePoint = SGBD::limpiarCadena($_POST['restorePoint']);

// Leer el archivo SQL y separar las consultas por ";"
$sql = explode(";", file_get_contents($restorePoint));
$totalErrors = 0;

// Aumentar el límite de tiempo de ejecución para evitar que el script expire
set_time_limit(60);

try {
    // Desactivar claves foráneas temporalmente
    $conn->query("SET FOREIGN_KEY_CHECKS=0");

    // Ejecutar cada consulta
    for ($i = 0; $i < count($sql) - 1; $i++) {
        if (!$conn->query($sql[$i] . ";")) {
            $totalErrors++;
        }
    }

    // Rehabilitar claves foráneas
    $conn->query("SET FOREIGN_KEY_CHECKS=1");

    // Verificar el resultado de la restauración
    if ($totalErrors <= 0) {
        $response['message'] = "Restauración completada con éxito";
    } else {
        $response['error'] = true;
        $response['message'] = "Ocurrió un error inesperado, no se pudo realizar la restauración completamente";
    }
} catch (Exception $e) {
    // Manejar excepciones y errores inesperados
    $response['error'] = true;
    $response['message'] = "Error durante la restauración: " . $e->getMessage();
} finally {
    // Cerrar la conexión
    $conn->close();
    // Enviar la respuesta como JSON
    echo json_encode($response);
    exit();
}
?>