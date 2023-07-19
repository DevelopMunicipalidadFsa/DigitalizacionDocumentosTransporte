<?php

require_once '../Controladores/ControladorDigitalizacionExp.php';
require_once '../Modelos/ModelosDigitalizacionExp.php';

if (isset($_POST['dominio'])) {
    $dominio = $_POST['dominio'];
    $Periodos = ControladorHistorialChoferes::CtrlHistoDominio($dominio);
    if ($Periodos == "vacio") { ?>
        <h3 class="h3SinResultados">No se encontraron registros para la busqueda: <?php echo $dominio ?></h3>
    <?php } else { ?>
        <table class="TablaFiltrada">
            <thead>
                <tr>
                    <th>DOMINIO</th>
                    <th>PROPIETARIO</th>
                    <th>DNI</th>
                    <th>AGENCIA</th>
                    <th>EXPTE</th>
                    <!-- <th>DETALLE</th> -->
                    <th>SEG DESDE</th>
                    <th>SEG HASTA</th>
                    <th>DIGITALIZAR</th>
                </tr>
            </thead>
            <?php foreach ($Periodos as $peri) {
                $Desde = $peri['segdesde'];
                $Hasta = $peri['seghasta'];
                $expediente = $peri['numexpte'];
                $Dc = $peri['dni'];
                $Do = $peri['dominio'];

                $FechaDesde = date("d-m-Y", strtotime($Desde));
                $FechaHasta = date("d-m-Y", strtotime($Hasta));

                $anio = date("Y", strtotime($Desde));
                $periodoAnio = date("Y", strtotime($Desde));
                $periodoMes = date("m", strtotime($Desde));
                $periodo = "$periodoAnio-$periodoMes";


                $IdAdherente = ControladorDatosChofer::CtrlExtraerIdAdherente($expediente, $Dc, $Do);

                foreach ($IdAdherente as $adherente) {
                    $Ia = $adherente[0];
                }
            ?>
                <tbody>
                    <tr>
                        <td style="text-align: center;"><?php echo $peri['dominio'] ?></td>
                        <td><?php echo $peri[1] ?></td>
                        <td><?php echo $peri[2] ?></td>
                        <td style="text-align: left;"><?php echo $peri[4] ?></td>
                        <td><?php echo $peri[5] ?></td>
                        <!-- <td><?php echo $peri[6] ?></td> -->
                        <td><?php echo $FechaDesde ?></td>
                        <td><?php echo $FechaHasta ?></td>
                        <td>
                            <form action="plantillas.php?pagina=Modulos/DigitalizarDocumentos" method="post">
                                <input type="hidden" name="Do" value="<?php echo $Do ?>">
                                <input type="hidden" name="Ia" value="<?php echo $Ia ?>">
                                <input type="hidden" name="Iag" value="<?php echo $peri['idagen'] ?>">
                                <input type="hidden" name="Dc" value="<?php echo $Dc ?>">
                                <input type="hidden" name="Itr" value="<?php echo 8 ?>">
                                <input type="hidden" name="Iru" value="<?php echo 0 ?>">
                                <input type="hidden" name="Ag" value="<?php echo rtrim($peri['agencia']) ?>">
                                <input type="hidden" name="Vd" value="<?php echo $FechaDesde ?>">
                                <input type="hidden" name="Vh" value="<?php echo $FechaHasta ?>">
                                <input type="hidden" name="Per" value="<?php echo $periodo ?>">
                                <button type="submit" class="verDocumentos">Digitalizar Documentos</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
    <?php } ?>

<?php } else { ?>
    <h3 class="h3SinAgencia">Debe seleccionar o filtrar un dominio para iniciar busqueda</h3>
<?php }
