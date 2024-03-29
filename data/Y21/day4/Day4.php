<?php

namespace trizz\AdventOfCode\Y21;

use trizz\AdventOfCode\Solution;

final class Day4 extends Solution
{
    public static null|int|string $part1ExampleResult = 4512;

    public static null|int|string $part1Result = 60368;

    public static null|int|string $part2ExampleResult = 1924;

    public static null|int|string $part2Result = 17435;

    #[\Override]
    public function part1(array $data): int|string
    {
        return $this->playBingo($data, firstWins: true);
    }

    #[\Override]
    public function part2(array $data): int|string
    {
        return $this->playBingo($data, firstWins: false);
    }

    /**
     * @param int[] $winningCard
     *
     * @psalm-param array<int, array<array-key, bool|int>|string> $winningCard
     */
    private function calculateScore(array $winningCard, int $number): int
    {
        $return = [];
        array_walk_recursive($winningCard, static function (bool $value, int $key) use (&$return): void {
            $return[$key] = $value;
        });
        $unusedNumbers = array_keys(array_filter($return, static fn (bool $value): bool => !$value));

        return (int) array_sum($unusedNumbers) * $number;
    }

    /**
     * @param non-empty-string $separator
     *
     * @return int[]
     *
     * @psalm-return array<int, int>
     */
    private function explodeNumbers(string $numberList, string $separator): array
    {
        return array_map(
            static fn ($value): int => (int) $value,
            array_filter(
                explode($separator, $numberList),
                static fn (string $value): bool => $value !== ''
            )
        );
    }

    /**
     * @param string[] $data
     */
    private function playBingo(array $data, bool $firstWins = true): int|string
    {
        $numbers = $this->explodeNumbers(array_shift($data) ?? '', ',');
        $cards = $this->setupCards($data);
        $finishedCards = [];

        // Call the numbers.
        foreach ($numbers as $number) {
            /**
             * @var int   $cardIndex
             * @var int[] $cardRows
             */
            foreach ($cards as $cardIndex => $cardRows) {
                if (isset($finishedCards[$cardIndex])) {
                    continue;
                }

                /**
                 * @var int   $cardRowIndex
                 * @var int[] $cardRow
                 */
                foreach ($cardRows as $cardRowIndex => $cardRow) {
                    if (isset($cardRow[$number])) {
                        $cards[$cardIndex][$cardRowIndex][$number] = true;
                    }
                }
            }

            $winningCards = $this->checkCards($cards, $finishedCards);
            if ($winningCards === []) {
                continue;
            }

            foreach ($winningCards as $winningCard) {
                $lastWinningCard = $cards[$winningCard];
                $lastWinNumber = $number;
                $finishedCards[$winningCard] = true;

                if ($firstWins) {
                    return $this->calculateScore($lastWinningCard, $number);
                }
            }
        }

        if (isset($lastWinningCard, $lastWinNumber)) {
            return $this->calculateScore($lastWinningCard, $lastWinNumber);
        }

        return 'Computer says no...';
    }

    /**
     * @param string[] $data
     *
     * @return ((false|int)[]|string)[][]
     *
     * @psalm-return array<int, array<int, array<false|int>|string>>
     */
    private function setupCards(array $data): array
    {
        $cards = array_chunk($data, 5);
        foreach ($cards as $card => $rows) {
            $cards[$card] = array_map(fn ($value): array => $this->explodeNumbers($value, ' '), $rows);

            foreach ($cards[$card] as $row => $number) {
                $cards[$card][$row] = array_fill_keys(array_values($number), false);
            }
        }

        return $cards;
    }

    /**
     * @return int[]
     *
     * @psalm-return list<int>
     */
    private function checkCards(array $cards, array $finishedCards): array
    {
        $winningCards = [];

        // Check rows
        /**
         * @var int   $cardIndex
         * @var int[] $rows
         */
        foreach ($cards as $cardIndex => $rows) {
            if (isset($finishedCards[$cardIndex])) {
                continue;
            }

            /** @var int[] $row */
            foreach ($rows as $row) {
                if ($this->arrayHasSingleValue($row, true)) {
                    $winningCards[] = $cardIndex;
                }
            }

            // Get the vertical numbers.
            $colValues = [];
            for ($rowIndex = 0; $rowIndex < 5; ++$rowIndex) {
                for ($colIndex = 0; $colIndex < 5; ++$colIndex) {
                    if (!isset($colValues[$colIndex])) {
                        $colValues[$colIndex] = [];
                    }

                    $colValues[$colIndex] += array_slice((array) $rows[$rowIndex], $colIndex, 1, preserve_keys: true);
                }
            }

            // See if there's a bingo on the vertical numbers.
            foreach ($colValues as $colIndex => $colValue) {
                if ($this->arrayHasSingleValue($colValue, true)) {
                    $winningCards[] = $cardIndex;
                }
            }
        }

        return $winningCards;
    }

    private function arrayHasSingleValue(array $array, bool $value): bool
    {
        return count(array_unique($array)) === 1 && end($array) === $value;
    }
}
