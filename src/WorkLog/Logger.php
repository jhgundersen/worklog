<?php
namespace WorkLog;

class Logger {

	const PERCENTAGE_OF_FULL_TIME_POSITION = 0.8;

	protected $collection;

	public function __construct($db = 'iz', $collection = 'worklog'){
		$mongo = new \MongoClient("mongodb://localhost:27017");
		$db = $mongo->selectDB($db);
		$this->collection = $db->selectCollection($collection);
	}

	public function start($time){
		$mongo_date = new \MongoDate($time ?: time());

		$this->collection->insert($entry = array(
			'start' 	=> $mongo_date,
			'message' 	=> '',
			'end' 		=> null,
			'holiday'   => false
		));

		$this->showById($entry['_id']);
	}

	public function end($time, $message){
		$mongo_date = new \MongoDate($time ?: time());

		$this->collection->update(
			array('end' => null),
			array('$set' => array(
				'message' => $message,
				'end' => $mongo_date)));

		$this->showEntry($this->collection->findOne(array('end' => $mongo_date)));
	}

	public function add($start, $end, $message, $holiday = false){
		$mongo_start_date = new \MongoDate($start);
		$mongo_end_date = new \MongoDate($end);

		$this->collection->insert($entry = array(
			'start' 	=> $mongo_start_date,
			'message' 	=> $message,
			'end' 		=> $mongo_end_date,
			'holiday'   => $holiday
		));

		$this->showById($entry['_id']);
	}

	public function showById($id){
		$this->showEntry($this->collection->findOne(array('_id' => $id)));
	}


	public function show(){
		foreach($this->collection->find()->sort(array('start' => 1)) as $entry){
			$this->showEntry($entry);
		}
	}

	public function export(){
		foreach($this->collection->find()->sort(array('start' => 1)) as $entry){
			$start = $entry['start'] ? $entry['start']->sec : 0;
			$end = $entry['end'] ? $entry['end']->sec : 0;

			if($end){
				echo implode(";", array(date('d.m.Y', $start), date('H:i', $start), date('H:i', $end), isset($entry['project']) ? $entry['project'] : '', $entry['message']));
				echo "\n";
			}
		}
	}

	public function summary(){
		$monday = new \DateTime('Monday this week');
		$start = new \MongoDate($monday->getTimestamp());
		$seconds_at_work = 0;

		foreach($this->collection->find(array('start' => array('$gt' => $start))) as $entry){
			if($entry['end'] && !$entry['holiday']){
				$seconds_at_work += ($entry['end']->sec - $entry['start']->sec);
			}
		}

		$hours = round($seconds_at_work / 3600, 2);

		$now = new \DateTime('tomorrow');
		$expected_hours = min(5, $now->diff($monday)->format('%d')) * 7.5 * self::PERCENTAGE_OF_FULL_TIME_POSITION;

		echo "Hours at work this week: ", $this->showHours($hours), "\n",
		"Expected hours at this moment: ", $expected_hours, "\n",
		"Difference: ", $this->showHours($hours - $expected_hours), "\n";

	}

	public function extended_summary(){
		$weeks = array();

		foreach($this->collection->find()->sort(array('start' => 1)) as $entry){
			if($entry['end'] && !$entry['holiday']){
				$week = strftime("%W", $entry['end']->sec);
				$day = strftime("%u", $entry['end']->sec);

				@$weeks[$week]['seconds'] += $entry['end']->sec - $entry['start']->sec;
				@$weeks[$week]['days'][$day] = 1;
			}
		}

		$total_diff = 0;
		echo "-----------------------------\n",
		"Total summary:\n";

		foreach($weeks as $week => $data){
			$days = min(5, count($data['days']));
			$seconds = $data['seconds'];
			$expected_hours = $days * 7.5 * self::PERCENTAGE_OF_FULL_TIME_POSITION;
			$hours = round($seconds / 3600, 2);
			$total_diff += $diff = $hours - $expected_hours;

			echo "Work in week ", $week, ": ", $days, " days and ", $this->showHours($hours), "\t| ", $this->showHours($diff), "\n";
		}

		$paid_overtime = 32.5;

		echo "-----------------------------\n";
		echo "  Total number of hours: ", $this->showHours($total_diff), "\n";
		echo "- Hours that has been compensated (paid): ", $this->showHours($paid_overtime), "\n";
		echo "= Hours to be compensated: ", $this->showHours($total_diff - $paid_overtime), "\n";
	}

	protected function showHours($time){
		$negative = $time < 0;
		$hours = intval($time);
		$time -= $hours;
		$time *= 60;

		$minutes = intval($time);
		$time -= $minutes;
		$time *= 60;

		$seconds = intval($time);

		return ($negative ? '-' : '').abs($hours)."h:".abs($minutes)."m:".abs($seconds) . "s";
	}

	public function delete($id = null){
		if($id){
			$this->collection->remove(array('_id' => $id));
		}
		else {
			$this->collection->remove();
		}
	}

	public function undo(){
		$entry = $this->collection->find()->limit(1)->sort(array('start' => -1))->getNext();

		if($entry){
			$this->collection->remove(array('_id' => $entry['_id']));
			$this->showEntry($entry);
		}
	}

	public function fix(){
		$this->collection->remove(array('end' => null));
	}

	protected function showEntry($entry){
		$start = $entry['start'] ? $entry['start']->sec : 0;
		$end = $entry['end'] ? $entry['end']->sec : 0;

		$start_day = date('d.m.Y', $start);
		$start_time = date('H:i', $start);
		$end_time = date('H:i', $end);

		echo $entry['_id'], " ", $start_day, " - kl ", $start_time;

		if($end){
			echo "-", $end_time, ": ", $entry['message'];
		}

		echo "\n";
	}
}