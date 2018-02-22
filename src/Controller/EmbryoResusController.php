<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EmbryoResus Controller
 *
 * @property \App\Model\Table\EmbryoResusTable $EmbryoResus
 */
class EmbryoResusController extends AppController
{
    public $components = array('ChangeLog'); 

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ($this->request->is('json')) {

            $contain = ['EmbryoTransfers'];
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'EmbryoResus', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'EmbryoResus', $contain);
            }

            // process the result set
            foreach ($resp['data'] as $k=>$rs) {
                $resp['data'][$k]['id_action'] = $rs->id;
                $resp['data'][$k]['id'] = "<a href='/embryo-resus/view/{$rs->id}' target='_blank'>{$rs->id}</a>";
                if ($rs->job) {
                    $resp['data'][$k]['stock_number'] = $rs->job->mmrrc_no;
                } else {
                    $resp['data'][$k]['stock_number'] = '';
                }
                if ($rs->job) {
                    $resp['data'][$k]['strain_name'] = $rs->job->strain_name;
                } else {
                    $resp['data'][$k]['strain_name'] = '';
                }
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Embryo Resus id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $embryoResus = $this->EmbryoResus->get($id, [
            'contain' => ['Jobs', 'EmbryoCryos', 'EmbryoTransfers']
        ]);

        /* Get change log for this and associated tables */
        $parentModel = ['tableName' => 'EmbryoResus', 'id' => $id];
        $children = ['fk' => 'embryo_resus_id', 'tables' => ['EmbryoTransfers']];
        $changes = $this->ChangeLog->getAssocChangeLog($parentModel, $children);

        $embryoResus['pi'] = $this->EmbryoResus->Jobs->getInvestigatorName($embryoResus['job_id']);
        
        $this->set('embryoResus', $embryoResus);
        $this->set('changes', $changes);
        $this->set('_serialize', ['embryoResus']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($job_id=null, $embryo_cryo_id=null)
    {
        $embryoResus = $this->EmbryoResus->newEntity();
        if ($this->request->is('post')) {
            $embryoResus = $this->EmbryoResus->patchEntity($embryoResus, $this->request->data);
            if ($this->EmbryoResus->save($embryoResus)) {
                $this->Flash->success(__('The embryo resuscitation has been saved.'));
                return $this->redirect(['controller'=>'EmbryoResus', 'action' => 'view', $embryoResus->id]);
            } else {
                $this->Flash->error(__('The embryo resuscitation could not be saved. Please try again.'));
            }
        }
        $jobs = $this->EmbryoResus->Jobs->find('list')->limit(1024*1024);
        $embryoCryos = $this->EmbryoResus->EmbryoCryos->find('list');
        $this->set(compact('embryoResus', 'jobs', 'embryoCryos', 'job_id', 'embryo_cryo_id'));
        $this->set('_serialize', ['embryoResus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Embryo Resus id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $embryoResus = $this->EmbryoResus->get($id, [
            'contain' => ['Jobs', 'EmbryoCryos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $embryoResus = $this->EmbryoResus->patchEntity($embryoResus, $this->request->data);
            if ($this->EmbryoResus->save($embryoResus)) {
                $this->Flash->success(__('The embryo resuscitation has been saved.'));
                return $this->redirect(['controller'=>'EmbryoResus', 'action' => 'view', $embryoResus->id]);
            } else {
                $this->Flash->error(__('The embryo resuscitation could not be saved. Please try again.'));
            }
        }
        $jobs = $this->EmbryoResus->Jobs->find('list');
        $embryoCryos = $this->EmbryoResus->EmbryoCryos->find('list');
        $this->set(compact('embryoResus', 'jobs', 'embryoCryos'));
        $this->set('_serialize', ['embryoResus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Embryo Resus id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $embryoResus = $this->EmbryoResus->get($id);
        if ($this->EmbryoResus->delete($embryoResus)) {
            $this->Flash->success(__('The embryo resuscitation has been deleted.'));
        } else {
            $this->Flash->error(__('The embryo resuscitation could not be deleted. Please try again.'));
        }
        return $this->redirect(['action' => 'view', 'controller' => 'jobs', $embryoResus->job_id, '#' => 'related-data']);
    }
}
