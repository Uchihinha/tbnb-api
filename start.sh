#!/bin/bash
echo "Aliasing $FRAMEWORK"
sudo ln -s /etc/nginx/sites/$FRAMEWORK.conf /etc/nginx/sites/enabled.conf

# copy the env example file to .env
cp .env.example .env

# install dependencies
composer install

# configure test database
sed -i '12s/.*/DB_HOST=db-test/' .env
php /var/www/app/artisan config:cache
php /var/www/app/artisan migrate

# configure main database
sed -i '12s/.*/DB_HOST=db/' .env
php /var/www/app/artisan config:cache
php /var/www/app/artisan migrate --seed

# set fpm service
nohup /usr/sbin/php-fpm -y /etc/php7/php-fpm.conf -F -O 2>&1 &

# start nginx server
nginx
