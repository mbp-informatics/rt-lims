<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * KompvialsJobs Controller
 *
 * @property \App\Model\Table\KompvialsJobsTable $KompvialsJobs
 */
class KompvialsJobsController extends AppController
{
    public $components = array('Project'); 
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $kompvialsJobs = $this->paginate($this->KompvialsJobs);

        $this->set(compact('kompvialsJobs'));
        $this->set('_serialize', ['kompvialsJobs']);
    }

    /**
     * View method
     *
     * @param string|null $id Kompvials Job id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kompvialsJob = $this->KompvialsJobs->get($id, [
            'contain' => []
        ]);

        $this->set('kompvialsJob', $kompvialsJob);
        $this->set('_serialize', ['kompvialsJob']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($jobId)
    {
        $kompvialsJob = $this->KompvialsJobs->newEntity();
        if ($this->request->is('post')) {

            /**
             * Check if the order of currently added vial is the
             * same as the order of vial we already have in the DB. 
             * If it's different, prevent the save!
             */
            $existingVials = $this->KompvialsJobs->KompVialsDump->findKompVials($jobId);
            $newVialOrder = $this->request->data['komp_order_id'];
            
            $existingVialsOrderId = null;
            foreach ($existingVials as $vial) {
                if ($vial['komp_order_id']) {
                    $existingVialsOrderId = $vial['komp_order_id'];
                 }
            }
            $newVialOrderId = isset($newVialOrder) ? $newVialOrder : null;

            if ($existingVialsOrderId != $newVialOrderId && $existingVialsOrderId && $newVialOrderId) {
                $this->Flash->error(__("The  KOMP order id of a vial you're trying to add is different than KOMP order id of vials already associated with this job. Vial not associated. Aborting." ));
                return $this->redirect(['action' => 'view', 'controller' => 'jobs', $jobId]);
            }

            $kompvialsJob = $this->KompvialsJobs->patchEntity($kompvialsJob, $this->request->data);
            $kompvialsJobRes = $this->KompvialsJobs->save($kompvialsJob);
            $existingVials = $this->KompvialsJobs->KompVialsDump->findKompVials($jobId);

            //Create a new project and update job->project_id if job->project_id is not set
            $projectId = $this->KompvialsJobs->Jobs->get($jobId)->toArray()['project_id'];
            if (!isset($projectId)) {
                $mgiAccessionIds[] = $this->KompvialsJobs->KompVialsDump
                        ->get($this->request->data['komp_vial_id'])
                        ->mgi_accession_id;
                $mgiAccessionIds = array_unique($mgiAccessionIds);
                $projectData = [
                    'project_type_id' => 7, // 'KOMP Order'
                    'project_status_id' => 13, // 'Job Requested'
                    'phenotype_id' => 4, // 'unspecified'
                    'mutation_id' => 6, // 'unspecified'
                    'komp_order_no' => $newVialOrderId,
                    'mgi_accession_ids' => $mgiAccessionIds
                ];
                $projResult = $this->Project->saveProject($projectData);
                //Edit job->project_id field
                $job = $this->KompvialsJobs->Jobs->get($jobId);
                $job = $this->KompvialsJobs->Jobs->patchEntity($job, ['project_id' => $projResult->id]);
                $this->KompvialsJobs->Jobs->save($job);
            } else { //otherwise, just update genes for the currently associated project
                
                //Find mgi ids for vials
                $mgiAccessionIds = [];
                foreach ($existingVials as $vial) {
                    $mgiAccessionIds[] = $vial->mgi_accession_id;
                }
                $mgiAccessionIds = array_unique($mgiAccessionIds);

                //Delete existing mgi ids for a given project
                $projectsGenesTable = TableRegistry::get('ProjectsGenes');
                $projectsGenesTable->deleteAll(['project_id' => $projectId]);

                //Save new mgi ids for this project
                foreach ($mgiAccessionIds as $mgi_id) {
                    $projectsGenesData = [
                        'project_id' => $projectId,
                        'mgi_accession_id' => $mgi_id
                    ];
                    $projectsGenes = $projectsGenesTable->newEntity($projectsGenesData);
                    $$projectsGenes = $projectsGenesTable->patchEntity($projectsGenes, $projectsGenesData);
                    $projectsGenesTable->save($projectsGenes);
                }
            }

            if ($kompvialsJobRes) {
                $this->Flash->success(__('The association has been saved.'));
                return $this->redirect(['action' => 'view', 'controller' => 'jobs', $jobId]);
            }
            $this->Flash->error(__('The kompvials job could not be saved. Please, try again.'));
        }

        $this->set(compact('kompvialsJob', 'jobId'));
        $this->set('_serialize', ['kompvialsJob']);
    }


    /**
     * Edit method
     *
     * @param string|null $id Kompvials Job id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kompvialsJob = $this->KompvialsJobs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kompvialsJob = $this->KompvialsJobs->patchEntity($kompvialsJob, $this->request->data);
            if ($this->KompvialsJobs->save($kompvialsJob)) {
                $this->Flash->success(__('The kompvials job has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kompvials job could not be saved. Please, try again.'));
        }
        $this->set(compact('kompvialsJob'));
        $this->set('_serialize', ['kompvialsJob']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Kompvials Job id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $job_id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kompvialsJob = $this->KompvialsJobs->get($id);
        if ($this->KompvialsJobs->delete($kompvialsJob)) {
            $this->Flash->success(__('The kompvials job has been deleted.'));
            return $this->redirect(['action' => 'view', 'controller' => 'jobs', $job_id ]);            
        } else {
            $this->Flash->error(__('The kompvials job could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
