<?php

declare(strict_types=1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function environmentOrDefault(string $name, string $default): string
{
    $value = getenv($name);

    return $value === false || $value === '' ? $default : $value;
}

$host = environmentOrDefault('POSTHUB_DB_HOST', 'localhost');
$port = (int) environmentOrDefault('POSTHUB_DB_PORT', '3306');
$database = environmentOrDefault('POSTHUB_DB_NAME', 'posthub');
$user = environmentOrDefault('POSTHUB_DB_USER', 'posthub');
$password = getenv('POSTHUB_DB_PASSWORD');

if ($password === false || $password === '') {
    fwrite(STDERR, "POSTHUB_DB_PASSWORD is not configured.\n");
    exit(1);
}

$connection = null;

for ($attempt = 1; $attempt <= 30; $attempt++) {
    try {
        $connection = @new mysqli($host, $user, $password, $database, $port);
        break;
    } catch (mysqli_sql_exception $exception) {
        if ($attempt === 1) {
            fwrite(STDOUT, "Waiting for the Posthub database...\n");
        }

        if ($attempt === 30) {
            fwrite(STDERR, "Could not connect to the Posthub database: {$exception->getMessage()}\n");
            exit(1);
        }

        sleep(2);
    }
}

$connection->set_charset('utf8mb4');
$schema = file_get_contents('/usr/local/share/posthub/schema.sql');

if ($schema === false) {
    fwrite(STDERR, "Could not read the Posthub database schema.\n");
    exit(1);
}

$connection->multi_query($schema);

do {
    if ($result = $connection->store_result()) {
        $result->free();
    }
} while ($connection->more_results() && $connection->next_result());

fwrite(STDOUT, "Posthub database is ready.\n");
