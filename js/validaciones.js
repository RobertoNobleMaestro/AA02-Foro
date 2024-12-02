// Función para mostrar errores y éxitos
function mostrarResultado(input, esValido, mensajeError, mensaje) {
    const mensajeErrorElemento = document.getElementById(mensajeError);
    if (esValido) {
        input.classList.remove('error');
        input.classList.add('success');
        mensajeErrorElemento.textContent = '';
    } else {
        input.classList.remove('success');
        input.classList.add('error');
        mensajeErrorElemento.textContent = mensaje;
    }
}

// Validaciones individuales
function validarCampoVacio(input, mensajeError, mensaje) {
    const esValido = input.value.trim() !== '';
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

function validarNombreUsuario(input, mensajeError, mensaje) {
    const regexNombreUsuario = /^[a-zA-Z0-9]+$/;
    const esValido = regexNombreUsuario.test(input.value.trim());
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

function validarNombreReal(input, mensajeError, mensaje) {
    const regexNombreReal = /^[a-zA-Z\s]+$/;
    const esValido = regexNombreReal.test(input.value.trim());
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

function validarCorreo(input, mensajeError, mensaje) {
    const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const esValido = regexCorreo.test(input.value.trim());
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

function validarContrasena(input, mensajeError, mensaje) {
    const regexContrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    const esValido = regexContrasena.test(input.value.trim());
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

function validarRepetirContrasena(input, contrasenaInput, mensajeError, mensaje) {
    const esValido = input.value === contrasenaInput.value;
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

// Validación general
function validarFormulario(event) {
    // Referencias a los campos del formulario
    const nombreUsuario = document.getElementById('nombre_usuario');
    const contrasena = document.getElementById('contrasena');
    const repetirContrasena = document.getElementById('repetir');
    const nombreReal = document.getElementById('nombre_real');
    const correo = document.getElementById('email');

    let esValido = true;

    // Validaciones
    if (!validarCampoVacio(nombreUsuario, 'error-nombre-usuario', 'Ningún campo puede estar vacío.') ||
        !validarNombreUsuario(nombreUsuario, 'error-nombre-usuario', 'El nombre de usuario solo puede contener letras y números.')) {
        esValido = false;
    }

    if (!validarCampoVacio(nombreReal, 'error-nombre-real', 'Ningún campo puede estar vacío.') ||
        !validarNombreReal(nombreReal, 'error-nombre-real', 'El nombre real solo puede contener letras y espacios.')) {
        esValido = false;
    }

    if (!validarCampoVacio(correo, 'error-correo', 'Ningún campo puede estar vacío.') ||
        !validarCorreo(correo, 'error-correo', 'Debe ingresar un correo electrónico válido.')) {
        esValido = false;
    }

    if (!validarCampoVacio(contrasena, 'error-contrasena', 'Ningún campo puede estar vacío.') ||
        !validarContrasena(contrasena, 'error-contrasena', 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.')) {
        esValido = false;
    }

    if (!validarRepetirContrasena(repetirContrasena, contrasena, 'error-repetir', 'Las contraseñas no coinciden.')) {
        esValido = false;
    }

    if (!esValido) {
        event.preventDefault();
    }
}

// Vincular las validaciones a eventos
document.addEventListener('DOMContentLoaded', () => {
    const nombreUsuario = document.getElementById('nombre_usuario');
    const contrasena = document.getElementById('contrasena');
    const repetirContrasena = document.getElementById('repetir');
    const nombreReal = document.getElementById('nombre_real');
    const correo = document.getElementById('email');
    const formulario = document.getElementById('formulario');

    nombreUsuario.addEventListener('blur', () => {
        validarCampoVacio(nombreUsuario, 'error-nombre-usuario', 'Ningún campo puede estar vacío.');
        validarNombreUsuario(nombreUsuario, 'error-nombre-usuario', 'El nombre de usuario solo puede contener letras y números.');
    });

    nombreReal.addEventListener('blur', () => {
        validarCampoVacio(nombreReal, 'error-nombre-real', 'Ningún campo puede estar vacío.');
        validarNombreReal(nombreReal, 'error-nombre-real', 'El nombre real solo puede contener letras y espacios.');
    });

    correo.addEventListener('blur', () => {
        validarCampoVacio(correo, 'error-correo', 'Ningún campo puede estar vacío.');
        validarCorreo(correo, 'error-correo', 'Debe ingresar un correo electrónico válido.');
    });

    contrasena.addEventListener('blur', () => {
        validarCampoVacio(contrasena, 'error-contrasena', 'Ningún campo puede estar vacío.');
        validarContrasena(contrasena, 'error-contrasena', 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.');
    });

    repetirContrasena.addEventListener('blur', () => {
        validarRepetirContrasena(repetirContrasena, contrasena, 'error-repetir', 'Las contraseñas no coinciden.');
    });

    formulario.addEventListener('submit', validarFormulario);
});
function validarFormulario(event) {
    var formulario = document.getElementById('formulario-respuesta');
    var campoRespuesta = document.getElementById('respuesta');
    var errorMensaje = document.getElementById('error');
    
    // Verifica si el campo está vacío
    if (campoRespuesta.value.trim() === "") {
        // Muestra el mensaje de error
        errorMensaje.style.display = 'block';
        // Cambia el borde a rojo
        campoRespuesta.classList.add('error');
        // Impide el envío del formulario
        return false;
    } else {
        // Oculta el mensaje de error y quita el borde rojo si el campo no está vacío
        errorMensaje.style.display = 'none';
        campoRespuesta.classList.remove('error');
        return true;
    }
}