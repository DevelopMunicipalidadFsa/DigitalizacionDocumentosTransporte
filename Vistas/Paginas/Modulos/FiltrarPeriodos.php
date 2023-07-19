<?php

$Fdesde = $_REQUEST['Vd'];
$Fhasta = $_REQUEST['Vh'];
$dominio = $_REQUEST['Do'];
$id_adherente = $_REQUEST['Ia'];
$idAgencia = $_REQUEST['Iag'];
$dniChofer = $_REQUEST['Dc'];
$id_tramite = 8;
$id_rubro = 0;
$agencia = $_REQUEST['Ag'];

$DESDE = date("d/m/Y", strtotime($_REQUEST['Vd']));
$HASTA = date("d/m/Y", strtotime($_REQUEST['Vh']));

$Requisitos = ControladorFiltrarRequisitos::CtrMostrarRequisitosFiltrados($id_tramite, $id_rubro, $id_adherente, $dominio, $Fdesde, $Fhasta); ?>

<div class="ContenedorGeneralAdherente">
    <div class="infoTitular">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <form action="plantillas.php?pagina=Modulos/ResolucionesChoferes" method="post">
                    <input type="hidden" name="Ia" value="<?php echo $id_adherente ?>">
                    <input type="hidden" name="Do" value="<?php echo rtrim($dominio) ?>">
                    <input type="hidden" name="Iag" value="<?php echo $idAgencia ?>">
                    <input type="hidden" name="Dc" value="<?php echo $dniChofer ?>">
                    <button type="submit" class="nav-link"><i class="fas fa-reply"></i></button>  
                </form>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="home" aria-selected="true">Documentos Digitalizados</a>
            </li>
        </ul>
        <div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <h3 class="tituloinfoDominio">Listado de requisitos Desde: <?php echo $DESDE ?> Hasta: <?php echo $HASTA ?></label></h3>

            <div class="divGeneralRequisitos">

                    <table class="tablaRequisitos">
                        <thead>
                            <tr>
                                <th class="threquisito">REQUISITO</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <?php foreach ($Requisitos as $ver) { ?>
                            <tbody>
                                <?php if ($ver['Digitalizado'] == 'NO') { ?>
                                    <tr>
                                        <td><label class="labelno"><?php echo $ver['TramitesRequisitosDetalles'] ?></label></td>
                                        <td style="text-align: center;"><i class="fas fa-times"></i></td>
                                        <td style="text-align: center;">
                                            <button class="btnSubir subir" data-descr="<?php echo $ver['idTramitesRequisitos']; ?>" data-toggle="modal" requisito="<?php echo $ver['TramitesRequisitosDetalles'] ?>" data-target="#exampleModalCenter">
                                                <i class="fas fa-file-upload"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } else {
                                    $anio = date("Y", strtotime($ver['fechaCreacion']));
                                    $periodoMes = date("m", strtotime($ver['fechaCreacion']));
                                    $dominio = $ver['detalle'];
                                    $archivo = $ver['titulo'];
                                    $ext = $ver['extension'];
                                    $periodo = "$anio$periodoMes";
                                    $explode = explode(".", $archivo);
                                    $extension = "application/" . $explode[1];

                                    $src = "Transito/$agencia/$anio/$periodo/$dominio/$archivo";
                                    $ruta = "$ver[src]$archivo";
                                ?>
                                    <tr>
                                        <td><label class="labelSi"><?php echo $ver['TramitesRequisitosDetalles'] ?></label></td>
                                        <td style="text-align: center;"><i class="fas fa-check"></i></td>
                                        <td style="text-align: center;"><?php
                                                                        if ($ext == "application/pdf") { ?>
                                                <a class="btnVisualizar visualizar" target="_blank" href="Paginas/archivoPDF.php?Di=<?php echo $ver['IdDocumentosDigitalizados'] ?>&Ag=<?php echo $agencia ?>"><i class="fas fa-eye"></i></a>
                                            <?php } else { ?>
                                                <a class="btnVisualizar visualizar" target="_blank" href="Paginas/verArchivo.php?Di=<?php echo $ver['IdDocumentosDigitalizados'] ?>&Ag=<?php echo $agencia ?>"><i class="fas fa-eye"></i></a>
                                            <?php  } ?>
                                            <button class="btnBorrar eliminar" type="button" id="<?php echo $ver[4]; ?>" archivo="<?php echo $ver[9]; ?>" direccion="FiltrarFechas" dominio="<?php echo $_REQUEST['Do']; ?>" idAdherente="<?php echo $id_adherente = $_REQUEST['Ia']; ?>" codUsu="<?php echo $codUsu ?>" Usuario="<?php echo $Rol; ?>" data-descr="<?php echo $idAgencia = $_REQUEST['Iag']; ?>" dniChofer="<?php echo $dniChofer ?>" creacion="<?php echo $ver[11] ?>" Fdesde="<?php echo $Fdesde ?>" Fhasta="<?PHP echo $Fhasta ?>" agencia="<?php echo $agencia ?>" nombreArchivo="<?php echo $ver[5] ?>" iT="<?php echo $id_tramite ?>" iR="<?php echo $id_rubro ?>"><i class="fas fa-trash" data-toggle="modal" data-target="#ModalBajaFiltro"></i></button>
                                        </td>
                                    </tr>
                                <?php  } ?>

                            </tbody>
                        <?php } ?>
                    </table>

                
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

include_once 'Paginas/Altas/FormAltaArchivo.php'; 
include_once 'Paginas/Bajas/BajaArchivoFiltro.php' 
?>