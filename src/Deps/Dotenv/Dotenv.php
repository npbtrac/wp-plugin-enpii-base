<?php

namespace Enpii_Base\Deps\Dotenv;

use Enpii_Base\Deps\Dotenv\Exception\InvalidPathException;
use Enpii_Base\Deps\Dotenv\Loader\Loader;
use Enpii_Base\Deps\Dotenv\Loader\LoaderInterface;
use Enpii_Base\Deps\Dotenv\Repository\Adapter\ArrayAdapter;
use Enpii_Base\Deps\Dotenv\Repository\RepositoryBuilder;
use Enpii_Base\Deps\Dotenv\Repository\RepositoryInterface;
use Enpii_Base\Deps\Dotenv\Store\FileStore;
use Enpii_Base\Deps\Dotenv\Store\StoreBuilder;
use Enpii_Base\Deps\Dotenv\Store\StringStore;

class Dotenv
{
    /**
     * The loader instance.
     *
     * @var \Enpii_Base\Deps\Dotenv\Loader\LoaderInterface
     */
    protected $loader;

    /**
     * The repository instance.
     *
     * @var \Enpii_Base\Deps\Dotenv\Repository\RepositoryInterface
     */
    protected $repository;

    /**
     * The store instance.
     *
     * @var \Enpii_Base\Deps\Dotenv\Store\StoreInterface
     */
    protected $store;

    /**
     * Create a new dotenv instance.
     *
     * @param \Enpii_Base\Deps\Dotenv\Loader\LoaderInterface         $loader
     * @param \Enpii_Base\Deps\Dotenv\Repository\RepositoryInterface $repository
     * @param \Enpii_Base\Deps\Dotenv\Store\StoreInterface|string[]  $store
     *
     * @return void
     */
    public function __construct(LoaderInterface $loader, RepositoryInterface $repository, $store)
    {
        $this->loader = $loader;
        $this->repository = $repository;
        $this->store = is_array($store) ? new FileStore($store, true) : $store;
    }

    /**
     * Create a new dotenv instance.
     *
     * @param \Enpii_Base\Deps\Dotenv\Repository\RepositoryInterface $repository
     * @param string|string[]                        $paths
     * @param string|string[]|null                   $names
     * @param bool                                   $shortCircuit
     *
     * @return \Enpii_Base\Deps\Dotenv\Dotenv
     */
    public static function create(RepositoryInterface $repository, $paths, $names = null, $shortCircuit = true)
    {
        $builder = StoreBuilder::create()->withPaths($paths)->withNames($names);

        if ($shortCircuit) {
            $builder = $builder->shortCircuit();
        }

        return new self(new Loader(), $repository, $builder->make());
    }

    /**
     * Create a new mutable dotenv instance with default repository.
     *
     * @param string|string[]      $paths
     * @param string|string[]|null $names
     * @param bool                 $shortCircuit
     *
     * @return \Enpii_Base\Deps\Dotenv\Dotenv
     */
    public static function createMutable($paths, $names = null, $shortCircuit = true)
    {
        $repository = RepositoryBuilder::create()->make();

        return self::create($repository, $paths, $names, $shortCircuit);
    }

    /**
     * Create a new immutable dotenv instance with default repository.
     *
     * @param string|string[]      $paths
     * @param string|string[]|null $names
     * @param bool                 $shortCircuit
     *
     * @return \Enpii_Base\Deps\Dotenv\Dotenv
     */
    public static function createImmutable($paths, $names = null, $shortCircuit = true)
    {
        $repository = RepositoryBuilder::create()->immutable()->make();

        return self::create($repository, $paths, $names, $shortCircuit);
    }

    /**
     * Create a new dotenv instance with an array backed repository.
     *
     * @param string|string[]      $paths
     * @param string|string[]|null $names
     * @param bool                 $shortCircuit
     *
     * @return \Enpii_Base\Deps\Dotenv\Dotenv
     */
    public static function createArrayBacked($paths, $names = null, $shortCircuit = true)
    {
        $adapter = new ArrayAdapter();

        $repository = RepositoryBuilder::create()->withReaders([$adapter])->withWriters([$adapter])->make();

        return self::create($repository, $paths, $names, $shortCircuit);
    }

    /**
     * Parse the given content and resolve nested variables.
     *
     * This method behaves just like load(), only without mutating your actual
     * environment. We do this by using an array backed repository.
     *
     * @param string $content
     *
     * @throws \Enpii_Base\Deps\Dotenv\Exception\InvalidFileException
     *
     * @return array<string,string|null>
     */
    public static function parse($content)
    {
        $adapter = new ArrayAdapter();

        $repository = RepositoryBuilder::create()->withReaders([$adapter])->withWriters([$adapter])->make();

        $phpdotenv = new self(new Loader(), $repository, new StringStore($content));

        return $phpdotenv->load();
    }

    /**
     * Read and load environment file(s).
     *
     * @throws \Enpii_Base\Deps\Dotenv\Exception\InvalidPathException|\Enpii_Base\Deps\Dotenv\Exception\InvalidFileException
     *
     * @return array<string,string|null>
     */
    public function load()
    {
        return $this->loader->load($this->repository, $this->store->read());
    }

    /**
     * Read and load environment file(s), silently failing if no files can be read.
     *
     * @throws \Enpii_Base\Deps\Dotenv\Exception\InvalidFileException
     *
     * @return array<string,string|null>
     */
    public function safeLoad()
    {
        try {
            return $this->load();
        } catch (InvalidPathException $e) {
            // suppressing exception
            return [];
        }
    }

    /**
     * Required ensures that the specified variables exist, and returns a new validator object.
     *
     * @param string|string[] $variables
     *
     * @return \Enpii_Base\Deps\Dotenv\Validator
     */
    public function required($variables)
    {
        return new Validator($this->repository, (array) $variables);
    }

    /**
     * Returns a new validator object that won't check if the specified variables exist.
     *
     * @param string|string[] $variables
     *
     * @return \Enpii_Base\Deps\Dotenv\Validator
     */
    public function ifPresent($variables)
    {
        return new Validator($this->repository, (array) $variables, false);
    }
}
