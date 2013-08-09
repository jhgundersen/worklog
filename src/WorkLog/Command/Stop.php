<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Stop extends Command{

	protected function configure(){
		$this
			->setName('stop')
			->setDescription('Stop current task')
			->addArgument(
				'time',
				InputArgument::OPTIONAL,
				'Time to stop the task',
				'now'
			)
			->addArgument(
				'description',
				InputArgument::IS_ARRAY,
				'Description of task'
			)

		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$input_time = $input->getArgument('time');
		$description = $input->getArgument('description');

		$time = strtotime($input->getArgument('time'));

		if(!$time){
			$time = time();
			array_unshift($description, $input_time);
		}

		$this->logger->end($time, implode(" ", $description));
		$this->logger->summary();
	}
}