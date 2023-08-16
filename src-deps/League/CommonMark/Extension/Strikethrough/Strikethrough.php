<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com> and uAfrica.com (http://uafrica.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\League\CommonMark\Extension\Strikethrough;

use Enpii_Base\Deps\League\CommonMark\Inline\Element\AbstractInline;

final class Strikethrough extends AbstractInline
{
    public function isContainer(): bool
    {
        return true;
    }
}
