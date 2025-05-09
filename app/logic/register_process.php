<?php
session_start();
// Conexión a la base de datos
require '../config/database.php';

/**
 * Script para registrar un nuevo perfil de usuario en el sistema
 * El mismo fue mejorado a último momento,
 * dentro del plazo misterioso de 1 semana ( •̀ ω •́ )✧
 *
 * @author wholehand
 * @link https://github.com/wholehand
 * @license: MIT
 * 
 * Querida amiga y supervisora programadora María, alias LuxFero:
 * 
 * Gracias por confiar en mi y permitirme aprender muchas cosas
 * durante la realización de este proyecto, el cúal llegue a subestimar bastante
 * por andar de confiado con lo que creía se iba a desarrollar, Ante todo la humildad y la gratitud
 * ya que; gracias a tu guía y a la disposición de recursos y herramientas como:
 * Youtube, Foros, Documentación y sobre todo ChatGPT, fue que logré hacer esto posible...
 * 
 * Sobretodo espero que esta humilde aplicación sea de utilidad para
 * todo el personal de la Gerencia de Tecnología en A.C.BBVVA.
 * 
 * Sin más que agregar, ojala pasé todos tus filtros y pruebas...
 * y que esta aplicación sea de tu agrado.
 * 
 * あなたの非公式のボーイフレンドに、深い愛情を込めて別れを告げます。
 * ATT: wholehand
 */


// Inicializar la respuesta
$response = [
    'error' => false,
    'message' => ''
];

