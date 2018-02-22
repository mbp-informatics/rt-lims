<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ContactsJobs Controller
 *
 * @property \App\Model\Table\ContactsJobsTable $ContactsJobs
 */
class ContactsJobsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Helper');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contacts', 'Jobs']
        ];
        $this->set('contactsJobs', $this->paginate($this->ContactsJobs));
        $this->set('_serialize', ['contactsJobs']);
    }

    /**
     * Add Ajax method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addajax($job_id=null, $downmark = null)
    {
        if (isset($job_id) ) { $this->request->data['job_id'] = $job_id; }
        $contactsJob = $this->ContactsJobs->newEntity();
        if ($this->request->is('post')) {
            $contactsJob = $this->ContactsJobs->patchEntity($contactsJob, $this->request->data);
            if ($this->ContactsJobs->save($contactsJob)) {
                $this->Flash->success(__('The contact association has been saved.'));
                if ($job_id) {
                  return $this->redirect(['action' => 'view', 'controller' => 'jobs', '#' => 'contacts', $job_id]);
                } else {
                    return $this->redirect(['action' => 'index', 'controller' => 'contacts']);
                }
            } else {
                $this->Flash->error(__('The contact association could not be saved. Please, try again.'));
                if ($job_id) {
                  return $this->redirect(['action' => 'view', 'controller' => 'jobs', '#' => 'contacts', $job_id]);
                } else {
                    return $this->redirect(['action' => 'index', 'controller' => 'contacts']);
                }
            }
        }
        $jobs = $this->ContactsJobs->Jobs->find('list');
        $contacts = $this->Helper->prepareViewList('contacts', ['id', 'first_name', 'last_name', 'email', 'campus_company', 'school'], ' - ');
        $contactsAssociations = $this->Helper->prepareViewList('contacts_jobs', ['contact_id', 'job_id'], '|');

            /** This removes a contact from contacts dropdown if a given
             * contact is already assigned to the jobs. This prevents assiginig the same
             * contact with the job twice (which would produce an error and is bad UX)
             */
            foreach ($contactsAssociations as $assoc) {
                $assoc = explode('|', $assoc);
                $job_contacts['contact_id'] = $assoc[0];
                $job_contacts['job_id'] = isset($assoc[1]) ? $assoc[1] : null;
                if ($job_id == $job_contacts['job_id']) { 
                    unset($contacts[$job_contacts['contact_id']]);
                }
            }

        $this->set(compact('contactsJob', 'jobs', 'contacts', 'job_id'));
        $this->set('_serialize', ['contactsJob']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($job_id=null, $downmark = null)
    {
        if (isset($job_id) ) { $this->request->data['job_id'] = $job_id; }
        $contactsJob = $this->ContactsJobs->newEntity();
        if ($this->request->is('post')) {
            $contactsJob = $this->ContactsJobs->patchEntity($contactsJob, $this->request->data);
            if ($this->ContactsJobs->save($contactsJob)) {
                $this->Flash->success(__('The contact association has been saved.'));
                if ($job_id) {
                  return $this->redirect(['action' => 'view', 'controller' => 'jobs', '#' => 'contacts', $job_id]);
                } else {
                    return $this->redirect(['action' => 'index', 'controller' => 'contacts']);
                }
            } else {
                $this->Flash->error(__('The contact association could not be saved. Please, try again.'));
                if ($job_id) {
                  return $this->redirect(['action' => 'view', 'controller' => 'jobs', '#' => 'contacts', $job_id]);
                } else {
                    return $this->redirect(['action' => 'index', 'controller' => 'contacts']);
                }
            }
        }
        $jobs = $this->ContactsJobs->Jobs->find('list');
        $contacts = $this->Helper->prepareViewList('contacts', ['id', 'first_name', 'last_name', 'email', 'campus_company', 'school'], ' - ');
        $contactsAssociations = $this->Helper->prepareViewList('contacts_jobs', ['contact_id', 'job_id'], '|');

            /** This removes a contact from contacts dropdown if a given
             * contact is already assigned to the jobs. This prevents assiginig the same
             * contact with the job twice (which would produce an error and is bad UX)
             */
            foreach ($contactsAssociations as $assoc) {
                $assoc = explode('|', $assoc);
                $job_contacts['contact_id'] = $assoc[0];
                $job_contacts['job_id'] = isset($assoc[1]) ? $assoc[1] : null;
                if ($job_id == $job_contacts['job_id']) { 
                    unset($contacts[$job_contacts['contact_id']]);
                }
            }

        $this->set(compact('contactsJob', 'jobs', 'contacts', 'job_id'));
        $this->set('_serialize', ['contactsJob']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contacts Job id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null, $job_id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contactsJob = $this->ContactsJobs->get($id);
        if ($this->ContactsJobs->delete($contactsJob)) {
            $this->Flash->success(__('The contact association has been deleted.'));
            return $this->redirect(['action' => 'view', 'controller' => 'jobs', '#' => 'contacts', $job_id]);
        } else {
            $this->Flash->error(__('The contact association could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'view', 'controller' => 'jobs', '#' => 'contacts', $job_id]);
        return $this->redirect(['action' => 'index']);
    }

  /**
  * View method
  *
  * @param string|null $id Contact id.
  * @return void
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function view($id = null)
  {
     $contactsJob = $this->ContactsJobs->get($id, [
         'contain' => ['Contacts', 'Jobs']
     ]);
     $this->set('contactsJob', $contactsJob);
     $this->set('_serialize', ['contact']);
  }
}
