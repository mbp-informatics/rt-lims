<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QcMicroinjections Controller
 *
 * @property \App\Model\Table\QcMicroinjectionsTable $QcMicroinjections
 */
class QcMicroinjectionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $this->set('qcMicroinjections', $this->paginate($this->QcMicroinjections));
        $this->set('_serialize', ['qcMicroinjections']);
    }

    /**
     * View method
     *
     * @param string|null $id Qc Microinjection id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qcMicroinjection = $this->QcMicroinjections->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('qcMicroinjection', $qcMicroinjection);
        $this->set('_serialize', ['qcMicroinjection']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($qcID=null)
    {
        $qcMicroinjection = $this->QcMicroinjections->newEntity();
        if ($this->request->is('post')) {
            $qcMicroinjection = $this->QcMicroinjections->patchEntity($qcMicroinjection, $this->request->data);
            if ($this->QcMicroinjections->save($qcMicroinjection)) {
                $this->Flash->success(__('The qc microinjection has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc microinjection could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcMicroinjections->QualityControls->find('list');
        $users = $this->QcMicroinjections->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcMicroinjection', 'users', 'qcID', 'qualityControls'));
        $this->set('_serialize', ['qcMicroinjection']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qc Microinjection id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qcMicroinjection = $this->QcMicroinjections->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qcMicroinjection = $this->QcMicroinjections->patchEntity($qcMicroinjection, $this->request->data);
            if ($this->QcMicroinjections->save($qcMicroinjection)) {
                $this->Flash->success(__('The qc microinjection has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc microinjection could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcMicroinjections->QualityControls->find('list');
        $users = $this->QcMicroinjections->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcMicroinjection', 'users', 'qualityControls'));
        $this->set('_serialize', ['qcMicroinjection']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qc Microinjection id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qcMicroinjection = $this->QcMicroinjections->get($id);
        if ($this->QcMicroinjections->delete($qcMicroinjection)) {
            $this->Flash->success(__('The qc microinjection has been deleted.'));
        } else {
            $this->Flash->error(__('The qc microinjection could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
