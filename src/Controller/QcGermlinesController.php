<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QcGermlines Controller
 *
 * @property \App\Model\Table\QcGermlinesTable $QcGermlines
 */
class QcGermlinesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $this->set('qcGermlines', $this->paginate($this->QcGermlines));
        $this->set('_serialize', ['qcGermlines']);
    }

    /**
     * View method
     *
     * @param string|null $id Qc Germline id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qcGermline = $this->QcGermlines->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('qcGermline', $qcGermline);
        $this->set('_serialize', ['qcGermline']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($qcID=null)
    {
        $qcGermline = $this->QcGermlines->newEntity();
        if ($this->request->is('post')) {
            $qcGermline = $this->QcGermlines->patchEntity($qcGermline, $this->request->data);
            if ($this->QcGermlines->save($qcGermline)) {
                $this->Flash->success(__('The qc germline has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc germline could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcGermlines->QualityControls->find('list');
        $users = $this->QcGermlines->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcGermline', 'users', 'qcID', 'qualityControls'));
        $this->set('_serialize', ['qcGermline']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qc Germline id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qcGermline = $this->QcGermlines->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qcGermline = $this->QcGermlines->patchEntity($qcGermline, $this->request->data);
            if ($this->QcGermlines->save($qcGermline)) {
                $this->Flash->success(__('The qc germline has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc germline could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcGermlines->QualityControls->find('list');
        $users = $this->QcGermlines->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcGermline', 'users', 'qualityControls'));
        $this->set('_serialize', ['qcGermline']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qc Germline id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qcGermline = $this->QcGermlines->get($id);
        if ($this->QcGermlines->delete($qcGermline)) {
            $this->Flash->success(__('The qc germline has been deleted.'));
        } else {
            $this->Flash->error(__('The qc germline could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
