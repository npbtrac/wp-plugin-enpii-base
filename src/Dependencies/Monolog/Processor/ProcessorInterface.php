<?php declare(strict_types=1);

/*
 * This file is part of the Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog\Processor;

/**
 * An optional interface to allow labelling Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog processors.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @phpstan-import-type Record from \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog\Logger
 */
interface ProcessorInterface
{
    /**
     * @return array The processed record
     *
     * @phpstan-param  Record $record
     * @phpstan-return Record
     */
    public function __invoke(array $record);
}
