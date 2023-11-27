<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Controllers;

use Enpii_Base\App\Models\Post;
use Enpii_Base\App\WP\Enpii_Base_WP_Plugin;
use Enpii_Base\Foundation\Http\Base_Controller;

class Index_Controller extends Base_Controller {
	public function index() {
		// This will render the index.php template in the theme: wp_app_view( 'index' )

		// Below would render the query like this
		// "select * from `wps_posts` where
		//	(`post_status` = ? or `post_title` LIKE ?)
		//	or (`post_status` = ? and `post_title` LIKE ?)"
		$queryBuilder = Post::where([
			['post_status', '=', 'publish'],
			['post_title', 'LIKE', "hello%", 'or'],
		])
		->orWhere([
			['post_status', '=', 'draft'],
			['post_title', 'LIKE', "%cy"],
		]);
		$post = $queryBuilder->firstOrFail();

		return 'Welcome to WP App from Enpii Base';
	}

	public function enpii_base() {
		return wp_app(Enpii_Base_WP_Plugin::class)->view('index/home');
	}
}
