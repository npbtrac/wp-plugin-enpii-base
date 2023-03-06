<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\DisallowedRawHtml;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Element\HtmlBlock;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Renderer\HtmlBlockRenderer;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\ConfigurableEnvironmentInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\ExtensionInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Inline\Element\HtmlInline;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Inline\Renderer\HtmlInlineRenderer;

final class DisallowedRawHtmlExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockRenderer(HtmlBlock::class, new DisallowedRawHtmlBlockRenderer(new HtmlBlockRenderer()), 50);
        $environment->addInlineRenderer(HtmlInline::class, new DisallowedRawHtmlInlineRenderer(new HtmlInlineRenderer()), 50);
    }
}
