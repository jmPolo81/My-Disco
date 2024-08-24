<?php
session_start();

if(!$_SESSION['logueado']){
    session_destroy();
    header("location:inicio_sesion.php");
    exit();
}
?>