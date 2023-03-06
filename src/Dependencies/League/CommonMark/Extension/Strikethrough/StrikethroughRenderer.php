<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com> and uAfrica.com (http://uafrica.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Strikethrough;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\ElementRendererInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\HtmlElement;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Inline\Element\AbstractInline;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Inline\Renderer\InlineRendererInterface;

final class StrikethroughRenderer implements InlineRendererInterface
{
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Strikethrough)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        return new HtmlElement('del', $inline->getData('attributes', []), $htmlRenderer->renderInlines($inline->children()));
    }
}