// Validar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar datos del formulario
    $user_name = htmlspecialchars(trim($_POST["username"]));
    $names = htmlspecialchars(trim($_POST["names"]));
    $last_names = htmlspecialchars(trim($_POST["last_names"]));
    $identity_card = htmlspecialchars(trim($_POST["identity_card"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $level_user = isset($_POST["level_user"]) && $_POST["level_user"] === '0' ? 0 : 1; // 0 = Admin, 1 = Técnico
    $state_user = 1; // Cuenta activa por defecto (1 = activo, 0 = inactivo)

    // VALIDACIONES GENERALES
    // Validar que todos los campos estén completos
    if (empty($user_name) || empty($names) || empty($last_names) || empty($identity_card) || empty($email) || empty($password) || empty($confirm_password)) {
        $response['error'] = true;
        $response['message'] = "Todos los campos son obligatorios.";
        echo json_encode($response);
        exit;
    }

    // VALIDACIONES DEL NOMBRE DE USUARIO
    // Longitud del nombre de usuario
    if (strlen($user_name) < 4 || strlen($user_name) > 10) {
        $response['error'] = true;
        $response['message'] = "El nombre de usuario debe tener entre 4 y 10 caracteres.";
        echo json_encode($response);
        exit;
    }

    // Validar si el nombre de usuario ya existe
    $sql_username = "SELECT user_name FROM users WHERE user_name = ?";
    $stmt_username = $conn->prepare($sql_username);
    $stmt_username->bind_param("s", $user_name);
    $stmt_username->execute();
    $stmt_username->store_result();
    if ($stmt_username->num_rows > 0) {
        $response['error'] = true;
        $response['message'] = "El nombre de usuario ya está registrado.";
        echo json_encode($response);
        exit;
    }
    $stmt_username->close();

    // VALIDACIONES DE NOMBRES Y APELLIDOS
    // Longitud de nombres
    if (strlen($names) < 3 || strlen($names) > 25) {
        $response['error'] = true;
        $response['message'] = "El nombre debe tener entre 3 y 25 caracteres.";
        echo json_encode($response);
        exit;
    }

    // Validar formato de nombres
    if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $names)) {
        $response['error'] = true;
        $response['message'] = "El nombre solo puede contener letras y espacios.";
        echo json_encode($response);
        exit;
    }

    // Longitud de apellidos
    if (strlen($last_names) < 2 || strlen($last_names) > 25) {
        $response['error'] = true;
        $response['message'] = "El apellido debe tener entre 2 y 25 caracteres.";
        echo json_encode($response);
        exit;
    }

    // Validar formato de apellidos
    if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $last_names)) {
        $response['error'] = true;
        $response['message'] = "El apellido solo puede contener letras y espacios.";
        echo json_encode($response);
        exit;
    }

    // VALIDACIONES DE LA CÉDULA DE IDENTIDAD
    // Longitud de la cédula
    if (strlen($identity_card) < 7) {
        $response['error'] = true;
        $response['message'] = "La cédula de identidad debe tener al menos 7 caracteres.";
        echo json_encode($response);
        exit;
    }

    // Formato de cédula (solo números)
    if (!ctype_digit($identity_card)) {
        $response['error'] = true;
        $response['message'] = "La cédula de identidad solo puede contener números.";
        echo json_encode($response);
        exit;
    }

    // Validar si la cédula ya existe
    $sql_identity_card = "SELECT identity_card FROM users WHERE identity_card = ?";
    $stmt_identity_card = $conn->prepare($sql_identity_card);
    $stmt_identity_card->bind_param("s", $identity_card);
    $stmt_identity_card->execute();
    $stmt_identity_card->store_result();
    if ($stmt_identity_card->num_rows > 0) {
        $response['error'] = true;
        $response['message'] = "La cédula de identidad ya está registrada.";
        echo json_encode($response);
        exit;
    }
    $stmt_identity_card->close();

    // VALIDACIONES DEL CORREO
    // Validar formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error'] = true;
        $response['message'] = "El correo electrónico no tiene un formato válido.";
        echo json_encode($response);
        exit;
    }

    // Validar si el correo ya existe
    $sql_email = "SELECT email FROM users WHERE email = ?";
    $stmt_email = $conn->prepare($sql_email);
    $stmt_email->bind_param("s", $email);
    $stmt_email->execute();
    $stmt_email->store_result();
    if ($stmt_email->num_rows > 0) {
        $response['error'] = true;
        $response['message'] = "El correo electrónico ya está registrado.";
        echo json_encode($response);
        exit;
    }
    $stmt_email->close();

    // VALIDACIONES DE CONTRASEÑA
    // Longitud de la contraseña
    if (strlen($password) < 5) {
        $response['error'] = true;
        $response['message'] = "La contraseña debe tener al menos 5 caracteres.";
        echo json_encode($response);
        exit;
    }

    // Verificar coincidencia de contraseñas
    if ($password !== $confirm_password) {
        $response['error'] = true;
        $response['message'] = "Las contraseñas no coinciden.";
        echo json_encode($response);
        exit;
    }

    // Validación de contraseña fuerte (comentada por ahora)
    // if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,}$/', $password)) {
    //     $response['error'] = true;
    //     $response['message'] = "La contraseña debe tener al menos 5 caracteres, incluyendo una letra mayúscula, una minúscula, un número y un carácter especial.";
    //     echo json_encode($response);
    //     exit;
    // }

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // INSERTAR EL NUEVO USUARIO EN LA BASE DE DATOS
    $sql = "INSERT INTO users (user_name, names, last_names, identity_card, email, password, level_user, state_user)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $response['error'] = true;
        $response['message'] = "Error en la preparación de la consulta: " . $conn->error;
        echo json_encode($response);
        exit;
    }
    $stmt->bind_param("ssssssii", $user_name, $names, $last_names, $identity_card, $email, $hashed_password, $level_user, $state_user);
    if ($stmt->execute()) {
        // Registrar en auditoría
        $fecha = date("Y-m-d H:i:s");
        $username = $_SESSION['user_name'];
        $sql_aud = "INSERT INTO auditory (aud_user, aud_registereddate, aud_action) VALUES (?, ?, ?)";
        $stmt_auditoria = $conn->prepare($sql_aud);
        $accion = "El usuario [$username] registró un nuevo perfil de usuario llamado '$user_name'";
        $stmt_auditoria->bind_param("sss", $username, $fecha, $accion);
        $stmt_auditoria->execute();
        $stmt_auditoria->close();

        $response['message'] = "Usuario registrado exitosamente.";
        echo json_encode($response);
        $response['reload'] = true;
        exit;
    } else {
        $response['error'] = true;
        $response['message'] = "Error al registrar el usuario: " . $stmt->error;
        echo json_encode($response);
        exit;
    }
    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión principal a la Base de Datos
$conn->close();
?>