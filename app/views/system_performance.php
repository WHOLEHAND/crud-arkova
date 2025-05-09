<?php
//Conexión a la base de datos
require '../config/database.php';
/**
 * Script de las metricas del sistema
 *
 * @author wholehand
 * @link https://github.com/wholehand
 * @license: MIT
 */

// header
require 'header.php';
?>

<!doctype html>
<html lang="es">
<head>
    <title>MÉTRICAS DE REDIMIENTO</title>
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

    <!-- Enlace a jQuery y Google Charts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Enlace a html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body>

    <div class="container py-3">
        <h2 class="text-center">Métricas de Rendimiento del Sistema</h2>

        <div class="row justify-content-center mt-4">
            <div class="col-auto onlineElement" style="display:block;">
                <button id="downloadPdf" class="btn btn-outline-danger"><i class="fa-solid fa-file-pdf"></i> Informe PDF</button>
            </div>
            <!-- div class="col-auto">
                <a href="#" class="btn btn-outline-success"><i class="fa-solid fa-file-excel"></i> Informe Excel</a>
            </div -->
        </div>
        <hr>

        <div class="row mt-4">
            <div id="offlineMessage" class="alert alert-danger" style="display:none; min-height: 350px;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); align-items: center; text-align: center;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 82px;"></i>
                    <strong style="font-size: 82px; padding-left: 15px; padding-right: 15px;">404</strong>
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 82px;"></i>
                    <br>
                    <strong style="font-size: 32px;">¡Sin conexión a Internet!</strong>
                    <p style="font-size: 24px;">Funcionalidad no disponible temporalmente</p>
                    <p style="font-size: 18px; font-style:italic">Comprueba los cables de red, el módem o el router</p>
                </div>
            </div>
            <div class="col-md-4 onlineElement" style="display:block;">
                <h4>Rango de fechas:</h4>
                <form id="date_form">
                    <div class="form-group">
                        <label for="start_date">Fecha de inicio:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Fecha de fin:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                    </div>

                    <button id="generate_metrics" type="submit" class="btn btn-primary mt-3">Ver Métricas</button>
                </form>
                <div id="chart_message" class="text-center text-danger mt-4"></div>
            </div>

            <div class="col-md-8 onlineElement" style="display:block;">
                <div id="chart_div" style="width: 100%; height: 350px;"></div>
            </div>
        </div>
    </div>

    <?php require 'footer.php'; ?>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart(data) {
            var chartData = new google.visualization.DataTable();
            chartData.addColumn('string', 'Fecha');
            chartData.addColumn('number', 'Total de Reportes');

            // Llenamos la gráfica con los datos de PHP
            data.forEach(function(item) {
                chartData.addRow([item.report_date, parseInt(item.total_reports)]); // Asegurar que sea un número entero
            });

            // Calcular el valor máximo de los reportes
            var maxReports = Math.max(...data.map(function(item) { return item.total_reports; }));

            var ticks = [];
            var message = ''; // Mensaje de texto

            if (maxReports > 0) {
                // Si hay reportes, calculamos los ticks dinámicamente
                var interval = Math.ceil(maxReports / 5);
                for (var i = 0; i <= maxReports; i += interval) {
                    ticks.push(i);
                }
                // Limpiamos el mensaje si hay datos
                document.getElementById('chart_message').innerText = '';
            } else {
                // Si no hay reportes, mostramos la escala de 0 a 5 y un mensaje de "no reportes"
                ticks = [0, 1, 2, 3, 4, 5];
                message = 'No se encontraron reportes para la consulta.';
            }

            var options = {
                title: 'Reportes Cargados por Fecha',
                chartArea: {
                    width: '80%',
                    height: '60%',
                    top: 30
                },
                hAxis: {  // Ahora el eje horizontal es la Fecha
                    title: 'Fecha',
                },
                vAxis: {  // Ahora el eje vertical es el Total de Reportes
                    title: 'Total de Reportes',
                    minValue: 0,
                    ticks: ticks  // Usamos los ticks generados
                },
                legend: { position: 'none' },
                bar: { groupWidth: '65%' },
                animation: {
                    duration: 1000, // Duración de la animación en milisegundos
                    easing: 'out',  // Tipo de efecto ('in', 'out', 'inAndOut', 'linear')
                    startup: true   // Ejecutar la animación solo al cargar
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

            // Verificar si no hay reportes y mostrar el mensaje
            if (message) {
                document.getElementById('chart_message').innerText = message;
            }

            chart.draw(chartData, options);
        }

        $(document).ready(function() {
            $("#generate_metrics").click(function(e) {
                e.preventDefault(); // Prevenir que el formulario se envíe de la forma tradicional

                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();

                $.ajax({
                    url: "../logic/system_performance_process.php", // Llamada al archivo que procesa los datos
                    type: "POST",
                    data: { start_date: start_date, end_date: end_date },
                    dataType: "json",
                    success: function(response) {
                        // Depuración de los datos que se están enviando
                        console.log('Fechas enviadas:', start_date, end_date);
                        // Verificar si se obtuvo una respuesta válida
                        if (response.error) {
                            alert(response.error); // Mostrar error si existe
                        } else {
                            // Llamar a la función para dibujar la gráfica con los datos
                            drawChart(response);
                        }
                    },
                    error: function() {
                        alert("Error en la consulta AJAX.");
                    }
                });
            });
        });

        // Script para generar una imagen de la gráfica y posteriormente procesarla para estar en el archivo PDF
        document.getElementById("downloadPdf").addEventListener("click", function() {
            console.log("Botón presionado");  // Esto debería aparecer en la consola cuando se presione el botón

            // Tomamos las fechas de los inputs
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            // Verificamos que las fechas estén seleccionadas
            if (start_date === "" || end_date === "") {
                alert("Por favor selecciona ambas fechas.");
                return;
            }

            console.log("Fechas seleccionadas:", start_date, end_date); // Verificar que las fechas se capturan correctamente

            console.log("Tipo de start_date:", typeof start_date);
            console.log("Tipo de end_date:", typeof end_date);

            // Si el valor es una cadena, mostramos su longitud
            if (typeof start_date === 'string') {
                console.log("Longitud de start_date:", start_date.length);
            }
            if (typeof end_date === 'string') {
                console.log("Longitud de end_date:", end_date.length);
            }

            // Captura la gráfica como imagen con html2canvas
            html2canvas(document.getElementById('chart_div')).then(function(canvas) {
                var imgData = canvas.toDataURL("image/png"); // Captura la gráfica en Base64
                console.log("Imagen capturada"); // Ver si la imagen se captura

                // Enviar la imagen al servidor mediante AJAX
                $.ajax({
                    url: '/crud-arkova/app/pdf reports/system_performance_PDF.php', // Archivo PHP que procesa la solicitud
                    type: 'POST',
                    data: {image: imgData, start_date: start_date, end_date: end_date },
                    async: true,  // No esperamos respuesta del servidor
                    success: function() {
                        console.log("Imagen enviada al servidor correctamente.");
                        // Redirige a la URL que generará el PDF en una nueva pestaña
                        var pdfUrl = '/crud-arkova/app/pdf reports/system_performance_PDF.php?generate=true';
                        window.open(pdfUrl, '_blank'); // Abre en una nueva pestaña
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", error); // Si hay algún error, lo mostramos en la consola
                    }
                });
            });
        });

        // Script para detectar si el usuario está desconectado
        if (!navigator.onLine) {
            document.getElementById('offlineMessage').style.display = 'block';
            // Cambié la manipulación de display para seleccionar por clase y ocultar todos los elementos con la clase "onlineElement"
            let onlineElements = document.querySelectorAll('.onlineElement');
            onlineElements.forEach(function(element) {
                element.style.display = 'none';
            });
        } else {
            // Si está en línea, ocultamos el mensaje de offline y mostramos los elementos con la clase "onlineElement"
            document.getElementById('offlineMessage').style.display = 'none';
            let onlineElements = document.querySelectorAll('.onlineElement');
            onlineElements.forEach(function(element) {
                element.style.display = 'block';
            });
        }
    </script>
</body>
</html>