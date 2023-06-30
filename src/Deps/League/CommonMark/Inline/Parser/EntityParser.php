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

namespace Enpii_Base\Deps\League\CommonMark\Inline\Parser;

use Enpii_Base\Deps\League\CommonMark\Inline\Element\Text;
use Enpii_Base\Deps\League\CommonMark\InlineParserContext;
use Enpii_Base\Deps\League\CommonMark\Util\Html5EntityDecoder;
use Enpii_Base\Deps\League\CommonMark\Util\RegexHelper;

final class EntityParser implements InlineParserInterface
{
    public function getCharacters(): array
    {
        return ['&'];
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        if ($m = $inlineContext->getCursor()->match('/^' . RegexHelper::PARTIAL_ENTITY . '/i')) {
            $inlineContext->getContainer()->appendChild(new Text(Html5EntityDecoder::decode($m)));

            return true;
        }

        return false;
    }
}