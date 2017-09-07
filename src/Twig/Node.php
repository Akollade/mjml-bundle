<?php

namespace NotFloran\MjmlBundle\Twig;

use Twig_Node;
use Twig_Compiler;

class Node extends Twig_Node
{
    /**
     * Node constructor.
     * @param Twig_Node $value
     * @param int $line
     * @param null $tag
     */
    public function __construct(Twig_Node $value, $line, $tag = null)
    {
        parent::__construct(['value' => $value], ['name' => $tag], $line, $tag);
    }

    /**
     * Compile the provided mjml into html.
     *
     * @param  Twig_Compiler $compiler
     * @return void
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this)
            ->write('ob_start();' . PHP_EOL)
            ->subcompile($this->getNode('value'))
            ->write('$content = ob_get_clean();' . PHP_EOL)
            ->write('preg_match("/^\s*/", $content, $matches);' . PHP_EOL)
            ->write('$lines = explode("\n", $content);'.PHP_EOL)
            ->write('$content = preg_replace(\'/^\' . $matches[0]. \'/\', "", $lines);' . PHP_EOL)
            ->write('$content = implode("\n", $content);' . PHP_EOL)
            ->write('echo $this->env->getTags()["mjml"]
                                    ->getMjml()
                                    ->render($content);
                '.PHP_EOL);
    }

}