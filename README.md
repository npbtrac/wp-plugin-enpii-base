## Development

### Installation
```shell script
cp .env.example .env
cp -r ./docker/config-example ./docker/config
cp ./docker/wp-config.php.example ./docker/wp-config.php
docker run --rm --interactive --tty --volume $PWD:/app composer composer install
docker-compose up -d
```
The local website will work with http://127.0.0.1:10108/
