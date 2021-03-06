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
        php-yaml  \
        lp-solve \
        php-dev
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

##Add lp_solve support


RUN git clone https://github.com/rsereda/php7_lp_solver.git /usr/lib/lp_solve_5.5
RUN mv  /usr/lib/lp_solve_5.5/src/lp_solve_5.5/* /usr/lib/lp_solve_5.5

RUN ln -s /usr/lib/lp_solve/liblpsolve55.so /usr/lib
RUN cd /usr/lib/lp_solve_5.5/lpsolve55/ && chmod +x ccc && bash ./ccc | true
RUN cd  /usr/lib/lp_solve_5.5/lp_solve && chmod +x ccc && bash ./ccc | true

RUN ln -s /usr/lib/lp_solve_5.5/lpsolve55/bin/ux64/liblpsolve55.so /usr/lib/liblpsolve5.5.so

RUN cd /usr/lib/lp_solve_5.5/extra/PHP/ && \
           phpize && \
           ./configure --enable-maintainer-zts --with-phplpsolve55=../.. && \
           make && \
           make test
RUN ln -s /usr/lib/lp_solve_5.5/extra/PHP/modules/phplpsolve55.so /usr/lib/php/20151012/phplpsolve55.so

RUN echo "extension=phplpsolve55.so" >> /etc/php/7.0/mods-available/lp_solve.ini
RUN ln -s /etc/php/7.0/mods-available/lp_solve.ini /etc/php/7.0/fpm/conf.d/lp_solve.ini
RUN ln -s /etc/php/7.0/mods-available/lp_solve.ini /etc/php/7.0/cli/conf.d/lp_solve.ini


#install nginx

RUN echo 'deb http://nginx.org/packages/ubuntu/ xenial nginx' | tee --append /etc/apt/sources.list.d/nginx
RUN echo 'deb-src http://nginx.org/packages/ubuntu/ xenial nginx' | tee --append /etc/apt/sources.list.d/nginx
RUN curl  https://nginx.org/keys/nginx_signing.key >> /tmp/nginx_signing.key
RUN apt-key add /tmp/nginx_signing.key
RUN apt-get update
RUN apt-get -yqq install nginx

RUN rm /etc/nginx/sites-enabled/default

COPY curicurum.conf /etc/nginx/sites-enabled/curicurum.conf

COPY . /var/www/html/curicurum/

RUN chown -R webapp: /var/www/html/curicurum/
RUN su webapp -c 'cd  /var/www/html/curicurum/ && composer  install'
COPY startup.sh /curicurum/startup.sh

EXPOSE 9000
CMD /curicurum/startup.sh
