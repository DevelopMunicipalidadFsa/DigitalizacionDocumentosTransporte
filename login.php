<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-icon" href="Librerias/img/logoMunicipalidadFsa.png">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sistema de Digitalización Remises</title>
  <link rel="stylesheet" href="Librerias/css/Bootstrap5/bootstrap.min.css">
  <link rel="stylesheet" href="Librerias/css/Estilos/styleLogin.css">
    
  <script src="Librerias/js/Scripts/jquery-3.5.1.min.js"></script>
  <script src="Librerias/js/Scripts/script.js"></script>
</head>

<body>
  <center>
    <center>
      <div class="page">
        <?php if (isset($_GET["SESSION_EXPIRED"])) { ?>
          <center>
            <div class="sesionExpirada">
              <h3>¡La sesion ha expirado!</h3>
              <h4>Vuelva a iniciar sesión</h4>
            </div>
          </center>

        <?php } ?>
        <div class="container-fluid">
          <div class="row d-flex justify-content-center">
            <div class="col-md-4">
              <div class="right">
                <center>
                  <img class="logoLogin" src="Librerias/img/logoMunicipalidadFsa.png">
                  <h5>Digitalización Documentos Remises</h5>
                  <h1>Iniciar Sesión</h1>
                </center>
                <form class="form_regis" method="POST" action="validarLogin.php">
                  <center>
                    <p>
                      <input class="input" autocomplete="off" type="number" id="username" name="username" placeholder="Usuario">
                    <div style="margin-top: -5px; margin-bottom: 0px;" id="result-username"></div>
                    </p>
                    <p>
                      <input class="input" autocomplete="off" type="password" name="clave" placeholder="Contraseña" required>
                    </p>
                    <button class="btn_submit" type="submit" id="btnIngresar">Ingresar</button>
                  </center>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </center>
  </center>
</body>
<?php include_once 'validarLogin.php'; ?>
<!-- Sciripts para el uso de JQuery y Bootstrap -->
<script src="Librerias/js/Scripts/jquery-3.4.1.min.js"></script>
<script src="Librerias/js/Scripts/bootstrap.min.js"></script>

</html>