<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\League\CommonMark\Extension\InlinesOnly;

use Enpii_Base\Deps\League\CommonMark\Block\Element\Document;
use Enpii_Base\Deps\League\CommonMark\Block\Element\Paragraph;
use Enpii_Base\Deps\League\CommonMark\Block\Parser as BlockParser;
use Enpii_Base\Deps\League\CommonMark\ConfigurableEnvironmentInterface;
use Enpii_Base\Deps\League\CommonMark\Delimiter\Processor\EmphasisDelimiterProcessor;
use Enpii_Base\Deps\League\CommonMark\Extension\ExtensionInterface;
use Enpii_Base\Deps\League\CommonMark\Inline\Element as InlineElement;
use Enpii_Base\Deps\League\CommonMark\Inline\Parser as InlineParser;
use Enpii_Base\Deps\League\CommonMark\Inline\Renderer as InlineRenderer;

final class InlinesOnlyExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $childRenderer = new ChildRenderer();

        $environment
            ->addBlockParser(new BlockParser\LazyParagraphParser(), -200)

            ->addInlineParser(new InlineParser\NewlineParser(),     200)
            ->addInlineParser(new InlineParser\BacktickParser(),    150)
            ->addInlineParser(new InlineParser\EscapableParser(),    80)
            ->addInlineParser(new InlineParser\EntityParser(),       70)
            ->addInlineParser(new InlineParser\AutolinkParser(),     50)
            ->addInlineParser(new InlineParser\HtmlInlineParser(),   40)
            ->addInlineParser(new InlineParser\CloseBracketParser(), 30)
            ->addInlineParser(new InlineParser\OpenBracketParser(),  20)
            ->addInlineParser(new InlineParser\BangParser(),         10)

            ->addBlockRenderer(Document::class, $childRenderer, 0)
            ->addBlockRenderer(Paragraph::class, $childRenderer, 0)

            ->addInlineRenderer(InlineElement\Code::class,       new InlineRenderer\CodeRenderer(),       0)
            ->addInlineRenderer(InlineElement\Emphasis::class,   new InlineRenderer\EmphasisRenderer(),   0)
            ->addInlineRenderer(InlineElement\HtmlInline::class, new InlineRenderer\HtmlInlineRenderer(), 0)
            ->addInlineRenderer(InlineElement\Image::class,      new InlineRenderer\ImageRenderer(),      0)
            ->addInlineRenderer(InlineElement\Link::class,       new InlineRenderer\LinkRenderer(),       0)
            ->addInlineRenderer(InlineElement\Newline::class,    new InlineRenderer\NewlineRenderer(),    0)
            ->addInlineRenderer(InlineElement\Strong::class,     new InlineRenderer\StrongRenderer(),     0)
            ->addInlineRenderer(InlineElement\Text::class,       new InlineRenderer\TextRenderer(),       0)
        ;

        if ($environment->getConfig('use_asterisk', true)) {
            $environment->addDelimiterProcessor(new EmphasisDelimiterProcessor('*'));
        }
        if ($environment->getConfig('use_underscore', true)) {
            $environment->addDelimiterProcessor(new EmphasisDelimiterProcessor('_'));
        }
    }
}
