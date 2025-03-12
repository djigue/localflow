# Image de base
FROM ubuntu:22.04 AS base

# mise à jour apt 
RUN apt-get update && apt-get install -y \
    curl \
    openssl \
    iputils-ping \
    gnupg2 \
    ca-certificates \
    software-properties-common \
    lsb-release \
    unzip \
    apt-transport-https \
    && rm -rf /var/lib/apt/lists/*

# installation php et des extensions
RUN add-apt-repository ppa:ondrej/php && apt-get update && apt-get install -y \
    php8.2-fpm \
    php8.2-cli \
    php8.2-intl \
    php8.2-pdo \
    php8.2-pgsql \
    php8.2-zip \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-curl \
    php8.2-bcmath \
    php8.2-gd \
    php8.2-mysql \
    php8.2-opcache \
    default-mysql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer et Symfony CLI
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Création du frontend
FROM base AS Frontend

# Node.js et Nginx
RUN curl -sL https://deb.nodesource.com/setup_21.x | bash - && apt-get update && apt-get install -y \
    nodejs \
    nginx \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/Frontend

COPY Frontend/package.json Frontend/package-lock.json ./

RUN npm ci --ignore-scripts

COPY Frontend/ .

ARG NODE_GID=1000
RUN groupadd -g $NODE_GID node && useradd -r -u 1000 -g node node

RUN chown -R node:node /var/www/Frontend

USER node

# Construction du backend
FROM base AS Backend

WORKDIR /var/www/Backend

COPY Backend/composer.json Backend/composer.lock ./

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts --no-interaction

COPY Backend/ ./

RUN mkdir -p /var/www/Backend/public /var/www/Backend/var

# On change les droits sur les dossiers
RUN chown -R www-data:www-data /var/www/Backend/public /var/www/Backend/var
RUN chmod -R 755 /var/www/Backend/public /var/www/Backend/var

# Configuration Nginx et PHP-FPM
FROM base AS final

# Installer Nginx et Supervisor
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=Frontend /var/www/Frontend/build /usr/share/nginx/html

COPY --from=Backend /var/www/Backend/public /var/www/Backend/public

COPY nginx.conf /etc/nginx/conf.d/default.conf

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord"]