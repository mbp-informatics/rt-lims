<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Schedule Model
 */
class Schedule extends Entity {

	public $useTable = false;
	
	public function generateFeed($start, $end, $projectId = null) {	
		$ProjectProcedure = ClassRegistry::init('ProjectProcedure');
		$ProjectGroupMice = ClassRegistry::init('ProjectGroupsMouse');
		$ProjectProcedure->contain(array('ProcedureVersion.Procedure.Color', 'ProjectGroup','ProcedureVersion.Procedure.ProcedureSchedule.all_day', 'User', 'Room', 'Project'));
		
		$options = array(
			'conditions' => array(
				'ProjectProcedure.scheduled >=' => CakeTime::toServer($start - WEEK),
				'ProjectProcedure.scheduled <=' => CakeTime::toServer($end),
				'ProjectProcedure.project_procedure_state_id !=' => '10',
			
			),
		);
		// Add the project ID clause (if one was provided)
		if($projectId) {
			$options['conditions']['ProjectProcedure.project_id'] = $projectId; 
			
		}
		$events = $ProjectProcedure->find('all', $options);
		$data = array();
		foreach($events as $event) {
			//remove out of life procedures from schedule display
			if (preg_match('/Hematology|Histopath|Embedding|Heart|Blood/',$event['ProjectProcedure']['name'])) {
				continue;
			}
			$date = new DateTime($event['ProjectProcedure']['scheduled']);
			$duration = $event['ProcedureVersion']['estimated_time'];
			if(!empty($event['ProjectProcedure']['duration'])) {
				// Override procedure duration
				$duration = $event['ProjectProcedure']['duration'];
			}
			$assigned = "";
			if(!empty($event['User'])) {
				foreach($event['User'] as $user) {
					$assigned = $assigned . $user['full_name'] . ', ';
				}
				$assigned = substr($assigned, 0, -2);
			}
			$room = "";
			if(!empty($event['Room'])) {
				$room = sprintf("%s (Room %s)", $event['Room']['description'], $event['Room']['number']);
			}
			$date->add(new DateInterval(sprintf("PT%dM", $duration)));
			$end = $date->format('Y-m-d H:i:s');
			
			$groupId = $event['ProjectProcedure']['project_group_id'];
			//$this->Schedule->loadModel('ProjectGroup');
			$mi = $ProjectGroupMice->find('count', array(
       					'conditions' => array('project_group_id' => $groupId)
   				 ));
			
			$data[] = array(
				'id' => $event['ProjectProcedure']['id'],
				'title'=>$event['ProjectProcedure']['name'],
				'start'=>$event['ProjectProcedure']['scheduled'],
				'end' => $end,
				'assigned' => $assigned,
				'mice' =>$mi,
				'room' => $room,
				'project' => $event['Project']['name'],
				'allDay' => $event['ProcedureVersion']['Procedure']['ProcedureSchedule']['all_day'] ? true : false,
				'link' => Router::url(array('controller' => 'project_procedures', 'action' => 'view', $event['ProjectProcedure']['id'])),
				'backgroundColor' => $event['ProcedureVersion']['Procedure']['Color']['background_color'],
				'borderColor' => $event['ProcedureVersion']['Procedure']['Color']['background_color'],
				'textColor' => $event['ProcedureVersion']['Procedure']['Color']['text_color'],
			);
		}
		return $data;
	}
}
