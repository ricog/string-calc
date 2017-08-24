<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * This is a special expression for functions with arguments.
 * The grammar's production rules are very vague, they do not
 * care if a function needs a special amount of arguments.
 * So we use this special expression that tries to ensure that
 * the chosen function will be called with the right amount of
 * arguments.
 *
 * @package ChrisKonnertz\StringCalc\Grammar\Expressions
 */
class FunctionExpression extends AndExpression
{

    /**
     * Array with all function symbols
     *
     * @var AbstractFunction[]
     */
    protected $functionSymbols;

    /**
     * FunctionExpression constructor.
     *
     * @param AbstractFunction[]      $functionSymbols
     * @param AbstractExpression[]  ...$expressions
     */
    public function __construct($functionSymbols, ...$expressions)
    {
        if (! is_array($functionSymbols)) {
            throw new \InvalidArgumentException('Error: Expected array but got something else');
        }
        if (sizeof($functionSymbols) == 0) {
            throw new \InvalidArgumentException('Error: Function symbols array cannot be empty');
        }

        $this->functionSymbols = $functionSymbols;

        $size = sizeof($expressions);
        if ($size != 5) {
            throw new \InvalidArgumentException('Error: Expected 5 constructor arguments but got '.$size);
        }

        if (! $expressions[0] instanceof SymbolExpression) {
            throw new \InvalidArgumentException(
                'Error: Expected first item in $expressions to be a SymbolExpression but got something else'
            );
        }

        parent::__construct(...$expressions);
    }

    /**
     * @inheritdoc
     */
    public function produceRandomWord(array $rules, $debugPrint = false)
    {
        $expressions = $this->expressions;

        $functionName = $expressions[0]->produceRandomWord($rules);

        // This code will try to find out how many arguments the function allows.
        // It will only test for a maximum of 4 arguments.
        // It has to actually call the function.
        $properAmounts = null;
        foreach ($this->functionSymbols as $symbol) {
            $identifiers = $symbol->getIdentifiers();
            if (in_array($functionName, $identifiers)) {
                $properAmounts = [];
                for ($i = 0; $i < 5; $i++) {
                    $numbers = array_fill(0, $i, 0);
                    try {
                        $symbol->execute($numbers);
                        $properAmounts[] = $i;
                    } catch (NumberOfArgumentsException $ex) {

                    } catch (\Exception $ex) { // Invalid argument values (numbers).
                        $properAmounts[] = $i;
                    }
                }
                break;
            }
        }
        if ($properAmounts === null) {
            throw new \LogicException('Error: Could not find function "'.$functionName.'"');
        }
        if (sizeof($properAmounts) == 0) {
            throw new \LogicException('Error: Could not find arguments for function "'.$functionName.'"');
        }

        if ($debugPrint) {
            echo ' function ( ';
        }

        $word = $functionName;
        $word .= $expressions[1]->produceRandomWord($rules, $debugPrint);

        $amount = $properAmounts[array_rand($properAmounts)];

        if ($amount > 0) {
            $word .= $expressions[2]->produceRandomWord($rules, $debugPrint);
        }
        if ($amount > 1) {
            $expressions[3]->setMin($amount - 1);
            $expressions[3]->setMax($amount - 1);
            $word .= $expressions[3]->produceRandomWord($rules, $debugPrint);
        }

        $word .= $expressions[4]->produceRandomWord($rules, $debugPrint);

        if ($debugPrint) {
            echo ' ) ';
        }

        return $word;
    }

}