<?php
session_start();
require '../config/database.php';

$response = ['error' => false, 'message' => ''];

// Fechas y archivo de respaldo
$day = date("d");
$month = date("m");
$year = date("Y");
$hora = date("H-i-s");
$fecha = $day . '_' . $month . '_' . $year;
$DataBASE = $fecha . "_(" . $hora . "_hrs).sql";
$tables = [];

$result = SGBD::sql('SHOW TABLES');
if (!$result) {
    $response['error'] = true;
    $response['message'] = "No se pudieron obtener las tablas de la base de datos.";
    echo json_encode($response);
    exit();
}

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

$sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";
$sql .= "CREATE DATABASE IF NOT EXISTS arkova;\n\n";
$sql .= "USE arkova;\n\n";

// Obtener todas las tablas
$result = SGBD::sql('SHOW TABLES');
if (!$result) {
    $response['error'] = true;
    $response['message'] = "No se pudieron obtener las tablas de la base de datos.";
    echo json_encode($response);
    exit();
}

// Recorrer las tablas y generar respaldo
foreach ($tables as $table) {
    $result = SGBD::sql("SELECT * FROM $table");
    if (!$result) {
        $response['error'] = true;
        $response['message'] = "Error al obtener los datos de la tabla '$table'.";
        echo json_encode($response);
        exit();
    }

    $numFields = mysqli_num_fields($result);
    $row2 = mysqli_fetch_row(SGBD::sql("SHOW CREATE TABLE $table"));
    if (!$row2) {
        $response['error'] = true;
        $response['message'] = "Error al obtener la estructura de la tabla '$table'.";
        echo json_encode($response);
        exit();
    }

    $sql .= "DROP TABLE IF EXISTS $table;\n";
    $sql .= $row2[1] . ";\n\n";

    while ($row = mysqli_fetch_row($result)) {
        $sql .= "INSERT INTO $table VALUES(";
        for ($j = 0; $j < $numFields; $j++) {
            // Escapar los valores usando mysqli_real_escape_string
            $row[$j] = mysqli_real_escape_string($conn, $row[$j]);
            
            // Reemplazar saltos de línea para que se almacenen correctamente
            $row[$j] = str_replace("\n", "\\n", $row[$j]);
    
            // Si el valor está definido, lo incluimos en la consulta SQL, sino usamos una cadena vacía
            $sql .= isset($row[$j]) ? "\"$row[$j]\"" : "\"\"";
    
            // Si no es el último campo, agregamos una coma
            if ($j < ($numFields - 1)) {
                $sql .= ",";
            }
        }
        $sql .= ");\n";
    }
    $sql .= "\n\n";
    
}

// Guardar respaldo en archivo
$sql .= "SET FOREIGN_KEY_CHECKS=1;";
$handle = fopen(BACKUP_PATH . $DataBASE, 'w+');
if (!$handle || !fwrite($handle, $sql)) {
    $response['error'] = true;
    $response['message'] = "Error al guardar el respaldo en el archivo.";
    echo json_encode($response);
    exit();
}

fclose($handle);
$response['message'] = "Respaldo realizado con éxito.";
$response['redirect'] = "/crud-arkova/app/views/database_backup.php";
echo json_encode($response);

// Auditoría
if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];
    require '../config/database.php';

    $fecha_aud = date("Y-m-d H:i:s");
    $accion_aud = "El usuario [$username] realizó un respaldo de la base de datos";
    $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
    $stmt_aud = mysqli_prepare($conn, $sql_aud);

    if ($stmt_aud) {
        mysqli_stmt_bind_param($stmt_aud, "sss", $username, $fecha_aud, $accion_aud);
        if (!mysqli_stmt_execute($stmt_aud)) {
            $response['error'] = true;
            $response['message'] = "Error al registrar la auditoría.";
            echo json_encode($response);
            exit();
        }
        mysqli_stmt_close($stmt_aud);
    } else {
        $response['error'] = true;
        $response['message'] = "Error al preparar la consulta de auditoría.";
        echo json_encode($response);
        exit();
    }

    mysqli_close($conn);
}
?>