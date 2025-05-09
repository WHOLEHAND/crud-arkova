<?php
// Conexión a la Base de Datos
require '../config/database.php';

/**
 * Script para cargar datos de lado del servidor con PHP y MySQL
 *
 * @author wholehand
 * @link https://github.com/wholehand
 * @license: MIT
*/

// Header
require 'header.php';

// Verificar si el usuario está autenticado y si tiene el nivel de usuario adecuado
$user_level = $_SESSION['level_user'] ?? null;

if ($user_level !== 0) {
    // Redirigir al usuario si no tiene nivel de administrador
    header("Location: /crud-arkova/app/index.php"); // Podría cambiarse más adelante por un 'access_denied.php'
    exit();
}

// Consulta SQL para obtener los datos que se mostrán en el DataTable
$sqlBinnacle = "SELECT id, aud_user, aud_registereddate, aud_action FROM auditory";
$binnacle = $conn->query($sqlBinnacle);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BITÁCORA</title>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Superviar las acciones de los usuarios en el sistema">
    <meta name="author" content="Jesús Vielma @wholehand">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">

    <!-- Iconos de Font Awesome -->
    <link href="/crud-arkova/app/assets/css/all.min.css" rel="stylesheet">

    <!-- Enlace a Bootstrap -->
    <!-- link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"-->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Enlaces a DataTables CSS y JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- Invoca y Traduce al metodo DataTable() -->
    <script>
      $(function () {
        $("#tbl_binnacle").DataTable({
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
            width: 50px; /* CSS para fijar el ancho de la columna Acción */
            text-align: center;
        }
    </style>
</head>
<body>
    
    <div class="container py-3">
        <h2 class="text-center">Bitácora del Sistema</h2>
        
        <div class="row justify-content-center mt-4">
            <div class="col-auto">
                <a href="/crud-arkova/app/pdf reports/binnacle_PDF.php" target="_blank" class="btn btn-outline-danger" title="Generar Informe PDF"><i class="fa-solid fa-file-pdf"></i> PDF</a>
            </div>
            <div class="col-auto">
                <a href="/crud-arkova/app/excel reports/binnacle_excel.php" target="_blank" class="btn btn-outline-success" title="Generar Informe Excel"><i class="fa-solid fa-file-excel"></i> Excel</a>
            </div>
        </div>
        <br>

        <table
          id="tbl_binnacle"
          class="table table-sm table-striped table-hover mt-4"
          style="width: 100%"
        >
          <thead>
            <tr>
                <th>Id</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Acción Efectuada</th>
            </tr>
          </thead>

          <tfoot>
            <tr>
                <th>Id</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Acción Efectuada</th>
            </tr>
          </tfoot>

          <tbody>
                <?php while ($row_binnacle = $binnacle->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row_binnacle['id']; ?></td>
                        <td><?php echo $row_binnacle['aud_user']; ?></td>
                        <td><?php echo $row_binnacle['aud_registereddate']; ?></td>
                        <td><?php echo $row_binnacle['aud_action']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
      </div>
    </div>
    <br>
    <br>
    <br>

    <!-- Footer -->
    <?php require 'footer.php' ?>
</body>
</html>