FROM ubuntu:16.04

MAINTAINER Roman Sereda <roman.sereda@kiron.ngo>
#Curriculum

RUN apt-get update && apt-get install -y \
        software-properties-common \
        git \
        curl \
        wget \
        zip && \
        locale-gen en_US.UTF-8 && export LANG=en_US.UTF-8 && \
        add-apt-repository ppa:ondrej/php -y && \
        apt-get update && \ 
        apt-get -yqq install \
        php7.0 \
        php7.0-fpm \
        php7.0-mysql \
        php7.0-xml \
        php7.0-curl \
        php7.0-gd \
        php7.0-intl \
        php7.0-json \
        php7.0-mbstring \
        php7.0-mcrypt \
        php7.0-pgsql \
        php7.0-zip \
        php-apcu \
        php-redis \
        php-yaml 
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
RUN sed -i -e "s|listen = /run/php/php7.0-fpm.sock|listen = 0.0.0.0:9000|g"  /etc/php/7.0/fpm/pool.d/www.conf 
RUN sed -i -e "s|user = www-data|user = webapp|g"  /etc/php/7.0/fpm/pool.d/www.conf 
RUN sed -i -e "s|group = www-data|group = webapp|g"  /etc/php/7.0/fpm/pool.d/www.conf 

ARG PUID=1000
ARG PGID=1000
RUN groupadd -g $PGID webapp && \
    useradd -u $PUID -g webapp -m webapp


RUN echo "" > /var/log/php7.0-fpm.log
RUN chmod 644  /var/log/php7.0-fpm.log

EXPOSE 9000
CMD service php7.0-fpm start &&   while true; do sleep 1000; done
