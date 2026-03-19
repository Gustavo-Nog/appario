FROM php:8.2-cli

# Instala dependências do sistema (PostgreSQL, etc)
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpq-dev

# Extensões do PHP necessárias para Laravel + PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql zip

# Instala o Composer (gerenciador de dependências do PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho dentro do container
WORKDIR /app

# Copia todos os arquivos do projeto para dentro do container
COPY . .

# Instala as dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Criar pastas para o storage
RUN mkdir -p storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

# Expõe a porta que o Laravel irá rodar
EXPOSE 8000

# depois de copiar o código e instalar dependências

# Comando que inicia o Laravel com artisan
CMD CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000