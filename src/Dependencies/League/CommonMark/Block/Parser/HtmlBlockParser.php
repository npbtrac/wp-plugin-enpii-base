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

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Element\HtmlBlock;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Element\Paragraph;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\ContextInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Cursor;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Util\RegexHelper;

final class HtmlBlockParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        if ($cursor->isIndented()) {
            return false;
        }

        if ($cursor->getNextNonSpaceCharacter() !== '<') {
            return false;
        }

        $savedState = $cursor->saveState();

        $cursor->advanceToNextNonSpaceOrTab();
        $line = $cursor->getRemainder();

        for ($blockType = 1; $blockType <= 7; $blockType++) {
            $match = RegexHelper::matchAt(
                RegexHelper::getHtmlBlockOpenRegex($blockType),
                $line
            );

            if ($match !== null && ($blockType < 7 || !($context->getContainer() instanceof Paragraph))) {
                $cursor->restoreState($savedState);
                $context->addBlock(new HtmlBlock($blockType));
                $context->setBlocksParsed(true);

                return true;
            }
        }

        $cursor->restoreState($savedState);

        return false;
    }
}
