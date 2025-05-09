<!-- Modal para Habilitar Usuarios -->
<div class="modal fade" id="enableUserModal" tabindex="-1" aria-labelledby="enableUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="enableUserModalLabel">Aviso</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas habilitar este usuario?
      </div>
      <div class="modal-footer">
        <form id="enableUserForm" action="../logic/disable_user_process.php" method="post">
            <input type="hidden" name="id" id="id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-user-check"></i> Habilitar</button>
        </form>
    </div>
  </div>
</div>