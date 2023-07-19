$(document).ready(function() {
    $('#username').on('blur', function() {
      $('#result-username').html('<img src="Librerias/img/GIF-FORMOSA_TU_CIUDAD.gif" width="45px" height="50px"/>').fadeOut(1000);

      var username = $(this).val();
      var dataString = 'username=' + username;

      $.ajax({
        type: "POST",
        url: "check_username_availablity.php",
        data: dataString,
        success: function(data) {
          $('#result-username').fadeIn(1000).html(data);
        }
      });
    });
  });

$('#id_agencia').select2().on('change', () => {
    var id_agencia = $('#id_agencia').val()
    $.ajax({
        url: '../AJAX/getDominios.php',
        type: "POST",
        data: {
            id_agencia: id_agencia
        }
    }).done((respuesta) => {
        var rsJSON = JSON.parse(respuesta)
        console.log(rsJSON.length)
        var options = '<option value="">Dominios</option>';

        $.each(rsJSON, function(k, v) {
            options += "<option value='" + v.dominio + "'>" + v.dominio + "</option>"

            $('#dominio').html('')
            $('#dominio').append(options)

        })

    })
    $('#dominio').empty();
})

$(obtenerChoferes());

function obtenerChoferes(dominio) {
    console.log(dominio);
    var id_agencia = $('#id_agencia').val()
    $.ajax({
            url: 'Paginas/Modulos/ListadoChoferes.php',
            type: 'POST',
            dataType: 'html',
            data: {
                dominio: dominio,
                id_agencia: id_agencia
            },
        })
        .done(function(resultado) {
            $("#tabla_resultados").html(resultado);
        })
}

$(document).ready(function() {
    $('#dominio').select2();

    $('#dominio').change(function() {
        var valorBusqueda = $(this).val();

        if (valorBusqueda != "") {
            obtenerChoferes(valorBusqueda);
        } else {
            obtenerChoferes();
        }
    });
});

$(document).on('click', '.subir', function() {

    var id_requisito = $(this).attr('data-descr');
    var requisito = $(this).attr('requisito');
    var id_adherente = $(this).attr('id_adherente');
    $('#exampleModalCenter input[name=Ir]').val(id_requisito);
    $('#exampleModalCenter input[name=Ti]').val(requisito);
    $('#exampleModalCenter input[name=id_adherente]').val(id_adherente);
    $('#exampleModalCenter').showModal(); 

});



$(document).on('click', '.eliminar', function() {
    var archivo = $(this).attr('archivo');
    var id = $(this).attr('id');
    var dominio = $(this).attr('dominio');
    var codUsu = $(this).attr('codUsu');
    var Usuario = $(this).attr('Usuario');
    var idAdherente = $(this).attr('idAdherente');
    var idAgencia = $(this).attr('data-descr');
    var dniChofer = $(this).attr('dniChofer');
    var creacion = $(this).attr('creacion');
    var agencia = $(this).attr('agencia');
    var nombreArchivo = $(this).attr('nombreArchivo');
    var direccion = $(this).attr('direccion');
    var Vd = $(this).attr('Vd');
    var Vh = $(this).attr('Vh');
    var id_adherente = $(this).attr('id_adherente');
    
    $('#ModalBajaArchivo input[name=Ach]').val(archivo);
    $('#ModalBajaArchivo input[name=Ie]').val(id);
    $('#ModalBajaArchivo input[name=Do]').val(dominio);
    $('#ModalBajaArchivo input[name=Cus]').val(codUsu);
    $('#ModalBajaArchivo input[name=Us]').val(Usuario);
    $('#ModalBajaArchivo input[name=Ia]').val(idAdherente);
    $('#ModalBajaArchivo input[name=Iag]').val(idAgencia);
    $('#ModalBajaArchivo input[name=Dc]').val(dniChofer);
    $('#ModalBajaArchivo input[name=Cre]').val(creacion);
    $('#ModalBajaArchivo input[name=Ag]').val(agencia);
    $('#ModalBajaArchivo input[name=Na]').val(nombreArchivo);
    $('#ModalBajaArchivo input[name=Ul]').val(direccion);
    $('#ModalBajaArchivo input[name=Vd]').val(Vd);
    $('#ModalBajaArchivo input[name=Vh]').val(Vh);
    $('#ModalBajaArchivo input[name=id_adherente]').val(id_adherente);
    
    $('#ModalBajaArchivo').showModal(); 
});

