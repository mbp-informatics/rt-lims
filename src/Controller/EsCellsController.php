<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EsCells Controller
 *
 * @property \App\Model\Table\EsCellsTable $EsCells
 */
class EsCellsController extends AppController
{
    public $components = array('ChangeLog', 'Helper'); 

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ($this->request->is('json')) {
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'EsCells');
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'EsCells');
            }
            foreach ($resp['data'] as $k=>$es) {
                $resp['data'][$k]['id_action'] = $es->id;
                $resp['data'][$k]['id'] = "<a href='/es-cells/view/{$es->id}'>{$es->id}</a>";
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    // public function index()
    // {
    //     $this->paginate = [
    //         'contain' => [ 'Users']
    //     ];
    //     $this->set('esCells', $this->paginate($this->EsCells));
    //     $this->set('_serialize', ['esCells']);
    // }

    /**
     * View method
     *
     * @param string|null $id Es Cell id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $esCell = $this->EsCells->get($id, [
            'contain' => ['Users', 'InventoryVials', 'QualityControls', 'ChildEsCells', 'QualityControls.QcCreflips', 'QualityControls.QcGenotypes', 
            'QualityControls.QcGermlines', 'QualityControls.QcGrowths', 'QualityControls.QcKaryotypes', 'QualityControls.QcMicroinjections', 
            'QualityControls.QcPathogens', 'QualityControls.QcResequencings', 'QualityControls.QcTmks',]
        ]);
        $this->set('esCell', $esCell);
        $this->set('_serialize', ['esCell']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $esCell = $this->EsCells->newEntity();
        if ($this->request->is('post')) {
            $esCell = $this->EsCells->patchEntity($esCell, $this->request->data);
            if ($this->EsCells->save($esCell)) {
                $this->Flash->success(__('The es cell has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The es cell could not be saved. Please, try again.'));
            }
        }
        $parentEsCells = $this->EsCells->ParentEsCells->find('list', ['limit' => 200]);
        $projects = $this->EsCells->Projects->find('list', ['limit' => 200]);
        $users = $this->EsCells->Users->find('list', ['limit' => 200]);
        $this->set(compact('esCell', 'parentEsCells', 'projects', 'users'));
        $this->set('_serialize', ['esCell']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Es Cell id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $esCell = $this->EsCells->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $esCell = $this->EsCells->patchEntity($esCell, $this->request->data);
            if ($this->EsCells->save($esCell)) {
                $this->Flash->success(__('The es cell has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The es cell could not be saved. Please, try again.'));
            }
        }
        $parentEsCells = $this->EsCells->ParentEsCells->find('list', ['limit' => 200]);
        $projects = $this->EsCells->Projects->find('list', ['limit' => 200]);
        $users = $this->EsCells->Users->find('list', ['limit' => 200]);
        $this->set(compact('esCell', 'parentEsCells', 'projects', 'users'));
        $this->set('_serialize', ['esCell']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Es Cell id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $esCell = $this->EsCells->get($id);
        if ($this->EsCells->delete($esCell)) {
            $this->Flash->success(__('The es cell has been deleted.'));
        } else {
            $this->Flash->error(__('The es cell could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
