<?php
do_action( 'get_header' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport"
			content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<title>{{ enpii_base_wp_app_web_page_title() }}</title>
	<?php wp_head(); ?>
</head>

<body>
	<main class="wp-block-group">
		@yield('content')
	</main>
<?php
do_action( 'get_footer' );
wp_footer();
?>
</body>
</html>
