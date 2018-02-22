<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Genotypings Controller
 *
 * @property \App\Model\Table\GenotypingsTable $Genotypings
 */
class GenotypingsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Ivfs', 'SpermCryos', 'EmbryoCryos', 'GenotypeRequests']
        ];
        $genotypings = $this->paginate($this->Genotypings);

        $this->set(compact('genotypings'));
        $this->set('_serialize', ['genotypings']);
    }

    /**
     * View method
     *
     * @param string|null $id Genotyping id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $genotyping = $this->Genotypings->get($id, [
            'contain' => ['Ivfs', 'SpermCryos', 'EmbryoCryos', 'GenotypeRequests']
        ]);

        $this->set('genotyping', $genotyping);
        $this->set('_serialize', ['genotyping']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $genotyping = $this->Genotypings->newEntity();
        if ($this->request->is('post')) {
            $genotyping = $this->Genotypings->patchEntity($genotyping, $this->request->data);
            if ($this->Genotypings->save($genotyping)) {
                $this->Flash->success(__('The genotyping has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The genotyping could not be saved. Please, try again.'));
        }
        $ivfs = $this->Genotypings->Ivfs->find('list', ['limit' => 200]);
        $spermCryos = $this->Genotypings->SpermCryos->find('list', ['limit' => 200]);
        $embryoCryos = $this->Genotypings->EmbryoCryos->find('list', ['limit' => 200]);
        $genotypeRequests = $this->Genotypings->GenotypeRequests->find('list', ['limit' => 200]);
        $this->set(compact('genotyping', 'ivfs', 'spermCryos', 'embryoCryos', 'genotypeRequests'));
        $this->set('_serialize', ['genotyping']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Genotyping id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $genotyping = $this->Genotypings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $genotyping = $this->Genotypings->patchEntity($genotyping, $this->request->data);
            if ($this->Genotypings->save($genotyping)) {
                $this->Flash->success(__('The genotyping has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The genotyping could not be saved. Please, try again.'));
        }
        $ivfs = $this->Genotypings->Ivfs->find('list', ['limit' => 200]);
        $spermCryos = $this->Genotypings->SpermCryos->find('list', ['limit' => 200]);
        $embryoCryos = $this->Genotypings->EmbryoCryos->find('list', ['limit' => 200]);
        $genotypeRequests = $this->Genotypings->GenotypeRequests->find('list', ['limit' => 200]);
        $this->set(compact('genotyping', 'ivfs', 'spermCryos', 'embryoCryos', 'genotypeRequests'));
        $this->set('_serialize', ['genotyping']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Genotyping id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $genotyping = $this->Genotypings->get($id);
        if ($this->Genotypings->delete($genotyping)) {
            $this->Flash->success(__('The genotyping has been deleted.'));
        } else {
            $this->Flash->error(__('The genotyping could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }



}
