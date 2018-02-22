<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Phenotypes Controller
 *
 * @property \App\Model\Table\PhenotypesTable $Phenotypes
 */
class PhenotypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $phenotypes = $this->paginate($this->Phenotypes);

        $this->set(compact('phenotypes'));
        $this->set('_serialize', ['phenotypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Phenotype id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $phenotype = $this->Phenotypes->get($id, [
            'contain' => ['Projects']
        ]);

        $this->set('phenotype', $phenotype);
        $this->set('_serialize', ['phenotype']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $phenotype = $this->Phenotypes->newEntity();
        if ($this->request->is('post')) {
            $phenotype = $this->Phenotypes->patchEntity($phenotype, $this->request->data);
            if ($this->Phenotypes->save($phenotype)) {
                $this->Flash->success(__('The phenotype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The phenotype could not be saved. Please, try again.'));
        }
        $this->set(compact('phenotype'));
        $this->set('_serialize', ['phenotype']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Phenotype id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $phenotype = $this->Phenotypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $phenotype = $this->Phenotypes->patchEntity($phenotype, $this->request->data);
            if ($this->Phenotypes->save($phenotype)) {
                $this->Flash->success(__('The phenotype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The phenotype could not be saved. Please, try again.'));
        }
        $this->set(compact('phenotype'));
        $this->set('_serialize', ['phenotype']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Phenotype id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $phenotype = $this->Phenotypes->get($id);
        if ($this->Phenotypes->delete($phenotype)) {
            $this->Flash->success(__('The phenotype has been deleted.'));
        } else {
            $this->Flash->error(__('The phenotype could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
