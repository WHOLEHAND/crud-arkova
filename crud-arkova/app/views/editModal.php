<!-- Modal para Editar Reportes -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Editar Reporte</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editReportForm" action="../logic/update_reports_process.php" method="post" enctype="multipart/form-data">
          
          <input type="hidden" id="id" name="id">

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