<?php
require_once '../../../Controladores/ControladorDigitalizacionExp.php';
require_once '../../../Modelos/ModelosDigitalizacionExp.php';

$idDocumento = $_POST['Di'];

$ConsultaDocDig = Conexiones::conDDLocal()->prepare("SELECT [IdDocumentosDigitalizados]
				,[idAdherente]
				,[idRequisitosTramites]
				,[titulo]
				,[detalle]
				,[Descripcion]
				,[src]
				,[archivo]
				,[extension]
				,[fechaCreacion]
				,[fechaValidoHasta]
		FROM [MunicipalidadDigital].[dbo].[DocumentosDigitalizados]
		WHERE
		[IdDocumentosDigitalizados]=$idDocumento");
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
	<meta charset="UTF-8">
	<title></title>
</head>

<body>
	<?php

	$ConsultaDocDig->execute();

	$Digitalizado = array();
	if ($digi = $ConsultaDocDig->fetchAll()) {
		foreach ($digi as $fila) {
			$agencia;
			$anio = date("Y", strtotime($fila['fechaValidoHasta']));
			$periodoMes = date("m", strtotime($fila['fechaValidoHasta']));
			$dominio = $fila['detalle'];
			$archivo = $fila['titulo'];
			$periodo = "$anio$periodoMes";
			$dir = $fila['src'];

			$src = "Transito/$agencia/$anio/$periodo/$dominio/$archivo";
			$src2 = $dir . "/" . $archivo;

			$mi_pdf = fopen("$src2", "r");
			if (!$mi_pdf) {
				echo "<p>No puedo abrir el archivo para lectura</p>";
				exit;
			}
			header('Content-type: application/pdf');
			fpassthru($mi_pdf); // Esto hace la magia
			fclose($archivo);

	?>
	<?php 	}
	}


	?>



</body>

</html>