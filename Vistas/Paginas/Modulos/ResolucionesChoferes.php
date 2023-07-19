<?php
require_once '../Controladores/ControladorDigitalizacionExp.php';
require_once '../Modelos/ModelosDigitalizacionExp.php';

$dominio = $_REQUEST['Do'];
$id_adherente = $_REQUEST['Ia'];
$idAgencia = $_REQUEST['Iag'];
$dniChofer = $_REQUEST['Dc'];
$url = "ResolucionesChoferes";

$Agencia = ControladorAgencia::CtrMostrarAgencia($idAgencia);

foreach ($Agencia as $ver) {
    $agencia = $ver[1];
}

$Fecha = ControladorFiltrarRequisitos::CtrlFecha($id_adherente, $dominio);
if ($Fecha == "no") {
    $mensaje = "Aún no se digitalizaron periodos";
} else {
    foreach ($Fecha as $val) {
        $fechad = $val[0];
        // $fechah = $val[1];
        $anio = date("Y", strtotime($val[0]));
        $periodoMes = date("m", strtotime($val[0]));
        $periodo = "$anio-$periodoMes";

        $mensaje = "Ultimo periodo registrado: " . $periodo;
    }
}
?>

<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">


<div class="ContenedorGeneralAdherente">
    <div class="infoTitular">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link btnAtras" href="plantillas.php?pagina=Modulos/GestionRemises">
                    <i class="fas fa-reply"></i> Volver a Filtrar</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Datos del Chofer</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Datos del Propietario</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="contact-tab" data-toggle="tab" href="#hist" role="tab" aria-controls="contact" aria-selected="false">Digitalizar Documentos</a>
            </li>
        </ul>
    </div>
    <div class="tab-content contenidoNAV" id="myTabContent">
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h3 class="h3DatosChofer">Datos del Chofer del Dominio <span class="colorDominio"><?php echo $dominio ?></span></h3>
            <?php if (isset($_REQUEST['Ia'])) {
                $id_adherente = $_REQUEST['Ia'];
                $Chofer = ControladorDatosChofer::CtrMostarDatosChofer($id_adherente);
                foreach ($Chofer as $chofer) { ?>
                    <div class="datosCHofer">
                        <label class="encabezadoInput">Nombre Completo</label><br>
                        <input class="inputDato" type="text" disabled value="<?php echo $chofer['chofer'] ?>"><br>

                        <label class="encabezadoInputDniC">Dni</label><label class="encabezadoInputCuilC">Cuil</label><br>
                        <input class="inputDatoDniC" type="text" disabled value="<?php echo $chofer['dni'] ?>">
                        <input class="inputDatoCuilC" type="text" disabled value="<?php echo $chofer['cuim'] ?>"><br>

                        <!-- <label class="encabezadoInput">Id Adherente</label><br>
                                <?php if ($chofer['idadhere'] == NULL) { ?>
                                    <input class="inputDato" type="text" style="text-align: center;" disabled value="--------">
                                <?php } else { ?>
                                    <input class="inputDato" type="text" disabled value="<?php echo $chofer['idadhere'] ?>">
                                <?php } ?> -->

                        <label class="encabezadoInputDni">Clase</label><label class="encabezadoInputCuil">Fecha de vencimiento</label><br>
                        <input class="inputDatoDni" type="text" disabled value="<?php echo $chofer['clase'] ?>">
                        <input class="inputDatoCuil" type="text" disabled value="<?php echo $chofer['fechavto'] ?>"><br>
                    </div>
            <?php }
            } ?>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <h3 class="h3DatosPersonales">Datos Personales del Propietario</h3>
            <h3 class="h3DatosVehiculo">Datos del Vehículo</h3>
            <div class="datosPersonales">
                <?php
                if (isset($_REQUEST['Do'])) {
                    $dominio = $_REQUEST['Do'];
                    $Titular = ControladorTitularVehiculo::CtrMostrarDatosTitularVehiculo($dominio);

                    foreach ($Titular as $dominio) { ?>
                        <label class="encabezadoInput">Nombre Completo</label><br>
                        <input class="inputDato" type="text" disabled value="<?php echo $dominio['propietario'] ?>"><br>

                        <label class="encabezadoInputDni">Dni</label><label class="encabezadoInputCuil">Cuil</label><br>
                        <input class="inputDatoDni" type="text" disabled value="<?php echo $dominio['dni'] ?>">
                        <input class="inputDatoCuil" type="text" disabled value="<?php echo $dominio['cuim'] ?>"><br>
                <?php }
                }
                ?>
            </div>
            <div class="Domicilio">
                <label class="encabezadoInput">Barrio</label><br>
                <?php if ($dominio['barrio'] == NULL) { ?>
                    <input class="inputDato" type="text" disabled value="-------">
                <?php } else { ?>
                    <input class="inputDato" type="text" disabled value="<?php echo $dominio['barrio'] ?>">
                <?php } ?>
                <label class="encabezadoInput">Calle</label><br>
                <?php if ($dominio['calle'] == NULL) { ?>
                    <input class="inputDato" type="text" disabled value="-------">
                <?php } else { ?>
                    <input class="inputDato" type="text" disabled value="<?php echo $dominio['calle'] ?>">
                <?php } ?>
                <label class="encabezadoInput">Altura</label><br>
                <?php if ($dominio['altura'] == NULL) { ?>
                    <input class="inputDato" type="text" disabled value="-------">
                <?php } else { ?>
                    <input class="inputDato" type="text" disabled value="<?php echo $dominio['altura'] ?>">
                <?php } ?>
                <label class="encabezadoInput">Dirección</label><br>
                <?php if ($dominio['direccion'] == NULL) { ?>
                    <input class="inputDato" type="text" disabled value="-------">
                <?php } else { ?>
                    <input class="inputDato" type="text" disabled value="<?php echo $dominio['direccion'] ?>">
                <?php } ?>
            </div>
            <div class="datos_vehiculo">
                <label class="encabezadoInput">Tipo de Vehículo</label><br>
                <input class="inputDato" type="text" disabled value="<?php echo $dominio['tipovehi'] ?>"><br>

                <label class="encabezadoInput">Marca</label><br>
                <input class="inputDato" type="text" disabled value="<?php echo $dominio['marca'] ?>"><br>

                <label class="encabezadoInput">Año</label><br>
                <input class="inputDato" type="text" disabled value="<?php echo $dominio['año'] ?>"><br>

                <label class="encabezadoInput">N° Motor</label><br>
                <input class="inputDato" type="text" disabled value="<?php echo $dominio['motorvehi'] ?>"><br>
            </div>

        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <?php

            if (isset($_REQUEST['Do']) && isset($_REQUEST['Ia']) && isset($_REQUEST['Iag'])) {
                $dominio = $_REQUEST['Do'];
                $id_adherente = $_REQUEST['Ia'];
                $idAgencia = $_REQUEST['Iag'];
                $dniChofer = $_REQUEST['Dc'];
                $id_tramite = 8;
                $id_rubro = 0;

                $requi = ControladorRequisitos::CtrMostrarRequisitos($id_tramite, $id_rubro, $id_adherente, $dominio); ?>
                <center>
                    <div class="FiltroFechaRequisito">
                        <div class="divNuevoPeriodo">
                            <button class="btnNperiodo Nperiodo" data-toggle="modal" data-target="#ModalNperiodo">
                                <i class="fas fa-folder-plus"></i> Ingresar nuevo periodo
                            </button>
                        </div>
                        <div class="divMensaje">
                            <h4 class="aviso"><?php echo $mensaje ?></h4>
                        </div>
                    </div>
                </center>
                <div class="divGeneralRequisitos" id="resultadoFiltro">
                    <table class="tablaRequisitos" id="tabla">
                        <thead>
                            <tr>
                                <th class="threquisito">REQUISITOS</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <?php foreach ($requi as $ver) { ?>
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
                                    $periodob = "$anio-$periodoMes";
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
                                                <a class="btnVisualizar visualizar" target="_blank" href="Paginas/Visualizar/VerPdf.php?Di=<?php echo $ver['IdDocumentosDigitalizados'] ?>&Ag=<?php echo $agencia ?>"><i class="fas fa-eye"></i></a>
                                            <?php } else { ?>
                                                <a class="btnVisualizar visualizar" target="_blank" href="Paginas/Visualizar/VerImagen.php?Di=<?php echo $ver['IdDocumentosDigitalizados'] ?>&Ag=<?php echo $agencia ?>"><i class="fas fa-eye"></i></a>
                                            <?php  } ?>
                                            <button class="btnBorrar eliminar" type="button" id="<?php echo $ver[4]; ?>" archivo="<?php echo $ver[9]; ?>" dominio="<?php echo $_REQUEST['Do']; ?>" idAdherente="<?php echo $id_adherente = $_REQUEST['Ia']; ?>" codUsu="<?php echo $codUsu ?>" Usuario="<?php echo $Rol; ?>" data-descr="<?php echo $idAgencia = $_REQUEST['Iag']; ?>" dniChofer="<?php echo $dniChofer ?>" creacion="<?php echo $ver[11] ?>" agencia="<?php echo $agencia ?>" nombreArchivo="<?php echo $ver[5] ?>" direccion="ResolucionesChoferes" Vd="0" Vh="0" data-toggle="modal" data-target="#ModalBajaArchivo"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php  } ?>
                            </tbody>
                        <?php } ?>
                    </table>


                </div>
            <?php } ?>
        </div>
        <div class="tab-pane fade show active" id="hist" role="tabpanel" aria-labelledby="contact-tab">
            <h3 class="h3Historial">Digitalizar Documentos por Periodo Registrado</h3>

            <?php $periodos = ControladorHistorialChoferes::CtrMostrarPeriodosDominio($dominio, $idAgencia);
            if ($periodos == "vacio") {
                echo "<label class='Nodispo'>Aún no se registraron periodos</label>";
            } else { ?>

                <div class="ContenedorTablaPeriodos">
                    <table class="TablaPeriodos">
                        <thead>
                            <tr>
                                <th>PERIODO</th>
                                <th>FECHA EMISIÓN</th>
                                <th>FECHA VENCIMIENTO</th>
                                <th>DISPOSICIÓN</th>
                                <th>DIGITALIZAR</th>
                            </tr>
                        </thead>
                        <?php foreach ($periodos as $value) {
                            $Vdesde = $value['segdesde'];
                            $Vhasta = $value['seghasta'];

                            $emision = date("d-m-Y", strtotime($Vdesde));
                            $vencimiento = date("d-m-Y", strtotime($Vhasta));

                            $anio = date("Y", strtotime($Vdesde));
                            $periodoAnio = date("Y", strtotime($Vdesde));
                            $periodoMes = date("m", strtotime($Vdesde));
                            $periodo = "$periodoAnio-$periodoMes";

                            $anio2 = date("Y", strtotime($Vhasta));
                            $periodoAnio2 = date("Y", strtotime($Vhasta));
                            $periodoMes2 = date("m", strtotime($Vhasta));
                            $periodo2 = "$periodoAnio2$periodoMes2";
                            
                            $expediente = $value['numexpte'];
                            $Dc = $value['dni'];
                            $Do = $_REQUEST['Do'];

                            $IdAdherente = ControladorDatosChofer::CtrlExtraerIdAdherente($expediente, $Dc, $Do);

                            foreach ($IdAdherente as $adherente) {
                                $Ia = $adherente[0];
                            }

                        ?>
                            <tbody>
                                <tr>
                                    <td style="text-align: center;"><?php echo $periodo ?></td>
                                    <td style="text-align: center;"><?php echo $emision ?></td>
                                    <td style="text-align: center;"><?php echo $vencimiento ?></td>
                                    <td style="text-align: center;"><?php echo $value[5] ?></td>
                                    <td style="text-align: center;">
                                        <form action="plantillas.php?pagina=Modulos/Periodo" method="post">

                                            <input type="hidden" name="Do" value="<?php echo $dominio ?>">
                                            <input type="hidden" name="Ia" value="<?php echo $Ia ?>">
                                            <input type="hidden" name="id_adherente" value="<?php echo $id_adherente ?>">
                                            <input type="hidden" name="Iag" value="<?php echo $idAgencia ?>">
                                            <input type="hidden" name="Dc" value="<?php echo $dniChofer ?>">
                                            <input type="hidden" name="Itr" value="<?php echo 8 ?>">
                                            <input type="hidden" name="Iru" value="<?php echo 0 ?>">
                                            <input type="hidden" name="Ag" value="<?php echo rtrim($agencia) ?>">
                                            <input type="hidden" name="Vd" value="<?php echo $Vdesde ?>">
                                            <input type="hidden" name="Vh" value="<?php echo $Vhasta ?>">
                                            <input type="hidden" name="Per" value="<?php echo $periodo ?>">

                                            <button type="submit" class="verDocumentos">Digitalizar Documentos</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>

            <?php  } ?>
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

?>
<?php
// include_once 'Paginas/Altas/ModalNuevoPeriodo.php';
// include_once 'Paginas/Altas/PeriodosRegistrados.php';
// include_once 'Paginas/Altas/FormularioAltaArchivo.php';
// include_once 'Paginas/Bajas/FormularioBajaArchivo.php';
?>