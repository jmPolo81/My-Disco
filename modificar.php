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
    if(isset($_GET['nombre'])) {
        echo "<title>Modificar $_GET[nombre]</title>";
    }else {
        echo "<title>Modificar $_GET[titulo]</title>";
    }

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

                    echo "<section id='contenido-actual'>";
                    if(isset($_GET['nombre'])) {
                        echo "<h1>Modificar $_GET[nombre]</h1>";
                    }else {
                        echo "<h1>Modificar $_GET[titulo]</h1>";
                    }
                    
                    echo "</section>";

                    if(isset($_GET['cod_grupo'])){
                    /* Si venimos desde la página "Grupos" ********************************************************************************************/
                        $cambio_efectuado = false;
                        $cod_grupo = $_GET['cod_grupo'];
                        $consulta = "SELECT * FROM grupos WHERE cod_grupo=$cod_grupo;";
                        $resultado = mysqli_query($conexion, $consulta);
                        while($fila=mysqli_fetch_array($resultado)) {
                            $nombre =       $fila['nombre'];
                            $nacionalidad = $fila['nacionalidad'];
                            $biografia=     $fila['biografia'];
                            $foto=          $fila['foto'];
                        }
            
                        echo "<form action='modificar.php' method='get' name='formulario' class='formulario-modificacion'>
                            <input type='hidden' name='cod_grupo' value='$cod_grupo'>
                            <label for='nombre'>Nombre</label>
                            <input type='text' name='nombre' id='nombre' value='$nombre' maxlength='50' required>
            
                            <label for='nacionalidad'>Nacionalidad</label>
                            <input type='text' name='nacionalidad' id='nacionalidad' value='$nacionalidad' maxlength='35' required>
            
                            <label for='biografia'>Biografia</label>
                            <textarea name='biografia' id='biografia' cols='30' rows='10' maxlength='500' required>"."$biografia"."</textarea>
            
                            <label for='foto'>Foto</label>
                            <input type='text' name='foto' id='foto' value='$foto' required>
                        
                            <input type='submit' value='Modificar grupo' name='modificar_grupo' class='btn-form'>
                            <input type='reset' value='Limpiar' class='btn-form'>
                        </form>";
            
                    } else if (isset($_GET['cod_album'])) {
                    /* Si venimos desde la página "albumes" ********************************************************************************************/
                    $cambio_efectuado = false;
                    $cod_album = $_GET['cod_album'];
                    $consulta = "SELECT * FROM albumes WHERE cod_album=$cod_album";
                    $resultado = mysqli_query($conexion, $consulta);
                    while($fila=mysqli_fetch_array($resultado)) {
                        $titulo =       $fila['titulo'];
                        $fecha =    $fila['fecha'];
                        $portada=      $fila['portada'];
                    }
            
                        echo "<form action='modificar.php' method='get' name='formulario' class='formulario-modificacion'>

                                <input type='hidden' name='cod_album' value='$cod_album'>

                                <label for='titulo'>Título</label>
                                <input type='text' name='titulo' id='titulo' maxlength='50' value='$titulo' required>
            
                                <label for='fecha'>Año</label>
                                <input type='text' name='fecha' id='fecha' maxlength='4' value='$fecha' required>
            
                                <label for='portada'>Portada</label>
                                <input type='text' name='portada' id='portada' value='$portada' required>    
            
                                <input type='submit' value='Modificar álbum' name='modificar_album' class='btn-form'>
                                <input type='reset' value='Limpiar' class='btn-form'>
                            </form>";
            
                    } else if (isset($_GET['cod_cancion'])) {
                    /* Si venimos desde la página "canciones" ******************************************************************************************/
            
                    $cambio_efectuado = false;
                    $cod_cancion = $_GET['cod_cancion'];
                    $consulta = "SELECT * FROM canciones WHERE cod_cancion=$cod_cancion";
                    $resultado = mysqli_query($conexion, $consulta);
                    while($fila=mysqli_fetch_array($resultado)) {
                        $titulo =       $fila['titulo'];
                        $num_pista =    $fila['num_pista'];
                        $duracion=      $fila['duracion'];
                    }
            
                        echo "<form action='modificar.php' method='get' name='formulario' class='formulario-modificacion'>

                                <input type='hidden' name='cod_cancion' value='$cod_cancion'>

                                <label for='titulo'>Título</label>
                                <input type='text' name='titulo' id='titulo' maxlength='50' value='$titulo' required>
            
                                <label for='fecha'>Número de pista</label>
                                <input type='text' name='fecha' id='fecha' maxlength='4' value='$num_pista' required>
            
                                <label for='portada'>Duración</label>
                                <input type='text' name='portada' id='portada' value='$duracion' required>    
            
                                <input type='submit' value='Modificar canción' name='modificar_cancion' class='btn-form'>
                                <input type='reset' value='Limpiar' class='btn-form'>
                            </form>";
                    } else {
                        //header("Location:index.html");
                    }

                    /* Si venimos desde el formulario "Crear grupo" *******/
                    if(isset($_GET['modificar_grupo'])){
                        $consulta  = "UPDATE grupos SET nombre='$_GET[nombre]', nacionalidad='$_GET[nacionalidad]', biografia='$_GET[biografia]', foto='$_GET[foto]' WHERE cod_grupo=$cod_grupo;";
                        mysqli_query($conexion, $consulta);
                        $cambio_efectuado = true;
                    /* Si venimos desde el formulario "Crear album" *******/
                    } else if (isset($_GET['modificar_album'])) {
                        $consulta  = "UPDATE albumes SET titulo='$_GET[titulo]', fecha='$_GET[fecha]', portada='$_GET[portada]' WHERE cod_album=$cod_album;";
                        mysqli_query($conexion, $consulta);
                        $cambio_efectuado = true;
                    /* Si venimos desde el formulario "Crear cancion" *****/
                    } else if (isset($_GET['modificar_cancion'])) {
                        $consulta  = "UPDATE canciones SET titulo='$_GET[titulo]', num_pista='$_GET[num_pista]', duracion='$_GET[duracion]' WHERE cod_cancion=$cod_cancion;";
                        mysqli_query($conexion, $consulta);
                        $cambio_efectuado = true;
                    }else {
                        
                    }

                    if($cambio_efectuado) {
                        header('Location:index.html');
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