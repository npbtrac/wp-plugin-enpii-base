<?php

declare(strict_types=1);

/*
 * This is part of the league/commonmark package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Table;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\ConfigurableEnvironmentInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\ExtensionInterface;

final class TableExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment): void
    {
        $environment
            ->addBlockParser(new TableParser())

            ->addBlockRenderer(Table::class, new TableRenderer())
            ->addBlockRenderer(TableSection::class, new TableSectionRenderer())
            ->addBlockRenderer(TableRow::class, new TableRowRenderer())
            ->addBlockRenderer(TableCell::class, new TableCellRenderer())
        ;
    }
}