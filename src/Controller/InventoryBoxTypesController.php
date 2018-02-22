<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InventoryBoxTypes Controller
 *
 * @property \App\Model\Table\InventoryBoxTypesTable $InventoryBoxTypes
 */
class InventoryBoxTypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('inventoryBoxTypes', $this->paginate($this->InventoryBoxTypes));
        $this->set('_serialize', ['inventoryBoxTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Box Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryBoxType = $this->InventoryBoxTypes->get($id, [
            'contain' => ['InventoryBoxes']
        ]);
        $this->set('inventoryBoxType', $inventoryBoxType);
        $this->set('_serialize', ['inventoryBoxType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventoryBoxType = $this->InventoryBoxTypes->newEntity();
        if ($this->request->is('post')) {
            $inventoryBoxType = $this->InventoryBoxTypes->patchEntity($inventoryBoxType, $this->request->data);
            if ($this->InventoryBoxTypes->save($inventoryBoxType)) {
                $this->Flash->success(__('The inventory box type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory box type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('inventoryBoxType'));
        $this->set('_serialize', ['inventoryBoxType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Box Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryBoxType = $this->InventoryBoxTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryBoxType = $this->InventoryBoxTypes->patchEntity($inventoryBoxType, $this->request->data);
            if ($this->InventoryBoxTypes->save($inventoryBoxType)) {
                $this->Flash->success(__('The inventory box type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory box type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('inventoryBoxType'));
        $this->set('_serialize', ['inventoryBoxType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Box Type id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryBoxType = $this->InventoryBoxTypes->get($id);
        if ($this->InventoryBoxTypes->delete($inventoryBoxType)) {
            $this->Flash->success(__('The inventory box type has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory box type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
