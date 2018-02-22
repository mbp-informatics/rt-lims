<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InventoryLocations Controller
 *
 * @property \App\Model\Table\InventoryLocationsTable $InventoryLocations
 */
class InventoryLocationsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Helper');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ($param = isset($this->request->query['s']) ? $this->request->query['s'] : Null ) {
            $cond = $this->Search->getSearchConditions($param, $this);
            $indexSet = $this->InventoryLocations->find('all', $cond)->contain(['InventoryBoxes.InventoryContainers']);
        } else {
            $indexSet = $this->InventoryLocations->find('all')->contain(['InventoryBoxes.InventoryContainers']);
        }
        $indexSet = $this->paginate($indexSet);
        $indexSet = $indexSet->toArray();


        /* Lets get parents array for every row and include it in the result set */
        $this->loadModel('InventoryContainers');
        $data = $this->InventoryContainers->find('all')->contain(['ChildInventoryContainers', 'ParentInventoryContainers', 'InventoryBoxes']
        )->toArray();

        $ancestryData = $this->Helper->getAncestors($data);
        foreach ($indexSet as $key => $row) {
            $indexSet[$key]['parents'] = $ancestryData[$row->inventory_box->inventory_container_id];
           
        }

        $this->set('inventoryLocations', $indexSet);
        $this->set('_serialize', ['inventoryLocations']);
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Location id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryLocation = $this->InventoryLocations->get($id, [
            'contain' => ['InventoryBoxes', 'InventoryVials']
        ]);

        $this->set('inventoryLocation', $inventoryLocation);
        $this->set('_serialize', ['inventoryLocation']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventoryLocation = $this->InventoryLocations->newEntity();

        /* Lets get parents array for every container and create options array for dropdown*/
        $this->loadModel('InventoryBoxes');
        $inventoryBoxes = $this->InventoryBoxes->find('all')->contain(['InventoryLocations.InventoryVials', 'InventoryContainers', 'InventoryBoxTypes'])->toArray();
        $this->loadModel('InventoryContainers');
        $inventoryContainers = $this->InventoryContainers->find('all')->contain(['ChildInventoryContainers', 'ParentInventoryContainers', 'InventoryBoxes'])->toArray($this->InventoryContainers->find('all'));
        $data = $inventoryContainers;
        $ancestryData = $this->Helper->getAncestors($data);
        $containerHierarchyOptions = [];
        $tmpInventoryBoxes = [];
        foreach ($inventoryBoxes as $key => $row) {
            $containerHierarchyOptions[$row->id] = $ancestryData[$row->inventory_container_id]; //$ancestryData[container_id]
            $tmpInventoryBoxes[$row->id] = $row; //reindexed the array so that array index = box id;
        }
        $inventoryBoxes = $tmpInventoryBoxes;

        if ($this->request->is('post')) {
            $inventoryLocation = $this->InventoryLocations->patchEntity($inventoryLocation, $this->request->data);
            if ($newLoc = $this->InventoryLocations->save($inventoryLocation)) {
                $this->Flash->success(__('The inventory location has been saved.'));
                return $this->redirect(['action' => 'view', $newLoc->id]);
            } else {
                $this->Flash->error(__('The inventory location could not be saved. Please, try again.'));
            }
        }
        
        $inventoryContainers = $this->InventoryContainers->find('list')->toArray();
        $this->set(compact('inventoryLocation', 'inventoryBoxes', 'inventoryVials', 'containerHierarchyOptions', 'inventoryContainers'));
        $this->set('_serialize', ['inventoryLocation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Location id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryLocation = $this->InventoryLocations->get($id, [
            'contain' => []
        ]);

        /* Lets get parents array for every container and create options array for dropdown*/
        $this->loadModel('InventoryBoxes');
        $inventoryBoxes = $this->InventoryBoxes->find('all')->contain(['InventoryLocations.InventoryVials', 'InventoryContainers', 'InventoryBoxTypes'])->toArray();

        $this->loadModel('InventoryContainers');
        $inventoryContainers = $this->InventoryContainers->find('all')->contain(['ChildInventoryContainers', 'ParentInventoryContainers', 'InventoryBoxes'])->toArray($this->InventoryContainers->find('all'));

        $data = $inventoryContainers;
        $ancestryData = $this->Helper->getAncestors($data);
        $containerHierarchyOptions = [];
        $tmpInventoryBoxes = [];
        foreach ($inventoryBoxes as $key => $row) {
            $containerHierarchyOptions[$row->id] = $ancestryData[$row->inventory_container_id]; //$ancestryData[container_id]
            $tmpInventoryBoxes[$row->id] = $row; //reindexed the array so that array index = box id;
        }
        $inventoryBoxes = $tmpInventoryBoxes;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryLocation = $this->InventoryLocations->patchEntity($inventoryLocation, $this->request->data);
            if ($this->InventoryLocations->save($inventoryLocation)) {
                $this->Flash->success(__('The inventory location has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory location could not be saved. Please, try again.'));
            }
        }
        
        $inventoryContainers = $this->InventoryContainers->find('list')->toArray();
        $this->set(compact('inventoryLocation', 'inventoryBoxes', 'inventoryVials', 'containerHierarchyOptions', 'inventoryContainers'));
        $this->set('_serialize', ['inventoryLocation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Location id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryLocation = $this->InventoryLocations->get($id);
        if ($this->InventoryLocations->delete($inventoryLocation)) {
            $this->Flash->success(__('The inventory location has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory location could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
