<?php

namespace trizz\AdventOfCode\Y21;

use trizz\AdventOfCode\Solution;

class Day3 extends Solution
{
    public static int|string|null $part1ExampleResult = 198;
    public static int|string|null $part1Result = 3309596;

    /**
     * {@inheritdoc}
     */
    public function part1(array $data): int
    {
        $bits = [];

        foreach ($data as $binary) {
            $split = str_split($binary);

            foreach ($split as $position => $value) {
                $bits[$position][] = $value;
            }
        }

        $gammaRate = '';
        $epsilonRate = '';

        foreach ($bits as $values) {
            $zeros = array_filter($values, static fn ($value) => $value === '0');
            $ones = array_filter($values, static fn ($value) => $value === '1');

            $gammaRate .= ($ones > $zeros) ? '1' : '0';
            $epsilonRate .= ($ones < $zeros) ? '1' : '0';
        }

        return (int) (bindec($gammaRate) * bindec($epsilonRate));
    }
}
