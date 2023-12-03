<?php

namespace trizz\AdventOfCode\Commands;

use PhpPkg\CliMarkdown\CliMarkdown;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Puzzle extends Command
{
    #[\Override]
    protected function configure(): void
    {
        $this
            ->setName('puzzle')
            ->setDescription('Show the puzzle description.')
            ->addArgument('day', InputArgument::REQUIRED, 'The day number.')
            ->addArgument('year', InputArgument::OPTIONAL, 'The year', date('y'));
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contents = file_get_contents(
            sprintf(
                '%s/../../data/Y%d/day%s/puzzle.md',
                __DIR__,
                $input->getArgument('year'),
                (int) $input->getArgument('day')
            )
        );

        if (!$contents) {
            $output->writeln('Can not read puzzle.');

            return Command::FAILURE;
        }

        $rendered = (new CliMarkdown())->render($contents);

        $output->writeln($rendered);

        return Command::SUCCESS;
    }
}
