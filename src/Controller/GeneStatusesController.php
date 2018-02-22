<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * GeneStatuses Controller
 *
 * @property \App\Model\Table\GeneStatusesTable $GeneStatuses
 */
class GeneStatusesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $geneStatuses = $this->paginate($this->GeneStatuses);

        $this->set(compact('geneStatuses'));
        $this->set('_serialize', ['geneStatuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Gene Status id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $geneStatus = $this->GeneStatuses->get($id, [
            'contain' => []
        ]);

        $this->set('geneStatus', $geneStatus);
        $this->set('_serialize', ['geneStatus']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $geneStatus = $this->GeneStatuses->newEntity();
        if ($this->request->is('post')) {
            $geneStatus = $this->GeneStatuses->patchEntity($geneStatus, $this->request->data);
            if ($this->GeneStatuses->save($geneStatus)) {
                $this->Flash->success(__('The gene status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gene status could not be saved. Please, try again.'));
        }
        $this->set(compact('geneStatus'));
        $this->set('_serialize', ['geneStatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Gene Status id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $geneStatus = $this->GeneStatuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $geneStatus = $this->GeneStatuses->patchEntity($geneStatus, $this->request->data);
            if ($this->GeneStatuses->save($geneStatus)) {
                $this->Flash->success(__('The gene status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gene status could not be saved. Please, try again.'));
        }
        $this->set(compact('geneStatus'));
        $this->set('_serialize', ['geneStatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Gene Status id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $geneStatus = $this->GeneStatuses->get($id);
        if ($this->GeneStatuses->delete($geneStatus)) {
            $this->Flash->success(__('The gene status has been deleted.'));
        } else {
            $this->Flash->error(__('The gene status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
