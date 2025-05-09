<!-- Modal para crear nuevos Tipos de Reporte -->
<div class="modal fade" id="newReportTypeModal" tabindex="-1" aria-labelledby="newReportTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="newReportTypeModalLabel">Nuevo Tipo de Reporte</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form id="registerForm" action="/crud-arkova/app/html/new_report_type_process.php" method="POST">
            <div class="row g-2 mt-2">
                <div class="form-group input-group col-md">
                  <span class="input-group-text bg-primary"><i class="fa-solid fa-file-circle-exclamation" style="color:#fff;"></i></span>
                  <div class="form-floating">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Tipo de Reporte" required>
                    <label for="name" style="color:#595c5f;">Tipo de Reporte</label>
                  </div>
                </div>
            </div>

            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Crear Tipo de Reporte</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>