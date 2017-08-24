<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

use ChrisKonnertz\StringCalc\Grammar\Rule;
use Closure;

/**
 * This class represents language symbols.
 *
 * @package ChrisKonnertz\StringCalc\Grammar\Expressions
 */
class SymbolExpression extends AbstractExpression
{

    /**
     * The name of the language symbol
     *
     * @var string
     */
    protected $symbolName;

    /**
     * This function is called to create a random word
     *
     * @var Closure|null
     */
    protected $productionFunction = null;

    /**
     * SymbolExpression constructor.
     *
     * @param string  $symbolName
     * @param Closure|null $productionFunction
     */
    public function __construct($symbolName, $productionFunction = null)
    {
        $this->setSymbolMame($symbolName);
        $this->setProductionFunction($productionFunction);
    }

    /**
     * Setter for the symbol name
     *
     * @param string $symbolName
     */
    public function setSymbolMame($symbolName)
    {
        if (! is_string($symbolName)) {
            throw new \InvalidArgumentException('Error: Expected string but got '.gettype($symbolName));
        }
        if (trim($symbolName) === '') {
            throw new \InvalidArgumentException('Error: Expected name but got empty string ro white space');
        }

       $this->symbolName = $symbolName;
    }

    /**
     * Getter for the symbol name
     *
     * @return string
     */
    public function getSymbolName()
    {
        return $this->symbolName;
    }

    /**
     * Setter for the production function
     *
     * @param Closure|null $productionFunction
     */
    public function setProductionFunction($productionFunction)
    {
        if (! (is_null($productionFunction) or $productionFunction instanceof Closure)) {
            throw new \InvalidArgumentException('Error: Expected closure or null but got something else.');
        }

        $this->productionFunction = $productionFunction;
    }

    /**
     * Getter for the production function
     *
     * @return Closure|null
     */
    public function getProductionFunction()
    {
        return $this->productionFunction;
    }

    /**
     * Creates and returns a randomly constructed word
     * by creating an instance of the the current symbol.
     *
     * @param Rule[] $rules
     * @param bool   $debugPrint
     * @return string
     * @throws \Exception
     */
    public function produceRandomWord(array $rules, $debugPrint = false)
    {
        if ($debugPrint) {
            echo ' symbol ';
        }

        if ($this->productionFunction === null) {
            throw new \LogicException('Error: No production function has been assigned');
        }

        $word = call_user_func($this->productionFunction, $rules);

        if (! is_string($word)) {
            throw new \Exception('Error: Production function did not return a string');
        }

        if ($debugPrint) {
            echo $word.' ';
        }

        return $word;
    }

    public function __toString()
    {
        return $this->getSymbolName();
    }
}