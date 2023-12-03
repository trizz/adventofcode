<?php

namespace trizz\AdventOfCode\Y23;

use trizz\AdventOfCode\Solution;

final class Day1 extends Solution
{
    /**
     * @var array<string,int>
     */
    private const array NUMBER_STRING = [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9,
    ];

    public static null|int|string $part1ExampleResult = 142;

    public static null|int|string $part1Result = 53974;

    public static null|int|string $part2ExampleResult = 281;

    public static null|int|string $part2Result = 52840;

    #[\Override]
    public function part1(array $data): int
    {
        $total = 0;

        foreach ($data as $line) {
            $total += $this->extractNumbersFromLine($line);
        }

        return $total;
    }

    #[\Override]
    public function part2(array $data): int
    {
        $total = 0;

        foreach ($data as $line) {
            $total += $this->extractNumbersFromLineWithText($line);
        }

        return $total;
    }

    private function extractNumbersFromLine(string $line): int
    {
        preg_match_all('#\d#', $line, $numbers);

        if (empty($numbers[0])) {
            return 0;
        }

        $first = $numbers[0][0];
        $last = $numbers[0][array_key_last($numbers[0])];

        return (int) ($first.$last);
    }

    private function extractNumbersFromLineWithText(string $line): int
    {
        preg_match_all('#\d|'.implode('|', array_keys(self::NUMBER_STRING)).'#', $line, $numbersStart);

        // Same regex, but match everything in reverse, so the last is the first.
        $keys = implode('|', array_map(static fn (string $k): string => '('.strrev($k).')', array_keys(self::NUMBER_STRING)));
        preg_match_all('#\d|'.$keys.'#', strrev($line), $numbersEnd);

        $first = $numbersStart[0][0];
        $last = strrev((string) $numbersEnd[0][0]);

        if (!ctype_digit((string) $first)) {
            $first = self::NUMBER_STRING[$first];
        }

        if (!ctype_digit($last)) {
            $last = self::NUMBER_STRING[$last];
        }

        return (int) ($first.$last);
    }
}
