<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="David Punzano Rodríguez">
    <meta name="description" content="Proyecto educativo de desarrollo web sin ánimo de lucro.">
    <meta name="keywords" content="música, grupos, álbumes, canciones, grupo, álbum, canción">
    <title>Eliminar</title>
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
        echo "<aside>
            <!-- Sección para los botones -->
            
            <section id='seccion-btn'>

                <a href='crear.php?grupo'>
                    <div class='btn-lateral' onclick='history.back()'>
                        <img src='media/img/icon/back.png' alt='Botón volver'>
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

                if(isset($_GET['cod_grupo'])){
                    /* Si venimos desde la página "Grupos" ********************************************************************************************/
                        $codigo = $_GET['cod_grupo'];
                        $nombre = $_GET['nombre'];
                        $consulta = "DELETE FROM grupos WHERE cod_grupo=$codigo";
                        $texto_confirmacion = "¿Quieres eliminar el grupo $nombre de la base de datos?";
                        $direccion_retorno = "grupos.php";
            
                        echo "<section id='contenido-actual'>
                        <h1>Eliminar grupo</h1>
                        </section>";
            
                    } else if (isset($_GET['cod_album'])) {
                    /* Si venimos desde la página "albumes" ********************************************************************************************/
                        $codigo = $_GET['cod_album'];
                        $titulo = $_GET['titulo'];
                        $consulta = "DELETE FROM albumes WHERE cod_album=$codigo";                        
                        $texto_confirmacion = "¿Quieres eliminar el álbum $titulo de la base de datos?";
                        $direccion_retorno = "albumes.php";
            
                        echo "<section id='contenido-actual'>
                        <h1>Eliminar álbum</h1>
                        </section>";
            
                    } else if (isset($_GET['cod_cancion'])) {
                    /* Si venimos desde la página "canciones" ******************************************************************************************/
                        $codigo = $_GET['cod_cancion'];
                        $titulo = $_GET['titulo'];
                        $consulta = "DELETE FROM grupos WHERE cod_grupo=$codigo";
                        $texto_confirmacion = "¿Quieres eliminar la canción $titulo de la base de datos?";
                        $direccion_retorno = "canciones.php";
            
                        echo "<section id='contenido-actual'>
                        <h1>Eliminar canción</h1>
                        </section>";
            
                    } else {
                        header("Location:index.html");
                    }
                    /***********************************************************************************************************************************/

                if(mysqli_errno($conexion)!=0) {
                    echo "<p>Nº Error: ".mysqli_errno($conexion)."</p>";
					echo "<p>Descripción: ".mysqli_error($conexion)."</p>";
                } else {

                    mysqli_query($conexion, $consulta);
                    header("Location:$direccion_retorno");

                    /*echo $texto_confirmacion;
                    echo "<form action='eliminar.php?' method='get'>
                        <input type='hidden' name='codigo' value='$codigo'>
                        <input type='submit' name='eliminar' value='Eliminar'>
                    </form>";*/
                }
            }
            mysqli_close($conexion);
        }
    ?>
        </main>
    </div>

</body>
</html>