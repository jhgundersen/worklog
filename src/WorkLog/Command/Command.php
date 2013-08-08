<?php
namespace WorkLog\Command;

use WorkLog\Logger;

abstract class Command extends \Symfony\Component\Console\Command\Command{

	protected $logger;

	public function __construct(Logger $logger){
		$this->logger = $logger;

		parent::__construct();
	}
}