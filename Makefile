build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

clean: composer optimize fresh admin supervisor-restart npm-i npm-dev

composer:
	docker-compose exec app sh -c "composer install && composer update"

optimize:
	docker-compose exec app sh -c "php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan debugbar:clear"

fresh:
	docker-compose exec app sh -c "php artisan migrate:fresh && php artisan db:seed"

admin:
	docker-compose exec app sh -c "php artisan orchid:admin admin admin@admin.com password"

npm-i:
	docker-compose exec app sh -c "npm i"

npm-dev:
	docker-compose exec app sh -c "npm run development"

test:
	docker-compose exec app sh -c "php artisan test"

supervisor-restart:
	docker-compose exec app sh -c "supervisorctl restart all"

telegram-bot:
	docker-compose exec app sh -c "php artisan telegram:bot:run"
