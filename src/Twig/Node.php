<?php

namespace NotFloran\MjmlBundle\Twig;

use Twig\Compiler;
use Twig\Node\Node as Twig_Node;

class Node extends Twig_Node
{
    /**
     * @param int         $line
     * @param string|null $tag
     */
    public function __construct(Twig_Node $value, $line, $tag = null)
    {
        parent::__construct(['value' => $value], ['name' => $tag], $line, $tag);
    }

    /**
     * Compile the provided mjml into html.
     */
    public function compile(Compiler $compiler): void
    {
        $compiler->addDebugInfo($this)
            ->write('ob_start();'.PHP_EOL)
            ->subcompile($this->getNode('value'))
            ->write('$content = ob_get_clean();'.PHP_EOL)
            ->write('preg_match("/^\s*/", $content, $matches);'.PHP_EOL)
            ->write('$lines = explode("\n", $content);'.PHP_EOL)
            ->write('$content = preg_replace(\'/^\' . $matches[0]. \'/\', "", $lines);'.PHP_EOL)
            ->write('$content = implode("\n", $content);'.PHP_EOL)
            ->write('echo $this->env->getExtension("'.Extension::class.'")->getMjml()->render($content);'.PHP_EOL);
    }
}
