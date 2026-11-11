<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/db_config.php';
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim((string)($_POST['nome'] ?? ''));
    $cognome = trim((string)($_POST['cognome'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $telefono = trim((string)($_POST['telefono'] ?? ''));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validazione numero di telefono (solo cifre, tra 8 e 15 numeri)
    if (!preg_match('/^\d{8,15}$/', $telefono)) {
        $error = "Inserisci un numero di telefono valido (solo cifre, da 8 a 15 numeri).";
    } elseif ($password !== $confirm_password) {
        $error = "Le password non corrispondono.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM utenti WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "L'email è già registrata. Prova ad accedere.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);//crittografia della passsword a 256 bit
            // Inserimento utente nel database
            // Assicurati di avere una tabella 'utenti' con le colonne appropriate  
            $stmt = $conn->prepare("INSERT INTO utenti (nome, email, telefono, password, data_registrazione, ruolo, cognome) VALUES (?, ?, ?, ?, NOW(), 'utente', ?)");
            $stmt->bind_param('sssss', $nome, $email, $telefono, $hashed_password, $cognome);

            if ($stmt->execute()) {
                $success = "Registrazione completata con successo! Puoi ora effettuare il login.";
                header("refresh:2;url=login.php");
            } else {
                $error = "Errore durante la registrazione: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrazione - FitZone</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="auth-bg">
  <div class="auth-container">
    <h2>Registrati</h2>
    <?php if ($error): ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <input type="text" name="nome" placeholder="Nome completo" required>
      <input type="text" name="cognome" placeholder="Cognome" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="telefono" placeholder="Telefono" required pattern="\d{8,15}" title="Solo cifre da 8 a 15">
      <input type="password" name="password" placeholder="Password" required minlength="6">
      <input type="password" name="confirm_password" placeholder="Conferma Password" required minlength="6">
      <button type="submit">Registrati</button>
    </form>
    <p>Hai già un account? <a href="login.php">Accedi</a></p>
    <p><a href="index.php">Torna alla home</a></p>
  </div>
</body>
</html>
