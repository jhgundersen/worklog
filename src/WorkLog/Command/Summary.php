<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Summary extends Command{

	protected function configure(){
		$this
			->setName('summary')
			->setDescription('Show summary of all entries')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$this->logger->extended_summary();
		$output->writeln("");
		$this->logger->summary();
	}
}