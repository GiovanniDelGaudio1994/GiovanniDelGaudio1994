<?php
// Avvia la sessione
session_start();

// Verifica se l'utente è loggato
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Includi la configurazione del database
require_once 'db_config.php';

$user_id = $_SESSION['user_id'];
$message = '';

// Verifica se è stato fornito un ID prenotazione
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $prenotazione_id = $_GET['id'];
    
    // Verifica che la prenotazione appartenga all'utente e che sia futura
    $sql = "SELECT p.*, s.data_ora FROM prenotazioni p 
            JOIN sessioni_corsi s ON p.sessione_id = s.id 
            WHERE p.id = $prenotazione_id AND p.utente_id = $user_id AND s.data_ora > NOW() AND p.stato = 'confermata'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        // Aggiorna lo stato della prenotazione
        $update_sql = "UPDATE prenotazioni SET stato = 'cancellata' WHERE id = $prenotazione_id";
        
        if($conn->query($update_sql) === TRUE) {
            // Prenotazione cancellata con successo
            $message = "La tua prenotazione è stata cancellata con successo.";
            
            // Crea una notifica per l'utente
            $sql = "INSERT INTO notifiche (utente_id, titolo, messaggio) 
                    VALUES ($user_id, 'Prenotazione cancellata', 'La tua prenotazione è stata cancellata con successo.')";
            $conn->query($sql);
        } else {
            // Errore nell'aggiornamento
            $message = "Errore durante la cancellazione della prenotazione: " . $conn->error;
        }
    } else {
        // La prenotazione non esiste, non appartiene all'utente o è già passata
        $message = "Prenotazione non valida o già passata.";
    }
} else {
    // Nessun ID prenotazione fornito
    $message = "Parametro non valido.";
}

// Chiudi la connessione al database
$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cancellazione Prenotazione - FitZone</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script defer src="script/script.js"></script>
</head>
<body>
  <header>
    <nav>
      <h1>FitZone</h1>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="profile.php">Profilo</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <div class="message-box">
      <h2>Cancellazione Prenotazione</h2>
      <p><?php echo $message; ?></p>
      <a href="profile.php" class="btn-submit">Torna al profilo</a>
    </div>
  </div>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> FitZone - Tutti i diritti riservati</p>
  </footer>
</body>
</html>