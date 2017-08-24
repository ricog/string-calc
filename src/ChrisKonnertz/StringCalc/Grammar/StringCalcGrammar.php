<?php

namespace ChrisKonnertz\StringCalc\Grammar;

use ChrisKonnertz\StringCalc\Container\ContainerInterface;
use ChrisKonnertz\StringCalc\Grammar\Expressions\AndExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\FunctionExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\OptionalAndExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\OrExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\RepeatedAndExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\SymbolExpression;
use ChrisKonnertz\StringCalc\Symbols\AbstractClosingBracket;
use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;
use ChrisKonnertz\StringCalc\Symbols\AbstractOpeningBracket;
use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;
use ChrisKonnertz\StringCalc\Symbols\AbstractSeparator;
use ChrisKonnertz\StringCalc\Symbols\AbstractSymbol;
use ChrisKonnertz\StringCalc\Symbols\SymbolContainerInterface;

/**
 * This class represents the concrete grammar of StringCalc.
 * It also is a container for the rules that define this grammar.
 *
 * @package ChrisKonnertz\StringCalc\Grammar
 */
class StringCalcGrammar extends AbstractGrammar
{

    /**
     * StringCalcGrammar constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        // Define the symbols ------------------------------------------------------------------------------------------
        $expression = new SymbolExpression('expression', function(array $rules)
        {
            $expressionRules = [];

            /** @var Rule[] $rules */
            foreach ($rules as $rule) {
                if ($rule->getNonterminalSymbolName() == 'expression') {
                    $expressionRules[] = $rule;
                };
            }

