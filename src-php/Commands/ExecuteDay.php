<?php

namespace trizz\AdventOfCode\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ExecuteDay extends AbstractDayCommand
{
    #[\Override]
    protected function configure(): void
    {
        parent::configure();
        $this
            ->setName('day')
            ->setDescription('Run day');
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $results = $this->getSolutions();

        // Output all the results.
        if (in_array($this->part, [0, 1], true)) {
            $output->writeln('<fg=bright-green>Part 1</>');
            $output->writeln(sprintf('  <fg=blue>Example:</> <comment>%s</comment>', $results['part1Example']));
            $output->writeln(sprintf('  <fg=blue>Result: </> <comment>%s</comment>', $results['part1']));
        }

        if ($this->part === 0) {
            $output->writeln(str_repeat('-', strlen($this->title)));
        }

        if (in_array($this->part, [0, 2], true)) {
            $output->writeln('<fg=bright-green>Part 2</>');
            $output->writeln(sprintf('  <fg=blue>Example:</> <comment>%s</comment>', $results['part2Example']));
            $output->writeln(sprintf('  <fg=blue>Result: </> <comment>%s</comment>', $results['part2']));
        }

        return Command::SUCCESS;
    }
}