$(document).on('click', '.subir', function() {

    var id_requisito = $(this).attr('data-descr');
    var requisito = $(this).attr('requisito');
    $('#exampleModalCenter input[name=Ir]').val(id_requisito);
    $('#exampleModalCenter input[name=Ti]').val(requisito);
    $('#exampleModalCenter').showModal(); 

});

$(document).on('click', '.eliminar', function() {
    var archivo = $(this).attr('archivo');
    var id = $(this).attr('id');
    var dominio = $(this).attr('dominio');
    var codUsu = $(this).attr('codUsu');
    var Usuario = $(this).attr('Usuario');
    var idAdherente = $(this).attr('idAdherente');
    var idAgencia = $(this).attr('data-descr');
    var dniChofer = $(this).attr('dniChofer');
    var creacion = $(this).attr('creacion');
    var agencia = $(this).attr('agencia');
    var nombreArchivo = $(this).attr('nombreArchivo');
    var direccion = $(this).attr('direccion');
    var Vd = $(this).attr('Vd');
    var Vh = $(this).attr('Vh');
    
    $('#ModalBajaArchivo input[name=Ach]').val(archivo);
    $('#ModalBajaArchivo input[name=Ie]').val(id);
    $('#ModalBajaArchivo input[name=Do]').val(dominio);
    $('#ModalBajaArchivo input[name=Cus]').val(codUsu);
    $('#ModalBajaArchivo input[name=Us]').val(Usuario);
    $('#ModalBajaArchivo input[name=Ia]').val(idAdherente);
    $('#ModalBajaArchivo input[name=Iag]').val(idAgencia);
    $('#ModalBajaArchivo input[name=Dc]').val(dniChofer);
    $('#ModalBajaArchivo input[name=Cre]').val(creacion);
    $('#ModalBajaArchivo input[name=Ag]').val(agencia);
    $('#ModalBajaArchivo input[name=Na]').val(nombreArchivo);
    $('#ModalBajaArchivo input[name=Ul]').val(direccion);
    $('#ModalBajaArchivo input[name=Vd]').val(Vd);
    $('#ModalBajaArchivo input[name=Vh]').val(Vh);
    
    $('#ModalBajaArchivo').showModal(); 
});

// PERIODOS FILTRADOS
$(document).on('click', '.subir', function() {

    var id_requisito = $(this).attr('data-descr');
    var requisito = $(this).attr('requisito');
    $('#exampleModalCenter input[name=Ir]').val(id_requisito);
    $('#exampleModalCenter input[name=Ti]').val(requisito);


    // aquí es cuando tienes que mirar la documentación de tu framework
    $('#exampleModalCenter').showModal(); // o similar

});

