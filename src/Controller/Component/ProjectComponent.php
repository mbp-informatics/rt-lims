<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class ProjectComponent extends Component
{
	protected $projects;
	protected $genes;
	protected $mutations;
    protected $conn;

	public function __construct($id = false, $table = null, $ds = null) {
	    parent::__construct($id, $table, $ds);
        $this->conn = ConnectionManager::get('default');
}

    public function getName($projectId) {
        $res = $this->conn
            ->execute('
                SELECT
                    p.id as project_id,
                    p.custom_name as custom_name,
                    pname.marker_symbol,
                    pname.marker_synonyms,
                    p.mutation_id,
                    m.type AS mutation_type
                FROM
                    projects AS p
                LEFT JOIN (
                    SELECT
                        pg.project_id,
                        mgd.marker_symbol,
                        mgd.marker_synonyms
                    FROM
                        mgi_genes_dump AS mgd
                    LEFT JOIN projects_genes AS pg ON pg.mgi_accession_id = mgd.mgi_accession_id
                    LEFT JOIN projects AS p ON p.id = pg.project_id
                    WHERE
                        pg.project_id = :id
                ) AS pname ON pname.project_id = p.id
                LEFT JOIN mutations AS m ON p.mutation_id = m.id
                WHERE
                    p.id = :id',
                ['id' => $projectId])->fetchAll('assoc');

        //Custom project name present, so let's serve it
        if (isset($res[0]['custom_name']) && !empty($res[0]['custom_name'])) {
            return $res[0]['custom_name'];
        }

        //Regular project name pattern
        $projectId = isset($res[0]['project_id']) ? $res[0]['project_id'] : null;
        $mutationType = isset($res[0]['mutation_type']) ? $res[0]['mutation_type'] : null;
        if (!empty($res[0]['marker_symbol'])) {
            $projectName = $projectId.'_' . $mutationType.'_';
            foreach ($res as $gene) {
                if (!empty($gene['marker_symbol'])) {
                    if (!empty($gene['marker_synonyms'])) {
                        $projectName .= "{$gene['marker_symbol']}({$gene['marker_synonyms']})_" ;
                    } else {
                        $projectName .= "{$gene['marker_symbol']}_";
                    }
                }
            }
        } else {
            $projectName = $projectId.'_' . $mutationType;
        }
        $projectName = rtrim($projectName, '_'); 
        return str_replace('_unspecified_', '_', $projectName);
    }
    /**
     * This method saves the project and if successful, populates projects_genes
     * join table with mgi_accession_id (projects<->genes are many-to-many)
     */
    public function saveProject($projectData) {
        $projectData = (array) $projectData;
        
        //convert empty string to null  - don't want to store (str) '' in the db
        foreach ($projectData as &$row) {
            $row = empty($row) ? null : $row;
        }
        unset($row);
        
        $projectsTable = TableRegistry::get('Projects');
        $project = $projectsTable->newEntity($projectData);
        $project = $projectsTable->patchEntity($project, $projectData);

        $res = $projectsTable->save($project);
        if (!isset($res->id)) { return false; }//save failed, abort

        if (!empty($projectData['mgi_accession_ids'])) {
            $projectsGenesTable = TableRegistry::get('ProjectsGenes');
            //Save multiple genes
            foreach ($projectData['mgi_accession_ids'] as $mgi_id) {
                $projectsGenesData = [
                    'project_id' => $res->id,
                    'mgi_accession_id' => $mgi_id
                ];
                $projectsGenes = $projectsGenesTable->newEntity($projectsGenesData);
                $project = $projectsGenesTable->patchEntity($projectsGenes, $projectData);
                $projectsGenesTable->save($projectsGenes);
            }
        }
        return $res;
    }

    /**
    * This method changes a status id of a project, e.g:
    * status_id = 4 ('injected')
    */
    public function changeProjectStatus($projectId, $newStatusId) {
        $projectsTable = TableRegistry::get('Projects');
        $project = $projectsTable->get($projectId);
        $projData = (Array) $project->toArray();
        $projData['project_status_id'] = $newStatusId;
        $project = $projectsTable->patchEntity($project, $projData);
        return $projectsTable->save($project);
    }
}