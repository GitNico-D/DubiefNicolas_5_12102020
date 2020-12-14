<?php

namespace ContainerFSpH7g6;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_CwterQlService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.cwterQl' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.cwterQl'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'category' => ['privates', '.errored..service_locator.cwterQl.App\\Entity\\Category', NULL, 'Cannot autowire service ".service_locator.cwterQl": it references class "App\\Entity\\Category" but no such service exists.'],
            'customLink' => ['privates', 'App\\Services\\CustomHateoasLinks', 'getCustomHateoasLinksService', true],
        ], [
            'category' => 'App\\Entity\\Category',
            'customLink' => 'App\\Services\\CustomHateoasLinks',
        ]);
    }
}