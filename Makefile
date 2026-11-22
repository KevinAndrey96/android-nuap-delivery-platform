.PHONY: help up down restart build logs sh test lint migrate seed reset-db

help: ## Muestra este menu de ayuda
	@echo "Comandos disponibles para NUAP On-Demand Beverage Delivery Platform:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

up: ## Inicia los contenedores en segundo plano
	docker compose up -d

down: ## Detiene todos los contenedores
	docker compose down

restart: down up ## Reinicia todos los servicios

build: ## Reconstruye las imagenes de Docker
	docker compose build

logs: ## Muestra los logs en vivo
	docker compose logs -f

sh: ## Accede al contenedor backend de PHP
	docker compose exec backend-app bash

migrate: ## Ejecuta migraciones de base de datos
	docker compose exec backend-app php artisan migrate

seed: ## Carga los datos de prueba en la base de datos
	docker compose exec -T database mysql -u nuap_user -pnuap_secret nuap_delivery < database/seeds.sql

reset-db: ## Restaura el esquema y datos iniciales
	docker compose exec -T database mysql -u root -proot_secret_password nuap_delivery < database/schema.sql
	docker compose exec -T database mysql -u root -proot_secret_password nuap_delivery < database/seeds.sql

test: ## Ejecuta pruebas automatizadas
	docker compose exec backend-app vendor/bin/phpunit

lint: ## Analiza la sintaxis de archivos PHP
	find backend/app backend/routes backend/config -name "*.php" -exec php -l {} +
