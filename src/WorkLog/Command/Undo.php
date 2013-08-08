<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Undo extends Command{

	protected function configure(){
		$this
			->setName('undo')
			->setDescription('Remove last entry')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$this->logger->undo();
		$output->writeln('Removed last entry');
	}
}