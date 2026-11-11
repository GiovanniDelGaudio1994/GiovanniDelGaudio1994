<?php
session_start();
require_once __DIR__ . '/db_config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Utente';

$db = $conn;
if ($db->connect_error) {
    die("Connessione fallita: " . $db->connect_error);
}

$success = $error = "";

// Acquista nuovo abbonamento
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['acquista_abbonamento'])) {
    $tipo_id = (int)$_POST['abbonamento_id'];
    $data_inizio = date('Y-m-d');
    
    // Recupera durata dell'abbonamento
    $result = $db->query("SELECT durata_mesi FROM tipi_abbonamento WHERE id = $tipo_id");
    $abbonamento = $result->fetch_assoc();
    $durata_mesi = $abbonamento['durata_mesi'];
    
    // Calcola data fine
    $data_fine = date('Y-m-d', strtotime("+$durata_mesi months", strtotime($data_inizio)));
    
    // Controlla se l'utente ha già un abbonamento attivo
    $check = $db->query("SELECT * FROM abbonamenti WHERE utente_id = $user_id AND data_fine >= CURDATE()");
    
    if ($check->num_rows > 0) {
        $error = "Hai già un abbonamento attivo. Attendi la scadenza o contatta la reception.";
    } else {
        // Inserisci nuovo abbonamento
        $stmt = $db->prepare("INSERT INTO abbonamenti (utente_id, tipo_id, data_inizio, data_fine) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $user_id, $tipo_id, $data_inizio, $data_fine);
        
        if ($stmt->execute()) {
            $success = "Abbonamento acquistato con successo!";
        } else {
            $error = "Errore durante l'acquisto: " . $db->error;
        }
        $stmt->close();
    }
}

// Recupera abbonamenti disponibili
$abbonamenti = $db->query("SELECT * FROM tipi_abbonamento WHERE attivo = TRUE ORDER BY prezzo");

// Recupera abbonamento attivo dell'utente
$abbonamento_attivo = $db->query("SELECT a.*, t.nome, t.descrizione, t.prezzo, t.durata_mesi 
                                 FROM abbonamenti a 
                                 JOIN tipi_abbonamento t ON a.tipo_id = t.id 
                                 WHERE a.utente_id = $user_id AND a.data_fine >= CURDATE() 
                                 ORDER BY a.data_fine DESC LIMIT 1");

// Recupera storico abbonamenti
$storico = $db->query("SELECT a.*, t.nome, t.descrizione, t.prezzo, t.durata_mesi 
                      FROM abbonamenti a 
                      JOIN tipi_abbonamento t ON a.tipo_id = t.id 
                      WHERE a.utente_id = $user_id 
                      ORDER BY a.data_inizio DESC");

$db->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abbonamenti - FitZone</title>
    <link rel="stylesheet" href="css/abbonamenti.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="logo">🏋️ FitZone</div>
        <ul class="menu">
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="corsi.php"><i class="fas fa-dumbbell"></i> Corsi</a></li>
            <li><a href="istruttori.php"><i class="fas fa-chalkboard-teacher"></i> Istruttori</a></li>
            <li><a href="attivita.php"><i class="fas fa-running"></i> Attività</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profilo</a></li>
            <li><a class="active" href="abbonamenti.php"><i class="fas fa-id-card"></i> Abbonamenti</a></li>
            <li><a href="prenotazioni.php"><i class="fas fa-calendar-check"></i> Prenotazioni</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <div class="hamburger">
        <i class="fas fa-bars"></i>
    </div>
    <div class="close-sidebar">
        <i class="fas fa-times"></i>
    </div>

    <main class="main-content">
        <div class="container">
            <h1>Gestione Abbonamenti</h1>

            <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
            <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>

            <!-- Abbonamento attivo -->
            <section class="abbonamento-attivo">
                <h2>Il tuo abbonamento attivo</h2>
                <?php if ($abbonamento_attivo && $abbonamento_attivo->num_rows > 0): 
                    $attivo = $abbonamento_attivo->fetch_assoc();
                ?>
                    <div class="card">
                        <div class="card-header">
                            <h3><?php echo htmlspecialchars($attivo['nome']); ?></h3>
                            <span class="badge active">Attivo</span>
                        </div>
                        <div class="card-body">
                            <p><?php echo htmlspecialchars($attivo['descrizione']); ?></p>
                            <p><strong>Data inizio:</strong> <?php echo date('d/m/Y', strtotime($attivo['data_inizio'])); ?></p>
                            <p><strong>Data scadenza:</strong> <?php echo date('d/m/Y', strtotime($attivo['data_fine'])); ?></p>
                            <p><strong>Prezzo:</strong> €<?php echo number_format($attivo['prezzo'], 2); ?></p>
                            
                            <?php 
                            $oggi = new DateTime();
                            $scadenza = new DateTime($attivo['data_fine']);
                            $diff = $oggi->diff($scadenza);
                            $giorni_rimanenti = $diff->days;
                            ?>
                            
                            <div class="progress-container">
                                <div class="progress-label">
                                    <span>Giorni rimanenti: <?php echo $giorni_rimanenti; ?></span>
                                </div>
                                <div class="progress">
                                    <?php 
                                    $inizio = new DateTime($attivo['data_inizio']);
                                    $durata_totale = $inizio->diff($scadenza)->days;
                                    $percentuale = 100 - (($giorni_rimanenti / $durata_totale) * 100);
                                    ?>
                                    <div class="progress-bar" style="width: <?php echo $percentuale; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="no-data">Non hai abbonamenti attivi.</div>
                <?php endif; ?>
            </section>

            <!-- Lista abbonamenti disponibili -->
            <section class="abbonamenti-disponibili">
                <h2>Abbonamenti disponibili</h2>
                <div class="abbonamenti-grid">
                    <?php while ($abbonamento = $abbonamenti->fetch_assoc()): ?>
                        <div class="abbonamento-card">
                            <h3><?php echo htmlspecialchars($abbonamento['nome']); ?></h3>
                            <p class="descrizione"><?php echo htmlspecialchars($abbonamento['descrizione']); ?></p>
                            <p class="durata"><i class="fas fa-clock"></i> <?php echo $abbonamento['durata_mesi']; ?> mesi</p>
                            <p class="prezzo">€<?php echo number_format($abbonamento['prezzo'], 2); ?></p>
                            
                            <form method="POST">
                                <input type="hidden" name="abbonamento_id" value="<?php echo $abbonamento['id']; ?>">
                                <button type="submit" name="acquista_abbonamento" class="btn-acquista">
                                    Acquista ora
                                </button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <!-- Storico abbonamenti -->
            <section class="storico-abbonamenti">
                <h2>Storico abbonamenti</h2>
                <?php if ($storico && $storico->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Data inizio</th>
                                <th>Data fine</th>
                                <th>Prezzo</th>
                                <th>Stato</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($abb = $storico->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($abb['nome']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($abb['data_inizio'])); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($abb['data_fine'])); ?></td>
                                    <td>€<?php echo number_format($abb['prezzo'], 2); ?></td>
                                    <td>
                                        <?php if (strtotime($abb['data_fine']) >= strtotime('now')): ?>
                                            <span class="badge active">Attivo</span>
                                        <?php else: ?>
                                            <span class="badge expired">Scaduto</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">Nessun abbonamento nel tuo storico.</div>
                <?php endif; ?>
            </section>

            <!-- FAQ -->
            <section class="faq">
                <h2>Domande frequenti</h2>
                <div class="faq-item">
                    <h3>Come posso rinnovare il mio abbonamento?</h3>
                    <p>Puoi rinnovare il tuo abbonamento in qualsiasi momento, ma il nuovo periodo inizierà solo dopo la scadenza dell'abbonamento attuale.</p>
                </div>
                <div class="faq-item">
                    <h3>Posso cambiare tipo di abbonamento?</h3>
                    <p>Per cambiare il tipo di abbonamento prima della scadenza, contatta la reception della palestra.</p>
                </div>
                <div class="faq-item">
                    <h3>Posso sospendere il mio abbonamento?</h3>
                    <p>In casi particolari (malattia, infortunio) è possibile sospendere l'abbonamento presentando un certificato medico alla reception.</p>
                </div>
                <div class="faq-item">
                    <h3>È possibile richiedere un rimborso?</h3>
                    <p>I rimborsi sono valutati caso per caso. Contatta la reception per maggiori informazioni.</p>
                </div>
            </section>
        </div>
    </main>
</div>
</body>
</html>