            /** @var Rule $rule */
            $rule = $expressionRules[array_rand($expressionRules)];
            return $rule->produceRandomWord($this->rules);
        });

        $simpleExpression = new SymbolExpression('simpleExpression', function(array $rules)
        {
            $expressionRules = [];

            /** @var Rule[] $rules */
            foreach ($rules as $rule) {
                if ($rule->getNonterminalSymbolName() == 'simpleExpression') {
                    $expressionRules[] = $rule;
                };
            }

            /** @var Rule $rule */
            $rule = $expressionRules[array_rand($expressionRules)];
            return $rule->produceRandomWord($this->rules);
        });

        $number = new SymbolExpression('number', function(array $rules) {
            return (string) rand(0, 10000);
        });

        $symbols = $this->getSymbolsOfType($container, AbstractConstant::class);
        $constant = new SymbolExpression('constant', function(array $rules) use ($symbols) {
            $symbol = $symbols[array_rand($symbols)];
            return $symbol->getIdentifiers()[array_rand($symbol->getIdentifiers())];
        });

        $function = new SymbolExpression('function', function(array $rules)
        {
            $functionRules = [];

            /** @var Rule[] $rules */
            foreach ($rules as $rule) {
                if ($rule->getNonterminalSymbolName() == 'function') {
                    $functionRules[] = $rule;
                };
            }

            /** @var Rule $rule */
            $rule = $functionRules[array_rand($functionRules)];
            return $rule->produceRandomWord($this->rules);
        });

        $symbols = $this->getSymbolsOfType($container, AbstractOpeningBracket::class);
        $openingBracket = new SymbolExpression('openingBracket', function(array $rules) use ($symbols) {
            $symbol = $symbols[array_rand($symbols)];
            return $symbol->getIdentifiers()[array_rand($symbol->getIdentifiers())];
        });

        $symbols = $this->getSymbolsOfType($container, AbstractClosingBracket::class);
        $closingBracket = new SymbolExpression('closingBracket', function(array $rules) use ($symbols) {
            $symbol = $symbols[array_rand($symbols)];
            return $symbol->getIdentifiers()[array_rand($symbol->getIdentifiers())];
        });

        $symbols = $this->getSymbolsOfType($container, AbstractOperator::class);
        $operator = new SymbolExpression('operator', function(array $rules) use ($symbols) {
            $symbols = array_filter($symbols, function($var)
            {
                /** @var AbstractOperator $var */
                return $var->getOperatesBinary();
            });

            $symbol = $symbols[array_rand($symbols)];
            return $symbol->getIdentifiers()[array_rand($symbol->getIdentifiers())];
        });

        $unaryOperator = new SymbolExpression('unaryOperator', function(array $rules) use ($symbols) {
            $symbols = array_filter($symbols, function($var)
            {
                /** @var AbstractOperator $var */
                return $var->getOperatesUnary();
            });

            $symbol = $symbols[array_rand($symbols)];
            return $symbol->getIdentifiers()[array_rand($symbol->getIdentifiers())];
        });

        $symbols = $this->getSymbolsOfType($container, AbstractFunction::class);
        $functionBody = new SymbolExpression('functionBody', function(array $rules) use ($symbols) {
            $identifiers = ['min', 'max'];
            return $identifiers[array_rand($identifiers)];

            // TODO We cannot use a completely randomly chosen function, because we cannot determine
            // valid arguments for the function with the current implementation of functions.
            // If we have implemented such a thing we can use the code below instead of the code above.
            //$symbol = $symbols[array_rand($symbols)];
            //return $symbol->getIdentifiers()[array_rand($symbol->getIdentifiers())];
        });

        $symbols = $this->getSymbolsOfType($container, AbstractSeparator::class);
        $argumentSeparator = new SymbolExpression('argumentSeparator', function($rules) use ($symbols) {
            $symbol = $symbols[array_rand($symbols)];
            return $symbol->getIdentifiers()[array_rand($symbol->getIdentifiers())];
        });

        // Define the rules --------------------------------------------------------------------------------------------
        $this->addRule($expression->getSymbolName(), new OrExpression($number, $constant, $function));
        $this->addRule($expression->getSymbolName(), new AndExpression($openingBracket, $expression, $closingBracket));
        $this->addRule($expression->getSymbolName(), new AndExpression(
            new OptionalAndExpression($unaryOperator),
            $simpleExpression,
            new RepeatedAndExpression(
                0, PHP_INT_MAX, $operator, new OptionalAndExpression($unaryOperator), $simpleExpression
            )
        ));

        $this->addRule($simpleExpression->getSymbolName(), new OrExpression($number, $constant, $function));
        $this->addRule($simpleExpression->getSymbolName(), new AndExpression(
            $openingBracket,
            $expression,
            $closingBracket
        ));
        $this->addRule($simpleExpression->getSymbolName(), new AndExpression(
            $simpleExpression,
            new RepeatedAndExpression(
                0, PHP_INT_MAX, $operator, new OptionalAndExpression($unaryOperator), $expression
            )
        ));

        //$this->addRule($function->getSymbolName(), new AndExpression($functionBody, $openingBracket, $closingBracket));
        $this->addRule($function->getSymbolName(), new FunctionExpression(
            $this->getSymbolsOfType($container, AbstractFunction::class),
            $functionBody,
            $openingBracket,
            $expression,
            new RepeatedAndExpression(0, PHP_INT_MAX, $argumentSeparator, $simpleExpression),
            $closingBracket
        ));

        // Define the start --------------------------------------------------------------------------------------------
        $this->start = $expression->getSymbolName();
    }

    /**
     * Creates and returns a randomly constructed word from the language.
     *
     * @return string
     * @throws \Exception
     */
    public function produceRandomWord()
    {
        ini_set('xdebug.max_nesting_level', 1000);

        $seed = time();
        echo $seed.'<br><br>';
        srand($seed);

        if (sizeof($this->rules) == 0) {
            throw new \Exception('Error: Cannot create word without production rules!');
        }

        $startRules = [];
        foreach ($this->rules as $rule) {
            if ($rule->getNonterminalSymbolName() == $this->start) {
                $startRules[] = $rule;
            }
        }

        if (sizeof($startRules) == 0) {
            throw new \LogicException('Error: Could not find a rule for the start');
        }

        /** @var Rule $rule */
        $rule = $startRules[array_rand($startRules)];
        return $rule->produceRandomWord($this->rules, true);
    }

    /**
     * Returns all symbol objects of a given type
     *
     * @param ContainerInterface $container
     * @param string             $symbolClassName
     * @return AbstractSymbol[]
     */
    public function getSymbolsOfType(ContainerInterface $container, $symbolClassName) {
        /** @var SymbolContainerInterface $symbolContainer */
        $symbolContainer = $container->get('stringcalc_symbolcontainer');

        $symbols = $symbolContainer->findSubtypes($symbolClassName);

        if (sizeof($symbols) == 0) {
            throw new \LogicException(
                'Error: No constants symbols of type "'.$symbolClassName.'" have been registered.'
            );
        }

        return $symbols;
    }

}