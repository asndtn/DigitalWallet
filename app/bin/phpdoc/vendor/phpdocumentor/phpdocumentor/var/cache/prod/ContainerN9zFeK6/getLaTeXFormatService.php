<?php

namespace ContainerN9zFeK6;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getLaTeXFormatService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Guides\RestructuredText\LaTeX\LaTeXFormat' shared autowired service.
     *
     * @return \phpDocumentor\Guides\RestructuredText\LaTeX\LaTeXFormat
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/Guides/Formats/Format.php';
        include_once \dirname(__DIR__, 4).'/src/Guides/RestructuredText/Formats/Format.php';
        include_once \dirname(__DIR__, 4).'/src/Guides/RestructuredText/LaTeX/LaTeXFormat.php';

        return $container->privates['phpDocumentor\\Guides\\RestructuredText\\LaTeX\\LaTeXFormat'] = new \phpDocumentor\Guides\RestructuredText\LaTeX\LaTeXFormat('tex', new RewindableGenerator(function () use ($container) {
            yield 0 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\LaTeX\\Directives\\LaTeXMain'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\LaTeX\\Directives\\LaTeXMain'] = new \phpDocumentor\Guides\RestructuredText\LaTeX\Directives\LaTeXMain()));
            yield 1 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\LaTeX\\Directives\\Title'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\LaTeX\\Directives\\Title'] = new \phpDocumentor\Guides\RestructuredText\LaTeX\Directives\Title()));
            yield 2 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\LaTeX\\Directives\\Wrap'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\LaTeX\\Directives\\Wrap'] = new \phpDocumentor\Guides\RestructuredText\LaTeX\Directives\Wrap()));
        }, 3));
    }
}
