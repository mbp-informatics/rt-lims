<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectTypesGenes Controller
 *
 * @property \App\Model\Table\ProjectTypesGenesTable $ProjectTypesGenes
 */
class ProjectTypesGenesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($ajax = null, $projectTypeId = null)
    {
        $data = $this->ProjectTypesGenes
            ->find('all')
            ->contain(['MgiGenesDump', 'ProjectTypes']);

        if ($ajax) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', json_encode($data));
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set('projectTypesGenes', $data);
            $this->set('_serialize', ['projectTypesGenes']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Project Types Gene id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectTypesGene = $this->ProjectTypesGenes->get($id, [
            'contain' => []
        ]);

        $this->set('projectTypesGene', $projectTypesGene);
        $this->set('_serialize', ['projectTypesGene']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectTypesGene = $this->ProjectTypesGenes->newEntity();
        if ($this->request->is('post')) {
            $projectTypesGene = $this->ProjectTypesGenes->patchEntity($projectTypesGene, $this->request->data);
            if ($this->ProjectTypesGenes->save($projectTypesGene)) {
                $this->Flash->success(__('The project types gene has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project types gene could not be saved. Please, try again.'));
        }
        $this->set(compact('projectTypesGene'));
        $this->set('_serialize', ['projectTypesGene']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project Types Gene id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectTypesGene = $this->ProjectTypesGenes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectTypesGene = $this->ProjectTypesGenes->patchEntity($projectTypesGene, $this->request->data);
            if ($this->ProjectTypesGenes->save($projectTypesGene)) {
                $this->Flash->success(__('The project types gene has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project types gene could not be saved. Please, try again.'));
        }
        $this->set(compact('projectTypesGene'));
        $this->set('_serialize', ['projectTypesGene']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project Types Gene id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectTypesGene = $this->ProjectTypesGenes->get($id);
        if ($this->ProjectTypesGenes->delete($projectTypesGene)) {
            $this->Flash->success(__('The project types gene has been deleted.'));
        } else {
            $this->Flash->error(__('The project types gene could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
