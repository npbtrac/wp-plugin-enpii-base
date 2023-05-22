<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\Symfony\Component\Translation;

use Enpii_Base\Deps\Symfony\Contracts\Translation\LocaleAwareInterface;
use Enpii_Base\Deps\Symfony\Contracts\Translation\TranslatorInterface;
use Enpii_Base\Deps\Symfony\Contracts\Translation\TranslatorTrait;

/**
 * IdentityTranslator does not translate anything.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class IdentityTranslator implements TranslatorInterface, LocaleAwareInterface
{
    use TranslatorTrait;
}
