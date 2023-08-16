<?php

namespace Enpii_Base\Deps\Illuminate\Broadcasting;

use Enpii_Base\Deps\Illuminate\Http\Request;
use Enpii_Base\Deps\Illuminate\Routing\Controller;
use Enpii_Base\Deps\Illuminate\Support\Facades\Broadcast;

class BroadcastController extends Controller
{
    /**
     * Authenticate the request for channel access.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @return \Enpii_Base\Deps\Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        if ($request->hasSession()) {
            $request->session()->reflash();
        }

        return Broadcast::auth($request);
    }
}
