<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * JobAstatuses Controller
 *
 * @property \App\Model\Table\JobAstatusesTable $JobAstatuses
 */
class JobAstatusesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('jobAstatuses', $this->paginate($this->JobAstatuses));
        $this->set('_serialize', ['jobAstatuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Job Astatus id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jobAstatus = $this->JobAstatuses->get($id, [
            'contain' => []
        ]);
        $this->set('jobAstatus', $jobAstatus);
        $this->set('_serialize', ['jobAstatus']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jobAstatus = $this->JobAstatuses->newEntity();
        if ($this->request->is('post')) {
            $jobAstatus = $this->JobAstatuses->patchEntity($jobAstatus, $this->request->data);
            if ($this->JobAstatuses->save($jobAstatus)) {
                $this->Flash->success(__('The job astatus has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The job astatus could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('jobAstatus'));
        $this->set('_serialize', ['jobAstatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Astatus id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jobAstatus = $this->JobAstatuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobAstatus = $this->JobAstatuses->patchEntity($jobAstatus, $this->request->data);
            if ($this->JobAstatuses->save($jobAstatus)) {
                $this->Flash->success(__('The job astatus has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The job astatus could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('jobAstatus'));
        $this->set('_serialize', ['jobAstatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Astatus id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobAstatus = $this->JobAstatuses->get($id);
        if ($this->JobAstatuses->delete($jobAstatus)) {
            $this->Flash->success(__('The job astatus has been deleted.'));
        } else {
            $this->Flash->error(__('The job astatus could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
