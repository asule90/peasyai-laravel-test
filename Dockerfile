# From official php image.
FROM php:8.2-fpm-alpine3.18

ARG USERNAME=laravel
ARG USER_UID=1000
ARG USER_GID=1000
ARG HOME_DIR=/var/www/html/laravel

WORKDIR $HOME_DIR

RUN echo "http://dl-cdn.alpinelinux.org/alpine/v3.19/main" > /etc/apk/repositories \
    && echo "http://dl-cdn.alpinelinux.org/alpine/v3.19/community" >> /etc/apk/repositories \
    && apk update && apk upgrade && apk add -q --update --progress --no-cache autoconf \
    bash coreutils curl g++ git make postgresql-client \
    ncurses sudo supervisor libpq-dev

RUN pecl install redis

# Setup user
RUN adduser $USERNAME -s /bin/sh -D -u $USER_UID $USER_GID \
    && addgroup docker && adduser $USERNAME docker \
    && mkdir -p /etc/sudoers.d \
    && echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

RUN mkdir -p "/etc/supervisor/logs" \
&& chown -R $USER_UID:$USER_GID /etc/supervisor/logs \
&& chown -R $USER_UID:$USER_GID .

COPY ./supervisord.conf /etc/supervisor/supervisord.conf

# Install postgres pdo driver.
RUN docker-php-ext-install pdo pdo_pgsql pgsql && docker-php-ext-enable redis.so

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer;

COPY --chown=$USER_UID:$USER_GID composer* ./

# install node & vue
RUN apk add --update nodejs npm 

USER $USERNAME

RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader
COPY --chown=$USER_UID:$USER_GID . .
RUN composer dump-autoload --no-scripts --no-dev --optimize \
    && npm install @inertiajs/vue3 && npm install && npm run build

EXPOSE 9000

# Prevent container from exiting early.
# CMD ["sleep", "infinity"]
CMD ["/usr/bin/supervisord", "-n"]
