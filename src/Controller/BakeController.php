<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Bake Controller
 *
 * @property \App\Model\Table\BakeTable $Bake
 */
class BakeController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('bake', $this->paginate($this->Bake));
        $this->set('_serialize', ['bake']);
    }

    /**
     * View method
     *
     * @param string|null $id Bake id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bake = $this->Bake->get($id, [
            'contain' => []
        ]);
        $this->set('bake', $bake);
        $this->set('_serialize', ['bake']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bake = $this->Bake->newEntity();
        if ($this->request->is('post')) {
            $bake = $this->Bake->patchEntity($bake, $this->request->data);
            if ($this->Bake->save($bake)) {
                $this->Flash->success(__('The bake has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bake could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('bake'));
        $this->set('_serialize', ['bake']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Bake id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bake = $this->Bake->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bake = $this->Bake->patchEntity($bake, $this->request->data);
            if ($this->Bake->save($bake)) {
                $this->Flash->success(__('The bake has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bake could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('bake'));
        $this->set('_serialize', ['bake']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Bake id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bake = $this->Bake->get($id);
        if ($this->Bake->delete($bake)) {
            $this->Flash->success(__('The bake has been deleted.'));
        } else {
            $this->Flash->error(__('The bake could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
