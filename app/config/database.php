<?php
// Configurar la zona horaria para todo el proyecto
date_default_timezone_set('America/Caracas');

// Configuración del puerto y credenciales del servidor
$conn = new mysqli("127.0.0.1", "root", "", "arkova");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres a utf8mb4
if (!$conn->set_charset("utf8mb4")) {
    die("Error al configurar el juego de caracteres: " . $conn->error);
}

// Carpeta donde se almacenarán las copias de seguridad
//const BACKUP_PATH = "../backup/";

// Carpeta donde se almacenarán las copias de seguridad
if (!defined('BACKUP_PATH')) {
    define('BACKUP_PATH', "../backup/");
}

if (!class_exists('SGBD')) {
    class SGBD {
        // Función para hacer consultas a la base de datos
        public static function sql($query) {
            global $conn; // Usa la conexión global

            if (!$conn) {
                die("Error: No se puede conectar a la base de datos.");
            }

            // Ejecutar la consulta
            $result = $conn->query($query);

            // Manejar errores de consulta
            if (!$result) {
                $response['error'] = true;
                $response['message'] = "Error en la consulta: " . $conn->error;
                echo json_encode($response);
                exit();
            }

            return $result;
        }

        // Función para limpiar variables que contengan inyección SQL
        public static function limpiarCadena($valor) {
            $valor = addslashes($valor);
            $valor = str_ireplace("<script>", "", $valor);
            $valor = str_ireplace("</script>", "", $valor);
            $valor = str_ireplace("SELECT * FROM", "", $valor);
            $valor = str_ireplace("DELETE FROM", "", $valor);
            $valor = str_ireplace("UPDATE", "", $valor);
            $valor = str_ireplace("INSERT INTO", "", $valor);
            $valor = str_ireplace("DROP TABLE", "", $valor);
            $valor = str_ireplace("TRUNCATE TABLE", "", $valor);
            $valor = str_ireplace("--", "", $valor);
            $valor = str_ireplace("^", "", $valor);
            $valor = str_ireplace("[", "", $valor);
            $valor = str_ireplace("]", "", $valor);
            $valor = str_ireplace("\\", "", $valor);
            $valor = str_ireplace("=", "", $valor);
            return $valor;
        }
    }
}
?>