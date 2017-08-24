<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

/**
 * This is a container expression. The expressions that it contains are
 * linked with an AND.
 *
 * @package ChrisKonnertz\StringCalc\Grammar\Expressions
 */
class AndExpression extends AbstractContainerExpression
{

    /**
     * @inheritdoc
     */
    public function produceRandomWord(array $rules, $debugPrint = false)
    {
        $word = '';

        foreach ($this->expressions as $expression) {
            if ($debugPrint) {
                echo ' and ( ';
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

        return implode(' ', $parts);
    }

}