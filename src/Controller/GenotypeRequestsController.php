<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * GenotypeRequests Controller
 *
 * @property \App\Model\Table\GenotypeRequestsTable $GenotypeRequests
 */
class GenotypeRequestsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Jobs', 'Users']
        ];
        $genotypeRequests = $this->paginate($this->GenotypeRequests);

        $this->set(compact('genotypeRequests'));
        $this->set('_serialize', ['genotypeRequests']);
    }

    /**
     * View method
     *
     * @param string|null $id Genotype Request id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $genotypeRequest = $this->GenotypeRequests->get($id, [
            'contain' => ['Jobs', 'Users', 'Genotypings', 'Genotypings.InventoryLocations', 'Genotypings.InventoryLocations.InventoryBoxes', 'Genotypings.InventoryLocations.InventoryBoxes.InventoryContainers',  'Genotypings.InventoryLocations.InventoryBoxes.InventoryContainers.ParentInventoryContainers',  'Genotypings.InventoryLocations.InventoryBoxes.InventoryContainers.ChildInventoryContainers', 'Genotypings.SpermCryos']
        ]);

        $this->set('genotypeRequest', $genotypeRequest);
        $this->set('_serialize', ['genotypeRequest']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($job_id=null)
    {
        $genotypeRequest = $this->GenotypeRequests->newEntity();
        if ($this->request->is('post')) {
            $genotypeRequest = $this->GenotypeRequests->patchEntity($genotypeRequest, $this->request->data);

            if ($savedRequest = $this->GenotypeRequests->save($genotypeRequest)) {
                $genotypings = TableRegistry::get('Genotypings');
                $entities = $genotypings->newEntities($this->request->data());
                foreach ($entities as $entity) {
                    $entity['genotype_request_id']=$savedRequest['id'];

                    /* Step 1. Get vial information from inventory_vials table */
                    if ($entity['inventory_vial_id']){
                    $this->loadModel('InventoryVials');
                    $inventoryVial = $this->InventoryVials->get($entity['inventory_vial_id'], [
                      'contain' => ['InventoryVialTypes', 
                        'InventoryLocations' => [
                          'InventoryBoxes' => [
                          'InventoryBoxTypes', 'InventoryContainers'
                      ]]]])->toArray();
                    $entity['inventory_location_id'] = $inventoryVial['inventory_location_id'];
                    $entity['vial_label'] = $inventoryVial['label'];
                }

                    $res = $genotypings->save($entity);
                }
                // $this->Flash->success(__('The genotype request has been saved.'));

                return $this->redirect(['controller'=>'GenotypeRequests', 'action' => 'view', $savedRequest->id, '?print']);
            }
            $this->Flash->error(__('The genotype request could not be saved. Please, try again.'));
        }
        $jobs = $this->GenotypeRequests->Jobs->find('list');
        $users = $this->GenotypeRequests->Users->find('list');
        $embryoCryos = $this->GenotypeRequests->Jobs->EmbryoCryos->find('list')->where(['EmbryoCryos.job_id' => $job_id]);
        $spermCryos = $this->GenotypeRequests->Jobs->SpermCryos->find('list')->where(['SpermCryos.job_id' => $job_id]);
        $ivfs = $this->GenotypeRequests->Jobs->ivfs->find('list')->where(['Ivfs.job_id' => $job_id]);
        $this->set(compact('genotypeRequest', 'jobs', 'users', 'job_id', 'ivfs', 'spermCryos', 'embryoCryos'));
        $this->set('_serialize', ['genotypeRequest']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Genotype Request id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $genotypeRequest = $this->GenotypeRequests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $genotypeRequest = $this->GenotypeRequests->patchEntity($genotypeRequest, $this->request->data);
            if ($this->GenotypeRequests->save($genotypeRequest)) {
                $this->Flash->success(__('The genotype request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The genotype request could not be saved. Please, try again.'));
        }
        $jobs = $this->GenotypeRequests->Jobs->find('list', ['limit' => 200]);
        $users = $this->GenotypeRequests->Users->find('list', ['limit' => 200]);
        $this->set(compact('genotypeRequest', 'jobs', 'users'));
        $this->set('_serialize', ['genotypeRequest']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Genotype Request id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $genotypeRequest = $this->GenotypeRequests->get($id);
        if ($this->GenotypeRequests->delete($genotypeRequest)) {
            $this->Flash->success(__('The genotype request has been deleted.'));
        } else {
            $this->Flash->error(__('The genotype request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
