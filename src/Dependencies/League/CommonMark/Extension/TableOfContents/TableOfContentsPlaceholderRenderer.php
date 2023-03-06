<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\TableOfContents;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Element\AbstractBlock;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Renderer\BlockRendererInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\ElementRendererInterface;

final class TableOfContentsPlaceholderRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        return '<!-- table of contents -->';
    }
}
