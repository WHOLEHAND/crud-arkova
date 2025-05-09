<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARKOVA - Inicio de Sesión</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">
    
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/all.min.css" rel="stylesheet">

    <!-- Metadatos para convertir el sistema en una (PWA) Aplicación Web Progresiva -->
    <link rel="manifest" href="../manifest.json">

    <style>
        body {
            background: url('/crud-arkova/app/assets/img/BVA.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* Capa traslúcida sobre el fondo */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Ajusta la opacidad según prefieras */
            z-index: -1;
        }

        .login-container {
            width: 346px;
            max-width: 400px;
            padding: 20px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9);
            border: solid 2px;
            border-color: #bbb;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: absolute;
            right: 5%;
            top: 38%;
            transform: translateY(-50%);
        }
        .logo {
            font-size: 2em;
            text-align: center;
            font-weight: bold;
        }
        .login-btn {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        /* Estilos para el popup flotante */
        .response-popup {
            position: fixed;
            top: 20px;
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
    <div class="container">
        <div class="login-container">
            <div class="logo mb-4">
                <img src="/crud-arkova/app/assets/brand/ARKOVA-logo-BK.svg" alt="ARKOVA Logo" style="width: 100px;">
            </div>
            <h3 class="text-center">Inicio de Sesión</h3>
            <form id="login-form" class="needs-validation" action="login_process.php" method="POST" novalidate>
                <div class="form-group input-group mb-2 has-validation">
                    <span class="input-group-text bg-primary"><i class="fa-solid fa-user" style="color:#fff;"></i></span>
                    <div class="form-floating">
                        <input type="text" name="username" class="form-control" id="floatingInputGroup1" placeholder="Nombre de usuario" required>
                        <label for="floatingInputGroup1" style="color: #595c5f;">Nombre de usuario</label>
                    </div>
                    <div class="valid-feedback">
                        Ok.
                    </div>
                    <div class="invalid-feedback">
                        Debe Ingresar un Nombre de Usuario.
                    </div>
                </div>

                <div class="form-group input-group has-validation">
                    <span class="input-group-text bg-primary"><i class="fa-solid fa-lock" style="color:#fff;"></i></span>
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control" id="floatingInputGroup2" placeholder="Contraseña" required>
                        <label for="floatingInputGroup2" style="color: #595c5f;">Contraseña</label>
                    </div>
                    <div class="valid-feedback">
                        Ok.
                    </div>
                    <div class="invalid-feedback">
                        Debe Ingresar su Contraseña.
                    </div>
                </div>

                <div class="form-check mb-3 mt-1">
                    <input type="checkbox" class="form-check-input" id="remember" onclick="toggleRemember()">
                    <label class="form-check-label" for="remember">Recuerdame</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 login-btn mb-4">INGRESAR</button>
            </form>
        </div>
    </div>

    <!-- Alertas Flotantes -->
    <div id="responsePopup" class="response-popup"></div>

    <!-- Footer -->
    <?php require 'footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script>
        (() => {
            'use strict';

                // Obtener todos los formularios a los que queremos aplicar estilos de validación de Bootstrap personalizados
                const forms = document.querySelectorAll('.needs-validation');
    
                // Bucle sobre ellos y evitar el envío
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', async event => {
                        event.preventDefault();
                        event.stopPropagation();

                        // Reseteamos las clases de error previas en los campos
                        const usernameField = document.getElementById("floatingInputGroup1");
                        const passwordField = document.getElementById("floatingInputGroup2");

                        usernameField.classList.remove('is-invalid', 'is-valid');
                        passwordField.classList.remove('is-invalid', 'is-valid');

                        // Hacemos la solicitud al servidor
                        const formData = new FormData(form);
                        const response = await fetch("../logic/login_process.php", {
                            method: "POST",
                            body: formData,
                        });
                        const result = await response.json();

                        // Verificamos los errores del servidor y aplicamos las clases correspondientes
                            if (result.error) {
                            if (result.message === "El usuario no existe.") {
                                usernameField.classList.add('is-invalid').focus();
                            } else if (result.message === "Su usuario ha sido inhabilitado.") {
                                usernameField.classList.add('is-invalid').focus();
                            } else if (result.message === "Contraseña incorrecta.") {
                                passwordField.classList.add('is-invalid').focus();
                            }
                        } else {
                            // Si el login es correcto, aplicamos un estilo positivo
                            usernameField.classList.add('is-valid').focus();
                            passwordField.classList.add('is-valid');
                            // Redirigir si el login es exitoso
                            window.location.href = result.redirect;
                        }

                        // Siempre añadir la clase 'was-validated' para que se muestren los estilos de validación
                        form.classList.add('was-validated');
                    }, false);
                });
        })();

        // JavaScript para la funcionalidad del botón Recuerdame
        window.onload = function() {
            const usernameField = document.querySelector("input[name='username']");
            const passwordField = document.querySelector("input[name='password']");
            const rememberCheckbox = document.getElementById("remember");

            // Función para verificar si los campos están autocompletados por el navegador
            function checkAutofill() {
                if (usernameField.value && passwordField.value) {
                    rememberCheckbox.checked = true;  // Si hay valores, marcar el checkbox
                }
            }

            // Verificar inicialmente si los valores están autocompletados
            checkAutofill();

            // Añadir un listener a los campos para detectar cambios
            usernameField.addEventListener('input', function() {
                checkAutofill();  // Revalidar si los campos se completaron
            });

            passwordField.addEventListener('input', function() {
                checkAutofill();  // Revalidar si los campos se completaron
            });
        };

        // Función para limpiar los campos si el checkbox es desmarcado
        function toggleRemember() {
            const usernameField = document.querySelector("input[name='username']");
            const passwordField = document.querySelector("input[name='password']");

            if (!document.getElementById("remember").checked) {
                // Si desmarcas el checkbox, limpiar los campos
                usernameField.value = "";
                passwordField.value = "";
            }
        }

        // JavaScript para mostrar las alertas
        document.getElementById("login-form").addEventListener("submit", async function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const response = await fetch("../logic/login_process.php", {
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
    </script>
</body>
</html>