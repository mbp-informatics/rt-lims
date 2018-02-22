<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QcCustomerInvivos Controller
 *
 * @property \App\Model\Table\QcCustomerInvivosTable $QcCustomerInvivos
 */
class QcCustomerInvivosController extends AppController
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
        $this->set('qcCustomerInvivos', $this->paginate($this->QcCustomerInvivos));
        $this->set('_serialize', ['qcCustomerInvivos']);
    }

    /**
     * View method
     *
     * @param string|null $id Qc Customer Invivo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qcCustomerInvivo = $this->QcCustomerInvivos->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('qcCustomerInvivo', $qcCustomerInvivo);
        $this->set('_serialize', ['qcCustomerInvivo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($qcID=null)
    {

        $qcCustomerInvivo = $this->QcCustomerInvivos->newEntity();
        if ($this->request->is('post')) {
            $qcCustomerInvivo = $this->QcCustomerInvivos->patchEntity($qcCustomerInvivo, $this->request->data);
            if ($this->QcCustomerInvivos->save($qcCustomerInvivo)) {
                $this->Flash->success(__('The qc customer invivo has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc customer invivo could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcCustomerInvivos->QualityControls->find('list');
        $users = $this->QcCustomerInvivos->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcCustomerInvivo', 'users', 'qualityControls', 'qcID'));
        $this->set('_serialize', ['qcCustomerInvivo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qc Customer Invivo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qcCustomerInvivo = $this->QcCustomerInvivos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qcCustomerInvivo = $this->QcCustomerInvivos->patchEntity($qcCustomerInvivo, $this->request->data);
            if ($this->QcCustomerInvivos->save($qcCustomerInvivo)) {
                $this->Flash->success(__('The qc customer invivo has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc customer invivo could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcCustomerInvivos->QualityControls->find('list');
        $users = $this->QcCustomerInvivos->Users->find('list');
        $this->set(compact('qcCustomerInvivo', 'users', 'qualityControls'));
        $this->set('_serialize', ['qcCustomerInvivo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qc Customer Invivo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qcCustomerInvivo = $this->QcCustomerInvivos->get($id);
        if ($this->QcCustomerInvivos->delete($qcCustomerInvivo)) {
            $this->Flash->success(__('The qc customer invivo has been deleted.'));
        } else {
            $this->Flash->error(__('The qc customer invivo could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
