<!-- Modal para ver Imagenes en grande -->
<div class="modal fade" id="viewImgModal" tabindex="-1" aria-labelledby="viewImgModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="viewImgModalLabel">Vista de la Imagen</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex justify-content-center align-items-center">
        <form method="post">
          <input type="hidden" id="id" name="id">
            <div class="mb-3">
              <img id="img_report" class="img-fluid" alt="Imagen del reporte">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>