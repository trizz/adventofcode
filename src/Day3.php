<?php

namespace AdventOfCode21;

class Day3 extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected static int $day = 3;

    /**
     * {@inheritdoc}
     */
    protected function part1(array $data): int
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

    /**
     * @param string[] $data
     * @param int      $position
     * @param bool     $highest
     *
     * @return string
     *
     * @psalm-return '0'|'1'
     */
    private function valueAtPosition(array $data, int $position, bool $highest = true): string
    {
        $zeros = count(array_filter($data, static fn ($value) => $value[$position] === '0'));
        $ones = count(array_filter($data, static fn ($value) => $value[$position] === '1'));

        if ($highest) {
            return $zeros > $ones ? '0' : '1';
        }

        if ($zeros === $ones) {
            return '0';
        }

        // If there are more zeros, return 1 (as that is the lowest).
        return $zeros > $ones ? '1' : '0';
    }
}
