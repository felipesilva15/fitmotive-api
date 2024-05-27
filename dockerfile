FROM php:8.2-fpm-alpine

# Instala o composer
RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Copia os arquivos do projeto
COPY . .
COPY .env.example .env

# Define as variáveis de ambiente no Dockerfile
ARG DB_CONNECTION=mysql
ARG DB_HOST
ARG DB_PORT
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD
ARG APP_ENV=production

# Substitui as variáveis no arquivo .env pelas variáveis de ambiente
RUN sed -i "s#DB_HOST=.*#DB_HOST=${DB_HOST}#" .env \
    && sed -i "s#DB_PORT=.*#DB_PORT=${DB_PORT}#" .env \
    && sed -i "s#DB_DATABASE=.*#DB_DATABASE=${DB_DATABASE}#" .env \
    && sed -i "s#DB_USERNAME=.*#DB_USERNAME=${DB_USERNAME}#" .env \
    && sed -i "s#DB_PASSWORD=.*#DB_PASSWORD=${DB_PASSWORD}#" .env \
    && sed -i "s#APP_ENV=.*#APP_ENV=${APP_ENV}#" .env

RUN composer install
RUN php artisan migrate --force
RUN php artisan route:cache && php artisan view:cache
RUN php artisan key:generate
RUN php artisan jwt:secret

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]