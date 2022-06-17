FROM php:fpm

WORKDIR /var/www/html/

RUN apt-get update && apt-get install -y \
  build-essential \
  libonig-dev \
  libpng-dev \
  libjpeg62-turbo-dev \
  libfreetype6-dev \
  libzip-dev \
  libpng-dev \
  locales \
  zip \
  jpegoptim optipng pngquant gifsicle \
  vim \
  unzip \
  git \
  curl

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-install gd
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000
CMD ["php-fpm"]
