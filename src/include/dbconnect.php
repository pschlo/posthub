<?php

$db_host = getenv('POSTHUB_DB_HOST') ?: 'localhost';
$db_port = (int) (getenv('POSTHUB_DB_PORT') ?: '3306');
$db_name = getenv('POSTHUB_DB_NAME') ?: 'posthub';
$db_user = getenv('POSTHUB_DB_USER') ?: 'posthub';
$db_password = getenv('POSTHUB_DB_PASSWORD');

if ($db_password === false || $db_password === '') {
    die('POSTHUB_DB_PASSWORD is not configured.');
}

$dbc = @mysqli_connect($db_host, $db_user, $db_password, $db_name, $db_port);

if (!$dbc) {
    die('Verbindung zur Datenbank fehlgeschlagen: '.mysqli_connect_error());
}

mysqli_set_charset($dbc, 'utf8mb4');
