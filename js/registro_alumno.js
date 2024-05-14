const formulario = document.getElementById('form');
const inputs = document.querySelectorAll('#form input');

const expresiones = {
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.;
    apellido: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.;
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    dni: /^\d{8,8}$/ // 8 numeros.
}

const campos = {
	apellido: false,
	nombre: false,
	correo: false,
	dni: false
}


const validarFormulario = (e) => {
	switch (e.target.name) {
		case "nombre":
			validarCampo(expresiones.nombre, e.target, 'nombre');
		break;
		case "apellido":
			validarCampo(expresiones.apellido, e.target, 'apellido');
		break;
		case "correo":
			validarCampo(expresiones.correo, e.target, 'correo');
		break;
		case "dni":
			validarCampo(expresiones.dni, e.target, 'dni');
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

inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});

formulario.addEventListener('submit', (e) => {
	e.preventDefault();
});

function guardarAlumno(){
    var nombre = $("#nombre").val();
    var apellido = $("#apellido").val();
    var dni = $("#dni").val();
    var correo = $("#correo").val();
    var estamento = $("#estamento").val();
    var area = $("#area").val();
    var ob = {nombre:nombre, apellido:apellido, dni:dni, correo:correo, estamento:estamento, area:area}

    // alert(area);

    if(campos.nombre && campos.apellido && campos.correo && campos.dni ){

    $.ajax({
        type: "POST",
        url:"../comedor/guardar_alumno.php",
        data: ob,
        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function(response)
        { 
            $("#resultado").html(swal({
                title: 'Registro',
                text: response,
                type: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#03A9F4',
                confirmButtonText: ' Ok!'
          }).then(function () {
                window.location.href="../comedor/alta_alumnos.php";
                
          }) );
        }
     });
    }else{
        $("#resultado").html("Por favor, ingrese los datos correctamente");
    }
}