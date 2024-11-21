// Función para mostrar errores y éxitos
function mostrarResultado(input, esValido, mensajeError, mensaje) {
    let mensajeErrorElemento = document.getElementById(mensajeError);
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
    let esValido = input.value.trim() !== '';
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

function validarNombreUsuario(input, mensajeError, mensaje) {
    let regex_nombre_usuario = /^[a-zA-Z0-9]+$/;
    let esValido = input.value.trim() !== '' && regex_nombre_usuario.test(input.value);
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

function validarNombreReal(input, mensajeError, mensaje) {
    let regex_nombre_real = /^[a-zA-Z\s]+$/;
    let esValido = input.value.trim() !== '' && regex_nombre_real.test(input.value);
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

function validarCorreo(input, mensajeError, mensaje) {
    let regex_correo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let esValido = input.value.trim() !== '' && regex_correo.test(input.value);
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

function validarContrasena(input, mensajeError, mensaje) {
    let regex_contrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    let esValido = input.value.trim() !== '' && regex_contrasena.test(input.value);
    mostrarResultado(input, esValido, mensajeError, mensaje);
    return esValido;
}

// Validación general
function validarFormulario(event) {
    let campos = [nombre_usuario, nombre_real, correo, contrasena];
    let esValido = true;

    campos.forEach(campo => {
        if (!validarCampoVacio(campo, 'error-campo-vacio', 'Ningún campo puede estar vacío.')) {
            esValido = false;
        }
    });

    if (!validarNombreUsuario(nombre_usuario, 'error-nombre-usuario', 'El nombre de usuario solo puede contener letras y números, y no debe estar vacío.')) {
        esValido = false;
    }

    if (!validarNombreReal(nombre_real, 'error-nombre-real', 'El nombre real solo puede contener letras y espacios, y no debe estar vacío.')) {
        esValido = false;
    }

    if (!validarCorreo(correo, 'error-correo', 'Debe ingresar un correo electrónico válido.')) {
        esValido = false;
    }

    if (!validarContrasena(contrasena, 'error-contrasena', 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.')) {
        esValido = false;
    }

    if (!esValido) {
        event.preventDefault(); 
    }
}

// Vincular las validaciones a eventos
nombre_usuario.addEventListener('blur', () => {
    validarCampoVacio(nombre_usuario, 'error-campo-vacio', 'Ningún campo puede estar vacío.');
    validarNombreUsuario(nombre_usuario, 'error-nombre-usuario', 'El nombre de usuario solo puede contener letras y números, y no debe estar vacío.');
});

nombre_real.addEventListener('blur', () => {
    validarCampoVacio(nombre_real, 'error-campo-vacio', 'Ningún campo puede estar vacío.');
    validarNombreReal(nombre_real, 'error-nombre-real', 'El nombre real solo puede contener letras y espacios, y no debe estar vacío.');
});

correo.addEventListener('blur', () => {
    validarCampoVacio(correo, 'error-campo-vacio', 'Ningún campo puede estar vacío.');
    validarCorreo(correo, 'error-correo', 'Debe ingresar un correo electrónico válido.');
});

contrasena.addEventListener('blur', () => {
    validarCampoVacio(contrasena, 'error-campo-vacio', 'Ningún campo puede estar vacío.');
    validarContrasena(contrasena, 'error-contrasena', 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.');
});

// Validación al enviar el formulario
formulario.addEventListener('submit', validarFormulario);