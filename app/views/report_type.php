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

// Consulta SQL para obtener los datos
$sqlReports = "SELECT id, name FROM report_type";
$report_type = $conn->query($sqlReports);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>TIPO DE REPORTES</title>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Buscar datos en tiempo real con PHP, MySQL y AJAX">
    <meta name="author" content="Jesús Vielma @wholehand">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">

    <!-- Iconos de Font Awesome -->
    <link href="../assets/css/all.min.css" rel="stylesheet">

    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- link href="../assets/css/bootstrap.min.css" rel="stylesheet" -->

    <!-- Enlaces a DataTables CSS y JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- Invoca y Traduce al metodo DataTable() -->
    <script>
      $(function () {
        $("#tbl_report_type").DataTable({
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
        .action-column {
            width: 50px; /* Ajusta el ancho según tus necesidades */
            text-align: center;
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
        <h2 class="text-center">Tipos de Reporte</h2>
        
        <div class="row justify-content-center mt-4">
            <div class="col-auto">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newReportTypeModal"><i class="fa-solid fa-file-circle-plus"></i> Nuevo Tipo</a>
            </div>
            <div class="col-auto">
                <a href="/crud-arkova/app/pdf reports/report_type_PDF.php" target="_blank" class="btn btn-outline-danger" title="Generar Informe PDF"><i class="fa-solid fa-file-pdf"></i> PDF</a>
            </div>
            <div class="col-auto">
                <a href="/crud-arkova/app/excel reports/report_type_excel.php" target="_blank" class="btn btn-outline-success" title="Generar Informe Excel"><i class="fa-solid fa-file-excel"></i> Excel</a>
            </div>
        </div>
        <br>

        <table
          id="tbl_report_type"
          class="table table-sm table-striped table-hover mt-4"
          style="width: 100%"
        >
          <thead>
            <tr>
                <th>Nombre</th>
                <th>Acción</th>
            </tr>
          </thead>

          <tfoot>
            <tr>
                <th>Nombre</th>
                <th>Acción</th>
            </tr>
          </tfoot>

          <tbody>
                <?php while ($row_report_type = $report_type->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row_report_type['name']; ?></td>
                        <td class="align-middle action-column">
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editReportTypeModal" title="Editar Tipo" data-bs-id="<?= $row_report_type['id']; ?>"><i class="fa-solid fa-file-pen"></i></a>
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
    <?php require 'newReportTypeModal.php'; ?>
    <?php require 'editReportTypeModal.php'; ?>
    
    <!-- Funciones de solicitud AJAX -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Editar Tipo de Reporte
            const editReportTypeModal = document.getElementById('editReportTypeModal');
            editReportTypeModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;
                const nameId = button.getAttribute('data-bs-id');

                // Verificar si el ID está siendo capturado correctamente
                console.log("Edit Report Type ID:", nameId);

                // Realiza una solicitud para obtener los datos del Tipo de Reporte
                fetch(`/crud-arkova/app/logic/get_report_type_data.php?id=${nameId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error(data.error);
                        } else {
                            // Llenar los campos del modal con los datos del Tipo de Reporte
                            document.getElementById('editnameId').value = data.id;
                            document.getElementById('editName').value = data.name;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // JavaScript para mostrar las alertas con los mensajes del modal de crear tipo de reporte
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
                        const modal = bootstrap.Modal.getInstance(document.getElementById('newReportTypeModal'));
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
                    const modal = bootstrap.Modal.getInstance(document.getElementById('newReportTypeModal'));
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

        // JavaScript para mostrar las alertas con los mensajes del modal de editar tipo de reporte
        document.getElementById("editReportTypeForm").addEventListener("submit", async function (event) {
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
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editReportTypeModal'));
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
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editReportTypeModal'));
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