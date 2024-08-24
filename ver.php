<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="David Punzano Rodríguez">
    <meta name="description" content="Proyecto educativo de desarrollo web sin ánimo de lucro.">
    <meta name="keywords" content="música, grupos, álbumes, canciones, grupo, álbum, canción">
    <?php
    echo "<title>Información de $_GET[nombre]</title>";
    ?>
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
                        <img src='media/img/icon/back.png' alt='Crear nuevo'>
                        <p>Volver</p>
                    </div>
                </a>
            </section>
        </aside>

        <main>";


        /***********************************************************************************************************************************/



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
                    /* Si venimos desde el boton ver de un grupo" *******/
                    if(isset($_GET['cod_grupo'])){
                        $consulta  = "SELECT * FROM grupos WHERE cod_grupo=$_GET[cod_grupo];";
                        $resultado = mysqli_query($conexion, $consulta);
                        while($fila=mysqli_fetch_array($resultado)) {
                            $nombre =       $fila['nombre'];
                            $nacionalidad = $fila['nacionalidad'];
                            $biografia=     $fila['biografia'];
                            $foto=          $fila['foto'];
                        }

                        echo "<h1>$nombre</h1>";
                        echo "<p>Nacionalidad: $nacionalidad</p>";
                        echo "<p>Biografía: $biografia</p>";
                    /* Si venimos desde el boton ver de un album" *******/
                    } else if (isset($_GET['cod_album'])) {
                        $consulta  = "SELECT * FROM albumes WHERE cod_album=$_GET[cod_album];";
                        $resultado = mysqli_query($conexion, $consulta);
                        while($fila = mysqli_fetch_array($resultado)) {
                            $cod_album  = $fila['cod_album'];
                            $titulo     = $fila['titulo'];
                            $fecha      = $fila['fecha'];
                            $imagen     = $fila['portada']; 
                        }

                        echo "<h1>$titulo</h1>";
                        echo "<p>Fecha: $fecha</p>";
                    /* Si venimos desde el boton ver de una cancion" *****/
                    } else if (isset($_GET['crear_cancion'])) {
                        $consulta  = "INSERT INTO canciones VALUES ($_GET[cod_cancion], '$_GET[titulo]', '$_GET[duracion]', '$_GET[pista]', $_GET[cod_album]);";
                        $resultado = mysqli_query($conexion, $consulta);
                    }else {
                        header("Location:index.html");
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