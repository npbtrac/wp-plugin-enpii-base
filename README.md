##Development
```shell script
cp .env.example .env
cp ./docker/wordpress/wp-config-sample.php ./docker/wordpress/wp-config.php
docker run --rm --interactive --tty --volume $PWD:/app composer composer install
docker-compose up -d
```
The local website will work with http://127.0.0.1:11080/
