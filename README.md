# Information
This is a simple blog project made with react.js php and mysql

# To run the project

docker, docker compose plugin, node.js and npm must be installed

# Step 1

add
```
MYSQL_DATABASE=blog
MYSQL_ROOT_PASSWORD=123456
MYSQL_HOST=mysql-dev
MYSQL_PASSWORD=123456
```

to `/backend/config/.env.dev`

# Step 2

add

```
REACT_APP_API_URL="localhost:80"
REACT_APP_TOKEN_KEY="token"
```

to `/.env`

# Step 3

run

```
npm install
```

to install all node.js dependencies

# Step 4

run

```
npm start
```

to start the project

`npm start` will start all services with profile named 'dev' and with `/backend/config/.env.dev` file,
there is also a profile named 'prod' but it is not configured yet

# API Container

docker compose will run the containers, as the API container depends on MySQL container
it waits for MySQL container status to become 'service_healthy'. This container will automatically run the migrations.
The source code is mapped to the `/app` folder of the container with a docker volume. 

# MySQL Container

this is the first container that starts up as the API container depends on it, it will perform health check
and change status when MySQL is ready to accept connections. The MySQL data is
mapped to the `/backend/docker/mysql/data` folder of repository.

# P.S.

Most part of development is done today, and most time went on configuration of docker and apache,
(it was not clear how to run migrations on container start up, then I figured it out).
I designed the app to be able to implement also the authentication part.
The backend is implemented but not fully tested yet,
also there are parts that are done in most straightforward way,
to save time, but they can be done better.
As the task required not to use any backend framework just some essential libraries, I've not used any migration
library, but I've implemented a migration file, which is running the migrations as RAW SQL queries.
Backend routing is implemented with Klein router, data validation is done with Respect/Validation library.
On frontend there is no any UI, there are several services and main components + redux store.
Front-end dependencies are installed by hand no create-react-app is used (now I'm wondering why? :)).

# The End







