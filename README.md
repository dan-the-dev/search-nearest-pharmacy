# search-nearest-pharmacy

JSON RPC service to find nearest pharmacy from a given location.

## Run the server

Add the following line to your /etc/hosts file:

`127.0.0.1 myapp.loc`

Run the following commands: 

`make composer-install`

then: 

`make start`

## Test the server

Run the following command: 

`make test-http-call`

it correspond to this cURL: 

`curl -X POST http://myapp.loc/ -H "Content-Type: application/json" -d '{"id":1,"jsonrpc":"2.0","method":"add","params":[1, 2]}'`

You can also run tests: 

`make test`

## A couple notes on the solution

- external library to handle JSON RPC (no need to reinvent the wheel, standard solution is ok)
- nginx config is a basic solution found on the web; is probably viable for optimization
- phpunit tests and composer command run on specific container, sharing volumes between them and the app container
- ...
- in order to load data on server start, a possible approach would be to handle it with docker compose configuration 
would be needed in order to set up a volume with the file and load the content on container startup; 
for a different approach on PHP code, a deeper look into the library used for JSON RPC via HTTP would be needed 
- automated test is only for the general business logic