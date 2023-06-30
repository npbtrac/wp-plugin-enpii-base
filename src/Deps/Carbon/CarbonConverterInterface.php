<?php

/**
 * This file is part of the Enpii_Base\Deps\Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\Carbon;

use DateTimeInterface;

interface CarbonConverterInterface
{
    public function convertDate(DateTimeInterface $dateTime, bool $negated = false): CarbonInterface;
}