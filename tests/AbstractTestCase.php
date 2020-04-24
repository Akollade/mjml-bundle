<?php

namespace NotFloran\MjmlBundle\Tests;

use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function getMjmlBinary(): string
    {
        $binary = 'node_modules/.bin/mjml';

        if (!file_exists($binary)) {
            throw new \Exception('MJML not installed');
        }

        return $binary;
    }
}
