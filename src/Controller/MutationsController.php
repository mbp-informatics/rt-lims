<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Mutations Controller
 *
 * @property \App\Model\Table\MutationsTable $Mutations
 */
class MutationsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('mutations', $this->paginate($this->Mutations));
        $this->set('_serialize', ['mutations']);
    }

    /**
     * View method
     *
     * @param string|null $id Mutation id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mutation = $this->Mutations->get($id, [
            'contain' => ['Projects']
        ]);
        $this->set('mutation', $mutation);
        $this->set('_serialize', ['mutation']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mutation = $this->Mutations->newEntity();
        if ($this->request->is('post')) {
            $mutation = $this->Mutations->patchEntity($mutation, $this->request->data);
            if ($this->Mutations->save($mutation)) {
                $this->Flash->success(__('The mutation has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mutation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('mutation'));
        $this->set('_serialize', ['mutation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Mutation id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mutation = $this->Mutations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mutation = $this->Mutations->patchEntity($mutation, $this->request->data);
            if ($this->Mutations->save($mutation)) {
                $this->Flash->success(__('The mutation has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mutation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('mutation'));
        $this->set('_serialize', ['mutation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Mutation id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mutation = $this->Mutations->get($id);
        if ($this->Mutations->delete($mutation)) {
            $this->Flash->success(__('The mutation has been deleted.'));
        } else {
            $this->Flash->error(__('The mutation could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
