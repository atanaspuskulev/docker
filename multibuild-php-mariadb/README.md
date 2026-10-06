### Multi-build images with internal DNS database resolve

A basic Docker initialization to showcase multi-build image;

### Requirements

A ready network to join. Create one with:

```docker network create [name]```

A ready volume to be used by MariaDB:

```docker volume create [name]```

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
docker run --network network-name -p 80:80 --name nginx nginx:1
docker run --network simple-app -p 3306:3306 \
    -v my-db-vol:/var/lib/mysql \
    -e MARIADB_ROOT_PASSWORD=1 \
    -e MARIADB_USER=db \
    -e MARIADB_PASSWORD=secret \
    -e MARIADB_DATABASE=test 
    --name mariadb db:1
```

The hostname for the MariaDB connection is "mariadb"

