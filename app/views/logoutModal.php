<!-- Modal para Cerrar Sesión -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="logoutModalLabel">Alerta de Confirmación</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Está seguro que desea Cerrar la Sesión?
      </div>
      <div class="modal-footer">
        <form action="/crud-arkova/app/logic/logout_process.php" method="post">
            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-check"></i> Sí</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-ban"></i> No</button>
        </form>
      </div>
    </div>
  </div>
</div>