<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editUserForm" action="../logic/edit_user_process.php" method="POST">
          <input type="hidden" id="editUserId" name="id">

          <div class="mb-3">
            <label for="editUsername" class="form-label">Nombre de Usuario</label>
            <input type="text" class="form-control" id="editUsername" name="user_name" required>
          </div>

          <div class="mb-3">
            <label for="editNames" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="editNames" name="names" required>
          </div>

          <div class="mb-3">
            <label for="editLastNames" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="editLastNames" name="last_names" required>
          </div>

          <div class="mb-3">
            <label for="editIdentityCard" class="form-label">Cédula</label>
            <input type="number" class="form-control" id="editIdentityCard" name="identity_card" required>
          </div>

          <div class="mb-3">
            <label for="editEmail" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
          </div>

          <div class="mb-3">
            <label for="editPassword" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="editPassword" name="password">
          </div>

          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirm_password">
          </div>

          <div class="mb-3">
            <label for="editRole" class="form-label">Rol</label>
            <select class="form-select" id="editRole" name="level_user" required>
              <option value="0">Administrador</option>
              <option value="1">Técnico</option>
            </select>
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