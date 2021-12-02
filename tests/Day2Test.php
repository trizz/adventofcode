<?php

namespace Tests;

use AdventOfCode21\Day2;

/**
 * @internal
 */
class Day2Test extends AbstractTestCase
{
    public static int $part1ExampleResult = 150;
    public static int $part1Result = 1654760;

    public static int $part2ExampleResult = 900;
    public static int $part2Result = 1956047400;

    public function setupDay(): Day2
    {
        return new class() extends Day2 {
            use ReturnTestableResults;
        };
    }
}
