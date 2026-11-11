<?php
// Simuliamo i dettagli del corso con dei dati statici, incluso l'URL dell'immagine
$corso_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($corso_id == 0) {
    echo "Corso non trovato.";
    exit;
}

// Dati statici per i corsi, incluso il percorso dell'immagine
$corsi = [
    1 => [
        'nome' => 'Yoga Base',
        'categoria' => 'Benessere',
        'descrizione' => 'Un corso di yoga per principianti, perfetto per rilassarsi e migliorare la flessibilità.',
        'orari' => 'Lunedì e Mercoledì - 18:00 - 19:30',
        'immagine' => 'images/placeholder.svg' // Percorso dell'immagine
    ],
    2 => [
        'nome' => 'Spinning',
        'categoria' => 'Cardio',
        'descrizione' => 'Un intenso corso di spinning per migliorare la resistenza cardiovascolare e bruciare calorie.',
        'orari' => 'Martedì e Giovedì - 07:30 - 08:30',
        'immagine' => 'images/placeholder.svg' // Percorso dell'immagine
    ],
    3 => [
        'nome' => 'Pilates Avanzato',
        'categoria' => 'Benessere',
        'descrizione' => 'Pilates per chi ha già esperienza, per migliorare la postura e la forza del core.',
        'orari' => 'Venerdì - 09:00 - 10:30',
        'immagine' => 'images/placeholder.svg' // Percorso dell'immagine
    ]
];

// Controlliamo se il corso esiste
if (!isset($corsi[$corso_id])) {
    echo "Corso non trovato.";
    exit;
}

$corso = $corsi[$corso_id];
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettaglio Corso</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="corso-details">
    <h1>Dettaglio Corso: <?php echo htmlspecialchars($corso['nome']); ?></h1>
    <img src="<?php echo htmlspecialchars($corso['immagine']); ?>" alt="Immagine del Corso" class="corso-image">
    <p><strong>Categoria:</strong> <?php echo htmlspecialchars($corso['categoria']); ?></p>
    <p><strong>Descrizione:</strong> <?php echo htmlspecialchars($corso['descrizione']); ?></p>
    <p><strong>Orari:</strong> <?php echo htmlspecialchars($corso['orari']); ?></p>

    <!-- Pulsante per prenotare il corso -->
    <a href="prenota-corso.php?id=<?php echo $corso_id; ?>" class="button">Prenota Corso</a>
</div>

</body>
</html>
