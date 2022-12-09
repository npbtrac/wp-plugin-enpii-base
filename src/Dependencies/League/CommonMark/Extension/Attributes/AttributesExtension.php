<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) 2015 Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Attributes;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\ConfigurableEnvironmentInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Event\DocumentParsedEvent;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Attributes\Event\AttributesListener;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Attributes\Parser\AttributesBlockParser;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Attributes\Parser\AttributesInlineParser;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\ExtensionInterface;

final class AttributesExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockParser(new AttributesBlockParser());
        $environment->addInlineParser(new AttributesInlineParser());
        $environment->addEventListener(DocumentParsedEvent::class, [new AttributesListener(), 'processDocument']);
    }
}
