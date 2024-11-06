# Usa una imagen base de PHP con Apache
FROM php:8.2-apache

# Copia el contenido del proyecto en el directorio predeterminado de Apache
COPY . /var/www/html/

# Da permisos de lectura a todos los archivos (esto puede ajustarse según tus necesidades de permisos)
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Expone el puerto 80
EXPOSE 80

# Opcional: Instala extensiones de PHP adicionales si tu aplicación las necesita
RUN docker-php-ext-install mysqli

# Instrucción de inicio
CMD ["apache2-foreground"]
