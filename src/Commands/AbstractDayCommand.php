<?php

namespace trizz\AdventOfCode\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use trizz\AdventOfCode\Solution;

abstract class AbstractDayCommand extends Command
{
    protected int $day;

    protected int $year;

    protected string $title;

    protected bool $skipExamples;

    protected int $part;

    #[\Override]
    protected function configure(): void
    {
        $this
            ->addArgument('day', InputArgument::REQUIRED, 'The day number')
            ->addArgument('year', InputArgument::OPTIONAL, 'The year', date('y'))
            ->addOption('one', '1', null, 'Run only part 1')
            ->addOption('two', '2', null, 'Run only part 2')
            ->addOption('skip-example', 's', null, 'Skip the example data');
    }

    #[\Override]
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->day = $input->getArgument('day');
        $this->year = $input->getArgument('year');

        $this->title = sprintf("Advent of Code '%d - Day %d", $this->year, $this->day);
        $this->skipExamples = $input->getOption('skip-example');
        $this->part = $input->getOption('one') ? 1 : ($input->getOption('two') ? 2 : 0);

        $output->writeln('');
        $output->writeln($this->title);
        $output->writeln(str_repeat('-', strlen($this->title)));
    }

    /**
     * @return array<string, int|string>
     */
    protected function getSolutions(): array
    {
        $solution = $this->loadClass();

        // Solve the examples if available.
        $resultPart1Example = 'n/a';
        $resultPart2Example = 'n/a';
        if (!$this->skipExamples && $solution->hasExampleData()) {
            ['part1' => $resultPart1Example, 'part2' => $resultPart2Example] = $solution->results(useExampleData: true, part: $this->part);
        }

        // Solve the real puzzle if available.
        $resultPart1 = 'n/a';
        $resultPart2 = 'n/a';
        if ($solution->hasData()) {
            ['part1' => $resultPart1, 'part2' => $resultPart2] = $solution->results(useExampleData: false, part: $this->part);
        }

        return [
            'part1' => $resultPart1,
            'part2' => $resultPart2,
            'part1Example' => $resultPart1Example,
            'part2Example' => $resultPart2Example,
        ];
    }

    protected function loadClass(): Solution
    {
        require_once sprintf('%s/Y%d/day%d/Day%d.php', DATA_DIR, $this->year, $this->day, $this->day);
        $className = sprintf('%s\Y%d\Day%d', substr(__NAMESPACE__, 0, -9), $this->year, $this->day);

        /** @var Solution $class */
        $class = new $className();
        $class->loadData();

        return $class;
    }
}
