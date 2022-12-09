<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (https://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Renderer;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Element\AbstractBlock;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Element\ThematicBreak;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\ElementRendererInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\HtmlElement;

final class ThematicBreakRenderer implements BlockRendererInterface
{
    /**
     * @param ThematicBreak            $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return HtmlElement
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof ThematicBreak)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        $attrs = $block->getData('attributes', []);

        return new HtmlElement('hr', $attrs, '', true);
    }
}
