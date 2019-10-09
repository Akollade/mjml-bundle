<?php

namespace NotFloran\MjmlBundle\Tests\Renderer;

use NotFloran\MjmlBundle\Renderer\BinaryRenderer;
use NotFloran\MjmlBundle\Tests\AbstractTestCase;

class BinaryRendererTest extends AbstractTestCase
{
    public function testBasicRender()
    {
        $renderer = new BinaryRenderer($this->getMjmlBinary(), false, 'strict');
        $html = $renderer->render(file_get_contents(__DIR__.'/../fixtures/basic.mjml'));

        $this->assertContains('html', $html);
        $this->assertContains('Hello Floran from MJML and Symfony', $html);
    }

    public function testInvalidRender()
    {
        $this->expectException(\RuntimeException::class);

        $renderer = new BinaryRenderer($this->getMjmlBinary(), false, 'strict');
        $renderer->render(file_get_contents(__DIR__.'/../fixtures/invalid.mjml'));
    }

    public function testInvalidRenderWithSkipValidationLevel()
    {
        $renderer = new BinaryRenderer($this->getMjmlBinary(), false, 'skip');
        $html = $renderer->render(file_get_contents(__DIR__.'/../fixtures/invalid.mjml'));

        $this->assertContains('html', $html);
    }

    public function testInvalidRenderWithSoftValidationLevel()
    {
        $renderer = new BinaryRenderer($this->getMjmlBinary(), false, 'soft');
        $html = $renderer->render(file_get_contents(__DIR__.'/../fixtures/invalid.mjml'));

        $this->assertContains('html', $html);
    }

    public function testBinaryNotFound()
    {
        $this->expectException(\RuntimeException::class);

        $renderer = new BinaryRenderer('mjml-not-found', false, 'strict');
        $renderer->render(file_get_contents(__DIR__.'/../fixtures/basic.mjml'));
    }
}
