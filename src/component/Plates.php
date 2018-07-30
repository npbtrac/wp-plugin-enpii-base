<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 7/30/18
 * Time: 6:50 PM
 */

namespace Enpii\Wp\EnpiiBase\Component;


use Enpii\Wp\EnpiiBase\Base\Component;

class PlatesComponent extends Component {
	public $_plates = null;

	public function __construct( array $config = null ) {
		parent::__construct( $config );

	}
}