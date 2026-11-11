<?php
include 'db_config.php';

// Recupera tutti gli istruttori e le info dei corsi
$sql = "SELECT DISTINCT istruttore, nome as corso, categoria_id, immagine FROM corsi ORDER BY istruttore";
$result = $conn->query($sql);

// Recupera tutte le categorie
$sql_categorie = "SELECT * FROM categorie_corsi ORDER BY nome";
$result_categorie = $conn->query($sql_categorie);

$istruttori = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if (!isset($istruttori[$row['istruttore']])) {
            $istruttori[$row['istruttore']] = [
                'nome' => $row['istruttore'],
                'corsi' => [$row['corso']],
                'categoria_id' => [$row['categoria_id']],
                'immagine' => $row['immagine']
            ];
        } else {
            if (!in_array($row['corso'], $istruttori[$row['istruttore']]['corsi'])) {
                $istruttori[$row['istruttore']]['corsi'][] = $row['corso'];
            }
            if (!in_array($row['categoria_id'], $istruttori[$row['istruttore']]['categoria_id'])) {
                $istruttori[$row['istruttore']]['categoria_id'][] = $row['categoria_id'];
            }
        }
    }
}

function getSpecializzazione($categorie_ids, $conn) {
    if (empty($categorie_ids)) return "Generale";
    $id = $categorie_ids[0];
    $sql = "SELECT nome FROM categorie_corsi WHERE id = $id";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        return $res->fetch_assoc()['nome'];
    }
    return "Generale";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Istruttori - FitZone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/istruttori.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <h2>FitZone</h2>
        <nav>
            <a href="index.php">Home</a>
            <a href="profile.php">Profilo</a>
            <a href="abbonamenti.php">Abbonamenti</a>
            <a href="prenotazioni.php">Prenotazioni</a>
            <a href="istruttori.php" class="active">Istruttori</a>
            <a href="corsi.php">Corsi</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <main class="content">
        <h1>I Nostri Istruttori</h1>

        <!-- FILTRO SOLO CSS -->
        <div class="filtro-container">
            <input type="radio" name="filtro" id="filtro-tutti" checked>
            <label for="filtro-tutti">Tutti</label>

            <?php
            $categorie_map = [];
            if ($result_categorie->num_rows > 0) {
                while ($cat = $result_categorie->fetch_assoc()) {
                    $slug = strtolower(str_replace(' ', '-', $cat['nome']));
                    $categorie_map[$cat['id']] = $slug;
                    echo '<input type="radio" name="filtro" id="filtro-' . $slug . '">';
                    echo '<label for="filtro-' . $slug . '">' . $cat['nome'] . '</label>';
                }
            }
            ?>
        </div>

        <div class="istruttori">
            <?php
            foreach ($istruttori as $istr) {
                $specializzazione = getSpecializzazione($istr['categoria_id'], $conn);
                $slug = $categorie_map[$istr['categoria_id'][0]] ?? 'tutti';
                $img = $istr['immagine'] ?: 'images/placeholder.svg';
                ?>
                <div class="card categoria-<?php echo $slug; ?>">
                    <img src="<?php echo $img; ?>" alt="<?php echo $istr['nome']; ?>">
                    <h3><?php echo $istr['nome']; ?></h3>
                    <p><strong>Specializzazione:</strong> <?php echo $specializzazione; ?></p>
                    <p><strong>Corsi:</strong> <?php echo implode(', ', $istr['corsi']); ?></p>
                </div>
            <?php } ?>
        </div>
    </main>
</div>
</body>
</html>
