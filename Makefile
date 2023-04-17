init: docker-down-clear api-clear docker-pull docker-build docker-up api-init
up: docker-up
down: docker-down
restart: down up
check: lint analyze test
lint: api-lint
fix: api-fix
analyze: api-analyze
test: api-test

docker-up:
	docker-compose up -d
docker-down:
	docker-compose down --remove-orphans
docker-down-clear:
	docker-compose down -v --remove-orphans
docker-pull:
	docker-compose pull
docker-build:
	docker-compose build

## Api init
api-init: api-permissions api-composer-install api-wait-db api-migrations api-fixtures

api-permissions:
	docker run --rm -v ${PWD}/api:/app -w /app alpine chmod 777 -R bootstrap/cache

api-clear:
	docker run --rm -v ${PWD}/api:/app -w /app alpine sh -c 'rm -rf bootstrap/cache/* var/cache/* var/log/* var/test/*'

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-wait-db:
	docker-compose run --rm api-php-cli wait-for-it api-mysql:3306 -t 30

api-migrations:
	docker-compose run --rm api-php-cli php artisan migrate

api-fixtures:
	docker-compose run --rm api-php-cli php artisan db:seed

api-wait-elasticsearch:
	docker-compose run --rm api-php-cli wait-for-it api-elasticsearch:9200 -t 60
api-elasticsearch-init:
	docker-compose run --rm api-php-cli php artisan search:init
api-elasticsearch-reindex:
	docker-compose run --rm api-php-cli php artisan search:reindex

## Check code PSR12 style
api-lint:
	docker-compose run --rm api-php-cli composer cs-check

## Check code error
api-analyze:
	docker-compose run --rm api-php-cli composer psalm
	docker-compose run --rm api-php-cli composer lint

## Fix code PSR12 style
api-fix:
	docker-compose run --rm api-php-cli composer psalter --issues=MissingReturnType --php-version=8.1

	docker-compose run --rm api-php-cli composer cs-fix
	docker-compose run --rm api-php-cli composer pint

api-test:
	docker-compose run --rm api-php-cli php artisan test
