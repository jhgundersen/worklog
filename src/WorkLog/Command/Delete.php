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
			->addArgument(
				'id',
				InputArgument::OPTIONAL,
				'Delete a single entry only'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$id = $input->getArgument('id');
		$dialog = $this->getHelperSet()->get('dialog');

		if($id){
			$id = new \MongoId($id);
			$this->logger->showById($id);

			if ($dialog->askConfirmation($output, '<question>Are you sure you want to delete this entry? (yes/no)</question> ', false)) {
				$this->logger->delete($id);
			}
		}

		else {
			if ($dialog->askConfirmation($output, '<question>Are you sure you want to delete all entries? (yes/no)</question> ', false)) {
				$this->logger->delete();
			}
		}
	}
}