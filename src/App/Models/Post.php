<?php

declare(strict_types=1);

namespace Enpii_Base\App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

	/**
	 * We may want to use Wpdb_Connection for the db
	 * @var string
	 */
	protected $connection = 'wpdb';

	public static function insert( ...$params ) {
		// Use wp_insert_post() instead
		throw new Exception( 'Invalid Method Call' );
	}

	public function update( array $attributes = [], array $options = [] ) {
		// Use wp_update_post() instead
		throw new Exception( 'Invalid Method Call' );
	}

	public function delete() {
		// Use wp_delete_post() instead
		throw new Exception( 'Invalid Method Call' );
	}
}
