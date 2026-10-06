# A simple multi-stage docker build

This is very basic docker-only multi-stage build app;
No compose, no docker-compose.yml.

First, create your network:

```docker network create [my-network-name]```

### Building stages

* Build PHP-FPM runtime stage

```docker build --target=php-runtime -t php-image:1 .```

* Build the Nginx stage
```docker build --target=nginx -t nginx-image:1 .```

### Run it

``` docker run --network [my-network-name] --name php-fpm php-image:1 ```
``` docker run --network [my-network-name] -p 80:80 --name nginx nginx-image:1 ```

You can access it via http://localhost (port 80 exposed and served).

This is just a simple showcase.
