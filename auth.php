<?php
    require_once (__DIR__."\..\parametri.php");
    session_start();
    function checkAuth() {
    // Se l'utente è già loggato, reindirizza alla home
    if (isset($_SESSION["user_id"])) {
        return $_SESSION['user_id'];
        exit;
        } else 
        return 0;
    }
?>