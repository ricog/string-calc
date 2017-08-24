<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

use ChrisKonnertz\StringCalc\Grammar\Rule;

/**
 * Abstract base class for all expression classes
 *
 * @package ChrisKonnertz\StringCalc\Grammar\Expressions
 */
abstract class AbstractExpression
{

    /**
     * Creates and returns a randomly constructed word of the language
     *
     * @param Rule[] $rules
     * @param bool   $debugPrint
     * @return string
     */
    abstract public function produceRandomWord(array $rules, $debugPrint = false);

    /**
     * The grammar has to be printable so child classes have
     * to overwrite this method with their own implementation
     */
    abstract public function __toString();

}
