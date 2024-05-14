const formulario = document.getElementById('form');
const inputs = document.querySelectorAll('#form input');

const expresiones = {
	password: /^.{4,12}$/, // 4 a 12 digitos.
}

const campos = {
	password: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
        case "pass":
			validarCampo(expresiones.password, e.target, 'pass');
			validarPassword2();
		break;
		case "password":
			validarCampo(expresiones.password, e.target, 'password');
			validarPassword2();
		break;
		case "password2":
			validarPassword2();
		break;
    }
}

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos[campo] = true;
	} else {
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos[campo] = false;
	}
}

const validarPassword2 = () => {
	const inputPassword1 = document.getElementById('password');
	const inputPassword2 = document.getElementById('password2');

	if(inputPassword1.value !== inputPassword2.value){
		document.getElementById(`grupo__password2`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__password2`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__password2 .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos['password'] = false;
	} else {
		document.getElementById(`grupo__password2`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__password2`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__password2 .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos['password'] = true;
	}
}

inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});

formulario.addEventListener('submit', (e) => {
	e.preventDefault();
});

function cambiarContrasena(){
    var contraseña_actual = $("#pass").val();
    var nueva_contraseña = $("#password").val();
    var ob = {contraseña_actual:contraseña_actual, nueva_contraseña:nueva_contraseña}

    // alert(usuario);

    if(campos.password){
		

    $.ajax({
        type: "POST",
        url:"../comedor/procesar_recuperacion.php",
        data: ob,

        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            if(response == 0 || response == 2){
                $("#resultado").html(swal({
                title: 'Contraseña',
                text: 'Error al verificar la contraseña',
                type: 'error',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#03A9F4',
                confirmButtonText: ' Intentar de nuevo!',
                }).then(function () {
                    window.location.href="../comedor/cambiar_contraseña.php";
                }) 
                );
            }
            else{
                if(response == 1){
                    $("#resultado").html(swal({
                        title: 'Contraseña',
                        text: 'Contraseña actualizada exitosamente.',
                        type: 'success',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: '#03A9F4',
                        confirmButtonText: '<i class="zmdi zmdi-thumb-up"> Ok!'
                        }).then(function () {
                            window.location.href="../comedor/login.php";
                        }) 
                    );
                }
            }
        }
     });
    }else{
        $("#resultado").html("Por favor, ingrese los datos correctamente");
    }
}