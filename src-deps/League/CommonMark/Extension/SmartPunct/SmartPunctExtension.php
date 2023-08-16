<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (http://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\League\CommonMark\Extension\SmartPunct;

use Enpii_Base\Deps\League\CommonMark\Block\Element\Document;
use Enpii_Base\Deps\League\CommonMark\Block\Element\Paragraph;
use Enpii_Base\Deps\League\CommonMark\Block\Renderer as CoreBlockRenderer;
use Enpii_Base\Deps\League\CommonMark\ConfigurableEnvironmentInterface;
use Enpii_Base\Deps\League\CommonMark\Extension\ExtensionInterface;
use Enpii_Base\Deps\League\CommonMark\Inline\Element\Text;
use Enpii_Base\Deps\League\CommonMark\Inline\Renderer as CoreInlineRenderer;

final class SmartPunctExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addInlineParser(new QuoteParser(), 10)
            ->addInlineParser(new PunctuationParser(), 0)

            ->addDelimiterProcessor(QuoteProcessor::createDoubleQuoteProcessor(
                $environment->getConfig('smartpunct/double_quote_opener', Quote::DOUBLE_QUOTE_OPENER),
                $environment->getConfig('smartpunct/double_quote_closer', Quote::DOUBLE_QUOTE_CLOSER)
            ))
            ->addDelimiterProcessor(QuoteProcessor::createSingleQuoteProcessor(
                $environment->getConfig('smartpunct/single_quote_opener', Quote::SINGLE_QUOTE_OPENER),
                $environment->getConfig('smartpunct/single_quote_closer', Quote::SINGLE_QUOTE_CLOSER)
            ))

            ->addBlockRenderer(Document::class, new CoreBlockRenderer\DocumentRenderer(), 0)
            ->addBlockRenderer(Paragraph::class, new CoreBlockRenderer\ParagraphRenderer(), 0)

            ->addInlineRenderer(Quote::class, new QuoteRenderer(), 100)
            ->addInlineRenderer(Text::class, new CoreInlineRenderer\TextRenderer(), 0)
        ;
    }
}
