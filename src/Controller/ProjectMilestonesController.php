<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectMilestones Controller
 *
 * @property \App\Model\Table\ProjectMilestonesTable $ProjectMilestones
 */
class ProjectMilestonesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('projectMilestones', $this->ProjectMilestones->find('all')->contain(['Projects', 'ProjectStatuses']));
        $this->set('_serialize', ['projectMilestones']);
    }

    /**
     * View method
     *
     * @param string|null $id Project Milestone id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectMilestone = $this->ProjectMilestones->get($id, [
            'contain' => ['Projects', 'ProjectStatuses']
        ]);
        $this->set('projectMilestone', $projectMilestone);
        $this->set('_serialize', ['projectMilestone']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectMilestone = $this->ProjectMilestones->newEntity();
        if ($this->request->is('post')) {
            $projectMilestone = $this->ProjectMilestones->patchEntity($projectMilestone, $this->request->data);
            if ($this->ProjectMilestones->save($projectMilestone)) {
                $this->Flash->success(__('The project milestone has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project milestone could not be saved. Please, try again.'));
            }
        }
        $projects = $this->ProjectMilestones->Projects->find('list', ['limit' => 200]);
        $projectStatuses = $this->ProjectMilestones->ProjectStatuses->find('list', ['limit' => 200]);
        $this->set(compact('projectMilestone', 'projects', 'projectStatuses'));
        $this->set('_serialize', ['projectMilestone']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project Milestone id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectMilestone = $this->ProjectMilestones->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectMilestone = $this->ProjectMilestones->patchEntity($projectMilestone, $this->request->data);
            if ($this->ProjectMilestones->save($projectMilestone)) {
                $this->Flash->success(__('The project milestone has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project milestone could not be saved. Please, try again.'));
            }
        }
        $projects = $this->ProjectMilestones->Projects->find('list', ['limit' => 200]);
        $projectStatuses = $this->ProjectMilestones->ProjectStatuses->find('list', ['limit' => 200]);
        $this->set(compact('projectMilestone', 'projects', 'projectStatuses'));
        $this->set('_serialize', ['projectMilestone']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project Milestone id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectMilestone = $this->ProjectMilestones->get($id);
        if ($this->ProjectMilestones->delete($projectMilestone)) {
            $this->Flash->success(__('The project milestone has been deleted.'));
        } else {
            $this->Flash->error(__('The project milestone could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
