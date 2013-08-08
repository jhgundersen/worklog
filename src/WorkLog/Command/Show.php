<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Show extends Command{

	protected function configure(){
		$this
			->setName('show')
			->setDescription('Show all entries')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$this->logger->show();
	}
}