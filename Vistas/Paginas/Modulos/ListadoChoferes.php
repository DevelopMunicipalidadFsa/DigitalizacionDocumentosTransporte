<?php

require_once '../../../Controladores/ControladorDigitalizacionExp.php';
require_once '../../../Modelos/ModelosDigitalizacionExp.php';

if (isset($_REQUEST['dominio']) && isset($_REQUEST['id_agencia'])) {
  $dominio = $_REQUEST['dominio'];
  $id_agencia = $_REQUEST['id_agencia'];
  $Choferes = ControladorChoferes::CtrMostrarChoferes($dominio);
  
  // $fechaActual = getdate();

  // print_r($fechaActual);

  if ($Choferes == FALSE) { ?>
    <h3 class="h3SinChoferes">No se encontraron choferes para este dominio <?php echo $dominio ?></h3>
  <?php } else { ?>
    <center>
      <!-- <div class="divTablaChoferes"> -->
      <table class="tablaChoferes">
        <thead>
          <th>CHOFER</th>
          <th>DNI</th>
          <th>CLASE</th>
          <th>VTO</th>
          <th>VISUALIZAR</th>
        </thead>
        <?php foreach ($Choferes as $chofer) :
        $Vencimiento = $chofer[5];
        $fechaVto = date("d/m/Y", strtotime($Vencimiento));  
        ?>
          <tbody>

            <tr>
              <td class="tdChofer"><?PHP echo $chofer[3] ?></td>
              <td><?php echo $chofer[1] ?></td>
              <td><?php echo $chofer[4] ?></td>
              <td><?php echo $fechaVto?></td>
              <td>
                <form action="plantillas.php?pagina=Modulos/ResolucionesChoferes" method="post">
                  <input type="hidden" name="Ia" value="<?php echo $chofer[0] ?>">
                  <input type="hidden" name="Do" value="<?php echo rtrim($dominio) ?>">
                  <input type="hidden" name="Iag" value="<?php echo $id_agencia ?>">
                  <input type="hidden" name="Dc" value="<?php echo $chofer[1] ?>">

                  <button class="verDocumentos">Más Información</button>
                </form>
              </td>
            </tr>

          </tbody>
        <?php endforeach; ?>
      </table>
      <!-- </div> -->
    </center>
  <?php  }
} else { ?>
  <h3 class="h3SinAgencia">Debe seleccionar o filtrar un dominio para iniciar busqueda</h3>
<?php }

?>