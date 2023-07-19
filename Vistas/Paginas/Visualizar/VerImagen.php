<?php 

require_once '../../../Controladores/ControladorDigitalizacionExp.php';
require_once '../../../Modelos/ModelosDigitalizacionExp.php';

$ftp_server='192.168.0.2'; 
$ftp_user_name='webdig'; 
$ftp_user_pass='muni1234'; 

$conn_id = ftp_connect($ftp_server); 

$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 



$idDocumento = $_POST['Di'];


$ConsultaDocDig = Conexiones::conDDLocal()->prepare("SELECT 
[IdDocumentosDigitalizados]
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
,[Activo]
,[SegExpediente]
FROM [MunicipalidadDigital].[dbo].[DocumentosDigitalizados]
WHERE
[IdDocumentosDigitalizados]=$idDocumento");
        

        $ConsultaDocDig->execute();

	$Digitalizado = array();
	// $digi = $ConsultaDocDig->fetchAll();
	// print_r($digi);
	if ($digi = $ConsultaDocDig->fetchAll()) {
		foreach ($digi as $fila) {
			$archivo = $fila['titulo'];
			$dir = $fila['src'];
            $extension = $fila['extension'];
			$src2 = "$dir$archivo";
            

            $mi_pdf = fopen ("$src2", "r");
            if (!$mi_pdf) {
                echo "<p>No puedo abrir el archivo para lectura</p>";
            exit;
            }

		}
	}

   
header('Content-type: '.$extension);
fpassthru($mi_pdf);

?>