<?php

namespace NotFloran\MjmlBundle\Renderer;

use Symfony\Component\Process\Process;

final class BinaryRenderer implements RendererInterface
{
    private const VERSION_4 = 4;
    private const VERSION_BEFORE_4 = 3;

    /**
     * @var string
     */
    private $bin;

    /**
     * @var bool
     */
    private $minify;

    /**
     * @var string
     */
    private $validationLevel;

    /**
     * @var int|null
     */
    private $mjmlVersion;

    public function __construct(string $bin, bool $minify, string $validationLevel)
    {
        $this->bin = $bin;
        $this->minify = $minify;
        $this->validationLevel = $validationLevel;
    }

    public function getMjmlVersion(): int
    {
        if (null === $this->mjmlVersion) {
            $process = new Process([
                $this->bin,
                '--version',
            ]);
            $process->mustRun();

            $this->mjmlVersion = self::VERSION_4;
            if (false === strpos($process->getOutput(), 'mjml-core: 4.')) {
                $this->mjmlVersion = self::VERSION_BEFORE_4;
            }
        }

        return $this->mjmlVersion;
    }

    public function render(string $mjmlContent): string
    {
        $version = $this->getMjmlVersion();

        // Tab arguments
        $arguments = [
            $this->bin,
            '-i',
            '-s',
        ];

        $strictArgument = '-l';
        if (self::VERSION_4 === $version) {
            $strictArgument = '--config.validationLevel';
        }

        array_push($arguments, $strictArgument, $this->validationLevel);

        if (true === $this->minify) {
            if (self::VERSION_4 === $version) {
                array_push($arguments, '--config.minify', 'true');
            } else {
                $arguments[] = '-m';
            }
        }

        // Create process
        $process = new Process($arguments);
        $process->setInput($mjmlContent);
        $process->mustRun();

        return $process->getOutput();
    }
}
