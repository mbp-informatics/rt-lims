<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QcGenotypes Controller
 *
 * @property \App\Model\Table\QcGenotypesTable $QcGenotypes
 */
class QcGenotypesController extends AppController
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
        $this->set('qcGenotypes', $this->paginate($this->QcGenotypes));
        $this->set('_serialize', ['qcGenotypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Qc Genotype id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qcGenotype = $this->QcGenotypes->get($id, [
            'contain' => ['InventoryVials', 'Users']
        ]);
        $this->set('qcGenotype', $qcGenotype);
        $this->set('_serialize', ['qcGenotype']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($qcID=null)
    {
        $qcGenotype = $this->QcGenotypes->newEntity();
        if ($this->request->is('post')) {
            $qcGenotype = $this->QcGenotypes->patchEntity($qcGenotype, $this->request->data);
            if ($this->QcGenotypes->save($qcGenotype)) {
                $this->Flash->success(__('The qc genotype has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc genotype could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcGenotypes->QualityControls->find('list');
        $users = $this->QcGenotypes->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcGenotype', 'users', 'qcID', 'qualityControls'));
        $this->set('_serialize', ['qcGenotype']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qc Genotype id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qcGenotype = $this->QcGenotypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qcGenotype = $this->QcGenotypes->patchEntity($qcGenotype, $this->request->data);
            if ($this->QcGenotypes->save($qcGenotype)) {
                $this->Flash->success(__('The qc genotype has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc genotype could not be saved. Please, try again.'));
            }
        }
<<<<<<< HEAD
        // $vials = $this->QcGenotypes->Vials->find('list', ['limit' => 200]);
        $users = $this->QcGenotypes->Users->find('list');
        $qualityControls = $this->QcGenotypes->QualityControls->find('list');
        $this->set(compact('qcGenotype', 'users', 'qualityControls'));
=======
        $users = $this->QcGenotypes->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcGenotype', 'users'));
>>>>>>> 96b88a50e76dc79a0a788e1e66d17e1dd9114d11
        $this->set('_serialize', ['qcGenotype']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qc Genotype id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qcGenotype = $this->QcGenotypes->get($id);
        if ($this->QcGenotypes->delete($qcGenotype)) {
            $this->Flash->success(__('The qc genotype has been deleted.'));
        } else {
            $this->Flash->error(__('The qc genotype could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
