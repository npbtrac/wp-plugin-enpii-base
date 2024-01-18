<?php

declare(strict_types=1);

namespace Enpii_Base\App\Models;

use Enpii_Base\App\Support\Traits\Model_Multisite_Trait;
use Exception;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use LogicException;

class WC_Order_Model extends Model {
	use Model_Multisite_Trait;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'wc_orders';

	/**
	 * Use with your own risks, you may want to use \WC_Order::save() instead
	 *
	 * @param array $options
	 * @return bool
	 * @throws InvalidArgumentException
	 * @throws InvalidCastException
	 * @throws Exception
	 */
	// phpcs:ignore Generic.CodeAnalysis.UselessOverridingMethod.Found
	public function save( array $options = [] ) {
		parent::save( $options );
	}

	/**
	 * Use with your own risks, you may want to use \WC_Order::save() instead
	 *
	 * @param array $attributes
	 * @param array $options
	 * @return bool
	 * @throws InvalidArgumentException
	 * @throws InvalidCastException
	 * @throws Exception
	 */
	// phpcs:ignore Generic.CodeAnalysis.UselessOverridingMethod.Found
	public function update( array $attributes = [], array $options = [] ) {
		parent::update( $attributes, $options );
	}

	/**
	 * Use with your own risks, you may want to use wp_delete_post() instead
	 *
	 * @return bool|null
	 * @throws LogicException
	 */
	// phpcs:ignore Generic.CodeAnalysis.UselessOverridingMethod.Found
	public function delete() {
		parent::delete();
	}
}
