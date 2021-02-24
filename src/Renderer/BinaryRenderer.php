<?php

namespace NotFloran\MjmlBundle\Renderer;

use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\CacheItem;
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

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * BinaryRenderer constructor.
     *
     * @param string      $bin
     * @param bool        $minify
     * @param string      $validationLevel
     * @param string      $cacheDir
     * @param bool        $debug
     * @param string|null $node
     */
    public function __construct(
        string $bin,
        bool $minify,
        string $validationLevel,
        string $cacheDir,
        bool $debug,
        string $node = null
    ) {
        $this->bin = $bin;
        $this->minify = $minify;
        $this->validationLevel = $validationLevel;
        $this->node = $node;
        $this->debug = $debug;
        $this->cacheDir = $this->ensureDirExists(sprintf('%s/notFloran/mjml', $cacheDir));
    }

    public function getMjmlVersion(): int
    {
        if (null === $this->mjmlVersion) {
            $cache = new FilesystemAdapter('notFloran_mjml', 0, $this->cacheDir);

            /** @var CacheItem $version */
            $version = $cache->getItem('mjml_version');

            if (!$version->isHit()) {
                $command = [];
                if ($this->node) {
                    $command[] = $this->node;
                }

                array_push($command, $this->bin, '--version');

                $process = new Process($command);
                $process->mustRun();

                $version->set(self::VERSION_4);
                if (false === strpos($process->getOutput(), 'mjml-core: 4.')) {
                    $version->set(self::VERSION_BEFORE_4);
                }

                $cache->save($version);
            }

            $this->mjmlVersion = $version->get();
        }

        return $this->mjmlVersion;
    }

    /**
     * @param string $mjmlContent
     * @param string $templateName
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function render(string $mjmlContent, string $templateName): string
    {
        $templateKey = str_replace(['.', '/'], '_', $templateName);
        $cache = new FilesystemAdapter('notFloran_mjml', 0, $this->cacheDir);

        /** @var CacheItem $render */
        $render = $cache->getItem($templateKey);

        if ($this->debug || !$render->isHit()) {
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

            $render->set($process->getOutput());

            $cache->save($render);
        }

        return $render->get();
    }

    /**
     * @param $dir
     *
     * @return string
     */
    private function ensureDirExists($dir): string
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        return $dir;
    }
}
