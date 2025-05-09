<!-- Modal para editar Tipo de Reporte -->
<div class="modal fade" id="editReportTypeModal" tabindex="-1" aria-labelledby="editReportTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editReportTypeModalLabel">Editar Tipo de Reporte</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editReportTypeForm" action="../logic/edit_ReportType_process.php" method="POST">
          <input type="hidden" id="editnameId" name="id">

          <div class="mb-3">
            <label for="editName" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="editName" name="name" required>
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