<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\English;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Patterns;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Ruleset;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Substitutions;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules\Transformations;

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
