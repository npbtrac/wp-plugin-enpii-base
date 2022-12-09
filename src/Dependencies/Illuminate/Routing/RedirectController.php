<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Str;

class RedirectController extends Controller
{
    /**
     * Invoke the controller method.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\UrlGenerator  $url
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, UrlGenerator $url)
    {
        $parameters = wp_app_collect($request->route()->parameters());

        $status = $parameters->get('status');

        $destination = $parameters->get('destination');

        $parameters->forget('status')->forget('destination');

        $route = (new Route('GET', $destination, [
            'as' => 'laravel_route_redirect_destination',
        ]))->bind($request);

        $parameters = $parameters->only(
            $route->getCompiled()->getPathVariables()
        )->toArray();

        $url = $url->toRoute($route, $parameters, false);

        if (! Str::startsWith($destination, '/') && Str::startsWith($url, '/')) {
            $url = Str::after($url, '/');
        }

        return new RedirectResponse($url, $status);
    }
}
