<!-- Modal para Inhabilitar Usuarios -->
<div class="modal fade" id="disableUserModal" tabindex="-1" aria-labelledby="disableUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="disableUserModalLabel">Aviso</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas inhabilitar este usuario?
      </div>
      <div class="modal-footer">
        <form id="disableUserForm" action="../logic/disable_user_process.php" method="post">
            <input type="hidden" name="id" id="id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-user-slash"></i> Inhabilitar</button>
        </form>
    </div>
  </div>
</div>