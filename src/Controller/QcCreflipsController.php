<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QcCreflips Controller
 *
 * @property \App\Model\Table\QcCreflipsTable $QcCreflips
 */
class QcCreflipsController extends AppController
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
        $this->set('qcCreflips', $this->paginate($this->QcCreflips));
        $this->set('_serialize', ['qcCreflips']);
    }

    /**
     * View method
     *
     * @param string|null $id Qc Creflip id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qcCreflip = $this->QcCreflips->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('qcCreflip', $qcCreflip);
        $this->set('_serialize', ['qcCreflip']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $qcCreflip = $this->QcCreflips->newEntity();
        if ($this->request->is('post')) {
            $qcCreflip = $this->QcCreflips->patchEntity($qcCreflip, $this->request->data);
            if ($this->QcCreflips->save($qcCreflip)) {
                $this->Flash->success(__('The qc creflip has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc creflip could not be saved. Please, try again.'));
            }
        }
        $users = $this->QcCreflips->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcCreflip', 'users'));
        $this->set('_serialize', ['qcCreflip']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qc Creflip id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qcCreflip = $this->QcCreflips->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qcCreflip = $this->QcCreflips->patchEntity($qcCreflip, $this->request->data);
            if ($this->QcCreflips->save($qcCreflip)) {
                $this->Flash->success(__('The qc creflip has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc creflip could not be saved. Please, try again.'));
            }
        }
        $users = $this->QcCreflips->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcCreflip', 'users'));
        $this->set('_serialize', ['qcCreflip']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qc Creflip id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qcCreflip = $this->QcCreflips->get($id);
        if ($this->QcCreflips->delete($qcCreflip)) {
            $this->Flash->success(__('The qc creflip has been deleted.'));
        } else {
            $this->Flash->error(__('The qc creflip could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
