<?php

namespace NotFloran\MjmlBundle\Twig;

use Twig\Compiler;
use Twig\Node\CaptureNode;
use Twig\Node\Node as Twig_Node;

class Node extends Twig_Node
{
    /**
     * @param int         $line
     * @param string|null $tag
     */
    public function __construct(Twig_Node $value, $line, $tag = null)
    {
        if (class_exists(CaptureNode::class)) {
            $value = new CaptureNode($value, $line, $tag);
            $value->setAttribute('raw', true);
        }

        parent::__construct(['value' => $value], ['name' => $tag], $line, $tag);
    }

    /**
     * Compile the provided mjml into html.
     */
    public function compile(Compiler $compiler): void
    {
        if (class_exists(CaptureNode::class)) {
            $compiler
                ->addDebugInfo($this)
                ->indent()
                ->write('$content = ')
                ->subcompile($this->getNode('value'))
                ->raw("\n")
                ->outdent()
            ;
        } else {
            $compiler
                ->addDebugInfo($this)
                ->indent()
                ->write("ob_start();\n")
                ->subcompile($this->getNode('value'))
                ->outdent()
                ->write("\$content = ob_get_clean();\n")
            ;
        }

        $compiler
            ->write('preg_match("/^\s*/", $content, $matches);'.PHP_EOL)
            ->write('$lines = explode("\n", $content);'.PHP_EOL)
            ->write('$content = preg_replace(\'/^\' . $matches[0]. \'/\', "", $lines);'.PHP_EOL)
            ->write('$content = implode("\n", $content);'.PHP_EOL);

        $compiler->write('echo $this->env->getExtension("'.Extension::class.'")->getMjml()->render($content);'.PHP_EOL);
    }
}
