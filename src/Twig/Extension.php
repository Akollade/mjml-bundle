<?php

namespace NotFloran\MjmlBundle\Twig;

use NotFloran\MjmlBundle\Renderer\RendererInterface;
use Twig\Extension\AbstractExtension;

class Extension extends AbstractExtension
{
    /**
     * @var RendererInterface
     */
    protected $mjml;

    public function __construct(RendererInterface $mjml)
    {
        $this->mjml = $mjml;
    }

    /**
     * Setup twig tags.
     *
     * @return array
     */
    public function getTokenParsers()
    {
        return [
            new TokenParser(),
        ];
    }

    public function getMjml(): RendererInterface
    {
        return $this->mjml;
    }
}
