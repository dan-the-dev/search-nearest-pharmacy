.PHONY: start stop composer-install composer-update composer-dump-autoload test test-http-call

start:
	docker-compose up -d

stop:
	docker-compose down

composer-install:
	docker-compose run --rm --no-deps composer install

composer-update:
	docker-compose run --rm --no-deps composer update

composer-dump-autoload:
	docker-compose run --rm --no-deps composer composer dump-autoload

test:
	docker-compose run --rm --no-deps phpunit

test-http-call:
	curl -X POST http://myapp.loc/ -H "Content-Type: application/json" -d '{"id":1,"jsonrpc":"2.0","method":"SearchNearestPharmacy","params":{"currentLocation":{"latitude":41.10938993,"longitude":15.032101},"range":3800000,"limit":2}}'