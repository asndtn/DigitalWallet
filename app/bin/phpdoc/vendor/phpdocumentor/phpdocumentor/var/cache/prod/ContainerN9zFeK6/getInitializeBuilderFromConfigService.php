<?php

namespace ContainerN9zFeK6;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getInitializeBuilderFromConfigService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Pipeline\Stage\InitializeBuilderFromConfig' shared autowired service.
     *
     * @return \phpDocumentor\Pipeline\Stage\InitializeBuilderFromConfig
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Pipeline/Stage/InitializeBuilderFromConfig.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Descriptor/Collection.php';

        return $container->privates['phpDocumentor\\Pipeline\\Stage\\InitializeBuilderFromConfig'] = new \phpDocumentor\Pipeline\Stage\InitializeBuilderFromConfig(new \phpDocumentor\Descriptor\Collection());
    }
}