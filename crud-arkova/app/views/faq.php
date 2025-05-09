<?php
// Conexión a la Base de Datos
require '../config/database.php';

// Header
require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PREGUNTAS FRECUENTES</title>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Author -->
    <meta name="description" content="Pantalla de Preguntas Frecuentes">
    <meta name="author" content="Jesús Vielma @wholehand">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">

    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- link href="./assets/css/bootstrap.min.css" rel="stylesheet" -->

    <style>
        body {
            position: relative;
            padding-bottom: 3em;
        }
    </style>
</head>
<body>
    <div class="container py-3">
        <h2 class="text-center mb-4">Preguntas Frecuentes</h2>

        <!-- Accordion -->
        <div class="accordion w-75 mx-auto" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        ¿Por qué ARKOVA?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        El nombre <strong>ARKOVA</strong> se inspira en la palabra rusa "арка" (arco), que simboliza un refugio o un respaldo firme, reflejando el propósito del sistema: servir como un soporte digital seguro y organizado para los reportes físicos. Además, ARKOVA es un acrónimo de <strong>Archiver for Reports Kept and Organized for Virtual Access</strong>, destacando su función de mantener y organizar los reportes para un acceso virtual eficiente.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        ¿Cómo puedo cargar un nuevo reporte en ARKOVA?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Para cargar un nuevo reporte, primero debes tomar una foto del documento físico. Luego, acceder al sistema ARKOVA con un perfil de usuario bien sea administrador o técnico, en el menú podrás acceder a la lista de reportes, mediante la opción "Reportes Vigentes", que se encuentra dentro del menú desplegable de la opción Reportes, una vez dentro selecciona "Nuevo Reporte", ingresa el tipo de reporte (Técnico o Movimiento de Bienes), llena el nombre, una descripción breve y establece la fecha de realización. Después, carga la foto del documento y haz clic en "Guardar Cambios".
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        ¿Qué tipos de reportes puedo cargar en ARKOVA?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        ARKOVA permite cargar principalemente dos tipos de reportes: <strong>Técnico</strong> y <strong>Movimiento de Bienes</strong>. (Aunque un usuario administrador puede crear otros tipos si se requieren). Selecciona el tipo adecuado según el contenido del documento que estás cargando para mantener la organización en el sistema.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        ¿Puedo editar un reporte después de haberlo cargado?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Sí, puedes editar un reporte después de haberlo cargado. Solo selecciona el reporte en la lista de registros, haz clic en el botón "Editar" ubicado en la columna "Acción", realiza los cambios necesarios (como el tipo de reporte, nombre, descripción, fecha o hasta reemplazar la imagen cargada), y guarda los cambios.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        ¿Cómo puedo buscar un reporte específico en el sistema?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Para buscar un reporte específico, debes primero dirigirte al archivero que dónde deseas buscar <strong>Reportes Vigentes</strong> ó <strong>Reportes Obsoletos</strong>. Desde allí utiliza la barra de búsqueda ubicada en la parte superior derecha en la tabla de reportes. Puedes buscar de manera automática por nombre, tipo de reporte, fecha o cualquier palabra clave que hayas incluido en la descripción del reporte.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        ¿El sistema ARKOVA permite la eliminación de registros cargados?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        No, si cometió un error, puede editar el reporte con la columna acción, ahora si lo que quiere es que un reporte ya no se muestre en la tabla, entonces puede archivarlo, lo que moverá dicho reporte al archivero de <strong>Reportes Obsoletos</strong>, tenga en cuenta que está acción es irreversible para usuarios <strong>Técnicos</strong>. Solo un perfil <strong>Administrador</strong> puede restaurar el reporte si desea traer de regreso al archivero de <strong>Reportes Vigentes</strong>.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        ¿Qué significa mi rol de usuario?
                    </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        En ARKOVA, los usuarios pueden tener dos roles:
                        <li><strong>Técnico:</strong> Este es el usuario base, encargado de cargar, editar y archivar reportes.</li>
                        <li><strong>Administrador:</strong> Este rol tiene control total sobre el sistema, incluyendo la gestión de perfiles de usuario, la edición de registros y la administración de los reportes archivados. Solo los administradores pueden registrar, editar o inhabilitar usuarios. Además de supervisar sus acciones en el sistema mediante un modulo de Bitácora.</li>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        ¿Si olvido mis credenciales de acceso, qué debo hacer?
                    </button>
                </h2>
                <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Si olvidaste tus credenciales de acceso, debes comunicarte con un administrador para modificar tu perfil. Solo los administradores tienen la capacidad de registrar, editar o inhabilitar perfiles de usuario en el sistema.
                    </div>
                </div>
            </div>
        </div>

        <!-- Nota -->
        <div class="text-center mt-2">
            <p style="font-style: italic; color: #595c5f;">
                Si su duda no se encuentra en esta lista, favor checar el manual de usuario <a href="/crud-arkova/app/views/user_manual.php"><strong>aquí</strong></a>.
            </p>
        </div>
    </div>
    
    <!-- Footer -->
    <?php require 'footer.php' ?>
</body>
</html>