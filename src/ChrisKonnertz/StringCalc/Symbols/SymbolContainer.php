<?php

namespace ChrisKonnertz\StringCalc\Symbols;
use ChrisKonnertz\StringCalc\Exceptions\NotFoundException;
use ChrisKonnertz\StringCalc\Support\StringHelperInterface;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Number;

/**
 * The symbol container manages an array with all symbol objects.
 *
 * @package ChrisKonnertz\StringCalc
 */
class SymbolContainer implements SymbolContainerInterface
{

    /**
     * Array with all available symbols
     *
     * @var AbstractSymbol[]
     */
    protected $symbols;

    /**
     * String helper class
     *
     * @var StringHelperInterface
     */
    protected $stringHelper;

    /**
     * SymbolManager constructor.
     *
     * @param StringHelperInterface $stringHelper
     */
    public function __construct(StringHelperInterface $stringHelper)
    {
        $this->stringHelper = $stringHelper;

        $this->prepare();
    }

    /**
     * Validates the symbol array. This is only a high-level validation.
     * Even if this validation passes, the symbols still might be corrupt.
     * Will throw an exception if validation fails.
     *
     * @throws \Exception
     */
    protected function validate()
    {
        foreach ($this->symbols as $symbol) {
            if (sizeof($symbol->getIdentifiers()) == 0) {
                throw new \LengthException('Error: Symbol does not have any identifiers.');
            }
        }

        $numberSymbols = $this->findSubtype(Number::class);
        if (sizeof($numberSymbols) != 1) {
            throw new NotFoundException('Error: Could not identify number class.');
        }
    }

    /**
     * Retrieves the list of available symbol classes,
     * creates objects of these classes and stores them.
     *
     * @return void
     * @throws \LengthException
     */
    protected function prepare()
    {
        $symbolRegistry = new SymbolRegistry();
        $symbolClassesNames = $symbolRegistry->getSymbols();

        foreach ($symbolClassesNames as $symbolClassName) {
            /** @var AbstractSymbol $symbol */
            $symbol = new $symbolClassName($this->stringHelper);

            $this->symbols[$symbolClassName] = $symbol;
        }

        $this->validate();
    }

    /**
     * Adds a symbol to the array of symbols. This method allows to add symbols
     * at runtime from the outside of this library.
     *
     * @param AbstractSymbol $symbol        The new symbol object
     * @param string|null    $replaceSymbol Class name of an known symbol that you want to replace
     * @return void
     * @throws \InvalidArgumentException
     */
    public function add(AbstractSymbol $symbol, $replaceSymbol = null)
    {
        if (sizeof($symbol->getIdentifiers()) == 0) {
            throw new \LengthException('Error: Symbol does not have any identifiers.');
        }

        if ($replaceSymbol === null) {
            if (array_key_exists(get_class($symbol), $this->symbols)) {
                throw new \InvalidArgumentException(
                    'Error: Trying to replace a symbol without using $replaceClass parameter.'
                );
            }

            $this->symbols[] = $symbol;
        } else {
            if (! is_string($replaceSymbol)) {
                throw new \InvalidArgumentException('Error: $replaceClass has to be the name of a class.');
            }

            if (! array_key_exists($replaceSymbol, $this->symbols)) {
                throw new \InvalidArgumentException('Error: Cannot replace the specified class since it is not known.');
            }

            $this->symbols[$replaceSymbol] = $symbol;
        }

        $this->validate();
    }

    /**
     * Removes a symbol from the array of symbols.
     * It is recommended to only remove custom symbols
     * (that have been added via the addSymbol() method)
     *
     * @param AbstractSymbol $symbol
     * @return void
     */
    public function remove(AbstractSymbol $symbol)
    {
        if (! in_array($symbol, $this->symbols)) {
            throw new \InvalidArgumentException('Error: Cannot remove symbol, because it is unknown.');
        }

        unset($this->symbols[get_class($symbol)]);

        $this->validate();
    }

    /**
     * Returns the symbol that has the given identifier.
     * Returns null if none is found.
     *
     * @param string $identifier
     * @return AbstractSymbol|null
     */
    public function find($identifier)
    {
        $this->stringHelper->validate($identifier);

        foreach ($this->symbols as $symbol) {
            if (in_array($identifier, $symbol->getIdentifiers())) {
                return $symbol;
            }
        }

        return null;
    }

    /**
     * Returns all symbols that inherit from a given abstract
     * parent type (class): The parent type has to be an
     * AbstractSymbol.
     * Notice: The parent type name will not be validated!
     *
     * @param string $parentTypeName
     * @return AbstractSymbol[]
     */
    public function findSubtype($parentTypeName)
    {
        $symbols = [];

        foreach ($this->symbols as $symbol) {
            if (is_a($symbol, $parentTypeName)) {
                $symbols[] = $symbol;
            }
        }

        return $symbols;
    }

    /**
     * Returns the number of managed symbols.
     *
     * @return int
     */
    public function size()
    {
        return sizeof($this->symbols);
    }

    /**
     * Getter for the array of all symbols.
     *
     * @return AbstractSymbol[]
     */
    public function getAll()
    {
        return $this->symbols;
    }

}