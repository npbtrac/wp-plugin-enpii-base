<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\League\CommonMark\Extension\HeadingPermalink;

use Enpii_Base\Deps\League\CommonMark\ConfigurableEnvironmentInterface;
use Enpii_Base\Deps\League\CommonMark\Event\DocumentParsedEvent;
use Enpii_Base\Deps\League\CommonMark\Extension\ExtensionInterface;

/**
 * Extension which automatically anchor links to heading elements
 */
final class HeadingPermalinkExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addEventListener(DocumentParsedEvent::class, new HeadingPermalinkProcessor(), -100);
        $environment->addInlineRenderer(HeadingPermalink::class, new HeadingPermalinkRenderer());
    }
}
