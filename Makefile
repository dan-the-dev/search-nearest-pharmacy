.PHONY: start stop composer-install composer-update test-http-call

start:
	docker-compose up -d

stop:
	docker-compose down

composer-install:
	docker-compose run composer install

composer-update:
	docker-compose run composer update

test-http-call:
	curl -X POST http://myapp.loc/ -H "Content-Type: application/json" -d '{"id":1,"jsonrpc":"2.0","method":"add","params":[1, 2]}'