<!DOCTYPE html>
<html lang="es">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="David Punzano Rodríguez">
    <meta name="description" content="Proyecto educativo de desarrollo web sin ánimo de lucro.">
    <meta name="keywords" content="música, grupos, álbumes, canciones, grupo, álbum, canción">
    <title>Álbumes</title>
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

    <!-- Contiene main y aside para agruparlos con flexbox -->
    <div id="contenido-principal">

        <!-- Contendrá los botones de crear, modificar y eliminar en una sección y debajo un menú desplegable con las secciones grupos, álbumes y canciones y los filtros -->
        <aside>
            <!-- Sección para los botones -->

            <section id="seccion-btn">

                <a href="crear.php?album">
                    <div class="btn-lateral">
                        <img src="media/img/icon/new.png" alt="Crear nuevo">
                        <p>Crear nuevo</p>
                    </div>
                </a>
                
                <a href="albumes.php?gestionar">
                    <div class="btn-lateral">
                        <img src="media/img/icon/manage.png" alt="Gestionar">
                        <p>Gestionar</p>
                    </div>
                </a>

            </section>

            <!-- Sección para las secciones grupos, albumes y canciones -->
            <section id="seccion-mostrar-todos">

                <img id="barra-separacion" src="media/img/stroke.png" alt="">

                <a href="grupos.php">
                    <div class="btn-lateral">
                        <img src="media/img/icon/cd.png" alt="Ir a grupos">
                        <p>Ir a grupos</p>
                    </div>
                </a>
                
                <a href="albumes.php">
                    <div class="btn-lateral">
                        <img src="media/img/icon/cd.png" alt="Ir a álbumes">
                        <p>Ir a álbumes</p>
                    </div>
                </a>
                
                <a href="canciones.php">
                    <div class="btn-lateral">
                        <img src="media/img/icon/cd.png" alt="Ir a canciones">
                        <p>Ir a canciones</p>
                    </div>
                </a>

            </section>

            <!-- Sección para la barra de búsqueda -->

            <section id="busqueda">
                <form action="albumes.php" method="get" id="formulario-busqueda">
                    <input type="search" name="busqueda" id="barra-busqueda" placeholder="Buscar álbum...">
                    <input type="submit" name="buscar_album" value="Buscar">
                </form>
            </section>

            <!-- Sección para el menú desplegable -->
            <section id="seccion-menu">

                <img id="barra-separacion" src="media/img/stroke.png" alt="">

                <!-- menu colapsable de ordenacion -->
                <button type="button" class="colapsable btn-lateral">
                    <img src="media/img/icon/menu.png" alt="">
                    <p>Ordenar</p></button>
                <div class="contenido">
                  <a href="albumes.php?">De la A a la Z</a>
                  <a href="albumes.php?orden=1">De la Z a la A</a>
                  <a href="albumes.php?orden=2">Por año (ascendente)</a>
                  <a href="albumes.php?orden=3">Por año (descendente)</a>
                </div> 
                  
            </section>

        </aside>


        <!-- Contendrá un título con la sección en la que nos encontramos y las tarjetas de grupos y canciones, sencillo y dividido en dos secciones -->
        <main>
            <!-- Sección para el título de la presente sección -->
            
            <section id="contenido-actual">
                <?php

                if(isset($_GET['cod_grupo'])) {
                    // Si se viene desde un grupo se mostrará su nombre
                    echo "<h1>Álbumes de $_GET[nombre]:</h1>";
                }else {
                    // Si se viene del menú 
                    echo "<h1>Sección de álbumes</h1>";
                }
                ?>
            </section>

            <!-- Sección para las tarjetas -->
            <section id="contenedor-tarjetas">
                <!-- ///////////////////////////////////////////////////////////////////-->
                <!-- //////////////// ZONA CON ACCESO A  BASE DE DATOS /////////////////-->
                
                <?php
                    require("conexion_discoteca.php");

                    $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);

                    if($conexion) {

                        mysqli_query($conexion, "SET NAMES 'UTF8'");

                        if(mysqli_select_db($conexion, $bbdd)) {

                            if(isset($_GET['orden'])){
                                switch($_GET['orden']){
                                    case "1":
                                        $orden = "titulo DESC";
                                        break;
                                    case "2":
                                        $orden = "fecha";
                                        break;
                                    case "3":
                                        $orden = "fecha DESC";
                                }
                            } else {
                                $orden = "titulo";
                            }

                            if(isset($_GET['buscar_album'])){
                                // Si se entra por la barra de búsqueda
                                $consulta   = "SELECT * FROM albumes WHERE titulo LIKE '%".$_GET['busqueda']."%' ORDER BY $orden;";
                            }else if (isset($_GET['cod_grupo'])) {
                                // Si se entra clicando en un grupo concreto
                                $consulta = "SELECT * FROM albumes WHERE cod_grupo=$_GET[cod_grupo] ORDER BY $orden;";
                                
                            } else {
                                // S se entra desde el menú
                                $consulta   = "SELECT * FROM albumes ORDER BY $orden;";    
                            }

                            
                            $resultado  = mysqli_query($conexion,$consulta);

                            if(mysqli_errno($conexion)!=0) {
                                echo "<p>Error nº ".mysqli_errno($conexion)."</p>";
                                echo "<p>Descripción: ".mysqli_error($conexion)."</p>";
                            } else {

                                /*Recepcion de tuplas*/
                                while($fila = mysqli_fetch_array($resultado)) {
                                    $cod_album  = $fila['cod_album'];
                                    $titulo     = $fila['titulo'];
                                    $fecha      = $fila['fecha'];
                                    $imagen     = $fila['portada']; 

                                    echo "<div class='tarjeta'> ";
                                                         
                                    echo "<a href='canciones.php?cod_album=$cod_album&titulo=$titulo&portada=$imagen'>
                                            <div class='tarjeta-contenido' title='Ver canciones de $titulo'>
                                                <img class='redondeado-total img-album' src='media/img/albumes/$imagen'>
                                                <p>$titulo ($fecha)</p>";
                                                if(isset($_GET['gestionar'])){
                                                    // Si pulsamos en "gestionar" desde el menú se mostrarán los botones de borrar y modificar
                                                    echo "<div id='btn-gestion'>
                                                    <a href='eliminar.php?cod_album=$cod_album&titulo=$titulo'><img src='media/img/icon/delete.png' alt='Borrar' title='Eliminar $titulo' class='icono'></a>
                                                    <a href='modificar.php?cod_album=$cod_album&&titulo=$titulo'><img src='media/img/icon/edit.png' alt='Modificar' title='Modificar $titulo' class='icono'></a></div>";
                                                }
                                            echo "</div>
                                        </a>
                                    </div>";
                                }
                            }
                            mysqli_close($conexion);
                        }
                    }
                ?>
            </section>
        </main>
    </div>
</body>
</html>