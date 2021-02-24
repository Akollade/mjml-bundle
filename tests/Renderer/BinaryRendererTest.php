<?php

namespace NotFloran\MjmlBundle\Tests\Renderer;

use NotFloran\MjmlBundle\Renderer\BinaryRenderer;
use NotFloran\MjmlBundle\Tests\AbstractTestCase;

class BinaryRendererTest extends AbstractTestCase
{
    public function testBasicRender()
    {
        $renderer = new BinaryRenderer($this->getMjmlBinary(), false, 'strict', $this->getCacheDir(), true);
        $html = $renderer->render(file_get_contents(__DIR__.'/../fixtures/basic.mjml'), 'basic.mjml');

        $this->assertContains('html', $html);
        $this->assertContains('Hello Floran from MJML and Symfony', $html);
    }

    public function testInvalidRender()
    {
        $this->expectException(\RuntimeException::class);

        $renderer = new BinaryRenderer($this->getMjmlBinary(), false, 'strict', $this->getCacheDir(), true);
        $renderer->render(file_get_contents(__DIR__.'/../fixtures/invalid.mjml'), 'invalid.mjml');
    }

    public function testInvalidRenderWithSkipValidationLevel()
    {
        $renderer = new BinaryRenderer($this->getMjmlBinary(), false, 'skip',$this->getCacheDir(), true);
        $html = $renderer->render(file_get_contents(__DIR__.'/../fixtures/invalid.mjml'), 'invalid.mjml');

        $this->assertContains('html', $html);
    }

    public function testInvalidRenderWithSoftValidationLevel()
    {
        $renderer = new BinaryRenderer($this->getMjmlBinary(), false, 'soft',$this->getCacheDir(), true);
        $html = $renderer->render(file_get_contents(__DIR__.'/../fixtures/invalid.mjml'), 'invalid.mjml');

        $this->assertContains('html', $html);
    }

    public function testBinaryNotFound()
    {
        $this->expectException(\RuntimeException::class);

        $renderer = new BinaryRenderer('mjml-not-found', false, 'strict',$this->getCacheDir(), true);
        $renderer->render(file_get_contents(__DIR__.'/../fixtures/basic.mjml'), 'basic.mjml');
    }

    public function testUseNode()
    {
        $renderer = new BinaryRenderer($this->getMjmlBinary(), false, 'strict', $this->getCacheDir(), true, $this->getNode());
        $html = $renderer->render(file_get_contents(__DIR__.'/../fixtures/basic.mjml'), 'basic.mjml');

        $this->assertContains('html', $html);
    }
}
