#!/bin/sh
set -eu

if [ "${1:-}" = "apache2-foreground" ]; then
    php /usr/local/share/posthub/initialize-database.php
fi

exec docker-php-entrypoint "$@"
