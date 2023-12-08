<?php

namespace trizz\AdventOfCode\Y23;

final class Day6 extends \trizz\AdventOfCode\Solution
{
    public static null|int|string $part1ExampleResult = null;

    public static null|int|string $part1Result = null;

    public static null|int|string $part2ExampleResult = null;

    public static null|int|string $part2Result = null;

    /*

     0 0
     1 6
     2 10
     3 12
     4 12
     5 10
     6 6
     7 0

     */

    #[\Override]
    public function part1(array $data): int
    {
        $time = array_filter(explode(' ', $data[0]));
        $distance = array_filter(explode(' ', $data[1]));
        unset($time[0], $distance[0]);
        $time = array_map('intval', array_values($time));
        $distance = array_map('intval', array_values($distance));

        $maxDistance = [];
        foreach ($time as $key => $value) {
            for ($i = 0; $i < $value; ++$i) {
                // dump($time[$key]);
                $maxDistance[$key][] = 7 + ($time[$key] - $i);
            }

            // dd($maxDistance);
        }

        // dd($maxDistance);

        return -1;
    }

    #[\Override]
    public function part2(array $data): int
    {
        return -1;
    }
}
