<?php

declare(strict_types=1);

namespace Enpii_Base\App\Support;

class App_Const {
	const ACTION_WP_APP_BROADCAST_CHANNELS = 'enpii_base_wp_app_broadcast_channels';
	const ACTION_WP_APP_REGISTERED = 'enpii_base_wp_app_registered';
	const ACTION_WP_APP_BOOTSTRAP = 'enpii_base_wp_app_bootstrap';
	const ACTION_WP_APP_REGISTER_ROUTES = 'enpii_base_wp_app_register_routes';
	const ACTION_WP_API_REGISTER_ROUTES = 'enpii_base_wp_api_register_routes';
	const ACTION_WP_APP_INIT = 'enpii_base_wp_app_init';
	const ACTION_WP_APP_PARSE_REQUEST = 'enpii_base_wp_app_parse_request';
	const ACTION_WP_APP_DO_WP_MAIN_QUERY = 'enpii_base_wp_app_do_wp_main_query';
	const ACTION_WP_APP_RENDER_WP_TEMPLATE = 'enpii_base_wp_app_render_wp_template';
	const ACTION_WP_APP_SKIP_USE_WP_THEME = 'enpii_base_wp_app_skip_use_wp_theme';
	const ACTION_WP_APP_COMPLETE_EXECUTION = 'enpii_base_wp_app_complete_execution';

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
	const FILTER_WP_APP_MAIN_SERVICE_PROVIDERS = 'enpii_base_wp_app_main_service_providers';
}
