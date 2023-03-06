<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Resources;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Collection;
use JsonSerializable;

class MergeValue
{
    /**
     * The data to be merged.
     *
     * @var array
     */
    public $data;

    /**
     * Create new merge value instance.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Collection|\JsonSerializable|array  $data
     * @return void
     */
    public function __construct($data)
    {
        if ($data instanceof Collection) {
            $this->data = $data->all();
        } elseif ($data instanceof JsonSerializable) {
            $this->data = $data->jsonSerialize();
        } else {
            $this->data = $data;
        }
    }
}
