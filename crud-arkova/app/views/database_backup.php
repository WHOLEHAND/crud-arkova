<?php
// Conexión a la Base de Datos
require '../config/database.php';

// Header
require 'header.php';

// Verificar si el usuario está autenticado y si tiene el nivel de usuario adecuado
$user_level = $_SESSION['level_user'] ?? null;

if ($user_level !== 0) {
    // Redirigir al usuario si no tiene nivel de administrador
    header("Location: /crud-arkova/app/index.php"); // Puedes cambiar 'access_denied.php' a cualquier página de redirección
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>RESPALDO DE LA BASE DE DATOS</title>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Author -->
    <meta name="description" content="Pantalla de Crear Respaldo para la Base de Datos">
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

        /* Estilos para el popup flotante */
        .response-popup {
            position: fixed;
            top: 70px;
            right: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            z-index: 1000;
            display: none; /* Oculto por defecto */
        }

        .response-popup.show {
            display: block;
            animation: fadeOut 5s forwards;
        }

        .response-popup p {
            margin: 0;
        }

        .response-icon {
            margin-right: 8px;
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; display: none; }
        }
    </style>
</head>
<body>
    <!-- div class="center-container" -->
    <div class="container py-3">
        <h2 class="text-center mb-4">Respaldo de la Base de Datos</h2>

		<div class="col-md-6 container">
            <!-- Botón para crear el punto de restauración (usando un formulario POST) -->
            <form id="backup-form" action="../logic/backup_process.php" method="POST">
                <button type="submit" class="btn btn-primary mb-3 w-100"><i class="fa-solid fa-boxes-packing"></i> Crear un Punto de Restauración</button>
            </form>
			<form id="restore-form" action="../logic/restore_process.php" method="POST">
				<div class="mb-3">
					<label for="restorePoint" class="form-label">Puntos de Restauración:</label>
					<select name="restorePoint" id="restorePoint" class="form-select">
						<option value="" disabled selected>Selecciona un punto de restauración</option>
						<?php
						include_once '../config/database.php';
						$ruta = BACKUP_PATH;
						if (is_dir($ruta)) {
							if ($aux = opendir($ruta)) {
								while (($archivo = readdir($aux)) !== false) {
									if ($archivo != "." && $archivo != "..") {
										$nombrearchivo = str_replace(".sql", "", $archivo);
										$nombrearchivo = str_replace("-", ":", $nombrearchivo);
										$ruta_completa = $ruta . $archivo;
										if (is_dir($ruta_completa)) {
										} else {
											echo '<option value="' . $ruta_completa . '">' . $nombrearchivo . '</option>';
										}
									}
								}
								closedir($aux);
							}
						} else {
							echo $ruta . " No es ruta válida";
						}
						?>
					</select>
				</div>
				<div><button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-recycle"></i> Restaurar</button></div>
			</form>
		</div>
	</div>

    <!-- Alertas Flotantes -->
    <div id="responsePopup" class="response-popup"></div>

    <!-- Footer -->
    <?php require 'footer.php' ?>

    <!-- JavaScript para mostrar las alertas y manejar ambos procesos (respaldo y restauración) -->
    <script>
        // Acción para el formulario de restauración
        document.getElementById("restore-form").addEventListener("submit", async function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const response = await fetch("../logic/restore_process.php", {
                method: "POST",
                body: formData,
            });

            const result = await response.json();
            const responsePopup = document.getElementById("responsePopup");

            responsePopup.innerHTML = ''; // Limpiar el contenido previo

            if (result.error) {
                responsePopup.style.backgroundColor = "red";

                if (typeof result.message === "object") {
                    // Mostrar errores individuales si existen varios
                    for (const [key, value] of Object.entries(result.message)) {
                        responsePopup.innerHTML += `<p><i class="fa-solid fa-xmark response-icon"></i>${value}</p>`;
                    }
                } else {
                    responsePopup.innerHTML = `<i class="fa-solid fa-xmark response-icon"></i>${result.message}`;
                }
            } else {
                responsePopup.style.backgroundColor = "LimeGreen";
                responsePopup.innerHTML = `<i class="fa-solid fa-check response-icon"></i>${result.message}`;
                // Redirigir si se proporciona una URL de redireccionamiento
                if (result.redirect) {
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 2000);
                }
            }

            // Mostrar el popup
            responsePopup.classList.add("show");
            // Ocultar el popup después de 5 segundos
            setTimeout(() => {
                responsePopup.classList.remove("show");
            }, 5000);
        });

        // Acción para el formulario de "Crear un Punto de Restauración"
        document.getElementById("backup-form").addEventListener("submit", async function (event) {
            event.preventDefault(); // Evitar el comportamiento por defecto (redirigir al archivo)

            const response = await fetch("../logic/backup_process.php", {
                method: "POST",
            });

            const result = await response.json();
            const responsePopup = document.getElementById("responsePopup");

            responsePopup.innerHTML = ''; // Limpiar el contenido previo

            if (result.error) {
                responsePopup.style.backgroundColor = "red";

                if (typeof result.message === "object") {
                    // Mostrar errores individuales si existen varios
                    for (const [key, value] of Object.entries(result.message)) {
                        responsePopup.innerHTML += `<p><i class="fa-solid fa-xmark response-icon"></i>${value}</p>`;
                    }
                } else {
                    responsePopup.innerHTML = `<i class="fa-solid fa-xmark response-icon"></i>${result.message}`;
                }
            } else {
                responsePopup.style.backgroundColor = "LimeGreen";
                responsePopup.innerHTML = `<i class="fa-solid fa-check response-icon"></i>${result.message}`;
                // Redirigir si se proporciona una URL de redireccionamiento
                if (result.redirect) {
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 2000);
                }
            }

            // Mostrar el popup
            responsePopup.classList.add("show");
            // Ocultar el popup después de 5 segundos
            setTimeout(() => {
                responsePopup.classList.remove("show");
            }, 5000);
        });
    </script>
</body>
</html>