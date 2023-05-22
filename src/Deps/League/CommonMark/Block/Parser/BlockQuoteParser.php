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

use Enpii_Base\Deps\League\CommonMark\Block\Element\BlockQuote;
use Enpii_Base\Deps\League\CommonMark\ContextInterface;
use Enpii_Base\Deps\League\CommonMark\Cursor;

final class BlockQuoteParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        if ($cursor->isIndented()) {
            return false;
        }

        if ($cursor->getNextNonSpaceCharacter() !== '>') {
            return false;
        }

        $cursor->advanceToNextNonSpaceOrTab();
        $cursor->advanceBy(1);
        $cursor->advanceBySpaceOrTab();

        $context->addBlock(new BlockQuote());

        return true;
    }
}
