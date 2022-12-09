<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Broadcasting;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Controller;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Broadcast;

class BroadcastController extends Controller
{
    /**
     * Authenticate the request for channel access.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        if ($request->hasSession()) {
            $request->session()->reflash();
        }

        return Broadcast::auth($request);
    }
}
