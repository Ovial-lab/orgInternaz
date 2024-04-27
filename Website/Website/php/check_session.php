<?php
    // Verifica se l'utente ha già effettuato l'accesso
    session_start();
    if(isset($_SESSION["usernameUtente"])) {
        header('location: ../html/home.html');
        exit; // Esce dallo script, poiché l'utente ha già effettuato l'accesso
    }else{
        header('location: ../html/login.html');
    }
?>