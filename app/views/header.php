<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: /crud-arkova/app/views/login.php");
    exit();
}

// Verificamos el nivel del usuario
$user_id = $_SESSION['user_id']; // Asegúrate de que el user_id está almacenado en la sesión
$sqlUser = "SELECT level_user FROM users WHERE id = ?";
$stmt = $conn->prepare($sqlUser);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$level_user = $user['level_user'];
$stmt->close();

$dir = "../assets/img/reports";
?>

<style>
    .welcome-text {
        font-style: italic;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!--link href="./assets/css/bootstrap.min.css" rel="stylesheet"-->
<link href="./assets/css/all.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/crud-arkova/app/index.php">
            <img src="/crud-arkova/app/assets/brand/ARKOVA-logo-WT.svg" alt="ARKOVA" width="135" height="35">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-folder-open"></i> Reportes</a>
                    <ul class="dropdown-menu">
                        <?php if ($level_user == 0) { // Solo muestra estos botones si el usuario es administrador ?>
                        <li><a class="dropdown-item" href="/crud-arkova/app/views/report_type.php">Tipos de Reportes</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="/crud-arkova/app/views/current_reports.php">Reportes Vigentes</a></li>
                        <li><a class="dropdown-item" href="/crud-arkova/app/views/obsolete_reports.php">Reportes Obsoletos</a></li>
                        <li><a class="dropdown-item" href="/crud-arkova/app/views/system_performance.php">Métricas de Rendimiento del Sistema</a></li>
                    </ul>
                </li>
                <?php if ($level_user == 0) { // Solo muestra estos botones si el usuario es administrador ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-users"></i> Personal</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/crud-arkova/app/views/users.php">Gestionar Usuarios</a></li>
                        <li><a class="dropdown-item" href="/crud-arkova/app/views/disabled_users.php">Usuarios Inhabilitados</a></li>
                        <li><a class="dropdown-item" href="/crud-arkova/app/views/binnacle.php">Bitácora del Sistema</a></li>
                    </ul>
                </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-circle-info"></i> Soporte</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/crud-arkova/app/views/faq.php">Preguntas Frecuentes</a></li>
                        <li><a class="dropdown-item" href="/crud-arkova/app/views/user_manual.php">Manual</a></li>
                        <?php if ($level_user == 0) { // Solo muestra estos botones si el usuario es administrador ?>
                        <li><a class="dropdown-item" href="/crud-arkova/app/views/database_backup.php">Respaldo de la Base de Datos</a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="welcome-text">Bienvenid@, <?php echo $_SESSION['user_name'];?></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="fa-solid fa-right-to-bracket"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php require 'logoutModal.php'; ?>
<script src="/crud-arkova/app/assets/js/bootstrap.bundle.min.js"></script>