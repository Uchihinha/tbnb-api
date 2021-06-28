#!/bin/bash
echo "Aliasing $FRAMEWORK"
sudo ln -s /etc/nginx/sites/$FRAMEWORK.conf /etc/nginx/sites/enabled.conf

# cria o arquivo de configuração de ambiente
cp .env.example .env

# instala as dependências do projeto
composer install

# cria e configura o banco para os testes
sed -i '12s/.*/DB_HOST=db-test/' .env
php /var/www/app/artisan config:cache
php /var/www/app/artisan migrate

# cria e configura o banco principal
sed -i '12s/.*/DB_HOST=db/' .env
php /var/www/app/artisan config:cache
php /var/www/app/artisan migrate --seed

# liga o fpm, serviço que vai rodar o php no server
nohup /usr/sbin/php-fpm -y /etc/php7/php-fpm.conf -F -O 2>&1 &

# liga a fila do Laravel para ficar escutando as requisições da aplicação
nohup php /var/www/app/artisan queue:work --verbose --tries=3 --timeout=90 &

# liga o servidor nginx
nginx
