<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CompensatoryTime extends Command{

	protected function configure(){
		$this
			->setName('compensatory')
			->setDescription('Register a compensatory day')
			->addArgument(
				'time',
				InputArgument::OPTIONAL,
				'Day to add as a compensatory day',
				'now'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$time = strtotime($input->getArgument('time'));

		$this->logger->start($time);
		$this->logger->end($time, "AVSPASERING");
		$this->logger->summary();
	}
}