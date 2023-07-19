<?php

if (isset($_SESSION['nombre'])) {
    // 	//Se crea una variable que tenga la varible de sesión que trae el rol del usuario
    $Rol = $_SESSION['nombre'];
    $IdArea = $_SESSION['IdArea'];
    $codUsu = $_SESSION['codusu'];
    //  //sino, calculamos el tiempo transcurrido
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $items2 = date("j-n-Y H:i:s", time());
    $date = new DateTime($items2, new DateTimeZone('America/Argentina/Buenos_Aires'));
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $zonahoraria = date_default_timezone_get();
    $items2 = date("j-n-Y H:i:s", time());
    $ahora = $items2;
    $tiempo_transcurrido = (strtotime($ahora) - strtotime($fechaGuardada));

    //comparamos el tiempo transcurrido
    if ($tiempo_transcurrido >= 3000) {
        //si pasaron 10 minutos o más
        session_destroy(); // destruyo la sesión
        $mensaje = 'YES';
        header("Location: ../login.php?SESSION_EXPIRED=$mensaje");
        //header("index.php:SESSION_EXPIRED=$mensaje"); envío al usuario a la pag. de autenticación
        // //sino, actualizo la fecha de la sesión
    } else {
        $_SESSION["ultimoAcceso"] = $ahora;
        $_SESSION["ultimoAcceso"];
    }
} else {
    header("Location: ../login.php");
}


?>

<header class="header">
    <div class="content3divs">
        <div class="div1"><img class="logo_header" src="../librerias/img/original.png">
            <!-- <label class="labelNav">Digitalización Documentos Remises</label> -->
            <label class="lblMuniDigital">Municipalidad Digital</label><br>
            <label class="lblDigitalizacion">Digitalización Documentos Remises</label>
        </div>
        <div class="div2"></div>
        <div class="div3">
            <a class="btnSalir" href="../cerrarSession.php"><i class="fas fa-power-off"></i></a>
            <label class="lblBienvenido">Bienvenido/a</label>
            <label class="lblUsuario"><?php echo $Rol ?></label>
        </div>
    </div>
</header>
