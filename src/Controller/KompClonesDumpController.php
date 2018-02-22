<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * KompClonesDump Controller
 *
 * @property \App\Model\Table\KompClonesDumpTable $KompClonesDump
 *
 * @method \App\Model\Entity\KompClonesDump[] paginate($object = null, array $settings = [])
 */
class KompClonesDumpController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        //Prepare DataTables.js view
        if ($this->request->is('json')) {
            // Notices from time parser break json view, so let's mute them (yikes!);
            @$resp = $this->Search->getDataTablesResultSet($this->request, 'KompClonesDump');
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    //Used by Middleware Application via RT-LIMS API
    public function getlastentry()
    {
        $conn = ConnectionManager::get('default');
        $qry = 'SELECT * from komp_clones_dump ORDER BY id DESC LIMIT 1';
        $lastEntry = $conn->execute($qry)->fetch('assoc');
   
        $this->set(compact('lastEntry'));
        $this->set('_serialize', ['lastEntry']);
    }

    /**
     * View method
     *
     * @param string|null $id Komp Clones Dump id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $ajax=null)
    {
        $kompClonesDump = $this->KompClonesDump->get($id, [
            'contain' => ['EsCells', 'EsCells.QualityControls', 'EsCells.QualityControls.QcCreflips', 'EsCells.QualityControls.QcGenotypes', 
            'EsCells.QualityControls.QcGermlines', 'EsCells.QualityControls.QcGrowths', 'EsCells.QualityControls.QcKaryotypes', 
            'EsCells.QualityControls.QcMicroinjections', 'EsCells.QualityControls.QcPathogens', 'EsCells.QualityControls.QcResequencings', 
            'EsCells.QualityControls.QcTmks', 'EsCells.QualityControls.QcCustomerInvivos', 'EsCells.InventoryVials']
        ]);
        $this->set('kompClonesDump', $kompClonesDump);
        $this->set('_serialize', ['kompClonesDump']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kompClonesDump = $this->KompClonesDump->newEntity();
        if ($this->request->is('post')) {
            $kompClonesDump = $this->KompClonesDump->patchEntity($kompClonesDump, $this->request->data);
            if ($this->KompClonesDump->save($kompClonesDump)) {
                $this->Flash->success(__('The komp clones dump has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The komp clones dump could not be saved. Please, try again.'));
        }
        $this->set(compact('kompClonesDump'));
        $this->set('_serialize', ['kompClonesDump']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Komp Clones Dump id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kompClonesDump = $this->KompClonesDump->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kompClonesDump = $this->KompClonesDump->patchEntity($kompClonesDump, $this->request->data);
            if ($this->KompClonesDump->save($kompClonesDump)) {
                $this->Flash->success(__('The komp clones dump has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The komp clones dump could not be saved. Please, try again.'));
        }
        $this->set(compact('kompClonesDump'));
        $this->set('_serialize', ['kompClonesDump']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Komp Clones Dump id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kompClonesDump = $this->KompClonesDump->get($id);
        if ($this->KompClonesDump->delete($kompClonesDump)) {
            $this->Flash->success(__('The komp clones dump has been deleted.'));
        } else {
            $this->Flash->error(__('The komp clones dump could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
