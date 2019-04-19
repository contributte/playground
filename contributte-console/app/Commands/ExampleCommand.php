<?php declare(strict_types = 1);

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExampleCommand extends Command
{

	/** @var string */
	protected static $defaultName = 'app:example';

	protected function configure(): void
	{
		$this->setName(static::$defaultName);
		$this->setDescription('app:example foo --bar=bar --baz');

		$this->addArgument('foo', InputArgument::REQUIRED, 'Required input argument');
		$this->addOption('bar', 'r', InputOption::VALUE_REQUIRED, 'Option 1', false);
		$this->addOption('baz', 'z', InputOption::VALUE_OPTIONAL, 'Option 2', false);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$style = new SymfonyStyle($input, $output);

		$foo = $input->getArgument('foo');
		$style->note(sprintf('Received value %s from input argument "foo"', $foo));

		$bar = $input->getOption('bar');
		if ($bar !== false) {
			$style->note(sprintf('Option --bar called with value %s', $bar));
		}

		$baz = $input->getOption('baz');
		if ($baz !== false) {
			if ($baz === null) {
				$style->note('Option --baz called with no value.');
			} else {
				$style->note(sprintf('Option --baz called with value %s', $baz));
			}
		}

		$style->success('Command successful');
		// Command should return 0, if successful
		// Exception otherwise
		return 0;
	}

}
