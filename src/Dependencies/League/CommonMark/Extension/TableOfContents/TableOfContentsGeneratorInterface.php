<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\TableOfContents;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Element\Document;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\TableOfContents\Node\TableOfContents;

interface TableOfContentsGeneratorInterface
{
    public function generate(Document $document): ?TableOfContents;
}

// Trigger autoload without causing a deprecated error
\class_exists(TableOfContents::class);
