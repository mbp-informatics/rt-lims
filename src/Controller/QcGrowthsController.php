<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QcGrowths Controller
 *
 * @property \App\Model\Table\QcGrowthsTable $QcGrowths
 */
class QcGrowthsController extends AppController
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
        $this->set('qcGrowths', $this->paginate($this->QcGrowths));
        $this->set('_serialize', ['qcGrowths']);
    }

    /**
     * View method
     *
     * @param string|null $id Qc Growth id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qcGrowth = $this->QcGrowths->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('qcGrowth', $qcGrowth);
        $this->set('_serialize', ['qcGrowth']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($qcID=null)
    {
        $qcGrowth = $this->QcGrowths->newEntity();
        if ($this->request->is('post')) {
            $qcGrowth = $this->QcGrowths->patchEntity($qcGrowth, $this->request->data);
            if ($this->QcGrowths->save($qcGrowth)) {
                $this->Flash->success(__('The qc growth has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc growth could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcGrowths->QualityControls->find('list');
        $users = $this->QcGrowths->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcGrowth', 'users', 'qcID', 'qualityControls'));
        $this->set('_serialize', ['qcGrowth']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qc Growth id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qcGrowth = $this->QcGrowths->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qcGrowth = $this->QcGrowths->patchEntity($qcGrowth, $this->request->data);
            if ($this->QcGrowths->save($qcGrowth)) {
                $this->Flash->success(__('The qc growth has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc growth could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcGrowths->QualityControls->find('list');
        $users = $this->QcGrowths->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcGrowth', 'users', 'qualityControls'));
        $this->set('_serialize', ['qcGrowth']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qc Growth id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qcGrowth = $this->QcGrowths->get($id);
        if ($this->QcGrowths->delete($qcGrowth)) {
            $this->Flash->success(__('The qc growth has been deleted.'));
        } else {
            $this->Flash->error(__('The qc growth could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
