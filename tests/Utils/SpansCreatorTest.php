<?php
/**
 * SpansCreator Test
 * User: moyo
 * Date: Jul 03, 2019
 * Time: 10:48
 */

namespace Carno\Tracing\Tests\Utils;

use Carno\Coroutine\Context;
use Carno\Tracing\Tests\Mocked\PlatformSwap;
use Carno\Tracing\Utils\SpansCreator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Exception;

class SpansCreatorTest extends TestCase
{
    use SpansCreator;

    public function testUninitialized()
    {
        $this->assertFalse($this->traced());
    }

    public function testCreatingNormal()
    {
        define('TRACING_ID_128BIT', 1);

        $this->newSpan(
            $ctx = new Context(),
            $op = sprintf('name.%d', rand(1000, 9999)),
            ['t1' => 'v1', 't2' => 'v2'],
            ['l1' => 'v1', 'l2' => 'v2'],
            null,
            null,
            null,
            $swap = new PlatformSwap()
        );

        $this->closeSpan($ctx, ['t3' => 'v3']);

        $dat = json_decode($swap->transporter()->data()[0], true);

        $this->assertEquals($op, $dat['op']);

        $this->assertTrue($dat['ctx']['trace.sampled']);
        $this->assertTrue(!!preg_match('/^[a-z0-9]{32}$/', $dat['ctx']['trace.id']));
        $this->assertTrue(!!preg_match('/^[a-z0-9]{16}$/', $dat['ctx']['span.id']));

        $this->assertArraySubset([
            'local' => 'swap',
            't1' => 'v1',
            't2' => 'v2',
            't3' => 'v3',
        ], $dat['tags']);

        $this->assertArraySubset([
            'l1' => 'v1',
            'l2' => 'v2',
        ], $dat['logs'][0][1]);
    }

    public function testCreatingError()
    {
        $this->newSpan(
            $ctx = new Context(),
            $op = sprintf('name.%d', rand(1000, 9999)),
            [],
            [],
            null,
            null,
            null,
            $swap = new PlatformSwap()
        );

        $this->errorSpan($ctx, new Exception($msg = sprintf('test.' . rand(1000, 9999))), ['et' => 'yes']);

        $dat = json_decode($swap->transporter()->data()[0], true);

        $this->assertArraySubset([
            'local' => 'swap',
            'error' => 'true',
            'et' => 'yes',
        ], $dat['tags']);

        $log = $dat['logs'][0][1];

        $this->assertEquals('error', $log['event']);
        $this->assertEquals(Exception::class, $log['error.kind']);
        $this->assertEquals($msg, $log['message']);
    }
}
