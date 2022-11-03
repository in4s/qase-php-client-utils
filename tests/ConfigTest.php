<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Qase\PhpClientUtils\Config;

class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        putenv('QASE_PROJECT_CODE=hi');
        putenv('QASE_API_BASE_URL=hi');
        putenv('QASE_API_TOKEN=hi');
    }

    public function testRunDescription()
    {
        putenv('QASE_RUN_DESCRIPTION=Qase run description');
        $config = new Config('FakeReporter');
        $this->assertEquals('Qase run description', $config->getRunDescription());
    }

    public function testEmptyRunDescription()
    {
        // Set empty value
        putenv('QASE_RUN_DESCRIPTION=');
        $config = new Config('FakeReporter');
        $this->assertEquals('', $config->getRunDescription());
    }

    public function testDefaultRunDescription()
    {
        // Unset ENV variable
        putenv('QASE_RUN_DESCRIPTION');
        $config = new Config('FakeReporter');
        $this->assertEquals('FakeReporter automated run', $config->getRunDescription());
    }

    public function testRequiredParamsValidation()
    {
        // Unset required ENV variable
        putenv('QASE_API_TOKEN');
        // Set empty required ENV variable
        putenv('QASE_API_BASE_URL=');
        $this->expectExceptionMessage('The Qase FakeReporter reporter needs the following environment variable(s) to be set: QASE_API_BASE_URL, QASE_API_TOKEN.');
        new Config('FakeReporter');
    }
}
