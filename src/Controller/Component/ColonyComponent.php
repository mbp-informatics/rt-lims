<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class ColonyComponent extends Component
{

	public function __construct($id = false, $table = null, $ds = null) {
	    parent::__construct($id, $table, $ds);
        $this->conn = ConnectionManager::get('default');
}

    public function getName($projectId=null, $injectionId=null) {
        if (!$projectId && !$injectionId) {
            throw new \Exception('ColonyComponent::getName() requires at least 1 parameter');
        }

        if ($projectId && !$injectionId) {
            $whereSql = 'WHERE project_id = :project_id';
            $boundParams = ['project_id' => $projectId];
        }

        if ($injectionId && !$projectId) {
            $whereSql = 'WHERE injection_id = :injection_id';
            $boundParams = ['injection_id' => $injectionId];
        }

        if ($injectionId && $projectId) {
            $whereSql = 'WHERE injection_id = :injection_id AND WHERE project_id = :project_id';
            $boundParams = ['injection_id' => $injectionId, 'project_id' => $projectId];   
        }

        $res = $this->conn
            ->execute(
                "SELECT name from colonies {$whereSql}",
                $boundParams
                )->fetchAll('assoc');

        if (count($res) === 1) { return $res[0]['name']; }

        $names = [];
        foreach ($res as $entry) {
            $names[] = $entry['name'];
        }
        return implode('|', $names);
    }
   
}