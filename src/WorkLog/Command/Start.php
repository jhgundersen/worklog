<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Start extends Command{

	protected function configure(){
		$this
			->setName('start')
			->setDescription('Start a new task')
			->addArgument(
				'time',
				InputArgument::OPTIONAL,
				'Time to start the task',
				'now'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$time = strtotime($input->getArgument('time'));

		$output->writeln('Task started at ');
		$this->logger->start($time);
	}
}