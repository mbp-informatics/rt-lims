<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * JobTypeNames Controller
 *
 * @property \App\Model\Table\JobTypeNamesTable $JobTypeNames
 */
class JobTypeNamesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('jobTypeNames', $this->paginate($this->JobTypeNames));
        $this->set('_serialize', ['jobTypeNames']);
    }

    /**
     * View method
     *
     * @param string|null $id Job Type Name id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jobTypeName = $this->JobTypeNames->get($id, [
            'contain' => []
        ]);
        $this->set('jobTypeName', $jobTypeName);
        $this->set('_serialize', ['jobTypeName']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jobTypeName = $this->JobTypeNames->newEntity();
        if ($this->request->is('post')) {
            $jobTypeName = $this->JobTypeNames->patchEntity($jobTypeName, $this->request->data);
            if ($this->JobTypeNames->save($jobTypeName)) {
                $this->Flash->success(__('The job type name has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The job type name could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('jobTypeName'));
        $this->set('_serialize', ['jobTypeName']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Type Name id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jobTypeName = $this->JobTypeNames->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobTypeName = $this->JobTypeNames->patchEntity($jobTypeName, $this->request->data);
            if ($this->JobTypeNames->save($jobTypeName)) {
                $this->Flash->success(__('The job type name has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The job type name could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('jobTypeName'));
        $this->set('_serialize', ['jobTypeName']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Type Name id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobTypeName = $this->JobTypeNames->get($id);
        if ($this->JobTypeNames->delete($jobTypeName)) {
            $this->Flash->success(__('The job type name has been deleted.'));
        } else {
            $this->Flash->error(__('The job type name could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
