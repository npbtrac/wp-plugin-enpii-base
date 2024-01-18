### Prepare the `wp-release`
We need to include all vendors to the repo then remove all `require` things in the composer.json file for skipping dependencies when this package being required.
- Switch to `wp-release` branch
- Delete all vendors
```
rm -rf vendor vendor-legacy
```
- Copy all needed files from master to this branch
```
git checkout master -- database public-assets resources src wp-app-config .editorconfig composer-legacy.json composer-legacy.lock composer.json composer.lock enpii-base-bootstrap.php enpii-base-init.php enpii-base.php
```
- Install and add vendors
```
composer81 install --no-dev
COMPOSER=composer-legacy.json composer73 install --no-dev
```
- Then add all files to the repo, commit and push
