<?php

namespace Tests;

use AdventOfCode21\Day4;

/**
 * @internal
 */
class Day4Test extends AbstractTestCase
{
    public static int $part1ExampleResult = 4512;
    public static int $part1Result = 60368;

    public static int $part2ExampleResult = 1924;
    public static int $part2Result = 17435;

    public function setupDay(): Day4
    {
        return new class() extends Day4 {
            use ReturnTestableResults;
        };
    }
}
