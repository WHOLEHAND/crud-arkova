<?php
// Conexión a la Base de Datos
require '../config/database.php';

// Header
require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Author -->
    <meta name="description" content="Pantalla de Bienvenida con carrusel">
    <meta name="author" content="Jesús Vielma @wholehand">

    <title>MANUAL DEL SISTEMA</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon"/>

    <!-- Enlace a Bootstrap -->
    <!-- link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            position: relative;
            padding-bottom: 3em;
        }
        div.container {
            max-width: 1200px;
        }

        .table-of-content {
            max-height: 570px;
            overflow-y: auto;

            /* makes the sidebar sticky */
            position: sticky;
            top: 22px;
        }

        .section-break {
            margin: 24px 0;
        }

        /* Botón flotante para ir arriba (solo visible en móvil) */
        .go-top {
            display: none; /* Oculto por defecto */
            position: fixed;
            bottom: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            background-color: black;
            color: white;
            text-align: center;
            line-height: 30px; /* Centrado verticalmente */
            font-size: 18px; /* Tamaño del símbolo */
            border-radius: 2px;
            z-index: 1000;
            text-decoration: none;
        }

        @media screen and (max-width: 780px) {
            /* the sidebar and content are stacked on top of each other */
            .main {
                flex-direction: column;
            }

            /* takes the full width of the document */
            .table-of-content {
                width: 100%;
                position: relative;
                margin-bottom: 50px;
            }

            /* takes the full width of document */
            .main-content {
                width: 100%;
            }

            /* Mostrar botón de Ir Arriba */
            .go-top {
                display: block;
            }

            img {
                max-width: 100%; /* Asegura que las imágenes no excedan el ancho del contenedor */
                height: auto; /* Mantiene la proporción */
            }
            .content img {
                margin: 0 auto; /* Centra las imágenes */
                display: block; /* Asegura que sean elementos de bloque */
            }
        }
    </style>
