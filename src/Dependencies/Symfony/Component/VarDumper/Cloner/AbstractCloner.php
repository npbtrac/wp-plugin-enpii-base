<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Cloner;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\Caster;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Exception\ThrowingCasterException;

/**
 * AbstractCloner implements a generic caster mechanism for objects and resources.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractCloner implements ClonerInterface
{
    public static $defaultCasters = [
        '__PHP_Incomplete_Class' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\Caster', 'castPhpIncompleteClass'],

        'Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\CutStub' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'castStub'],
        'Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\CutArrayStub' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'castCutArray'],
        'Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ConstStub' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'castStub'],
        'Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\EnumStub' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'castEnum'],

        'Fiber' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\FiberCaster', 'castFiber'],

        'Closure' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castClosure'],
        'Generator' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castGenerator'],
        'ReflectionType' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castType'],
        'ReflectionAttribute' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castAttribute'],
        'ReflectionGenerator' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castReflectionGenerator'],
        'ReflectionClass' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castClass'],
        'ReflectionClassConstant' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castClassConstant'],
        'ReflectionFunctionAbstract' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castFunctionAbstract'],
        'ReflectionMethod' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castMethod'],
        'ReflectionParameter' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castParameter'],
        'ReflectionProperty' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castProperty'],
        'ReflectionReference' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castReference'],
        'ReflectionExtension' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castExtension'],
        'ReflectionZendExtension' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castZendExtension'],

        'Doctrine\Common\Persistence\ObjectManager' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],
        'Doctrine\Common\Proxy\Proxy' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DoctrineCaster', 'castCommonProxy'],
        'Doctrine\ORM\Proxy\Proxy' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DoctrineCaster', 'castOrmProxy'],
        'Doctrine\ORM\PersistentCollection' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DoctrineCaster', 'castPersistentCollection'],
        'Doctrine\Persistence\ObjectManager' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],

        'DOMException' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castException'],
        'DOMStringList' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'],
        'DOMNameList' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'],
        'DOMImplementation' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castImplementation'],
        'DOMImplementationList' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'],
        'DOMNode' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castNode'],
        'DOMNameSpaceNode' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castNameSpaceNode'],
        'DOMDocument' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDocument'],
        'DOMNodeList' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'],
        'DOMNamedNodeMap' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'],
        'DOMCharacterData' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castCharacterData'],
        'DOMAttr' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castAttr'],
        'DOMElement' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castElement'],
        'DOMText' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castText'],
        'DOMTypeinfo' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castTypeinfo'],
        'DOMDomError' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDomError'],
        'DOMLocator' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLocator'],
        'DOMDocumentType' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDocumentType'],
        'DOMNotation' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castNotation'],
        'DOMEntity' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castEntity'],
        'DOMProcessingInstruction' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castProcessingInstruction'],
        'DOMXPath' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DOMCaster', 'castXPath'],

        'XMLReader' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\XmlReaderCaster', 'castXmlReader'],

        'ErrorException' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castErrorException'],
        'Exception' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castException'],
        'Error' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castError'],
        'Symfony\Bridge\Monolog\Logger' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],
        'Symfony\Component\DependencyInjection\ContainerInterface' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],
        'Symfony\Component\EventDispatcher\EventDispatcherInterface' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],
        'Symfony\Component\HttpClient\AmpHttpClient' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClient'],
        'Symfony\Component\HttpClient\CurlHttpClient' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClient'],
        'Symfony\Component\HttpClient\NativeHttpClient' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClient'],
        'Symfony\Component\HttpClient\Response\AmpResponse' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'],
        'Symfony\Component\HttpClient\Response\CurlResponse' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'],
        'Symfony\Component\HttpClient\Response\NativeResponse' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'],
        'Symfony\Component\HttpFoundation\Request' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castRequest'],
        'Symfony\Component\Uid\Ulid' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castUlid'],
        'Symfony\Component\Uid\Uuid' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castUuid'],
        'Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Exception\ThrowingCasterException' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castThrowingCasterException'],
        'Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\TraceStub' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castTraceStub'],
        'Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\FrameStub' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castFrameStub'],
        'Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Cloner\AbstractCloner' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],
        'Symfony\Component\ErrorHandler\Exception\SilencedErrorContext' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castSilencedErrorContext'],

        'Imagine\Image\ImageInterface' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ImagineCaster', 'castImage'],

        'Ramsey\Uuid\UuidInterface' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\UuidCaster', 'castRamseyUuid'],

        'ProxyManager\Proxy\ProxyInterface' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ProxyManagerCaster', 'castProxy'],
        'PHPUnit_Framework_MockObject_MockObject' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],
        'PHPUnit\Framework\MockObject\MockObject' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],
        'PHPUnit\Framework\MockObject\Stub' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],
        'Prophecy\Prophecy\ProphecySubjectInterface' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],
        'Mockery\MockInterface' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'],

        'PDO' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\PdoCaster', 'castPdo'],
        'PDOStatement' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\PdoCaster', 'castPdoStatement'],

        'AMQPConnection' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castConnection'],
        'AMQPChannel' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castChannel'],
        'AMQPQueue' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castQueue'],
        'AMQPExchange' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castExchange'],
        'AMQPEnvelope' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castEnvelope'],

        'ArrayObject' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SplCaster', 'castArrayObject'],
        'ArrayIterator' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SplCaster', 'castArrayIterator'],
        'SplDoublyLinkedList' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SplCaster', 'castDoublyLinkedList'],
        'SplFileInfo' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SplCaster', 'castFileInfo'],
        'SplFileObject' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SplCaster', 'castFileObject'],
        'SplHeap' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SplCaster', 'castHeap'],
        'SplObjectStorage' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SplCaster', 'castObjectStorage'],
        'SplPriorityQueue' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SplCaster', 'castHeap'],
        'OuterIterator' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SplCaster', 'castOuterIterator'],
        'WeakReference' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\SplCaster', 'castWeakReference'],

        'Redis' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedis'],
        'RedisArray' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedisArray'],
        'RedisCluster' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedisCluster'],

        'DateTimeInterface' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DateCaster', 'castDateTime'],
        'DateInterval' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DateCaster', 'castInterval'],
        'DateTimeZone' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DateCaster', 'castTimeZone'],
        'DatePeriod' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DateCaster', 'castPeriod'],

        'GMP' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\GmpCaster', 'castGmp'],

        'MessageFormatter' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\IntlCaster', 'castMessageFormatter'],
        'NumberFormatter' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\IntlCaster', 'castNumberFormatter'],
        'IntlTimeZone' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\IntlCaster', 'castIntlTimeZone'],
        'IntlCalendar' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\IntlCaster', 'castIntlCalendar'],
        'IntlDateFormatter' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\IntlCaster', 'castIntlDateFormatter'],

        'Memcached' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\MemcachedCaster', 'castMemcached'],

        'Ds\Collection' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DsCaster', 'castCollection'],
        'Ds\Map' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DsCaster', 'castMap'],
        'Ds\Pair' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DsCaster', 'castPair'],
        'Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DsPairStub' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\DsCaster', 'castPairStub'],

        'mysqli_driver' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\MysqliCaster', 'castMysqliDriver'],

        'CurlHandle' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castCurl'],
        ':curl' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castCurl'],

        ':dba' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castDba'],
        ':dba persistent' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castDba'],

        'GdImage' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castGd'],
        ':gd' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castGd'],

        ':mysql link' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castMysqlLink'],
        ':pgsql large object' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\PgSqlCaster', 'castLargeObject'],
        ':pgsql link' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\PgSqlCaster', 'castLink'],
        ':pgsql link persistent' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\PgSqlCaster', 'castLink'],
        ':pgsql result' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\PgSqlCaster', 'castResult'],
        ':process' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castProcess'],
        ':stream' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castStream'],

        'OpenSSLCertificate' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castOpensslX509'],
        ':OpenSSL X.509' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castOpensslX509'],

        ':persistent stream' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castStream'],
        ':stream-context' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castStreamContext'],

        'XmlParser' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\XmlResourceCaster', 'castXml'],
        ':xml' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\XmlResourceCaster', 'castXml'],

        'RdKafka' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castRdKafka'],
        'RdKafka\Conf' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castConf'],
        'RdKafka\KafkaConsumer' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castKafkaConsumer'],
        'RdKafka\Metadata\Broker' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castBrokerMetadata'],
        'RdKafka\Metadata\Collection' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castCollectionMetadata'],
        'RdKafka\Metadata\Partition' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castPartitionMetadata'],
        'RdKafka\Metadata\Topic' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopicMetadata'],
        'RdKafka\Message' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castMessage'],
        'RdKafka\Topic' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopic'],
        'RdKafka\TopicPartition' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopicPartition'],
        'RdKafka\TopicConf' => ['Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopicConf'],
    ];

    protected $maxItems = 2500;
    protected $maxString = -1;
    protected $minDepth = 1;

    /**
     * @var array<string, list<callable>>
     */
    private $casters = [];

    /**
     * @var callable|null
     */
    private $prevErrorHandler;

    private $classInfo = [];
    private $filter = 0;

    /**
     * @param callable[]|null $casters A map of casters
     *
     * @see addCasters
     */
    public function __construct(array $casters = null)
    {
        if (null === $casters) {
            $casters = static::$defaultCasters;
        }
        $this->addCasters($casters);
    }

    /**
     * Adds casters for resources and objects.
     *
     * Maps resources or objects types to a callback.
     * Types are in the key, with a callable caster for value.
     * Resource types are to be prefixed with a `:`,
     * see e.g. static::$defaultCasters.
     *
     * @param callable[] $casters A map of casters
     */
    public function addCasters(array $casters)
    {
        foreach ($casters as $type => $callback) {
            $this->casters[$type][] = $callback;
        }
    }

    /**
     * Sets the maximum number of items to clone past the minimum depth in nested structures.
     */
    public function setMaxItems(int $maxItems)
    {
        $this->maxItems = $maxItems;
    }

    /**
     * Sets the maximum cloned length for strings.
     */
    public function setMaxString(int $maxString)
    {
        $this->maxString = $maxString;
    }

    /**
     * Sets the minimum tree depth where we are guaranteed to clone all the items.  After this
     * depth is reached, only setMaxItems items will be cloned.
     */
    public function setMinDepth(int $minDepth)
    {
        $this->minDepth = $minDepth;
    }

    /**
     * Clones a PHP variable.
     *
     * @param mixed $var    Any PHP variable
     * @param int   $filter A bit field of Caster::EXCLUDE_* constants
     *
     * @return Data
     */
    public function cloneVar($var, int $filter = 0)
    {
        $this->prevErrorHandler = set_error_handler(function ($type, $msg, $file, $line, $context = []) {
            if (\E_RECOVERABLE_ERROR === $type || \E_USER_ERROR === $type) {
                // Cloner never dies
                throw new \ErrorException($msg, 0, $type, $file, $line);
            }

            if ($this->prevErrorHandler) {
                return ($this->prevErrorHandler)($type, $msg, $file, $line, $context);
            }

            return false;
        });
        $this->filter = $filter;

        if ($gc = gc_enabled()) {
            gc_disable();
        }
        try {
            return new Data($this->doClone($var));
        } finally {
            if ($gc) {
                gc_enable();
            }
            restore_error_handler();
            $this->prevErrorHandler = null;
        }
    }

    /**
     * Effectively clones the PHP variable.
     *
     * @param mixed $var Any PHP variable
     *
     * @return array
     */
    abstract protected function doClone($var);

    /**
     * Casts an object to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array
     */
    protected function castObject(Stub $stub, bool $isNested)
    {
        $obj = $stub->value;
        $class = $stub->class;

        if (\PHP_VERSION_ID < 80000 ? "\0" === ($class[15] ?? null) : str_contains($class, "@anonymous\0")) {
            $stub->class = get_debug_type($obj);
        }
        if (isset($this->classInfo[$class])) {
            [$i, $parents, $hasDebugInfo, $fileInfo] = $this->classInfo[$class];
        } else {
            $i = 2;
            $parents = [$class];
            $hasDebugInfo = method_exists($class, '__debugInfo');

            foreach (class_parents($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            foreach (class_implements($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            $parents[] = '*';

            $r = new \ReflectionClass($class);
            $fileInfo = $r->isInternal() || $r->isSubclassOf(Stub::class) ? [] : [
                'file' => $r->getFileName(),
                'line' => $r->getStartLine(),
            ];

            $this->classInfo[$class] = [$i, $parents, $hasDebugInfo, $fileInfo];
        }

        $stub->attr += $fileInfo;
        $a = Caster::castObject($obj, $class, $hasDebugInfo, $stub->class);

        try {
            while ($i--) {
                if (!empty($this->casters[$p = $parents[$i]])) {
                    foreach ($this->casters[$p] as $callback) {
                        $a = $callback($obj, $a, $stub, $isNested, $this->filter);
                    }
                }
            }
        } catch (\Exception $e) {
            $a = [(Stub::TYPE_OBJECT === $stub->type ? Caster::PREFIX_VIRTUAL : '').'⚠' => new ThrowingCasterException($e)] + $a;
        }

        return $a;
    }

    /**
     * Casts a resource to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array
     */
    protected function castResource(Stub $stub, bool $isNested)
    {
        $a = [];
        $res = $stub->value;
        $type = $stub->class;

        try {
            if (!empty($this->casters[':'.$type])) {
                foreach ($this->casters[':'.$type] as $callback) {
                    $a = $callback($res, $a, $stub, $isNested, $this->filter);
                }
            }
        } catch (\Exception $e) {
            $a = [(Stub::TYPE_OBJECT === $stub->type ? Caster::PREFIX_VIRTUAL : '').'⚠' => new ThrowingCasterException($e)] + $a;
        }

        return $a;
    }
}