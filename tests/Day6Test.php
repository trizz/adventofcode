<?php

namespace Tests;

use AdventOfCode21\Day6;

/**
 * @internal
 */
class Day6Test extends AbstractTestCase
{
    public static int $part1ExampleResult = 5934;
    public static int $part1Result = 350917;

    public static int $part2ExampleResult = 26984457539;
    public static int $part2Result = 1592918715629;

    public function setupDay(): Day6
    {
        return new class() extends Day6 {
            use ReturnTestableResults;
        };
    }
}
