#!make

up:
	docker compose up -d

down:
	docker compose down

composer-install:
	docker compose run --rm app-cli composer install

composer-update:
	docker compose run --rm app-cli composer update

migrate:
	docker compose run --rm app-cli php artisan migrate

artisan-optimize:
	docker compose run --rm app-cli php artisan optimize

app-key-generate:
	docker compose run --rm app-cli php artisan key:generate

front-install:
	docker compose run --rm frontend-dev npm install

front-build:
	docker compose run --rm frontend-dev npm run build