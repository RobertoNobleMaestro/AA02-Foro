<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stack Overflow</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <!-- Encabezado -->
    <header class="barra-navegacion">
        <div class="logo">Stack Overflow</div>
        <div class="barra-busqueda">
            <input type="text" placeholder="Buscar...">
            <button>Buscar</button>
        </div>
        <div class="acciones-usuario">
            <button>Iniciar sesión</button>
            <button>Crear cuenta</button>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="contenedor-principal">
        <!-- Barra lateral -->
        <aside class="barra-lateral">
            <ul>
                <li>Preguntas</li>
                <li>Historial de preguntas</li>
            </ul>
        </aside>

        <!-- Sección de preguntas -->
        <section class="seccion-preguntas">
            <form action="" method="post">
                <input type="submit" name="btn_crear_pregunta" value="Crear pregunta">
            </form>
            <div class="lista-preguntas">
                <?php if(isset($_POST['btn_crear_pregunta'])){ ?>
                    <h2>Formulario creación preguntas</h2>
                    <form action="" method="post">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo">
                        <br><br>
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion"></textarea>
                        <br><br>
                        <button name="enviar_pregunta">Enviar pregunta</button>
                        <button><a href="./index.php">Eliminar pregunta</a></button>
                    </form>
                <?php } ?>
            </div>
            <div class="lista-preguntas">
                <h2>Preguntas</h2>
                <h4>Número total de preguntas</h4>
                <div class="elemento-pregunta">
                    <h3>¿Cómo centrar un div en CSS?</h3>
                    <p>Preguntado por <strong>Usuario123</strong> - 2 respuestas</p>
                </div>
                <?php 
                
                    

                ?>
            </div>
        </section>

        <!-- Detalles de la pregunta -->
        <section class="detalles-pregunta">
            <h2>Título de la pregunta</h2>
            <p>Aquí aparecerán todos los detalles de la pregunta seleccionada.</p>
            <div class="respuestas">
                <div class="elemento-respuesta">
                    <h3>Respuestas</h3>
                    <p>Este es un ejemplo de una respuesta.</p>
                    <span>Respondido por <strong>UsuarioExperto</strong></span>
                </div>
            </div>
        </section>
    </main>
</body>
</html>