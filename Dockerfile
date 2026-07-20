FROM php:8.4-apache-bookworm

LABEL org.opencontainers.image.source="https://github.com/pschlo/posthub"

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && docker-php-ext-install -j"$(nproc)" mysqli

WORKDIR /var/www/html

COPY --chown=www-data:www-data src/ ./
COPY docker/schema.sql docker/initialize-database.php /usr/local/share/posthub/
COPY docker/entrypoint.sh /usr/local/bin/posthub-entrypoint

RUN chmod 0755 /usr/local/bin/posthub-entrypoint \
    && php -l /usr/local/share/posthub/initialize-database.php \
    && find /var/www/html -type f -name '*.php' -exec php -l {} \;

ENTRYPOINT ["posthub-entrypoint"]
CMD ["apache2-foreground"]

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=3s --start-period=10s --retries=3 \
    CMD php -r '$socket = @fsockopen("127.0.0.1", 80); exit($socket ? 0 : 1);'
