<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\League\CommonMark\Extension\ExternalLink;

use Enpii_Base\Deps\League\CommonMark\ConfigurableEnvironmentInterface;
use Enpii_Base\Deps\League\CommonMark\Event\DocumentParsedEvent;
use Enpii_Base\Deps\League\CommonMark\Extension\ExtensionInterface;

final class ExternalLinkExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addEventListener(DocumentParsedEvent::class, new ExternalLinkProcessor($environment), -50);
    }
}
