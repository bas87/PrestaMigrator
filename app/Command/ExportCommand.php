<?php

namespace App\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Table;

class ExportCommand extends Command
{

	protected function configure()
	{
		$this->setName('export');
		$this->setDescription('Export data entity from PrestaShop to CSV.');

		$this->addArgument('entity', InputArgument::REQUIRED);

		$this->addOption('host', 'H', InputOption::VALUE_REQUIRED, '');
		$this->addOption('database', 'd', InputOption::VALUE_REQUIRED, '');
		$this->addOption('user', 'u', InputOption::VALUE_REQUIRED, '');
		$this->addOption('password', 'p', InputOption::VALUE_REQUIRED, '');

		$this->addOption('output', 'o', InputOption::VALUE_OPTIONAL, '');
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$factory = new \App\Console\Model\Factory(
			$input->getOption('host'),
			$input->getOption('database'),
			$input->getOption('user'),
			$input->getOption('password'));

		switch($input->getArgument('entity')) {
			case 'category':
				$category = $factory->getCategoryModel();

				if ($input->getOption('output')) {
					$category->toCsv($input->getOption('output'));
				} else {
					$table = new Table($output);
					$table->setHeaders($category->toArray()['header'])
						->setRows($category->toArray()['rows']);
					$table->render();
				}

			break;
		}
	}

}
