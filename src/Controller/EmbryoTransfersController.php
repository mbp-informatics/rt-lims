<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * EmbryoTransfers Controller
 *
 * @property \App\Model\Table\EmbryoTransfersTable $EmbryoTransfers
 */
class EmbryoTransfersController extends AppController
{
    public $components = ['Helper', 'AppErrors', 'Injection', 'ChangeLog', 'Colony'];
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
        //Prepare DataTables.js view
        if ($this->request->is('json')) {

            $contain = ['Jobs', 'Recipients', 'Injections.Colonies'];
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'EmbryoTransfers', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'EmbryoTransfers', $contain);
            }

            // process the result set 
            foreach ($resp['data'] as $k=>$et) {
                $resp['data'][$k]['id_action'] = $et->id;
                $resp['data'][$k]['id'] = "<a href='/embryo-transfers/view/{$et->id}' target='_blank'>{$et->id}</a>";
                $resp['data'][$k]['ivf_id'] = "<a href='/ivfs/view/{$et->ivf_id}' target='_blank'>{$et->ivf_id}</a>";
                $resp['data'][$k]['job_id'] = "<a href='/jobs/view/{$et->job_id}' target='_blank'>{$et->job_id}</a>";

                $embryosCount = 0;
                $malePups = 0;
                $femalePups = 0;
                $totalPups = 0;
                $mutMales = 0;
                $mutFemales = 0;
                $totalMuts = 0;
                $litterCount = 0;
                $litterRate = 0;
                $birthRate = 0;
                $recipientCount = 0;
                if ($et->recipients) {
                    foreach ($et->recipients as $rec){
                        if ($rec->total_tx) {
                            $embryosCount += $rec->total_tx;
                        } 
                        if ($rec->male_pups) {
                            $malePups += $rec->male_pups;
                        } 
                        if ($rec->female_pups) {
                            $femalePups += $rec->female_pups;
                        } 
                        if ($rec->male_mut) {
                            $mutMales += $rec->male_mut;
                        } 
                        if ($rec->female_mut) {
                            $mutFemales += $rec->female_mut;
                        } 
                        $recipientCount +=1;
                        if ($rec->female_pups||$rec->male_pups) {
                            $litterCount += 1;
                        }                        
                    }
                    $totalPups = $femalePups+$malePups;
                    $totalMuts = $mutFemales+$mutMales;
                    if (!$embryosCount == 0) {
                        $birthRate = ($totalPups/$embryosCount)*100;
                    }
                    if (!$recipientCount == 0) {
                        $litterRate = ($litterCount/$recipientCount)*100;
                    }
                }

                $resp['data'][$k]['pups_equation'] = $totalMuts . "/" . $totalPups;
                $resp['data'][$k]['birth_rate'] = round($birthRate, 2);
                $resp['data'][$k]['litterrate'] = round($litterRate, 2);

                if ($et->job) {
                    if ($et->job->mmrrc_no) {
                        $resp['data'][$k]['stock_number'] = $et->job->mmrrc_no;
                    }
                    else {
                        $resp['data'][$k]['stock_number'] = '';
                    }
                } else {
                    $resp['data'][$k]['stock_number'] = '';
                }

                if ($et->job) {
                    if ($et->job->strain_name) {
                        $resp['data'][$k]['strain_name'] = $et->job->strain_name;
                    }
                    else {
                        $resp['data'][$k]['strain_name'] = '';
                    }
                } else {
                    $resp['data'][$k]['strain_name'] = '';
                }

                $resp['data'][$k]['colonies'] = isset($et->injection_id) ? $this->Colony->getName(null, $et->injection_id) : '';
                
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Embryo Transfer id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null, $source=null)
    {
        $embryoTransfer = $this->EmbryoTransfers->get($id, [
            'contain' => ['Jobs', 'EmbryoResus', 'Ivfs', 'Users', 'Recipients', 'EmbryoCryos', 'Injections']
        ]);

        /* Get change log for this and associated tables */
        $parentModel = ['tableName' => 'EmbryoTransfers', 'id' => $id];
        $children = ['fk' => 'embryo_transfer_id', 'tables' => ['Recipients']];
        $changes = $this->ChangeLog->getAssocChangeLog($parentModel, $children);

        $embryoTransfer['pi'] = '';
        if (isset($embryoTransfer['job_id'])) {
            $embryoTransfer['pi'] = $this->EmbryoTransfers->Jobs->getInvestigatorName($embryoTransfer['job_id']);
        }

        if ($source == 'ajax') { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', $embryoTransfer);
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set('changes', $changes);
            $this->set(compact('embryoTransfer', $embryoTransfer, 'source'));
            $this->set('_serialize', ['embryoTransfer']);
        }

    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($source=null)
    {
        // Checks the URL to see if Job or Injection are provided, then passes it to the page to use. 
        if (array_key_exists('job_id', $this->request->query)) {
            $job_id = $this->request->query['job_id'];
        } else {
            $job_id = null;
        }
        if (array_key_exists('injection_id', $this->request->query)) {
            $injection_id = $this->request->query['injection_id'];
        } else {
            $injection_id = null;
        }
        
        $embryoTransfer = $this->EmbryoTransfers->newEntity();
        if ($this->request->is('post')) {
            $embryoTransfer = $this->EmbryoTransfers->patchEntity($embryoTransfer, $this->request->data);
            if ($this->EmbryoTransfers->save($embryoTransfer)) {
                
                /* Set the 'injections.do_imits_update' flag */
                if ($injection_id) {
                    if ($this->Injection->isImitsUpdateNeeded($injection_id)) {
                        $saveStatus = $this->Injection->setImitsUpdateFlag($injection_id);
                    } else {
                        $saveStatus = $this->Injection->clearImitsUpdateFlag($injection_id);
                    }
                    if ($saveStatus === false) {
                        $this->AppErrors->saveError('rt-lims', "Couldn't set 'do_imits_update' flag for the injection.", $injection_id);
                        $this->Flash->error(__("Could not set 'do_imits_update' flag. iMITS WILL NOT GET UPDATED! Contact IT for details."));
                    } elseif ($saveStatus === true) {
                        $this->Flash->success(__("The 'do_imits_update' flag has been updated." ));
                    }
                }
                
                $this->Flash->success(__('The embryo transfer has been saved.'));
                if ($source == 'mtgl') {
                    return $this->redirect(['controller'=>'EmbryoTransfers', 'action' => 'view', $embryoTransfer->id, 'mtgl']);
                } else {
                    return $this->redirect(['controller'=>'EmbryoTransfers', 'action' => 'view', $embryoTransfer->id]);
                };
            } else {
                $this->Flash->error(__('The embryo transfer could not be saved. Please, try again.'));
            }
        }

        $users = $this->EmbryoTransfers->Users->find('list', ['limit' => 200]);
        $this->set(compact('embryoTransfer', 'users', 'source', 'job_id', 'injection_id'));
        $this->set('_serialize', ['embryoTransfer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Embryo Transfer id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $source=null)
    {
        $embryoTransfer = $this->EmbryoTransfers->get($id, [
            'contain' => []
        ]);
        
        // Checks the URL to see if Job or Injection are provided, then passes it to the page to use. 
        if (array_key_exists('job_id', $this->request->query)) {
            $job_id = $this->request->query['job_id'];
        } else {
            $job_id = null;
        }
        if (array_key_exists('injection_id', $this->request->query)) {
            $injection_id = $this->request->query['injection_id'];
        } else {
            $injection_id = null;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $embryoTransfer = $this->EmbryoTransfers->patchEntity($embryoTransfer, $this->request->data);
            if ($this->EmbryoTransfers->save($embryoTransfer)) {

                /* Set the 'injections.do_imits_update' flag */
                if ($injection_id) {
                    if ($this->Injection->isImitsUpdateNeeded($embryoTransfer->injection_id)) {
                        $saveStatus = $this->Injection->setImitsUpdateFlag($embryoTransfer->injection_id);
                    } else {
                        $saveStatus = $this->Injection->clearImitsUpdateFlag($embryoTransfer->injection_id);
                    }
                    if ($saveStatus === false) {
                        $this->AppErrors->saveError('rt-lims', "Couldn't set 'do_imits_update' flag for the injection.", $injection_id);
                        $this->Flash->error(__("Could not set 'do_imits_update' flag. iMITS WILL NOT GET UPDATED! Contact IT for details."));
                    } elseif ($saveStatus === true) {
                        $this->Flash->success(__("The 'do_imits_update' flag has been updated." ));
                    }
                }

                $this->Flash->success(__('The embryo transfer has been saved.'));
                return $this->redirect(['action' => 'view', 'controller' => 'embryoTransfers', $embryoTransfer->id, $source]);
            } else {
                $this->Flash->error(__('The embryo transfer could not be saved. Please, try again.'));
            }
        }
        // $embryoCryos = $this->EmbryoTransfers->EmbryoCryos->find('list');
        // $jobs = $this->EmbryoTransfers->Jobs->find('list');
        // $embryoResus = $this->EmbryoTransfers->EmbryoResus->find('list');
        // $ivfs = $this->EmbryoTransfers->Ivfs->find('list');
        $users = $this->EmbryoTransfers->Users->find('list');
        // $injections = $this->EmbryoTransfers->Injections->find('list');
        $this->set(compact('embryoTransfer', 'users', 'source'));
        $this->set('_serialize', ['embryoTransfer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Embryo Transfer id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $embryoTransfer = $this->EmbryoTransfers->get($id);
        if ($this->EmbryoTransfers->delete($embryoTransfer)) {
            $this->Flash->success(__('The embryo transfer has been deleted.'));
        } else {
            $this->Flash->error(__('The embryo transfer could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function postOp($id)
    {
        $embryoTransfer = $this->EmbryoTransfers->get($id, [
            'contain' => ['Injections', 'Users', 'Recipients', 'Jobs']
        ]);
        
        $date = Time::parse($embryoTransfer->date);
        $dates = [];
        for($i=1; $i<15; $i++){
            $dates[] = $date;
            $date = clone($date->addDay());
        }

        $this->set('colonyName', isset($embryoTransfer->injection_id) ? $this->Colony->getName(null, $embryoTransfer->injection_id) : '');

        $this->set('embryoTransfer', $embryoTransfer);
        $this->set('dates', $dates);

        $this->set('_serialize', ['embryoTransfer', 'dates']);
        $this->viewBuilder()->layout("default-minimal");
    }

}
