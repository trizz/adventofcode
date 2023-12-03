<?php

namespace trizz\AdventOfCode\Commands;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use trizz\AdventOfCode\Solution;

use function Laravel\Prompts\text;

final class AddDay extends Command
{
    private string $dataDir;

    #[\Override]
    protected function configure(): void
    {
        $this
            ->setName('new')
            ->setDescription('Add a new day.')
            ->addArgument('day', InputArgument::OPTIONAL, 'The day number.')
            ->addArgument('year', InputArgument::OPTIONAL, 'The year', date('y'));
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $input->getArgument('day');
        $year = $input->getArgument('year');

        if ($day === null) {
            $day = text(
                label: 'For which day?',
                placeholder: '3',
                default: date('j'),
                required: true,
                validate: static fn ($value): ?string => is_numeric($value) && $value > 0 && $value < 26 ? null : 'Please enter a valid day number.'
            );
        }

        $example1Result = text(
            label: 'Please enter the result for example 1.',
            required: true,
            validate: static fn ($value): ?string => is_numeric($value) ? null : 'Please enter a valid number.'
        );

        // Create short year.
        $year = strlen((string) $year) === 4 ? substr((string) $year, 2) : $year;
        $this->dataDir = DATA_DIR.'/Y'.$year.'/day'.$day;
        $output->writeln(sprintf("Adding files for day %s of year '%s.", $day, $year));

        $this
            ->addDirsAndExampleFiles($year, $day)
            ->createClass($day, $year, $example1Result);

        return Command::SUCCESS;
    }

    private function createClass(string $day, string $year, string $example1Result): self
    {
        $phpNamespace = new PhpNamespace('trizz\AdventOfCode\Y'.$year);
        $classType = new ClassType('Day'.$day);

        $classType->setFinal()->setExtends(Solution::class);

        $this->createClassProperties($classType, $example1Result);
        $this->createClassMethods($classType);

        $phpNamespace->add($classType);
        $this->printClassToFile($classType, $year, $day, $phpNamespace);

        return $this;
    }

    private function addDirsAndExampleFiles(mixed $year, mixed $day): self
    {
        if (!is_dir($this->dataDir) && !mkdir($this->dataDir, recursive: true) && !is_dir($this->dataDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->dataDir));
        }

        touch($this->dataDir.'/example.txt');
        touch($this->dataDir.'/data.txt');

        return $this;
    }

    private function createClassProperties(ClassType $classType, string $example1Result): void
    {
        $properties = [
            'part1ExampleResult' => $example1Result,
            'part1Result' => null,
            'part2ExampleResult' => null,
            'part2Result' => null,
        ];

        foreach ($properties as $name => $value) {
            $classType
                ->addProperty($name, $value)
                ->setPublic()
                ->setStatic()
                ->setType('null|int|string');
        }
    }

    private function createClassMethods(ClassType $classType): void
    {
        $methods = ['part1', 'part2'];

        foreach ($methods as $method) {
            $classType
                ->addMethod($method)
                ->setReturnType('int')
                ->setBody('return -1;')
                ->addParameter('data')->setType('array');
        }
    }

    private function printClassToFile(ClassType $classType, string $year, string $day, PhpNamespace $phpNamespace): void
    {
        $printer = new Printer();
        $printer->indentation = '    ';

        $filename = $this->dataDir.'/Day'.$day.'.php';
        if (file_exists($filename)) {
            throw new \RuntimeException(sprintf('File %s already exists.', $filename));
        }

        file_put_contents($filename, '<?php'.PHP_EOL.$printer->printNamespace($phpNamespace));
    }
}
