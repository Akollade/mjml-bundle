<?php

namespace NotFloran\MjmlBundle\Renderer;

interface RendererInterface
{
    public function render(string $mjmlContent, string $templateName): string;
}
