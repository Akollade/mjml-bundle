<?php

namespace NotFloran\MjmlBundle\Tests\Renderer;

use NotFloran\MjmlBundle\Renderer\BinaryRenderer;
use NotFloran\MjmlBundle\Tests\AbstractTestCase;

class BinaryRendererTest extends AbstractTestCase
{
    public function testBasicRender()
    {
        $renderer = new BinaryRenderer($this->getMjmlBinary(), false);
        $html = $renderer->render(file_get_contents(__DIR__.'/../fixtures/basic.mjml'));

        $this->assertContains('html', $html);
        $this->assertContains('Hello Floran from MJML and Symfony', $html);
    }

}