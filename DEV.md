### For pushing to WordPress.org repo
- To get dependencies for PHP 8.0
```
COMPOSER=composer-php80down.json composer install --no-dev --ignore-platform-reqs
```
- Get all needed dependencies
```
composer update --ignore-platform-reqs
```

### For telescope
- Publish telescope assets
```
wp enpii-base artisan vendor:publish --tag=telescope-assets
```
For php 7.4 (wp74 should be the wp-cli running with php 7.4)
```
wp74 enpii-base artisan telescope:publish --force
wp74 enpii-base artisan --force vendor:publish --tag=telescope-assets # alternative way
```
- Publish telescope migrations
```
wp enpii-base artisan vendor:publish --tag=telescope-migrations
```
