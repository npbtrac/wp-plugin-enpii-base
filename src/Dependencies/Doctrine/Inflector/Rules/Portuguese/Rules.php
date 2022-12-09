<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Portuguese;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Patterns;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Ruleset;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Substitutions;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Transformations;

final class Rules
{
    public static function getSingularRuleset(): Ruleset
    {
        return new Ruleset(
            new Transformations(...Inflectible::getSingular()),
            new Patterns(...Uninflected::getSingular()),
            (new Substitutions(...Inflectible::getIrregular()))->getFlippedSubstitutions()
        );
    }

    public static function getPluralRuleset(): Ruleset
    {
        return new Ruleset(
            new Transformations(...Inflectible::getPlural()),
            new Patterns(...Uninflected::getPlural()),
            new Substitutions(...Inflectible::getIrregular())
        );
    }
}
