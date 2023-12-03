<?php

namespace trizz\AdventOfCode\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TestDay extends AbstractDayCommand
{
    #[\Override]
    protected function configure(): void
    {
        parent::configure();
        $this
            ->setName('test')
            ->setDescription('Test day');
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $results = $this->getSolutions();
        $solution = $this->loadClass();

        if (in_array($this->part, [0, 1], true)) {
            $output->writeln('<fg=bright-green>Part 1</>');
            $this->render($output, 'Example', $solution::$part1ExampleResult, $results['part1Example']);
            $this->render($output, 'Puzzle', $solution::$part1Result, $results['part1']);
        }

        if ($this->part === 0) {
            $output->writeln(str_repeat('-', strlen($this->title)));
        }

        if (in_array($this->part, [0, 2], true)) {
            $output->writeln('<fg=bright-green>Part 2</>');
            $this->render($output, 'Example', $solution::$part2ExampleResult, $results['part2Example']);
            $this->render($output, 'Puzzle', $solution::$part2Result, $results['part2']);
        }

        return Command::SUCCESS;
    }

    private function render(OutputInterface $output, string $title, null|int|string $expected, null|int|string $result): void
    {
        if ($title === 'Example' && $this->skipExamples) {
            return;
        }

        $color = $expected === $result ? 'green' : 'red';
        $output->writeln(sprintf('  <fg=blue>%s:</>', $title));
        $output->writeln(sprintf('    <fg=%s>Expected: </> <comment>%s</comment>', $color, $expected));
        $output->writeln(sprintf('    <fg=%s>Result:   </> <comment>%s</comment>', $color, $result));
    }
}