</head>
<body class="bg-light">
    <main class="container py-4 main">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-md-4 table-of-content border p-3 bg-white">
                <h2 class="fs-5 mb-4">Tabla de Contenidos</h2>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <strong>Introducción</strong>
                        <ul class="list-unstyled ps-3">
                            <li><a href="#about-arkova" class="text-primary text-decoration-none">Acerca de ARKOVA</a></li>
                            <li><a href="#about-doc" class="text-primary text-decoration-none">Acerca de esta documentación</a></li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <strong>Primeros Pasos</strong>
                        <ul class="list-unstyled ps-3">
                            <li><a href="#login-ARKOVA" class="text-primary text-decoration-none">Ingreso al Sistema</a></li>
                            <li><a href="#home-ARKOVA" class="text-primary text-decoration-none">Bienvenid@ al Sistema</a></li>
                            <li><a href="#reports-ARKOVA" class="text-primary text-decoration-none">Sección de Reportes</a></li>
                            <li><ol>
                                <li><a href="#report-type-ARKOVA" class="text-primary text-decoration-none">Tipos de Reportes</a></li>
                                <li><a href="#current-report-ARKOVA" class="text-primary text-decoration-none">Reportes Vigentes</a></li>
                                <li><a href="#obsolete-report-ARKOVA" class="text-primary text-decoration-none">Reportes Obsoletos</a></li>
                                <li><a href="#system-performance-ARKOVA" class="text-primary text-decoration-none">Métricas de Rendimiento del Sistema</a></li>
                            </ol></li>
                            <li><a href="#personal-ARKOVA" class="text-primary text-decoration-none">Sección de Personal</a></li>
                            <li><ol>
                                <li><a href="#users-ARKOVA" class="text-primary text-decoration-none">Gestionar Usuarios</a></li>
                                <li><a href="#disable-users-ARKOVA" class="text-primary text-decoration-none">Usuarios Inhabilitados</a></li>
                                <li><a href="#binnacle-ARKOVA" class="text-primary text-decoration-none">Bitácora del Sistema</a></li>
                            </ol></li>
                            <li><a href="#support-ARKOVA" class="text-primary text-decoration-none">Sección de Soporte</a></li>
                            <li><ol>
                                <li><a href="#faq-ARKOVA" class="text-primary text-decoration-none">Preguntas Frecuentes</a></li>
                                <li><a href="#user-manual-ARKOVA" class="text-primary text-decoration-none">Manual del Sistema</a></li>
                                <li><a href="#db-backup-ARKOVA" class="text-primary text-decoration-none">Respaldo de la Base de Datos</a></li>
                            </ol></li>
                        </ul>
                    </li>
                </ul>
            </aside>

            <!-- Main content -->
            <section class="col-md-8 main-content">
                <!-- Botón para Ir Arriba -->
                <a href="#" class="go-top" aria-label="Ir arriba">^</a>
                
                <h2>Introducción</h2>
                <h3 id="about-arkova">Acerca de ARKOVA</h3>
                <p style="text-align: justify;">
                    ARKOVA (<span style="font-style: italic;">Archiver for Reports Kept and Organized for Virtual Access</span>)
                    es una aplicación web que surge en 2024 como proyecto en las
                    prácticas profesionales del estudiante Jesús Vielma para optar al título universitario
                    Ingeniería de Sistemas, el mismo propusó
                    un archivero de respaldo digital para los documentos de tipo
                    reporte técnico o movimiento de bienes;
                    realizados por el personal de la Gerencia de Tecnolgía en la
                    Asociación Civil Bibliotecas Virtuales de Aragua.
                </p>
                <h3 id="about-doc">Acerca de esta documentación</h3>
                <p style="text-align: justify;">
                    Los desarrolladores en la Gerencia de Tecnología de la A.C.BBVVA
                    escriben, corrigen, editan y mejoran esta documentación cada que la aplicación se actualiza.
                    <br>
                    <br>
                    Actualmente se encuentra leyendo la versión: 1.0 Estable
                    <br>
                    <br>
                    Todo el contenido de la documentación está bajo la licencia
                    Creative Commons Attribution 3.0 (<a class="reference external" href="https://creativecommons.org/licenses/by/3.0/">CC-BY 3.0</a>), con atribución a
                    <em>Jesús Vielma y al personal de la Gerencia de Tecnología en A.C.BBVVA</em>
                    a menos que se indique lo contrario.
                </p>
                <hr class="section-break">
                <h2>Primeros Pasos</h2>
                <h3 id="login-ARKOVA">Ingreso al Sistema</h3>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            En esta página los usuarios deberán colocar su nombre de usuario y la contraseña en los campos señalados, es importante destacar dos cosas:
                            <li>El usuario debe estar previamente registrado por un usuario administrador.</li>
                            <li>El usuario debe estar habilitado, de lo contrario, el sistema arrojará el mensaje “Su usuario ha sido inhabilitado” Y no podrá iniciar sesión.</li>
                        </p>
                    </div>
                    <div class="col"><img src="../assets/img/manual/login.jpeg" class="col-md-12 rounded float-end" alt="login-users"></div>
                </div>
                <h3 id="home-ARKOVA">Bienvenid@ al Sistema</h3>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            En esta página se recibe al usuario una vez ingresa al sistema, a continuación podrá encontrar
                            el menú de opciones desde la cabecera del sistema
                            y un banner de tipo carrusel que le da un pequeño resumen de las opciones principales.
                        </p>
                    </div>
                    <div class="col"><img src="../assets/img/manual/home.jpeg" class="col-md-12 rounded float-end" alt="home-users"></div>
                    <p class="mt-2" style="text-align: justify;">
                        Cabe destacar que el menú de opciones de la cabecera varia según el rol del usuario en el sistema:
                        <br>
                        <li>Los usuarios de Rol Administrador poseen una sección extra llamada <strong>"Personal"</strong>
                            la misma les permite gestionar los usuarios del sistema tanto; habilitados, como inhabilitados tamibén
                            desde allí puede acceder a la bitácora del sistema.
                        </li>
                        <br>
                        <li>Por otro lado los usuarios de Rol Técnico solo poseen las secciones de <strong>"Reportes"</strong> y <strong>"Soporte"</strong></li>
                    </p>
                </div>

                <h3 id="reports-ARKOVA">Sección de Reportes</h3>
                <h4 id="report-type-ARKOVA">Tipo de Reportes</h4>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            Esta sección permite al usuario Administrador consultar y gestionar los tipos de reportes disponibles para seleccionarlos al crear un nuevo reporte mediante la opción de "Reportes Vigentes".
                        </p>
                        <p style="text-align: justify;">
                            En esta página, el usuario puede visualizar una tabla donde están registrados los tipos de reportes existentes, observando en ella el nombre de cada tipo registrado.
                        </p>
                    </div>
                    <div class="col">
                        <img src="../assets/img/manual/report-type.jpeg" class="col-md-12 rounded float-end" alt="Tipos de reportes">
                    </div>
                </div>
                <p style="text-align: justify;">
                    La tabla cuenta con las siguientes funcionalidades:
                </p>
                <ul class="col">
                    <li>Ordenamiento alfabético ascendente o descendente mediante una flecha en los encabezados de las columnas.</li>
                    <li>Buscador dinámico en la esquina superior derecha, que permite filtrar automáticamente por el nombre de los tipos registrados.</li>
                    <li>Opción para ajustar el número de filas mostradas en la tabla, mejorando el rendimiento al consultar datos.</li>
                    <li>Botones de navegación ("Anterior", paginación numérica y "Siguiente") para explorar múltiples páginas de la tabla.</li>
                </ul>
                <p style="text-align: justify;">
                    El encabezado de la tabla incluye botones de control como:
                </p>
                <ul>
                    <li><strong>Nuevo Tipo:</strong> abre un formulario para registrar un nuevo tipo de reporte. El usuario debe ingresar el nombre deseado y confirmar con el botón "Crear Tipo de Reporte". Una vez creado, la tabla se actualizará automáticamente para reflejar el nuevo registro.</li>
                    <li><strong>Generar Informes:</strong> opciones para exportar los datos de la tabla en formato PDF o Excel:
                        <ul>
                            <li>El archivo PDF se abre en una nueva pestaña, desde donde puede guardarse o imprimirse.</li>
                            <li>El archivo Excel se descarga automáticamente en formato .xlsx, compatible con aplicaciones de hojas de cálculo.</li>
                        </ul>
                    </li>
                </ul>
                <p style="text-align: justify;">
                    Además, la tabla incluye una acción específica para la gestión de los tipos de reportes:
                </p>
                <ul>
                    <li><strong>Editar Tipo:</strong> al hacer clic en este botón, se despliega un formulario donde se puede modificar el nombre del tipo registrado. Los cambios se reflejan de inmediato en la tabla.</li>
                </ul>

                <h4 id="current-report-ARKOVA">Reportes Vigentes</h4>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            Esta sección permite a los usuarios consultar y gestionar los reportes cargados en el sistema, los mismos pueden ser de tipo técnico o movimiento de bienes.
                        </p>
                        <p style="text-align: justify;">
                            En esta página, el usuario puede visualizar una tabla donde están registrados los reportes existentes que se encuentren vigentes, observando en ella el tipo de reporte, su nombre, la descripción, la fecha y hora de realización y la foto de cada reporte registrado.
                        </p>
                    </div>
                    <div class="col">
                        <img src="../assets/img/manual/current-reports.jpeg" class="col-md-12 rounded float-end" alt="Reportes Vigentes">
                    </div>
                </div>
                <p style="text-align: justify;">
                    La tabla cuenta con las siguientes funcionalidades:
                </p>
                <ul class="col">
                    <li>Ordenamiento alfabético ascendente o descendente mediante una flecha en los encabezados de las columnas.</li>
                    <li>Buscador dinámico en la esquina superior derecha, que permite filtrar automáticamente por el tipo de reporte, nombre, fecha o cualquier palabra clave que hayas incluido en la descripción del reporte.</li>
                    <li>Opción para ajustar el número de filas mostradas en la tabla, la cual se encuentra en la esquina superior izquierda y sirve para mejorar el rendimiento al consultar datos.</li>
                    <li>Botones de navegación ("Anterior", paginación numérica y "Siguiente") para explorar múltiples páginas de la tabla. Ubicados en la esquina inferior derecha.</li>
                </ul>
                <p style="text-align: justify;">
                    El encabezado de la tabla incluye botones de control como:
                </p>
                <ul>
                    <li><strong>Botones de selección y deselección múltiple:</strong> permiten seleccionar o deseleccionar todos los reportes cargados en la tabla.</li>
                    <li><strong>Nuevo Reporte:</strong> abre un formulario para registrar un nuevo reporte. El usuario debe seleccionar un tipo de reporte: técnico o movimiento de bienes, luego ingresar el nombre del reporte, una descripción breve del trabajo realizado, asignar la fecha y hora correspondiente y cargar la foto del documento (solo se admite formato JPG o JPEG) para finalizar el proceso debe confirmar con el botón "Guardar Cambios". Una vez creado, la tabla se actualizará automáticamente para reflejar el nuevo registro. Además, se resalta que todos los campos del registro son obligatorios.</li>
                    <li><strong>Archivar Reportes:</strong> esta opción permite al usuario archivar 1 o más reportes simultáneamente, para ello, deben estar previamente seleccionados, usando la casilla de selección ubicada en la primera columna de cada registro o usando los botones de selección múltiple si desea archivar todos los registros cargados en la tabla. Cabe destacar que esta acción es irreversible para usuario con Rol Técnico.</li>
                    <li><strong>Generar Informes:</strong> opciones para exportar los datos de la tabla en formato PDF o Excel:
                        <ul>
                            <li>El archivo PDF se abre en una nueva pestaña, desde donde puede guardarse o imprimirse.</li>
                            <li>El archivo Excel se descarga automáticamente en formato .xlsx, compatible con aplicaciones de hojas de cálculo.</li>
                        </ul>
                    </li>
                </ul>
                <p style="text-align: justify;">
                    Además, la tabla incluye una acción específica para la gestión de los reportes:
                </p>
                <ul>
                    <li><strong>Editar Reporte:</strong> al hacer clic en este botón, se despliega un formulario donde se puede modificar el tipo de reporte asignado, su nombre, descripción, fecha o sustituir la foto cargada. Los cambios se reflejan de inmediato en la tabla.</li>
                    <li><strong>Archivar Reporte:</strong> al hacer clic en este botón, se mostrará un modal de confirmación, para evitar que un usuario archive un registro por error, pues esta acción es irreversible para usuarios con Rol Técnico. Archivar un Reporte lo que permite es cambiar el estado del reporte de vigente a obsoleto, por consecuente el mismo se mostrará ahora en la tabla de "Reportes Obsoletos".</li>
                </ul>

                <h4 id="obsolete-report-ARKOVA">Reportes Obsoletos</h4>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            Esta sección permite a los usuarios consultar y gestionar los reportes obsoletos cargados en el sistema, los mismos pueden ser de tipo técnico o movimiento de bienes.
                        </p>
                        <p style="text-align: justify;">
                            En esta página, el usuario puede visualizar una tabla donde están registrados los reportes existentes que se encuentren obsoletos, observando en ella el tipo de reporte, su nombre, la descripción, la fecha y hora de realización y la foto de cada reporte registrado.
                        </p>
                    </div>
                    <div class="col">
                        <img src="../assets/img/manual/obsolete-reports.jpeg" class="col-md-12 rounded float-end" alt="Reportes Obsoletos">
                    </div>
                </div>
                <p style="text-align: justify;">
                    La tabla cuenta con las siguientes funcionalidades:
                </p>
                <ul class="col">
                    <li>Ordenamiento alfabético ascendente o descendente mediante una flecha en los encabezados de las columnas.</li>
                    <li>Buscador dinámico en la esquina superior derecha, que permite filtrar automáticamente por el tipo de reporte, nombre, fecha o cualquier palabra clave que hayas incluido en la descripción del reporte.</li>
                    <li>Opción para ajustar el número de filas mostradas en la tabla, la cual se encuentra en la esquina superior izquierda y sirve para mejorar el rendimiento al consultar datos.</li>
                    <li>Botones de navegación ("Anterior", paginación numérica y "Siguiente") para explorar múltiples páginas de la tabla. Ubicados en la esquina inferior derecha.</li>
                </ul>
                <p style="text-align: justify;">
                    El encabezado de la tabla incluye botones de control como:
                </p>
                <ul>
                    <li><strong>Botones de selección y deselección múltiple:</strong> esta opción solo está disponiple para el usuario con Rol Administrador y permiten seleccionar o deseleccionar todos los reportes cargados en la tabla.</li>
                    <li><strong>Resturar Reportes:</strong> esta opción solo está disponiple para el usuario con Rol Administrador y permite restaurar 1 o más reportes simultáneamente, para ello, deben estar previamente seleccionados, usando la casilla de selección ubicada en la primera columna de cada registro o usando los botones de selección múltiple si desean restaurar todos los registros cargados en la tabla.</li>
                    <li><strong>Generar Informes:</strong> opciones para exportar los datos de la tabla en formato PDF o Excel:
                        <ul>
                            <li>El archivo PDF se abre en una nueva pestaña, desde donde puede guardarse o imprimirse.</li>
                            <li>El archivo Excel se descarga automáticamente en formato .xlsx, compatible con aplicaciones de hojas de cálculo.</li>
                        </ul>
                    </li>
                </ul>
                <p style="text-align: justify;">
                    Además, la tabla incluye acciones específicas las cuales solo están disponiple para el usuario con Rol Administrador y sirven para la gestión de los reportes obsoletos:
                </p>
                <ul>
                    <li><strong>Editar Reporte:</strong> al hacer clic en este botón, se despliega un formulario donde se puede modificar el tipo de reporte asignado, su nombre, descripción, fecha o sustituir la foto cargada. Los cambios se reflejan de inmediato en la tabla.</li>
                    <li><strong>Restaurar Reporte:</strong> al hacer clic en este botón, se mostrará un modal de confirmación, para evitar que un usuario administrador restaure un registro no deseado por error. Restaurar un Reporte lo que permite es cambiar el estado del reporte de obsoleto a vigente, por consecuente el mismo se mostrará ahora en la tabla de "Reportes Vigentes".</li>
                </ul>

                <h4 id="system-performance-ARKOVA">Métricas de Rendimiento del Sistema</h4>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            Esta sección permite a los usuarios con Rol Administrador consultar y gestionar los usuarios inhabilitados registrados en el sistema.
                        </p>
                        <p style="text-align: justify;">
                            En esta página, el usuario Administrador puede visualizar una tabla donde están registrados los usuarios existentes que se encuentren inhabilitados, observando en ella el nombre de usuario, sus nombres, apellidos, cédula, correo y Rol de cada usuario registrado en la tabla.
                        </p>
                    </div>
                    <div class="col">
                        <img src="../assets/img/manual/system-performance.jpeg" class="col-md-12 rounded float-end" alt="Métricas de Rendimiento ARKOVA">
                    </div>
                </div>
                <p style="text-align: justify;">
                    La tabla cuenta con las siguientes funcionalidades:
                </p>
                <ul class="col">
                    <li>Ordenamiento alfabético ascendente o descendente mediante una flecha en los encabezados de las columnas.</li>
                    <li>Buscador dinámico en la esquina superior derecha, que permite filtrar automáticamente por el nombre de usuario, nombres, apellidos, cédula, correo eléctronico o su Rol asignado.</li>
                    <li>Opción para ajustar el número de filas mostradas en la tabla, la cual se encuentra en la esquina superior izquierda y sirve para mejorar el rendimiento al consultar datos.</li>
                    <li>Botones de navegación ("Anterior", paginación numérica y "Siguiente") para explorar múltiples páginas de la tabla. Ubicados en la esquina inferior derecha.</li>
                </ul>
                <p style="text-align: justify;">
                    El encabezado de la tabla incluye botones de control como:
                </p>
                <ul>
                    <li><strong>Botones de selección y deselección múltiple:</strong> permiten seleccionar o deseleccionar todos los usuarios cargados en la tabla.</li>
                    <li><strong>Habilitar Usuarios:</strong> esta opción permite al usuario administrador habilitar 1 o más perfiles de usuarios simultáneamente, para ello, deben estar previamente seleccionados, usando la casilla de selección ubicada en la primera columna de cada registro o usando los botones de selección múltiple si desea habilitar todos los perfiles cargados en la tabla.</li>
                    <li><strong>Generar Informes:</strong> opciones para exportar los datos de la tabla en formato PDF o Excel:
                        <ul>
                            <li>El archivo PDF se abre en una nueva pestaña, desde donde puede guardarse o imprimirse.</li>
                            <li>El archivo Excel se descarga automáticamente en formato .xlsx, compatible con aplicaciones de hojas de cálculo.</li>
                        </ul>
                    </li>
                </ul>
                <p style="text-align: justify;">
                    Además, la tabla incluye una acción específica para la gestión de los usuarios:
                </p>
                <ul>
                    <li><strong>Editar Usuario:</strong> al hacer clic en este botón, se despliega un formulario donde se puede modificar todos los datos del perfil de usuario como: su nombre de usuario, nombres, apellidos cédula de identidad, correo eléctronico, la contraseña o el rol asignado. Se pueden cambiar todos los campos o solo uno en especifico. Los cambios se reflejan de inmediato en la tabla.</li>
                    <li><strong>Habilitar Usuario:</strong> al hacer clic en este botón, se mostrará un modal de confirmación, para evitar que un usuario administrador habilite un perfil de usuario por error. Habilitar un perfil de usuario lo que permite es cambiar el estado del perfil de inhabilitado a habilitado, por consecuente el mismo se mostrará ahora en la tabla de "Gestionar Usuarios" y se permitirá nuevamente su acceso al sistema.</li>
                </ul>

                <h3 id="personal-ARKOVA">Sección de Personal</h3>
                <h4 id="users-ARKOVA">Gestionar Usuarios/Consulta Usuarios</h4>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            Esta sección permite a los usuarios con Rol Administrador consultar y gestionar los usuarios registrados en el sistema.
                        </p>
                        <p style="text-align: justify;">
                            En esta página, el usuario Administrador puede visualizar una tabla donde están registrados los usuarios existentes que se encuentren habilitados, observando en ella el nombre de usuario, sus nombres, apellidos, cédula, correo y Rol de cada usuario registrado.
                        </p>
                    </div>
                    <div class="col">
                        <img src="../assets/img/manual/users.jpeg" class="col-md-12 rounded float-end" alt="Usuarios ARKOVA">
                    </div>
                </div>
                <p style="text-align: justify;">
                    La tabla cuenta con las siguientes funcionalidades:
                </p>
                <ul class="col">
                    <li>Ordenamiento alfabético ascendente o descendente mediante una flecha en los encabezados de las columnas.</li>
                    <li>Buscador dinámico en la esquina superior derecha, que permite filtrar automáticamente por el nombre de usuario, nombres, apellidos, cédula, correo eléctronico o su Rol asignado.</li>
                    <li>Opción para ajustar el número de filas mostradas en la tabla, la cual se encuentra en la esquina superior izquierda y sirve para mejorar el rendimiento al consultar datos.</li>
                    <li>Botones de navegación ("Anterior", paginación numérica y "Siguiente") para explorar múltiples páginas de la tabla. Ubicados en la esquina inferior derecha.</li>
                </ul>
                <p style="text-align: justify;">
                    El encabezado de la tabla incluye botones de control como:
                </p>
                <ul>
                    <li><strong>Botones de selección y deselección múltiple:</strong> permiten seleccionar o deseleccionar todos los usuarios cargados en la tabla.</li>
                    <li><strong>Crear Nuevo Usuario:</strong> abre un formulario para registrar un nuevo perfil de usuario. Lo primero es asignar un nombre de usuario, luego ingresar los datos personales como: nombres, apellidos cédula de identidad, correo eléctronico, asiganar una contraseña, confirmarla y por último seleccionar el Rol de usuario que se desea ortorgar a ese perfil: Técnico o Administrador, para finalizar el proceso debe confirmar con el botón "Registrar Usuario". Una vez creado, la tabla se actualizará automáticamente para reflejar el nuevo registro. Además, se resalta que todos los campos del registro son obligatorios.</li>
                    <li><strong>Inhabilitar Usuarios:</strong> esta opción permite al usuario administrador inhabilitar 1 o más perfiles de usuarios simultáneamente, para ello, deben estar previamente seleccionados, usando la casilla de selección ubicada en la primera columna de cada registro o usando los botones de selección múltiple si desea Inhabilitar todos los perfiles cargados en la tabla. Tenga mucho cuidado con está acción para no inhabilitar por error su propio perfil de usuario.</li>
                    <li><strong>Generar Informes:</strong> opciones para exportar los datos de la tabla en formato PDF o Excel:
                        <ul>
                            <li>El archivo PDF se abre en una nueva pestaña, desde donde puede guardarse o imprimirse.</li>
                            <li>El archivo Excel se descarga automáticamente en formato .xlsx, compatible con aplicaciones de hojas de cálculo.</li>
                        </ul>
                    </li>
                </ul>
                <p style="text-align: justify;">
                    Además, la tabla incluye una acción específica para la gestión de los usuarios:
                </p>
                <ul>
                    <li><strong>Editar Usuario:</strong> al hacer clic en este botón, se despliega un formulario donde se puede modificar todos los datos del perfil de usuario como: su nombre de usuario, nombres, apellidos cédula de identidad, correo eléctronico, la contraseña o el rol asignado. Se pueden cambiar todos los campos o solo uno en especifico. Los cambios se reflejan de inmediato en la tabla.</li>
                    <li><strong>Inhabilitar Usuario:</strong> al hacer clic en este botón, se mostrará un modal de confirmación, para evitar que un usuario administrador inhabilite un perfil de usuario por error. Inhabilitar un perfil de usuario lo que permite es cambiar el estado del perfil de habilitado a inhabilitado, por consecuente el mismo se mostrará ahora en la tabla de "Usuarios Inhabilitados" y se restrigirá su acceso al sistema.</li>
                </ul>

                <h4 id="disable-users-ARKOVA">Usuarios Inhabilitados</h4>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            Esta sección permite a los usuarios con Rol Administrador consultar y gestionar los usuarios inhabilitados registrados en el sistema.
                        </p>
                        <p style="text-align: justify;">
                            En esta página, el usuario Administrador puede visualizar una tabla donde están registrados los usuarios existentes que se encuentren inhabilitados, observando en ella el nombre de usuario, sus nombres, apellidos, cédula, correo y Rol de cada usuario registrado en la tabla.
                        </p>
                    </div>
                    <div class="col">
                        <img src="../assets/img/manual/diable-users.jpeg" class="col-md-12 rounded float-end" alt="Usuarios Inhabilitados ARKOVA">
                    </div>
                </div>
                <p style="text-align: justify;">
                    La tabla cuenta con las siguientes funcionalidades:
                </p>
                <ul class="col">
                    <li>Ordenamiento alfabético ascendente o descendente mediante una flecha en los encabezados de las columnas.</li>
                    <li>Buscador dinámico en la esquina superior derecha, que permite filtrar automáticamente por el nombre de usuario, nombres, apellidos, cédula, correo eléctronico o su Rol asignado.</li>
                    <li>Opción para ajustar el número de filas mostradas en la tabla, la cual se encuentra en la esquina superior izquierda y sirve para mejorar el rendimiento al consultar datos.</li>
                    <li>Botones de navegación ("Anterior", paginación numérica y "Siguiente") para explorar múltiples páginas de la tabla. Ubicados en la esquina inferior derecha.</li>
                </ul>
                <p style="text-align: justify;">
                    El encabezado de la tabla incluye botones de control como:
                </p>
                <ul>
                    <li><strong>Botones de selección y deselección múltiple:</strong> permiten seleccionar o deseleccionar todos los usuarios cargados en la tabla.</li>
                    <li><strong>Habilitar Usuarios:</strong> esta opción permite al usuario administrador habilitar 1 o más perfiles de usuarios simultáneamente, para ello, deben estar previamente seleccionados, usando la casilla de selección ubicada en la primera columna de cada registro o usando los botones de selección múltiple si desea habilitar todos los perfiles cargados en la tabla.</li>
                    <li><strong>Generar Informes:</strong> opciones para exportar los datos de la tabla en formato PDF o Excel:
                        <ul>
                            <li>El archivo PDF se abre en una nueva pestaña, desde donde puede guardarse o imprimirse.</li>
                            <li>El archivo Excel se descarga automáticamente en formato .xlsx, compatible con aplicaciones de hojas de cálculo.</li>
                        </ul>
                    </li>
                </ul>
                <p style="text-align: justify;">
                    Además, la tabla incluye una acción específica para la gestión de los usuarios:
                </p>
                <ul>
                    <li><strong>Editar Usuario:</strong> al hacer clic en este botón, se despliega un formulario donde se puede modificar todos los datos del perfil de usuario como: su nombre de usuario, nombres, apellidos cédula de identidad, correo eléctronico, la contraseña o el rol asignado. Se pueden cambiar todos los campos o solo uno en especifico. Los cambios se reflejan de inmediato en la tabla.</li>
                    <li><strong>Habilitar Usuario:</strong> al hacer clic en este botón, se mostrará un modal de confirmación, para evitar que un usuario administrador habilite un perfil de usuario por error. Habilitar un perfil de usuario lo que permite es cambiar el estado del perfil de inhabilitado a habilitado, por consecuente el mismo se mostrará ahora en la tabla de "Gestionar Usuarios" y se permitirá nuevamente su acceso al sistema.</li>
                </ul>

                <h4 id="binnacle-ARKOVA">Bitácora del Sistema</h4>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            Esta sección solo está disponible para los usuarios con Rol Administrador y les permite consultar y gestionar una aditoría general a las acciones realizadas por cada perfil de usuario en el sistema.
                        </p>
                        <p style="text-align: justify;">
                            En esta página, el usuario administrador puede visualizar una tabla donde están registradas las acciones realizadas por cada perfil de usuario en el sistema incluyendole,
                            en dicha tabla puede observar un id, el nombre de usuario, la fecha con su hora, y la acción que fue efectuada dentro del sistema. permitiendole así custodear que cada perfil no haya roto algo sin querer o de mala fe.
                        </p>
                    </div>
                    <div class="col">
                        <img src="../assets/img/manual/binnacle.jpeg" class="col-md-12 rounded float-end" alt="Bitácora ARKOVA">
                    </div>
                </div>
                <p style="text-align: justify;">
                    La tabla cuenta con las siguientes funcionalidades:
                </p>
                <ul class="col">
                    <li>Ordenamiento alfabético ascendente o descendente mediante una flecha en los encabezados de las columnas.</li>
                    <li>Buscador dinámico en la esquina superior derecha, que permite filtrar automáticamente por el nombre de usuario, la fecha o cualquier palabra clave que corresponda a alguna acción efectuada por un perfil de usuario en el sistema.</li>
                    <li>Opción para ajustar el número de filas mostradas en la tabla, la cual se encuentra en la esquina superior izquierda y sirve para mejorar el rendimiento al consultar datos.</li>
                    <li>Botones de navegación ("Anterior", paginación numérica y "Siguiente") para explorar múltiples páginas de la tabla. Ubicados en la esquina inferior derecha.</li>
                </ul>
                <p style="text-align: justify;">
                    El encabezado de la tabla incluye botones de control como:
                </p>
                <ul>
                    <li><strong>Generar Informes:</strong> opciones para exportar los datos de la tabla en formato PDF o Excel:
                        <ul>
                            <li>El archivo PDF se abre en una nueva pestaña, desde donde puede guardarse o imprimirse.</li>
                            <li>El archivo Excel se descarga automáticamente en formato .xlsx, compatible con aplicaciones de hojas de cálculo.</li>
                        </ul>
                    </li>
                </ul>

                <h3 id="support-ARKOVA">Sección de Soporte</h3>
                <h4 id="faq-ARKOVA">Preguntas Frecuentes</h4>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            En esta página los usuarios podrán aclarar sus dudas, mediante un menú acordeón que
                            abarca 8 respuestas a las preguntas más recurrentes. Y si por alguna razón su duda no es respondida
                            allí mismo se le muestra un mensaje que le permite dirigirse rápidamente al manual de usuario, dónde se acarban
                            más situaciones y se explican cada una de las opciones y secciones del sistema.
                        </p>
                    </div>
                    <div class="col"><img src="../assets/img/manual/faq.jpeg" class="col-md-12 rounded float-end" alt="faq-ARKOVA"></div>
                </div>

                <h4 class="mt-2" id="user-manual-ARKOVA">Manual del Sistema</h4>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            Es la página en la que se encuentra ahora mismo, la misma sirve para orientar a los usuarios,
                            en las opciones, funciones y acciones del sistema. En pocas palabras saber dónde se úbica
                            cada cosa y como se deben usar dichas opciones.
                        </p>
                    </div>
                    <div class="col"><img src="../assets/img/manual/manual.jpeg" class="col-md-12 rounded float-end" alt="manual-ARKOVA"></div>
                </div>

                <h4 class="mt-2" id="db-backup-ARKOVA">Respaldo/Restauración de la Base de Datos</h4>
                <div class="row mt-4">
                    <div class="col">
                        <p style="text-align: justify;">
                            Esta página solo está diponible para usuarios de Rol Administrador
                            con ella el mismo puede respaldar la base de datos haciendo click
                            en el botón "Crear un Punto de Restauración" de igual forma puede restaurar la misma desplegando
                            el campo de Puntos de Restauración, escoger el punto deseado y después hacer click en el botón "Restaurar"
                            para cargar la base de datos.
                        </p>
                    </div>
                    <div class="col"><img src="../assets/img/manual/backup.jpeg" class="col-md-12 rounded float-end" alt="bd-backup"></div>
                    <p class="mt-2" style="text-align: justify;">
                        Si algún proceso falla el usuario será notificado con las alertas flotantes.
                    </p>
                </div>

                <hr id="html-basics" class="section-break">
                <p style="color:grey;">©2024 Jesús Vielma y personal de la Gerencia de Tecnología en A.C.BBVVA (CC BY 3.0). Revision vE1.0</p>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <?php require 'footer.php' ?>
</body>
</html>