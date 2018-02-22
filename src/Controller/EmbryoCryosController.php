<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * EmbryoCryos Controller
 *
 * @property \App\Model\Table\EmbryoCryosTable $EmbryoCryos
 */
class EmbryoCryosController extends AppController
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
            $contain = ['Jobs', 'InventoryVials'];
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'EmbryoCryos', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'EmbryoCryos', $contain);
            }

            foreach ($resp['data'] as $k=>$ec) {
                $resp['data'][$k]['id_action'] = $ec->id;
                $resp['data'][$k]['id'] = "<a href='/embryo-cryos/view/{$ec->id}' target='_blank'>{$ec->id}</a>";
                $resp['data'][$k]['job_id'] = "<a href='/jobs/view/{$ec->job_id}' target='_blank'>{$ec->job_id}</a>";
                if ($ec->job) {
                    $resp['data'][$k]['stock_number'] = $ec->job->mmrrc_no;
                } else {
                    $resp['data'][$k]['stock_number'] = '';
                }
                if ($ec->inventory_vials){

                    $embryoCount = 0;
                    foreach ($ec->inventory_vials as $vial) {
                        if ($vial->volume) {
                            $embryoCount += $vial->volume;
                        }
                    }

                    // $samplesCount = count($ec->embryoCount);
                    $resp['data'][$k]['vial_count'] = $embryoCount;
                } else {
                    $resp['data'][$k]['vial_count'] = '-';
                } 
                if ($ec->blasts_no && $ec->cultured_no ) {
                    if ($ec->cultured_no > 0) {
                        $resp['data'][$k]['blast_rate'] = number_format( ($ec->blasts_no / $ec->cultured_no)*100,2) . '%';

                    } else {
                        $resp['data'][$k]['blast_rate'] = '-';
                    }    
                } else {
                    $resp['data'][$k]['blast_rate'] = '-';
                } 
                if($ec->genotype_confirmed) {
                    $resp['data'][$k]['genotype_confirmed'] = 'Yes';
                } else {
                    $resp['data'][$k]['genotype_confirmed'] = 'No';
                }
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Embryo Cryo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null, $ajax = null)
    {
        $embryoCryo = $this->EmbryoCryos->get($id, [
            'contain' => [
                'Users','Jobs', 'EmbryoResus',
                'InventoryVials' => [
                    'InventoryVialTypes',
                    'InventoryLocations'=> [
                        'InventoryBoxes' => [
                            'InventoryBoxTypes',
                            'InventoryContainers' => [
                                'ParentInventoryContainers',
                                'ChildInventoryContainers'
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $vf = $embryoCryo->toArray()['verified_by'];
        if ($vf) {
            $verifyUser = $this->EmbryoCryos->Users->find('All')->where(['id' => $vf])->first()->toArray();
            $userName = $verifyUser['name'];            
        } else {
            $userName = Null;
        }

        /* Get all vials for a given EC id and patch it with Container/Box hierarchy */
        if ( $allVials = $this->Helper->getAllVials(null, $embryoCryo->id) ) {
            //First reindex so that array index = container id
            $inventoryContainers = [];
            foreach ($this->EmbryoCryos->InventoryVials->InventoryLocations->InventoryBoxes->InventoryContainers->find('all')->toArray() as $container) {
                $inventoryContainers[$container->id] = $container;
            }
            //Then prepare an array of all containers and the box
            foreach ($allVials as &$vial) {
                if ($vial->ship_thaw_date || !isset($vial->inventory_location_id)) { continue; } // skip hierarchy for shipped vials
                $childId = $vial->inventory_location->inventory_box->inventory_container_id;
                $container = $vial->inventory_location->inventory_box->inventory_container;
                $box = $vial->inventory_location->inventory_box;
                $parentsArr = $this->Helper->getContainerParents($childId, $inventoryContainers);
                array_unshift($parentsArr, $container);
                array_unshift($parentsArr, $box);
                $vial['parent_containers'] = $parentsArr;
            }
            unset($vial);
        }

        /* Get change log for this and associated tables */
        $parentModel = ['tableName' => 'EmbryoCryos', 'id' => $id];
        $children = ['fk' => 'embryo_cryo_id', 'tables' => ['EmbryoTransfers', 'InventoryVials']];
        $changes = $this->ChangeLog->getAssocChangeLog($parentModel, $children);

        if ($embryoCryo['job_id']) {
            $embryoCryo['pi'] = $this->EmbryoCryos->Jobs->getInvestigatorName($embryoCryo['job_id']);
        }

        if ($ajax) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', $embryoCryo);
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set(compact('embryoCryo', 'allVials', 'userName'));
            $this->set('changes', $changes);
            $this->set('_serialize', ['embryoCryo']);
        }
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($job_id=null)
    {
        $embryoCryo = $this->EmbryoCryos->newEntity();
        if ($this->request->is('post')) {
            $embryoCryo = $this->EmbryoCryos->patchEntity($embryoCryo, $this->request->data);
            if ($this->EmbryoCryos->save($embryoCryo)) {
                $this->Flash->success(__('The embryo cryo has been saved.'));
                return $this->redirect(['controller'=>'EmbryoCryos', 'action' => 'view', $embryoCryo->id]);
            } else {
                $this->Flash->error(__('The embryo cryo could not be saved. Please, try again.'));
            }
        }
        $users = $this->EmbryoCryos->Users->find('list');
        $jobs = $this->EmbryoCryos->Jobs->find('list');
        $ivfs = $this->EmbryoCryos->Ivfs->find('list');
        $inventoryVials = $this->EmbryoCryos->InventoryVials->find('list');
        $this->set(compact('embryoCryo', 'users', 'jobs', 'ivfs','job_id', 'inventoryVials'));
        $this->set('_serialize', ['embryoCryo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Embryo Cryo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $embryoCryo = $this->EmbryoCryos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $embryoCryo = $this->EmbryoCryos->patchEntity($embryoCryo, $this->request->data);
            if ($this->EmbryoCryos->save($embryoCryo)) {
                //If the blast rate is > 50, then update the associated vial that it passed QA. If not, update that it failed. If not edited it will just save
                if (isset($embryoCryo->blasts_no) && isset($embryoCryo->cultured_no) ) {
                    if ($embryoCryo->cultured_no > 0) {
                        $blastRate = number_format( ($embryoCryo->blasts_no / $embryoCryo->cultured_no)*100,2) . '%';
                    } else {
                        $blastRate = null;
                    }
                } else {
                    $blastRate = null;
                }
                // if (isset($embryoCryo->straw_id_no) and $blastRate) {
                //     $vial_id = $embryoCryo->straw_id_no;
                //     $inventoryVials = $this->loadModel('InventoryVials');
                //     $inventoryVial = $this->InventoryVials->get($vial_id, [
                //         'contain' => []
                //     ]);
                //     if ($blastRate >= 50) {
                //         $inventoryVial->qc_pass = "Yes";
                //     } else {
                //         $inventoryVial->qc_pass = "No";
                //     }                    
                //     if($inventoryVials->save($inventoryVial)){
                //         $this->Flash->success(__('The embryo cryo has been saved.'));
                //         return $this->redirect(['action' => 'view', 'controller' => 'embryoCryos', $embryoCryo->id]);
                //     } else {
                //         $this->Flash->error(__('The embryo cryo could not be saved due to the Blast Rate. Please, try again.'));
                //     }
                // }
                $this->Flash->success(__('The embryo cryo has been saved.'));
                return $this->redirect(['action' => 'view', 'controller' => 'embryoCryos', $embryoCryo->id]);
            } else {
                $this->Flash->error(__('The embryo cryo could not be saved. Please, try again.'));
            }
        }
        $users = $this->EmbryoCryos->Users->find('list');
        $jobs = $this->EmbryoCryos->Jobs->find('list');
        $ivfs = $this->EmbryoCryos->Ivfs->find('list');
        $job_id = $embryoCryo->job_id;
        $this->set(compact('embryoCryo', 'users', 'jobs', 'ivfs','job_id'));
        $this->set('_serialize', ['embryoCryo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Embryo Cryo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $embryoCryo = $this->EmbryoCryos->get($id);
        if ($this->EmbryoCryos->delete($embryoCryo)) {
            $this->Flash->success(__('The embryo cryo has been deleted.'));
        } else {
            $this->Flash->error(__('The embryo cryo could not be deleted. Please, try again.'));
        }
		return $this->redirect(['controller'=> 'Jobs', 'action' => 'view', '#' => 'related-data', $embryoCryo->job_id]);
    }

    public function verify($id, $user)
    {
        $embryoCryo = $this->EmbryoCryos->get($id, [
            'contain' => ['Users']
        ]);

        $conn = ConnectionManager::get('default');
        $verify = $conn->execute('UPDATE embryo_cryos SET verified = 1, verified_by = :user, verified_time = NOW() where id = :id', ['user' => $user, 'id' =>$id]);

        if ($verify) {
            $this->Flash->success(__('The embryo cryo inventory has been verified'));
            return $this->redirect(['controller'=>'EmbryoCryos', 'action' => 'view', $embryoCryo->id]);
        } else {
            $this->Flash->error(__('The embryo cryo inventory was not verified. Please try again.'));
        }            

        $embryoCryo = $this->EmbryoCryos->find('list');
        $this->set(compact('embryoCryo', 'users'));
        $this->set('_serialize', ['embryoCryo']);
    }
}
