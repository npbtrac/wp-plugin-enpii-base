<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) 2015 Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Attributes\Parser;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Parser\BlockParserInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\ContextInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Cursor;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Attributes\Node\Attributes;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Attributes\Util\AttributesHelper;

final class AttributesBlockParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        $state = $cursor->saveState();
        $attributes = AttributesHelper::parseAttributes($cursor);
        if ($attributes === []) {
            return false;
        }

        if ($cursor->getNextNonSpaceCharacter() !== null) {
            $cursor->restoreState($state);

            return false;
        }

        $context->addBlock(new Attributes($attributes));
        $context->setBlocksParsed(true);

        return true;
    }
}
