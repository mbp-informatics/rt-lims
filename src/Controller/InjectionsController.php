<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Injections Controller
 *
 * @property \App\Model\Table\InjectionsTable $Injections
 */
class InjectionsController extends AppController
{
    /** 
     * Load 'Project' component to access its custom getName($pid) method
     * Load 'Milestones' component to access its custom 
     * saveMilestone($projectId, $milestoneId) method
     */
    public $components = array('Project', 'Milestones', 'AppErrors', 'Injection', 'Colony');
    public $injectedStatusId = 4; //4 = 'Injected'
    public $initialColonyNumber = 10000; // start numbering colonies at 10000
    
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Projects');
        $this->loadModel('ProjectsInjections');
        $this->loadModel('Colonies');
    }


    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        //Prepare DataTables.js view
        if ($this->request->is('json') || true) {

            $contain = [
                'Projects.MgiGenesDump',
                'Projects.ProjectTypes',
                'Projects.ProjectStatuses',
                'Projects.Mutations',
                'Projects.Phenotypes',
                'Colonies',
                'Jobs'
                ];
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'Injections', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'Injections', $contain);
            }

            // process the result set
            foreach ($resp['data'] as $k=>$inj) {
                $projNames = '';
                foreach ($inj->projects as $proj) {
                    $projNames .= "<a href='/projects/view/{$proj->id}'>{$this->Project->getName($proj->id)}</a><br/>";
                }
                if (count($inj->projects) != 0) {
                    $resp['data'][$k]['project_name'] = $projNames;
                } else {
                    $resp['data'][$k]['project_name'] = '';
                }
                $resp['data'][$k]['colonies'] = $this->Colony->getName(null, $inj->id);
                $resp['data'][$k]['cell_clone_line'] = $resp['data'][$k]['job']['cell_clone_line'];
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }


    /**
     * This method returns injections that have 'do_imits_update' flag set to 1.
     * It's used by the api-ns to figure out which injections should be 
     * pushed to/updated in imits as mi_attempts.
     *
     * @return void
     */
    public function getInjectionsForImits()
    {
        $this->autorender = False;
        $this->loadModel('ImitsDumpMiPlans');
        $injections = $this->Injections
            ->find('all')
            ->where(['do_imits_update = ' => 1])
            ->contain([
                'Users',
                'Projects'=>
                    ['ProjectTypes', 'Mutations', 'Phenotypes', 'MgiGenesDump', 'CrisprDesigns.CrisprAttributes'],
                'EmbryoTransfers',
                'Colonies'
            ])->toArray();

        foreach ($injections as &$inj) {
            if (!isset($inj['projects'][0])) {
                continue; //no project = no gene = no mi plan
            }
            $inj['mi_plan'] = $this->ImitsDumpMiPlans->find('all')
            ->where([
                'mgi_accession_id = ' => $inj['projects'][0]['mgi_genes_dump'][0]['mgi_accession_id']
                ])->first();
        }
        unset($inj);
        $this->set('injections', $injections);
        $this->set('_serialize', ['injections']);
        $this->render('index');
    }


    public function clearImitsUpdateFlag($injId)
    {
        $resp = $this->Injection->clearImitsUpdateFlag($injId);
        $this->set('res', $resp);
        $this->set('_serialize', ['resp']);
        $this->render('index');
    }

    /**
     * View method
     *
     * @param string|null $id Injection id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $injection = $this->Injections->get($id, [
            'contain' => ['Users', 'Projects'=>['ProjectTypes', 'Mutations', 'Phenotypes', 'MgiGenesDump'], 'EmbryoTransfers', 'Colonies', 'EmbryoTransfers.Recipients']
        ]);
        $colonyName = $this->Colonies->find('all')->where(['injection_id =' => $id])->last()['name'];
        $colonies = $this->Colonies->find('all')->where(['injection_id =' => $id])->toArray();

        //Inject project name
        foreach ($injection->projects as &$proj) {
            $proj['project_name'] = $this->Project->getName($proj['id']);
        }
        unset($proj);

        $this->set('injection', $injection);
        $this->set('colonyName', $colonyName);
        $this->set('colonies', $colonies);
        $this->set('_serialize', ['injection']);
        $this->set('imitsStatus', $this->getImitsStatus($injection));
        switch (strtoupper($injection->injection_type)) {
            case 'BL':
            $this->render('/Injections/view_esc');
            break;
            default:
            $this->render('/Injections/view_zygote'); //injection_type == CR or PN
        }
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($type='')
    {
        $type = strtoupper($type);
        $injection = $this->Injections->newEntity();
        if ($this->request->is('post')) {
            $conn = ConnectionManager::get('default');
            $conn->transactional(function ($conn) use ($type, $injection) { //let's do all this as one transaction
                $jointErrMsg = '';
                
                /* Save the injection */
                unset($this->request->data["id"]);
                $injection = $this->Injections->patchEntity($injection, $this->request->data);
                $injResult = $this->Injections->save($injection);
                if (!$injResult->id) {
                    $is_err = true;
                    $errMsg = "The INJECTION could not be saved. Please, try again.";
                    $jointErrMsg .= $errMsg;
                    $this->Flash->error(__($errMsg));                  
                }

                /* Save projects <> injections relations */
                $projectsInjections = []; //will need it later when saving colonies
                foreach ($this->request->data["linkedProjects"] as $projId) {
                    $projRelResult = $this->saveProjectsInjectionsRelation($projId, $injResult->id);
                    if (!$projRelResult->id) {
                        $is_err = true;
                        $errMsg = "Could not saved Project<>Injection RELATION for project {$projId} could not be changed. Please, try again.";
                        $jointErrMsg .= $errMsg;
                        $this->Flash->error(__($errMsg)); 
                    }
                    $projectsInjections[] = ['project_id' => $projId, 'injection_id' => $injResult->id];
                }

                /* Edit project status of all projects linked to this injection */
                foreach ($this->request->data["linkedProjects"] as $projId) {
                    $projStatusResult = $this->Project->changeProjectStatus($projId, $this->injectedStatusId);//change  status to 4 = injected
                    if (!$projStatusResult){ 
                        $is_err = true;
                        $errMsg = "Could not change PROJECT STATUS of project {$projId}. Please, try again.";
                        $jointErrMsg .= $errMsg;
                        $this->Flash->error(__($errMsg));                      
                    }
                }

                /* Save the milestone for each linked project */
                foreach ($this->request->data["linkedProjects"] as $projId) {
                    if (!($milesResult = $this->Milestones->saveMilestone($projId, $this->injectedStatusId))) {
                        $is_err = true;
                        $errMsg = "The MILESTONE for project {$projId} could not be saved. Please, try again.\n";
                        $jointErrMsg .= $errMsg;
                        $this->Flash->error(__($errMsg));   
                    }
                }

                /* If injection is CRM, Save 3 new colonies with an incremented id */
                if ($type == 'CRM' && count($projectsInjections) > 1) {
                    //Add CRM 'ghost' colony
                    $projectsInjections[] = ['project_id' => null, 'injection_id' => $injResult->id];
                    $denotations = ['CR', 'CR', 'CRM'];
                    $i = 0;
                    $crmColonyName = '';
                    foreach ($projectsInjections as $k => $projectInjection) {

                        //Grab previous colony id and auto-increment
                        if ($prevColonyId = $this->Colonies->find('all')->last()['colony_id']) {
                            $colonyId = ++$prevColonyId;
                        } else {
                            $colonyId = $this->initialColonyNumber; //look's like the table's empty so we need to start somewhere
                        }

                        //Figure out denotation and prepare colony names
                        if (count($projectsInjections) == $k+1) { //we're at the last array row!
                            $denotation = 'CRM';
                            $colonyName = 'CRM_'.trim($crmColonyName, '_');
                        } else {
                            $denotation = 'CR';
                            $colonyName = "{$denotation}{$colonyId}";
                            $crmColonyName .= $colonyId.'_';
                        }
                    
                        //Prepare MGI Accession Ids
                        $mgi_accession_id = null;
                        $gene = null;
                        if ($denotation != 'CRM') {
                            $gene = $this->Projects
                                ->find('all')
                                ->contain('MgiGenesDump')
                                ->where(['id = ' => $projectInjection['project_id']])
                                ->last()['mgi_genes_dump'];
                        }
                        $mgi_accession_id = $gene[0] ? $gene[0]->mgi_accession_id : null;

                        $colony = $this->Colonies->newEntity();
                        $colony->colony_id = $colonyId;
                        $colony->denotation = $denotation;
                        $colony->name = $colonyName;
                        $colony->injection_id = $injResult->id;
                        $colony->project_id = $projectInjection['project_id'];
                        $colony->mgi_accession_id = $mgi_accession_id;
                        
                        if (!($colResult = $this->Colonies->save($colony))) {
                            $is_err = true;
                            $errMsg = "The COLONY for project {$projectInjection['project_id']} could not be saved. Please, try again.\n";
                            $jointErrMsg .= $errMsg;
                            $this->Flash->error(__($errMsg));   
                        }
                        $i++;
                    } //end foreach
                } else {
                    /**
                     * Injection type other than CRM (or CRM with 1 project
                     *  only), means there's a single project only, so we
                     * need to save only 1 colony
                     */

                    //Special case: CRM injection with 1 project only
                    //If so, ecreate only 1 colony with denotaion = CR
                    if ($type == 'CRM') { $type = 'CR'; }

                    //Grab previous colony id and auto-increment
                    if ($prevColonyId = $this->Colonies->find('all')->last()['colony_id']) {
                        $colonyId = ++$prevColonyId;
                    } else {
                        $colonyId = $this->initialColonyNumber; //look's like the table's empty so we need to start somewhere
                    }

                    //Get MGI Accession Id
                    $gene = $this->Projects
                                ->find('all')
                                ->contain('MgiGenesDump')
                                ->where(['id = ' => $projId])
                                ->last()['mgi_genes_dump'];
                    $mgi_accession_id = isset($gene[0]) ? $gene[0]->mgi_accession_id : null;

                    $colony = $this->Colonies->newEntity();
                    $colony->colony_id = $colonyId;
                    $colony->denotation = $type;
                    $colony->name = "{$type}{$colonyId}";
                    $colony->injection_id = $injResult->id;
                    $colony->project_id = $projId;
                    $colony->mgi_accession_id = $mgi_accession_id;

                    if (!($colResult = $this->Colonies->save($colony))) {
                        $is_err = true;
                        $errMsg = "The COLONY for project {$projId} could not be saved. Please, try again.\n";
                        $jointErrMsg .= $errMsg;
                        $this->Flash->error(__($errMsg));   
                    }
                } //end else (non CRM injection colony)

                if (isset($is_err)) {
                    $this->AppErrors->saveError('api-ns', "Couldn't save the new injection. Transaction rolled back.");
                    throw new \Exception("Rolling back the transaction. Could not save some of it's constituents. {$errMsg}");
                }
                
                foreach ($injection->linkedProjects as $pid) {
                    if ($this->Projects->get($pid)['project_type_id'] == 1) { //found KOMP project
                        $isKompProject = true;
                        break;
                    }
                }
                if (strtoupper($injection->injection_type) == 'CRM' || isset($isKompProject)) {
                    $matchColonies = '1'; //Show match colonies dialog immediately after saving the injection
                } else {
                    $matchColonies = '0';
                }
                return $this->redirect(['controller'=>'injections', 'action' => 'view', $injection->id, 'match-colonies' => $matchColonies]);
            }); //end transactional closure
        } //end if post

        $kompGenesDump = $this->getGenesDump();
        $users = $this->Injections->Users->find('list', ['limit' => 200]);
        if (isset($_GET['pull-from-injection'])) {
            $injectionToPullFrom = $this->Injections->get($_GET['pull-from-injection']);
            $this->set('injectionToPullFrom', $injectionToPullFrom);
        }
        $this->set('type', $type);
        $this->set(compact('injection', 'users', 'inventoryVials', 'kompGenesDump'));
        $this->set('_serialize', ['injection']);

        switch ($type) {
            case 'CR':
            case 'CRM':
            $this->render('/Injections/add_zygote');
            break;
            case 'PN':
            $this->render('/Injections/add_zygote');
            break;
            case 'BL':
            $this->render('/Injections/add_esc');
            break;
        }

    }

    /**
     * Edit method
     *
     * @param string|null $id Injection id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $injection = $this->Injections->get($id, [
            'contain' => ['Users', 'Projects'=>['ProjectTypes', 'Mutations', 'Phenotypes', 'MgiGenesDump'], 'EmbryoTransfers']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $injection = $this->Injections->patchEntity($injection, $this->request->data);
            if ($injResult = $this->Injections->save($injection)) {

                /* Set the 'injections.do_imits_update' flag */
                if ($this->Injection->isImitsUpdateNeeded($id)) {
                    $saveStatus = $this->Injection->setImitsUpdateFlag($id);
                } else {
                    $saveStatus = $this->Injection->clearImitsUpdateFlag($id);
                }
                if ($saveStatus === false) {
                    $this->AppErrors->saveError('rt-lims', "Couldn't set 'do_imits_update' flag for the injection.", $injection_id);
                    $this->Flash->error(__("Could not set 'do_imits_update' flag. iMITS WILL NOT GET UPDATED! Contact IT for details."));
                } elseif ($saveStatus === true) {
                    $this->Flash->success(__("The 'do_imits_update' flag has been set. The mi_attempt record will be updated in iMits shortly." ));
                }
                

                $this->Flash->success(__('Injection has been successfully saved in RT-LIMS.'));
                return $this->redirect(['action' => 'view', $injection['id']] );
            } else {
                $this->Flash->error(__('The injection could not be saved. Please, try again.'));
            }
        }

        $projectsString = '';
        $genesString = '';
        foreach ($injection->projects as $proj) {
            $projectsString .= "id: ".$proj->id." (type: {$proj->project_type->type}), ";

            foreach ($proj->mgi_genes_dump as $gene) {
                $genesString .= $gene->marker_symbol." ({$gene->mgi_accession_id}), ";
            }
        }
        $this->set('projectsString', rtrim($projectsString, ', '));
        $this->set('genesString', rtrim($genesString, ', '));

        $users = $this->Injections->Users->find('list', ['limit' => 200]);
        $this->set(compact('injection', 'users' ));
        $this->set('_serialize', ['injection']);
        switch (strtoupper($injection->injection_type)) {
            case 'BL':
            $this->render('/Injections/edit_esc');
            break;
            default:
            $this->render('/Injections/edit_zygote'); //injection_type == CR or PN
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Injection id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $injection = $this->Injections->get($id);
        if ($this->Injections->delete($injection)) {
            $this->Flash->success(__('The injection has been deleted.'));
        } else {
            $this->Flash->error(__('The injection could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function getCrisprDesignByProjectId($id)
    {
        $table = TableRegistry::get('crispr_designs');
        $query = $table->find('all', [
            'conditions' => ['crispr_designs.project_id =' => $id],
            'contain' => ['Projects.Genes', 'CrisprAttributes']
        ]);
        $results = $query->first();
        return $results;
    }

    public function prepareProjectsList() { //prepares array to be used in the view dropdown: [projectID => projectName]
        $table = TableRegistry::get('projects');
        $query = $table->find('all');
        $results = $query->all();
        $list = [];
        foreach ($results->toArray() as $project) {
            $list[$project->id] = $this->Project->getName($project->id);
        }
        return $list;
    }
    
    private function getGenesDump() {
        $conn = ConnectionManager::get('default');
        $kompGenesQuery = $conn->execute('SELECT id, symbol FROM komp_genes_dump WHERE hasBeenOrdered = 1');
        $kompGenes = $kompGenesQuery->fetchAll();
        $geneOptions = [];
        foreach ($kompGenes as $key => $row) {
            $geneOptions[$row['0']] = $row['1'];
        }
        return $geneOptions;
    }

    /* Save project <> injection many-to-many relation in projects_injections table */
    private function saveProjectsInjectionsRelation($projectId, $injectionId) {
        $projectsInjectionsTable = TableRegistry::get('ProjectsInjections');
        $projectsInjectionsData = [
            'project_id' => $projectId,
            'injection_id' => $injectionId
        ];
        $projectsInjections = $projectsInjectionsTable->newEntity($projectsInjectionsData);
        $project = $projectsInjectionsTable->patchEntity($projectsInjections, $projectsInjectionsData);
        return $projectsInjectionsTable->save($projectsInjections);
    }

    /* Returns the iMits status for an injection. Statuses matrix:
     * DO_IMITS_UPDATE | IMITS_MI_ATTEMPT_ID | STATUS
     * true            | true                | 'update pending'
     * true            | false               | 'insert pending'
     * false           | true                | 'updated'
     * false           | false               | 'none'    
     */
    private function getImitsStatus($injection) {
        if (!($injection->do_imits_update || $injection->imits_mi_attempt_id)) {
            $status = 'none';
        }
        if ($injection->do_imits_update && $injection->imits_mi_attempt_id) {
            $status = 'update pending';
        }
        if (!isset($status)) {
            if ($injection->do_imits_update) { $status = 'insert pending'; }
            if ($injection->imits_mi_attempt_id) { $status = 'updated'; }
        }
        return $status;
    }


    //A method to be invoked manually when some automatic work is needed
    public function automateupdateimitsflags() {
        if ($this->Auth->user("role")['id'] != 1) {
            return null;
        }
        //Grab injections after Sept 19
        // $injs_to_update = $this->Injections->find('All')->where(['created >' => '2017-09-18'])->toArray();

        // Grab injections after CR10000 (inj id = 7743)
        $injs_to_update = $this->Injections->find('All')
        ->contain([
            'Users', 'Projects'=>['ProjectTypes', 'Mutations', 'Phenotypes', 'MgiGenesDump'], 'EmbryoTransfers', 'Colonies', 'EmbryoTransfers.Recipients'
        ])->where(['Injections.id >' => 7742])->toArray();
        echo '<pre>injs to iterate over:' . count( $injs_to_update ) . "\n";
        $i = 0;
        foreach ($injs_to_update as $inj) {
            $this->Injections->updateNumberTransfered($inj['id']);
            /* Set the 'injections.do_imits_update' flag */
            if ($this->Injection->isImitsUpdateNeeded($inj['id'])) {

                echo $inj->id . "\t" . $inj->colonies[0]->name . "\t" . $inj->projects[0]->mgi_genes_dump[0]->marker_symbol;
                if (isset($inj->mi_attempt_id)) {
                    echo "\t" . $inj->mi_attempt_id;
                }
                echo "\n";

                $this->Injection->setImitsUpdateFlag($inj['id']);
            } else {
                $this->Injection->clearImitsUpdateFlag($inj['id']);
            }

            $i++;

            // if ($i == 3) { exit; }
        }
        echo "\nIterated over: ".$i;
        exit;
        return null;
    }

    //A method to be invoked manually when some automatic work is needed
    public function automateUpdatePostCr1000Injection($fname) {
        if ($this->Auth->user("role")['id'] != 1) {
            return null;
        }
        $f_input = __DIR__.'/../../webroot/uploads/other/'.$fname;
        $row = 1;
        //Read the input file
        if (($handle = fopen($f_input, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row == 1) { $row++; continue; }

                $inputData = [
                    'id' => (int) $data[2],
                    'do_imits_update' => 1
                ];
                if (isset($data[1]) && !empty($data[1])) {
                    $inputData['grna_concentration'] = $data[1];
                }
                if (isset($data[0]) && !empty($data[0])) {
                    $inputData['protein_nuclease_concentration'] = $data[0];
                }
                debug($inputData);
                // Update the injection
                $injection = $this->Injections->get($inputData['id']);
                if ($injection->grna_concentration !=  $inputData['grna_concentration'] && $injection->protein_nuclease_concentration != $inputData['protein_nuclease_concentration']) {
                    echo '<pre>update this!';
                    $injection = $this->Injections->patchEntity($injection, $inputData);
                    if( $res = $this->Injections->save($injection) ) {
                        echo $res->id . ' successfully updated'."\n";
                    }    
                }
                echo $row++;
            }
                fclose($handle);
                echo 'Iterated over: '. $row;
                exit;
                return null;
        }
    }

    //A method to be invoked manually when some automatic work is needed
    public function automateUpdatePreCr1000Injection($fname=null) {
        echo "<pre>";
        if ($this->Auth->user("role")['id'] != 1) {
            return null;
        }

        $f_input = __DIR__.'/../../webroot/uploads/other/'.$fname;
        $row = 1;
        //Read the input file
        if (($handle = fopen($f_input, "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                if ($row == 1) { $row++; continue; }

                //Get injection for a given CR number
                $injection = $this->Injections->find('All');
                $injection->matching('Colonies', function ($q) use ($data) {
                    return $q->where(['Colonies.name =' => $data[0]]); //e.g. CR1334
                });

                $inputData = [
                    'protein_nuclease_concentration' => (int) $data[1],
                    'grna_concentration' => (int) $data[2]
                ];
                $injection = $injection->first();

                // Update the injection
                if ($injection['grna_concentration'] !=  $inputData['grna_concentration'] &&
                    $injection['protein_nuclease_concentration'] != $inputData['protein_nuclease_concentration']) {
                    echo '<pre>update this!';
                    try {
                        $injection = $this->Injections->get($injection['id']);
                        $injection = $this->Injections->patchEntity($injection, $inputData);
                        if( $res = $this->Injections->save($injection) ) {
                            echo $res->id . ' successfully updated'."\n";
                        }                    
                    } catch (\Exception $e) {
                        debug($e->getMessage());
                    }
                }
                echo $row++ .' - '.$data[0]."\n";
            }
                fclose($handle);
                echo 'Iterated over: '. $row;
                exit;
                return null;
        }
    }


}


