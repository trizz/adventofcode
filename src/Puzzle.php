<?php

namespace trizz\AdventOfCode;

use trizz\AdventOfCode\Utils\SymfonyConsoleMarkdown;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('puzzle')
            ->addArgument('day', InputArgument::REQUIRED, 'The day number.')
            ->addArgument('year', InputArgument::OPTIONAL, 'The year', date('y'));
    }

    /**
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contents = file_get_contents(
            sprintf(
                '%s/../data/Y%d/day%s/puzzle.md',
                __DIR__,
                $input->getArgument('year'),
                (int) $input->getArgument('day')
            )
        );
        $rendered = (new SymfonyConsoleMarkdown())->render($contents);

        $output->writeln($rendered);

        return Command::SUCCESS;
    }
}
