<?php

namespace trizz\AdventOfCode\Y23;

use trizz\AdventOfCode\Solution;

final class Day2 extends Solution
{
    public static null|int|string $part1ExampleResult = 8;

    public static null|int|string $part1Result = 2810;

    public static null|int|string $part2ExampleResult = 2286;

    public static null|int|string $part2Result = 69110;

    /**
     * @var array<string, array<string, int>>
     */
    private static array $colorData = [
        'red' => ['max' => 12],
        'green' => ['max' => 13],
        'blue' => ['max' => 14],
    ];

    #[\Override]
    public function part1(array $data): int
    {
        $score = 0;
        foreach ($data as $line) {
            [$gameId, $hands] = $this->getHand($line);
            $validGame = true;
            foreach ($hands as $hand) {
                if ($this->isValidHand($hand)) {
                    continue;
                }

                $validGame = false;
            }

            if ($validGame) {
                $score += (int) $gameId;
            }
        }

        return (int) $score;
    }

    #[\Override]
    public function part2(array $data): int
    {
        $score = 0;
        foreach ($data as $line) {
            [$gameId, $hands] = $this->getHand($line);
            $handData = ['red' => 0, 'green' => 0, 'blue' => 0];
            foreach ($hands as $hand) {
                $colorsInHand = $this->extractColors($hand);
                foreach ($handData as $color => $value) {
                    if (($colorsInHand[$color] ?? 0) > $value) {
                        $handData[$color] = $colorsInHand[$color];
                    }
                }
            }

            $score += array_product($handData);
        }

        return (int) $score;
    }

    /**
     * @return array<int, array<int, string>>
     */
    private function getHand(string $line): array
    {
        [$gameId, $gameData] = explode(':', $line, 2);
        [$_, $gameId] = explode(' ', $gameId);

        $hands = explode(';', $gameData);

        return [$gameId, $hands];
    }

    /**
     * @return array<string, int>
     */
    private function extractColors(string $hand): array
    {
        $colors = [];
        foreach (explode(',', $hand) as $part) {
            [$number, $color] = explode(' ', trim($part));
            $colors[$color] = (int) $number;
        }

        return $colors;
    }

    private function isValidHand(string $hand): bool
    {
        $lineData = ['red' => 0, 'green' => 0, 'blue' => 0];
        foreach (explode(',', $hand) as $part) {
            [$number, $color] = explode(' ', trim($part));
            $lineData[$color] += (int) $number;
        }

        return !($lineData['red'] > self::$colorData['red']['max'] || $lineData['green'] > self::$colorData['green']['max'] || $lineData['blue'] > self::$colorData['blue']['max']);
    }
}
