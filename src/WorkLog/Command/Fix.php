<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Fix extends Command{


	protected function configure(){
		$this
			->setName('fix')
			->setDescription('Remove all entries with an end')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$this->logger->fix();
		$output->writeln('Removed all entries without an end');
	}
}