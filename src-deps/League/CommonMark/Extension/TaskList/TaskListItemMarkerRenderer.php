<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\League\CommonMark\Extension\TaskList;

use Enpii_Base\Deps\League\CommonMark\ElementRendererInterface;
use Enpii_Base\Deps\League\CommonMark\HtmlElement;
use Enpii_Base\Deps\League\CommonMark\Inline\Element\AbstractInline;
use Enpii_Base\Deps\League\CommonMark\Inline\Renderer\InlineRendererInterface;

final class TaskListItemMarkerRenderer implements InlineRendererInterface
{
    /**
     * @param TaskListItemMarker       $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement|string|null
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof TaskListItemMarker)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }

        $checkbox = new HtmlElement('input', [], '', true);

        if ($inline->isChecked()) {
            $checkbox->setAttribute('checked', '');
        }

        $checkbox->setAttribute('disabled', '');
        $checkbox->setAttribute('type', 'checkbox');

        return $checkbox;
    }
}
