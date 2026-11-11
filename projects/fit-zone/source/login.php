<?php
// Avvia la sessione
session_start();
// Se l'utente è già loggato, reindirizzalo in base al ruolo
if(isset($_SESSION['user_id'])) {
    if($_SESSION['user_role'] == 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
    exit;
}
require_once __DIR__ . '/db_config.php';
$error = ''; // Inizializza la variabile di errore
// Processo del form di login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    
    // Login normale per gli altri utenti
    $stmt = $conn->prepare("SELECT id, nome, email, password, ruolo FROM utenti WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verifica la password
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            // Password corretta, crea la sessione
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nome'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['ruolo'];
            
            // Reindirizza in base al ruolo
            if($user['ruolo'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            // Password errata
            $error = "Email o password non validi.";
        }
    } else {
        // L'utente non esiste
        $error = "Email o password non validi.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FitZone</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="login-page">
    <div class="auth-container">
        <h2>Accedi</h2>
        <?php if($error != ''): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Non hai un account? <a href="register.php">Registrati</a></p>
        <p><a href="index.php">Torna alla home</a></p>
    </div>
</body>
</html>