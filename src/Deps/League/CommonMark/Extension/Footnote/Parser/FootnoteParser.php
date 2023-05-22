<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) Rezo Zero / Ambroise Maupate
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Parser;

use Enpii_Base\Deps\League\CommonMark\Block\Parser\BlockParserInterface;
use Enpii_Base\Deps\League\CommonMark\ContextInterface;
use Enpii_Base\Deps\League\CommonMark\Cursor;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Node\Footnote;
use Enpii_Base\Deps\League\CommonMark\Reference\Reference;
use Enpii_Base\Deps\League\CommonMark\Util\RegexHelper;

final class FootnoteParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        if ($cursor->isIndented()) {
            return false;
        }

        $match = RegexHelper::matchFirst(
            '/^\[\^([^\n^\]]+)\]\:\s/',
            $cursor->getLine(),
            $cursor->getNextNonSpacePosition()
        );

        if (!$match) {
            return false;
        }

        $cursor->advanceToNextNonSpaceOrTab();
        $cursor->advanceBy(\strlen($match[0]));
        $str = $cursor->getRemainder();
        \preg_replace('/^\[\^([^\n^\]]+)\]\:\s/', '', $str);

        if (\preg_match('/^\[\^([^\n^\]]+)\]\:\s/', $match[0], $matches) > 0) {
            $context->addBlock($this->createFootnote($matches[1]));
            $context->setBlocksParsed(true);

            return true;
        }

        return false;
    }

    private function createFootnote(string $label): Footnote
    {
        return new Footnote(
            new Reference($label, $label, $label)
        );
    }
}
