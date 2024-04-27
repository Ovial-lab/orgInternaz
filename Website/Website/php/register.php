<?php
    //connection and check Db 
    include('connectionDb.php');

    //conversione dati form in variabili
    $nome_Utente = $_POST['nomeUtente'];
    $cognome_Utente= $_POST['cognomeUtente'];
    $username_Utente= $_POST['usernameUtente'];
    $email_Utente= $_POST['emailUtente'];
    $password_Utente= $_POST['passwordUtente'];
    $nazione_Utente= $_POST['nazioneUtente'];
    $prefisso_Utente= $_POST['prefissoUtente'];
    $telefono_Utente= $_POST['telefonoUtente'];
    $dNascita_Utente = $_POST['dataNUtente'];
    $livello_utente_standard= '3';

    //encryption della password tramite md5
    $pwEncrypted= md5($password_Utente);

    //combinazione prefisso + telefono
    $telefonoCompleto= $prefisso_Utente." ".$telefono_Utente;
    
    //select per verificare se esistono account con la stessa mail
    $query= "SELECT * FROM utenti WHERE nome_utente='$username_Utente'";
    $result = $conn->query($query);

    //verifica l'unicita' dell'username_utente
    if($result && $result->num_rows == 0){
        
        //inserting data order
        $toinsert = "INSERT INTO utenti (nome,cognome,telefono,data_nascita,email,nome_utente,password,id_nazione,id_livello)VALUES('$nome_Utente','$cognome_Utente','$telefonoCompleto','$dNascita_Utente','$email_Utente','$username_Utente','$pwEncrypted','$nazione_Utente','$livello_utente_standard')";

        //declare in the order variable
        $result = mysqli_query($conn, $toinsert);
        if($result){
            header('Location: ../html/login.html');
        } else{
            echo("<br>Inserimento non eseguito");
        }

    } else {
        echo("<br>Account gia' esistente.");
    }
    
    mysqli_close($conn);
?>