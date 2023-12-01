<?php

namespace trizz\AdventOfCode;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ExecuteDay extends Command
{
    private int $day;

    private int $year;

    private string $title;

    #[\Override]
    protected function configure(): void
    {
        $this
            ->setName('day')
            ->setDescription('Run day')
            ->addArgument('day', InputArgument::REQUIRED, 'The day number')
            ->addArgument('year', InputArgument::OPTIONAL, 'The year', date('y'));
    }

    #[\Override]
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->day = $input->getArgument('day');
        $this->year = $input->getArgument('year');

        $this->title = sprintf("Advent of Code '%d - Day %d", $this->year, $this->day);

        $output->writeln('');
        $output->writeln($this->title);
        $output->writeln(str_repeat('-', strlen($this->title)));
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $className = sprintf('%s\\Y%d\\Day%d', __NAMESPACE__, $this->year, $this->day);

        /** @var Solution $class */
        $class = new $className();
        $class->loadData();

        // Solve the examples if available.
        $resultPart1Example = 'n/a';
        $resultPart2Example = 'n/a';
        if ($class->hasExampleData()) {
            ['part1' => $resultPart1Example, 'part2' => $resultPart2Example] = $class->results(useExampleData: true);
        }

        // Solve the real puzzle if available.
        $resultPart1 = 'n/a';
        $resultPart2 = 'n/a';
        if ($class->hasData()) {
            ['part1' => $resultPart1, 'part2' => $resultPart2] = $class->results(useExampleData: false);
        }

        // Output all the results.
        $output->writeln('<fg=bright-green>Part 1</>');
        $output->writeln(sprintf('<fg=blue>Example:</> <comment>%s</comment>', $resultPart1Example));
        $output->writeln(sprintf('<fg=blue>Result: </> <comment>%s</comment>', $resultPart1));
        $output->writeln(str_repeat('-', strlen($this->title)));
        $output->writeln('<fg=bright-green>Part 2</>');
        $output->writeln(sprintf('<fg=blue>Example:</> <comment>%s</comment>', $resultPart2Example));
        $output->writeln(sprintf('<fg=blue>Result: </> <comment>%s</comment>', $resultPart2));

        return Command::SUCCESS;
    }
}
