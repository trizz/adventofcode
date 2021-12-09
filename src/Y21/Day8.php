<?php

namespace trizz\AdventOfCode\Y21;

use trizz\AdventOfCode\Solution;
use trizz\AdventOfCode\Utils\Arr;
use trizz\AdventOfCode\Utils\Str;

class Day8 extends Solution
{
    public static int|string|null $part1ExampleResult = 26;

    public static int|string|null $part1Result = 397;

    public static int|string|null $part2ExampleResult = 61229;

    public static int|string|null $part2Result = 1027422;

    private array $digitPatterns;

    private array $patternDigits;

    /**
     * {@inheritdoc}
     */
    public function part1(array $data): int
    {
        $values = array_map(
            static fn ($item) => strlen($item),
            Arr::flatten(
                array_map(
                    static fn ($item) => explode(' ', $item),
                    array_map(
                        static fn ($item) => explode(' | ', $item)[1],
                        $data
                    )
                )
            )
        );

        return count(array_intersect($values, [2, 4, 3, 7]));
    }

    public function part2(array $data): int|string
    {
        $sequences = [];

        foreach ($data as $line) {
            $item = explode(' | ', $line);
            $sequences[] = [
                'patterns' => array_map([Str::class, 'sort'], explode(' ', $item[0])),
                'shown' => array_map([Str::class, 'sort'], explode(' ', $item[1])),
            ];
        }

        $results = [];
        foreach ($sequences as $sequence) {
            $this->mapDigits($sequence['patterns']);
            $output = '';

            foreach ($sequence['shown'] as $pattern) {
                $output .= $this->patternDigits[$pattern];
            }

            $results[] = (int) $output;
        }

        return array_sum($results);
    }

    /**
     * @param array $patterns
     *
     * Code based on (sorry, didn't have a clue to solve this one, so I needed some inspiration):
     *
     * @see https://github.com/MueR/adventofcode/blob/master/src/AdventOfCode2021/Day08/Day08.php
     */
    public function mapDigits(array $patterns): void
    {
        /** @noinspection PackedHashtableOptimizationInspection */
        $findDigit = [
            // 1 is the only one with 2 segments
            1 => static fn (string $pattern) => strlen($pattern) === 2,
            // 7 is the only one with 3 segments
            7 => static fn (string $pattern) => strlen($pattern) === 3,
            // 4 is the only one with 4 segments
            4 => static fn (string $pattern) => strlen($pattern) === 4,
            // 8 is the only one with 7 segments
            8 => static fn (string $pattern) => strlen($pattern) === 7,
            // 9 is 6 segments, matches segments for 4
            9 => fn (string $pattern) => strlen($pattern) === 6 && Str::matchesAll(
                $pattern,
                $this->digitPatterns[4] ?? ''
            ),
            // 0 is 6 segments, matching 1's segments (9 is already out)
            0 => fn (string $pattern) => strlen($pattern) === 6 && Str::matchesAll(
                $pattern,
                $this->digitPatterns[1] ?? ''
            ),
            // 6 is 6 segments, the only one left
            6 => static fn (string $pattern) => strlen($pattern) === 6,
            // 3 is 5 segments and matches 1's segments
            3 => fn (string $pattern) => strlen($pattern) === 5 && Str::matchesAll(
                $pattern,
                $this->digitPatterns[1] ?? ''
            ),
            // 5 is 5 segments, and 9 has all the segments of 5
            5 => fn (string $pattern) => strlen($pattern) === 5 && Str::matchesAll(
                $this->digitPatterns[9] ?? '',
                $pattern
            ),
            // 2 is the only one remaining
            2 => static fn (string $pattern) => true,
        ];

        foreach ($findDigit as $digit => $test) {
            foreach ($patterns as $key => $pattern) {
                if (!$test($pattern)) {
                    continue;
                }

                unset($patterns[$key]);
                $this->patternDigits[$pattern] = $digit;
                $this->digitPatterns[$digit] = $pattern;

                break;
            }
        }
    }
}
