<?php

namespace Tests;

use AdventOfCode21\Day7;

/**
 * @internal
 */
class Day7Test extends AbstractTestCase
{
    public static int $part1ExampleResult = 37;
    public static int $part1Result = 344297;

    public static int $part2ExampleResult = 168;
    public static int $part2Result = 97164301;

    public function setupDay(): Day7
    {
        return new class() extends Day7 {
            use ReturnTestableResults;
        };
    }
}
