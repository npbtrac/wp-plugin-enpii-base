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

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Parser;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\ContextInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Cursor;

final class LazyParagraphParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        if (!$cursor->isIndented()) {
            return false;
        }

        $context->setBlocksParsed(true);

        return true;
    }
}
