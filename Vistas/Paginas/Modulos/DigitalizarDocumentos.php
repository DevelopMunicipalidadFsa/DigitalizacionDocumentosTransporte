<?php
require_once '../Controladores/ControladorDigitalizacionExp.php';
require_once '../Modelos/ModelosDigitalizacionExp.php';

$Do = $_REQUEST['Do'];
$Ia = $_REQUEST['Ia'];
$Iag = $_REQUEST['Iag'];
$Dc = $_REQUEST['Dc'];
$Ag = $_REQUEST['Ag'];
$Vd = $_REQUEST['Vd'];
$Vh = $_REQUEST['Vh'];
$Itr = $_REQUEST['Itr'];
$Iru = $_REQUEST['Iru'];


$DESDE = date("d-m-Y", strtotime($_REQUEST['Vd']));
$HASTA = date("d-m-Y", strtotime($_REQUEST['Vh']));

$anioB = date("Y", strtotime($Vd));
$periodoAnioB = date("Y", strtotime($Vd));
$periodoMesB = date("m", strtotime($Vd));
$periodoB = "$periodoAnioB-$periodoMesB";


$Agencia = ControladorAgencia::CtrMostrarAgencia($Iag);

foreach ($Agencia as $ver) {
    $agencia = $ver[1];
}

$Requisitos = ControladorFiltrarRequisitos::CtrMostrarRequisitosFiltrados($Itr, $Iru, $Ia, $Do, $Vd, $Vh); ?>



