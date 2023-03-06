<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Controller;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Request;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Responsible for resolving the value of an argument based on its metadata.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
interface ArgumentValueResolverInterface
{
    /**
     * Whether this resolver can resolve the value for the given ArgumentMetadata.
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument);

    /**
     * Returns the possible value(s).
     *
     * @return iterable
     */
    public function resolve(Request $request, ArgumentMetadata $argument);
}
