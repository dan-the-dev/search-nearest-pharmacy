# search-nearest-pharmacy

JSON RPC service to find nearest pharmacy from a given location

## Run the server

Add the following line to your /etc/hosts file:

`127.0.0.1 myapp.loc`

Run the following commands: 

`make composer-install`

then: 

`make start`

## Test the server

`curl -X POST http://myapp.loc/ -H "Content-Type: application/json" -d '{"id":1,"jsonrpc":"2.0","method":"add","params":[1, 2]}'`
