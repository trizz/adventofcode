<?php

namespace trizz\AdventOfCode\Y21;

use trizz\AdventOfCode\Solution;

final class Day3 extends Solution
{
    public static null|int|string $part1ExampleResult = 198;

    public static null|int|string $part1Result = 3_309_596;

    #[\Override]
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

        foreach ($bits as $bit) {
            $zeros = array_filter($bit, static fn ($value): bool => $value === '0');
            $ones = array_filter($bit, static fn ($value): bool => $value === '1');

            $gammaRate .= ($ones > $zeros) ? '1' : '0';
            $epsilonRate .= ($ones < $zeros) ? '1' : '0';
        }

        return (int) (bindec($gammaRate) * bindec($epsilonRate));
    }
}
