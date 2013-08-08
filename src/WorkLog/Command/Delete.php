<?php
namespace WorkLog\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Delete extends Command{

	protected function configure(){
		$this
			->setName('delete')
			->setDescription('Delete all entries')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$dialog = $this->getHelperSet()->get('dialog');

		if($dialog->askConfirmation($output, '<question>Are you sure you want to delete all entries?</question>', false)){
			$this->logger->delete();
		}
	}
}