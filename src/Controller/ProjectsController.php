<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Http\Client;
use Cake\ORM\TableRegistry;
require_once(($_SERVER['DOCUMENT_ROOT'].'/vendor/PHPExcel/Classes/PHPExcel/IOFactory.php'));

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController
{
    public $components = array('Project', 'AppErrors', 'Milestones', 'Colony'); //load the project component to acces custom getName() and saveProject() methods...

    protected $errors = array();
    protected $batchUploadId;
    protected $filePath;
    protected $fileName;
    protected $parsedSheet;
    protected $requiredHeaders = [
                "type",
                "gene_name",
                "project_status",
                "mutation",
                "phenotype",
                "comment"
                ];
    protected $pathToSave = '/webroot/uploads/project-bulk-upload/';
    protected $mutations;
    protected $phenotypes;
    protected $projectTypes;
    protected $projectStatuses;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Mutations');
        $this->loadModel('Phenotypes');
        $this->loadModel('ProjectTypes');
        $this->loadModel('ProjectStatuses');
        $this->loadModel('MgiGenesDump');

        $this->mutations = $this->Mutations->find('all')->toArray();
        $this->phenotypes = $this->Phenotypes->find('all')->toArray();
        $this->projectTypes = $this->ProjectTypes->find('all')->toArray();
        $this->projectStatuses = $this->ProjectStatuses->find('all')->toArray();
    }

    /**
     * Bulk upload methods
     *
     * @return void
     */    
    public function bulkUpload(){} //just go to bulk_upload.ctp, will add flash debug messages
    public function parseBulkUpload()
    {
        $this->autoRender = false;
        ini_set("auto_detect_line_endings", true); //to parse csv correctly 
        
        //Script logic starts
        $this
        ->saveFile();

        switch (pathinfo($this->filePath, PATHINFO_EXTENSION)) {
            case "xlsx":
            $this->parseXLS();
            break;
            case "csv":
            $this->parseCSV();
            break;
            case "tsv":
            $this->parseCSV("tsv");
            break;
            default:
            $this->showErr("Wrong filetype. Accepted filetypes: XLSX, CSV, TSV");
        }
        $this
        ->checkHeaders()    //check the structure of XLS file headers
        ->checkMutations() //check if values are present in Mutations, Phenotypes, ProjectStatuses tables
        ->checkPhenotypes()
        ->checkStatuses()
        ->saveProject();
        echo json_encode(["success" => 1]); //all OK!

    }

    private function showErr($msg)
    {
        $this->autoRender = false;
        $this->errors['errors'][] = $msg;
        echo json_encode($this->errors);
        exit;
    }

    private function saveFile()
    {   
        $this->batchUploadId = uniqid();
        $this->fileName = $this->batchUploadId . "+" . $this->request->data['file']['name'];
        $this->filePath = $_SERVER['DOCUMENT_ROOT'] . $this->pathToSave . $this->fileName;
        if (@move_uploaded_file($this->request->data['file']['tmp_name'], $this->filePath) === false) {
            $this->showErr("The file <em><strong>{$this->fileName}</strong></em> could not be uploaded to the server. Upload aborted.");
        }
        return $this;
    }

    private function parseCSV($tsv=null)
    {
        if ($tsv == "tsv") {
            $arr = array_map(function($v){return str_getcsv($v, "\t");}, file($this->filePath));
        } else {
            $arr = array_map(function($v){return str_getcsv($v, ",");}, file($this->filePath));
        }
        $this->parsedSheet = $arr;
        return $this;
    }

    private function parseXLS()
    {
        $inputFileType = \PHPExcel_IOFactory::identify($this->filePath);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($this->filePath);
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $this->parsedSheet = $sheet->rangeToArray('A1:F' . $highestRow);
        return $this;
    }

    private function checkHeaders()
    {       
        foreach ($this->parsedSheet[0] as $i=>$header) {
            if ($header !== $this->requiredHeaders[$i]) {
                $this->showErr("The file <em><strong>{$this->fileName}</strong></em> contains incorrect column headers. Upload aborted.");
            }
        }
        return $this;
    }

    private function checkMutations()
    {       
        $i = 0;
        foreach ($this->parsedSheet as $project) {
            if ($i++ == 0) { continue; } //skip first row (headers)
            $pass = false;
            foreach ($this->mutations as $mType){
                if ($mType->type == $project[3]) {
                    $pass = true;
                }
            }
            if (!$pass) {
                $this->showErr("Make sure that the mutation you're specifying in the xls file is present in <a href='/mutations'>Mutations</a> table. Upload aborted.");
            }
        }
        return $this;
    }

    private function checkPhenotypes()
    {       
        $i = 0;
        foreach ($this->parsedSheet as $project) {
            if ($i++ == 0) { continue; } //skip first row (headers)
            $pass = false;
            foreach ($this->phenotypes as $pType){
                if ($pType->type == $project[4]) {
                    $pass = true;
                }
            }
            if (!$pass) {
                $this->showErr("Make sure that the phenotype you're specifying in the xls file is present in <a href='/phenotypes'>Phenotypes</a> table. Upload aborted.");
            }
        }
        return $this;
    }

    private function checkStatuses()
    {       
        $i = 0;
        foreach ($this->parsedSheet as $project) {
            if ($i++ == 0) { continue; } //skip first row (headers)
            $pass = false;
            foreach ($this->projectStatuses as $pStat){
                if ($pStat->status == $project[2]) {
                    $pass = true;
                }
            }
            if (!$pass) {
                $this->showErr("Make sure that the project status you're specifying in the xls file is present in <a href='/project-statuses'>Project Statuses</a> table. Upload aborted.");
            }
        }
        return $this;
    }

    private function searchObjectKey($needle, $fieldName, $object) {
        foreach ($object as $row) {
            if ($row->$fieldName == $needle) {
                return $row->id;
            }
        }
        return false;
    }

    private function saveProject()
    {
        $this->autoRender = false;
        $i = 0;
        foreach ($this->parsedSheet as $project) {
            if ($i++ == 0) { continue; } //skip first row (headers)
            //Get Mgi Accession Id for a given gene symbol            
            $mgi_id = $this->MgiGenesDump
                ->find('all')
                ->where(['marker_symbol =' => $project[1]])
                ->first()['mgi_accession_id'];
            if (!$mgi_id) {
                $this->showErr("Can't find matching MGI Accession ID for gene name {$project[1]}");
            }

            //Prepare and save project
            $data = [
                'project_type_id' => $this->searchObjectKey($project[0], 'type', $this->projectTypes),
                'project_status_id' => $this->searchObjectKey($project[2], 'status', $this->projectStatuses),
                'mutation_id' => $this->searchObjectKey($project[3], 'type', $this->mutations),
                'phenotype_id' => $this->searchObjectKey($project[4], 'type', $this->phenotypes),
                'comments' => $project[5],
                "mgi_accession_ids" => [$mgi_id  => $mgi_id],
                'batch_upload_uid' => $this->batchUploadId
                ];
            $this->add($data);
            unset($data);
            unset($mgi_id);
        }
        return $this;
    }
    
