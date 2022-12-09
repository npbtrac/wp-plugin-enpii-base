<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\ExternalLink;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\ConfigurableEnvironmentInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Event\DocumentParsedEvent;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\ExtensionInterface;

final class ExternalLinkExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addEventListener(DocumentParsedEvent::class, new ExternalLinkProcessor($environment), -50);
    }
}
