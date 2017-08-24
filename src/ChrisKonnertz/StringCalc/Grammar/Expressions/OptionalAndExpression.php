<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

/**
 * This is a container expression. The expressions that it contains are
 * linked with an AND. They (as a whole) are optional.
 *
 * @package ChrisKonnertz\StringCalc\Grammar\Expressions
 */
class OptionalAndExpression extends AbstractContainerExpression
{

    /**
     * @inheritdoc
     */
    public function produceRandomWord(array $rules, $debugPrint = false)
    {
        if (rand(0, 1) == 0) {
            return '';
        }

        $word = '';

        foreach ($this->expressions as $expression) {
            if ($debugPrint) {
                echo ' optionalAnd ( ';
            }

            $word .= $expression->produceRandomWord($rules, $debugPrint);

            if ($debugPrint) {
                echo ' ) ';
            }
        }

        return $word;
    }

    public function __toString()
    {
        $parts = [];

        foreach ($this->expressions as $expression) {
            $parts[] = $expression->__toString();
        }

        return '[ '.implode(' ', $parts).' ]';
    }

}