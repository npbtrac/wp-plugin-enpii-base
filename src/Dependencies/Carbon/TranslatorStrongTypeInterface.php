<?php

/**
 * This file is part of the Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * Mark translator using strong type from symfony/translation >= 6.
 */
interface TranslatorStrongTypeInterface
{
    public function getFromCatalogue(MessageCatalogueInterface $catalogue, string $id, string $domain = 'messages');
}
