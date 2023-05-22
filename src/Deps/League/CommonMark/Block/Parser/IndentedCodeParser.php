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

namespace Enpii_Base\Deps\League\CommonMark\Block\Parser;

use Enpii_Base\Deps\League\CommonMark\Block\Element\IndentedCode;
use Enpii_Base\Deps\League\CommonMark\Block\Element\Paragraph;
use Enpii_Base\Deps\League\CommonMark\ContextInterface;
use Enpii_Base\Deps\League\CommonMark\Cursor;

final class IndentedCodeParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        if (!$cursor->isIndented()) {
            return false;
        }

        if ($context->getTip() instanceof Paragraph) {
            return false;
        }

        if ($cursor->isBlank()) {
            return false;
        }

        $cursor->advanceBy(Cursor::INDENT_LEVEL, true);
        $context->addBlock(new IndentedCode());

        return true;
    }
}
