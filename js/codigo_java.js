const form = document.querySelector("form");
const span_cb = document.getElementById("cb_validacion");

form.addEventListener('submit', e => {
    const cb = document.querySelectorAll("input[name='id_menus[]']:checked");
    if(cb.length == 0){
        span_cb.innerHTML = `Debe seleccionar al menos un (1) menú`;
        e.preventDefault();
    }
})


function a(){
	var ids = document.querySelectorAll("input[name='id_menus[]']:checked");

    if(ids.length == 0){
        false;
        exit;
    }
    else{
        var a=[];
	for (var i=0; i<ids.length; i++) {
		a[i] = ids[i].value;
	}
    // alert(a);
	$.ajax({
		method: "POST",
		url: "procesar_reserva.php",
		data: {  ids: a },

        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            $("#resultado").html(swal({
                title: 'Reserva',
                text: response,
                type: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#03A9F4',
                confirmButtonText: '<i class="zmdi zmdi-thumb-up"> Ok!',
          }).then(function () {
              window.location.href="../comedor/realizar_reserva.php";
          }) );
        }
	});
    }
}

function eliminarMenu (id){
    var repuesta = confirm("¿Esta séguro que quiere eliminar?");
    if(repuesta == true){
        var ob = {id:id}

    $.ajax({
        type: "POST",
        url:"../comedor/eliminar_menu.php",
        data: ob,

        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            $("#resultado").html(swal({
                title: 'Menú',
                text: response,
                type: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#03A9F4',
                confirmButtonText: '<i class="zmdi zmdi-thumb-up"> Ok!',
          }).then(function () {
              window.location.href="../comedor/ver_menu.php";
          }) );
        }
     });
    }
}

function guardarMenu(){
    var dia_semana = $("#dia_semana").val();
    var tipo = $("#tipo").val();
    var menu = $("#menu").val();
    var postre = $("#postre").val();

    // alert(dia_semana+"-"+tipo);
    var ob = {dia_semana:dia_semana, tipo:tipo, menu:menu, postre:postre};

    $.ajax({
        type: "POST",
        url:"../comedor/guardar_menu_semanal.php",
        data: ob,

        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            $("#resultado").html(swal({
                title: 'Menú',
                text: response,
                type: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#03A9F4',
                confirmButtonText: '<i class="zmdi zmdi-thumb-up"> Ok!',
          }).then(function () {
              window.location.href="../comedor/menu_semanal.php";
          }) );
        }
     });
}

function editarMenu (){
    // alert(id+"_"+menu+"_"+postre);

    var repuesta = confirm("¿Desea guardar los cambios?");
    if(repuesta == true){
        var id = $("#id").val();
        var menu = $("#menu").val();
        var postre = $("#postre").val();
        var ob = {id:id, menu:menu, postre:postre}

    $.ajax({
        type: "POST",
        url:"../comedor/guardar_modificacion_menu.php",
        data: ob,

        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            $("#resultado").html(swal({
                title: 'Menú',
                text: response,
                type: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#03A9F4',
                confirmButtonText: ' Ok!'
          }).then(function () {
                window.location.href="../comedor/ver_menu.php";
                
          }) );
        }
     });
    }
}


function editarAlumno (){
    // alert(id+"_"+menu+"_"+postre);

    var repuesta = confirm("¿Desea guardar los cambios?");
    if(repuesta == true){
        var id = $("#id").val();
        var nombre = $("#nombre").val();
        var apellido = $("#apellido").val();
        var area = $("#area").val();
        var estamento = $("#estamento").val();
        var correo = $("#correo").val();
        var ob = {id:id, nombre:nombre, apellido:apellido, area:area, estamento:estamento, correo:correo}

    $.ajax({
        type: "POST",
        url:"../comedor/guardar_modificacion_alumno.php",
        data: ob,

        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            $("#resultado").html(swal({
                title: 'Usuario',
                text: response,
                type: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#03A9F4',
                confirmButtonText: '<i class="zmdi zmdi-thumb-up"> Ok!',
          }).then(function () {
              window.location.href="../comedor/ver_alumnos.php";
          }) );
        }
     });
    }
}


function eliminarAlumno(id){
    var repuesta = confirm("¿Esta séguro que desea Eliminar?");
    if(repuesta == true){
        var ob = {id:id}

        // alert(id);

    $.ajax({
        type: "POST",
        url:"../comedor/eliminar_alumno.php",
        data: ob,

        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            $("#resultado").html(swal({
                title: 'Usuario',
                text: response,
                type: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#03A9F4',
                confirmButtonText: '<i class="zmdi zmdi-thumb-up"> Ok!',
          }).then(function () {
              window.location.href="../comedor/ver_alumnos.php";
          }) );
        }
     });
    }
}

function recuperarContrasena(){

        var dni = $("#dni").val();
        var ob = {dni:dni}

    $.ajax({
        type: "POST",
        url:"../comedor/procesar_recuperacion.php",
        data: ob,
        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            $("#resultado").html(swal({
                title: 'Contraseña',
                text: response,
                type: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: '#03A9F4',
                cancelButtonColor: '#00FF00',
                confirmButtonText: ' Volver atras!',
                cancelButtonText: ' Ingresar otro!'
          }).then(function () {
              window.location.href="../comedor/login.php";
          }) );
        }
     });
}

function cancelarMenu (id){
    var repuesta = confirm("¿Esta séguro que quiere cancelar el menú?");
    if(repuesta == true){
        var ob = {id:id}

    $.ajax({
        type: "POST",
        url:"../comedor/eliminar_reserva.php",
        data: ob,

        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            $("#resultado").html(swal({
                title: 'Menú',
                text: response,
                type: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#03A9F4',
                confirmButtonText: '<i class="zmdi zmdi-thumb-up"> Ok!',
          }).then(function () {
              window.location.href="../comedor/panel_reservas_alumno.php";
          }) );
        }
     });
    }
}

function guardarReserva(){
    var ids = document.querySelectorAll("input[name='id_reserva[]']:checked");
    var a=[];

	for (var i=0; i<ids.length; i++) {
		a[i] = ids[i].value;
	}
    // alert(a);
	$.ajax({
		method: "POST",
		url: "asistencia.php",
		data: {  ids: a },

        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            $("#resultado").html(swal({
                title: 'Reserva',
                text: response,
                type: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#03A9F4',
                confirmButtonText: '<i class="zmdi zmdi-thumb-up"> Ok!',
          }).then(function () {
              window.location.href="../comedor/ver_reservas.php";
          }) );
        }
	});
}
