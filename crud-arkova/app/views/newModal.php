<!-- Modal para crear nuevos reportes -->
<div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="newModalLabel">Agregar Reporte</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="newReportForm" action="../logic/save_process.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tipo_reporte" class="forn-label">Tipo de Reporte:</label>
                <select name="tipo_reporte" id="tipo_reporte" class="form-select" required>
                    <option value="">Seleccionar...</option>
                    <?php while($row_report_type = $reports->fetch_assoc()) { ?>
                      <option value="<?php echo $row_report_type["id"]; ?>"><?= $row_report_type["name"] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nombre" class="forn-label">Nombre del Reporte: </label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="forn-label">Descripción del Reporte: </label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="datetime" class="forn-label">Fecha y Hora del Reporte:</label>
                <input type="datetime-local" name="datetime" id="datetime" class="form-control" required>
            </div>
            <div class="mb-3">
              <img id="img_report" width="100" alt="Imagen del reporte">
            </div>
            <div class="mb-3">
                <label for="imagen" class="forn-label">Imagen del Reporte:</label>
                <input type="file" name="imagen" id="imagen" class="form-control" accept="image/jpg">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Cambios</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript para previsualizar la imagen -->
<script>
  document.getElementById("imagen").addEventListener("change", function(event) {
    const file = event.target.files[0];
    const imgPreview = document.getElementById("img_report");

    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        imgPreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      imgPreview.src = ""; // Limpia la imagen si no hay archivo
    }
  });
</script>