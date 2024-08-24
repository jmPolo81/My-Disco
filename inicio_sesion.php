<!DOCTYPE html>
<html lang="es">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="David Punzano Rodríguez">
    <meta name="description" content="Proyecto educativo de desarrollo web sin ánimo de lucro.">
    <meta name="keywords" content="música, grupos, álbumes, canciones, grupo, álbum, canción">
    <title>Iniciar sesión</title>
    <!-- enlaces -->
    <link rel="stylesheet" href="css/estilos.css">
    <script src="js/script.js" defer></script>
</head>

<body>
    <!-- Contendrá una banda negra no muy ancha con un logo a la izquierda y el inicio de sesión a la derecha, minimalista -->
    <header>
        <a href="index.html"><img src="media/img/logo.png" alt="logo de Discoteca"></a>

    </header>

        <section id="contenedor-sesion">
            <section id='ventana-sesion'>
                <div id="contenido-actual">
                     <h1>Iniciar sesión</h1>
                </div>
               
                <form action="validacion.php" method="post" id="formulario-sesion" name="formulario" enctype="application/x-www-form-urlencoded">
                    <label for="usuario">Usuario</label>
                    <input type="email" name="usuario" id="usuario" placeholder="Introduzca un correo electrónico" required>
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Introduzca una contraseña" required>

                    <input type="submit" name="enviar" value="Iniciar sesión">
                    <input type="reset" value="Restablecer">
                </form>

            </section>
        </section>

</body>

</html>