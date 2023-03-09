<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Stock Management APIs

This application aims to simulate a stock management system. It was used PHP Laravel Framework (8.40) + PostgreSQL + Docker.

## Installation

You need to have Docker installed in your environment.

Then, clone this repo and start docker containers.
PS: you need to free up ports 8080, 5432 and 5433 to run services.

```
docker-compose -f "docker-compose.yml" up -d --build
```

It will run a startup with following steps:

```
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
```

You can get a realtime logs about the pipeline by running:

```
docker logs --tail 1000 -f <<CONTAINER_ID>>
```

To get container id, just run the following:

```
docker ps
```

and get column "CONTAINER ID".

Now the application is running in [http://localhost:8080](http://localhost:8080).

## Full Docs

You can get full docs [here](https://documenter.getpostman.com/view/6846169/TzefBPNF).

## Testing

The application works with default integration tests Laravel pattern (_tests/Feature_).

To test, run the following:

```
php artisan test
```

All tests occur in dedicated tests database, so don't worry about data.
