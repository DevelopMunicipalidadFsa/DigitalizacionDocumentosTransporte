<?php 
include 'Modelos/conexiones.php';
sleep(1);

if (isset($_POST)) {
    $username = (string)$_POST['username'];
 	if ($username == true) {
    			$consulta="";
				$ContibuDatos = Conexiones::conDDLocal()->prepare("SELECT  * FROM [municipio].[dbo].[Usuarios2]
					WHERE
					codusu = $username");
				
				if ($ContibuDatos -> execute()) {
					$RTA= $ContibuDatos -> fetchAll();
					if(empty($RTA)) { ?>
						<label style="font-weight: bold; height: 10px; margin: 0px;" class="text-danger text-center">Usuario no existe</label>
						<?php }else{
						foreach ($RTA as $key => $value) { ?>
							<label style="height: 10px; font-weight: bold; margin: -10px;" class="text-success text-center"><?php echo $value['nombre'] ?></label>
						<?php }
					}
				}
				
	}
 
 }


