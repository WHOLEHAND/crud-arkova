<?php
require '../config/database.php';
/**
 * Script para cargar datos de lado del servidor con PHP y MySQL
 *
 * @author wholehand
 * @link https://github.com/wholehand
 * @license: MIT
 */

require 'header.php';

// Verificar si el usuario está autenticado y si tiene el nivel de usuario adecuado
$user_level = $_SESSION['level_user'] ?? null;

if ($user_level !== 0) {
    // Redirigir al usuario si no tiene nivel de administrador
    header("Location: /crud-arkova/app/index.php"); // Puedes cambiar 'access_denied.php' a cualquier página de redirección
    exit();
}

// Modificamos la consulta SQL para obtener solo los usuarios activos sin incluir el password y el state_user
$sqlUsers = "SELECT id, user_name, names, last_names, identity_card, email, 
                    CASE 
                        WHEN level_user = 0 THEN 'Administrador' 
                        WHEN level_user = 1 THEN 'Técnico' 
                        ELSE 'Desconocido' 
                    END AS role
             FROM users
             WHERE state_user = 1"; // Solo selecciona usuarios activos
$users = $conn->query($sqlUsers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>GESTIÓN DE PERFILES DE USUARIO</title>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Buscar datos en tiempo real con PHP, MySQL y AJAX">
    <meta name="author" content="Jesús Vielma @wholehand">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">

    <!-- Iconos de Font Awesome -->
    <link href="/crud-arkova/app/assets/css/all.min.css" rel="stylesheet">

    <!-- Enlace a Bootstrap -->
    <link href="/crud-arkova/app/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Enlaces a DataTables CSS y JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- Invoca y Traduce al metodo DataTable() -->
    <script>
      $(function () {
        $("#tbl_users").DataTable({
          language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla =(",
            sInfo:
              "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty:
              "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
              sFirst: "Primero",
              sLast: "Último",
              sNext: "Siguiente",
              sPrevious: "Anterior",
            },
            oAria: {
              sSortAscending:
                ": Activar para ordenar la columna de manera ascendente",
              sSortDescending:
                ": Activar para ordenar la columna de manera descendente",
            },
            buttons: {
              copy: "Copiar",
              colvis: "Visibilidad",
            },
            decimal: ",",
            thousands: ".",
          },
          lengthMenu: [
            [5, 10, 20, 30, 50, -1],
            [5, 10, 20, 30, 50, "Todos"],
          ],
        });
      });
    </script>

    <style>
        body {
            position: relative;
            padding-bottom: 3em;
        }
        div.container {
            max-width: 1200px;
        }

        .protec_system {
            display: none;
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
            z-index: 1082;
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
    
    <div class="container py-3">
        <h2 class="text-center">Gestionar Usuarios</h2>
        
        <div class="row justify-content-center mt-4">
            <div class="col-auto">
                <button id="selectAll" class="btn btn-light"><i class="fa-regular fa-square-check"></i> Seleccionar Todos</button>
            </div>
            <div class="col-auto">
                <button id="deselectAll" class="btn btn-light"><i class="fa-regular fa-square"></i> No Seleccionar Ninguno</button>
            </div>
            <div class="col-auto">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newUserModal"><i class="fa-solid fa-user-plus"></i> Crear Nuevo Usuario</a>
            </div>
            <div class="col-auto">
                <button id="confirmDisableUserMulti" class="btn btn-secondary"><i class="fa-solid fa-user-slash"></i> Inhabilitar Usuarios</button>
                <form id="disableUserMultiForm" action="disableUserMultiModal.php" method="post" style="display: none;">
                    <input type="hidden" name="selected_ids" id="selectedIds">
                </form>
            </div>
            <div class="col-auto">
                <a href="/crud-arkova/app/pdf reports/users_PDF.php" target="_blank" class="btn btn-outline-danger" title="Generar Informe PDF"><i class="fa-solid fa-file-pdf"></i> PDF</a>
            </div>
            <div class="col-auto">
                <a href="/crud-arkova/app/excel reports/users_excel.php" target="_blank" class="btn btn-outline-success" title="Generar Informe Excel"><i class="fa-solid fa-file-excel"></i> Excel</a>
            </div>
        </div>
        <br>

        <table
          id="tbl_users"
          class="table table-sm table-striped table-hover mt-4"
          style="width: 100%"
        >
          <thead>
            <tr>
                <th>#</th>
                <th>Usuario</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cédula</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acción</th>
            </tr>
          </thead>

          <tfoot>
            <tr>
                <th>#</th>
                <th>Usuario</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cédula</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acción</th>
            </tr>
          </tfoot>

          <tbody>
                <?php while ($row_users = $users->fetch_assoc()) { ?>
                    <tr>
                        <td><input class="form-check-input" type="checkbox" name="selected_users[]" value="<?php echo $row_users['id']; ?>"></td>
                        <td><?php echo $row_users['user_name']; ?></td>
                        <td><?php echo $row_users['names']; ?></td>
                        <td><?php echo $row_users['last_names']; ?></td>
                        <td><?php echo $row_users['identity_card']; ?></td>
                        <td><?php echo $row_users['email']; ?></td>
                        <td><?php echo $row_users['role']; ?></td>
                        <td class="align-middle">
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal" title="Editar Usuario" data-bs-id="<?= $row_users['id']; ?>"><i class="fa-solid fa-user-pen"></i></a>
                            
                            <!-- Aplicamos la clase protec_system dinámicamente para hacer que un usuario no pueda inhabilitar su propio perfil de usuario -->
                            <a 
                                href="#" 
                                class="btn btn-sm btn-secondary openMove <?= $row_users['user_name'] == $_SESSION['user_name'] ? 'protec_system' : '' ?>" 
                                data-bs-toggle="modal" 
                                data-bs-target="#disableUserModal" 
                                title="Inhabilitar Usuario" 
                                data-bs-id="<?= $row_users['id']; ?>">
                                <i class="fa-solid fa-user-slash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
      </div>
    </div>
    <br>
    <br>
    <br>

    <!-- Alertas Flotantes -->
    <div id="responsePopup" class="response-popup"></div>

    <!-- Footer -->
    <?php require 'footer.php' ?>

    <!-- Ventanas Modales requeridas -->
    <?php require 'newUserModal.php'; ?>
    <?php require 'editUserModal.php'; ?>
    <?php require 'disableUserModal.php'; ?>
    
    <!-- Funciones de solicitud AJAX -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Editar usuario
            const editUserModal = document.getElementById('editUserModal');
            editUserModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-bs-id');

                // Verificar si el ID está siendo capturado correctamente
                console.log("Edit User ID:", userId);

                // Realiza una solicitud para obtener los datos del usuario
                fetch(`/crud-arkova/app/logic/get_user_data.php?id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error(data.error);
                        } else {
                            // Llenar los campos del modal con los datos del usuario
                            document.getElementById('editUserId').value = data.id;
                            document.getElementById('editUsername').value = data.user_name;
                            document.getElementById('editNames').value = data.names;
                            document.getElementById('editLastNames').value = data.last_names;
                            document.getElementById('editIdentityCard').value = data.identity_card;
                            document.getElementById('editEmail').value = data.email;
                            document.getElementById('editRole').value = data.level_user;

                            // Limpiar los campos de contraseña por seguridad
                            document.getElementById('editPassword').value = '';
                            document.getElementById('confirmPassword').value = '';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            // Desactivar usuario
            // Al hacer clic en el botón de inhabilitar
            let disableUserModal = document.getElementById('disableUserModal');
            disableUserModal.addEventListener('shown.bs.modal', event => {
                let button = event.relatedTarget;
                let id = button.getAttribute('data-bs-id');
                disableUserModal.querySelector('.modal-footer #id').value = id;
            });
        });

        // Selección de filas
        const selectAllBtn = document.querySelector('#selectAll');
        const deselectAllBtn = document.querySelector('#deselectAll');
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_users[]"]');
        const rows = document.querySelectorAll('tbody tr');

        function updateRowSelection() {
            checkboxes.forEach((checkbox, index) => {
                if (checkbox.checked) {
                    rows[index].classList.add('table-active');
                } else {
                    rows[index].classList.remove('table-active');
                }
            });
        }

        selectAllBtn.addEventListener('click', (e) => {
            e.preventDefault();
            checkboxes.forEach(checkbox => checkbox.checked = true);
            updateRowSelection();
        });

        deselectAllBtn.addEventListener('click', (e) => {
            e.preventDefault();
            checkboxes.forEach(checkbox => checkbox.checked = false);
            updateRowSelection();
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateRowSelection);
        });

        // Modal Inhabilitar Multiples Usuarios
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('confirmDisableUserMulti').addEventListener('click', () => {
                const selectedIds = Array.from(document.querySelectorAll('input[name="selected_users[]"]:checked'))
                    .map(checkbox => checkbox.value)
                    .join(',');

                if (selectedIds.length === 0) {
                    alert("No has seleccionado ningún usuario.");
                    return; // Salir si no hay usuarios seleccionados
                }

                const confirmAction = confirm("¿Estás seguro de que deseas inhabilitar los usuarios seleccionados?");
                if (confirmAction) {
                    document.getElementById('selectedIds').value = selectedIds;
                    document.getElementById('disableUserMultiForm').submit();
                }
            });
        });

        // JavaScript para mostrar las alertas con los mensajes del modal de crear usuarios
        document.getElementById("registerForm").addEventListener("submit", async function (event) {
            event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada

            const formData = new FormData(event.target); // Recopilar datos del formulario
            const response = await fetch(event.target.action, { // Usar la acción del formulario como URL
                method: "POST",
                body: formData,
            });

            const result = await response.json(); // Procesar la respuesta como JSON
            const responsePopup = document.getElementById("responsePopup");

            responsePopup.innerHTML = ''; // Limpiar el contenido previo de la alerta

            if (result.error) {
                responsePopup.style.backgroundColor = "red";

                if (typeof result.message === "object") {
                    // Mostrar errores individuales si es un objeto
                    for (const [key, value] of Object.entries(result.message)) {
                        responsePopup.innerHTML += `<p><i class="fa-solid fa-xmark response-icon"></i>${value}</p>`;
                    }
                } else {
                    responsePopup.innerHTML = `<i class="fa-solid fa-xmark response-icon"></i>${result.message}`;
                }
            } else {
                responsePopup.style.backgroundColor = "LimeGreen";
                responsePopup.innerHTML = `<i class="fa-solid fa-check response-icon"></i>${result.message}`;

                if (result.redirect) {
                    // Si se proporciona una URL de redirección, redirigir
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 2000);
                } else {
                    // Si se debe recargar la página
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('newUserModal'));
                        if (modal) {
                            modal.hide();
                        }

                        // Recargar la página después de cerrar el modal
                        setTimeout(() => {
                            location.reload();
                        }, 500); // Pequeño retraso para garantizar que el modal haya cerrado completamente
                    }, 1000);
                }

                // Cerrar el modal automáticamente después de un registro exitoso
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('newUserModal'));
                    if (modal) {
                        modal.hide();
                    }
                }, 2000);
            }

            // Mostrar el popup
            responsePopup.classList.add("show");
            // Ocultar el popup después de 5 segundos
            setTimeout(() => {
                responsePopup.classList.remove("show");
            }, 5000);
        });

        // JavaScript para mostrar las alertas con los mensajes del modal de editar usuarios
        document.getElementById("editUserForm").addEventListener("submit", async function (event) {
            event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada

            const formData = new FormData(event.target); // Recopilar datos del formulario
            const response = await fetch(event.target.action, { // Usar la acción del formulario como URL
                method: "POST",
                body: formData,
            });

            const result = await response.json(); // Procesar la respuesta como JSON
            const responsePopup = document.getElementById("responsePopup");

            responsePopup.innerHTML = ''; // Limpiar el contenido previo de la alerta

            if (result.error) {
                responsePopup.style.backgroundColor = "red";

                if (typeof result.message === "object") {
                    // Mostrar errores individuales si es un objeto
                    for (const [key, value] of Object.entries(result.message)) {
                        responsePopup.innerHTML += `<p><i class="fa-solid fa-xmark response-icon"></i>${value}</p>`;
                    }
                } else {
                    responsePopup.innerHTML = `<i class="fa-solid fa-xmark response-icon"></i>${result.message}`;
                }
            } else {
                responsePopup.style.backgroundColor = "LimeGreen";
                responsePopup.innerHTML = `<i class="fa-solid fa-check response-icon"></i>${result.message}`;

                if (result.redirect) {
                    // Si se proporciona una URL de redirección, redirigir
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 2000);
                } else {
                    // Si se debe recargar la página
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
                        if (modal) {
                            modal.hide();
                        }

                        // Recargar la página después de cerrar el modal
                        setTimeout(() => {
                            location.reload();
                        }, 500); // Pequeño retraso para garantizar que el modal haya cerrado completamente
                    }, 1000);
                }

                // Cerrar el modal automáticamente después de un registro exitoso
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
                    if (modal) {
                        modal.hide();
                    }
                }, 2000);
            }

            // Mostrar el popup
            responsePopup.classList.add("show");
            // Ocultar el popup después de 5 segundos
            setTimeout(() => {
                responsePopup.classList.remove("show");
            }, 5000);
        });

        // JavaScript para mostrar las alertas con los mensajes del modal de inhabilitar usuarios
        document.getElementById("disableUserForm").addEventListener("submit", async function (event) {
            event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada

            const formData = new FormData(event.target); // Recopilar datos del formulario
            const response = await fetch(event.target.action, { // Usar la acción del formulario como URL
                method: "POST",
                body: formData,
            });

            const result = await response.json(); // Procesar la respuesta como JSON
            const responsePopup = document.getElementById("responsePopup");

            responsePopup.innerHTML = ''; // Limpiar el contenido previo de la alerta

            if (result.error) {
                responsePopup.style.backgroundColor = "red";

                if (typeof result.message === "object") {
                    // Mostrar errores individuales si es un objeto
                    for (const [key, value] of Object.entries(result.message)) {
                        responsePopup.innerHTML += `<p><i class="fa-solid fa-xmark response-icon"></i>${value}</p>`;
                    }
                } else {
                    responsePopup.innerHTML = `<i class="fa-solid fa-xmark response-icon"></i>${result.message}`;
                }
            } else {
                responsePopup.style.backgroundColor = "LimeGreen";
                responsePopup.innerHTML = `<i class="fa-solid fa-check response-icon"></i>${result.message}`;

                if (result.redirect) {
                    // Si se proporciona una URL de redirección, redirigir
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 2000);
                } else {
                    // Si se debe recargar la página
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('disableUserModal'));
                        if (modal) {
                            modal.hide();
                        }

                        // Recargar la página después de cerrar el modal
                        setTimeout(() => {
                            location.reload();
                        }, 500); // Pequeño retraso para garantizar que el modal haya cerrado completamente
                    }, 1000);
                }

                // Cerrar el modal automáticamente después de un registro exitoso
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('disableUserModal'));
                    if (modal) {
                        modal.hide();
                    }
                }, 2000);
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