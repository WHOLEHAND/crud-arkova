<!-- Modal para crear nuevos Usuarios -->
<div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="newUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="newUserModalLabel">Registro de Usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form id="registerForm" action="../logic/register_process.php" method="POST">
            <div class="row g-2 mt-2">
                <div class="form-group input-group col-md">
                  <span class="input-group-text bg-primary"><i class="fa-solid fa-user" style="color:#fff;"></i></span>
                  <div class="form-floating">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario" required>
                    <label for="username" style="color:#595c5f;">Nombre de usuario</label>
                  </div>
                </div>
                <div class="form-group input-group col-md">
                  <span class="input-group-text bg-primary"><i class="fa-solid fa-user-tag" style="color:#fff;"></i></span>
                  <div class="form-floating">
                    <select class="form-select" id="role" name="level_user" aria-label="Rol de usuario" required>
                        <option value="1">Técnico</option>
                        <option value="0">Administrador</option>
                    </select>
                    <label for="role">Rol de usuario</label>
                  </div>
                </div>
            </div>
            
            <div class="row g-2 mt-2">
                <div class="form-group input-group col-md">
                  <span class="input-group-text bg-primary"><i class="fa-regular fa-address-book" style="color:#fff;"></i></span>
                  <div class="form-floating">
                    <input type="text" class="form-control" id="names" name="names" placeholder="Nombre" required>
                    <label for="names" style="color:#595c5f;">Nombre</label>
                  </div>
                </div>
                <div class="form-group input-group col-md">
                  <span class="input-group-text bg-primary"><i class="fa-solid fa-indent" style="color:#fff;"></i></span>
                  <div class="form-floating">
                    <input type="text" class="form-control" id="last_names" name="last_names" placeholder="Apellido" required>
                    <label for="last_names" style="color:#595c5f;">Apellido</label>
                  </div>
                </div>
            </div>

            <div class="row g-2 mt-2">
                <div class="form-group input-group col-md">
                  <span class="input-group-text bg-primary"><i class="fa-regular fa-address-card" style="color:#fff;"></i></span>
                  <div class="form-floating">
                    <input type="number" class="form-control" id="identity_card" name="identity_card" placeholder="Número de cédula" required>
                    <label for="identity_card" style="color:#595c5f;">Número de cédula</label>
                  </div>
                </div>
                <div class="form-group input-group col-md">
                  <span class="input-group-text bg-primary"><i class="fa-solid fa-at" style="color:#fff;"></i></span>
                  <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required>
                    <label for="email" style="color:#595c5f;">Correo</label>
                  </div>
                </div>
            </div>

            <div class="row g-2 mt-2">
                <div class="form-group input-group col-md">
                  <span class="input-group-text bg-primary"><i class="fa-solid fa-lock" style="color:#fff;"></i></span>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                    <label for="password" style="color:#595c5f;">Contraseña</label>
                  </div>
                </div>
                <div class="form-group input-group col-md">
                  <span class="input-group-text bg-primary"><i class="fa-solid fa-lock" style="color:#fff;"></i></span>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirme su contraseña" required>
                    <label for="confirmPassword" style="color:#595c5f;">Confirme su contraseña</label>
                  </div>
                </div>
            </div>

            <input type="hidden" name="state_user" value="1">

            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Registrar Usuario</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>