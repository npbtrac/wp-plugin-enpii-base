<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) Rezo Zero / Ambroise Maupate
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Footnote\Renderer;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Element\AbstractBlock;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Renderer\BlockRendererInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\ElementRendererInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Footnote\Node\FootnoteContainer;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\HtmlElement;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Util\ConfigurationAwareInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Util\ConfigurationInterface;

final class FootnoteContainerRenderer implements BlockRendererInterface, ConfigurationAwareInterface
{
    /** @var ConfigurationInterface */
    private $config;

    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof FootnoteContainer)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        $attrs = $block->getData('attributes', []);
        $attrs['class'] = $attrs['class'] ?? $this->config->get('footnote/container_class', 'footnotes');
        $attrs['role'] = 'doc-endnotes';

        $contents = new HtmlElement('ol', [], $htmlRenderer->renderBlocks($block->children()));
        if ($this->config->get('footnote/container_add_hr', true)) {
            $contents = [new HtmlElement('hr', [], null, true), $contents];
        }

        return new HtmlElement('div', $attrs, $contents);
    }

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
