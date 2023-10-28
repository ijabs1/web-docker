FROM php:8.2-cli

WORKDIR /app

# Install the MySQL extension
RUN docker-php-ext-install mysqli

COPY src /app

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app"]
