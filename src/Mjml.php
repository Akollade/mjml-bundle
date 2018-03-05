<?php

namespace NotFloran\MjmlBundle;

use Symfony\Component\Process\Process;

class Mjml
{
    /**
     * @var string
     */
    private $bin;

    /**
     * @var bool
     */
    private $mimify;

    /**
     * @param string $bin
     * @param bool   $mimify
     */
    public function __construct($bin, $mimify)
    {
        $this->bin = $bin;
        $this->mimify = $mimify;
    }

    /**
     * @param string $mjmlContent
     * @throw \RuntimeException
     *
     * @return string
     */
    public function render($mjmlContent)
    {
        // Tab arguments
        $arguments = [
            $this->bin,
            '-i',
            '-s',
            '-l',
            'strict',
        ];

        if (true === $this->mimify) {
            array_push($arguments, '-m');
        }

        // Create process
        $process = new Process($arguments);
        $process->setInput($mjmlContent);
        $process->run();

        // Executes after the command finishes
        if (true !== $process->isSuccessful()) {
            throw new \RuntimeException(sprintf(
                'The exit status code \'%s\' says something went wrong:' . "\n"
                . 'stderr: "%s"' . "\n"
                . 'stdout: "%s"' . "\n"
                . 'command: %s.',
                $process->getStatus(),
                $process->getErrorOutput(),
                $process->getOutput(),
                $process->getCommandLine()
            ));
        }

        return $process->getOutput();
    }
}
