sail := "./vendor/bin/sail"
.DEFAULT_GOAL := help
.PHONY: help
help: ## Affiche cette aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: install test

vendor: composer.json ## Installe les packages
	 composer install

composer.lock: composer.json ## Mets à jour les packages
	 composer update

install: vendor composer.lock

test: install ## Lance les tests
	$(sail) artisan test

.PHONY: stop-and-start
stop-and-start: install ## stop all services and then start the project
	sudo chmod +x ./tools/bash/stop-services.sh && sudo ./tools/bash/stop-services.sh && make start

.PHONY: start
start: ## Run docker to start the project
	$(sail) up

.PHONY: lint
lint: ./vendor/bin/phpstan phpstan.neon ## Lance phpstan pour l'analyse static que code
	docker-compose exec -u sail "laravel.test" ./vendor/bin/phpstan analyse --memory-limit=2G

.PHONY: build-watch
build-watch: ## build assets and watch
	$(sail) yarn watch

.PHONY: buil-dev
build-dev:  ## build assets for dev
	$(sail) yarn dev

.PHONY: sprite
sprite: ## Combine les fichiers svg ensemble
	svg-sprite-generate -d public/assets/images/icons -o public/assets/images/sprite.svg

.PHONY: push
push: ./vendor/czproject/git-php ## déploiement sur github
	php artisan git:push

.PHONY: push-dev
push-dev: ./vendor/czproject/git-php ## déploiement dev sur github
	php artisan git:push-dev
