<?php

namespace Tests;

use AdventOfCode21\Day3;

/**
 * @internal
 */
class Day3Test extends AbstractTestCase
{
    public static int $part1ExampleResult = 198;
    public static int $part1Result = 3309596;

    public static string $part2ExampleResult = 'n/a';
    public static string $part2Result = 'n/a';

    public function setupDay(): Day3
    {
        return new class() extends Day3 {
            use ReturnTestableResults;
        };
    }
}
