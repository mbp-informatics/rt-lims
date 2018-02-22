<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Contacts Controller
 *
 * @property \App\Model\Table\ContactsTable $Contacts
 */
class ContactsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $data = $this->Contacts->find('all')
            ->contain(['Users', 'ContactTypes']);
        $this->set('Contacts', $data);
        $this->set('_serialize', ['Contacts']);
    }

    /**
     * View method
     *
     * @param string|null $id Contact id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null, $ajax=null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => ['Users', 'ContactTypes']
        ]);

        if ($ajax) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', $contact);
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set('contact', $contact);
            $this->set('_serialize', ['contact']);
        }


    }

    /**
     * Add method - adds a contact via ajax:
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addAjax()
    {
        $contact = $this->Contacts->newEntity();
        if ($this->request->is('post')) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            if ($res = $this->Contacts->save($contact)) {
                $res['success'] = 'New contact has been saved. ID: ' . $res['id'];
            } else {
                $res['error'] = 'The contact could not be saved.';
            }
        }
        $ContactTypes = $this->Contacts->ContactTypes->find('list');
        if (isset($res)) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', json_encode($res));
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set(compact('contact','ContactTypes'));
            $this->set('_serialize', ['contact']);
        }
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($job_id=null)
    {
        $contact = $this->Contacts->newEntity();
        if ($this->request->is('post')) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('The contact has been saved.'));
                return $this->redirect(['controller'=> 'Contacts', 'action' => 'index']);
            } else {
                $this->Flash->error(__('The contact could not be saved. Please, try again.'));
            }
        }
        $jobs = $this->Contacts->Jobs->find('list');
        $users = $this->Contacts->Users->find('list');
        $ContactTypes = $this->Contacts->ContactTypes->find('list');
        
        $this->set('job_id', [$job_id]);
        $this->set(compact('contact','jobs','users', 'ContactTypes'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contact id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $jobId=null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => ['Users', 'Jobs', 'ContactTypes']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('The contact has been saved.'));
                if (isset($jobId)) {
                    return $this->redirect(['controller'=>'Jobs','action' => 'view', $jobId, '#' => 'contacts']);
                }
                return $this->redirect(['controller'=>'Contacts','action' => 'view', $id]);
            } else {
                $this->Flash->error(__('The job contact could not be saved. Please, try again.'));
            }
        }
        $jobs = $this->Contacts->Jobs->find('list');
        $users = $this->Contacts->Users->find('list');
        $ContactTypes = $this->Contacts->ContactTypes->find('list');
        $this->set(compact('contact', 'jobs', 'users', 'ContactTypes'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Contact id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contact = $this->Contacts->get($id);
        if ($this->Contacts->delete($contact)) {
            $this->Flash->success(__('The contact has been deleted.'));
        } else {
            $this->Flash->error(__('The contact could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller'=> 'Contacts', 'action' => 'index', $id]);
    }
}
