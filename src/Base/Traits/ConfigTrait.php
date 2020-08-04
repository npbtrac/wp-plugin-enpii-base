<?php
declare(strict_types=1);

namespace Enpiicom\WpPlugin\EnpiiBase\Base\Traits;

trait ConfigTrait
{
    /**
     * @param array $config
     */
    public function bindConfig(array $config)
    {
        foreach ((array)$config as $attrName => $attrValue) {
            if (property_exists($this, $attrName)) {
                $this->$attrName = $attrValue;
            }
        }
    }
}
