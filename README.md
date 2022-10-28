## Development

### Installation
- Commands to set up the development environment 
```shell script
cp .env.example .env
cp -r ./dev-docker/config-example ./dev-docker/config
cp ./dev-docker/config/wordpress/wp-config.php.example ./dev-docker/config/wordpress/wp-config.php
docker run --rm --interactive --tty --volume $PWD:/app composer composer install
docker-compose up -d
```
#### Explaination
- `dev-docker` is the folder for docker related stuffs
- `dev-docker/wordpress` would be the document root for the webserver default host (it's `/var/www/html/public` in the container)

### Working with the containers
- To SSH to the wordpress containers
```
docker-compose exec --user=webuser wordpress bash
```

The local website will work with http://127.0.0.1:10108/
