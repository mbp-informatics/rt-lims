<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectsInjections Controller
 *
 * @property \App\Model\Table\ProjectsInjectionsTable $ProjectsInjections
 */
class ProjectsInjectionsController extends AppController
{
    public $components = array('Project'); 

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $projectsInjections = $this->ProjectsInjections->find('all')->contain(['Users', 'Projects'=>['ProjectTypes', 'Mutations', 'Phenotypes'], 'Injections']);;

        $this->set(compact('projectsInjections'));
        $this->set('_serialize', ['projectsInjections']);
    }

    /**
     * View method
     *
     * @param string|null $id Projects Injection id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectsInjection = $this->ProjectsInjections->get($id, [
            'contain' => ['Users', 'Projects'=>['ProjectTypes', 'Mutations', 'Phenotypes'], 'Injections']
        ]);

        $this->set('projectsInjection', $projectsInjection);
        $this->set('_serialize', ['projectsInjection']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectsInjection = $this->ProjectsInjections->newEntity();
        if ($this->request->is('post')) {
            $projectsInjection = $this->ProjectsInjections->patchEntity($projectsInjection, $this->request->data);
            if ($this->ProjectsInjections->save($projectsInjection)) {
                $this->Flash->success(__('The projects injection has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projects injection could not be saved. Please, try again.'));
        }
        $injections = $this->ProjectsInjections->Injections->find('list');
        $projects = $this->ProjectsInjections->Projects->find('list');
        $this->set(compact('projectsInjection', 'projects', 'injections'));
        $this->set('_serialize', ['projectsInjection']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Projects Injection id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectsInjection = $this->ProjectsInjections->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectsInjection = $this->ProjectsInjections->patchEntity($projectsInjection, $this->request->data);
            if ($this->ProjectsInjections->save($projectsInjection)) {
                $this->Flash->success(__('The projects injection has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projects injection could not be saved. Please, try again.'));
        }
        $injections = $this->ProjectsInjections->Injections->find('list');
        $projects = $this->ProjectsInjections->Projects->find('list');
        $this->set(compact('projectsInjection', 'projects', 'injections'));
        $this->set('_serialize', ['projectsInjection']);
    }

    /**
     * 'Edit' all projects associated with an injection method, in fact this method
     *  removes all project associated with a given injection and then populated the
     *  projects_injections table for that injection again. Sinmpler than trying
     *  to figure out which row to edit.
     *
     * @param string|null $id Projects Injection id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editMultiple($injectionId)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Remove all prvious associations
            $this->ProjectsInjections->deleteAll(['injection_id =' => $injectionId]);

            //If no projects speified, only clear the associations
            if (!isset($this->request->data['project_id'])) {
                $this->Flash->warning(__("The project<->injection associations have been CLEARED."));
                return $this->redirect(['controller' => 'injections', 'action' => 'view', $injectionId]);
            }

            //Remove dupes
            $data = array_unique($this->request->data['project_id']);

            // Save all associations afresh
            foreach ($data as $pid) {
                $projectsInjection = $this->ProjectsInjections->newEntity();
                $projectsInjection = $this->ProjectsInjections->patchEntity($projectsInjection, ['injection_id' => $injectionId, 'project_id' => $pid, 'user_id' => $this->Auth->user()['id']]);
                
                if ($res = $this->ProjectsInjections->save($projectsInjection)) {
                    $this->Flash->success(__("The project<->injection association {$res->id} has been saved."));
                } else {
                    $this->Flash->error(__('The project<->injection association could not be saved. Please, try again.'));
                }
                unset($projectsInjection);
            }
           return $this->redirect(['controller' => 'injections', 'action' => 'view', $injectionId]);
        }

        $projectsInjection = $this->ProjectsInjections
        ->find('all')
        ->where(['injection_id =' => (int) $injectionId])->toArray();
        if (!$projectsInjection) {
            $projectsInjection = $this->ProjectsInjections->newEntity(); //to prevent errors in the view
        }

        $this->loadModel('Projects');
        foreach ($this->Projects->find('list') as $pid => $displayField) {
                $projectNames[$pid] = $this->Project->getName($pid);
        }

        $this->set(compact('projectsInjection', 'projectNames', 'injectionId'));
        $this->set('_serialize', ['projectsInjection']);
    }


    /**
     * Delete method
     *
     * @param string|null $id Projects Injection id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectsInjection = $this->ProjectsInjections->get($id);
        if ($this->ProjectsInjections->delete($projectsInjection)) {
            $this->Flash->success(__('The projects injection has been deleted.'));
        } else {
            $this->Flash->error(__('The projects injection could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
