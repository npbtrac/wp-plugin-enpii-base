<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\CssSelector\Parser\Handler;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\CssSelector\Parser\Reader;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\CssSelector\Parser\Token;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\CssSelector\Parser\Tokenizer\TokenizerEscaping;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\CssSelector\Parser\Tokenizer\TokenizerPatterns;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\CssSelector\Parser\TokenStream;

/**
 * CSS selector comment handler.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
class IdentifierHandler implements HandlerInterface
{
    private $patterns;
    private $escaping;

    public function __construct(TokenizerPatterns $patterns, TokenizerEscaping $escaping)
    {
        $this->patterns = $patterns;
        $this->escaping = $escaping;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Reader $reader, TokenStream $stream): bool
    {
        $match = $reader->findPattern($this->patterns->getIdentifierPattern());

        if (!$match) {
            return false;
        }

        $value = $this->escaping->escapeUnicode($match[0]);
        $stream->push(new Token(Token::TYPE_IDENTIFIER, $value, $reader->getPosition()));
        $reader->moveForward(\strlen($match[0]));

        return true;
    }
}