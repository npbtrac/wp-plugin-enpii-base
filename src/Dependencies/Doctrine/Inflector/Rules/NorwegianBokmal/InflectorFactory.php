<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\NorwegianBokmal;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\GenericLanguageInflectorFactory;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Ruleset;

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
