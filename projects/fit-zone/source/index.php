<?php

// Avvia la sessione per gestire i login degli utenti
session_start();

require_once __DIR__ . '/db_config.php';
// Funzione per recuperare i servizi dal database
function getServices($conn) {
    $services = array();
    $sql = "SELECT * FROM servizi ORDER BY id ASC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
    }
    return $services;
}

// Funzione per recuperare le testimonianze dal database
function getTestimonials($conn) {
    $testimonials = array();
    $sql = "SELECT * FROM testimonianze ORDER BY id ASC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $testimonials[] = $row;
        }
    }
    return $testimonials;
}

// Funzione per recuperare le immagini della galleria dal database
function getGalleryImages($conn) {
    $images = array();
    $sql = "SELECT * FROM galleria ORDER BY id ASC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $images[] = $row;
        }
    }
    return $images;
}

// Funzione per recuperare gli orari di apertura dal database
function getOpeningHours($conn) {
    $hours = array();
    $sql = "SELECT * FROM orari ORDER BY id ASC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $hours[] = $row;
        }
    }
    return $hours;
}

// Funzione per recuperare le FAQ dal database
function getFAQs($conn) {
    $faqs = array();
    $sql = "SELECT * FROM faq ORDER BY id ASC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $faqs[] = $row;
        }
    }
    return $faqs;
}

