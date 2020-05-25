FROM wordpress:4.9.1-apache

COPY --chown=www-data:www-data html /var/www/html

COPY application-insights /var/www/html/wp-content/plugins

EXPOSE 80 8080 443 2222 5000

ENTRYPOINT ["apache2-foreground"]