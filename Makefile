.PHONY: start stop composer-install composer-update

start:
	docker-compose up -d

stop:
	docker-compose down

composer-install:
	docker-composer run composer install

composer-update:
	docker-composer run composer update