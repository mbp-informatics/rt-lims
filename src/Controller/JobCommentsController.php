<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * JobComments Controller
 *
 * @property \App\Model\Table\JobCommentsTable $JobComments
 */
class JobCommentsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('jobComments', $this->paginate($this->JobComments));
        $this->set('_serialize', ['jobComments']);
    }

    /**
     * View method
     *
     * @param string|null $id Job Comment id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jobComment = $this->JobComments->get($id, [
            'contain' => ['Users', 'Jobs']
        ]);
        $this->set('jobComment', $jobComment);
        $this->set('_serialize', ['jobComment']);
    }

    /**
     * Add Ajax method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addAjax()
    {
        $jobComment = $this->JobComments->newEntity();
        $users = $this->JobComments->Users->find('list');
        $this->set(compact('jobComment','users'));
        $this->set('_serialize', ['jobComment']);
    }    

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($job_id, $downmark = null)
    {
        $jobComment = $this->JobComments->newEntity();
        if ($this->request->is('post')) {
            $jobComment = $this->JobComments->patchEntity($jobComment, $this->request->data);
            if ($this->JobComments->save($jobComment)) {
                $this->Flash->success(__('The job comment has been saved.'));
                return $this->redirect(['controller'=> 'Jobs', 'action' => 'view', '#' => 'job-comments', $job_id]);
            } else {
                $this->Flash->error(__('The job comment could not be saved. Please, try again.'));
            }
        }
        $jobs = $this->JobComments->Jobs->find('list');
        $users = $this->JobComments->Users->find('list');
        $this->set('job_id', [$job_id]);
        $this->set(compact('jobComment','jobs','users'));
        $this->set('_serialize', ['jobComment']);
        if ( isset($downmark) )  { //get rid of the layout (skip header, footer, navbar)
            $this->viewBuilder()->layout('');
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Comment id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jobComment = $this->JobComments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobComment = $this->JobComments->patchEntity($jobComment, $this->request->data);
            if ($this->JobComments->save($jobComment)) {
                $this->Flash->success(__('The job comment has been saved.'));
                return $this->redirect(['controller'=> 'Jobs', 'action' => 'view', '#' => 'job-comments', $jobComment->job_id]);
            } else {
                $this->Flash->error(__('The job comment could not be saved. Please, try again.'));
            }
        }
        $jobs = $this->JobComments->Jobs->find('list');
        $users = $this->JobComments->Users->find('list');
        $this->set(compact('jobComment', 'jobs', 'users'));
        $this->set('_serialize', ['jobComment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Comment id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobComment = $this->JobComments->get($id);
        if ($this->JobComments->delete($jobComment)) {
            $this->Flash->success(__('The job comment has been deleted.'));
        } else {
            $this->Flash->error(__('The job comment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller'=> 'Jobs', 'action' => 'view', '#' => 'job-comments', $jobComment->job_id]);
    }
}
