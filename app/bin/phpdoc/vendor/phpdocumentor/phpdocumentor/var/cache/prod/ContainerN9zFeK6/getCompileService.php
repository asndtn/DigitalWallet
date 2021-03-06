<?php

namespace ContainerN9zFeK6;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCompileService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Pipeline\Stage\Compile' shared autowired service.
     *
     * @return \phpDocumentor\Pipeline\Stage\Compile
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Pipeline/Stage/Compile.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Compiler.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/CompilerPassInterface.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Pass/TableOfContentsBuilder.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Pass/ElementsIndexBuilder.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Pass/MarkerFromTagsExtractor.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Pass/PackageTreeBuilder.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Pass/NamespaceTreeBuilder.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Pass/ResolveInlineMarkers.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Pass/Debug.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Descriptor/ProjectAnalyzer.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Pass/RemoveSourcecode.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Linker/Linker.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Compiler/Linker/DescriptorRepository.php';

        $a = new \phpDocumentor\Compiler\Compiler();

        $b = ($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService'));

        $a->insert(new \phpDocumentor\Compiler\Pass\TableOfContentsBuilder(($container->privates['phpDocumentor\\Transformer\\Router\\Router'] ?? $container->load('getRouter2Service')), $b), 2000);
        $a->insert(new \phpDocumentor\Compiler\Pass\ElementsIndexBuilder(), 15000);
        $a->insert(new \phpDocumentor\Compiler\Pass\MarkerFromTagsExtractor(), 9000);
        $a->insert(new \phpDocumentor\Compiler\Pass\PackageTreeBuilder(($container->privates['phpDocumentor\\Parser\\Parser'] ?? $container->load('getParserService'))), 9001);
        $a->insert(new \phpDocumentor\Compiler\Pass\NamespaceTreeBuilder(), 9000);
        $a->insert(new \phpDocumentor\Compiler\Pass\ResolveInlineMarkers(), 9000);
        $a->insert(new \phpDocumentor\Compiler\Pass\Debug($b, new \phpDocumentor\Descriptor\ProjectAnalyzer()), 1000);
        $a->insert(new \phpDocumentor\Compiler\Pass\RemoveSourcecode(), 2000);
        $a->insert(new \phpDocumentor\Compiler\Linker\Linker($container->parameters['linker.substitutions'], new \phpDocumentor\Compiler\Linker\DescriptorRepository()));

        return $container->privates['phpDocumentor\\Pipeline\\Stage\\Compile'] = new \phpDocumentor\Pipeline\Stage\Compile($a);
    }
}
