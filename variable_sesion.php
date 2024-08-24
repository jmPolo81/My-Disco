<?php
    require_once('sesion.php');//requiere una vez lo de sesion.php
    //Caduca a los 10 Minutos(600sg) (si o si)
    if(($_SESSION['hora']+600)<time()){
        //Habría caducado la sesion
        session_destroy();
        header("location:inicio_sesion.php?mensaje=caducada");
        
    }/*else{
        echo "<a href='archivo_protegido2.php'>Archivo 2</a>";
    }*/

    //Caduca a los 30 segundos de inactividad(mover ratón no vale)
    
    if(isset($_SESSION['timeout'])){
        $vida_sesion = time()-$_SESSION['timeout'];
        if($vida_sesion>30){
            //La sesion habría caducado por inactividad
            session_destroy();
            header("location:inicio_sesion.php?mensaje=inactividad");
        }
    }
    
    echo "<a href='archivo_protegido2.php'>Archivo 2</a></br>";
    echo "<a href='salir.php'>Salir de la app</a>";    

    $_SESSION['timeout']=time();
    
    ?>