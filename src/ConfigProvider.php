<?php
/**
 * @link      http://github.com/zendframework/zend-mvc-console for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Mvc\Console;

use Zend\Mvc\SendResponseListener;
use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    /**
     * Provide configuration for this component.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'controller_plugins' => $this->getPluginConfig(),
            'dependencies'       => $this->getDependencyConfig(),
        ];
    }

    /**
     * Provide dependency configuration for this component.
     *
     * @return array
     */
    public function getDependencyConfig()
    {
        return [
            'aliases' => [
                'ConsoleDefaultRenderingStrategy' => View\DefaultRenderingStrategy::class,
                'ConsoleRenderer'                 => View\Renderer::class,
            ],
            'delegator_factories' => [
                'Application'               => [ Service\ConsoleApplicationDelegatorFactory::class ],
                'ControllerManager'         => [ Service\ControllerManagerDelegatorFactory::class ],
                'ControllerPluginManager'   => [ Service\ControllerPluginManagerDelegatorFactory::class ],
                'Request'                   => [ Service\ConsoleRequestDelegatorFactory::class ],
                'Response'                  => [ Service\ConsoleResponseDelegatorFactory::class ],
                'Router'                    => [ Router\ConsoleRouterDelegatorFactory::class ],
                SendResponseListener::class => [ Service\ConsoleResponseSenderDelegatorFactory::class ],
                'ViewHelperManager'         => [ Service\ConsoleViewHelperManagerDelegatorFactory::class ],
            ],
            'factories' => [
                'ConsoleAdapter'               => Service\ConsoleAdapterFactory::class,
                'ConsoleExceptionStrategy'     => Service\ConsoleExceptionStrategyFactory::class,
                'ConsoleRouteNotFoundStrategy' => Service\ConsoleRouteNotFoundStrategyFactory::class,
                'ConsoleRouter'                => Router\ConsoleRouterFactory::class,
                'ConsoleViewManager'           => Service\ConsoleViewManagerFactory::class,
                View\DefaultRenderingStrategy::class => Service\DefaultRenderingStrategyFactory::class,
                View\Renderer::class           => InvokableFactory::class,
            ],
        ];
    }

    /**
     * Provide controller plugin configuration for this component.
     *
     * @return array
     */
    public function getPluginConfig()
    {
        // @codingStandardsIgnoreStart
        return [
            'aliases' => [
                'CreateConsoleNotFoundModel' => Controller\Plugin\CreateConsoleNotFoundModel::class,
                'createConsoleNotFoundModel' => Controller\Plugin\CreateConsoleNotFoundModel::class,
                'createconsolenotfoundmodel' => Controller\Plugin\CreateConsoleNotFoundModel::class,
                'Zend\Mvc\Controller\Plugin\CreateConsoleNotFoundModel::class' => Controller\Plugin\CreateConsoleNotFoundModel::class,
            ],
            'factories' => [
                Controller\Plugin\CreateConsoleNotFoundModel::class => InvokableFactory::class,
            ],
        ];
        // @codingStandardsIgnoreEnd
    }
}
