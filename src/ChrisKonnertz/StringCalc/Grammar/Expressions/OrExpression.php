<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

/**
 * This is a container expression. The expressions that it contains are
 * linked with an OR.
 *
 * @package ChrisKonnertz\StringCalc\Grammar\Expressions
 */
class OrExpression extends AbstractContainerExpression
{

    /**
     * @inheritdoc
     */
    public function produceRandomWord(array $rules, $debugPrint = false)
    {
        /** @var AbstractExpression $part */
        $part = $this->expressions[array_rand($this->expressions)];

        if ($part == null) {
            return '';
        }

        if ($debugPrint) {
            echo ' or ( ';
        }

        $word = $part->produceRandomWord($rules, $debugPrint);

        if ($debugPrint) {
            echo ' ) ';
        }

        return $word;
    }

    public function __toString()
    {
        $parts = [];

        foreach ($this->expressions as $expression) {
            $parts[] = $expression->__toString();
        }

        return implode(' | ', $parts);
    }

}