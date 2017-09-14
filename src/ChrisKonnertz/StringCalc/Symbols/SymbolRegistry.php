<?php

namespace ChrisKonnertz\StringCalc\Symbols;

use ChrisKonnertz\StringCalc\Symbols\Concrete\Brackets\ClosingBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Brackets\OpeningBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\EConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\EulerConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LnPiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LnTenConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LnTwoConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LogTenEConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LogTwoEConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\OnePiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiFourConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiTwoConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtOneTwoConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtPiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtThreeConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtTwoConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\TwoPiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\TwoSqrtPiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\AbsFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ACosFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ACosHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ASinFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ASinHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ATanFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ATanHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ATanTwoFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\CeilFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\CosFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\CosHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\DegToRadFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\EnFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ExpFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ExpMOneFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\FloorFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\FModFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\GetRandMaxFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\HypotFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\LogFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\LogOnePFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\LogTenFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MaxFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MinFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MTGetRandMaxFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MTRandFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\PowFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\RadToDegFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\RandFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\RoundFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\SinFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\SinHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\SqrtFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\TanFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\TanHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Number;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\AdditionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\DivisionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\ExponentiationOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\ModuloOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\MultiplicationOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\SubtractionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Separator;

/**
 * This class has one simple job: It contains an array with the names
 * of the initially registered symbols. It does not offer an add()
 * method - but you can add new symbols via the addSymbol() method of
 * the StringCalc class.
 *
 * @package ChrisKonnertz\StringCalc\Symbols
 */
class SymbolRegistry
{

    /**
     * This method has to return an array with the class names of all registered
     * symbols. Symbols have to inherit from the AbstractSymbol class.
     *
     * @return string[]
     */
    public function getSymbols()
    {
        $symbols = [
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Number',

            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Separator',

            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Brackets\ClosingBracket',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Brackets\OpeningBracket',

            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\EConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LogTwoEConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LogTenEConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LnTwoConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LnTenConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiTwoConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiFourConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\OnePiConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\TwoPiConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtPiConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\TwoSqrtPiConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtTwoConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtThreeConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtOneTwoConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LnPiConstant',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\EulerConstant',

            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\AdditionOperator',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\DivisionOperator',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\ExponentiationOperator',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\ModuloOperator',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\MultiplicationOperator',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\SubtractionOperator',

            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\AbsFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ACosFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ACosHFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ASinFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ASinHFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ATanFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ATanHFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ATanTwoFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\CeilFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\CosFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\CosHFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\DegToRadFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\EnFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ExpFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ExpMOneFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\FloorFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\FModFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\GetRandMaxFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\HypotFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\LogFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\LogOnePFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\LogTenFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MaxFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MinFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MTGetRandMaxFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MTRandFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\PowFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\RadToDegFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\RandFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\RoundFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\SinFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\SinHFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\SqrtFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\TanFunction',
            '\ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\TanHFunction',
        ];

        return $symbols;
    }

}
