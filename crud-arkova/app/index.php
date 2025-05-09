<?php
// Conexión a la Base de Datos
require 'config/database.php';

// Header
require 'views/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BIENVENID@!</title>
    <link type="image/x-icon" href="assets/img/favicon.ico?v=1" rel="shortcut icon">

    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Author -->
    <meta name="description" content="Pantalla de Bienvenida al sistema">
    <meta name="author" content="Jesús Vielma @wholehand">

    <!-- Enlace a Bootstrap -->
    <!--link href="./assets/css/bootstrap.min.css" rel="stylesheet"-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Estilos para centrar y definir tamaño del carrusel */
        #carousel-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Estilos para centrar y definir tamaño del carrusel */
        #demo {
            width: 1000px;
            height: 370px;
            margin: auto;
            position: relative;
            overflow: hidden;
        }
        #demo .h2 .p .a {
            color: black;
        }
    </style>
</head>
<body>
    <!-- Carousel Container -->
    <div id="carousel-container">
        <!-- Carousel -->
        <div id="demo" class="carousel slide mt-2" data-bs-ride="carousel">

            <!-- Indicators/dots -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
            </div>

            <!-- The slideshow/carousel -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/crud-arkova/app/assets/img/marquee_blue_patterned_2x.png" style="background-color: #0071b2;" alt="Welcome" class="d-block w-100">
                    <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                        <h1>¡Te damos la bienvenida a ARKOVA!</h1>
                        <h5 style="font-weight:400;">“Una herramienta eficaz para archivar y respaldar tus reportes”</h5>
                        <a href="/crud-arkova/app/views/current_reports.php" class="btn btn-outline-light mt-3">Ver Reportes Vigentes</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/crud-arkova/app/assets/img/ttae_abstract_green_patterned_2x.png" style="background-color: #00b253;" alt="Respaldo" class="d-block w-100">
                    <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                        <h1>“Es triste amar sin ser amado, pero es más triste cerrar sin haber guardado”</h1>
                        <h5 style="font-weight:400;">¡Crea respaldos de tu data con las opciones de generar informe PDF o Excel!</h5>
                        <!-- a href="#" class="btn btn-outline-light mt-3">Ver Reportes Vigentes</a -->
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/crud-arkova/app/assets/img/nadzeya_pakhomava_geometric_yellow_patterned_2x.png" style="background-color: #b27c00;" alt="Support" class="d-block w-100">
                    <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                        <h2>¿Tienes dudas sobre como usar ARKOVA?</h2>
                        <h6 style="font-weight:400;">“No te preocupes hemos incluido un manual de uso y una sección de preguntas frecuentes”</h6>
                        <a href="/crud-arkova/app/views/user_manual.php" class="btn btn-outline-light mt-3">Leer Manual</a>
                    </div>
                </div>
            </div>

            <!-- Left and right controls/icons -->
            <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
    
    <!-- Footer -->
    <?php require 'views/footer.php' ?>
</body>
</html>