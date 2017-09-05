<?php

namespace notFloran\MjmlBundle;

use Symfony\Component\Process\Process;

class Mjml
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render($template, array $parameters)
    {
        $mjmlTemplate = $this->twig->render($template, $parameters);

        $process = new Process('mjml -i -s');
        $process->setInput($mjmlTemplate);
        $process->run();

        return $process->getOutput();
    }
}
