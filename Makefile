build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

composer-install:
	docker-compose exec php composer install

init-db:
	docker-compose exec --user=www-data php php bin/console doctrine:migrations:migrate -n

run-phpunit:
	docker-compose exec php  ./vendor/bin/phpunit