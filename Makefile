.PHONY:


help:
		cat Makefile

up:
		docker-compose up -d

upb:
		docker-compose up -d --build

upc:
		docker-compose up

bd:
		docker-compose build

rbd:
		docker-compose build --no-cache

down:
		docker-compose down

#clearex:
		#docker images -aq | xargs docker rmi -f
		#docker volume rm $(docker volume ls --filter dangling=true -q)

snipe:
		docker-compose exec snipe-it bash


# in container

vendor: composer.json composer.lock
		composer self-update
		composer validate
		composer install

vendor2: composer.json composer.lock
		composer self-update --2
		composer validate
		composer install


dump:
		composer dump-autoload

clear:
		composer clear-cache
		php artisan view:clear
		php artisan route:clear
		php artisan clear-compiled
		php artisan config:cache

opt: clear
		php artisan cache:clear
		#php artisan optimize

clr: opt dump


init: vendor
		php artisan migrate --force
		php artisan migrate --path='vendor/laravel/passport/database/migrations' --force
		php artisan passport:install
		php artisan db:seed
		php artisan db:seed --class=AdjustFirstAdminUserSeeder

e2e:
		php artisan dusk
