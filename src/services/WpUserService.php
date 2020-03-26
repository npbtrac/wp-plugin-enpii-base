<?php


namespace Enpii\Wp\EnpiiBase\Services;


use Enpii\Wp\EnpiiBase\Libs\Traits\ServiceTrait;

class WpUserService {
	use ServiceTrait;

	public $enable_site_manager_role = false;

	public function __construct( $config = null ) {
		echo '<pre> $config: ';
		print_r( $config );
		echo '</pre>';
		die( '$config' );

	}
}