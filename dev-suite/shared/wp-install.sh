#!/bin/bash
source "$PWD/wp-content/plugins/enpii-base/.env"

wp core install \
  --url=$PROJECT_BASE_URL \
  --title="$PROJECT_NAME" \
  --admin_user="$WP_ADMIN_USER" \
  --admin_password="$WP_ADMIN_PASSWORD" \
  --admin_email="$WP_ADMIN_EMAIL"\
  --skip-email
wp plugin activate enpii-base
