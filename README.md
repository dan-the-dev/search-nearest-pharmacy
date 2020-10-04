# search-nearest-pharmacy

JSON RPC service to find nearest pharmacy from a given location.

## Run the server

Add the following line to your /etc/hosts file (you might need administrator rights):

`127.0.0.1 myapp.loc`

Install docker (check [here](https://docs.docker.com/compose/install/) for how to do it) and start it on your machine (docker-compose command will work properly only when Docker is running).

Run the following commands:

`make composer-install`

then:

`make start`

Once started, the JSON RPC service via HTTP will be available.

You can stop everything with the command:

`make stop`

## Test the server

Run the following command: 

`make test-http-call`

it correspond to this cURL: 

`curl -X POST http://myapp.loc/ -H "Content-Type: application/json" -d '{"id":1,"jsonrpc":"2.0","method":"add","params":[1, 2]}'`

You can also run tests: 

`make test`

## A couple notes on the solution

- I used an external library to handle JSON RPC: there was no need to reinvent it
- Nginx config is a basic solution I found on the web; is a good solution for simple situations, i'm not a ninja on it 
so I tried to simplify it a bit but is probably viable for more optimization
- phpunit tests and composer command run on specific container, sharing volumes between them and the app container
- in order to load data on server start, a possible approach would be to handle it with docker compose configuration: 
we might set up a volume with the file and load the content on container startup; 
for a different approach on PHP code, a deeper look into the library used for JSON RPC via HTTP would be needed
- automated test is mainly for the general business logic: this is because I didn't found good abstraction for it; 
the only other thing tested is the repository
- encapsulated some domain object into classes (Pharmacy, Location, ecc)
- encapsulated Request in an object so we have a reusable input independet from transfer protocol (HTTP in this case)

In general, all choiches has been taken considering the following priorities:
- time: since it is for a job apply, I want to deliver this in a week max; more time is probably inappropriate in this situation
- domain: the main "stuff" of this assignment is the "search nearest pharmacies" business; main focus on that, things around can be replaced easily
- quality: I wanted nevertheless keep a good quality on code, but with a good balance with time and domain needs
