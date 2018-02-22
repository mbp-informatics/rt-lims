<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InventoryBoxes Controller
 *
 * @property \App\Model\Table\InventoryBoxesTable $InventoryBoxes
 */
class InventoryBoxesController extends AppController
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
    public function index($containerId=null, $ajax=null)
    {
        if (!$this->request->is('json')) {
             $data = $this->InventoryBoxes->find('all')->contain(['InventoryBoxTypes', 'InventoryLocations.InventoryVials', 'InventoryContainers']);
        }                    
        if (isset($containerId)) {
            $data->where(['inventory_container_id = ' => $containerId]);
        }
        if ($ajax) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', json_encode($data));
            $this->render('/Imits/dumpvalues');
        }
        //Prepare DataTables.js view
        if ($this->request->is('json')) {


            $contain = ['InventoryBoxTypes', 'InventoryLocations.InventoryVials', 'InventoryContainers'];
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'InventoryBoxes', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'InventoryBoxes', $contain);
            }

            // process the result set
            foreach ($resp['data'] as $k=>$box) {
                if (isset($box->inventory_box_type)) {
                    $resp['data'][$k]['box_type'] = "<a href='/inventory_box_type/view/{$box->inventory_box_type->id}'>{$box->inventory_box_type->name}</a>";
                }
                if (empty($box->inventory_locations)) {
                    $locInfo = '<small><em>no locations defined</em></small>';
                } else {
                    $totalLoc = count($box->inventory_locations);
                    $emptyLoc = 0;
                    foreach ($box->inventory_locations as $loc) {
                        if ($loc['inventory_vial'] == null) {
                            $emptyLoc++;
                        }
                    }
                    if ($emptyLoc == 0) {
                        $locInfo = '<span style="color:red">'.$emptyLoc . '/' . $totalLoc.'</span> (<small>box full</small>)';
                    } else {
                        $locInfo = '<span style="color:green"><strong>'.$emptyLoc . '/' . $totalLoc. ' avail.</strong></span>';    
                    }
                }
                $resp['data'][$k]['inventory_locations'] = $locInfo;
            }

            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Box id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null, $ajax = null)
    {
        $inventoryBox = $this->InventoryBoxes->get($id, [
            'contain' => ['InventoryLocations.InventoryVials','InventoryLocations.InventoryVials.InventoryVialTypes', 'InventoryContainers', 'InventoryBoxTypes', ]
        ]);

        /* Get Container Hierarchy */
        //First reindex so that array index = container id
        $inventoryContainers = [];
        foreach ($this->InventoryBoxes->InventoryContainers->find('all')->toArray() as $container) {
            $inventoryContainers[$container->id] = $container;
        }
        $parentsArr = $this->Helper->getContainerParents($inventoryBox->inventory_container_id , $inventoryContainers);

        $this->set('inventoryBox', $inventoryBox);
        $this->set('containerHierarchy', $parentsArr);
        $this->set('_serialize', ['inventoryBox']);

        if ($ajax) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', $inventoryBox);
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set('inventoryBox', $inventoryBox);
            $this->set('_serialize', ['inventoryBox']);
        }
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventoryBox = $this->InventoryBoxes->newEntity();

        /* Lets get parents array for every container and create options array for dropdown*/
        $this->loadModel('InventoryContainers');
        $data = $this->InventoryContainers->find('all')->contain(['ChildInventoryContainers', 'ParentInventoryContainers', 'InventoryBoxes']
        )->toArray($this->InventoryContainers->find('all'));
        $ancestryData = $this->Helper->getAncestors($data);
        $containerHierarchyOptions = [];
        foreach ($data as $key => $row) {
            $containerHierarchyOptions[$row->id] = $ancestryData[$row->id]; //$ancestryData[container_id]
        }

        if ($this->request->is('post')) {
            $inventoryBox = $this->InventoryBoxes->patchEntity($inventoryBox, $this->request->data);
            if ($savedBox = $this->InventoryBoxes->save($inventoryBox)) {

                /* Now let's save locations... */
                //Reindexed the array so that array index = box id;
                $newBox = $inventoryBox = $this->InventoryBoxes->get($savedBox->id, [
                            'contain' => [ 'InventoryBoxTypes']
                        ]);
                //Prepare request object to use when saving entities
                $requestData = [];
                $numCells = $newBox->inventory_box_type->num_cells;
                $i = 0;
                for($i; $i < $numCells; $i++ ) {
                    $requestData[] = [
                        'cell' => $i+1,
                        'inventory_box_id' => $savedBox->id
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
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory box could not be saved. Please, try again.'));
            }
        }

        $inventoryContainers = $this->InventoryBoxes->InventoryContainers->find('list')->limit(1024*1024);
        $inventoryBoxTypes = $this->InventoryBoxes->InventoryBoxTypes->find('list');
        $this->set(compact('inventoryBox', 'inventoryContainers', 'inventoryBoxTypes', 'containerHierarchyOptions'));
        $this->set('_serialize', ['inventoryBox']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Box id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryBox = $this->InventoryBoxes->get($id, [
            'contain' => []
        ]);

        /* Lets get parents array for every container and create options array for dropdown*/
        $this->loadModel('InventoryContainers');
        $data = $this->InventoryContainers->find('all')->contain(['ChildInventoryContainers', 'ParentInventoryContainers', 'InventoryBoxes']
        )->toArray($this->InventoryContainers->find('all'));
        $ancestryData = $this->Helper->getAncestors($data);
        $containerHierarchyOptions = [];
        foreach ($data as $key => $row) {
            $containerHierarchyOptions[$row->id] = $ancestryData[$row->id]; //$ancestryData[container_id]
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryBox = $this->InventoryBoxes->patchEntity($inventoryBox, $this->request->data);
            if ($this->InventoryBoxes->save($inventoryBox)) {
                $this->Flash->success(__('The inventory box has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory box could not be saved. Please, try again.'));
            }
        }
	$inventoryContainers = $this->InventoryBoxes->InventoryContainers->find('list');
	$inventoryBoxTypes = $this->InventoryBoxes->InventoryBoxTypes->find('list');
        $this->set(compact('inventoryBox', 'inventoryContainers', 'inventoryBoxTypes', 'containerHierarchyOptions'));
        $this->set('_serialize', ['inventoryBox']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Box id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryBox = $this->InventoryBoxes->get($id);
        if ($this->InventoryBoxes->delete($inventoryBox)) {
            $this->Flash->success(__('The inventory box has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory box could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
