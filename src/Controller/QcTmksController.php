<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QcTmks Controller
 *
 * @property \App\Model\Table\QcTmksTable $QcTmks
 */
class QcTmksController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['InventoryVials', 'Users']
        ];
        $this->set('qcTmks', $this->paginate($this->QcTmks));
        $this->set('_serialize', ['qcTmks']);
    }

    /**
     * View method
     *
     * @param string|null $id Qc Tmk id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qcTmk = $this->QcTmks->get($id, [
            'contain' => ['InventoryVials', 'Users']
        ]);
        $this->set('qcTmk', $qcTmk);
        $this->set('_serialize', ['qcTmk']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($qcID=null)
    {
        $qcTmk = $this->QcTmks->newEntity();
        if ($this->request->is('post')) {
            $qcTmk = $this->QcTmks->patchEntity($qcTmk, $this->request->data);
            if ($this->QcTmks->save($qcTmk)) {
                $this->Flash->success(__('The qc tmk has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc tmk could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcTmks->QualityControls->find('list');
        $inventoryVials = $this->QcTmks->InventoryVials->find('list', ['limit' => 200]);
        $users = $this->QcTmks->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcTmk', 'inventoryVials', 'users', 'qcID', 'qualityControls'));
        $this->set('_serialize', ['qcTmk']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qc Tmk id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qcTmk = $this->QcTmks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qcTmk = $this->QcTmks->patchEntity($qcTmk, $this->request->data);
            if ($this->QcTmks->save($qcTmk)) {
                $this->Flash->success(__('The qc tmk has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc tmk could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcTmks->QualityControls->find('list');
        $inventoryVials = $this->QcTmks->InventoryVials->find('list', ['limit' => 200]);
        $users = $this->QcTmks->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcTmk', 'inventoryVials', 'users', 'qualityControls'));
        $this->set('_serialize', ['qcTmk']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qc Tmk id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qcTmk = $this->QcTmks->get($id);
        if ($this->QcTmks->delete($qcTmk)) {
            $this->Flash->success(__('The qc tmk has been deleted.'));
        } else {
            $this->Flash->error(__('The qc tmk could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
