<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Export extends Command{

	protected function configure(){
		$this
			->setName('export')
			->setDescription('Export entries as csv')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$this->logger->export();
	}
}