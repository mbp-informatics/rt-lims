<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InventoryContainers Controller
 *
 * @property \App\Model\Table\InventoryContainersTable $InventoryContainers
 */
class InventoryContainersController extends AppController
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
        $data = $this->InventoryContainers->find('all')->contain(['ChildInventoryContainers', 'ParentInventoryContainers', 'InventoryBoxes']
        )->toArray($this->InventoryContainers->find('all'));
   
        /* Lets get parents array for every row and include it in the result set */
        $indexSet = $data;
        $ancestryData = $this->Helper->getAncestors($data);
        foreach ($indexSet as $key => $row) {
            $indexSet[$key]['parents'] = $ancestryData[$row->id];
           
        }
        $this->set('inventoryContainers', $indexSet);
        $this->set('_serialize', ['inventoryContainers']);
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Container id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryContainer = $this->InventoryContainers->get($id, [
            'contain' => ['ChildInventoryContainers', 'ParentInventoryContainers', 'InventoryBoxes', 'InventoryBoxes.InventoryBoxTypes', 'InventoryBoxes.InventoryLocations', 'InventoryBoxes.InventoryLocations.InventoryVials']
        ]);


        $family = $this->InventoryContainers->find('threaded');
        $descendants = $this->Helper->getChildrenFor($family, $inventoryContainer->id);


        $this->set('inventoryContainer', $inventoryContainer);
        $this->set('descendants', $descendants);
        $this->set('family', $family);
        $this->set('_serialize', ['inventoryContainer']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventoryContainer = $this->InventoryContainers->newEntity();

        /* Lets get parents array for every container and create options array for dropdown*/
        $data = $this->InventoryContainers->find('all')->contain(['ChildInventoryContainers', 'ParentInventoryContainers', 'InventoryBoxes']
        )->toArray($this->InventoryContainers->find('all'));
        $ancestryData = $this->Helper->getAncestors($data);
        $containerHierarchyOptions = [];
        foreach ($data as $key => $row) {
            $containerHierarchyOptions[$row->id] = $ancestryData[$row->id]; //$ancestryData[container_id]
        }

        if ($this->request->is('post')) {
            $inventoryContainer = $this->InventoryContainers->patchEntity($inventoryContainer, $this->request->data);
            if ($this->InventoryContainers->save($inventoryContainer)) {
                $this->Flash->success(__('The inventory container has been saved.'));
                return $this->redirect(['action' => 'view', $inventoryContainer->id]);
            } else {
                $this->Flash->error(__('The inventory container could not be saved. Please, try again.'));
            }
        }
        $inventoryContainers = $this->InventoryContainers->find('list');
        $this->set(compact('inventoryContainer', 'inventoryContainers', 'containerHierarchyOptions'));
        $this->set('_serialize', ['inventoryContainer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Container id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryContainer = $this->InventoryContainers->get($id, [
            'contain' => ['ChildInventoryContainers', 'ParentInventoryContainers', 'InventoryBoxes']
        ]);

        /* Lets get parents array for every container and create options array for dropdown*/
        $data = $this->InventoryContainers->find('all')->contain(['ChildInventoryContainers', 'ParentInventoryContainers', 'InventoryBoxes']
        )->toArray($this->InventoryContainers->find('all'));
        $ancestryData = $this->Helper->getAncestors($data);
        $containerHierarchyOptions = [];
        foreach ($data as $key => $row) {
            $containerHierarchyOptions[$row->id] = $ancestryData[$row->id]; //$ancestryData[container_id]
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryContainer = $this->InventoryContainers->patchEntity($inventoryContainer, $this->request->data);
            if ($this->InventoryContainers->save($inventoryContainer)) {
                $this->Flash->success(__('The inventory container has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory container could not be saved. Please, try again.'));
            }
        }
        $inventoryContainers = $this->InventoryContainers->find('list')->toArray();
        unset($inventoryContainers[$id]); //do not include container being edited in the dropdown, otherwise you'd be able to select itself as a parent and cause infinite loop
        $this->set(compact('inventoryContainer', 'inventoryContainers', 'containerHierarchyOptions'));
        $this->set('_serialize', ['inventoryContainer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Container id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryContainer = $this->InventoryContainers->get($id);
        if ($this->InventoryContainers->delete($inventoryContainer)) {
            $this->Flash->success(__('The inventory container has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory container could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function addWedges($id)
    {
        $wedgeNames = ['Wedge 1- Black', 'Wedge 2- Red', 'Wedge 3- Grey', 'Wedge 4- Pink', 'Wedge 5- Orange', 'Wedge 6- Yellow', 'Wedge 7- Purple', 'Wedge 8- Pistachio', 'Wedge 9- Blue', 'Wedge 10- Brown', 'Wedge 11- Green', 'Wedge 12- Center'];

        foreach ($wedgeNames as $name) {
            $requestData[] = [
                'name' => $name,
                'inventory_container_id' => $id,
                'inventory_box_type_id' => '3',
                'user_id' => $this->request->session()->read('Auth.User.id'),
            ];            
        }

        //Now save entities
        $inventoryBoxes = $this->loadModel('InventoryBoxes');
        $entities = $this->InventoryBoxes->newEntities($requestData);
        $inventoryBoxes->connection()->transactional(function () use ($inventoryBoxes, $entities) { //Treat saving all entities as single transaction
            foreach ($entities as $ent) {
                if(!$inventoryBoxes->save($ent) ) {
                    $this->Flash->error(__('Wedges could not be saved. Please add them manually.'));
                } else {
                    /* Now let's save locations... */
                    //Prepare request object to use when saving entities
                    $requestData = [];
                    $numCells = 33;
                    $i = 0;
                    for($i; $i < $numCells; $i++ ) {
                        $requestData[] = [
                            'cell' => $i+1,
                            'inventory_box_id' => $ent->id
                        ];
                    }
                    //Now save entities
                    $inventoryLocations = $this->loadModel('InventoryLocations');
                    $entities = $this->InventoryLocations->newEntities($requestData);
                    $inventoryLocations->connection()->transactional(function () use ($inventoryLocations, $entities) { //Treat saving all entities as single transaction
                        foreach ($entities as $ent) {
                            if(!$inventoryLocations->save($ent) ) {
                                 $this->Flash->error(__('Locations could not be saved. Please add them manually.'));
                            }
                        }
                    });     
                    $this->Flash->success(__('The inventory box has been saved.'));
                    
                } 
            }
        }); 
    return $this->redirect(['controller'=>'InventoryContainers', 'action' => 'view', $id]);
    }
}
