  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title text-center" id="exampleModalLongTitle">Subir Archivo</h3>
          <button class="btnCerrarModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="row" id="FaP" action="plantillas.php?pagina=Modulos/Periodo" method="POST" enctype='multipart/form-data'>
            <input type="hidden" name="FormularioAltaArchivoParticular" value="FormularioAltaArchivoParticular">
            <input type="hidden" name="Ia" value="<?php echo $Ia = $_REQUEST['Ia']; ?>" required />
            <input type="hidden" name="Do" value="<?php echo $Do = $_REQUEST['Do']; ?>" required />
            <input type="hidden" name="Us" value="<?php echo $Rol; ?>" required />
            <input type="hidden" name="Cus" value="<?php echo $codUsu; ?>" required />
            <input type="hidden" name="Iag" value="<?php echo $Iag = $_REQUEST['Iag']; ?>" required />
            <input type="hidden" name="Ag" value="<?php echo $Ag; ?>" required />
            <input type="hidden" name="Ir" required>
            <input type="hidden" name="Dc" value="<?php echo rtrim($Dc) ?>">
            <input type="hidden" name="Ul" value="Periodo">
            <input type="hidden" name="Itr" value="8">
            <input type="hidden" name="Iru" value="0">
            <input type="hidden" name="id_adherente">
            <div class="col-md-12">
              <input type="text" name="Ti" class="form-control Nrequisito text-center" autocomplete="off" readonly required />
            </div><br><br><br>

            <div class="col-md-12 mb-3" style="cursor: pointer;">
              <input type="file" class="form-control" id="image" name="image" required>
            </div><br><br>

            <div class="col-md-6">
              <label style="margin-bottom: -5;">Valido Desde</label>
              <input class="form-control text-center" type="text" readonly name="Vd" value="<?php echo $DESDE ?>" required>
            </div>
            <div class="col-md-6">
              <label style="margin-bottom: -5;">Valido Hasta</label>
              <input class="form-control text-center" readonly type="text" name="Vh" value="<?php echo $HASTA ?>" required>
            </div>

            <!-- <input type="hidden" id="Desc" name="Desc"><br> -->
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button form="FaP" name="Submit" id="Submit" type="submit" class="btn" style="background: #074b79; color: white;">
            <span id="texto">Guardar</span>&nbsp;
            <span class="far fa-save" id="icono" role="status" aria-hidden="true"></span>
          </button>
        </div>
      </div>
    </div>
  </div>