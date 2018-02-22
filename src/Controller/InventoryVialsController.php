<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * InventoryVials Controller
 *
 * @property \App\Model\Table\InventoryVialsTable $InventoryVials
 */
class InventoryVialsController extends AppController
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
    public function index($ajax=null)
    {
        if ($ajax) { //dump data in JSON format
            $data = $this->InventoryVials->find('all')->contain(['InventoryVialTypes']);
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', json_encode($data));
            $this->render('/Imits/dumpvalues');
        }

        //Prepare DataTables.js view
        if ($this->request->is('json')) {

            $contain = ['InventoryVialTypes'];
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'InventoryVials', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'InventoryVials', $contain);
            }

            // process the result set
            foreach ($resp['data'] as $k=>$vial) {
                if (isset($vial->inventory_vial_type)) {
                    $resp['data'][$k]['inventory_vial_type'] = "<a href='/inventory-vial-types/view/{$vial->inventory_vial_type->id}'>{$vial->inventory_vial_type->name}</a>";
                }
                $resp['data'][$k]['ec_sc'] = '';
                if (isset($vial->sperm_cryo_id)) {
                    $resp['data'][$k]['ec_sc'] = 'Sperm';
                }
                if (isset($vial->embryo_cryo_id)) {
                    $resp['data'][$k]['ec_sc'] = 'Embryo';
                }
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Vial id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null, $ajax = null)
    {
        $inventoryVial = $this->InventoryVials->get($id, [
            'contain' => ['EsCells', 'SpermCryos', 'EmbryoCryos', 'InventoryVialTypes', 
            'InventoryLocations' => [
                'InventoryBoxes' => [
                    'InventoryBoxTypes', 'InventoryContainers'
                ] 
            ]
        ]
        ]);

        /* Get Container Hierarchy */
        //First reindex so that array index = container id. Only does this if inventory_location is present
        if ($inventoryVial['inventory_location']) {
            $inventoryContainers = [];
            foreach ($this->InventoryVials->InventoryLocations->InventoryBoxes->InventoryContainers->find('all')->toArray() as $container) {
                $inventoryContainers[$container->id] = $container;
            }
            $parentsArr = $this->Helper->getContainerParents($inventoryVial->inventory_location->inventory_box->inventory_container_id , $inventoryContainers);            
        } else {
            $parentsArr = null;
        }


        $this->set('inventoryVial', $inventoryVial);
        $this->set('containerHierarchy', $parentsArr);
        $this->set('_serialize', ['inventoryVial']);
    }

    /**
     * Add multiple vials method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($cryoId, $cryoType)
    {
        $inventoryVial = $this->InventoryVials->newEntity();
        
        /* SAVE ENTRY TO DB */
        if ($this->request->is('post')) {
            debug($this->request->data);

            /* Patch request data with $cryoId */
            if ($cryoType == 'sperm') {
                foreach ($this->request->data as $key => $vial) {
                   $this->request->data[$key]['sperm_cryo_id'] = $cryoId;
                }  
            } elseif ($cryoType == 'embryo') {
                foreach ($this->request->data as $key => $vial) {
                   $this->request->data[$key]['embryo_cryo_id'] = $cryoId;
                }  
            } elseif ($cryoType == 'escell') {
                foreach ($this->request->data as $key => $vial) {
                   $this->request->data[$key]['komp_clone_id'] = $cryoId;
                   $this->request->data[$key]['es_cell']['komp_clones_dump_id'] = $cryoId;
                }  
            }
            /* Save multiple vials */ 
            $inventoryVials = TableRegistry::get('InventoryVials');
            if ($cryoType == 'escell') {
                $entities = $inventoryVials->newEntities($this->request->data(), ['associated' => ['EsCells']]);
            } else {
                $entities = $inventoryVials->newEntities($this->request->data());
            }

            foreach ($entities as $entity) {
                $res = $inventoryVials->save($entity);
                if ($res) {
                    $this->Flash->success(__('The inventory vial id:'.$res['id'].' has been saved.'));

                    /**
                     * Successfully saved the vial, so now
                     * let's check if it was a 'restore vial' action
                     * and let' delete the shipped vial if needed.
                    */
                    if (isset($entity->shipped_vial_id) && !empty($entity->shipped_vial_id))
                    {
                        $this->loadModel('InventoryShippedVials');
                        $inventoryShippedVial = $this->InventoryShippedVials->get($entity->shipped_vial_id);
                        if (!$this->InventoryShippedVials->delete($inventoryShippedVial))
                        {
                            $this->Flash->error(__("Could not delete shipped vial id: {$entity->shipped_vial_id}"));
                        }
                    }

                } else {
                    $this->Flash->error(__('The inventory vial could not be saved. Please, try again.'));
                }
            }

            if ($cryoType == 'sperm') {
                return $this->redirect(['controller' => 'SpermCryos', 'action' => 'view', $cryoId]);
            } elseif ($cryoType == 'embryo') {
                return $this->redirect(['controller' => 'EmbryoCryos', 'action' => 'view', $cryoId]); 
            } elseif ($cryoType == 'escell') {
                return $this->redirect(['controller' => 'KompClonesDump', 'action' => 'view', $cryoId]); 
            } 
        } //end SAVE ENTRY TO DB
        
        /* Prepare containers dropdown (including hierarchy) */
        $this->loadModel('InventoryContainers');

        //First reindex so that array index = container id
        $inventoryContainers = $this->Helper->reindexArr($this->InventoryContainers->find('all')->toArray());
        
        //Then grab containers hierarchy
        $containersDropdown = [];
        foreach ($inventoryContainers as $container) {
            if ($parentsArr = $this->Helper->getContainerParents($container->id, $inventoryContainers)) { //thare are some parrents
                array_unshift($parentsArr, $container);
            } else {
                $parentsArr[] = $container; //no parents found
            }
            $containersDropdown[$container->id] = $parentsArr;
        }

        //If ES Cell, grab other vials from that clone that could be the parent
        if ($cryoType == 'escell') {
                $parentClones=$this->InventoryVials->find('list', ['conditions' => ['komp_clone_id' => $cryoId ]]);
            } else{
                $parentClones = Null;
            }

        $inventoryVialTypes = $this->InventoryVials->InventoryVialTypes->find('list');
        $this->set([
            'inventoryVial' => $inventoryVial,
            'inventoryVialTypes' => $inventoryVialTypes,
            'cryoId' => $cryoId,
            'inventoryContainers' => $containersDropdown,
            'cryoType' => $cryoType,
            'parentClones' => $parentClones
            ]);
        $this->set('_serialize', ['inventoryVial']);
    }

    /**
     * Add a single vial method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addSingle($locationId, $cryoId=Null)
    {
        $inventoryVial = $this->InventoryVials->newEntity();

        $inventoryVialTypes = $this->InventoryVials->InventoryVialTypes->find('list');
        $spermCryos = $this->InventoryVials->SpermCryos->find('list');
        $embryoCryos = $this->InventoryVials->EmbryoCryos->find('list');
        $esCells = $this->InventoryVials->EsCells->find('list');
        $parentClones=$this->InventoryVials->find('list', ['conditions' => ['komp_clone_id' => $cryoId ]]); // for es cells

        if ($this->request->is('post')) {
            $inventoryVial = $this->InventoryVials->patchEntity($inventoryVial, $this->request->data);
            if ($res = $this->InventoryVials->save($inventoryVial)) {
                $this->Flash->success(__('The inventory vial has been saved. Vial id:' . $res['id']));
            } else {
                $this->Flash->error(__('The inventory vial could not be saved. Please, try again.'));
            }
            $table = $this->loadModel('inventoryLocations');
            $inventoryLocation = $table->get($this->request->data['inventory_location_id']);
            return $this->redirect(['controller' => 'inventoryBoxes' , 'action' => 'view', $inventoryLocation->inventory_box_id, '#' => 'freezer-view']);
        } //end if post

        $this->set(compact('inventoryVial', 'inventoryVialTypes', 'locationId', 'inventoryLocations', 'spermCryos', 'inventoryLocation', 'embryoCryos', 'esCells', 'parentClones'));
        $this->set('_serialize', ['inventoryVial']);
    }


    /**
     * Edit method
     *
     * @param string|null $id Inventory Vial id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $ajax=null)
    {
        $inventoryVial = $this->InventoryVials->get($id, [
            'contain' => ['SpermCryos', 'EmbryoCryos', 'InventoryVialTypes', 'EsCells',
            'InventoryLocations' => [
                'InventoryBoxes' => [
                    'InventoryBoxTypes', 'InventoryContainers'
                ] 
            ]
        ]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryVial = $this->InventoryVials->patchEntity($inventoryVial, $this->request->data);
            if ($this->InventoryVials->save($inventoryVial)) {
                if (!$ajax) {
                    $this->Flash->success(__('The inventory vial has been saved.'));
                    return $this->redirect(['action' => 'view', $id]);
                }
                $status = 1;
            } else {
                if (!$ajax) {
                    $this->Flash->error(__('The inventory vial could not be saved. Please, try again.'));
                    return $this->redirect(['action' => 'view', $id]);
                }
                $status = 0;
            }
        }
        $locationId = $inventoryVial->inventory_location_id;
        $inventoryVialTypes = $this->InventoryVials->InventoryVialTypes->find('list');
        $inventoryLocations = $this->InventoryVials->InventoryLocations->find('list');
        $spermCryos = $this->InventoryVials->SpermCryos->find('list');
        $embryoCryos = $this->InventoryVials->EmbryoCryos->find('list');
        $esCells = $this->InventoryVials->EsCells->find('list');
        $parentClones=$this->InventoryVials->find('list', ['conditions' => ['komp_clone_id' => $id ]]);
        // $inventoryVialLoc = $this->InventoryVials->get($id,
        if ($inventoryVial['inventory_location']) {
            $invLoc=$this->InventoryVials->InventoryLocations->get($locationId);
            $boxId = $invLoc->inventory_box_id;
            $invBox=$this->InventoryVials->InventoryLocations->InventoryBoxes->get($boxId);
            $invContainerId = $invBox->inventory_container_id;

            $boxesDropdown = $this->InventoryVials->InventoryLocations->InventoryBoxes->find('list', ['conditions' => ['inventory_container_id' => $invContainerId ]]);
            $locationsDropdown = $this->InventoryVials->InventoryLocations->find('list', ['conditions' => ['inventory_box_id' => $boxId ]]);
        } else {
            $invContainerId = Null;
            $boxId = Null;

            $boxesDropdown = $this->InventoryVials->InventoryLocations->InventoryBoxes->find('list');
            $locationsDropdown = $this->InventoryVials->InventoryLocations->find('list');            
        }

        /* Prepare containers dropdown (including hierarchy) */
        $this->loadModel('InventoryContainers');

        //First reindex so that array index = container id
        $inventoryContainers = $this->Helper->reindexArr($this->InventoryContainers->find('all')->toArray());
        
        //Then grab containers hierarchy
        $containersDropdown = [];
        foreach ($inventoryContainers as $container) {
            if ($parentsArr = $this->Helper->getContainerParents($container->id, $inventoryContainers)) { //there are some parents
                array_unshift($parentsArr, $container);
            } else {
                $parentsArr[] = $container; //no parents found
            }
            $containersDropdown[$container->id] = $parentsArr;
        }
        $inventoryContainers = $containersDropdown;

        if ($ajax) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', $status);
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set(compact('inventoryVial', 'inventoryVialTypes', 'inventoryLocations', 'inventoryContainers', 'spermCryos', 'embryoCryos', 'esCells', 'parentClones', 'locationId', 'boxId', 'invContainerId', 'boxesDropdown', 'locationsDropdown'));
            $this->set('_serialize', ['inventoryVial']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Vial id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null, $type = null, $recId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryVial = $this->InventoryVials->get($id);
        if ($this->InventoryVials->delete($inventoryVial)) {
            $this->Flash->success(__('The inventory vial has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory vial could not be deleted. Please, try again.'));
        }
        if ($type == 'embryo') {
            return $this->redirect(['controller' => 'EmbryoCryos', 'action' => 'view', $recId]);
        }
        else if ($type == 'sperm'){
            return $this->redirect(['controller' => 'SpermCryos', 'action' => 'view', $recId]);
        }
        else {
            return $this->redirect(['action' => 'index']);
        }
    }

  /**
     * Add Ajax method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function ajax($spermCryoId=Null)
    {
        if (!$this->request->is('json')) {
            // $conn = ConnectionManager::get('default');
            // $data = $conn->execute('SELECT * FROM  inventory_vials WHERE sperm_cryo_id = :sperm_cryo_id AND tissue=1', ['sperm_cryo_id' =>$spermCryoId]);
            $data = $this->InventoryVials->find('all')->where(['sperm_cryo_id' => $spermCryoId])->andWhere(['tissue' => 1]);
        }

        if ($data) {
            $this->viewBuilder()->layout(''); // get rid of the layout (skip header, footer, navbar)
            $this->set('value', json_encode($data));
            $this->render('/Imits/dumpvalues');
        }
    }
}
