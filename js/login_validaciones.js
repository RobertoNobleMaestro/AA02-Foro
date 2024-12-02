document.addEventListener('DOMContentLoaded', function() {
    // Obtener parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    
    // Obtener los campos de correo y contraseña
    const correo = document.getElementById('correo');
    const contrasena = document.getElementById('contrasena');
    
    // Obtener los elementos donde se mostrarán los mensajes de error
    const correoError = document.getElementById('correoError');
    const contrasenaError = document.getElementById('contrasenaError');

    // Verificar si hay errores y mostrarlos
    if (error) {
        // Si hay un error de contraseña incorrecta
        if (error === 'contra_incorrecta') {
            correoError.textContent = ''; 
            contrasenaError.textContent = 'Contraseña incorrecta.';
            contrasena.classList.add('error'); // Añadir clase 'error' a la contraseña
            correo.classList.add('error'); // Añadir clase 'error' al correo
        } 
        // Si el usuario no se encuentra
        else if (error === 'usuario_no_encontrado') {
            correoError.textContent = 'Usuario no encontrado.';
            contrasenaError.textContent = '';
            correo.classList.add('error'); // Añadir clase 'error' al correo
            contrasena.classList.add('error'); // Añadir clase 'error' a la contraseña
        } 
        // Si los campos están vacíos
        else if (error === 'campos_vacios') {
            correoError.textContent = 'Por favor, complete este campo.';
            contrasenaError.textContent = 'Por favor, complete este campo.';
            correo.classList.add('error'); // Añadir clase 'error' al correo
            contrasena.classList.add('error'); // Añadir clase 'error' a la contraseña
        }
    }
});
