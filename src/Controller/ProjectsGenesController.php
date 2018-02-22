<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectsGenes Controller
 *
 * @property \App\Model\Table\ProjectsGenesTable $ProjectsGenes
 */
class ProjectsGenesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $projectsGenes = $this->ProjectsGenes->find('all')->contain(['Users', 'Projects'=>['ProjectTypes', 'Mutations', 'Phenotypes'], 'MgiGenesDump']);

        $this->set(compact('projectsGenes'));
        $this->set('_serialize', ['projectsGenes']);
    }

    /**
     * View method
     *
     * @param string|null $id Projects Gene id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectsGene = $this->ProjectsGenes->get($id, [
            'contain' => ['Users', 'Projects', 'MgiGenesDump']
        ]);

        $this->set('projectsGene', $projectsGene);
        $this->set('_serialize', ['projectsGene']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectsGene = $this->ProjectsGenes->newEntity();
        if ($this->request->is('post')) {
            $projectsGene = $this->ProjectsGenes->patchEntity($projectsGene, $this->request->data);
            if ($this->ProjectsGenes->save($projectsGene)) {
                $this->Flash->success(__('The projects gene has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projects gene could not be saved. Please, try again.'));
        }
        $users = $this->ProjectsGenes->Users->find('list', ['limit' => 200]);
        $projects = $this->ProjectsGenes->Projects->find('list', ['limit' => 200]);
        $mgiGenesDump = $this->ProjectsGenes->MgiGenesDump->find('list', ['limit' => 200]);
        $this->set(compact('projectsGene', 'users', 'projects', 'mgiGenesDump'));
        $this->set('_serialize', ['projectsGene']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Projects Gene id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectsGene = $this->ProjectsGenes->get($id, [
            'contain' => ['Users', 'Projects', 'MgiGenesDump']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectsGene = $this->ProjectsGenes->patchEntity($projectsGene, $this->request->data);
            if ($this->ProjectsGenes->save($projectsGene)) {
                $this->Flash->success(__('The projects gene has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projects gene could not be saved. Please, try again.'));
        }
        $users = $this->ProjectsGenes->Users->find('list', ['limit' => 200]);
        $projects = $this->ProjectsGenes->Projects->find('list', ['limit' => 200]);
        $mgiGenesDump = $this->ProjectsGenes->MgiGenesDump->find('list', ['limit' => 200]);
        $this->set(compact('projectsGene', 'users', 'projects', 'mgiGenesDump'));
        $this->set('_serialize', ['projectsGene']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Projects Gene id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectsGene = $this->ProjectsGenes->get($id);
        if ($this->ProjectsGenes->delete($projectsGene)) {
            $this->Flash->success(__('The projects gene has been deleted.'));
        } else {
            $this->Flash->error(__('The projects gene could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
