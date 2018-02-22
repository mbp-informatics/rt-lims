<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectTypes Controller
 *
 * @property \App\Model\Table\ProjectTypesTable $ProjectTypes
 */
class ProjectTypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('projectTypes', $this->paginate($this->ProjectTypes));
        $this->set('_serialize', ['projectTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Project Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectType = $this->ProjectTypes->get($id, [
            'contain' => ['Projects']
        ]);
        $this->set('projectType', $projectType);
        $this->set('_serialize', ['projectType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectType = $this->ProjectTypes->newEntity();
        if ($this->request->is('post')) {
            $projectType = $this->ProjectTypes->patchEntity($projectType, $this->request->data);
            if ($this->ProjectTypes->save($projectType)) {
                $this->Flash->success(__('The project type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('projectType'));
        $this->set('_serialize', ['projectType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectType = $this->ProjectTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectType = $this->ProjectTypes->patchEntity($projectType, $this->request->data);
            if ($this->ProjectTypes->save($projectType)) {
                $this->Flash->success(__('The project type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('projectType'));
        $this->set('_serialize', ['projectType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project Type id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectType = $this->ProjectTypes->get($id);
        if ($this->ProjectTypes->delete($projectType)) {
            $this->Flash->success(__('The project type has been deleted.'));
        } else {
            $this->Flash->error(__('The project type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
