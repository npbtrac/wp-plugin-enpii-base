<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Store;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\InvalidPathException;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Store\File\Reader;

class FileStore implements StoreInterface
{
    /**
     * The file paths.
     *
     * @var string[]
     */
    protected $filePaths;

    /**
     * Should file loading short circuit?
     *
     * @var bool
     */
    protected $shortCircuit;

    /**
     * Create a new file store instance.
     *
     * @param string[] $filePaths
     * @param bool     $shortCircuit
     *
     * @return void
     */
    public function __construct(array $filePaths, $shortCircuit)
    {
        $this->filePaths = $filePaths;
        $this->shortCircuit = $shortCircuit;
    }

    /**
     * Read the content of the environment file(s).
     *
     * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\InvalidPathException
     *
     * @return string
     */
    public function read()
    {
        if ($this->filePaths === []) {
            throw new InvalidPathException('At least one environment file path must be provided.');
        }

        $contents = Reader::read($this->filePaths, $this->shortCircuit);

        if (count($contents) > 0) {
            return implode("\n", $contents);
        }

        throw new InvalidPathException(
            sprintf('Unable to read any of the environment file(s) at [%s].', implode(', ', $this->filePaths))
        );
    }
}
