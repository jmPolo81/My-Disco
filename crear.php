<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="David Punzano Rodríguez">
    <meta name="description" content="Proyecto educativo de desarrollo web sin ánimo de lucro.">
    <meta name="keywords" content="música, grupos, álbumes, canciones, grupo, álbum, canción">
    <title>Crear nuevo</title>
    <!-- enlaces -->
    <link rel="stylesheet" href="css/estilos.css">
    <script src="js/script.js" defer></script>
</head>
<body>

    <!-- Contendrá una banda negra no muy ancha con un logo a la izquierda y el inicio de sesión a la derecha, minimalista -->
    <header>
        <a href="index.html"><img src="media/img/logo.png" alt="logo de Discoteca"></a>
        <button id="inicio-sesion">Iniciar sesión</button>
    </header>

    <div id="contenido-principal">
    



    <?php

        require('variable_sesion.php');
        echo "<aside>
            <!-- Sección para los botones -->
            
            <section id='seccion-btn'>

                <a href='crear.php?grupo'>
                    <div class='btn-lateral' onclick='history.back()'>
                        <img src='media/img/icon/back.png' alt='Crear nuevo'>
                        <p>Volver</p>
                    </div>
                </a>
            </section>
        </aside>

        <main>";

        

        /***********************************************************************************************************************************/
        /****//***************************//**//**//**//** ZONA DE MANEJO DE BASE DE DATOS **//**//**//**//*********************************/
        /***********************************************************************************************************************************/

        require('conexion_discoteca.php');
        $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);

        if($conexion) {
            mysqli_query($conexion, "SET NAMES 'UTF8'");

            if(mysqli_select_db($conexion, $bbdd)) {

                if(mysqli_errno($conexion)!=0) {
                    echo "<p>Nº Error: ".mysqli_errno($conexion)."</p>";
					echo "<p>Descripción: ".mysqli_error($conexion)."</p>";
                } else {

                    if(isset($_GET['grupo'])){
                    /* Si venimos desde la página "Grupos" ********************************************************************************************/

                        echo "<section id='contenido-actual'>
                        <h1>Crear un grupo</h1>
                        </section>";

                        echo "<form action='crear.php' method='get' name='formulario' class='formulario-creacion'>
                            <label for='cod_grupo'>Código de grupo</label>
                            <input type='number' name='cod_grupo' id='cod_grupo' autofocus required>
                            <label for='nombre'>Nombre</label>
                            <input type='text' name='nombre' id='nombre' maxlength='50' required>
                            <label for='nacionalidad'>Nacionalidad</label>
                            <input type='text' name='nacionalidad' id='nacionalidad' maxlength='35' required>
                            <label for='biografia'>Biografia</label>
                            <textarea name='biografia' id='biografia' cols='30' rows='10' maxlength='500' placeholder='Máximo de 500 caracteres' required></textarea>
                            <label for='foto'>Foto</label>
                            <input type='text' name='foto' id='foto' placeholder='.jpg, .png' required>
                        
                            <input type='submit' value='Crear grupo' name='crear_grupo' class='btn-form'>
                            <input type='reset' value='Limpiar' class='btn-form'>
                        </form>";

                    } else if (isset($_GET['album'])) {
                    /* Si venimos desde la página "albumes" ********************************************************************************************/

                        echo "<section id='contenido-actual'>
                        <h1>Crear un álbum</h1>
                        </section>";

                        $consulta_grupos = "SELECT cod_grupo, nombre FROM grupos ORDER BY nombre";
                        $resultado_grupos = mysqli_query($conexion, $consulta_grupos);

                        echo "<form action='crear.php' method='get' name='formulario' class='formulario-creacion'>
                                <label for='cod_album'>Código de álbum</label>
                                <input type='number' name='cod_album' id='cod_album' autofocus required>
                                <label for='titulo'>Título</label>
                                <input type='text' name='titulo' id='titulo' maxlength='50' required>
                                <label for='fecha'>Año</label>
                                <input type='text' name='fecha' id='fecha' maxlength='4' placeholder='Formato AAAA' required>
                                <label for='img-portada'>Portada</label>
                                <input type='text' name='img-portada' id='img-portada' placeholder='.jpg, .png' required>
                                <label for=''>Código de grupo</label>
                                <select name='cod_grupo' id='cod_grupo' required>
                                <option value=''>Selecciona un grupo</option>";
                                while($fila = mysqli_fetch_array($resultado_grupos)) {
                                    echo "<option value='$fila[cod_grupo]'>$fila[nombre]</option>";
                                }
                                echo "<input type='submit' value='Crear álbum' name='crear_album' class='btn-form'>
                                <input type='reset' value='Limpiar' class='btn-form'>
                            </form>";

                    } else if (isset($_GET['cancion'])) {
                    /* Si venimos desde la página "canciones" ******************************************************************************************/

                        echo "<section id='contenido-actual'>
                        <h1>Crear una canción</h1>
                        </section>";

                        $consulta_albumes = "SELECT cod_album, titulo FROM albumes ORDER BY titulo";
                        $resultado_albumes = mysqli_query($conexion, $consulta_albumes);

                        echo "<form action='crear.php' method='get' name='formulario' class='formulario-creacion'>
                            <label for='cod_cancion'>Código de canción</label>
                            <input type='number' name='cod_cancion' id='cod_cancion' autofocus required>
                            <label for='titulo'>Título</label>
                            <input type='text' name='titulo' id='titulo' maxlength='50' required>
                            <label for='duracion'>Duración</label>
                            <input type='text' name='duracion' id='duracion' maxlength='8' placeholder='Formato 00:00:00' pattern='[0-9]{2}:[0-9]{2}:[0-9]{2}' title='El formato correcto es HH:MM:SS' required>
                            <label for='pista'>Número de pista</label>
                            <input type='number' name='pista' id='pista' required>
                            <label for=''>Código de álbum</label>
                            <select name='cod_album' id='cod_album' required>
                            <option value=''>Selecciona un álbum</option>";
                            while($fila = mysqli_fetch_array($resultado_albumes)) {
                                echo "<option value='$fila[cod_album]'>$fila[titulo]</option>";
                            }                  
                            echo "<input type='submit' value='Crear canción' name='crear_cancion' class='btn-form'>
                            <input type='reset' value='Limpiar' class='btn-form'>
                        </form>";
                    } else {
                        header("Location:index.html");
                    }
        /***********************************************************************************************************************************/


                    /* Si venimos desde el formulario "Crear grupo" *******/
                    if(isset($_GET['crear_grupo'])){
                        $consulta  = "INSERT INTO grupos VALUES ($_GET[cod_grupo], '$_GET[nombre]', '$_GET[nacionalidad]', '$_GET[biografia]', '$_GET[foto]');";
                        $resultado = mysqli_query($conexion, $consulta);
                    /* Si venimos desde el formulario "Crear album" *******/
                    } else if (isset($_GET['crear_album'])) {
                        $consulta  = "INSERT INTO albumes VALUES ($_GET[cod_album], '$_GET[titulo]', '$_GET[fecha]', $_GET[cod_grupo], '$_GET[portada]');";
                        $resultado = mysqli_query($conexion, $consulta);
                    /* Si venimos desde el formulario "Crear cancion" *****/
                    } else if (isset($_GET['crear_cancion'])) {
                        $consulta  = "INSERT INTO canciones VALUES ($_GET[cod_cancion], '$_GET[titulo]', '$_GET[duracion]', '$_GET[pista]', $_GET[cod_album]);";
                        $resultado = mysqli_query($conexion, $consulta);
                    }
                }
            }
            mysqli_close($conexion);
        }
    ?>
        </main>
    </div>

</body>
</html>