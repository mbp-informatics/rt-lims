<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager; //for truncate() method

/**
 * ImitsDumpMiAttempts Controller
 *
 * @property \App\Model\Table\ImitsDumpMiAttemptsTable $ImitsDumpMiAttempts
 */
class ImitsDumpMiAttemptsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $imitsDumpMiAttempts = $this->ImitsDumpMiAttempts->find('all');
        $this->set(compact('imitsDumpMiAttempts'));
        $this->set('_serialize', ['imitsDumpMiAttempts']);
    }

    public function truncate()
    {
        $conn = ConnectionManager::get('default');
        $conn->execute('TRUNCATE imits_dump_mi_attempts');
    }

    /**
     * View method
     *
     * @param string|null $id Imits Dump Mi Attempt id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $imitsDumpMiAttempt = $this->ImitsDumpMiAttempts->get($id, [
            'contain' => []
        ]);

        $this->set('imitsDumpMiAttempt', $imitsDumpMiAttempt);
        $this->set('_serialize', ['imitsDumpMiAttempt']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $imitsDumpMiAttempt = $this->ImitsDumpMiAttempts->newEntity();
        if ($this->request->is('post')) {
            $imitsDumpMiAttempt = $this->ImitsDumpMiAttempts->patchEntity($imitsDumpMiAttempt, $this->request->data);
            if ($this->ImitsDumpMiAttempts->save($imitsDumpMiAttempt)) {
                $this->Flash->success(__('The imits dump mi attempt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The imits dump mi attempt could not be saved. Please, try again.'));
        }
        $this->set(compact('imitsDumpMiAttempt'));
        $this->set('_serialize', ['imitsDumpMiAttempt']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Imits Dump Mi Attempt id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $imitsDumpMiAttempt = $this->ImitsDumpMiAttempts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $imitsDumpMiAttempt = $this->ImitsDumpMiAttempts->patchEntity($imitsDumpMiAttempt, $this->request->data);
            if ($this->ImitsDumpMiAttempts->save($imitsDumpMiAttempt)) {
                $this->Flash->success(__('The imits dump mi attempt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The imits dump mi attempt could not be saved. Please, try again.'));
        }
        $this->set(compact('imitsDumpMiAttempt'));
        $this->set('_serialize', ['imitsDumpMiAttempt']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Imits Dump Mi Attempt id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $imitsDumpMiAttempt = $this->ImitsDumpMiAttempts->get($id);
        if ($this->ImitsDumpMiAttempts->delete($imitsDumpMiAttempt)) {
            $this->Flash->success(__('The imits dump mi attempt has been deleted.'));
        } else {
            $this->Flash->error(__('The imits dump mi attempt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
