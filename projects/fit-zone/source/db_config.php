<?php
/** Connessione MySQL locale. Variabili da configurare nell’ambiente del server. */
$db_host = getenv('FITZONE_DB_HOST') ?: '127.0.0.1';
$db_user = getenv('FITZONE_DB_USER') ?: 'fitzone_user';
$db_password = getenv('FITZONE_DB_PASSWORD');
$db_name = getenv('FITZONE_DB_NAME') ?: 'fitzone_db';
$db_port = (int)(getenv('FITZONE_DB_PORT') ?: 3306);
if ($db_password === false || $db_password === '') {
    http_response_code(503);
    exit('Database non configurato. Imposta FITZONE_DB_PASSWORD sul server.');
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('FitZone MySQL connection error: ' . $e->getMessage());
    http_response_code(503);
    exit('Il database non è temporaneamente disponibile.');
}
