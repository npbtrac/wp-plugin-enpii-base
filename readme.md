## Introduction
- Since I needed to do a lot of WordPress projects and they have same formula so I decide to create this plugin as a base plugin for all of my WordPress development.

## Local Development
- If you want to use this plugin as standalone development environment, you can use docker containers made for it
```shell script
cp .env.example .env
docker-compose up -d
docker run --rm -v ${PWD}:/var/www/html npbtrac/php:latest-cli composer update
docker-compose exec php_fpm /shared/wp-install.sh
```
