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

// Per filtrare per mese
$mese_corrente = isset($_GET['mese']) ? intval($_GET['mese']) : intval(date('m'));
$anno_corrente = isset($_GET['anno']) ? intval($_GET['anno']) : intval(date('Y'));

// Validazione dei parametri
if ($mese_corrente < 1 || $mese_corrente > 12) {
    $mese_corrente = intval(date('m'));
}
if ($anno_corrente < 2020 || $anno_corrente > 2030) {
    $anno_corrente = intval(date('Y'));
}

// Nome del mese in italiano
$nomi_mesi = [
    1 => 'Gennaio', 2 => 'Febbraio', 3 => 'Marzo', 4 => 'Aprile',
    5 => 'Maggio', 6 => 'Giugno', 7 => 'Luglio', 8 => 'Agosto',
    9 => 'Settembre', 10 => 'Ottobre', 11 => 'Novembre', 12 => 'Dicembre'
];

// Calcola il mese precedente e successivo
$mese_precedente = $mese_corrente - 1;
$anno_precedente = $anno_corrente;
if ($mese_precedente < 1) {
    $mese_precedente = 12;
    $anno_precedente--;
}

$mese_successivo = $mese_corrente + 1;
$anno_successivo = $anno_corrente;
if ($mese_successivo > 12) {
    $mese_successivo = 1;
    $anno_successivo++;
}

// Recupera le sessioni del mese selezionato
$primo_giorno_mese = sprintf("%04d-%02d-01", $anno_corrente, $mese_corrente);
$ultimo_giorno_mese = date('Y-m-t', strtotime($primo_giorno_mese));

$sql = "SELECT sc.*, c.nome as corso_nome, c.istruttore, cc.nome as categoria_nome, c.immagine
        FROM sessioni_corsi sc 
        JOIN corsi c ON sc.corso_id = c.id 
        JOIN categorie_corsi cc ON c.categoria_id = cc.id
        WHERE sc.data_ora BETWEEN '$primo_giorno_mese 00:00:00' AND '$ultimo_giorno_mese 23:59:59'
        ORDER BY sc.data_ora ASC";
$sessioni = $db->query($sql);

// Organizzare le sessioni per giorno
$calendario = [];
if ($sessioni && $sessioni->num_rows > 0) {
    while ($sessione = $sessioni->fetch_assoc()) {
        $data = date('Y-m-d', strtotime($sessione['data_ora']));
        $giorno = date('j', strtotime($data));
        if (!isset($calendario[$giorno])) {
            $calendario[$giorno] = [];
        }
        $calendario[$giorno][] = $sessione;
    }
}

// Recupera le categorie per i filtri
$categorie = $db->query("SELECT * FROM categorie_corsi ORDER BY nome ASC");
$cat_array = [];
if ($categorie && $categorie->num_rows > 0) {
    while ($cat = $categorie->fetch_assoc()) {
        $cat_array[] = $cat;
    }
}

$db->close();

// Funzione per ottenere il primo giorno del mese (0 = lunedì, 6 = domenica)
function getFirstDayOfMonth($anno, $mese) {
    $data = new DateTime("$anno-$mese-01");
    return (intval($data->format('N')) - 1); // Converto da 1-7 (lun-dom) a 0-6 (lun-dom)
}

// Numero di giorni nel mese
$giorni_nel_mese = cal_days_in_month(CAL_GREGORIAN, $mese_corrente, $anno_corrente);

