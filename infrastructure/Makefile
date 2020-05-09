up:
	docker-compose up -d
build:
	docker-compose build --no-cache --force-rm
create-project:
	mkdir -p ./docker/php/bash/psysh
	touch ./docker/php/bash/.bash_history
	@make build
	@make up
	docker-compose exec app composer create-project --prefer-dist laravel/laravel .
	docker-compose exec app composer require predis/predis
	docker-compose exec app composer require doctrine/dbal
install-recommend-packages:
	docker-compose exec app composer require --dev barryvdh/laravel-ide-helper
	docker-compose exec app composer require --dev beyondcode/laravel-dump-server
	docker-compose exec app composer require --dev barryvdh/laravel-debugbar
	docker-compose exec app php artisan vendor:publish --provider="BeyondCode\DumpServer\DumpServerServiceProvider"
	docker-compose exec app php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
init:
	mkdir -p ./docker/php/bash/psysh
	touch ./docker/php/bash/.bash_history
	docker-compose up -d --build
	docker-compose exec app composer install
	docker-compose exec app cp .env.example .env
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan storage:link
	docker-compose exec app php artisan migrate:fresh --seed
remake:
	@make destroy
	@make init
stop:
	docker-compose stop
down:
	docker-compose down
restart:
	@make down
	@make up
destroy:
	docker-compose down --rmi all --volumes
destroy-volumes:
	docker-compose down --volumes
ps:
	docker-compose ps
logs:
	docker-compose logs
logs-watch:
	docker-compose logs --follow
web:
	docker-compose exec web ash
app:
	docker-compose exec app bash
fresh:
	docker-compose exec app php artisan migrate:fresh
seed:
	docker-compose exec app php artisan db:seed
tinker:
	docker-compose exec app php artisan tinker
test:
	docker-compose exec app php artisan test
cache:
	docker-compose exec app composer dump-autoload -o
	docker-compose exec app php artisan optimize
cache-clear:
	docker-compose exec app php artisan optimize:clear
yarn:
	docker-compose exec web yarn
yarn-dev:
	docker-compose exec web yarn run dev
yarn-watch:
	docker-compose exec web yarn run watch
yarn-watch-poll:
	docker-compose exec web yarn run watch-poll
yarn-hot:
	docker-compose exec web yarn run hot
db:
	docker-compose exec db bash
mysql:
	docker-compose exec db bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
redis:
	docker-compose exec redis redis-cli
ide-helper:
	docker-compose exec app php artisan clear-compiled
	docker-compose exec app php artisan ide-helper:generate
	docker-compose exec app php artisan ide-helper:meta
	docker-compose exec app php artisan ide-helper:models --nowrite