$(document).on('click', '.eliminar', function() {
    var archivo = $(this).attr('archivo');
    var id = $(this).attr('id');
    var dominio = $(this).attr('dominio');
    var codUsu = $(this).attr('codUsu');
    var Usuario = $(this).attr('Usuario');
    var idAdherente = $(this).attr('idAdherente');
    var idAgencia = $(this).attr('data-descr');
    var dniChofer = $(this).attr('dniChofer');
    var creacion = $(this).attr('creacion');
    var agencia = $(this).attr('agencia');
    var nombreArchivo = $(this).attr('nombreArchivo');
    var direccion = $(this).attr('direccion');
    var Vd = $(this).attr('Vd');
    var Vh = $(this).attr('Vh');
    var IdTramite = $(this).attr('iT');
    var IdRubro = $(this).attr('iR');
    var id_adherente = $(this).attr('id_adherente');

    
    $('#ModalBajaFiltro input[name=Ach]').val(archivo);
    $('#ModalBajaFiltro input[name=Ie]').val(id);
    $('#ModalBajaFiltro input[name=Do]').val(dominio);
    $('#ModalBajaFiltro input[name=Cus]').val(codUsu);
    $('#ModalBajaFiltro input[name=Us]').val(Usuario);
    $('#ModalBajaFiltro input[name=Ia]').val(idAdherente);
    $('#ModalBajaFiltro input[name=Iag]').val(idAgencia);
    $('#ModalBajaFiltro input[name=Dc]').val(dniChofer);
    $('#ModalBajaFiltro input[name=Cre]').val(creacion);
    $('#ModalBajaFiltro input[name=Ag]').val(agencia);
    $('#ModalBajaFiltro input[name=Na]').val(nombreArchivo);
    $('#ModalBajaFiltro input[name=Ul]').val(direccion);
    $('#ModalBajaFiltro input[name=Vd]').val(Vd);
    $('#ModalBajaFiltro input[name=Vh]').val(Vh);
    $('#ModalBajaFiltro input[name=Itr]').val(IdTramite);
    $('#ModalBajaFiltro input[name=Iru]').val(IdRubro);
    $('#ModalBajaFiltro input[name=id_adherente]').val(id_adherente);

    
    $('#ModalBajaFiltro').showModal(); 
});

//PERIODO
$(document).on('click', '.subir', function() {

    var id_requisito = $(this).attr('data-descr');
    var requisito = $(this).attr('requisito');
    $('#exampleModalCenter input[name=Ir]').val(id_requisito);
    $('#exampleModalCenter input[name=Ti]').val(requisito);


    // aquí es cuando tienes que mirar la documentación de tu framework
    $('#exampleModalCenter').showModal(); // o similar

});

jQuery('.eliminar').on('click', function() {
    var archivo = $(this).attr('archivo');
    var id = $(this).attr('id');
    var dominio = $(this).attr('dominio');
    var codUsu = $(this).attr('codUsu');
    var Usuario = $(this).attr('Usuario');
    var idAdherente = $(this).attr('idAdherente');
    var idAgencia = $(this).attr('data-descr');
    var dniChofer = $(this).attr('dniChofer');
    var creacion = $(this).attr('creacion');
    var agencia = $(this).attr('agencia');
    var nombreArchivo = $(this).attr('nombreArchivo');
    var direccion = $(this).attr('url');
    var Vd = $(this).attr('Fdesde');
    var Vh = $(this).attr('Fhasta');
    var id_tramite = $(this).attr('iT');
    var id_rubro = $(this).attr('iR');
    var id_adherente = $(this).attr('id_adherente');

    $('#ModalBajaPeriodo input[name=Ach]').val(archivo);
    $('#ModalBajaPeriodo input[name=Ie]').val(id);
    $('#ModalBajaPeriodo input[name=Do]').val(dominio);
    $('#ModalBajaPeriodo input[name=Cus]').val(codUsu);
    $('#ModalBajaPeriodo input[name=Us]').val(Usuario);
    $('#ModalBajaPeriodo input[name=Ia]').val(idAdherente);
    $('#ModalBajaPeriodo input[name=Iag]').val(idAgencia);
    $('#ModalBajaPeriodo input[name=Dc]').val(dniChofer);
    $('#ModalBajaPeriodo input[name=Cre]').val(creacion);
    $('#ModalBajaPeriodo input[name=Ag]').val(agencia);
    $('#ModalBajaPeriodo input[name=Na]').val(nombreArchivo);
    $('#ModalBajaPeriodo input[name=Ul]').val(direccion);
    $('#ModalBajaPeriodo input[name=Vd]').val(Vd);
    $('#ModalBajaPeriodo input[name=Vh]').val(Vh);
    $('#ModalBajaPeriodo input[name=id_adherente]').val(id_adherente);
    
    $('#ModalBajaPeriodo').showModal(); 
});


