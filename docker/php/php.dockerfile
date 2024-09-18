# Use a imagem oficial do PHP
FROM php:8.3.7-fpm

# Declare argumentos que serão preenchidos por valores do .env
ARG WORKDIR

# Torne essas variáveis disponíveis no ambiente de execução do contêiner
ENV WORKDIR=${WORKDIR}

# Define o diretório de trabalho
WORKDIR '${WORKDIR}'

# Instale as dependências
RUN apt-get update
RUN apt-get install -y build-essential
RUN apt-get install -y locales
RUN apt-get install -y zip
RUN apt-get install -y vim
RUN apt-get install -y unzip
RUN apt-get install -y git
RUN apt-get install -y curl
RUN apt-get install -y net-tools
RUN apt-get install -y libonig-dev
RUN apt-get install -y libzip-dev
RUN apt-get install -y libpq-dev
RUN apt-get install -y libpng-dev
RUN apt-get install -y libxml2-dev
RUN apt-get install -y libmagickwand-dev
RUN apt-get install -y libfreetype6

# Clonar e compilar a extensão Imagick
RUN git clone https://github.com/Imagick/imagick.git /tmp/imagick && \
    cd /tmp/imagick && \
    phpize && \
    ./configure && \
    make && make install

# Limpe o cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instale as extensões
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install gd
RUN docker-php-ext-enable imagick && rm -rf /tmp/imagick

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Adicione um usuário para a aplicação Laravel
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copie o conteúdo do diretório da aplicação existente
COPY src '${WORKDIR}'

# Copie as permissões do diretório da aplicação existente
COPY --chown=www:www . '${WORKDIR}'

# Altere o usuário atual para www
USER www

# Exponha a porta 9000 e inicie o servidor php-fpm
EXPOSE 9000
CMD ["php-fpm"]