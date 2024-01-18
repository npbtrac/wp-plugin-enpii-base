<?php

declare(strict_types=1);

namespace Enpii_Base\App\Support;

class App_Const {
	const ACTION_WP_APP_LOADED = 'enpii_base_wp_app_loaded';
	const ACTION_WP_APP_REGISTERED = 'enpii_base_wp_app_registered';
	const ACTION_WP_APP_BOOTED = 'enpii_base_wp_app_booted';
	const ACTION_WP_APP_BOOTSTRAP = 'enpii_base_wp_app_bootstrap';
	const ACTION_WP_APP_REGISTER_ROUTES = 'enpii_base_wp_app_register_routes';
	const ACTION_WP_API_REGISTER_ROUTES = 'enpii_base_wp_api_register_routes';
	const ACTION_WP_APP_INIT = 'enpii_base_wp_app_init';
	const ACTION_WP_APP_COMPLETE_EXECUTION = 'enpii_base_wp_app_complete_execution';
	const ACTION_WP_APP_WEB_WORKER = 'enpii_base_wp_app_web_worker';
	const ACTION_WP_APP_SCHEDULE_RUN = 'enpii_base_wp_app_schedule_run';
	const ACTION_WP_APP_SETUP_APP = 'enpii_base_wp_app_setup_app';
	const ACTION_WP_APP_BROADCAST_CHANNELS = 'enpii_base_wp_app_broadcast_channels';
	const ACTION_WP_APP_AUTH_BOOT = 'enpii_base_wp_app_auth_boot';

	const FILTER_WP_APP_PREPARE_CONFIG = 'enpii_base_wp_app_prepare_config';
	const FILTER_WP_APP_MAIN_SERVICE_PROVIDERS = 'enpii_base_wp_app_main_service_providers';
	const FILTER_WP_APP_APP_CONFIG = 'enpii_base_wp_app_app_config';
	const FILTER_WP_APP_AUTH_CONFIG = 'enpii_base_wp_app_auth_config';
	const FILTER_WP_APP_BROADCASTING_CONFIG = 'enpii_base_wp_app_broadcasting_config';
	const FILTER_WP_APP_CACHE_CONFIG = 'enpii_base_wp_app_cache_config';
	const FILTER_WP_APP_DATABASE_CONFIG = 'enpii_base_wp_app_database_config';
	const FILTER_WP_APP_FILESYSTEMS_CONFIG = 'enpii_base_wp_app_filsystems_config';
	const FILTER_WP_APP_HASHING_CONFIG = 'enpii_base_wp_app_hashing_config';
	const FILTER_WP_APP_LOGGING_CONFIG = 'enpii_base_wp_app_logging_config';
	const FILTER_WP_APP_MAIL_CONFIG = 'enpii_base_wp_app_mail_config';
	const FILTER_WP_APP_QUEUE_CONFIG = 'enpii_base_wp_app_queue_config';
	const FILTER_WP_APP_SESSION_CONFIG = 'enpii_base_wp_app_session_config';
	const FILTER_WP_APP_TELESCOPE_CONFIG = 'enpii_base_wp_app_telescope_config';
	const FILTER_WP_APP_TINKER_CONFIG = 'enpii_base_wp_app_tinker_config';
	const FILTER_WP_APP_VIEW_CONFIG = 'enpii_base_wp_app_view_config';
	const FILTER_WP_APP_PASSPORT_CONFIG = 'enpii_base_wp_app_passport_config';
	const FILTER_WP_APP_WEB_PAGE_TITLE = 'enpii_base_wp_app_web_page_title';

	const QUEUE_HIGH = 'high';
	const QUEUE_DEFAULT = 'default';
	const QUEUE_LOW = 'low';
	const QUEUE_BACKOFF = 'queue_backoff';

	const USER_META_CLIENT_CREDENTIALS_APP_ID = 'client_credentials_app_id';
	const USER_META_CLIENT_CREDENTIALS_APP_SECRET = 'client_credentials_app_secret';
}
