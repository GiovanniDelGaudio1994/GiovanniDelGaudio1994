<?php
// Inizia la sessione
session_start();

// Controlla se l'utente è loggato come admin - CORRETTO
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    // Reindirizza alla pagina di login
    header("Location: login.php");
    exit;
}

// Il resto del tuo codice rimane invariato...

//  connessione al database con mysqli
include 'db_config.php';

// Rimozioni amministrative: solo POST con token antiforgery.
if (!isset($_SESSION['fitzone_csrf_token'])) {
    $_SESSION['fitzone_csrf_token'] = bin2hex(random_bytes(32));
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) &&
    in_array($_POST['action'], ['delete_user', 'delete_trainer'], true) &&
    !hash_equals($_SESSION['fitzone_csrf_token'], (string)($_POST['csrf_token'] ?? ''))) {
    http_response_code(403);
    exit('Richiesta non autorizzata.');
}
// Operazioni per utenti
if($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_user' && isset($_POST['id'])) {
    $user_id = (int)$_POST['id'];
    $query = "DELETE FROM utenti WHERE id = ? AND ruolo != 'admin'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    if($stmt->affected_rows > 0) {
        $success_message = "Utente eliminato con successo";
    } else {
        $error_message = "Impossibile eliminare l'utente";
    }
    $stmt->close();
}

if(isset($_POST['update_course'])) {
    $id = intval($_POST['id']);
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $categoria_id = intval($_POST['categoria_id']);
    $istruttore = $_POST['istruttore'];
    $max_partecipanti = intval($_POST['max_partecipanti']);
    $immagine = $_POST['immagine'];
    
    $query = "UPDATE corsi SET nome = ?, descrizione = ?, categoria_id = ?, istruttore = ?, 
              max_partecipanti = ?, immagine = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssissii", $nome, $descrizione, $categoria_id, $istruttore, $max_partecipanti, $immagine, $id);
    $stmt->execute();
    
    if($stmt->affected_rows > 0) {
        $success_message = "Corso aggiornato con successo";
    } else {
        $error_message = "Nessuna modifica effettuata al corso";
    }
    $stmt->close();
}

// Operazioni per istruttori
if(isset($_POST['add_trainer'])) {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $specializzazione = $_POST['specializzazione'];
    $descrizione = $_POST['descrizione'];
    $immagine = $_POST['immagine'];
    
    $query = "INSERT INTO istruttori (nome, cognome, email, telefono, specializzazione, descrizione, immagine) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $nome, $cognome, $email, $telefono, $specializzazione, $descrizione, $immagine);
    $stmt->execute();
    
    if($stmt->affected_rows > 0) {
        $success_message = "Istruttore aggiunto con successo";
    } else {
        $error_message = "Impossibile aggiungere l'istruttore";
    }
    $stmt->close();
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_trainer' && isset($_POST['id'])) {
    $trainer_id = (int)$_POST['id'];
    $query = "DELETE FROM istruttori WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $trainer_id);
    $stmt->execute();
    
    if($stmt->affected_rows > 0) {
        $success_message = "Istruttore eliminato con successo";
    } else {
        $error_message = "Impossibile eliminare l'istruttore";
    }
    $stmt->close();
}

// Recupera le categorie dei corsi per i form
$categorie = [];
$query = "SELECT id, nome FROM categorie_corsi";
$result = $conn->query($query);
if($result) {
    while($row = $result->fetch_assoc()) {
        $categorie[] = $row;
    }
}

// Determina quale tab visualizzare
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'utenti';

