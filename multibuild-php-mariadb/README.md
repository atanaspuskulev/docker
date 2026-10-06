### Multi-build images with internal DNS database resolve

A basic Docker initialization to showcase multi-build image;

## Architecture

Nginx -> PHP-FPM -> MariaDB

with Docker internal DNS.

1. Nginx is resolving PHP-FPM
2. PHP must resolve MariaDB hostname
3. Uses a volume to persist database data
4. No database port is needed to be passed used by PHP connection


### Requirements

A ready network to join. Create one with:

```docker network create [name]```

A ready volume to be used by MariaDB:

```docker volume create [name]```

Note: All the containers should be started in the defined [network-name].

Note: The credentials used here, are just an example how to run the containers; they're not production ready 
and should not be used like that; Always use strong passwords, hide them from command line.

### Setup

Build all the containers:

```
docker build --target=php-runtime -t phpfpm-image:1 .
docker build --target=nginx -t nginx:1 .
docker build --target=mariadb -t mariadb:1 .
```

### Run

Run with:

```
docker run --name php-fpm --network [network-name] phpfpm-image:1
docker run --network [network-name] -p 80:80 --name nginx nginx:1
docker run --network [network-name] -p 3306:3306 \
    -v my-db-vol:/var/lib/mysql \
    -e MARIADB_ROOT_PASSWORD=1 \
    -e MARIADB_USER=db \
    -e MARIADB_PASSWORD=secret \
    -e MARIADB_DATABASE=test \
    --name mariadb mariadb:1
```

The hostname for the MariaDB connection is "mariadb"

