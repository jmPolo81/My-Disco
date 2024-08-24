<?php

if(isset($_POST['enviar'])){
    
    if($_POST['usuario']=="pepe@hotmail.com" && $_POST['password']== "1234qwerty"){
        session_start();

        $_SESSION['logueado']=true;
        $_SESSION['usuario']=$usuario;
        $_SESSION['hora']=time();
        header("location:index.html");

    }else{
        header("location:inicio_sesion.php?mensaje=error");
    }
}else{
    header("location:inicio_sesion.php");
}

?>