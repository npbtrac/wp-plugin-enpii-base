<?php

declare(strict_types=1);

/*
 * This is part of the league/commonmark package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\League\CommonMark\Extension\Table;

use Enpii_Base\Deps\League\CommonMark\Block\Element\AbstractBlock;
use Enpii_Base\Deps\League\CommonMark\Block\Renderer\BlockRendererInterface;
use Enpii_Base\Deps\League\CommonMark\ElementRendererInterface;
use Enpii_Base\Deps\League\CommonMark\HtmlElement;

final class TableRowRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!$block instanceof TableRow) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        $attrs = $block->getData('attributes', []);

        $separator = $htmlRenderer->getOption('inner_separator', "\n");

        return new HtmlElement('tr', $attrs, $separator . $htmlRenderer->renderBlocks($block->children()) . $separator);
    }
}