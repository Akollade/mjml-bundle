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

    /**
     * @var string|null
     */
    private $node;

    public function __construct(string $bin, bool $minify, string $validationLevel, ?string $node = null, ?int $mjmlVersion = null)
    {
        $this->bin = $bin;
        $this->minify = $minify;
        $this->validationLevel = $validationLevel;
        $this->node = $node;
        $this->mjmlVersion = $mjmlVersion;
    }

    public function getMjmlVersion(): int
    {
        if (null === $this->mjmlVersion) {
            $command = [];
            if ($this->node) {
                $command[] = $this->node;
            }

            array_push($command, $this->bin, '--version');

            $process = new Process($command);
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

        $command = [];
        if ($this->node) {
            $command[] = $this->node;
        }

        array_push($command, $this->bin, '-i', '-s');

        $strictArgument = '-l';
        if (self::VERSION_4 === $version) {
            $strictArgument = '--config.validationLevel';
        }

        array_push($command, $strictArgument, $this->validationLevel);

        if (true === $this->minify) {
            if (self::VERSION_4 === $version) {
                array_push($command, '--config.minify', 'true');
            } else {
                $command[] = '-m';
            }
        }

        // Create process
        $process = new Process($command);
        $process->setInput($mjmlContent);
        $process->mustRun();

        return $process->getOutput();
    }
}
