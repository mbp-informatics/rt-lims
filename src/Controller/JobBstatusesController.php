<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * JobBstatuses Controller
 *
 * @property \App\Model\Table\JobBstatusesTable $JobBstatuses
 */
class JobBstatusesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('jobBstatuses', $this->paginate($this->JobBstatuses));
        $this->set('_serialize', ['jobBstatuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Job Bstatus id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jobBstatus = $this->JobBstatuses->get($id, [
            'contain' => []
        ]);
        $this->set('jobBstatus', $jobBstatus);
        $this->set('_serialize', ['jobBstatus']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jobBstatus = $this->JobBstatuses->newEntity();
        if ($this->request->is('post')) {
            $jobBstatus = $this->JobBstatuses->patchEntity($jobBstatus, $this->request->data);
            if ($this->JobBstatuses->save($jobBstatus)) {
                $this->Flash->success(__('The job bstatus has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The job bstatus could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('jobBstatus'));
        $this->set('_serialize', ['jobBstatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Bstatus id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jobBstatus = $this->JobBstatuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobBstatus = $this->JobBstatuses->patchEntity($jobBstatus, $this->request->data);
            if ($this->JobBstatuses->save($jobBstatus)) {
                $this->Flash->success(__('The job bstatus has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The job bstatus could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('jobBstatus'));
        $this->set('_serialize', ['jobBstatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Bstatus id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobBstatus = $this->JobBstatuses->get($id);
        if ($this->JobBstatuses->delete($jobBstatus)) {
            $this->Flash->success(__('The job bstatus has been deleted.'));
        } else {
            $this->Flash->error(__('The job bstatus could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
