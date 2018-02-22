<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager; //for truncate() method

/**
 * KompProjectsDump Controller
 *
 * @property \App\Model\Table\KompProjectsDumpTable $KompProjectsDump
 */
class KompProjectsDumpController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($ajax = null)
    {
        $kompProjectsDumps = $this->KompProjectsDump->find('all');

        if ($ajax) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', json_encode($kompProjectsDumps));
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set('kompProjectsDumps', $kompProjectsDumps);
            $this->set('_serialize', ['kompProjectsDumps']);
        }
    }
    
    public function truncate()
    {
        $conn = ConnectionManager::get('default');
        $conn->execute('TRUNCATE komp_projects_dump');
    }

    /**
     * View method
     *
     * @param string|null $id Komp Projects Dump id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kompProjectsDump = $this->KompProjectsDump->get($id, [
            'contain' => []
        ]);

        $this->set('kompProjectsDump', $kompProjectsDump);
        $this->set('_serialize', ['kompProjectsDump']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kompProjectsDump = $this->KompProjectsDump->newEntity();
        if ($this->request->is('post')) {
            $kompProjectsDump = $this->KompProjectsDump->patchEntity($kompProjectsDump, $this->request->data);
            if ($this->KompProjectsDump->save($kompProjectsDump)) {
                $this->Flash->success(__('The komp projects dump has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The komp projects dump could not be saved. Please, try again.'));
        }
        $this->set(compact('kompProjectsDump'));
        $this->set('_serialize', ['kompProjectsDump']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Komp Projects Dump id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kompProjectsDump = $this->KompProjectsDump->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kompProjectsDump = $this->KompProjectsDump->patchEntity($kompProjectsDump, $this->request->data);
            if ($this->KompProjectsDump->save($kompProjectsDump)) {
                $this->Flash->success(__('The komp projects dump has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The komp projects dump could not be saved. Please, try again.'));
        }
        $this->set(compact('kompProjectsDump'));
        $this->set('_serialize', ['kompProjectsDump']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Komp Projects Dump id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kompProjectsDump = $this->KompProjectsDump->get($id);
        if ($this->KompProjectsDump->delete($kompProjectsDump)) {
            $this->Flash->success(__('The komp projects dump has been deleted.'));
        } else {
            $this->Flash->error(__('The komp projects dump could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
