<!DOCTYPE html>
<html lang="es">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="David Punzano Rodríguez">
    <meta name="description" content="Proyecto educativo de desarrollo web sin ánimo de lucro.">
    <meta name="keywords" content="música, grupos, álbumes, canciones, grupo, álbum, canción">
    <title>Grupos</title>
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

                <a href="crear.php?grupo">
                    <div class="btn-lateral">
                        <img src="media/img/icon/new.png" alt="Crear nuevo">
                        <p>Crear nuevo</p>
                    </div>
                </a>
                
                <a href="grupos.php?gestionar">
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
                <form action="grupos.php" method="get" id="formulario-busqueda">
                    <input type="search" name="busqueda" id="barra-busqueda" placeholder="Buscar grupo...">
                    <input type="submit" name="buscar_grupo" value="Buscar">
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
                  <a href="grupos.php?">De la A a la Z</a>
                  <a href="grupos.php?orden=1">De la Z a la A</a>
                  <!--<a href="grupos.php?orden=2">Por año (ascendente)</a>
                  <a href="grupos.php?orden=3">Por año (descendente)</a>-->
                </div> 
                  

            </section>

        </aside>


        <!-- Contendrá un título con la sección en la que nos encontramos y las tarjetas de grupos y canciones, sencillo y dividido en dos secciones -->
        <main>
            <!-- Sección para el título de la presente sección -->
            
            <section id="contenido-actual">
                <h1>Sección de grupos</h1>
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
                                        $orden = "nombre DESC";
                                        break;
                                }
                            } else {
                                $orden = "nombre";
                            }

                            if(isset($_GET['buscar_grupo'])){
                                $consulta   = "SELECT * FROM grupos WHERE nombre LIKE '%".$_GET['busqueda']."%' ORDER BY $orden;";
                            }else {
                                $consulta   = "SELECT * FROM grupos ORDER BY $orden;";
                            }
                            $resultado  = mysqli_query($conexion,$consulta);

                            if(mysqli_errno($conexion)!=0) {
                                echo "<p>Error nº ".mysqli_errno($conexion)."</p>";
                                echo "<p>Descripción: ".mysqli_error($conexion)."</p>";
                            } else {

                                /*Recepcion de tuplas*/
                                while($fila = mysqli_fetch_array($resultado)) {
                                    $cod_grupo  = $fila['cod_grupo'];
                                    $nombre     = $fila['nombre'];
                                    $imagen     = $fila['foto']; 

                                    echo "<div class='tarjeta'>";

                                    echo "<a href='albumes.php?cod_grupo=$cod_grupo&nombre=$nombre'>
                                        <div class='tarjeta-contenido' title='Ver álbumes de $nombre'>
                                            <img class='redondeado-parcial img-grupo' src='media/img/grupos/$imagen'>
                                            <p>$nombre</p>";
                                            echo "<div id='btn-gestion'>
                                            <a href='ver.php?cod_grupo=$cod_grupo&nombre=$nombre'><img src='media/img/icon/moreinfo.png' alt='Ver información' title='Ver información detallada de $nombre' class='icono'></a>
                                            ";
                                            if(isset($_GET['gestionar'])){
                                                // Si pulsamos en "gestionar" desde el menú se mostrarán los botones de borrar y modificar
                                                echo "<a href='eliminar.php?cod_grupo=$cod_grupo&nombre=$nombre'><img src='media/img/icon/delete.png' alt='Borrar' title='Eliminar $nombre' class='icono'></a>";
                                                echo "<a href='modificar.php?cod_grupo=$cod_grupo&nombre=$nombre'><img src='media/img/icon/edit.png' alt='Modificar' title='Modificar $nombre' class='icono'></a>";
                                            }
                                        echo "</div>
                                            </div>
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