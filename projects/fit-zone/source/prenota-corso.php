<?php
session_start();
require_once 'db_config.php';

// Verifica che l'utente sia loggato
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Recupera il nome del corso dall'URL
if (!isset($_GET['corso'])) {
    header("Location: corsi.php");
    exit;
}

$corso_nome = urldecode($_GET['corso']);

// Recupera le informazioni del corso
$stmt = $conn->prepare("SELECT id, nome, descrizione, categoria_id, istruttore, max_partecipanti, immagine FROM corsi WHERE nome = ?");
$stmt->bind_param("s", $corso_nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: corsi.php");
    exit;
}

$corso = $result->fetch_assoc();
$corso_id = $corso['id'];

// Recupera la categoria del corso
$stmt = $conn->prepare("SELECT nome FROM categorie_corsi WHERE id = ?");
$stmt->bind_param("i", $corso['categoria_id']);
$stmt->execute();
$cat_result = $stmt->get_result();
$categoria = $cat_result->fetch_assoc();

// Verifica se l'utente ha un abbonamento attivo
$date_now = date('Y-m-d');
$stmt = $conn->prepare("SELECT id FROM abbonamenti WHERE utente_id = ? AND data_fine >= ?");
$stmt->bind_param("is", $user_id, $date_now);
$stmt->execute();
$abbonamento_result = $stmt->get_result();
$has_abbonamento = $abbonamento_result->num_rows > 0;

