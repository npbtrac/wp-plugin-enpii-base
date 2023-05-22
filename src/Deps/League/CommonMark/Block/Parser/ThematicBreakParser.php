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

use Enpii_Base\Deps\League\CommonMark\Block\Element\ThematicBreak;
use Enpii_Base\Deps\League\CommonMark\ContextInterface;
use Enpii_Base\Deps\League\CommonMark\Cursor;
use Enpii_Base\Deps\League\CommonMark\Util\RegexHelper;

final class ThematicBreakParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        if ($cursor->isIndented()) {
            return false;
        }

        $match = RegexHelper::matchAt(RegexHelper::REGEX_THEMATIC_BREAK, $cursor->getLine(), $cursor->getNextNonSpacePosition());
        if ($match === null) {
            return false;
        }

        // Advance to the end of the string, consuming the entire line (of the thematic break)
        $cursor->advanceToEnd();

        $context->addBlock(new ThematicBreak());
        $context->setBlocksParsed(true);

        return true;
    }
}
