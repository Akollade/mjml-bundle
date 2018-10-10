<?php

namespace NotFloran\MjmlBundle\Twig;

use NotFloran\MjmlBundle\Renderer\RendererInterface;
use Twig_Extension;
use Twig_Extension_GlobalsInterface;

class Extension extends Twig_Extension implements Twig_Extension_GlobalsInterface
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
    public function getGlobals()
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
