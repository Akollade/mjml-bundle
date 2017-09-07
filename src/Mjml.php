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
     * @var bool
     */
    private $mimify;

    /**
     * @param \Twig_Environment $twig
     * @param string            $bin
     * @param bool              $mimify
     */
    public function __construct(
        \Twig_Environment $twig,
        $bin,
        $mimify
    )
    {
        $this->twig = $twig;
        $this->bin = $bin;
        $this->mimify = $mimify;
    }

    /**
     * @param       $template
     * @param array $parameters
     *
     * @throw \RuntimeException
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

        if ($this->mimify) {
            $builder->add('-m');
        }

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
