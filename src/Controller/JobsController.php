<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;


/**
 * Jobs Controller
 *
 * @property \App\Model\Table\JobsTable $Jobs
 */
class JobsController extends AppController
{
    public $components = array('ChangeLog', 'Project', 'Colony'); 

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

        $contain = [
                 'SpermCryos.InventoryVials',
                 'EmbryoCryos.InventoryVials',
                 'JobTypes.JobTypeNames',
                 'JobAstatuses',
                 'JobBstatuses'
        ];

        if (isset($this->request->query['injection_requests'])) {
            $this->set('injection_requests', $this->request->query['injection_requests']);    
        }

        if ($this->request->is('json')||true) {
            if (isset($this->request->query['injection_requests'])) {
                // Case: display only injection requests    
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'Jobs', $contain, ['is_injection_request' => '1']);
            } elseif (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                //Case: Advanced search
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'Jobs', $contain);
            } else {
                //Case: Display all jobs
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'Jobs', $contain);            
            }

            foreach ($resp['data'] as $k=>$job) {

                $resp['data'][$k]['id_action'] = $job->id;
                $resp['data'][$k]['id'] = "<a href='/jobs/view/{$job->id}' target='_blank' >{$job->id}</a>";

                if ($job->sperm_cryos){
                    $samplesCount = 0;
                    foreach ($job->sperm_cryos as $sc) {
                        foreach ($sc->inventory_vials as $vial) {
                            if ($vial->tissue != 1 && $vial->do_not_distribute != 1) {
                                $samplesCount += 1;
                            }
                        }
                    }
                    $resp['data'][$k]['sc_count'] = $samplesCount;
                
                } else {
                    $resp['data'][$k]['sc_count'] = '-';
                } 
                if ($job->embryo_cryos){
                    $embryoCount = 0;
                    foreach ($job->embryo_cryos as $ec) {
                        if ($ec->inventory_vials){
                            foreach ($ec->inventory_vials as $vial) {
                                if ($vial->volume && $vial->do_not_distribute != 1) {
                                    $embryoCount += $vial->volume;
                                }
                            }
                        }
                    }
                    $resp['data'][$k]['ec_count'] = $embryoCount;
                } else {
                    $resp['data'][$k]['ec_count'] = '-';
                } 

                if ($job->job_astatus_id){
                    $resp['data'][$k]['job_status'] = $job->job_astatus->name;
                } else {
                    $resp['data'][$k]['job_status'] = '';
                } 
                if ($job->job_bstatus_id){
                    $resp['data'][$k]['job_statusb'] = $job->job_bstatus->name;
                } else {
                    $resp['data'][$k]['job_statusb'] = '';
                } 
            }

            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        } //end if json
    }

    /**
     * View method
     *
     * @param string|null $id Job id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null, $ajax = null)
    {
        $job = $this->Jobs->get($id, [
            'contain' => ['Injections.Projects', 'MgiGenesDump', 'KompVialsDump', 'KompvialsJobs', 'Users', 'EmbryoCryos', 'EmbryoResus', 'Ivfs', 'JobComments.Users', 'Contacts', 'JobTypes.JobTypeNames', 'SpermCryos', 'JobAstatuses', 'JobBstatuses', 'SpermCryos.InventoryVials', 'EmbryoCryos.InventoryVials', 'Contacts.ContactTypes', 'EmbryoTransfers', 'JobComments', 'EmbryoTransfers.Recipients', 'Ivfs.IvfDishes', 'GenotypeRequests', 'GenotypeRequests.Genotypings']
        ]);

        //Let's grab Komp Vials and modify $job object
        $job->komp_vials_dump = $this->Jobs->KompVialsDump->findKompVials($job->id);

        /* Get change log for this and associated tables */
        $parentModel = ['tableName' => 'Jobs', 'id' => $id];
        $children = ['fk' => 'job_id', 'tables' => ['KompvialsJobs', 'JobComments', 'ContactsJobs', 'JobTypes']];
        $manyToManyDefs = [
            [
                'lookup' => [
                    'table' => 'ContactsJobs', 
                    'fk' =>  'contact_id'
                ],
                'target' => [
                    'table' => 'Contacts', 
                    'pk' =>  'id'
                ]
            ]
        ];
        $changes = $this->ChangeLog->getAssocChangeLog($parentModel, $children, $manyToManyDefs);
        if (!empty($job->project_id)){
            $job->project_name = $this->Project->getName($job->project_id);
        }

        $comments = $this->Jobs->JobComments->find('all', ['order' => ['JobComments.created' => 'DESC'], 'conditions' => ['JobComments.job_id' => $id], 'contain' => ['Users']]);

        if ($ajax) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', $job);
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set('job', $job);
            $this->set('changes', $changes);
            $this->set('comments', $comments);
            $this->set('_serialize', ['job']);
            if ($job->is_injection_request == True) {

                // process the result set
                foreach ($job->injections as $k=>$inj) {
                    $projNames = '';
                    foreach ($inj->projects as $proj) {
                        $projNames .= "<a href='/projects/view/{$proj->id}'>{$this->Project->getName($proj->id)}</a><br/>";
                    }
                    if (count($inj->projects) != 0) {
                        $job->injections[$k]['project_name'] = $projNames;
                    } else {
                        $job->injections[$k]['project_name'] = '';
                    }
                    $job->injections[$k]['colonies'] = $this->Colony->getName(null, $inj->id);
                }

                $this ->render('view_injection_request');                
            }
        }
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($injectionTag=Null)
    {
        $job = $this->Jobs->newEntity();
        if ($this->request->is('post')) {
            $conn = ConnectionManager::get('default');
            $conn->transactional(function ($conn) use ($job) { //let's do all this as one transaction
                /**
                 * Save the project if job source = KOMP ORDER
                 * Create a new project. This works because all vials per
                 * clone are linked to the same KOMP order: 
                 * we are forcing a user to select a single order only.
                 */
               
                if (isset($this->request->data['kompVials'])) {
                    $kompOrderNo =  $this->Jobs->KompvialsJobs->KompVialsDump
                        ->find()
                        ->where(['komp_vial_id' => $this->request->data['kompVials'][0]])
                        ->toArray()[0]->komp_order_id;

                    $mgiAccessionIds = [];
                    foreach ($this->request->data['kompVials'] as $kompVialId) {
                        $mgiAccessionIds[] = $this->Jobs->KompvialsJobs->KompVialsDump
                            ->get($kompVialId)
                            ->mgi_accession_id;
                    }
                    $mgiAccessionIds = array_unique($mgiAccessionIds);
                    $projectData = [
                        'project_type_id' => 7, // 'KOMP Order'
                        'project_status_id' => 13, // 'Job Requested'
                        'phenotype_id' => 4, // 'unspecified'
                        'mutation_id' => 6, // 'unspecified'
                        'komp_order_no' => $kompOrderNo,
                        'mgi_accession_ids' => $mgiAccessionIds
                    ];
                    if ($projResult = $this->Project->saveProject($projectData)) {
                        $this->Flash->success(__("The project has been successfully saved. Project id:{$projResult->id}"));
                    } else {
                        $this->Flash->error(__("Could not save the project. Aborting."));                        
                        return $this->redirect(['controller'=> 'Jobs', 'action' => 'index']);
                    }
                    $this->request->data['project_id'] = $projResult->id;
                }

                $job = $this->Jobs->patchEntity($job, $this->request->data);
                //Prepare JobTypes associations
                if (isset($this->request->data['jobTypes'])) {
                    $jobTypeAssociations = [];
                    foreach ($this->request->data['jobTypes'] as $jobType) {
                        $nt = $this->Jobs->JobTypes->newEntity();
                        $nt->job_type_name_id = $jobType['jobType'];
                        $nt->scheduled_date1 = $jobType['scheduledDate1'];
                        $nt->scheduled_date2 = $jobType['scheduledDate2'];
                        $nt->user_id = $this->Auth->user('id');
                        $jobTypeAssociations[] = $nt;
                    }
                }

                //Prepare JobContacts associations
                if (isset($this->request->data['jobContacts'])) {
                    $jobContactAssociations = [];
                    foreach ($this->request->data['jobContacts'] as $jobContactId) {
                        $nt = $this->Jobs->ContactsJobs->newEntity();
                        $nt->contact_id = $jobContactId;
                        $nt->user_id = $this->Auth->user('id');
                        $jobContactAssociations[] = $nt;
                    }
                }

                //Prepare JobComments associations
                if (isset($this->request->data['jobComments'])) {
                    $jobCommentAssociations = [];
                    foreach ($this->request->data['jobComments'] as $commentBody) {
                        $nt = $this->Jobs->JobComments->newEntity();
                        $nt->comment = $commentBody;
                        $nt->user_id = $this->Auth->user('id');
                        $jobCommentAssociations[] = $nt;
                    }
                }

                // Prepare KompVials associations
                if (isset($this->request->data['kompVials'])) {
                    $kompVialAssociations = [];
                    foreach ($this->request->data['kompVials'] as $key => $kompVialId) {
                        $nt = $this->Jobs->KompvialsJobs->newEntity();
                        $nt->komp_vial_id = $kompVialId;
                        $nt->komp_order_id = $this->request->data['kompOrders'][$key];
                        $nt->user_id = $this->Auth->user('id');
                        $kompVialAssociations[] = $nt;
                    }
                }

                $res = $this->Jobs->save($job);
                if (isset($this->request->data['jobTypes'])) {
                    $this->Jobs->JobTypes->link($job, $jobTypeAssociations);
                }
                if (isset($this->request->data['jobContacts'])) {
                    $this->Jobs->ContactsJobs->link($job, $jobContactAssociations);
                }
                if (isset($this->request->data['jobComments'])) {
                    $this->Jobs->JobComments->link($job, $jobCommentAssociations);
                }
                if (isset($this->request->data['kompVials'])) {
                    $this->Jobs->KompvialsJobs->link($job, $kompVialAssociations);
                }

                if ($res) {
                    $this->Flash->success(__("The job has been saved. Job id: {$res->id}"));
                    return $this->redirect(['controller'=> 'Jobs', 'action' => 'view', $job->id]);
                } else {
                    $this->Flash->error(__('The job could not be saved. Please, try again.'));
                }
            }); //end transaction
        } //end if POST

        $users = $this->Jobs->Users->find('list');
        $jobAstatuses = $this->Jobs->JobAstatuses->find('list', ['order'=>['list_order'=>'ASC'], 'conditions'=>['list_order <' => 86]]); //A bunch of the statuses are not in use anymore, but need to show up on the edit page
        $jobBstatuses = $this->Jobs->JobBstatuses->find('list', ['order'=>['list_order'=>'ASC'], 'conditions'=>['list_order <' => 25]]); //Currently anything below 86 and 25 is current. They also are sorted in an order provided by Ming. 
        $this->set(compact('job', 'users', 'jobAstatuses', 'jobBstatuses', 'injectionTag'));
        $this->set('_serialize', ['job']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Job id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $job = $this->Jobs->get($id, [
            'contain' => ['Projects']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $job = $this->Jobs->patchEntity($job, $this->request->data);
            if ($this->Jobs->save($job)) {
                $this->Flash->success(__('The job has been saved.'));
                return $this->redirect(['controller'=> 'Jobs', 'action' => 'view', $job->id]);
            } else {
                $this->Flash->error(__('The job could not be saved. Please, try again.'));
            }
        }
        $users = $this->Jobs->Users->find('list');
        $jobAstatuses = $this->Jobs->JobAstatuses->find('list', ['order'=>['list_order'=>'ASC']]); //Statuses sorted in an order provided by Ming
        $jobBstatuses = $this->Jobs->JobBstatuses->find('list', ['order'=>['list_order'=>'ASC']]);
        $projectsList = [];
        foreach ($this->Jobs->Projects->find()->where(['project_type_id' => 7]) as $p) {
            $projectsList[$p->id] = $this->Project->getName($p->id);
        }
        $this->set(compact('job', 'users', 'jobAstatuses', 'jobBstatuses', 'projectsList'));
        $this->set('_serialize', ['job']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $job = $this->Jobs->get($id);
        if ($this->Jobs->delete($job)) {
            $this->Flash->success(__('The job has been deleted.'));
            return $this->redirect(['controller'=> 'Jobs', 'action' => 'index']);
        } else {
            $this->Flash->error(__('The job could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller'=> 'Jobs', 'action' => 'view', $job->id]);
    }

    public function genotyping($id = null)
    {
        $job = $this->Jobs->get($id);

        $conn = ConnectionManager::get('default');
        $spermCryos = $conn->execute('SELECT id, donor_id_no, donor_genotype FROM sperm_cryos WHERE job_id = :id', ['id' => $id])->fetchAll();
        $embryoCryos = $conn->execute('SELECT id, stud_id_no, male_genotype FROM embryo_cryos WHERE job_id = :id', ['id' => $id])->fetchAll();
        $ivfs = $conn->execute('SELECT id, stud_id_no, genotype FROM ivfs WHERE job_id = :id', ['id' => $id])->fetchAll();

        $this->set(compact('job', 'spermCryos', 'embryoCryos', 'ivfs'));
        $this->set('_serialize', ['job']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addInjection($injectionTag=Null)
    {
        $job = $this->Jobs->newEntity();
        if ($this->request->is('post')) {
            $conn = ConnectionManager::get('default');
            $conn->transactional(function ($conn) use ($job) { //let's do all this as one transaction

                $job = $this->Jobs->patchEntity($job, $this->request->data);

                //Prepare JobContacts associations
                if (isset($this->request->data['jobContacts'])) {
                    $jobContactAssociations = [];
                    foreach ($this->request->data['jobContacts'] as $jobContactId) {
                        $nt = $this->Jobs->ContactsJobs->newEntity();
                        $nt->contact_id = $jobContactId;
                        $nt->user_id = $this->Auth->user('id');
                        $jobContactAssociations[] = $nt;
                    }
                }

                //Prepare JobComments associations
                if (isset($this->request->data['jobComments'])) {
                    $jobCommentAssociations = [];
                    foreach ($this->request->data['jobComments'] as $commentBody) {
                        $nt = $this->Jobs->JobComments->newEntity();
                        $nt->comment = $commentBody;
                        $nt->user_id = $this->Auth->user('id');
                        $jobCommentAssociations[] = $nt;
                    }
                }

                $res = $this->Jobs->save($job);
                if (isset($this->request->data['jobContacts'])) {
                    $this->Jobs->ContactsJobs->link($job, $jobContactAssociations);
                }
                if (isset($this->request->data['jobComments'])) {
                    $this->Jobs->JobComments->link($job, $jobCommentAssociations);
                }

                if ($res) {
                    $this->Flash->success(__("The job has been saved. Job id: {$res->id}"));
                    return $this->redirect(['controller'=> 'Jobs', 'action' => 'view', $job->id]);
                } else {
                    $this->Flash->error(__('The job could not be saved. Please, try again.'));
                }
            }); //end transaction
        } //end if POST

        $users = $this->Jobs->Users->find('list');
        $this->set(compact('job', 'users', 'injectionTag'));
        $this->set('_serialize', ['job']);
    }


}
