<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Controllers;

use Enpii_Base\App\Models\Post;
use Enpii_Base\App\WP\Enpii_Base_WP_Plugin;
use Enpii_Base\Foundation\Http\Base_Controller;
use Illuminate\Support\Facades\Artisan;

class Main_Controller extends Base_Controller {
	public function index() {
		return Enpii_Base_WP_Plugin::wp_app_instance()->view( 'main/index' );
	}

	public function queue_work() {
		Artisan::call(
			'queue:work',
			[
				'connection' => 'database',
				'--queue' => 'high,default,low',
				'--tries' => 3,
				'--quiet' => true,
				'--stop-when-empty' => true,
				'--timeout' => 60,
				'--memory' => 256,
			]
		);

		return ' Queue Work ';
	}

	public function post() {
		// This will render the index.php template in the theme: return wp_app_view( 'index' )

		// Below would render the query like this
		// "select * from `wps_posts` where
		//  (`post_status` = ? or `post_title` LIKE ?)
		//  or (`post_status` = ? and `post_title` LIKE ?)"
		$queryBuilder = Post::where(
			[
				[ 'post_status', '=', 'publish' ],
				[ 'post_title', 'LIKE', 'hello%', 'or' ],
			]
		)
		->orWhere(
			[
				[ 'post_status', '=', 'publish' ],
				[ 'post_title', 'LIKE', '%world%' ],
			]
		);
		$post = $queryBuilder->firstOrFail();

		/** @var \WP_Query $wp_query */
		$wp_query = $GLOBALS['wp_query'];
		$wp_query = new \WP_Query(
			[
				'p' => $post->ID,
			] 
		);
		$wp_query->the_post();

		return Enpii_Base_WP_Plugin::wp_app_instance()->view( 'main/post' );
	}

	public function page() {
		/** @var \WP_Query $wp_query */
		$wp_query = $GLOBALS['wp_query'];
		$wp_query = new \WP_Query(
			[
				'page_id' => 2,
			] 
		);
		$wp_query->the_post();

		return Enpii_Base_WP_Plugin::wp_app_instance()->view( 'main/page' );
	}
}
