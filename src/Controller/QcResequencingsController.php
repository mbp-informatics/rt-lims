<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QcResequencings Controller
 *
 * @property \App\Model\Table\QcResequencingsTable $QcResequencings
 */
class QcResequencingsController extends AppController
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
        $this->set('qcResequencings', $this->paginate($this->QcResequencings));
        $this->set('_serialize', ['qcResequencings']);
    }

    /**
     * View method
     *
     * @param string|null $id Qc Resequencing id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qcResequencing = $this->QcResequencings->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('qcResequencing', $qcResequencing);
        $this->set('_serialize', ['qcResequencing']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($qcID=null)
    {
        $qcResequencing = $this->QcResequencings->newEntity();
        if ($this->request->is('post')) {
            $qcResequencing = $this->QcResequencings->patchEntity($qcResequencing, $this->request->data);
            if ($this->QcResequencings->save($qcResequencing)) {
                $this->Flash->success(__('The qc resequencing has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc resequencing could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcResequencings->QualityControls->find('list');
        $users = $this->QcResequencings->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcResequencing', 'users', 'qcID', 'qualityControls'));
        $this->set('_serialize', ['qcResequencing']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qc Resequencing id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qcResequencing = $this->QcResequencings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qcResequencing = $this->QcResequencings->patchEntity($qcResequencing, $this->request->data);
            if ($this->QcResequencings->save($qcResequencing)) {
                $this->Flash->success(__('The qc resequencing has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc resequencing could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcResequencings->QualityControls->find('list');
        $users = $this->QcResequencings->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcResequencing', 'users', 'qualityControls'));
        $this->set('_serialize', ['qcResequencing']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qc Resequencing id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qcResequencing = $this->QcResequencings->get($id);
        if ($this->QcResequencings->delete($qcResequencing)) {
            $this->Flash->success(__('The qc resequencing has been deleted.'));
        } else {
            $this->Flash->error(__('The qc resequencing could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
