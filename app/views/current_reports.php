<?php
require '../config/database.php';
/**
 * Script para cargar datos de lado del servidor con PHP y MySQL
 *
 * @author wholehand
 * @link https://github.com/wholehand
 * @license: MIT
 */

// header
require 'header.php';

// Modificamos la consulta SQL para filtrar solo los reportes activos
$sqlReports = "SELECT r.id, r.id_report_type, r.name, r.description, r.date, rt.name AS rt 
               FROM reports AS r
               INNER JOIN report_type AS rt ON r.id_report_type = rt.id
               WHERE r.state_report = 1"; // Solo selecciona reportes activos
$reports = $conn->query($sqlReports);

$dir = "../assets/img/reports";
?>

<!doctype html>
<html lang="es">
<head>
    <title>REPORTES VIGENTES</title>
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
    <!-- link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Enlaces a DataTables CSS y JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- Invoca y Traduce al metodo DataTable() -->
    <script>
      $(function () {
        $("#tbl_reports").DataTable({
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
            width: 90px; /* Ajusta el ancho según tus necesidades */
            text-align: center;
        }

        /* Estilos para la vista de la imagen que se muestra en el DataTable */
        .image-hover-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .image-hover-wrapper img {
            display: block;
        }

        .hover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6); /* Oscurecimiento */
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-hover-wrapper:hover .hover-overlay {
            opacity: 1;
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
      <div>
        <h2 class="text-center">Reportes Vigentes</h2>

        <div class="row justify-content-center mt-4">
            <div class="col-auto">
                <button id="selectAll" class="btn btn-light"><i class="fa-regular fa-square-check"></i> Seleccionar Todo</button>
            </div>
            <div class="col-auto">
                <button id="deselectAll" class="btn btn-light"><i class="fa-regular fa-square"></i> No Seleccionar Ninguno</button>
            </div>
            <div class="col-auto">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newModal"><i class="fa-solid fa-file-circle-plus"></i> Nuevo Reporte</a>
            </div>
            <div class="col-auto">
                <button id="confirmMoveMulti" class="btn btn-secondary"><i class="fa-regular fa-folder-open"></i> Archivar Reportes</button>
                <form id="moveMultiForm" action="moveMulti.php" method="post" style="display: none;">
                    <input type="hidden" name="selected_ids" id="selectedIds">
                </form>
            </div>
            <div class="col-auto">
                <a href="/crud-arkova/app/pdf reports/current_reports_PDF.php" target="_blank" class="btn btn-outline-danger"><i class="fa-solid fa-file-pdf"></i> Informe PDF</a>
            </div>
            <div class="col-auto">
                <a href="/crud-arkova/app/excel reports/current_reports_excel.php" target="_blank" class="btn btn-outline-success"><i class="fa-solid fa-file-excel"></i> Informe Excel</a>
            </div>
        </div>
        <hr>

        <table
          id="tbl_reports"
          class="table table-sm table-striped table-hover mt-4"
          style="width: 100%"
        >
          <thead>
            <tr>
                <th>#</th>
                <th>Tipo de Reporte</th>
                <th>Nombre del Reporte</th>
                <th>Descripción</th>
                <th>Fecha y Hora</th>
                <th>Imagen</th>
                <th>Acción</th>
            </tr>
          </thead>

          <tfoot>
            <tr>
                <th>#</th>
                <th>Tipo de Reporte</th>
                <th>Nombre del Reporte</th>
                <th>Descripción</th>
                <th>Fecha y Hora</th>
                <th>Imagen</th>
                <th>Acción</th>
            </tr>
          </tfoot>

          <tbody>
                <?php while ($row_report = $reports->fetch_assoc()) { ?>
                    <tr>
                        <td><input class="form-check-input" type="checkbox" name="selected_reports[]" value="<?php echo $row_report['id']; ?>"></td>
                        <td><?php echo $row_report['rt']; ?></td>
                        <td><?php echo $row_report['name']; ?></td>
                        <td><?php echo $row_report['description']; ?></td>
                        <td><?php echo $row_report['date']; ?></td>
                        <td>
                            <div class="image-hover-wrapper" data-bs-toggle="modal" data-bs-target="#viewImgModal" data-bs-id="<?= $row_report['id']; ?>">
                                <img src="<?= $dir . '/' . $row_report['id'] . '.jpg?n=' .time(); ?>" width="100" alt="Imagen del reporte">
                                <div class="hover-overlay">
                                    <i class="fa-solid fa-eye"></i>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle action-column">
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" title="Editar Reporte" data-bs-id="<?= $row_report['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="btn btn-sm btn-secondary openMove" data-bs-toggle="modal" data-bs-target="#moveModal" title="Archivar Reporte" data-bs-id="<?= $row_report['id']; ?>"><i class="fa-regular fa-folder-open"></i></a>
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

    <?php 
    $sqlReport = "SELECT id, name FROM report_type";
    $reports = $conn->query($sqlReport);
    ?>

    <!-- Modales Requeridos -->
    <?php require 'newModal.php'; ?>
    <?php $reports->data_seek(0); ?>
    <?php require 'viewImgModal.php'; ?>
    <?php require 'editModal.php'; ?>
    <?php require 'moveModal.php'; ?>

    <!-- Script JavaScript -->
    <script>
        // Editar Modal
        let editModal = document.getElementById('editModal');
        editModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');

            let inputId = editModal.querySelector('.modal-body #id');
            let inputTipo_reporte = editModal.querySelector('.modal-body #tipo_reporte');
            let inputNombre = editModal.querySelector('.modal-body #nombre');
            let inputDescripcion = editModal.querySelector('.modal-body #descripcion');
            let inputDatetime = editModal.querySelector('.modal-body #datetime');
            let imgReport = editModal.querySelector('.modal-body #img_report');

            let url = "../logic/get_current_reports.php";
            let formData = new FormData();
            formData.append('id', id);

            fetch(url, {
                method: "POST",
                body: formData
            }).then(response => response.json())
            .then(data => {
                inputId.value = data.id;
                inputTipo_reporte.value = data.id_report_type;
                inputNombre.value = data.name;
                inputDescripcion.value = data.description;
                inputDatetime.value = data.date;
                let imgSrc = '<?= $dir ?>/' + data.id + '.jpg?t=' + new Date().getTime();
                imgReport.src = imgSrc;
            }).catch(err => console.log(err));
        });

        // Ver Imagen Ampliada Modal
        let viewImgModal = document.getElementById('viewImgModal');
        viewImgModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget; // El botón que activó el modal
            let id = button.getAttribute('data-bs-id'); // Obtener el ID de la imagen seleccionada

            let imgReport = viewImgModal.querySelector('.modal-body #img_report'); // Seleccionar la imagen en el modal

            // Aquí puedes hacer una llamada AJAX o modificar directamente la URL si ya tienes la información
            let url = "../logic/get_current_reports.php";
            let formData = new FormData();
            formData.append('id', id);

            fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Agregar un parámetro único (timestamp) para evitar caché
                let imgSrc = '<?= $dir ?>/' + data.id + '.jpg?t=' + new Date().getTime();  // Aquí agregamos el parámetro 't' con el timestamp

                imgReport.src = imgSrc; // Actualizar la fuente de la imagen
            })
            .catch(err => console.log(err));
        });

        // Archivar Modal
        let moveModal = document.getElementById('moveModal');
        moveModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');
            moveModal.querySelector('.modal-footer #id').value = id;
        });

        // Selección de filas
        const selectAllBtn = document.querySelector('#selectAll');
        const deselectAllBtn = document.querySelector('#deselectAll');
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_reports[]"]');
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

        // Modal Archivar Multiple
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('confirmMoveMulti').addEventListener('click', () => {
                const selectedIds = Array.from(document.querySelectorAll('input[name="selected_reports[]"]:checked'))
                    .map(checkbox => checkbox.value)
                    .join(',');

                if (selectedIds.length === 0) {
                    alert("No has seleccionado ningún reporte.");
                    return; // Salir si no hay reportes seleccionados
                }

                const confirmAction = confirm("¿Estás seguro que deseas archivar los reportes seleccionados?");
                if (confirmAction) {
                    document.getElementById('selectedIds').value = selectedIds;
                    document.getElementById('moveMultiForm').submit();
                }
            });
        });

        // JavaScript para mostrar las alertas con los mensajes del modal de crear reportes
        document.getElementById("newReportForm").addEventListener("submit", async function (event) {
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
                        const modal = bootstrap.Modal.getInstance(document.getElementById('newModal'));
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
                    const modal = bootstrap.Modal.getInstance(document.getElementById('newModal'));
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

        // JavaScript para mostrar las alertas con los mensajes del modal de editar reportes
        document.getElementById("editReportForm").addEventListener("submit", async function (event) {
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
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
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
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
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