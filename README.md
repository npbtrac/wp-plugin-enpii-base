## Installation
- Commands to set up the development environment
```shell script
cp .env.example .env
docker run --rm --interactive --tty --volume $PWD:/app composer composer install
docker-compose up -d
```
- Run the WP CLI command to prepare the necessary things
```
docker-compose exec wordpress wp enpii-base prepare_wp_app
```

## Explaination
- `dev-docker` is the folder for docker related stuffs
- `dev-docker/wordpress` would be the document root for the webserver default host (it's `/var/www/html` in the container)
- In the container `wordpress`
	- `devuser` is the user to own the files and folder
	- `nobody` is ths user of the webserver (for uploading files or create files using the web requests)

## Working with the containers
- To SSH to the wordpress containers
```
docker-compose exec --user=devuser wordpress sh
```

The local website will work with http://127.0.0.1:10108/ (or the port you put in env file)

## Development

### Base concepts
  - This plugin will create a laravel application `wp_app()` (a DI container https://code.tutsplus.com/tutorials/digging-in-to-laravels-ioc-container--cms-22167) contains everything we need.
  - Each plugin or theme will act as a Service Provider https://laravel.com/docs/7.x/providers
  - We are trying to implement Domain Driven Development (DDD) and Command Query Responsibility Segregation (CQRS)
    - Code sample here https://github.com/mguinea/laravel-ddd-example
    - More on DDD https://content-garden.com/domain-driven-design-ddd-principles-with-laravel
	- More on CQRS https://tsh.io/blog/cqrs-event-sourcing-php/, https://github.com/artisansdk/cqrs
    - Each hanlder is a class (1 class only for 1 handler). An action may contain many hanlders.

### Working with composer
- We should use `~1.0.3` when require a package (only update if bugfixing released)
- We use `mozart` (https://packagist.org/packages/coenjacobs/mozart) package to put the dependencies to a separate folder for the plugin to avoid the conflicts
  - We should use `mozart` globally
  - After running `composer update`, you need to run `mozart compose` (this should be run manually). If issues found related to some composer issues e.g. wrong included files, wrong path (due to the moving of files) ... you need to run `composer update` (or `composer dump-autoload`) one more time after fixing `composer.json` file.
#### Process to perform the composer and mozart:
  - Remove the `autoload -> files` part in composer.json
  - `composer install` or `composer update`
  - `composer dump-autoload`
  - `mozart compose`
  - Undo the removing `autoload -> files`
  - `composer dump-autoload`
#### After using `mozart`, remember to manually repair the namespace in:
  - `LogManager`, use namespace `as Monolog`
  - `ParseLogConfiguration` (same as above)
  - `Symfony\Component\Routing\Route`, find the keyword `compiler_class` and update that option value to the one with the namespace
  - Replace all `app()` -> `wp_app()`, `collect()` -> `wp_app_collect()`

### Naming Convention
- Spaces, indentation are defined in `.editorconfig`
- We follow WordPress conventions https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/#naming-conventions
	- Variables, functions, methods should be named in **snake_eye** rules e.g. `$current_date`, `get_latest_posts` (not `$currentDate` or `getLatestPosts`)
	- Classes, Traits, Interfaces, enum names should be named with capitalized words separated by underscores e.g. `Top_Gun`, `A_Simple_Payment_Gateway` (not `TopGun` or `ASimplePaymentGateway`)
- Running **phpcs** to find coding standard issues
	- With docker (we need to use php 7.4 to avoid errors)
	```shell script
	# Run the docker pull once if you haven't run that before
	docker pull serversideup/php:7.4-cli
	docker run --rm --interactive --tty -v $PWD:/var/www/html serversideup/php:7.4-cli ./vendor/bin/phpcs
	```
	- Or if you have your executable php 7.4 on your machine (we need to use php 7.4 to avoid errors)
	```shell script
	/path/to/your/php7.4/executable/file ./vendor/bin/phpcs
	```
- Running **phpcbf** to fix code style issues
	- With docker (we need to use php 7.4 to avoid errors)
	```shell script
	# Run the docker pull once if you haven't run that before
	docker pull serversideup/php:7.4-cli
	docker run --rm --interactive --tty -v $PWD:/var/www/html serversideup/php:7.4-cli ./vendor/bin/phpcbf <path-to-file-need-to-be-fixed>
	```
	- Or if you have your executable php 7.4 on your machine (we need to use php 7.4 to avoid errors)
	```shell script
	/path/to/your/php7.4/executable/file ./vendor/bin/phpcbf <path-to-file-need-to-be-fixed>
	```

### Install plugins and themes via the WP Admin Dashbboard
- We need to ensure needed folders are there (only run once)
```shell script
docker compose exec --user=webuser wordpress mkdir -p /var/www/html/wp-content/uploads >/dev/null 2>&1
docker compose exec --user=webuser wordpress mkdir -p /var/www/html/wp-content/upgrade >/dev/null 2>&1
docker compose exec --user=webuser wordpress mkdir -p /var/www/html/wp-content/cache >/dev/null 2>&1
docker compose exec --user=webuser wordpress chmod -R 777 /var/www/html/wp-content/cache /var/www/html/wp-content/uploads /var/www/html/wp-content/upgrade
```
- To install plugins and themes via the Admin Dashboard, you need to follow these steps:
	1. Add this part to `wp-config.php` (after `That's all ... ` line)
	```
	define( 'FS_METHOD', 'direct' );
	define( 'FS_CHMOD_DIR', (0755 & ~ umask()) );
	define( 'FS_CHMOD_FILE', (0644 & ~ umask()) );
	```
	2. Allow the file writting folders first
	For plugins:
	```shell script
	docker compose exec --user=devuser wordpress chmod g+w /var/www/html/wp-content/plugins/
	```

	For themes:
	```shell script
	docker compose exec --user=devuser wordpress chmod g+w /var/www/html/wp-content/themes/
	```

	3. Start to perform plugins, themes installation

	4. Revoke the write permission
	```shell script
	docker compose exec --user=devuser wordpress chmod g-w /var/www/html/wp-content/plugins/
	docker compose exec --user=devuser wordpress chmod g-w /var/www/html/wp-content/themes/
	```

	5. Remove the previous part added to `wp-config.php` (item 1)
