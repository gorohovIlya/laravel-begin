FROM php:8.3-fpm

# Принимаем ID пользователя и группы из docker-compose (по умолчанию 1000)
ARG USER_ID=1000
ARG GROUP_ID=1000

# Создаем пользователя с тем же UID/GID, что и у вас на ПК, чтобы не было конфликта прав
RUN if getent group $GROUP_ID; then \
        # Если группа существует, используем её имя
        USER_GROUP=$(getent group $GROUP_ID | cut -d: -f1); \
    else \
        # Если группы нет, создаем новую
        groupadd -g $GROUP_ID laravel_user && USER_GROUP=laravel_user; \
    fi && \
    useradd -u $USER_ID -g $USER_GROUP -m -s /bin/bash laravel_user || true

# Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo_mysql zip gd bcmath soap \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Переключаем контейнер: теперь все команды (включая php-fpm) будут работать от вашего имени!
USER $USER_ID