// Recupera le sessioni disponibili per il corso
$stmt = $conn->prepare("
    SELECT sc.id, sc.data_ora, sc.durata_minuti, 
           (SELECT COUNT(*) FROM prenotazioni WHERE sessione_id = sc.id AND stato = 'confermata') as partecipanti
    FROM sessioni_corsi sc
    WHERE sc.corso_id = ? AND sc.data_ora > NOW()
    ORDER BY sc.data_ora ASC
");
$stmt->bind_param("i", $corso_id);
$stmt->execute();
$sessioni_result = $stmt->get_result();

// Gestione della prenotazione
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sessione_id'])) {
    if (!$has_abbonamento) {
        $error = "Non hai un abbonamento attivo. Acquista un abbonamento prima di prenotare un corso.";
    } else {
        $sessione_id = $_POST['sessione_id'];
        
        // Verifica se l'utente ha già prenotato questa sessione
        $stmt = $conn->prepare("SELECT id FROM prenotazioni WHERE utente_id = ? AND sessione_id = ? AND stato = 'confermata'");
        $stmt->bind_param("ii", $user_id, $sessione_id);
        $stmt->execute();
        $prenotazione_result = $stmt->get_result();
        
        if ($prenotazione_result->num_rows > 0) {
            $error = "Hai già prenotato questa sessione!";
        } else {
            // Verifica se c'è ancora posto disponibile
            $stmt = $conn->prepare("
                SELECT sc.max_partecipanti, 
                       (SELECT COUNT(*) FROM prenotazioni WHERE sessione_id = ? AND stato = 'confermata') as partecipanti
                FROM sessioni_corsi sc 
                JOIN corsi c ON sc.corso_id = c.id
                WHERE sc.id = ?
            ");
            $stmt->bind_param("ii", $sessione_id, $sessione_id);
            $stmt->execute();
            $sessione_result = $stmt->get_result();
            $sessione = $sessione_result->fetch_assoc();
            
            // Recupera data e ora della sessione
            $stmt = $conn->prepare("SELECT data_ora FROM sessioni_corsi WHERE id = ?");
            $stmt->bind_param("i", $sessione_id);
            $stmt->execute();
            $data_ora_result = $stmt->get_result();
            $data_ora_row = $data_ora_result->fetch_assoc();
            $data_ora = $data_ora_row['data_ora'];
            
            if ($sessione['partecipanti'] >= $corso['max_partecipanti']) {
                $error = "Sessione completa! Non ci sono più posti disponibili.";
            } else {
                // Inserisci la prenotazione
                $stmt = $conn->prepare("INSERT INTO prenotazioni (utente_id, corso_id, sessione_id, data_ora) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiis", $user_id, $corso_id, $sessione_id, $data_ora);
                
                if ($stmt->execute()) {
                    // Crea una notifica per l'utente
                    $titolo_notifica = "Prenotazione confermata";
                    $messaggio_notifica = "La tua prenotazione per il corso di {$corso['nome']} del " . date('d/m/Y H:i', strtotime($data_ora)) . " è stata confermata.";
                    
                    $stmt = $conn->prepare("INSERT INTO notifiche (utente_id, titolo, messaggio) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss", $user_id, $titolo_notifica, $messaggio_notifica);
                    $stmt->execute();
                    
                    $message = "Prenotazione effettuata con successo!";
                    
                    // Aggiorna la lista delle sessioni
                    $stmt = $conn->prepare("
                        SELECT sc.id, sc.data_ora, sc.durata_minuti, 
                               (SELECT COUNT(*) FROM prenotazioni WHERE sessione_id = sc.id AND stato = 'confermata') as partecipanti
                        FROM sessioni_corsi sc
                        WHERE sc.corso_id = ? AND sc.data_ora > NOW()
                        ORDER BY sc.data_ora ASC
                    ");
                    $stmt->bind_param("i", $corso_id);
                    $stmt->execute();
                    $sessioni_result = $stmt->get_result();
                } else {
                    $error = "Errore durante la prenotazione: " . $stmt->error;
                }
            }
        }
    }
}

// Recupera le prenotazioni dell'utente per questo corso
$stmt = $conn->prepare("
    SELECT p.id, sc.data_ora, p.stato
    FROM prenotazioni p
    JOIN sessioni_corsi sc ON p.sessione_id = sc.id
    WHERE p.utente_id = ? AND p.corso_id = ? AND sc.data_ora > NOW()
    ORDER BY sc.data_ora ASC
");
$stmt->bind_param("ii", $user_id, $corso_id);
$stmt->execute();
$prenotazioni_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenota Corso - <?php echo htmlspecialchars($corso['nome']); ?></title>
    <link rel="stylesheet" href="css/prenota-corso.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <h2>Area Utente</h2>
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="profile.php"><i class="fas fa-user"></i> Profilo</a></li>
                <li><a href="abbonamenti.php"><i class="fas fa-credit-card"></i> Abbonamenti</a></li>
                <li><a href="prenotazioni.php"><i class="fas fa-calendar-check"></i> Prenotazioni</a></li>
                <li><a href="corsi.php"><i class="fas fa-dumbbell"></i> Corsi</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Esci</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header-nav">
                <a href="corsi.php" class="back-link"><i class="fas fa-arrow-left"></i> Torna ai corsi</a>
            </div>
            
            <?php if(!empty($message)): ?>
                <div class="alert success">
                    <i class="fas fa-check-circle"></i> <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($error)): ?>
                <div class="alert error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <div class="corso-header">
                <?php if (!empty($corso['immagine'])): ?>
                    <div class="corso-image" style="background-image: url('<?php echo htmlspecialchars($corso['immagine']); ?>')"></div>
                <?php else: ?>
                    <div class="corso-image default-image">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                <?php endif; ?>
                
                <div class="corso-info">
                    <h1><?php echo htmlspecialchars($corso['nome']); ?></h1>
                    <div class="corso-meta">
                        <div class="meta-item">
                            <i class="fas fa-tag"></i> <?php echo htmlspecialchars($categoria['nome']); ?>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-user-tie"></i> <?php echo htmlspecialchars($corso['istruttore']); ?>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-users"></i> Max <?php echo htmlspecialchars($corso['max_partecipanti']); ?> partecipanti
                        </div>
                    </div>
                    <div class="corso-descrizione">
                        <p><?php echo nl2br(htmlspecialchars($corso['descrizione'])); ?></p>
                    </div>
                </div>
            </div>
            
            <?php if(!$has_abbonamento): ?>
                <div class="alert warning">
                    <i class="fas fa-exclamation-triangle"></i> Non hai un abbonamento attivo. <a href="abbonamenti.php">Acquista un abbonamento</a> per prenotare i corsi.
                </div>
            <?php endif; ?>
            
            <div class="section-container">
                <div class="section">
                    <h2><i class="fas fa-calendar-alt"></i> Sessioni disponibili</h2>
                    <?php if($sessioni_result->num_rows > 0): ?>
                        <div class="sessioni-list">
                            <?php while($sessione = $sessioni_result->fetch_assoc()): 
                                $data_sessione = new DateTime($sessione['data_ora']);
                                $oggi = new DateTime();
                                $diff_giorni = $oggi->diff($data_sessione)->days;
                                $posti_disponibili = $corso['max_partecipanti'] - $sessione['partecipanti'];
                                $percentuale_occupazione = ($sessione['partecipanti'] / $corso['max_partecipanti']) * 100;
                                
                                // Controlla se l'utente ha già prenotato questa sessione
                                $prenotato = false;
                                if($prenotazioni_result->num_rows > 0) {
                                    $prenotazioni_result->data_seek(0);
                                    while($prenotazione = $prenotazioni_result->fetch_assoc()) {
                                        if(strtotime($prenotazione['data_ora']) == strtotime($sessione['data_ora'])) {
                                            $prenotato = true;
                                            break;
                                        }
                                    }
                                }
                            ?>
                                <div class="sessione-card <?php echo ($posti_disponibili <= 0 ? 'completo' : ($prenotato ? 'prenotato' : '')); ?>">
                                    <div class="sessione-data">
                                        <div class="giorno"><?php echo $data_sessione->format('d'); ?></div>
                                        <div class="mese"><?php echo $data_sessione->format('M'); ?></div>
                                    </div>
                                    <div class="sessione-info">
                                        <div class="orario">
                                            <i class="far fa-clock"></i> <?php echo $data_sessione->format('H:i'); ?>
                                            <span class="durata">(<?php echo $sessione['durata_minuti']; ?> min)</span>
                                        </div>
                                        <div class="posti">
                                            <div class="posti-testo">
                                                <?php if($posti_disponibili <= 0): ?>
                                                    <i class="fas fa-users-slash"></i> Completo
                                                <?php else: ?>
                                                    <i class="fas fa-users"></i> <?php echo $posti_disponibili; ?> posti disponibili
                                                <?php endif; ?>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress" style="width: <?php echo $percentuale_occupazione; ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sessione-action">
                                        <?php if($prenotato): ?>
                                            <span class="prenotato-label"><i class="fas fa-check"></i> Prenotato</span>
                                        <?php elseif($posti_disponibili <= 0): ?>
                                            <span class="completo-label"><i class="fas fa-times"></i> Completo</span>
                                        <?php else: ?>
                                            <form method="post" action="">
                                                <input type="hidden" name="sessione_id" value="<?php echo $sessione['id']; ?>">
                                                <button type="submit" class="btn-prenota" <?php echo (!$has_abbonamento ? 'disabled' : ''); ?>>
                                                    <i class="fas fa-calendar-plus"></i> Prenota
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-sessioni">
                            <i class="fas fa-calendar-times"></i>
                            <p>Non ci sono sessioni disponibili per questo corso al momento.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="section">
                    <h2><i class="fas fa-calendar-check"></i> Le tue prenotazioni</h2>
                    <?php if($prenotazioni_result->num_rows > 0): ?>
                        <div class="prenotazioni-list">
                            <?php 
                            $prenotazioni_result->data_seek(0);
                            while($prenotazione = $prenotazioni_result->fetch_assoc()): 
                                $data_prenotazione = new DateTime($prenotazione['data_ora']);
                            ?>
                                <div class="prenotazione-card">
                                    <div class="prenotazione-data">
                                        <div class="giorno"><?php echo $data_prenotazione->format('d'); ?></div>
                                        <div class="mese"><?php echo $data_prenotazione->format('M'); ?></div>
                                    </div>
                                    <div class="prenotazione-info">
                                        <div class="orario"><i class="far fa-clock"></i> <?php echo $data_prenotazione->format('H:i'); ?></div>
                                        <div class="stato">
                                            <span class="stato-label <?php echo strtolower($prenotazione['stato']); ?>">
                                                <i class="fas fa-check-circle"></i> <?php echo ucfirst($prenotazione['stato']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="prenotazione-action">
                                        <a href="cancella_prenotazioni.php?id=<?php echo $prenotazione['id']; ?>" class="btn-cancella" onclick="return confirm('Sei sicuro di voler cancellare questa prenotazione?');">
                                            <i class="fas fa-calendar-times"></i> Cancella
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-prenotazioni">
                            <i class="fas fa-calendar-times"></i>
                            <p>Non hai prenotazioni per questo corso.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENSIONI -->
<section class="recensioni">
    <h2>Recensioni degli utenti</h2>

    <?php
    // Connessione al DB (se non già aperta)
    $db = $conn;
    if ($db->connect_error) {
        die("Connessione fallita: " . $db->connect_error);
    }

    // ID del corso corrente (assicurati che $corso_id sia definito prima)
    $stmt = $db->prepare("SELECT r.*, u.nome AS utente_nome
                          FROM recensioni r
                          JOIN utenti u ON r.user_id = u.id
                          WHERE r.corso_id = ?
                          ORDER BY r.data_creazione DESC");
    $stmt->bind_param("i", $corso_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0):
        while ($rec = $result->fetch_assoc()):
    ?>
        <div class="recensione-item">
            <strong><?php echo htmlspecialchars($rec['utente_nome']); ?></strong>
            <span class="voto">
                <?php echo str_repeat('⭐', (int)$rec['voto']); ?>
            </span>
            <p><?php echo htmlspecialchars($rec['commento']); ?></p>
        </div>
    <?php
        endwhile;
    else:
        echo "<p>Nessuna recensione disponibile per questo corso.</p>";
    endif;

    $stmt->close();
    $db->close();
    ?>
</section>

</body>
</html>