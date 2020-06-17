<?php


namespace Enpii\Wp\EnpiiBase\App\Helpers;

/**
 * Class WpCommon
 * @package Enpii\Wp\EnpiiBase
 *
 * Handle common operations of WP
 */
class WpCommonHelper {
	/**
	 * Get content of a template block for the layout with params
	 * Template file should be in `templates` folder of child theme, parent theme or of this plugin
	 *
	 * @param string $template_slug name of the template
	 * @param array $params arguments needed to be sent to the view
	 *
	 * @return string
	 */
	public static function getTemplate( $template_slug, $params = [] ) {
		// Todo: add object cache function for template
		extract( $params );

		ob_start();
		echo locate_template( $template_slug );
		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	/**
	 * Turn a content to complete output like `the_content`
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public static function getPostContent( $content ) {
		/**
		 * Filters the post content.
		 *
		 * @param string $content Content of the current post.
		 *
		 * @since 0.71
		 *
		 */
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );

		return $content;
	}

	/**
	 * Escape a rich text field entered from Admin
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public static function escEditorField( $content ) {
		$content = static::getPostContent( $content );

		return wp_kses_post( $content );
	}

	/**
	 * Handle HTML Text to produce a safe rich text
	 *
	 * @param $html_text
	 *
	 * @return string
	 */
	public function processHtml( $html_text ) {
		$content = wp_kses( $html_text, $GLOBALS['allowedposttags'] );

		return static::getPostContent( $content );
	}

	/**
	 * Handle HTML Text to produce a safe rich text inside an <a> tag
	 *
	 * @param $html_text
	 *
	 * @return string
	 */
	public function process_html_for_a( $html_text ) {
		$allowed_tags_for_a = $GLOBALS['allowedposttags'];
		unset( $allowed_tags_for_a['a'] );

		$content = wp_kses( $html_text, $allowed_tags_for_a );

		return static::getPostContent( $content );
	}
}
