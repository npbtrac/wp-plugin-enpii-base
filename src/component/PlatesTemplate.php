<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 7/30/18
 * Time: 6:50 PM
 */

namespace Enpii\Wp\EnpiiBase\Component;


use Enpii\Wp\EnpiiBase\Base\Component;
use League\Plates\Engine;

class PlatesTemplate extends Component {
	/* @var Engine $plates_engine */
	public $plates_engine = null;

	public $base_template_path = null;
	public $fallback_template_path = null;
	public $plugin_template_path = null;

	public function __construct( array $config = null ) {
		parent::__construct( $config );

		$this->plates_engine = new Engine($this->base_template_path);
		if ($this->base_template_path !== $this->fallback_template_path) {
			$this->plates_engine->addFolder('parent', $this->fallback_template_path, true);
		}
		if ($this->plugin_template_path) {
			$this->plates_engine->addFolder('plugin', $this->plugin_template_path, true);
		}
	}

	/**
	 * Render a view
	 * @param $name
	 * @param array $data
	 *
	 * @return string
	 */
	public function render($name, array $data = array())
	{
		return $this->plates_engine->render($name, $data);
	}
}