<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * JobTypes Controller
 *
 * @property \App\Model\Table\JobTypesTable $JobTypes
 */
class JobTypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('jobTypes', $this->paginate($this->JobTypes));
        $this->set('_serialize', ['jobTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Job Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jobType = $this->JobTypes->get($id, [
            'contain' => ['Users', 'JobTypeNames', 'Jobs']
        ]);
        $this->set('jobType', $jobType);
        $this->set('_serialize', ['jobType']);
    }

  /**
     * Add Ajax method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addAjax()
    {
        $jobType = $this->JobTypes->newEntity();
        if ($this->request->is('post')) {
            $jobType = $this->JobTypes->patchEntity($jobType, $this->request->data);
            if ($res = $this->JobTypes->save($jobType)) {
                $res['success'] = 'A Job Type has been saved. ID: ' . $res['id'];
            } else {
                $res['error'] = 'A Job Type could not be saved.';
            }
        }
        $jobTypeNames = $this->JobTypes->JobTypeNames->find('list');
        if (isset($res)) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', json_encode($res));
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set(compact('jobType','jobs','users', 'jobTypeNames'));
            $this->set('_serialize', ['jobType']);
        }
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($job_id, $downmark = null)
    {
        $jobType = $this->JobTypes->newEntity();
        if ($this->request->is('post')) {
            $jobType = $this->JobTypes->patchEntity($jobType, $this->request->data);
            if ($this->JobTypes->save($jobType)) {
                $this->Flash->success(__('The job type has been saved.'));
                return $this->redirect(['controller'=> 'Jobs', 'action' => 'view', '#' => 'requested-job-types', $job_id]);
            } else {
                $this->Flash->error(__('The job type could not be saved. Please, try again.'));
            }
        }
        $jobs = $this->JobTypes->Jobs->find('list');
        $users = $this->JobTypes->Users->find('list');
        $jobTypeNames = $this->JobTypes->JobTypeNames->find('list');
        $this->set('job_id', [$job_id]);
        $this->set(compact('jobType','jobs','users', 'jobTypeNames'));
        $this->set('_serialize', ['jobType']);
        if ( isset($downmark) )  { //get rid of the layout (skip header, footer, navbar)
            $this->viewBuilder()->layout('');
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jobType = $this->JobTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobType = $this->JobTypes->patchEntity($jobType, $this->request->data);
            if ($this->JobTypes->save($jobType)) {
                $this->Flash->success(__('The job type has been saved.'));
                return $this->redirect(['controller'=> 'Jobs', 'action' => 'view','#' => 'requested-job-types', $jobType->job_id]);
            } else {
                $this->Flash->error(__('The job type could not be saved. Please, try again.'));
            }
        }
        $jobs = $this->JobTypes->Jobs->find('list');
        $users = $this->JobTypes->Users->find('list');
        $jobTypeNames = $this->JobTypes->JobTypeNames->find('list');
        $this->set(compact('jobType','jobs','users', 'jobTypeNames'));
        $this->set('_serialize', ['jobType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Type id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobType = $this->JobTypes->get($id);
        if ($this->JobTypes->delete($jobType)) {
            $this->Flash->success(__('The job type has been deleted.'));
        } else {
            $this->Flash->error(__('The job type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller'=> 'Jobs', 'action' => 'view','#' => 'requested-job-types', $jobType->job_id]);
    }
}
