<?php

namespace NotFloran\MjmlBundle;

use Symfony\Component\Process\Process;

class Mjml
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $bin;

    /**
     * @param \Twig_Environment $twig
     * @param                   $bin
     */
    public function __construct(\Twig_Environment $twig, $bin)
    {
        $this->twig = $twig;
        $this->bin = $bin;
    }

    /**
     * @param       $template
     * @param array $parameters
     *
     * @return string
     */
    public function render($template, array $parameters = [])
    {
        $mjmlTemplate = $this->twig->render($template, $parameters);

        $process = new Process($this->bin . ' -i -s');
        $process->setInput($mjmlTemplate);
        $process->run();

        return $process->getOutput();
    }
}
