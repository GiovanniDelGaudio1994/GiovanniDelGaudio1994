<?php
// Avvia la sessione
session_start();

// Distruggi tutte le variabili di sessione
$_SESSION = array();

// Distruggi la sessione
session_destroy();

// Reindirizza alla home page
header("Location: index.php");
exit;
?>