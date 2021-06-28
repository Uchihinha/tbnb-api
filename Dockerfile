FROM ambientum/php:7.4-nginx

USER root

RUN rm /etc/apk/repositories
ADD https://packages.whatwedo.ch/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub
RUN echo "https://packages.whatwedo.ch/php-alpine/v3.11/php-7.4" >> /etc/apk/repositories

COPY ./start.sh /usr/local/bin/start
RUN chmod u+x /usr/local/bin/start

RUN apk update && \
    apk add php7-dev@php --force-broken-world && \
	apk add php7-pear@php --force-broken-world && \
    apk add php7-gmp@php --force-broken-world && \
    apk add autoconf --force-broken-world && \
    apk add openssl --force-broken-world && \
    apk add --no-cache tzdata --force-broken-world && \
    pecl channel-update pecl.php.net && \
    pear config-set php_ini /etc/php7/php.ini

ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN sudo ln -s /etc/nginx/sites/$FRAMEWORK.conf /etc/nginx/sites/enabled.conf
RUN nohup /usr/sbin/php-fpm -y /etc/php7/php-fpm.conf -F -O 2>&1 &

# USER ambientum

WORKDIR /var/www/app

COPY . .

RUN composer install

RUN chmod 777 -R storage

EXPOSE 8080

# CMD ["nginx"]
CMD ["/usr/local/bin/start"]
