<?php

namespace ContainerN9zFeK6;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getTransformService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Pipeline\Stage\Transform' shared autowired service.
     *
     * @return \phpDocumentor\Pipeline\Stage\Transform
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Pipeline/Stage/Transform.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Transformer.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/Collection.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/WriterAbstract.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/IoTrait.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/FileIo.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/Sourcecode.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/PathGenerator.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/Pathfinder.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/Initializable.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/Twig.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Template/Factory.php';

        $a = new \phpDocumentor\Transformer\Writer\Collection();

        $b = new \phpDocumentor\Transformer\Writer\PathGenerator(($container->privates['phpDocumentor\\Transformer\\Router\\Router'] ?? $container->load('getRouter2Service')), new \phpDocumentor\Transformer\Writer\Pathfinder());

        $a->offsetSet('FileIo', new \phpDocumentor\Transformer\Writer\FileIo());
        $a->offsetSet('sourcecode', new \phpDocumentor\Transformer\Writer\Sourcecode($b));
        $a->offsetSet('Graph', ($container->privates['phpDocumentor\\Transformer\\Writer\\Graph'] ?? $container->load('getGraphService')));
        $a->offsetSet('twig', new \phpDocumentor\Transformer\Writer\Twig(($container->privates['phpDocumentor\\Transformer\\Writer\\Twig\\EnvironmentFactory'] ?? $container->load('getEnvironmentFactoryService')), $b));
        $a->offsetSet('RenderGuide', ($container->privates['phpDocumentor\\Transformer\\Writer\\RenderGuide'] ?? $container->load('getRenderGuideService')));
        $c = ($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService'));
        $d = ($container->privates['phpDocumentor\\Parser\\FlySystemFactory'] ?? $container->load('getFlySystemFactoryService'));

        return $container->privates['phpDocumentor\\Pipeline\\Stage\\Transform'] = new \phpDocumentor\Pipeline\Stage\Transform(new \phpDocumentor\Transformer\Transformer($a, $c, $d, ($container->services['event_dispatcher'] ?? $container->getEventDispatcherService())), $d, $c, new \phpDocumentor\Transformer\Template\Factory($a, $d, (new \phpDocumentor\Application())->templateDirectory()));
    }
}