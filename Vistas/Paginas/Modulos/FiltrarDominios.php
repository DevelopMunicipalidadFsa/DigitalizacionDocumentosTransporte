<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>
</head>

<body>
    <div class="ContenedorGeneralFiltros">
        <div class="Contenedorfiltro1">
            <?php $Agencias = ControladorAgencias::CtrMostrarAgencias(); ?>
            <select class="selectAgencias" id="id_agencia">
                <option value="">Seleccionar una agencia</option>

                <?php foreach ($Agencias as  $value) { ?>
                    <option value="<?php echo $value[0]; ?>"><?php echo $value[1]; ?>
                    </option>
                <?php } ?>
                <select>
        </div>
        <div class="Contenedorfiltro2">
            <select class="selecDominio" id="dominio" name="dominio">
                <option value="">Dominios</option>
            </select>
        </div>
        <div class="Contenedorfiltro3">
            <center>
                <div class="caja_filtro">
                    <input type="text" name="busquedaDominio" id="busquedaDominio" class="filtro" onKeyUp="this.value=this.value.toUpperCase();" ></input>
                    <input type="text" name="busquedaDominio" id="busquedaDominio" class="filtroResponsive" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Filtrar Dominio o Resolución"></input>
                    <label class="labelFiltro">Filtrar Dominio o Resolución</label>
                </div>
            </center>
        </div>
    </div>
    <div class="DivChoferes" id="tabla_resultados">
                    
    </div>
</body>

</html>