// Se viene richiesto un corso da modificare
$edit_course = null;
if(isset($_GET['action']) && $_GET['action'] == 'edit_course' && isset($_GET['id'])) {
    $course_id = intval($_GET['id']);
    $query = "SELECT * FROM corsi WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_course = $result->fetch_assoc();
    $stmt->close();
    $active_tab = 'corsi';
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone - Pannello Amministratore</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>FitZone - Pannello Amministratore</h1>
            <div class="user-info">
                <span>Admin</span>
                <a href="logout.php" class="btn btn-logout">Logout</a>
            </div>
        </header>
        
        <div class="admin-content">
            <nav class="admin-nav">
                <ul>
                    <li><a href="?tab=utenti" class="<?php echo $active_tab == 'utenti' ? 'active' : ''; ?>">Gestione Utenti</a></li>
                    <li><a href="?tab=corsi" class="<?php echo $active_tab == 'corsi' ? 'active' : ''; ?>">Gestione Corsi</a></li>
                    <li><a href="?tab=abbonamenti" class="<?php echo $active_tab == 'abbonamenti' ? 'active' : ''; ?>">Abbonamenti Attivi</a></li>
                    <li><a href="?tab=istruttori" class="<?php echo $active_tab == 'istruttori' ? 'active' : ''; ?>">Personal Trainer</a></li>
                </ul>
            </nav>
            
            <main class="admin-main">
                <?php if(isset($success_message)): ?>
                <div class="alert success">
                    <?php echo $success_message; ?>
                </div>
                <?php endif; ?>
                
                <?php if(isset($error_message)): ?>
                <div class="alert error">
                    <?php echo $error_message; ?>
                </div>
                <?php endif; ?>
                
                <!-- TAB UTENTI -->
                <?php if($active_tab == 'utenti'): ?>
                    <section class="admin-section">
                        <h2>Gestione Utenti</h2>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Cognome</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Data Registrazione</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM utenti WHERE ruolo = 'utente' ORDER BY id DESC";
                                $result = $conn->query($query);
                                if($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$row['id']."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['nome'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['cognome'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['email'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['telefono'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['data_registrazione'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td><form method='POST' onsubmit='return confirm(\"Eliminare questo utente?\")'>";
                                        echo "<input type='hidden' name='action' value='delete_user'><input type='hidden' name='id' value='".(int)$row['id']."'>";
                                        echo "<input type='hidden' name='csrf_token' value='".htmlspecialchars($_SESSION['fitzone_csrf_token'], ENT_QUOTES, 'UTF-8')."'>";
                                        echo "<button type='submit' class='btn btn-delete'>Elimina</button></form></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>Nessun utente trovato</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </section>
                <?php endif; ?>
                
                <!-- TAB CORSI -->
                <?php if($active_tab == 'corsi'): ?>
                    <section class="admin-section">
                        <h2><?php echo $edit_course ? 'Modifica Corso' : 'Aggiungi Nuovo Corso'; ?></h2>
                        <form class="admin-form" method="post" action="admin.php?tab=corsi">
                            <?php if($edit_course): ?>
                                <input type="hidden" name="id" value="<?php echo $edit_course['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <label for="nome">Nome del Corso:</label>
                                <input type="text" id="nome" name="nome" value="<?php echo $edit_course ? $edit_course['nome'] : ''; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="descrizione">Descrizione:</label>
                                <textarea id="descrizione" name="descrizione" rows="4" required><?php echo $edit_course ? $edit_course['descrizione'] : ''; ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="categoria_id">Categoria:</label>
                                <select id="categoria_id" name="categoria_id" required>
                                    <?php foreach($categorie as $categoria): ?>
                                        <option value="<?php echo $categoria['id']; ?>" <?php echo ($edit_course && $edit_course['categoria_id'] == $categoria['id']) ? 'selected' : ''; ?>>
                                            <?php echo $categoria['nome']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="istruttore">Istruttore:</label>
                                <input type="text" id="istruttore" name="istruttore" value="<?php echo $edit_course ? $edit_course['istruttore'] : ''; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="max_partecipanti">Max Partecipanti:</label>
                                <input type="number" id="max_partecipanti" name="max_partecipanti" value="<?php echo $edit_course ? $edit_course['max_partecipanti'] : ''; ?>" min="1" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="immagine">Percorso Immagine:</label>
                                <input type="text" id="immagine" name="immagine" value="<?php echo $edit_course ? $edit_course['immagine'] : ''; ?>">
                            </div>
                            
                            <div class="form-actions">
                                <?php if($edit_course): ?>
                                    <button type="submit" name="update_course" class="btn btn-primary">Aggiorna Corso</button>
                                    <a href="?tab=corsi" class="btn">Annulla</a>
                                <?php else: ?>
                                    <button type="submit" name="add_course" class="btn btn-primary">Aggiungi Corso</button>
                                <?php endif; ?>
                            </div>
                        </form>
                        
                        <h2 class="mt-4">Corsi Disponibili</h2>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Categoria</th>
                                    <th>Istruttore</th>
                                    <th>Max Partecipanti</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT c.*, cc.nome as categoria_nome FROM corsi c 
                                         JOIN categorie_corsi cc ON c.categoria_id = cc.id 
                                         ORDER BY c.id DESC";
                                $result = $conn->query($query);
                                if($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$row['id']."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['nome'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td>".$row['categoria_nome']."</td>";
                                        echo "<td>".$row['istruttore']."</td>";
                                        echo "<td>".$row['max_partecipanti']."</td>";
                                        echo "<td class='action-buttons'>
                                                <a href='?tab=corsi&action=edit_course&id=".$row['id']."' class='btn btn-edit'>Modifica</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>Nessun corso trovato</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </section>
                <?php endif; ?>
                
                <!-- TAB ABBONAMENTI -->
                <?php if($active_tab == 'abbonamenti'): ?>
                    <section class="admin-section">
                        <h2>Abbonamenti Attivi</h2>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Utente</th>
                                    <th>Tipo Abbonamento</th>
                                    <th>Data Inizio</th>
                                    <th>Data Fine</th>
                                    <th>Data Pagamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $today = date('Y-m-d');
                                $query = "SELECT a.*, u.nome, u.cognome, u.email, t.nome as tipo_nome 
                                         FROM abbonamenti a
                                         JOIN utenti u ON a.utente_id = u.id
                                         JOIN tipi_abbonamento t ON a.tipo_id = t.id
                                         WHERE a.data_fine >= '$today'
                                         ORDER BY a.data_fine ASC";
                                $result = $conn->query($query);
                                if($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$row['id']."</td>";
                                        echo "<td>".$row['nome']." ".$row['cognome']." (".$row['email'].")</td>";
                                        echo "<td>".$row['tipo_nome']."</td>";
                                        echo "<td>".$row['data_inizio']."</td>";
                                        echo "<td>".$row['data_fine']."</td>";
                                        echo "<td>".$row['data_pagamento']."</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>Nessun abbonamento attivo trovato</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </section>
                <?php endif; ?>
                
                <!-- TAB ISTRUTTORI/PERSONAL TRAINER -->
                <?php if($active_tab == 'istruttori'): ?>
                    <section class="admin-section">
                        <h2>Aggiungi Nuovo Personal Trainer</h2>
                        <form class="admin-form" method="post" action="admin.php?tab=istruttori">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" id="nome" name="nome" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="cognome">Cognome:</label>
                                <input type="text" id="cognome" name="cognome" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="telefono">Telefono:</label>
                                <input type="text" id="telefono" name="telefono">
                            </div>
                            
                            <div class="form-group">
                                <label for="specializzazione">Specializzazione:</label>
                                <input type="text" id="specializzazione" name="specializzazione" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="descrizione">Descrizione:</label>
                                <textarea id="descrizione" name="descrizione" rows="4"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="immagine">Percorso Immagine:</label>
                                <input type="text" id="immagine" name="immagine">
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" name="add_trainer" class="btn btn-primary">Aggiungi Trainer</button>
                            </div>
                        </form>
                        
                        <h2 class="mt-4">Personal Trainer Disponibili</h2>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Cognome</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Specializzazione</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM istruttori ORDER BY id DESC";
                                $result = $conn->query($query);
                                if($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$row['id']."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['nome'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['cognome'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['email'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['telefono'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td>".htmlspecialchars((string)$row['specializzazione'], ENT_QUOTES, 'UTF-8')."</td>";
                                        echo "<td><form method='POST' onsubmit='return confirm(\"Eliminare questo trainer?\")'>";
                                        echo "<input type='hidden' name='action' value='delete_trainer'><input type='hidden' name='id' value='".(int)$row['id']."'>";
                                        echo "<input type='hidden' name='csrf_token' value='".htmlspecialchars($_SESSION['fitzone_csrf_token'], ENT_QUOTES, 'UTF-8')."'>";
                                        echo "<button type='submit' class='btn btn-delete'>Elimina</button></form></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>Nessun trainer trovato</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </section>
                <?php endif; ?>
            </main>
        </div>
        
        <footer class="admin-footer">
            <p>&copy; 2025 FitZone - Tutti i diritti riservati</p>
        </footer>
    </div>
</body>
</html>