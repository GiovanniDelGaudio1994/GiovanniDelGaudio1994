<?php
session_start();
require_once 'db_config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT nome, descrizione, istruttore, immagine FROM corsi";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corsi</title>

    <link rel="stylesheet" href="css/corsi.css">
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
                <li><a href="corsi.php" class="active"><i class="fas fa-dumbbell"></i> Corsi</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Esci</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h1>Corsi disponibili</h1>
            <div class="corsi-list">
                <?php if($result && $result->num_rows > 0): ?>
                    <?php while($corso = $result->fetch_assoc()): ?>
                        <div class="corso">
                            <?php if (!empty($corso['immagine'])): ?>
                                <img src="<?php echo htmlspecialchars($corso['immagine']); ?>" alt="<?php echo htmlspecialchars($corso['nome']); ?>" class="corso-img">
                            <?php else: ?>
                                <div class="corso-img-placeholder">
                                    <i class="fas fa-dumbbell"></i>
                                </div>
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($corso['nome']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($corso['descrizione'])); ?></p>
                            <p><strong><i class="fas fa-user-tie"></i> Istruttore:</strong> <?php echo htmlspecialchars($corso['istruttore']); ?></p>
                            <a href="prenota_corso.php?corso=<?php echo urlencode($corso['nome']); ?>" class="btn-prenota">
                                <i class="fas fa-calendar-plus"></i> Prenota ora
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-corsi">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Non ci sono corsi disponibili al momento.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script>
        // Script opzionale per animazioni o interazioni aggiuntive
        document.addEventListener('DOMContentLoaded', function() {
            const corsiCards = document.querySelectorAll('.corso');
            
            corsiCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.classList.add('hover');
                });
                
                card.addEventListener('mouseleave', function() {
                    this.classList.remove('hover');
                });
            });
        });
    </script>
</body>
</html>