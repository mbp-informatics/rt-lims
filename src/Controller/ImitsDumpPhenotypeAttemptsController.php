<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager; //for truncate() method

/**
 * ImitsDumpPhenotypeAttempts Controller
 *
 * @property \App\Model\Table\ImitsDumpPhenotypeAttemptsTable $ImitsDumpPhenotypeAttempts
 */
class ImitsDumpPhenotypeAttemptsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $imitsDumpPhenotypeAttempts = $this->ImitsDumpPhenotypeAttempts->find('all');
        $this->set('imitsDumpPhenotypeAttempts', $imitsDumpPhenotypeAttempts);
        $this->set('_serialize', ['imitsDumpPhenotypeAttempts']);
    }

    public function truncate()
    {
        $conn = ConnectionManager::get('default');
        $conn->execute('TRUNCATE imits_dump_phenotype_attempts');
    }

    /**
     * View method
     *
     * @param string|null $id Imits Dump Phenotype Attempt id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $imitsDumpPhenotypeAttempt = $this->ImitsDumpPhenotypeAttempts->get($id, [
            'contain' => []
        ]);

        $this->set('imitsDumpPhenotypeAttempt', $imitsDumpPhenotypeAttempt);
        $this->set('_serialize', ['imitsDumpPhenotypeAttempt']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $imitsDumpPhenotypeAttempt = $this->ImitsDumpPhenotypeAttempts->newEntity();
        if ($this->request->is('post')) {
            $imitsDumpPhenotypeAttempt = $this->ImitsDumpPhenotypeAttempts->patchEntity($imitsDumpPhenotypeAttempt, $this->request->data);
            if ($this->ImitsDumpPhenotypeAttempts->save($imitsDumpPhenotypeAttempt)) {
                $this->Flash->success(__('The imits dump phenotype attempt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The imits dump phenotype attempt could not be saved. Please, try again.'));
        }
        $this->set(compact('imitsDumpPhenotypeAttempt'));
        $this->set('_serialize', ['imitsDumpPhenotypeAttempt']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Imits Dump Phenotype Attempt id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $imitsDumpPhenotypeAttempt = $this->ImitsDumpPhenotypeAttempts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $imitsDumpPhenotypeAttempt = $this->ImitsDumpPhenotypeAttempts->patchEntity($imitsDumpPhenotypeAttempt, $this->request->data);
            if ($this->ImitsDumpPhenotypeAttempts->save($imitsDumpPhenotypeAttempt)) {
                $this->Flash->success(__('The imits dump phenotype attempt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The imits dump phenotype attempt could not be saved. Please, try again.'));
        }
        $this->set(compact('imitsDumpPhenotypeAttempt'));
        $this->set('_serialize', ['imitsDumpPhenotypeAttempt']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Imits Dump Phenotype Attempt id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $imitsDumpPhenotypeAttempt = $this->ImitsDumpPhenotypeAttempts->get($id);
        if ($this->ImitsDumpPhenotypeAttempts->delete($imitsDumpPhenotypeAttempt)) {
            $this->Flash->success(__('The imits dump phenotype attempt has been deleted.'));
        } else {
            $this->Flash->error(__('The imits dump phenotype attempt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
