<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Summary extends Command{

	protected function configure(){
		$this
			->setName('summary')
			->setDescription('Show summary of all entries')
		;
		
		$this->addOption('end', null, InputOption::VALUE_REQUIRED, "End date for summary");
		$this->addOption('start', null, InputOption::VALUE_REQUIRED, "Start date for summary");
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$this->logger->extended_summary($input->getOption('start'), $input->getOption('end'));
		$output->writeln("");
		$this->logger->summary();
	}
}