// Primo giorno del mese (0 = lunedì, 6 = domenica)
$primo_giorno = getFirstDayOfMonth($anno_corrente, $mese_corrente);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Attività - FitZone</title>
    <link rel="stylesheet" href="css/calendario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="logo">🏋 FitZone</div>
        <ul class="menu">
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="corsi.php"><i class="fas fa-dumbbell"></i> Corsi</a></li>
            <li><a href="istruttori.php"><i class="fas fa-chalkboard-teacher"></i> Istruttori</a></li>
            <li><a href="attivita.php"><i class="fas fa-running"></i> Attività</a></li>
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
            <h1>Calendario Completo</h1>
            
            <!-- Barra di navigazione del calendario -->
            <div class="calendario-nav">
                <a href="?mese=<?php echo $mese_precedente; ?>&anno=<?php echo $anno_precedente; ?>" class="nav-btn">
                    <i class="fas fa-chevron-left"></i> Mese precedente
                </a>
                
                <h2><?php echo $nomi_mesi[$mese_corrente] . ' ' . $anno_corrente; ?></h2>
                
                <a href="?mese=<?php echo $mese_successivo; ?>&anno=<?php echo $anno_successivo; ?>" class="nav-btn">
                    Mese successivo <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            
            <!-- Filtri per categoria -->
            <div class="filtri-container">
                <h3>Filtra per categoria</h3>
                <form method="GET" action="calendario.php" class="filtri-form">
                    <input type="hidden" name="mese" value="<?php echo $mese_corrente; ?>">
                    <input type="hidden" name="anno" value="<?php echo $anno_corrente; ?>">
                    
                    <div class="filtri-grid">
                        <div class="filtro">
                            <input type="radio" id="tutte" name="categoria" value="tutte" <?php echo (!isset($_GET['categoria']) || $_GET['categoria'] == 'tutte') ? 'checked' : ''; ?>>
                            <label for="tutte">Tutte</label>
                        </div>
                        
                        <?php foreach ($cat_array as $cat): ?>
                            <div class="filtro">
                                <input type="radio" id="<?php echo htmlspecialchars($cat['id']); ?>" 
                                       name="categoria" 
                                       value="<?php echo htmlspecialchars($cat['id']); ?>"
                                       <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id']) ? 'checked' : ''; ?>>
                                <label for="<?php echo htmlspecialchars($cat['id']); ?>">
                                    <?php echo htmlspecialchars(ucfirst($cat['nome'])); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <button type="submit" class="btn-filtro">Applica filtri</button>
                </form>
            </div>
            
            <!-- Griglia del calendario -->
            <div class="calendario-grid">
                <!-- Intestazione giorni della settimana -->
                <div class="giorno-header">Lun</div>
                <div class="giorno-header">Mar</div>
                <div class="giorno-header">Mer</div>
                <div class="giorno-header">Gio</div>
                <div class="giorno-header">Ven</div>
                <div class="giorno-header">Sab</div>
                <div class="giorno-header">Dom</div>
                
                <?php
                // Aggiunge celle vuote per i giorni precedenti al primo del mese
                for ($i = 0; $i < $primo_giorno; $i++) {
                    echo '<div class="giorno vuoto"></div>';
                }
                
                // Categoria filtrata
                $categoria_filtro = isset($_GET['categoria']) && $_GET['categoria'] != 'tutte' ? $_GET['categoria'] : null;
                
                // Aggiunge le celle per ogni giorno del mese
                for ($giorno = 1; $giorno <= $giorni_nel_mese; $giorno++) {
                    $oggi = date('j') == $giorno && date('m') == $mese_corrente && date('Y') == $anno_corrente;
                    $classe_giorno = $oggi ? 'giorno oggi' : 'giorno';
                    
                    echo "<div class=\"$classe_giorno\">";
                    echo "<div class=\"numero-giorno\">$giorno</div>";
                    
                    // Mostra le sessioni per questo giorno
                    if (isset($calendario[$giorno])) {
                        echo "<div class=\"sessioni-giorno\">";
                        
                        foreach ($calendario[$giorno] as $sessione) {
                            // Applica il filtro se selezionato
                            if ($categoria_filtro) {
                                $corso_sql = "SELECT categoria_id FROM corsi WHERE id = " . $sessione['corso_id'];
                                $corso_result = $db->query($corso_sql);
                                if ($corso_result && $corso_result->num_rows > 0) {
                                    $corso = $corso_result->fetch_assoc();
                                    if ($corso['categoria_id'] != $categoria_filtro) {
                                        continue;
                                    }
                                }
                            }
                            
                            $ora = date('H:i', strtotime($sessione['data_ora']));
                            echo "<div class=\"sessione-item\">";
                            echo "<span class=\"sessione-ora\">$ora</span>";
                            echo "<span class=\"sessione-nome\">" . htmlspecialchars($sessione['corso_nome']) . "</span>";
                            echo "<a href=\"prenota-sessione.php?id=" . $sessione['id'] . "\" class=\"btn-prenota-mini\">Prenota</a>";
                            echo "</div>";
                        }
                        
                        echo "</div>";
                    }
                    
                    echo "</div>";
                }
                
                // Aggiunge celle vuote per completare l'ultima riga del calendario
                $celle_totali = $primo_giorno + $giorni_nel_mese;
                $celle_mancanti = 7 - ($celle_totali % 7);
                if ($celle_mancanti < 7) {
                    for ($i = 0; $i < $celle_mancanti; $i++) {
                        echo '<div class="giorno vuoto"></div>';
                    }
                }
                ?>
            </div>
            
            <!-- Legenda -->
            <div class="legenda">
                <div class="legenda-item">
                    <div class="legenda-colore oggi-colore"></div>
                    <div class="legenda-testo">Oggi</div>
                </div>
                <div class="legenda-item">
                    <div class="legenda-colore sessione-colore"></div>
                    <div class="legenda-testo">Sessione disponibile</div>
                </div>
            </div>
            
            <!-- Lista dettagliata delle sessioni del mese -->
            <section class="lista-sessioni">
                <h2>Sessioni di <?php echo $nomi_mesi[$mese_corrente]; ?></h2>
                
                <?php
                // Reset dei risultati per usarli di nuovo
                $db = $conn;
                $sessioni = $db->query($sql);
                
                if ($sessioni && $sessioni->num_rows > 0):
                    // Raggruppa sessioni per giorno
                    $sessioni_per_giorno = [];
                    while ($sessione = $sessioni->fetch_assoc()) {
                        // Applica il filtro se selezionato
                        if ($categoria_filtro && $sessione['categoria_id'] != $categoria_filtro) {
                            continue;
                        }
                        
                        $data = date('Y-m-d', strtotime($sessione['data_ora']));
                        if (!isset($sessioni_per_giorno[$data])) {
                            $sessioni_per_giorno[$data] = [];
                        }
                        $sessioni_per_giorno[$data][] = $sessione;
                    }
                    
                    // Mostra sessioni raggruppate per giorno
                    foreach ($sessioni_per_giorno as $data => $sessioni_giorno):
                        $giorno_settimana = date('l', strtotime($data));
                        $giorno_nome_ita = [
                            'Monday' => 'Lunedì',
                            'Tuesday' => 'Martedì',
                            'Wednesday' => 'Mercoledì',
                            'Thursday' => 'Giovedì',
                            'Friday' => 'Venerdì',
                            'Saturday' => 'Sabato',
                            'Sunday' => 'Domenica'
                        ];
                ?>
                    <div class="giorno-sessioni">
                        <h3><?php echo $giorno_nome_ita[$giorno_settimana] . ' ' . date('d/m/Y', strtotime($data)); ?></h3>
                        
                        <div class="sessioni-lista">
                            <?php foreach ($sessioni_giorno as $sessione): ?>
                                <div class="sessione-card">
                                    <?php if (!empty($sessione['immagine'])): ?>
                                        <div class="sessione-img">
                                            <img src="<?php echo htmlspecialchars($sessione['immagine']); ?>" alt="<?php echo htmlspecialchars($sessione['corso_nome']); ?>">
                                        </div>
                                    <?php else: ?>
                                        <div class="sessione-img">
                                            <img src="images/placeholder.svg" alt="<?php echo htmlspecialchars($sessione['corso_nome']); ?>">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="sessione-info">
                                        <h4><?php echo htmlspecialchars($sessione['corso_nome']); ?></h4>
                                        
                                        <div class="sessione-meta">
                                            <span class="ora">
                                                <i class="fas fa-clock"></i> 
                                                <?php echo date('H:i', strtotime($sessione['data_ora'])); ?>
                                            </span>
                                            
                                            <span class="durata">
                                                <i class="fas fa-hourglass-half"></i> 
                                                <?php echo $sessione['durata_minuti']; ?> min
                                            </span>
                                            
                                            <span class="istruttore">
                                                <i class="fas fa-user"></i> 
                                                <?php echo htmlspecialchars($sessione['istruttore']); ?>
                                            </span>
                                            
                                            <span class="categoria">
                                                <i class="fas fa-tag"></i> 
                                                <?php echo htmlspecialchars(ucfirst($sessione['categoria_nome'])); ?>
                                            </span>
                                        </div>
                                        
                                        <div class="sessione-azioni">
                                            <a href="dettaglio-corso.php?id=<?php echo $sessione['corso_id']; ?>" class="btn-dettaglio">
                                                Dettagli
                                            </a>
                                            
                                            <a href="prenota-sessione.php?id=<?php echo $sessione['id']; ?>" class="btn-prenota">
                                                Prenota
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php 
                    endforeach;
                else: 
                ?>
                    <div class="no-results">
                        <p>Non ci sono sessioni programmate per questo mese.</p>
                    </div>
                <?php endif; ?>
            </section>
            
            <!-- Pulsante per tornare alle attività -->
            <div class="azioni-footer">
                <a href="attivita.php" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Torna alle attività
                </a>
            </div>
        </div>
    </main>
</div>
</body> 
</html>