<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php echo '<title>' . esc_html( wp_get_document_title() ) . '</title>'; ?>
</head>

<body>
	<main class="wp-block-group">
		@yield('content')
	</main>
</body>
</html>
