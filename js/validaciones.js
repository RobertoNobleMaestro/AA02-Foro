// Función para mostrar errores y éxitos
function mostrarResultado(input, esValido, mensajeError, mensaje) {
    let mensajeErrorElemento = document.getElementById(mensajeError);
    if (esValido) {
        input.classList.remove('error');
        input.classList.add('success');
        mensajeErrorElemento.textContent = ''; // Borra el mensaje de error
    } else {
        input.classList.remove('success');
        input.classList.add('error');
        mensajeErrorElemento.textContent = mensaje; // Muestra el mensaje de error
    }
}

// Validación de nombre de usuario
function validar_nombre_usuario() {
    let regex_nombre_usuario = /^[a-zA-Z0-9]+$/;
    let esValido = nombre_usuario.value.trim() !== '' && regex_nombre_usuario.test(nombre_usuario.value);
    let mensaje = esValido
        ? ''
        : 'El nombre de usuario solo puede contener letras y números, y no debe estar vacío.';
    mostrarResultado(nombre_usuario, esValido, 'error-nombre-usuario', mensaje);
    return esValido;
}

// Validación de nombre real
function validar_nombre_real() {
    let regex_nombre_real = /^[a-zA-Z\s]+$/;
    let esValido = nombre_real.value.trim() !== '' && regex_nombre_real.test(nombre_real.value);
    let mensaje = esValido
        ? ''
        : 'El nombre real solo puede contener letras y espacios, y no debe estar vacío.';
    mostrarResultado(nombre_real, esValido, 'error-nombre-real', mensaje);
    return esValido;
}

// Validación de correo electrónico
function validar_correo() {
    let regex_correo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let esValido = correo.value.trim() !== '' && regex_correo.test(correo.value);
    let mensaje = esValido
        ? ''
        : 'Debe ingresar un correo electrónico válido.';
    mostrarResultado(correo, esValido, 'error-correo', mensaje);
    return esValido;
}

// Validación de contraseña
function validar_contrasena() {
    let regex_contrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    let esValido = contrasena.value.trim() !== '' && regex_contrasena.test(contrasena.value);
    let mensaje = esValido
        ? ''
        : 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.';
    mostrarResultado(contrasena, esValido, 'error-contrasena', mensaje);
    return esValido;
}

// Validar todos los campos
function validarFormulario(event) {
    let esNombreUsuarioValido = validar_nombre_usuario();
    let esNombreRealValido = validar_nombre_real();
    let esCorreoValido = validar_correo();
    let esContrasenaValida = validar_contrasena();

    if (!esNombreUsuarioValido || !esNombreRealValido || !esCorreoValido || !esContrasenaValida) {
        event.preventDefault(); // Evita el envío del formulario si hay errores
    }
}

// Vincular las validaciones a eventos
nombre_usuario.addEventListener('blur', validar_nombre_usuario);
nombre_real.addEventListener('blur', validar_nombre_real);
correo.addEventListener('blur', validar_correo);
contrasena.addEventListener('blur', validar_contrasena);

// Validación al enviar el formulario
formulario.addEventListener('submit', validarFormulario);