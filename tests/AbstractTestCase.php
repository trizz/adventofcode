<?php

namespace Tests;

use AdventOfCode21\AbstractCommand;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    public AbstractCommand $command;

    protected function setUp(): void
    {
        $this->command = $this->setupDay();
    }

    public function testPart1(): void
    {
        $this->assertSame(static::$part1ExampleResult, $this->command->part1ExampleResult());
        $this->assertSame(static::$part1Result, $this->command->part1Result());
    }

    public function testPart2(): void
    {
        $this->assertSame(static::$part2ExampleResult, $this->command->part2ExampleResult());
        $this->assertSame(static::$part2Result, $this->command->part2Result());
    }

    abstract public function setupDay(): AbstractCommand;
}
