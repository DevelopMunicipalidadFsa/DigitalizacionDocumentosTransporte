<div class="modal modalBaja fade ModalBajaPeriodo" id="ModalBajaArchivoHistorial" tabindex="-1" role="dialog" aria-labelledby="ModalBajaAlumnoTitle" aria-hidden="true" role="document">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-dialog-scrollable">
        <div class="modal-content " style="border: solid 2px silver;">
            <div class="modal-header btn-primary" style="background: #e45d5d; color: white;">
                <h4 class="modal-title text-center" id="exampleModalLongTitle">Borrar Documento Digitalizado</h4>
                <button class="btnCerrarModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row p-4">
                <form action="plantillas.php?pagina=Modulos/DigitalizarDocumentos" method="post" name="borrar">
                    <input type="hidden" name="Ach">
                    <input type="hidden" name="Ie">
                    <input type="hidden" name="Do">
                    <input type="hidden" name="Cus">
                    <input type="hidden" name="Us">
                    <input type="hidden" name="Ia">
                    <input type="hidden" name="Iag">
                    <input type="hidden" name="Dc">
                    <input type="hidden" name="Cre">
                    <input type="hidden" name="Ag">
                    <input type="hidden" name="Na">
                    <input type="hidden" name="Ul">
                    <input type="hidden" name="Vd">
                    <input type="hidden" name="Vh">
                    <input type="hidden" name="Itr" value="8">
                    <input type="hidden" name="Iru" value="0">


                    <div class="col-md-12 g-0">
                        <i style="color: #e45d5d; font-size: 80px" class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="col-md-12 g-0">
                        <label style="font-weight: bold; color:#e45d5d; font-size:18px" class="form-label g-0">Atención !!!</label>
                    </div>
                    <div class="col-md-12 g-1">
                        <h5 style="text-align: center; font-weight:bold;">¿Está seguro que desea borrar este documento?</h5>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button name="Submit" type="submit" class="btn btn-danger">
                    <span id="texto">Si, Borrar</span>&nbsp;
                </button>
            </div>
            </form>
        </div>
    </div>
</div>