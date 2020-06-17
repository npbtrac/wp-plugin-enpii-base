<?php


namespace Enpii\Wp\EnpiiBase\App\Helpers;


class TextHelper {

	/**
	 * Highlight the occurrence of words in a string in a text
	 *
	 * @param $text_to_highlight
	 * @param null $search_query
	 * @param string $regex_replacement
	 * @param int $text_replaced_count
	 *
	 * @return string|null
	 */
	public static function highlightKeyword( $text_to_highlight, $search_query = null, $regex_replacement = "<i class='found-text'>$0</i>", &$text_replaced_count = 0 ) {
		$search_query = trim( $search_query );
		$arr_tmp      = array_unique( preg_split( '/\s+/', $search_query ) );

		$arr_keyword_pattern   = [];
		$arr_keyword_pattern[] = "/\p{L}*?" . preg_quote( implode( ' ', $arr_tmp ) ) . "\p{L}*/i";
		foreach ( $arr_tmp as $key => $keyword_element ) {
			$keyword_element = str_replace( [ '"', "'" ], '', $keyword_element );

			if ( strlen( $keyword_element ) > 3 ) {
				$arr_keyword_pattern[] = "/\p{L}*" . preg_quote( $keyword_element ) . "\p{L}*/ui";
			} else {
				$arr_keyword_pattern[] = "/\b" . preg_quote( $keyword_element ) . "\b/ui";
			}
		}

		return preg_replace( $arr_keyword_pattern, $regex_replacement, $text_to_highlight, - 1, $text_replaced_count );
	}

	/**
	 * Shorten a text with highlighted keywords and some words around it
	 *
	 * @param $text_to_highlight
	 * @param null $search_query
	 * @param int $character_count
	 * @param string $str_ellipsis
	 * @param string $regex_replacement
	 * @param int $text_replaced_count
	 *
	 * @return string
	 */
	public static function getShortenedKeywordHighlightedText( $text_to_highlight, $search_query = null, $character_count = 36, $str_ellipsis = ' ... ', $regex_replacement = "<i class='found-text'>$0</i>", &$text_replaced_count = 0 ) {

		$search_query      = trim( $search_query );
		$text_to_highlight = preg_replace( '/[\s]+/', ' ', $text_to_highlight );

		$arr_tmp = array_unique( preg_split( '/\s+/', $search_query ) );

		$arr_keyword_pattern   = [];
		$arr_keyword_pattern[] = "/\p{L}*?" . preg_quote( implode( ' ', $arr_tmp ) ) . "\p{L}*/i";
		foreach ( $arr_tmp as $key => $keyword_element ) {
			$keyword_element = str_replace( [ '"', "'" ], '', $keyword_element );

			if ( strlen( $keyword_element ) > 3 ) {
				$arr_keyword_pattern[] = "/\p{L}*" . preg_quote( $keyword_element ) . "\p{L}*/ui";
			} else {
				$arr_keyword_pattern[] = "/\b" . preg_quote( $keyword_element ) . "\b/ui";
			}
		}

		$arr_text_to_return = [];

		$text_replaced_count = 0;
		foreach ( $arr_tmp as $index_arr => $search_term ) {
			if ( preg_match( '/[\s].{1,' . $character_count . '}(' . $search_term . ').{1,' . $character_count . '}[\s]/is', $text_to_highlight, $match ) ) {
				$text_with_keyword = $match[0];
			} else {
				$text_with_keyword = '';
			}

			$text_replaced_count_tmp = 0;
			if ( $tmp_text = preg_replace( $arr_keyword_pattern, $regex_replacement, $text_with_keyword, - 1, $text_replaced_count_tmp ) ) {
				$arr_text_to_return[] = $tmp_text;
				$text_replaced_count  += $text_replaced_count_tmp;
			}
		}

		return ! empty( $arr_text_to_return ) ? $str_ellipsis . implode( $str_ellipsis, $arr_text_to_return ) . $str_ellipsis : $str_ellipsis;
	}
}
