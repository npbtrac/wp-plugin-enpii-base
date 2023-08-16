<?php

declare(strict_types=1);

namespace Enpii_Base\Deps\Doctrine\Inflector\Rules\Turkish;

use Enpii_Base\Deps\Doctrine\Inflector\GenericLanguageInflectorFactory;
use Enpii_Base\Deps\Doctrine\Inflector\Rules\Ruleset;

final class InflectorFactory extends GenericLanguageInflectorFactory
{
    protected function getSingularRuleset(): Ruleset
    {
        return Rules::getSingularRuleset();
    }

    protected function getPluralRuleset(): Ruleset
    {
        return Rules::getPluralRuleset();
    }
}
