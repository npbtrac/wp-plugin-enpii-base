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

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Inline\Renderer;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\ElementRendererInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Inline\Element\AbstractInline;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Inline\Element\Text;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Util\Xml;

final class TextRenderer implements InlineRendererInterface
{
    /**
     * @param Text                     $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Text)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }

        return Xml::escape($inline->getContent());
    }
}
