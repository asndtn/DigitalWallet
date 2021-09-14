<?php

namespace ContainerN9zFeK6;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCollectFilesService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Pipeline\Stage\Parser\CollectFiles' shared autowired service.
     *
     * @return \phpDocumentor\Pipeline\Stage\Parser\CollectFiles
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Pipeline/Stage/Parser/CollectFiles.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/FileCollector.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/FlySystemCollector.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/SpecificationFactoryInterface.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/SpecificationFactory.php';

        return $container->privates['phpDocumentor\\Pipeline\\Stage\\Parser\\CollectFiles'] = new \phpDocumentor\Pipeline\Stage\Parser\CollectFiles(new \phpDocumentor\Parser\FlySystemCollector(new \phpDocumentor\Parser\SpecificationFactory(), ($container->privates['phpDocumentor\\Parser\\FlySystemFactory'] ?? $container->load('getFlySystemFactoryService'))), ($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService')));
    }
}
