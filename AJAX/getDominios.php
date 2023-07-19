<?php 

require_once '../Controladores/ControladorDigitalizacionExp.php';
require_once '../Modelos/ModelosDigitalizacionExp.php';

if(isset($_POST['id_agencia'])){
    $id_agencia = $_POST['id_agencia'];
    $Dominios = ControladorDominios::CtrMostrarDominios($id_agencia);
    
    echo json_encode($Dominios,JSON_UNESCAPED_UNICODE);
} else { 
    echo json_encode('<h3 class="seleccioneDominio">Debe seleccionar una Agencia</h3>');
 }
