<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QcPathogens Controller
 *
 * @property \App\Model\Table\QcPathogensTable $QcPathogens
 */
class QcPathogensController extends AppController
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
        $this->set('qcPathogens', $this->paginate($this->QcPathogens));
        $this->set('_serialize', ['qcPathogens']);
    }

    /**
     * View method
     *
     * @param string|null $id Qc Pathogen id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qcPathogen = $this->QcPathogens->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('qcPathogen', $qcPathogen);
        $this->set('_serialize', ['qcPathogen']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($qcID=null)
    {
        $qcPathogen = $this->QcPathogens->newEntity();
        if ($this->request->is('post')) {
            $qcPathogen = $this->QcPathogens->patchEntity($qcPathogen, $this->request->data);
            if ($this->QcPathogens->save($qcPathogen)) {
                $this->Flash->success(__('The qc pathogen has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc pathogen could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcPathogens->QualityControls->find('list');
        $users = $this->QcPathogens->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcPathogen', 'users', 'qcID', 'qualityControls'));
        $this->set('_serialize', ['qcPathogen']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qc Pathogen id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qcPathogen = $this->QcPathogens->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qcPathogen = $this->QcPathogens->patchEntity($qcPathogen, $this->request->data);
            if ($this->QcPathogens->save($qcPathogen)) {
                $this->Flash->success(__('The qc pathogen has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The qc pathogen could not be saved. Please, try again.'));
            }
        }
        $qualityControls = $this->QcPathogens->QualityControls->find('list');
        $users = $this->QcPathogens->Users->find('list', ['limit' => 200]);
        $this->set(compact('qcPathogen', 'users', 'qualityControls'));
        $this->set('_serialize', ['qcPathogen']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qc Pathogen id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qcPathogen = $this->QcPathogens->get($id);
        if ($this->QcPathogens->delete($qcPathogen)) {
            $this->Flash->success(__('The qc pathogen has been deleted.'));
        } else {
            $this->Flash->error(__('The qc pathogen could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
