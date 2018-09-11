<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 9/11/18
 * Time: 3:36 PM
 */

namespace Enpii\Wp\EnpiiBase\Component;

use Enpii\Wp\EnpiiBase\Base\ComponentTrait;
use Snscripts\HtmlHelper\Html;

class HtmlHelper extends Html {
	use ComponentTrait {
		ComponentTrait::__construct as private __componentConstruct;
	}

	public $form_class;
	public $basic_form_interface;
	public $basic_router_interface;
	public $basic_assets_interface;

	/**
	 * Instance constructor.
	 * Initialize values for object based on configuration array
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->__componentConstruct( $config );

		parent::__construct(
			new $this->form_class(
				new $this->basic_form_interface()
			),
			new $this->basic_router_interface(),
			new $this->basic_assets_interface()
		);
	}
}