<!-- Modal para Restaurar Reportes -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="restoreModalLabel">Alerta de Confirmación</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Desea Restaurar el reporte?
      </div>
      <div class="modal-footer">
        <form action="../logic/move_process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="id" id="id" value="<?php echo $report['id']; ?>">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-recycle"></i> Confirmar</button>
        </form>
    </div>
  </div>
</div>