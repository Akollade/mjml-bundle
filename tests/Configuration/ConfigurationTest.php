<?php

namespace NotFloran\MjmlBundle\Tests\Configuration;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use NotFloran\MjmlBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration()
    {
        return new Configuration();
    }

    public function testBinaryConfiguration()
    {
        $config = [
            [
                'renderer' => 'binary',
                'options' => [
                    'binary' => 'mjml',
                    'minify' => true,
                ],
            ],
        ];

        $this->assertConfigurationIsValid($config);
    }

    public function testInvalidBinaryConfiguration()
    {
        $config = [
            [
                'renderer' => 'binary',
                'options' => [
                    'binary' => null,
                ],
            ],
        ];

        $this->assertConfigurationIsInvalid($config, 'Binary is missing');
    }

    public function testServiceConfiguration()
    {
        $config = [
            [
                'renderer' => 'service',
                'options' => [
                    'service_id' => 'App\Mjml\TestRenderer',
                ],
            ],
        ];

        $this->assertConfigurationIsValid($config);
    }

    public function testInvalidServiceConfiguration()
    {
        $config = [
            [
                'renderer' => 'service',
                'options' => [],
            ],
        ];

        $this->assertConfigurationIsInvalid($config, '"service_id" is missing for service renderer');
    }

    public function testValidationLevelConfiguration()
    {
        $config = [
            [
                'renderer' => 'binary',
                'options' => [
                    'binary' => 'mjml',
                    'validation_level' => 'strict',
                ],
            ],
        ];

        $this->assertConfigurationIsValid($config);
    }

    public function testInvalidValidationLevelConfiguration()
    {
        $config = [
            [
                'renderer' => 'binary',
                'options' => [
                    'binary' => 'mjml',
                    'validation_level' => 'something_invalid',
                ],
            ],
        ];

        $this->assertConfigurationIsInvalid($config, 'Validation level is invalid');
    }

    public function testMjmlVersionConfiguration()
    {
        $config = [
            [
                'renderer' => 'binary',
                'options' => [
                    'binary' => 'mjml',
                    'mjml_version' => 4,
                ],
            ],
        ];

        $this->assertConfigurationIsValid($config);
    }

    public function testInvalidMjmlVersionConfiguration()
    {
        $config = [
            [
                'renderer' => 'binary',
                'options' => [
                    'binary' => 'mjml',
                    'mjml_version' => 2,
                ],
            ],
        ];

        $this->assertConfigurationIsInvalid(
            $config,
            'The value 2 is too small for path "mjml.options.mjml_version". Should be greater than or equal to 3'
        );
    }
}
