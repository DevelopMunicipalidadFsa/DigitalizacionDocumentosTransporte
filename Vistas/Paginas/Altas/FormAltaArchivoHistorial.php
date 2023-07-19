  <div class="modal fade" id="ModalAltaDocumentoDigitalizado" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header btn-primary headerMDLperiodo" style="border: none;">
          <h3 class="modal-title text-center" id="exampleModalLongTitle">Formulario de Alta</h3>
          <button class="btnCerrarModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="row" id="Fa" action="plantillas.php?pagina=Modulos/DigitalizarDocumentos" method="POST" enctype='multipart/form-data'>
          <input type="hidden" name="FormularioAltaArchivoParticular" value="FormularioAltaArchivoParticular">
            <input type="hidden" name="Ia" value="<?php echo $Ia = $_REQUEST['Ia']; ?>" required />
            <input type="hidden" name="Do" value="<?php echo $Do = $_REQUEST['Do']; ?>" required />
            <input type="hidden" name="Us" value="<?php echo $Rol; ?>" required />
            <input type="hidden" name="Cus" value="<?php echo $codUsu; ?>" required />
            <input type="hidden" name="Iag" value="<?php echo $Iag = $_REQUEST['Iag']; ?>" required />
            <input type="hidden" name="Ag" value="<?php echo $Ag; ?>" required />
            <input type="hidden" name="Ir" required>
            <input type="hidden" name="Dc" value="<?php echo rtrim($Dc) ?>">
            <input type="hidden" name="Ul" value="DigitalizarDocumentos">
            <input type="hidden" name="Itr" value="8">
            <input type="hidden" name="Iru" value="0">

            <div class="col-md-12">
              <input type="text" name="Ti" style="text-transform: uppercase;" class="form-control Nrequisito text-center" autocomplete="off" readonly required />
            </div><br><br>

            <div class="col-md-12 mt-3 mb-2">
            <input type="file" class="form-control" id="image" name="image" required>
            </div>

            <div class="col-md-6 mt-3">
              <label style="margin-bottom: -5;">Valido Desde</label>
              <input class="form-control text-center" type="text" readonly name="Vd" value="<?php echo $DESDE ?>" required>
            </div>
            <div class="col-md-6 mt-3">
              <label style="margin-bottom: -5;">Valido Hasta</label>
              <input class="form-control text-center" readonly type="text" name="Vh" value="<?php echo $HASTA ?>" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button form="Fa" name="Submit" id="Submit" type="submit" class="btn btn-primary">
            <span id="texto">Guardar</span>&nbsp;
            <span class="far fa-save" id="icono" role="status" aria-hidden="true"></span>
          </button>
        </div>
      </div>
    </div>
  </div>