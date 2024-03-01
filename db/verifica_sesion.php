<?php
    session_start();
    if(!isset($_SESSION["logueado"])){
        header("location:../index.php");
    }
?>