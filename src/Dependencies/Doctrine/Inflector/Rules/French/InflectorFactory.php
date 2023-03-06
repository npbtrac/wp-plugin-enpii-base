<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\French;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\GenericLanguageInflectorFactory;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Ruleset;

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
