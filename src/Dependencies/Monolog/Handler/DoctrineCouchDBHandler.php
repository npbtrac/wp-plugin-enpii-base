<?php declare(strict_types=1);

/*
 * This file is part of the Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog\Handler;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog\Logger;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog\Formatter\NormalizerFormatter;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog\Formatter\FormatterInterface;
use Doctrine\CouchDB\CouchDBClient;

/**
 * CouchDB handler for Doctrine CouchDB ODM
 *
 * @author Markus Bachmann <markus.bachmann@bachi.biz>
 */
class DoctrineCouchDBHandler extends AbstractProcessingHandler
{
    /** @var CouchDBClient */
    private $client;

    public function __construct(CouchDBClient $client, $level = Logger::DEBUG, bool $bubble = true)
    {
        $this->client = $client;
        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritDoc}
     */
    protected function write(array $record): void
    {
        $this->client->postDocument($record['formatted']);
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new NormalizerFormatter;
    }
}