$(document).on('click', '.Nperiodo', function() {

    // aquí es cuando tienes que mirar la documentación de tu framework
    $('#ModalNperiodo').showModal(); // o similar

});

$(document).on('click', '.VerP', function() {

    // aquí es cuando tienes que mirar la documentación de tu framework
    $('#ModalVerPeriodosRegistrados').showModal(); // o similar

});


$(filtroDominio());
function filtroDominio(dominio){
  
  $.ajax({
    url : '../AJAX/FiltroDominio.php',
    type : 'POST',
    dataType : 'html',
    data : { dominio: dominio }
  })
  .done(function(resultado){
    $("#tabla_resultados").html(resultado);
  })
}

$(document).on('keyup', '#busquedaDominio', function(){
  var valorBusqueda=$(this).val();

  if (valorBusqueda!=""){
    filtroDominio(valorBusqueda);
  }
});

jQuery('.eliminarDocDig').on('click', function() {
  
    var archivo = $(this).attr('archivo');
    var id = $(this).attr('id');
    var dominio = $(this).attr('dominio');
    var codUsu = $(this).attr('codUsu');
    var Usuario = $(this).attr('Usuario');
    var idAdherente = $(this).attr('idAdherente');
    var idAgencia = $(this).attr('data-descr');
    var dniChofer = $(this).attr('dniChofer');
    var creacion = $(this).attr('creacion');
    var agencia = $(this).attr('agencia');
    var nombreArchivo = $(this).attr('nombreArchivo');
    var direccion = $(this).attr('url');
    var Vd = $(this).attr('Vd');
    var Vh = $(this).attr('Vh');
    var id_rubro = $(this).attr('iR');
    var id_tramite = $(this).attr('iT');
    
    $('#ModalBajaArchivoHistorial input[name=Ach]').val(archivo);
    $('#ModalBajaArchivoHistorial input[name=Ie]').val(id);
    $('#ModalBajaArchivoHistorial input[name=Do]').val(dominio);
    $('#ModalBajaArchivoHistorial input[name=Cus]').val(codUsu);
    $('#ModalBajaArchivoHistorial input[name=Us]').val(Usuario);
    $('#ModalBajaArchivoHistorial input[name=Ia]').val(idAdherente);
    $('#ModalBajaArchivoHistorial input[name=Iag]').val(idAgencia);
    $('#ModalBajaArchivoHistorial input[name=Dc]').val(dniChofer);
    $('#ModalBajaArchivoHistorial input[name=Cre]').val(creacion);
    $('#ModalBajaArchivoHistorial input[name=Ag]').val(agencia);
    $('#ModalBajaArchivoHistorial input[name=Na]').val(nombreArchivo);
    $('#ModalBajaArchivoHistorial input[name=Ul]').val(direccion);
    $('#ModalBajaArchivoHistorial input[name=Vd]').val(Vd);
    $('#ModalBajaArchivoHistorial input[name=Vh]').val(Vh);
    $('#ModalBajaArchivoHistorial input[name=Itr]').val(id_tramite);
    $('#ModalBajaArchivoHistorial input[name=Iru]').val(id_rubro);
    
    $('#ModalBajaArchivoHistorial').showModal(); 
});

$(document).on('click', '.subirDocHisotrial', function() {

    var id_requisito = $(this).attr('id_requisito');
    var requisito = $(this).attr('requisito');
    $('#ModalAltaDocumentoDigitalizado input[name=Ir]').val(id_requisito);
    $('#ModalAltaDocumentoDigitalizado input[name=Ti]').val(requisito);
    

    // aquí es cuando tienes que mirar la documentación de tu framework
    $('#ModalAltaDocumentoDigitalizado').showModal(); // o similar

});