<div class="ContenedorGeneralAdherente">
    <div class="infoTitular">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <form action="plantillas.php?pagina=Modulos/FiltrarDominios" method="post">
                    <!-- <input type="hidden" name="Ia" value="<?php echo $Ia ?>">
                    <input type="hidden" name="Do" value="<?php echo rtrim($Do) ?>">
                    <input type="hidden" name="Iag" value="<?php echo $Iag ?>">
                    <input type="hidden" name="Dc" value="<?php echo $Dc ?>"> -->

                    <button type="submit" class="nav-link btnAtras"><i class="fas fa-reply"></i> Volver a Filtrar</button>
                </form>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="home" aria-selected="true">Periodo <?php echo $periodoB . " - Dominio: " . $Do ?></a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#masivo" role="tab" aria-controls="home" aria-selected="true">Subir varios Archivos</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <h3 class="h3tituloPeriodo">Listado de requisitos del Periodo: <?php echo $DESDE ?> Hasta: <?php echo $HASTA ?></label></h3>

                <div class="ContenedorRequisitosPeriodos">
                    <table class="tablaRequisitos">
                        <thead>
                            <tr>
                                <th class="threquisito">REQUISITO</th>
                                <th style="width: 20%;">ESTADO</th>
                                <th style="width: 30%;">ACCIONES</th>
                            </tr>
                        </thead>
                        <?php foreach ($Requisitos as $ver) { ?>
                            <tbody>
                                <?php if ($ver['Digitalizado'] == 'NO') { ?>
                                    <tr>
                                        <td style="text-align: left; padding-left: 15px;"><label class="labelno"><?php echo $ver['TramitesRequisitosDetalles'] ?></label></td>
                                        <td style="text-align: center;"><label class="spanNoDigitalizado">No Digitalizado</label></td>
                                        <td style="text-align: center;">
                                            <button class="btnSubir subirDocHisotrial" id_requisito="<?php echo $ver['idTramitesRequisitos']; ?>" data-toggle="modal" requisito="<?php echo $ver['TramitesRequisitosDetalles'] ?>" data-target="#ModalAltaDocumentoDigitalizado">
                                                Subir Archivo
                                            </button>
                                        </td>
                                    </tr>
                                <?php } else {
                                    $anio = date("Y", strtotime($ver['fechaCreacion']));
                                    $periodoMes = date("m", strtotime($ver['fechaCreacion']));
                                    $dominio = $ver['detalle'];
                                    $archivo = $ver['titulo'];
                                    $ext = $ver['extension'];
                                    $periodo = "$anio-$periodoMes";
                                    $explode = explode(".", $archivo);
                                    $extension = "application/" . $explode[1];

                                    $src = "Transito/$agencia/$anio/$periodo/$dominio/$archivo";
                                    $ruta = "$ver[src]$archivo";
                                ?>
                                    <tr>
                                        <td style="text-align: left; padding-left: 15px;"><label class="labelSi"><?php echo $ver['TramitesRequisitosDetalles'] ?></td>
                                        <td style="text-align: center;"><label class="spanDigitalizado">Digitalizado</label></td>
                                        <td style="text-align: center;"><?php
                                                                        if ($ext == "application/pdf") { ?>
                                                <form action="Paginas/Visualizar/VerPdf.php" method="post" target="_blanck">
                                                    <input type="hidden" name="Di" value="<?php echo $ver['IdDocumentosDigitalizados'] ?>">
                                                    <button class="btnVisualizar" type="submit">Visualizar</button>
                                                </form>
                                            <?php } else { ?>
                                                <form action="Paginas/Visualizar/VerImagen.php" method="post" target="_blanck">
                                                    <input type="hidden" name="Di" value="<?php echo $ver['IdDocumentosDigitalizados'] ?>">
                                                    <button class="btnVisualizar" type="submit">Visualizar</button>
                                                </form>
                                            <?php  } ?>
                                            <button class="btnBorrar eliminarDocDig" type="button" id="<?php echo $ver[4]; ?>" archivo="<?php echo $ver[9]; ?>" url="DigitalizarDocumentos" dominio="<?php echo $_REQUEST['Do']; ?>" idAdherente="<?php echo $Ia = $_REQUEST['Ia']; ?>" codUsu="<?php echo $codUsu ?>" Usuario="<?php echo $Rol; ?>" data-descr="<?php echo $Iag = $_REQUEST['Iag']; ?>" dniChofer="<?php echo $Dc ?>" creacion="<?php echo $ver[11] ?>" Vd="<?php echo $Vd ?>" Vh="<?PHP echo $Vh ?>" agencia="<?php echo $Ag ?>" nombreArchivo="<?php echo $ver[5] ?>" iT="<?php echo $Itr ?>" iR="<?php echo $Iru ?>" data-toggle="modal" data-target="#ModalBajaArchivoHistorial">Borrar</button>
                                        </td>
                                    </tr>
                                <?php  } ?>

                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="masivo" role="tabpanel" aria-labelledby="contact-tab">
                <h3 class="h3tituloPeriodo">SELECCIONE LOS REQUISITOS QUE DESEA DIGITALIZAR</h3>
                <form action="" method="post" id="FormularioMasivo" enctype="multipart/form-data">
                    <input type="hidden" name="Ul" value="Periodo" form="FormularioMasivo">
                    <input type="hidden" name="FormularioAltaMasiva" value="FormularioAltaMasiva" form="FormularioMasivo">
                    <div class="ContenedorFormMasivo">
                        <table class="tablaInsertMasivo">
                            <thead>
                                <tr>
                                    <th class="threquisito">REQUISITO</th>
                                    <!-- <th style="width: 20%;">ESTADO</th> -->
                                    <th style="width: 27%;">ACCIONES</th>
                                </tr>
                            </thead>
                            <?php foreach ($Requisitos as $ver) { ?>
                                <tbody>
                                    <?php if ($ver['Digitalizado'] == 'NO') { ?>
                                        <tr>
                                            <td style="text-align: left; padding-left: 15px;"><?php echo $ver['TramitesRequisitosDetalles'] ?></td>
                                            <!-- <td style="text-align: center;"><label class="spanNoDigitalizado">No Digitalizado</label></td> -->
                                            <td style="text-align: center;">
                                                <input type="hidden" name="Vd" value="<?php echo $DESDE  ?>">
                                                <input type="hidden" name="Vh" value="<?php echo $HASTA  ?>">
                                                <input type="hidden" name="Ia" value="<?php echo $Ia ?>">
                                                <input type="hidden" name="Do" value="<?php echo $Do ?>">
                                                <input type="hidden" name="Us" value="<?php echo $Rol; ?>" required />
                                                <input type="hidden" name="Cus" value="<?php echo $codUsu; ?>" required />
                                                <input type="hidden" name="Iag" value="<?php echo $Iag = $_REQUEST['Iag']; ?>" required />
                                                <input type="hidden" name="Ag" value="<?php echo $Ag; ?>" required />
                                                <input type="hidden" name="Ir[]" value="<?php echo $ver['idTramitesRequisitos'] ?>">
                                                <input type="hidden" name="Ti[]" value="<?php echo $ver['TramitesRequisitosDetalles'] ?>">
                                                <input type="hidden" name="id_adherente" value="<?php NULL ?>">
                                                <input type="hidden" name="Itr" value="8">
                                                <input type="hidden" name="Iru" value="0">
                                                <input type="file" name="image[]" class="form-control inputFileMasivo">
                                                <input type="hidden" name="Dc" value="<?php echo rtrim($Dc) ?>">
                </form>
                </td>
                </tr>
            <?php } else {
                                        $anio = date("Y", strtotime($ver['fechaCreacion']));
                                        $periodoMes = date("m", strtotime($ver['fechaCreacion']));
                                        $dominio = $ver['detalle'];
                                        $archivo = $ver['titulo'];
                                        $ext = $ver['extension'];
                                        $periodo = "$anio-$periodoMes";
                                        $explode = explode(".", $archivo);
                                        $extension = "application/" . $explode[1];

                                        $src = "Transito/$agencia/$anio/$periodo/$dominio/$archivo";
                                        $ruta = "$ver[src]$archivo";
            ?>
                <tr>
                    <td style="text-align: left; padding-left: 15px;"><label class="labelSi"><?php echo $ver['TramitesRequisitosDetalles'] ?></label></td>
                    <!-- <td style="text-align: center;"><label class="spanDigitalizado">Digitalizado</label></td> -->
                    <td style="text-align: center;"><label class="SpanRequisitosOK">Requisito Digitalizado</label></td>
                </tr>
            <?php  } ?>

            </tbody>
        <?php } ?>

        </table>
        <div class="footer-formMasivo d-flex justify-content-center">
            <button type="submit" class="btn btnInsertMasivo" form="FormularioMasivo">Guardar Archivos</button>
        </div>
            </div>
        </div>


        <?php
        $tra = DigiExpedientesControlador::ctrAltaArchivo();
        echo '<pre>';
        print_r($tra);
        echo '</pre>';
        $tra2 = DigiExpedientesControlador::ctrBajaArchivo();
        echo '<pre>';
        print_r($tra2);
        echo '</pre>';
        $tra3 = DigiExpedientesControlador::CtrlAltaMasiva();
        echo '<pre>';
        print_r($tra3);
        echo '</pre>';

        ?>
        <?php
        include_once 'Paginas/Altas/FormAltaArchivoHistorial.php';
        include_once 'Paginas/Bajas/BajaArchivoHistorial.php'
        ?>