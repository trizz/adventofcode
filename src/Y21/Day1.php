<?php

namespace trizz\AdventOfCode\Y21;

use trizz\AdventOfCode\Solution;

class Day1 extends Solution
{
    public static int|string|null $part1ExampleResult = 7;
    public static int|string|null $part1Result = 1688;

    public static int|string|null $part2ExampleResult = 5;
    public static int|string|null $part2Result = 1728;

    /**
     * {@inheritdoc}
     */
    public function part1(array $data): int
    {
        $previous = null;
        $increases = 0;

        /** @var int $current */
        foreach ($data as $current) {
            if ($previous !== null && $previous < $current) {
                ++$increases;
            }

            $previous = $current;
        }

        return $increases;
    }

    /**
     * {@inheritdoc}
     */
    public function part2(array $data): int
    {
        $previousSum = null;
        $increases = 0;

        /**
         * @var int $index
         * @var int $indexValue
         */
        foreach ($data as $index => $indexValue) {
            // If no 'next' indexes are available, skip.
            if (!isset($data[$index + 1], $data[$index + 2])) {
                continue;
            }

            // Calculate the sum of the current value and the next two.
            $newSum = $indexValue + (int) $data[$index + 1] + (int) $data[$index + 2];

            if ($previousSum !== null && $previousSum < $newSum) {
                ++$increases;
            }

            $previousSum = $newSum;
        }

        return $increases;
    }
}
