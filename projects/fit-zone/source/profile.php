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

// Aggiorna profilo
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
    $nome = $db->real_escape_string($_POST['nome']);
    $email = $db->real_escape_string($_POST['email']);
    $telefono = $db->real_escape_string($_POST['telefono']);

    if (!empty($_FILES['foto']['name'])) {
        $error = "Caricamento foto disabilitato in questa versione dimostrativa per sicurezza.";
    } else {
        $stmt = $db->prepare("UPDATE utenti SET nome = ?, email = ?, telefono = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nome, $email, $telefono, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    if (!$error) {
        $_SESSION['user_name'] = $nome;
        $success = "Profilo aggiornato con successo.";
    }
}

// Cambia password
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['change_password'])) {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    $result = $db->query("SELECT password FROM utenti WHERE id = $user_id");
    $user = $result->fetch_assoc();

    if (!password_verify($old_pass, $user['password'])) {
        $error = "La vecchia password non è corretta.";
    } elseif ($new_pass !== $confirm_pass) {
        $error = "Le nuove password non corrispondono.";
    } else {
        $hashed_new = password_hash($new_pass, PASSWORD_DEFAULT);
        $db->query("UPDATE utenti SET password = '$hashed_new' WHERE id = $user_id");
        $success = "Password aggiornata con successo.";
    }
}

// Recupera dati utente
$result = $db->query("SELECT nome, email, telefono, foto_profilo FROM utenti WHERE id = $user_id");
$utente = $result->fetch_assoc();

$db->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo Utente</title>
    <link rel="stylesheet" href="css/profile.css">
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
            <li><a class="active" href="profile.php"><i class="fas fa-user"></i> Profilo</a></li>
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
            <h1>Il tuo Profilo</h1>

            <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
            <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="update_profile" value="1">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($utente['nome'] ?? ''); ?>" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($utente['email'] ?? ''); ?>" required>

                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" id="telefono" value="<?php echo htmlspecialchars($utente['telefono'] ?? ''); ?>">

                <label for="foto">Foto Profilo</label>
                <?php if (!empty($utente['foto_profilo'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($utente['foto_profilo']); ?>" class="profile-img" alt="Foto Profilo">
                <?php endif; ?>
                <input type="file" name="foto" id="foto" disabled title="Caricamento disabilitato nella versione pubblica">
                <img id="preview" class="preview-img" style="display:none;">

                <button type="submit">Salva Modifiche</button>
            </form>

            <form method="POST" class="password-form">
                <input type="hidden" name="change_password" value="1">
                <h2>Cambia Password</h2>
                <label for="old_password">Vecchia Password</label>
                <input type="password" name="old_password" id="old_password" required>

                <label for="new_password">Nuova Password</label>
                <input type="password" name="new_password" id="new_password" required minlength="6">

                <label for="confirm_password">Conferma Nuova Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required minlength="6">

                <button type="submit">Aggiorna Password</button>
            </form>

            <div class="card-accesso">
                <h2>Badge Accesso Palestra</h2>
                <div class="badge">
                    <?php if (!empty($utente['foto_profilo'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($utente['foto_profilo']); ?>" class="badge-img" alt="Foto">
                    <?php endif; ?>
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($utente['nome']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($utente['email']); ?></p>
                    <p><strong>Telefono:</strong> <?php echo htmlspecialchars($utente['telefono']); ?></p>
                    <p><strong>ID Utente:</strong> <?php echo $user_id; ?></p>
                    <div id="qrcode"></div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
    const hamburger = document.querySelector('.hamburger');
    const closeSidebar = document.querySelector('.close-sidebar');
    const sidebar = document.querySelector('.sidebar');

    hamburger.addEventListener('click', () => {
    sidebar.classList.add('open');
});

closeSidebar.addEventListener('click', () => {
    sidebar.classList.remove('open');
});
    // Chiudi la sidebar se l'utente clicca al di fuori di essa
    document.addEventListener('click', (event) => {
        if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
            sidebar.classList.remove('open');
        }
    });
    // Chiudi la sidebar se l'utente ridimensiona la finestra
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
        }
    });
    // Mostra l'icona del menu hamburger se la larghezza della finestra è inferiore a 768px
    if (window.innerWidth <= 768) {
        hamburger.style.display = 'block';
    } else {
        hamburger.style.display = 'none';
    }
    // Mostra l'icona del menu hamburger se la larghezza della finestra è inferiore a 768px
    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) {
            hamburger.style.display = 'block';
        } else {
            hamburger.style.display = 'none';
        }
    });

    // Anteprima immagine
    const fotoInput = document.getElementById('foto');
    const preview = document.getElementById('preview');

    fotoInput.addEventListener('change', function () {
        const file = this.files[0];//array di file list parte dalla cella 0
        if (file) {
            const reader = new FileReader();//crea un oggetto file reader
            reader.onload = function (e) {//quando il file è caricato
                // Imposta l'anteprima dell'immagine
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

</script>

</body>
</html>
