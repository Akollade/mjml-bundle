<?php

namespace NotFloran\MjmlBundle\Twig;

use NotFloran\MjmlBundle\Renderer\RendererInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class Extension extends AbstractExtension implements GlobalsInterface
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
     * Return the name of the extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'mjml';
    }

    /**
     * Setup the twig globals.
     *
     * @return array
     */
    public function getGlobals(): array
    {
        return [
            'mjml' => $this->mjml
        ];
    }

    /**
     * Setup twig tags.
     *
     * @return array
     */
    public function getTokenParsers()
    {
        return [
            new TokenParser($this->mjml)
        ];
    }
}
