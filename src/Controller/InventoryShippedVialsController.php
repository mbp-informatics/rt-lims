<?php
namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use App\Controller\AppController;

/**
 * InventoryShippedVials Controller
 *
 * @property \App\Model\Table\InventoryShippedVialsTable $InventoryShippedVials
 */
class InventoryShippedVialsController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        //Prepare DataTables.js view
        if ($this->request->is('json')) {

            $contain = ['Jobs', 'InventoryVials'];
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'InventoryShippedVials');
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'InventoryShippedVials');
            }

            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
      }

    /**
     * View method
     *
     * @param string|null $id Inventory Shipped Vial id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryShippedVial = $this->InventoryShippedVials->get($id, [
            'contain' => ['Users']
        ]);

        /**
         * Let's see if this shipped vial original location is vacant.
         * If it is, it means we can restore (unship) this vial.
         * To see if the locatio is empty we're looking at box_id and cell
         * within that box.
         */
        $origVial = unserialize($inventoryShippedVial['original_vial_snapshot']);

        if ($origVial) {
          // First let's get location id for a given original box and cell.
          $this->loadModel('InventoryLocations');
          $originalLocationId = $this->InventoryLocations
            ->find()
            ->where(['inventory_box_id' => $origVial['inventory_location']['inventory_box_id']])
            ->andWhere(['cell' => $origVial['inventory_location']['cell']])
            ->first()
            ->toArray()['id'];

          // Now let's check if this location is vacant
          $this->loadModel('InventoryVials');
          $originalLocationTakenBy = $this->InventoryVials
            ->find()
            ->where(['inventory_location_id' => $originalLocationId])
            ->first();
        } else {
          $originalLocationTakenBy = Null;
        }

        $this->set('originalLocationTakenBy', $originalLocationTakenBy);
        $this->set('inventoryShippedVial', $inventoryShippedVial);
        $this->set('_serialize', ['inventoryShippedVial']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($vialId=null, $locationId=null)
    {
      $conn = ConnectionManager::get('default');
      $conn->transactional(function ($conn) use ($vialId, $locationId) { //let's do all this as one transaction

        $inventoryShippedVial = $this->InventoryShippedVials->newEntity();
        if ($this->request->is('post')) {
            /**
              * When a vial is shiped, the following logic is put in place: the vial is
              * copied to inventory_shipped_vials table. The snapshot of other tables
              * related to inventory_vials (such as inventory_locations, intentory boxes... see
              * 'contain' below) is saved to inventory_vials_shipped as serialized data. Finally,
              * the original entry from ivnentory_vials table is deleted
              *  - Tomek, 10/3/2016
              */

            /* Step 1. Get vial information from inventory_vials table */
            $this->loadModel('InventoryVials');
            $inventoryVial = $this->InventoryVials->get($vialId, [
              'contain' => ['InventoryVialTypes', 
                'InventoryLocations' => [
                  'InventoryBoxes' => [
                  'InventoryBoxTypes', 'InventoryContainers'
              ]]]])->toArray();

            $inventoryVial['original_vial_id_no'] = $inventoryVial['id'];
            $inventoryVial['original_location_id_no'] = $inventoryVial['inventory_location_id'];
            $inventoryVial['original_vial_type_id_no'] = $inventoryVial['inventory_vial_type_id'];
            $inventoryVial['original_created'] = $inventoryVial['created'];
            $inventoryVial['original_modified'] = $inventoryVial['modified'];
            $inventoryVial['sperm_cryo_id'] = $inventoryVial['sperm_cryo_id'];
            $inventoryVial['embryo_cryo_id'] = $inventoryVial['embryo_cryo_id'];
            $inventoryVial['es_cell_id'] = $inventoryVial['es_cell_id'];
            $inventoryVial['original_vial_snapshot'] = serialize($inventoryVial);
            $inventoryVial['comments'] = $this->request->data['comments'];
            $inventoryVial['order_no'] = $this->request->data['order_no'];
            $inventoryVial['ship_thaw_date'] = $this->request->data['ship_thaw_date'];
            $inventoryVial['ship_thaw_reason'] = $this->request->data['ship_thaw_reason'];
            $inventoryVial['user_id'] = $this->request->data['user_id'];
            $inventoryVial['pups'] = $inventoryVial['pups'];
            $inventoryVial['qc_pass'] = $inventoryVial['qc_pass'];
            $inventoryVial['do_not_distribute'] = $inventoryVial['do_not_distribute'];
            unset($inventoryVial['id']);
            unset($inventoryVial['inventory_location_id']);
            unset($inventoryVial['created']);
            unset($inventoryVial['modified']);
            unset($inventoryVial['id']);
            unset($inventoryVial['inventory_location']);
            unset($inventoryVial['inventory_vial_type_id']);
            unset($inventoryVial['inventory_vial_type']);

            /* Step 2. Insert vial information into inventory_shipped_vials table */
            $this->loadModel('InventoryShippedVials');
            $InventoryShippedVial = $this->InventoryShippedVials->newEntity();
            $InventoryShippedVial = $this->InventoryShippedVials->patchEntity($InventoryShippedVial, $inventoryVial);
            $success = $this->InventoryShippedVials->save($InventoryShippedVial);

            $newVialId = $success->id;
            if ($success->sperm_cryo_id){
              $sc_id = $success->sperm_cryo_id;
            } elseif ($success->embryo_cryo_id){
              $ec_id = $success->embryo_cryo_id;
            } elseif ($success->es_cell_id){
              $esc_id = $success->es_cell_id;
            }

            if (!$success) {
                $this->Flash->error(__('Could not save data to inventory_shipped_vials table. Vial has NOT been shipped. Aborting.'));
                return $this->redirect(['action' => 'add', $vialId, $locationId]);
            }

            /* Now we can delete the original entry from inventory_vials */
            $inventoryVial = $this->InventoryVials->get($vialId);
            $success = $this->InventoryVials->delete($inventoryVial);
            if (!$success) {
                $this->Flash->error(__('The inventory vial could not be deleted from inventory_vials table. Please delete manually.'));
            }

            /* Finally let's redirect to the newly created shipping */
            $this->Flash->success(__('The vial has been shipped successfully.'));
            if (isset($sc_id)) {
              return $this->redirect(['controller' => 'SpermCryos', 'action' => 'view', $sc_id]);
            } elseif (isset($ec_id)) {
              return $this->redirect(['controller' => 'EmbryoCryos', 'action' => 'view', $ec_id]); 
            } elseif (isset($esc_id)) {
              return $this->redirect(['controller' => 'EsCells', 'action' => 'view', $esc_id]); 
            } else {
              return $this->redirect(['action' => 'view', $newVialId]);
            } 
        }

        $this->set('inventoryShippedVial', $inventoryShippedVial);
        $this->set('_serialize', ['inventoryShippedVial']);
      }); //end transactional closure
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Shipped Vial id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryShippedVial = $this->InventoryShippedVials->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryShippedVial = $this->InventoryShippedVials->patchEntity($inventoryShippedVial, $this->request->data);
            if ($this->InventoryShippedVials->save($inventoryShippedVial)) {
                $this->Flash->success(__('The inventory shipped vial has been saved.'));
                return $this->redirect(['action' => 'view', $inventoryShippedVial->id]);
            } else {
                $this->Flash->error(__('The inventory shipped vial could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('inventoryShippedVial'));
        $this->set('_serialize', ['inventoryShippedVial']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Shipped Vial id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryShippedVial = $this->InventoryShippedVials->get($id);
        if ($this->InventoryShippedVials->delete($inventoryShippedVial)) {
            $this->Flash->success(__('The inventory shipped vial has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory shipped vial could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
