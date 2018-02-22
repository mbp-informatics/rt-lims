<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class MilestonesComponent extends Component
{
    public function saveMilestone($projectId, $milestoneId) {
        if (empty($projectId) || empty($projectId)) {
            throw new Exception("saveMilestone() method is missing arguments. Provided arguments: saveMilestone({$projectId}, {$projectId})");
        }
        $projectMilestonesTable = TableRegistry::get('ProjectMilestones');
        $projectMilestone = $projectMilestonesTable->newEntity([
            'project_id' => $projectId,
            'project_status_id' => $milestoneId
            ]);
        if ($projectMilestonesTable->save($projectMilestone)) {
        	$projectsTable = TableRegistry::get('Projects');
			$project = $projectsTable->get($projectId);
			$projectData = $project->toArray();
			$projectData['project_status_id'] = $milestoneId;
        	$patachedProject = $projectsTable->patchEntity($project, $projectData);
        	return $projectsTable->save($patachedProject);
        }
    }
}