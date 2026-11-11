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

// Recupera i corsi dal database (useremo questi come attività)
$sql = "SELECT c.*, cc.nome as categoria_nome 
        FROM corsi c 
        JOIN categorie_corsi cc ON c.categoria_id = cc.id 
        ORDER BY c.nome ASC";
$corsi = $db->query($sql);

// Recupera le categorie per i filtri
$categorie = $db->query("SELECT * FROM categorie_corsi ORDER BY nome ASC");

// Recupera le sessioni future dei corsi
$sessioni_future = $db->query("SELECT sc.*, c.nome as corso_nome, c.istruttore 
                              FROM sessioni_corsi sc 
                              JOIN corsi c ON sc.corso_id = c.id 
                              WHERE sc.data_ora > NOW() 
                              ORDER BY sc.data_ora ASC 
                              LIMIT 10");

// Recupera le FAQ relative ai corsi/attività
$faq_query = $db->query("SELECT * FROM faq WHERE domanda LIKE '%corso%' OR domanda LIKE '%attività%' ORDER BY ordine ASC LIMIT 4");
$faqs = [];
if ($faq_query && $faq_query->num_rows > 0) {
    while ($row = $faq_query->fetch_assoc()) {
        $faqs[] = $row;
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attività - FitZone</title>
    <link rel="stylesheet" href="css/attivita.css">
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
            <li><a class="active" href="attivita.php"><i class="fas fa-running"></i> Attività</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profilo</a></li>
            <li><a href="abbonamenti.php"><i class="fas fa-id-card"></i> Abbonamenti</a></li>
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
            <h1>Attività e Eventi</h1>
            
            <!-- Banner promozionale -->
            <section class="promo-banner">
                <h2>Scopri le nostre attività</h2>
                <p>Esplora tutti i corsi, workshop e attività speciali organizzati da FitZone</p>
            </section>

            <!-- Filtri per categoria -->
            <section class="filtri-container">
                <h2>Filtra per categoria</h2>
                <form method="GET" action="attivita.php" class="filtri-form">
                    <div class="filtri-grid">
                        <div class="filtro">
                            <input type="radio" id="tutte" name="categoria" value="tutte" <?php echo (!isset($_GET['categoria']) || $_GET['categoria'] == 'tutte') ? 'checked' : ''; ?>>
                            <label for="tutte">Tutte</label>
                        </div>
                        
                        <?php if ($categorie && $categorie->num_rows > 0): ?>
                            <?php while ($cat = $categorie->fetch_assoc()): ?>
                                <div class="filtro">
                                    <input type="radio" id="<?php echo htmlspecialchars($cat['id']); ?>" 
                                           name="categoria" 
                                           value="<?php echo htmlspecialchars($cat['id']); ?>"
                                           <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id']) ? 'checked' : ''; ?>>
                                    <label for="<?php echo htmlspecialchars($cat['id']); ?>">
                                        <?php echo htmlspecialchars(ucfirst($cat['nome'])); ?>
                                    </label>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" class="btn-filtro">Applica filtri</button>
                </form>
            </section>

            <!-- Lista attività (corsi) -->
            <section class="attivita-lista">
                <?php 
                $categoria_filtro = isset($_GET['categoria']) && $_GET['categoria'] != 'tutte' ? $_GET['categoria'] : null;
                
                if ($corsi && $corsi->num_rows > 0): 
                    $trovato = false;
                ?>
                    <div class="attivita-grid">
                        <?php while ($corso = $corsi->fetch_assoc()): 
                            // Applica il filtro se selezionato
                            if ($categoria_filtro && $corso['categoria_id'] != $categoria_filtro) {
                                continue;
                            }
                            $trovato = true;
                        ?>
                            <div class="attivita-card">
                                <?php if (!empty($corso['immagine'])): ?>
                                    <div class="attivita-img">
                                        <img src="<?php echo htmlspecialchars($corso['immagine']); ?>" alt="<?php echo htmlspecialchars($corso['nome']); ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="attivita-img">
                                        <img src="images/placeholder.svg" alt="<?php echo htmlspecialchars($corso['nome']); ?>">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="attivita-info">
                                    <h3><?php echo htmlspecialchars($corso['nome']); ?></h3>
                                    
                                    <div class="attivita-meta">
                                        <span class="categoria">
                                            <i class="fas fa-tag"></i> 
                                            <?php echo htmlspecialchars(ucfirst($corso['categoria_nome'])); ?>
                                        </span>
                                        
                                        <span class="istruttore">
                                            <i class="fas fa-user"></i> 
                                            <?php echo htmlspecialchars($corso['istruttore']); ?>
                                        </span>
                                        
                                        <span class="partecipanti">
                                            <i class="fas fa-users"></i> 
                                            Max <?php echo $corso['max_partecipanti']; ?> partecipanti
                                        </span>
                                    </div>
                                    
                                    <p class="descrizione"><?php echo htmlspecialchars($corso['descrizione']); ?></p>
                                    
                                    <div class="attivita-footer">
                                        <a href="dettaglio-corso.php?id=<?php echo $corso['id']; ?>" class="btn-dettaglio">
                                            Dettagli
                                        </a>
                                        
                                        <a href="prenota-corso.php?id=<?php echo $corso['id']; ?>" class="btn-prenota">
                                            Prenota
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    
                    <?php if (!$trovato): ?>
                        <div class="no-results">
                            <p>Nessuna attività trovata per la categoria selezionata.</p>
                        </div>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <div class="no-results">
                        <p>Non ci sono attività disponibili al momento.</p>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Prossime sessioni -->
            <section class="calendario-eventi">
                <h2>Prossimi eventi</h2>
                <p>Le prossime sessioni in programma:</p>
                
                <?php if ($sessioni_future && $sessioni_future->num_rows > 0): ?>
                    <div class="prossimi-eventi">
                        <?php while ($sessione = $sessioni_future->fetch_assoc()): ?>
                            <div class="evento-item">
                                <div class="evento-data">
                                    <?php 
                                    $data = new DateTime($sessione['data_ora']);
                                    echo $data->format('d/m/Y'); 
                                    ?>
                                </div>
                                <div class="evento-ora">
                                    <?php echo $data->format('H:i'); ?>
                                </div>
                                <div class="evento-dettagli">
                                    <h3><?php echo htmlspecialchars($sessione['corso_nome']); ?></h3>
                                    <p>Istruttore: <?php echo htmlspecialchars($sessione['istruttore']); ?></p>
                                    <p>Durata: <?php echo $sessione['durata_minuti']; ?> minuti</p>
                                </div>
                                <a href="prenota-sessione.php?id=<?php echo $sessione['id']; ?>" class="btn-prenota">Prenota</a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="no-results">
                        <p>Non ci sono sessioni programmate per i prossimi giorni.</p>
                    </div>
                <?php endif; ?>
                
                <a href="calendario.php" class="btn-calendario">Visualizza calendario completo</a>
            </section>

            <!-- FAQ -->
            <section class="faq">
                <h2>Domande frequenti</h2>
                
                <?php if (!empty($faqs)): ?>
                    <?php foreach($faqs as $faq): ?>
                        <div class="faq-item">
                            <h3><?php echo htmlspecialchars($faq['domanda']); ?></h3>
                            <p><?php echo htmlspecialchars($faq['risposta']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="faq-item">
                        <h3>Come posso prenotare un'attività?</h3>
                        <p>Puoi prenotare direttamente dalla pagina dell'attività cliccando sul pulsante "Prenota".</p>
                    </div>
                    <div class="faq-item">
                        <h3>Posso annullare una prenotazione?</h3>
                        <p>Sì, puoi annullare la prenotazione fino a 24 ore prima dell'inizio dell'attività.</p>
                    </div>
                    <div class="faq-item">
                        <h3>Le attività sono incluse nell'abbonamento?</h3>
                        <p>La maggior parte delle attività sono incluse nell'abbonamento. Eventuali costi aggiuntivi sono indicati nella descrizione dell'attività.</p>
                    </div>
                    <div class="faq-item">
                        <h3>Posso partecipare a un'attività senza prenotazione?</h3>
                        <p>È consigliabile prenotare in anticipo per garantirti un posto. Alcune attività hanno posti limitati.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
</div>
</body>
</html>