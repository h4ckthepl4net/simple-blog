# Information
This is a simple blog project made with react.js php and mysql

Go to the bottom to see how to run manually [without docker](#without-docker)

# The repo is a monorepo containing front-end at the root and backend in the /backend folder

# To run the project

# * Check the line endings in /backend/db_migrate.sh file, it may cause container OS not being able to find migrate_db.php file (On Windows maybe, replace CRLF with LF)*

docker, docker compose plugin, node.js and npm must be installed, and docker engine must be started

# Step 1

add
```
MYSQL_DATABASE=blog
MYSQL_ROOT_PASSWORD=123456
MYSQL_HOST=mysql-dev
MYSQL_PASSWORD=123456
```

to `/backend/config/.env.dev` (You can use also MYSQL_USER with MYSQL_PASSWORD to change the DB user)

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

`npm start` will start all backend services (PHP/MySQL) with profile named 'dev' and with `/backend/config/.env.dev` file,
(there is also a profile named 'prod' but it is not configured yet), and after successfull launch of containers it will 
serve react.js frontend app with webpack-dev-server

# API Container

docker compose will run the containers, as the API container depends on MySQL container
it waits for MySQL container status to become 'service_healthy'. This container will automatically run the migrations.
The source code is mapped to the `/app` folder of the container with a docker volume. 

# MySQL Container

this is the first container that starts up as the API container depends on it, it will perform health check
and change status when MySQL is ready to accept connections. The MySQL data is
mapped to the `/backend/docker/mysql/data` folder of repository.

# Without Docker

Running project without docker involves several steps:

# Step 1

install php 7.4, composer, mysql 8.0, node.js and npm

# Step 2

configure server (Apache/ngiNX) to serve and rewrite any coming request to /backend/src/index.php file

# Step 3

run `composer install` in `/backend` folder to install all php dependencies

# Step 4

run `npm install` in `/` folder to install all node.js dependencies

# Step 5

the backend works with mysql through PDO interface so the appropriate driver must be installed and enabled in php.ini

# Step 6

check running the project in docker for setup of environment variables (configure the DB connection)

# Step 7

run migrate_db.php file in `/backend/src` folder to migrate the DB and create the tables

# Step 8

run `npm start` in `/` folder to start the project

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







