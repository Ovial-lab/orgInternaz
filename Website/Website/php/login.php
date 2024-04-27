<?php
    //creazione di una sessione
    session_start();

    // Se non ha già effettuato l'accesso, controlla se sono stati inviati i dati del login
    if(isset($_POST['usernameUtente']) && isset($_POST['passwordUtente'])) {
        include('check_session.php');
        $username_Utente = $_POST['usernameUtente'];
        $password_Utente = $_POST['passwordUtente'];
        $pwEncrypted= md5($password_Utente);
        
        //connection and check Db 
        include('connectionDb.php');

        //query per verificare se esiste un account con quelle credenziali
        $query= "SELECT * FROM utenti WHERE nome_utente='$username_Utente' AND password='$pwEncrypted'";
        $result = $conn->query($query);
        if($result->num_rows == 1) {
            // Accesso riuscito, imposta le variabili di sessione
            $_SESSION["usernameUtente"] = $username_Utente;
            header('Location: ../html/home.html');
        } else {
            echo ("Username o password errate.");
        }  
        mysqli_close($conn);
    }
?>