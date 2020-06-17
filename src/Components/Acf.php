<?php


namespace Enpii\Wp\EnpiiBase\Components;


use Enpii\Wp\EnpiiBase\Yii2\Base\Component;

class Acf extends Component {
	/**
	 * Register Options for Footer (e.g. copyright text
	 */
	public function registerFooterOptions() {

	}

	/**
	 * Add an extra caption field to Flexible content layout title
	 *
	 * @param $title
	 * @param $field
	 * @param $layout
	 * @param $i
	 *
	 * @return bool
	 */
	public function addCaptionToFlexibleContent( $title, $field, $layout, $i ) {
		if ( $value = get_sub_field( 'caption' ) ) {
			return $title . ' - ' . $value;
		} else {
			foreach ( $layout['sub_fields'] as $sub ) {
				if ( $sub['name'] == 'caption' ) {
					$key = $sub['key'];
					if ( array_key_exists( $i, $field['value'] ) && $value = $field['value'][ $i ][ $key ] ) {
						return $title . ' - ' . $value;
					}
				}
			}
		}

		return $title;
	}
}