// Gestione dell'invio del form di contatto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_submit'])) {
    $name = trim((string)($_POST['name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $message = trim((string)($_POST['message'] ?? ''));
    
    $stmt = $conn->prepare("INSERT INTO contatti (nome, email, messaggio, data_invio) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param('sss', $name, $email, $message);

    if ($stmt->execute()) {
        $contact_success = "Messaggio inviato con successo!";
    } else {
        $contact_error = "Errore nell'invio del messaggio: " . $conn->error;
    }
}

// Recupera i dati dal database
$services = getServices($conn);
$testimonials = getTestimonials($conn);
$gallery_images = getGalleryImages($conn);
$opening_hours = getOpeningHours($conn);
$faqs = getFAQs($conn);

// Recupera info palestra
$sql = "SELECT * FROM info_palestra WHERE id = 1";
$result = $conn->query($sql);
$gym_info = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Palestra FitZone</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script defer src="script/script.js"></script>
</head>
<body>
  <div id="preloader"><div class="spinner"></div></div>

  <!-- Header con il menu -->
  <header class="hero">
    <nav>
      <h1>FitZone</h1>
      <!-- Aggiunta l'icona hamburger per il mobile o tablet -->
      <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#services">Servizi</a></li>
        <li><a href="#testimonials">Testimonianze</a></li>
        <li><a href="#gallery">Galleria</a></li>
        <li><a href="#location">Dove siamo</a></li>
        <li><a href="#social">Contattaci</a></li>
        <li><a href="#faq">FAQ</a></li>
        <li><a href="#about">Chi siamo</a></li>
        <?php if(isset($_SESSION['user_id'])): ?>
          <li><a href="profile.php">Profilo</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Accedi</a></li>
          <li><a href="register.php">Registrati</a></li>
        <?php endif; ?>
      </ul>
    </nav>
    <div class="hero-content">
      <h2>Scopri il meglio del fitness</h2>
      <p>Allenamenti personalizzati e attrezzature moderne per il tuo benessere.</p>
    </div>
  </header>

  <!-- Sezione Servizi -->
  <section id="services" class="section">
    <h2>I nostri servizi</h2>
    <div class="services">
      <?php foreach($services as $service): ?>
      <div class="service-card">
        <img src="<?php echo htmlspecialchars($service['immagine']); ?>" alt="<?php echo htmlspecialchars($service['titolo']); ?>">
        <h3><?php echo htmlspecialchars($service['titolo']); ?></h3>
        <p><?php echo htmlspecialchars($service['descrizione']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Sezione Testimonianze -->
  <section id="testimonials" class="section">
    <h2>Cosa dicono i nostri clienti</h2>
    <div class="testimonials">
      <?php foreach($testimonials as $testimonial): ?>
      <div class="testimonial">
        <p>"<?php echo htmlspecialchars($testimonial['commento']); ?>"</p>
        <h4>- <?php echo htmlspecialchars($testimonial['nome']); ?></h4>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Sezione Galleria -->
  <section id="gallery" class="section">
    <h2>Galleria</h2>
    <div class="services">
      <?php 
      $count = 0;
      foreach($gallery_images as $image): 
        if($count % 3 == 0 && $count > 0): ?>
        </div>
        <div class="services">
        <?php endif; ?>
        <div class="service-card">
          <img src="<?php echo htmlspecialchars($image['percorso']); ?>" alt="<?php echo htmlspecialchars($image['descrizione']); ?>">
        </div>
      <?php 
        $count++;
      endforeach; 
      ?>
    </div>
  </section>

  <!-- Sezione Dove siamo -->
  <section id="location" class="section">
    <h2>Dove siamo</h2>
    <p><?php echo htmlspecialchars($gym_info['indirizzo']); ?></p>
    <p>Telefono: <?php echo htmlspecialchars($gym_info['telefono']); ?></p>
    <p><iframe id="map-canvas" class="map_part" width="1000" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%&amp;height=100%&amp;hl=en&amp;q=camerota&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></p>
  </section>

  <!-- Sezione Chi siamo -->
  <section id="about" class="section">
    <h2>Chi siamo</h2>
    <p><?php echo nl2br(htmlspecialchars($gym_info['descrizione'])); ?></p>
  </section>

  <!-- Sezione Contattaci  -->
  <section id="social" class="section contact-section">
    <h2>Contattaci</h2>
    <?php if(isset($contact_success)): ?>
      <div class="success-message"><?php echo $contact_success; ?></div>
    <?php endif; ?>
    <?php if(isset($contact_error)): ?>
      <div class="error-message"><?php echo $contact_error; ?></div>
    <?php endif; ?>
    <form class="contact-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#social" method="POST">
      <input type="text" name="name" placeholder="Il tuo nome" required>
      <input type="email" name="email" placeholder="La tua email" required>
      <textarea name="message" placeholder="Scrivi il tuo messaggio..." rows="5" required></textarea>
      <button type="submit" name="contact_submit" class="btn-submit">Invia</button>
    </form>
    <div class="social-icons">
      <a href="<?php echo htmlspecialchars($gym_info['facebook']); ?>"><i class="fab fa-facebook-f"></i></a>
      <a href="<?php echo htmlspecialchars($gym_info['instagram']); ?>"><i class="fab fa-instagram"></i></a>
      <a href="<?php echo htmlspecialchars($gym_info['twitter']); ?>"><i class="fab fa-twitter"></i></a>
      <a href="<?php echo htmlspecialchars($gym_info['whatsapp']); ?>"><i class="fab fa-whatsapp"></i></a>
    </div>
  </section>

  <!-- Sezione Calendario Apertura -->
  <section id="opening-hours" class="section">
    <h2>Orari di apertura</h2>
    <table class="opening-hours-table">
      <thead>
        <tr>
          <th>Giorno</th>
          <th>Orario</th>
          <th>Corsi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($opening_hours as $day): ?>
        <tr>
          <td><?php echo htmlspecialchars($day['giorno']); ?></td>
          <td><?php echo htmlspecialchars($day['orario']); ?></td>
          <td><?php echo htmlspecialchars($day['corsi']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>

  <!-- Sezione FAQ -->
  <section id="faq" class="section">
    <h2>Domande Frequenti</h2>
    <div class="faq">
      <?php foreach($faqs as $faq): ?>
      <div class="faq-item">
        <h3><?php echo htmlspecialchars($faq['domanda']); ?></h3>
        <p><?php echo htmlspecialchars($faq['risposta']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; <?php echo date("Y"); ?> FitZone - Tutti i diritti riservati</p>
  </footer>

</body>
</html>
<?php
// Chiudi la connessione al database
$conn->close();
?>