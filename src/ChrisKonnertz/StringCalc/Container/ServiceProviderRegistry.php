<?php

namespace ChrisKonnertz\StringCalc\Container;

use ChrisKonnertz\StringCalc\Container\ServiceProviders\CalculatorServiceProvider;
use ChrisKonnertz\StringCalc\Container\ServiceProviders\InputStreamServiceProvider;
use ChrisKonnertz\StringCalc\Container\ServiceProviders\StringHelperServiceProvider;
use ChrisKonnertz\StringCalc\Container\ServiceProviders\SymbolContainerServiceProvider;

/**
 * This class is where all service providers are registered
 * (except of those that are registered at runtime).
 *
 * @package ChrisKonnertz\StringCalc\Container
 */
class ServiceProviderRegistry implements ServiceProviderRegistryInterface
{

    /**
     * @inheritdoc
     */
    public function getServiceProviders()
    {
        $serviceProviders = [
            'stringcalc_stringhelper'       => '\ChrisKonnertz\StringCalc\Container\ServiceProviders\StringHelperServiceProvider',
            'stringcalc_inputstream'        => '\ChrisKonnertz\StringCalc\Container\ServiceProviders\InputStreamServiceProvider',
            'stringcalc_symbolcontainer'    => '\ChrisKonnertz\StringCalc\Container\ServiceProviders\SymbolContainerServiceProvider',
            'stringcalc_calculator'         => '\ChrisKonnertz\StringCalc\Container\ServiceProviders\CalculatorServiceProvider',
        ];

        return $serviceProviders;
    }

}
