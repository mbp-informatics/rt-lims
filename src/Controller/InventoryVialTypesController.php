<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InventoryVialTypes Controller
 *
 * @property \App\Model\Table\InventoryVialTypesTable $InventoryVialTypes
 */
class InventoryVialTypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('inventoryVialTypes', $this->paginate($this->InventoryVialTypes));
        $this->set('_serialize', ['inventoryVialTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Vial Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryVialType = $this->InventoryVialTypes->get($id, [
            'contain' => ['InventoryVials']
        ]);
        $this->set('inventoryVialType', $inventoryVialType);
        $this->set('_serialize', ['inventoryVialType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventoryVialType = $this->InventoryVialTypes->newEntity();
        if ($this->request->is('post')) {
            $inventoryVialType = $this->InventoryVialTypes->patchEntity($inventoryVialType, $this->request->data);
            if ($this->InventoryVialTypes->save($inventoryVialType)) {
                $this->Flash->success(__('The inventory vial type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory vial type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('inventoryVialType'));
        $this->set('_serialize', ['inventoryVialType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Vial Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryVialType = $this->InventoryVialTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryVialType = $this->InventoryVialTypes->patchEntity($inventoryVialType, $this->request->data);
            if ($this->InventoryVialTypes->save($inventoryVialType)) {
                $this->Flash->success(__('The inventory vial type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory vial type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('inventoryVialType'));
        $this->set('_serialize', ['inventoryVialType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Vial Type id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryVialType = $this->InventoryVialTypes->get($id);
        if ($this->InventoryVialTypes->delete($inventoryVialType)) {
            $this->Flash->success(__('The inventory vial type has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory vial type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
