<?php

namespace NotFloran\MjmlBundle\Tests\Twig;

use NotFloran\MjmlBundle\Renderer\BinaryRenderer;
use NotFloran\MjmlBundle\Tests\AbstractTestCase;
use NotFloran\MjmlBundle\Twig\Extension;
use Twig\Environment;
use Twig\Loader\ArrayLoader as TwigArrayLoader;
use Twig\TemplateWrapper;

class ExtensionTest extends AbstractTestCase
{
    public function testRenderUsingTwigExtension()
    {
        $mjmlBody = file_get_contents(__DIR__.'/../fixtures/basic.mjml');
        $twigTemplate = <<<TWIG
{% mjml %}
$mjmlBody
{% endmjml %}
TWIG;

        $template = $this->getTemplate($twigTemplate);

        $html = $template->render([]);
        $this->assertContains('html', $html);
        $this->assertContains('Hello Floran from MJML and Symfony', $html);
    }

    private function getTemplate($template): TemplateWrapper
    {
        $mjmlRenderer = new BinaryRenderer($this->getMjmlBinary(), false, 'strict', __DIR__.'/../../cache', true);

        $loader = new TwigArrayLoader(['index' => $template]);
        $twig = new Environment($loader, ['debug' => true, 'cache' => false]);
        $twig->addExtension(new Extension($mjmlRenderer));

        return $twig->load('index');
    }
}
