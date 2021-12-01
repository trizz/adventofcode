<?php

namespace AdventOfCode21;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    /**
     * @var int The day number.
     */
    protected static int $day = -1;

    /**
     * @var string[] The data to use.
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected array $data;

    /**
     * @var string[] The example data.
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected array $exampleData;

    /**
     * @var string The title.
     */
    private string $title;

    /**
     * Configure the command.
     */
    protected function configure(): void
    {
        $this
            ->setName((string) static::$day)
            ->setDescription('Run day '.static::$day);
    }

    /**
     * Initializes the command after the input has been bound and before the input
     * is validated.
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->title = 'Advent of Code - Day '.static::$day;

        $dataFile = sprintf('%s/../data/day%d/data.txt', __DIR__, static::$day);
        $dataExampleFile = sprintf('%s/../data/day%d/example.txt', __DIR__, static::$day);

        if (file_exists($dataFile)) {
            $this->data = array_filter(explode(PHP_EOL, file_get_contents($dataFile)));
        }

        if (file_exists($dataExampleFile)) {
            $this->exampleData = array_filter(explode(PHP_EOL, file_get_contents($dataExampleFile)));
        }

        $output->writeln('');
        $output->writeln($this->title);
        $output->writeln(str_repeat('-', strlen($this->title)));
    }

    /**
     * Executes the current command.
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Solve the examples if available.
        $resultPart1Example = 'n/a';
        $resultPart2Example = 'n/a';
        if ($this->exampleData) {
            $resultPart1Example = $this->part1($this->exampleData);
            $resultPart2Example = $this->part2($this->exampleData);
        }

        // Solve the real puzzle if available.
        $resultPart1 = 'n/a';
        $resultPart2 = 'n/a';
        if ($this->data) {
            $resultPart1 = $this->part1($this->data);
            $resultPart2 = $this->part2($this->data);
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

    /**
     * Solve the given data for part one of the puzzle.
     *
     * @param array $data The data to process.
     *
     * @return int|string The result or null if not (yet?) implemented.
     */
    protected function part1(array $data): int|string
    {
        return 'n/a';
    }

    /**
     * Solve the given data for part one of the puzzle.
     *
     * @param array $data The data to process.
     *
     * @return int|string The result or null if not (yet?) implemented.
     */
    protected function part2(array $data): int|string
    {
        return 'n/a';
    }
}
