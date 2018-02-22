<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * KompGenesDump Controller
 *
 * @property \App\Model\Table\KompGenesDumpTable $KompGenesDump
 */
class KompGenesDumpController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        if ($this->request->is('json')) {
            // Notices from time parser break json view, so let's mute them (yikes!);
            @$resp = $this->Search->getDataTablesResultSet($this->request, 'KompGenesDump');
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    //Used by Middleware Application via RT-LIMS API
    public function getlastentry()
    {
        $conn = ConnectionManager::get('default');
        $qry = 'SELECT * from komp_genes_dump ORDER BY id DESC LIMIT 1';
        $lastEntry = $conn->execute($qry)->fetch('assoc');
        $this->set(compact('lastEntry'));
        $this->set('_serialize', ['lastEntry']);
    }

    /**
     * View method
     *
     * @param string|null $id Komp Genes Dump id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kompGenesDump = $this->KompGenesDump->get($id, [
            'contain' => []
        ]);

        $this->set('kompGenesDump', $kompGenesDump);
        $this->set('_serialize', ['kompGenesDump']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kompGenesDump = $this->KompGenesDump->newEntity();
        if ($this->request->is('post')) {
            $kompGenesDump = $this->KompGenesDump->patchEntity($kompGenesDump, $this->request->data);
            if ($this->KompGenesDump->save($kompGenesDump)) {
                $this->Flash->success(__('The komp genes dump has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The komp genes dump could not be saved. Please, try again.'));
        }
        $this->set(compact('kompGenesDump'));
        $this->set('_serialize', ['kompGenesDump']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Komp Genes Dump id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kompGenesDump = $this->KompGenesDump->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kompGenesDump = $this->KompGenesDump->patchEntity($kompGenesDump, $this->request->data);
            if ($this->KompGenesDump->save($kompGenesDump)) {
                $this->Flash->success(__('The komp genes dump has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The komp genes dump could not be saved. Please, try again.'));
        }
        $this->set(compact('kompGenesDump'));
        $this->set('_serialize', ['kompGenesDump']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Komp Genes Dump id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kompGenesDump = $this->KompGenesDump->get($id);
        if ($this->KompGenesDump->delete($kompGenesDump)) {
            $this->Flash->success(__('The komp genes dump has been deleted.'));
        } else {
            $this->Flash->error(__('The komp genes dump could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
