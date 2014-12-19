<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Holiday extends Command{

	protected function configure(){
		$this
			->setName('holiday')
			->setDescription('Register a holiday')
			->addArgument(
				'time',
				InputArgument::OPTIONAL,
				'Day to add as a holiday',
				'now'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$time = $input->getArgument('time');
		$start = new \DateTime($time);
		$start->modify('08:00');
		$end = clone $start;
		$end->modify('+450 min');

		$this->logger->add($start->getTimestamp(), $end->getTimestamp(), 'FERIE', true);
		$this->logger->summary();
	}
}