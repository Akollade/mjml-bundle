<?php

namespace NotFloran\MjmlBundle;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

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

        $builder = new ProcessBuilder();
        $builder->setPrefix($this->bin);
        $builder->setArguments([
            '-i',
            '-s',
        ]);
        $builder->setInput($mjmlTemplate);

        $process = $builder->getProcess();
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \RuntimeException(sprintf(
                'The exit status code \'%s\' says something went wrong:'."\n"
                .'stderr: "%s"'."\n"
                .'stdout: "%s"'."\n"
                .'command: %s.',
                $process->getStatus(),
                $process->getErrorOutput(),
                $process->getOutput(),
                $process->getCommandLine()
            ));
        }

        return $process->getOutput();
    }
}
