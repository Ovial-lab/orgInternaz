<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" href="../css/profilo.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <body>
    <header>
        <nav class="navbar">
            <div class="container">
                <h1 class="header">Home</h1>
                <ul class="nav-links">
                    <li><a href="../html/home.html">Home</a></li>
                    <li><a href="profile.php">Profilo</a></li>
                    <li><a href="../html/abbonamenti.html">Abbonamenti</a></li>
                    <li><a href="../html/home.html" class="logout">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1 class="Welcome">Welcome to Your Profile</h1>
        <div class="user-info">
            <?php
                session_start();
                $nomeUtente = $_SESSION ["usernameUtente"];

                //Connessione al DataBase
                include('connectionDb.php'); 
            
                //Query per selezione tipologia
                $query = "SELECT Tipologie.tipo FROM Utenti INNER JOIN Tipologie ON Utenti.id_tipologia = Tipologie.id_tipologia WHERE nome_utente='$nomeUtente'";
                $result = $conn->query($query);
                $tipologia = $result->fetch_assoc();
            
                //Selezione importo totale
                $query = "SELECT SUM(Transazioni.importo) FROM Utenti RIGHT JOIN Transazioni ON Utenti.id_utente = Transazioni.id_utente WHERE nome_utente='$nomeUtente'";
                $result = $conn->query($query);
                $importoTot = $result->fetch_assoc();
            
                //Selezione Ultimo Importo
                $query = "SELECT Transazioni.importo FROM Utenti RIGHT JOIN Transazioni ON Utenti.id_utente = Transazioni.id_utente WHERE nome_utente='$nomeUtente' AND transazioni.data = (SELECT MAX(data) FROM Transazioni)";
                $result = $conn->query($query);
                $ultimoImport = $result->fetch_assoc();
            
                //Data ultimo importo
                $query = "SELECT MAX(data) FROM Transazioni INNER JOIN Utenti ON Utenti.id_utente = Transazioni.id_utente WHERE nome_utente='$nomeUtente'";
                $result = $conn->query($query);
                $dataultimoImport = $result->fetch_assoc();
            
                //Data prevista fine pagamento
                $query = "SELECT 'data' FROM Pagamenti INNER JOIN Transazioni ON Pagamenti.id_pagamento = Transazioni.id_pagamento INNER JOIN Utenti ON Transazioni.id_utente=Utenti.id_utente WHERE nome_utente='$nomeUtente'";
                $result = $conn->query($query);
                $dataprevista = $result->fetch_assoc();

                // Controlli per verificare se le variabili contengono valori validi
                if ($tipologia !== null && isset($tipologia['tipo'])) {
                    echo "<p>Tipologia: <span id='tipologia'>" . $tipologia['tipo'] . "</span></p>";
                } else {
                    echo "<p>Tipologia non disponibile</p>";
                }

                if ($importoTot !== null && isset($importoTot['SUM(Transazioni.importo)'])) {
                    echo "<p>Importo totale: <span id='importo-totale'>" . $importoTot['SUM(Transazioni.importo)'] . "</span></p>";
                } else {
                    echo "<p>Importo totale non disponibile</p>";
                }

                if ($ultimoImport !== null && isset($ultimoImport['importo'])) {
                    echo "<p>Ultimo importo: <span id='ultimo-importo'>" . $ultimoImport['importo'] . "</span></p>";
                } else {
                    echo "<p>Ultimo importo non disponibile</p>";
                }

                if ($dataultimoImport !== null && isset($dataultimoImport['MAX(data)'])) {
                    echo "<p>Data ultimo importo: <span id='data-ultimo-importo'>" . $dataultimoImport['MAX(data)'] . "</span></p>";
                } else {
                    echo "<p>Data ultimo importo non disponibile</p>";
                }

                if ($dataprevista !== null && isset($dataprevista['data'])) {
                    echo "<p>Data prevista di fine pagamento: <span id='data-fine-pagamento'>" . $dataprevista['data'] . "</span></p>";
                } else {
                    echo "<p>Data prevista di fine pagamento non disponibile</p>";
                }
            ?>
        </div>

        <!-- Buttons for different roles -->
        <button class="admin-only-btn">Admin Button</button>
        <button class="superadmin-only-btn">Super Admin Button</button>
    </div>

    <div class="footer">
        <a href="#">About</a>
        <a href="#">Contact</a>
        <div class="social-media">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
    </div>

    <script>
        // Function to open modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        // Function to close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        // Check user role and toggle button visibility
        function checkUserRole(id_livello) {
            const adminButton = document.querySelector('.admin-only-btn');
            const superAdminButton = document.querySelector('.superadmin-only-btn');

            // Assuming role is fetched from server-side or stored somewhere
            if (id_livello === '2' || id_livello === '1') {
                adminButton.style.display = 'block';
            } else {
                adminButton.style.display = 'none';
            }

            if (id_livello === '1') {
                superAdminButton.style.display = 'block';
            } else {
                superAdminButton.style.display = 'none';
            }
        }
        checkUserRole('3');
    </script>

    </body>
</html>