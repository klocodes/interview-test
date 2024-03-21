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
migrate-refresh:
	docker compose run --rm app-cli php artisan migrate:refresh

artisan-optimize:
	docker compose run --rm app-cli php artisan optimize

app-key-generate:
	docker compose run --rm app-cli php artisan key:generate

front-install:
	docker compose run --rm frontend-dev npm install
front-build:
	docker compose run --rm frontend-dev npm run build

test:
	docker compose run --rm app-cli php artisan test


# Консольные команды для работы с данными
create-user:
	docker compose run --rm app-cli php artisan app:create-user

perform-operation:
	docker compose run --rm app-cli php artisan app:perform-operation
