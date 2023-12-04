<?php

namespace trizz\AdventOfCode\Y23;

final class Day4 extends \trizz\AdventOfCode\Solution
{
    public static null|int|string $part1ExampleResult = 13;

    public static null|int|string $part1Result = 24733;

    public static null|int|string $part2ExampleResult = 30;

    public static null|int|string $part2Result = 5_422_730;

    private mixed $scoringNumbersPerCard;

    private int $totalCards;

    private mixed $numberOfCards;

    #[\Override]
    public function part1(array $data): int
    {
        $score = 0;
        foreach ($data as $line) {
            [$winningNumbers, $cardNumbers] = $this->parseInput($line);
            $scoringNumbers = array_intersect($winningNumbers, $cardNumbers);

            if ($scoringNumbers === []) {
                continue;
            }

            $cardScore = 1;
            for ($i = 0; $i < count($scoringNumbers) - 1; ++$i) {
                $cardScore *= 2;
            }

            $score += $cardScore;
        }

        return $score;
    }

    #[\Override]
    public function part2(array $data): int
    {
        $this->totalCards = count($data);
        foreach ($data as $card => $line) {
            [$winningNumbers, $cardNumbers] = $this->parseInput($line);
            $scoringNumbers = array_intersect($winningNumbers, $cardNumbers);
            $this->scoringNumbersPerCard[$card] = count($scoringNumbers);
            $this->numberOfCards[$card] = 1;
        }

        // Start the recursive loop with the first card.
        $this->updateCount(0);

        return array_sum($this->numberOfCards);
    }

    public function updateCount(int $card): void
    {
        $cardCount = $this->numberOfCards[$card] ?? 0;
        for ($i = 0; $i < $cardCount; ++$i) {
            $winningNumbers = $this->scoringNumbersPerCard[$card] ?? 0;
            for ($number = 1; $number <= $winningNumbers; ++$number) {
                ++$this->numberOfCards[$card + $number];
            }
        }

        if ($card <= $this->totalCards) {
            $this->updateCount($card + 1);
        }
    }

    /**
     * @return array<int, array<int>>
     */
    public function parseInput(string $input): array
    {
        $numbers = explode(':', $input)[1];
        [$winningNumbers, $cardNumbers] = explode('|', $numbers, 2);

        $winningNumbers = array_map('intval', array_filter(explode(' ', $winningNumbers)));
        $cardNumbers = array_map('intval', array_filter(explode(' ', $cardNumbers)));

        return [$winningNumbers, $cardNumbers];
    }
}
