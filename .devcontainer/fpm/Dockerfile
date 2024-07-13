# From official php image.
FROM php:8.2-fpm-alpine3.18

ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=1000
ARG HOME_DIR=/home/$USERNAME

RUN echo "http://dl-cdn.alpinelinux.org/alpine/v3.19/main" > /etc/apk/repositories \
    && echo "http://dl-cdn.alpinelinux.org/alpine/v3.19/community" >> /etc/apk/repositories \
    && apk update && apk upgrade && apk add -q --update --progress --no-cache autoconf \
    bash coreutils curl docker-cli docker-compose g++ git jq make postgresql-client \
    ncurses openssh-client sudo supervisor vim vim-doc zsh zsh-vcs libpq-dev

RUN pecl install redis

# Setup user
RUN adduser $USERNAME -s /bin/sh -D -u $USER_UID $USER_GID \
    && addgroup docker && adduser $USERNAME docker \
    && mkdir -p /etc/sudoers.d \
    && echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

# Install postgres pdo driver.
RUN docker-php-ext-install pdo pdo_pgsql pgsql && docker-php-ext-enable redis.so


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer;

# install node & vue
RUN apk add --update nodejs npm \
    && npm install @inertiajs/vue3

USER $USERNAME
WORKDIR $HOME_DIR

# Install Oh-My-Zsh
RUN curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh | bash \
    && git clone https://github.com/zsh-users/zsh-autosuggestions ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-autosuggestions \
    && git clone https://github.com/zsh-users/zsh-completions ${ZSH_CUSTOM:-${ZSH:-~/.oh-my-zsh}/custom}/plugins/zsh-completions

# Install the Powerlevel10k theme
RUN git clone --depth=1 https://github.com/romkatv/powerlevel10k.git $HOME_DIR/.oh-my-zsh/custom/themes/powerlevel10k

COPY .p10k.zsh .zshrc $HOME_DIR/

RUN dos2unix ~/.p10k.zsh && dos2unix ~/.zshrc

# Prevent container from exiting early.
# CMD ["sleep", "infinity"]
# CMD ["/usr/bin/supervisord", "-n"]
