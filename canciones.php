<!DOCTYPE html>
<html lang="es">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="David Punzano Rodríguez">
    <meta name="description" content="Proyecto educativo de desarrollo web sin ánimo de lucro.">
    <meta name="keywords" content="música, grupos, álbumes, canciones, grupo, álbum, canción">
    <title>Canciones</title>
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

                <a href="crear.php?cancion">
                    <div class="btn-lateral">
                        <img src="media/img/icon/new.png" alt="Crear nuevo">
                        <p>Crear nuevo</p>
                    </div>
                </a>
                
                <a href="canciones.php?gestionar">
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
                <form action="canciones.php" method="get" id="formulario-busqueda">
                    <input type="search" name="busqueda" id="barra-busqueda" placeholder="Buscar canción...">
                    <input type="submit" name="buscar_cancion" value="Buscar">
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
                  <a href="canciones.php?">De la A a la Z</a>
                  <a href="canciones.php?orden=1">De la Z a la A</a>
                </div> 
                  

            </section>

        </aside>

        <!-- Contendrá un título con la sección en la que nos encontramos y las tarjetas de grupos y canciones, sencillo y dividido en dos secciones -->
        <main>

        <!-- /////////////////////////////////////////////////////////////////// -->
        <!-- //////////////// ZONA CON ACCESO A  BASE DE DATOS /////////////////- -->

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
                    }
                } else {
                    $orden = "titulo";
                }

                if(isset($_GET['buscar_cancion'])){
                    // Si se entra por la barra de búsqueda
                    $consulta   = "SELECT * FROM canciones WHERE titulo LIKE '%".$_GET['busqueda']."%' ORDER BY num_pista;";

                } else if(isset($_GET['cod_album'])) {
                    // Si se entra clicando en un grupo concreto
                    $consulta = "SELECT * FROM canciones WHERE cod_album=$_GET[cod_album] ORDER BY num_pista;";
                    
                } else {
                    // Si se entra desde el menú
                    $consulta   = "SELECT * FROM canciones ORDER BY $orden;";
                }

                $resultado  = mysqli_query($conexion,$consulta);

                if(mysqli_errno($conexion)!=0) {
                    echo "<p>Error nº ".mysqli_errno($conexion)."</p>";
                    echo "<p>Descripción: ".mysqli_error($conexion)."</p>";
                } else {

                    // Sección para el título de la presente sección 
                    
                    echo "<section id='contenido-actual'>";

                    /** CREACIÓN DE CABECERA CON FOTO Y TÍTULO */
                    if(isset($_GET['portada'])){
                        // Si la URL contiene portada significa que se viene desde un album concreto y se muestra en la cabecera
                        $portada = $_GET['portada'];

                        echo "<section id='portada'>
                        <img src='media/img/albumes/$portada'></img>
                        <h1>Canciones de $_GET[titulo]</h1>
                        </section>";

                    } else {
                        //Si se viene desde el menu
                        echo "<h1>Sección de canciones</h1></section>";
                    }

                    //// Sección para las tarjetas
                    echo "<section id='contenedor-canciones'>";        

                    /** CREACION DE TABLA */

                    echo "
                    <table>
                        <thead>
                            <tr>
                                <th class='numero'>#</th>
                                <th class='titulo'>Título</th>
                                <th class='duracion'>Duración</th>
                                <th class='album'>Álbum</th>";
                                if(isset($_GET['gestionar'])){
                                    echo "<td class='duracion'>Gestión</td>";
                                }
                            echo "</tr>
                        </thead>
                    </table>
                    <img id='barra-separacion-2' src='media/img/stroke2.png' alt=''>";

                    /*Recepcion de tuplas*/

                    $contador   = 1; // Contador para enumerar
                    echo "<table>";
                    while($fila = mysqli_fetch_array($resultado)) {
                        $cod_cancion    = $fila['cod_cancion'];
                        $titulo         = $fila['titulo'];
                        $duracion       = $fila['duracion'];
                        $num_pista      = $fila['num_pista'];

                        // Query para extraer el titulo y portada del album de cada canción
                        $consulta2 = "SELECT albumes.titulo, albumes.portada FROM albumes WHERE albumes.cod_album = $fila[cod_album];";
                        $resultado2 = mysqli_query($conexion, $consulta2);
                        $fila2 = mysqli_fetch_array($resultado2);

                        $titulo_album = $fila2['titulo'];
                        $portada = $fila2['portada'];

                        // Muestra de información en la tabla
                    
                        echo "<tr>";
                            if(isset($_GET['cod_album'])){
                                // Si venimos de un álbum mostramos el número de pista y se ordena por el mismo
                                echo "<td class='numero'>$num_pista</td>";
                            }else {
                                // Si venimos desde el menú se muestra un número de orden ascendente y se ordena alfabéticamente, el número es meramente un punto de referencia visual
                                echo "<td class='numero'>$contador</td>";
                            }
                                echo "<td class='titulo'>$titulo</td>
                                <td class='duracion'>$duracion</td>
                                <td class='album'><a href='canciones.php?cod_album=$fila[cod_album]&titulo=$titulo_album&portada=$portada' title='Ver álbum completo'>$titulo_album</a></td>";
                                if(isset($_GET['gestionar'])){
                                    echo "<td class='duracion'>
                                    <a href='eliminar.php?cod_cancion=$cod_cancion&&titulo=$titulo'><img src='media/img/icon/delete.png' alt='Borrar' title='Eliminar $titulo' class='icono'></a>";
                                    
                                    echo "<a href='modificar.php?cod_cancion=$cod_cancion&&titulo=$titulo'><img src='media/img/icon/edit.png' alt='Modificar' title='Modificar $titulo' class='icono'></a></td>";
                                }
                            echo "</tr>";
                        $contador++;
                    }
                    echo "</table>
                    </section>";
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