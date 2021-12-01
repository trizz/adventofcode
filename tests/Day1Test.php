<?php

namespace Tests;

use AdventOfCode21\Day1;

/**
 * @internal
 */
class Day1Test extends AbstractTestCase
{
    public static int $part1ExampleResult = 7;
    public static int $part1Result = 1688;

    public static int $part2ExampleResult = 5;
    public static int $part2Result = 1728;

    public function setupDay(): Day1
    {
        return new class() extends Day1 {
            use ReturnTestableResults;
        };
    }
}