/*************************************************************************/
    /**
     * Index method
     *
     * @return void
     */
    public function index($ajax = null)
    {
        $this->Colony->getName(null, 7801);

        if(!is_null($this->request->query("bulk_upload"))){
            $this->Flash->success("Bulk upload completed successfully!");   
        }
    
        if ($ajax) { //dump data in JSON format
            $data = $this->Projects->find('all')->contain(
            [ 'ProjectTypes', 'ProjectStatuses', 'Mutations', 'Phenotypes', 'MgiGenesDump']);
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', json_encode($data));
            $this->render('/Imits/dumpvalues');
        }

        //Prepare DataTables.js view
        if ($this->request->is('json')) {
            // Notices from time parser break json view, so let's mute them (yikes!);
            @$resp = $this->Search->getDataTablesResultSet($this->request, 'Projects', ['Colonies', 'ProjectTypes', 'ProjectStatuses', 'Mutations', 'Phenotypes', 'MgiGenesDump']);
            // process the result set
            foreach ($resp['data'] as $k=>$proj) {
                   $resp['data'][$k]['project_name'] = "<a href='/projects/view/{$proj->id}'>{$this->Project->getName($proj->id)}</a><br/>";
                   $resp['data'][$k]['colony_name'] = $this->Colony->getName($proj->id);
                   $mgi_ids = [];
                    foreach ($proj->mgi_genes_dump as $gene) {
                        $mgi_ids[] =  "<a href='/mgi-genes-dump/view/{$gene->mgi_accession_id}'>{$gene->mgi_accession_id}</a>";
                    }
                    $resp['data'][$k]['mgi_genes_dump'] = implode(', ', $mgi_ids);
                }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
            }
        }    

    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Colonies', 'ProjectTypes', 'ProjectStatuses', 'Mutations', 'ProjectMilestones.ProjectStatuses', 'Phenotypes', 'MgiGenesDump', 'Injections.Users', 'CrisprDesigns']
        ]);
        $project['name'] =  $this->Project->getName($id); //generate and add project name to the project object
        $this->set('project', $project);
        $this->set('_serialize', ['project']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($projectData=null)
    {
        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {
            if ($projectData) {
                $projectData = (object) $projectData;
            } else {
                $projectData = (object) $this->request->data;
            }  

            if (isset($this->request->data['external_project_id'])){
                $externalProjectId = $this->request->data['external_project_id'];
                switch(strtoupper($this->request->data['project_type_id'])) {
                    case '5': // PTS
                    $projectData->pts_id_no = $externalProjectId;
                    break;
                    case '3': // MMRRC
                    $projectData->mmrrc_id_no = $externalProjectId;
                    break;
                    case '1': // KOMP
                    $projectData->komp_id_no = $externalProjectId;
                    break;
                }
            }

            if ($projResult = $this->Project->saveProject($projectData)) { //saveProject() is defined in custom Project component
                $this->Flash->success(__('The project has been saved. Project id: '.$projResult->id));
                # Save milestone
                if (!($milesResult = $this->Milestones->saveMilestone($projResult->id, $projectData->project_status_id))){
                    $this->Flash->error(__("Couldn't save the milestone for project id: ".$projResult->id));
                }
                # Save relations in API-NS (only if external project)
                if (isset($externalProjectId)){
                    $relationsArr = [
                        'mmrrc_order_id' => isset($projectData->mmrrc_id_no) ? $projectData->mmrrc_id_no : null,
                        'pts_project_id' => isset($projectData->pts_id_no) ? $projectData->pts_id_no : null,
                        'komp_id'=> isset($projectData->komp_id_no) ? $projectData->komp_id_no : null,
                        'rt_lims_project_id'=> isset($projResult->id) ? $projResult->id : null
                        ];
                    $res = $this->Helper->saveRelationsToApins($relationsArr);
                    if (isset($res->json['success'])) {
                        $this->Flash->success('Relations successfully saved in API-NS middleware. Row id: ' . $res->json['success']);
                    } else {
                        $this->Flash->error(__('Relations could NOT be saved into API-NS middleware.'));
                        $this->AppErrors->saveError('api-ns', "Relations couldn't be saved", $projResult->id);
                    }
                }
                if (isset($_GET['redir'])) {
                    return $this->redirect(['controller' => $_GET['redir'], 'action' => 'add']);    
                }
                if (isset($projectData->batch_upload_uid)) {
                    return $projResult;
                } 
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $projectTypes = $this->Projects->ProjectTypes->find('list', ['limit' => 200]);
        $projectStatuses = $this->Projects->ProjectStatuses->find('list', ['limit' => 200]);
        $mutations = $this->Projects->Mutations->find('list', ['limit' => 200]);
        $phenotypes = $this->Projects->Phenotypes->find('list', ['limit' => 200]);
        $this->set(compact('project', 'projectTypes', 'projectStatuses', 'mutations', 'phenotypes'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['ProjectTypes', 'ProjectStatuses', 'Mutations', 'ProjectMilestones.ProjectStatuses', 'Phenotypes', 'MgiGenesDump']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            //Check if project status has been edited
            if ($project->project_status_id != $this->request->data['project_status_id']) {
                $saveMilestone = true;
            }

            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($projResult = $this->Projects->save($project)) {
                # Save milestone
                if (isset($saveMilestone)) {
                    if (!($milesResult = $this->Milestones->saveMilestone($project->id, $project->project_status_id))){
                        $this->Flash->error(__("Couldn't save the milestone for project id: ".$projResult->id));
                    }
                }
                # Save relations in API-NS
                $projectData = (object) $this->request->data;
                if (!empty($projectData->mmrrc_id_no) || !empty($projectData->pts_id_no) || !empty($projectData->komp_id_no)) {
                    $relationsArr = [
                        'mmrrc_order_id' => isset($projectData->mmrrc_id_no) ? $projectData->mmrrc_id_no : null,
                        'pts_project_id' => isset($projectData->pts_id_no) ? $projectData->pts_id_no : null,
                        'komp_id'=> isset($projectData->komp_id_no) ? $projectData->komp_id_no : null,
                        'rt_lims_project_id'=> isset($projResult->id) ? $projResult->id : null
                        ];
                    $res = $this->Helper->saveRelationsToApins($relationsArr);
                    if (isset($res->json['success'])) {
                        $this->Flash->success('Relations successfully saved in API-NS middleware. Row id: ' . $res->json['success']);
                    } else {
                        $this->Flash->error(__('Relations could NOT be saved into API-NS middleware.'));
                        $this->AppErrors->saveError('api-ns', "Relations couldn't be saved", $projResult->id);
                    }
                }
                $this->Flash->success(__('The project has been saved. Project id:'.$projResult->id));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $projectTypes = $this->Projects->ProjectTypes->find('list');
        $projectStatuses = $this->Projects->ProjectStatuses->find('list');
        $mutations = $this->Projects->Mutations->find('list');
        $genes = $this->Projects->MgiGenesDump->find('list', ['limit' => 200]);
        $phenotypes = $this->Projects->Phenotypes->find('list', ['limit' => 200]);
        $this->set(compact('project', 'projectTypes', 'projectStatuses', 'mutations', 'genes', 'phenotypes'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
