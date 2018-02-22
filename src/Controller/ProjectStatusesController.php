<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectStatuses Controller
 *
 * @property \App\Model\Table\ProjectStatusesTable $ProjectStatuses
 */
class ProjectStatusesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('projectStatuses', $this->paginate($this->ProjectStatuses));
        $this->set('_serialize', ['projectStatuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Project Status id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectStatus = $this->ProjectStatuses->get($id, [
            'contain' => ['ProjectMilestones', 'Projects']
        ]);
        $this->set('projectStatus', $projectStatus);
        $this->set('_serialize', ['projectStatus']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectStatus = $this->ProjectStatuses->newEntity();
        if ($this->request->is('post')) {
            $projectStatus = $this->ProjectStatuses->patchEntity($projectStatus, $this->request->data);
            if ($this->ProjectStatuses->save($projectStatus)) {
                $this->Flash->success(__('The project status has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project status could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('projectStatus'));
        $this->set('_serialize', ['projectStatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project Status id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectStatus = $this->ProjectStatuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectStatus = $this->ProjectStatuses->patchEntity($projectStatus, $this->request->data);
            if ($this->ProjectStatuses->save($projectStatus)) {
                $this->Flash->success(__('The project status has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project status could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('projectStatus'));
        $this->set('_serialize', ['projectStatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project Status id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectStatus = $this->ProjectStatuses->get($id);
        if ($this->ProjectStatuses->delete($projectStatus)) {
            $this->Flash->success(__('The project status has been deleted.'));
        } else {
            $this->Flash->error(__('The project status could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
