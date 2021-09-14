<?php

namespace ContainerN9zFeK6;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCache_SystemClearerService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the public 'cache.system_clearer' shared service.
     *
     * @return \Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 6).'/symfony/http-kernel/CacheClearer/CacheClearerInterface.php';
        include_once \dirname(__DIR__, 6).'/symfony/http-kernel/CacheClearer/Psr6CacheClearer.php';

        return $container->services['cache.system_clearer'] = new \Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer(['cache.app' => ($container->services['cache.app'] ?? null), 'cache.system' => ($container->services['cache.system'] ?? null), 'cache.validator' => null, 'cache.serializer' => null, 'cache.annotations' => null, 'cache.property_info' => null]);
    }
}
