<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QcKaryotypes Controller
 *
 * @property \App\Model\Table\QcKaryotypesTable $QcKaryotypes
 */
class QcKaryotypesController extends AppController
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
        $this->set('qcKaryotypes', $this->paginate($this->QcKaryotypes));
        $this->set('_serialize', ['qcKaryotypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Qc Karyotype id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qcKaryotype = $this->QcKaryotypes->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('qcKaryotype', $qcKaryotype);
        $this->set('_serialize', ['qcKaryotype']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($qcID=null)
    {
        $qcKaryotype = $this->QcKaryotypes->newEntity();
        if ($this->request->is('post')) {
            $qcKaryotype = $this->QcKaryotypes->patchEntity($qcKaryotype, $this->request->data);
            if ($this->QcKaryotypes->save($qcKaryotype)) {
                $this->Flash->success(__('The qc karyotype has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc karyotype could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcKaryotypes->QualityControls->find('list');
        $users = $this->QcKaryotypes->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcKaryotype', 'users', 'qcID', 'qualityControls'));
        $this->set('_serialize', ['qcKaryotype']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qc Karyotype id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qcKaryotype = $this->QcKaryotypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qcKaryotype = $this->QcKaryotypes->patchEntity($qcKaryotype, $this->request->data);
            if ($this->QcKaryotypes->save($qcKaryotype)) {
                $this->Flash->success(__('The qc karyotype has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc karyotype could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcKaryotypes->QualityControls->find('list');
        $users = $this->QcKaryotypes->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcKaryotype', 'users', 'qualityControls'));
        $this->set('_serialize', ['qcKaryotype']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qc Karyotype id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qcKaryotype = $this->QcKaryotypes->get($id);
        if ($this->QcKaryotypes->delete($qcKaryotype)) {
            $this->Flash->success(__('The qc karyotype has been deleted.'));
        } else {
            $this->Flash->error(__('The qc karyotype could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
