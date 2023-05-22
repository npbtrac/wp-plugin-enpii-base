<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\League\CommonMark\Extension\DisallowedRawHtml;

use Enpii_Base\Deps\League\CommonMark\ElementRendererInterface;
use Enpii_Base\Deps\League\CommonMark\Inline\Element\AbstractInline;
use Enpii_Base\Deps\League\CommonMark\Inline\Renderer\InlineRendererInterface;
use Enpii_Base\Deps\League\CommonMark\Util\ConfigurationAwareInterface;
use Enpii_Base\Deps\League\CommonMark\Util\ConfigurationInterface;

final class DisallowedRawHtmlInlineRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    /** @var InlineRendererInterface */
    private $htmlInlineRenderer;

    public function __construct(InlineRendererInterface $htmlBlockRenderer)
    {
        $this->htmlInlineRenderer = $htmlBlockRenderer;
    }

    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        $rendered = $this->htmlInlineRenderer->render($inline, $htmlRenderer);

        if ($rendered === '') {
            return '';
        }

        // Match these types of tags: <title> </title> <title x="sdf"> <title/> <title />
        return preg_replace('/<(\/?(?:title|textarea|style|xmp|iframe|noembed|noframes|script|plaintext)[ \/>])/i', '&lt;$1', $rendered);
    }

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        if ($this->htmlInlineRenderer instanceof ConfigurationAwareInterface) {
            $this->htmlInlineRenderer->setConfiguration($configuration);
        }
    }
}
