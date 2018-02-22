<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * SpermCryos Controller
 *
 * @property \App\Model\Table\SpermCryosTable $SpermCryos
 */
class SpermCryosController extends AppController
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

            $contain = ['Users', 'Jobs', 'InventoryVials'];
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'SpermCryos', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'SpermCryos', $contain);
            }

            // process the result set
            foreach ($resp['data'] as $k=>$sc) {
                $resp['data'][$k]['id_action'] = $sc->id;
                $resp['data'][$k]['id'] = "<a href='/sperm-cryos/view/{$sc->id}' target='_blank'>{$sc->id}</a>";
                $resp['data'][$k]['job_id'] = "<a href='/jobs/view/{$sc->job_id}' target='_blank'>{$sc->job_id}</a>";
                if ($sc->job) {
                    $resp['data'][$k]['stock_number'] = $sc->job->mmrrc_no;
                } else {
                    $resp['data'][$k]['stock_number'] = '';
                }

                if ($sc->inventory_vials){
                    $samplesCount = 0;
                    foreach ($sc->inventory_vials as $vial) {
                        if ($vial->tissue != 1) {
                            $samplesCount += 1;
                        }
                    }
                    $resp['data'][$k]['straw_count'] = $samplesCount;
                } else {
                    $resp['data'][$k]['straw_count'] = '-';
                } 

                if ($sc->job) {
                    $resp['data'][$k]['strain_name'] = $sc->job->strain_name;
                } else {
                    $resp['data'][$k]['strain_name'] = '';
                }

                if(!$sc->donor_genotype_confirmed) {
                    $donorGeno = 'No';
                } else {
                    $donorGeno = strip_tags($sc->donor_genotype_confirmed);
                }
                if(!$sc->incorrect_genotype) {
                    $inGeno = 'No';
                } else {
                    $inGeno = strip_tags($sc->incorrect_genotype);
                }
                // $donorGeno = strip_tags($sc->donor_genotype_confirmed);
                // $inGeno = strip_tags($sc->incorrect_genotype);
                $resp['data'][$k]['donor_geno'] = $donorGeno.'|'.$inGeno;
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Sperm Cryo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $spermCryo = $this->SpermCryos->get($id, [
            'contain' => [
                'Users','Jobs.Contacts',
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

        $vf = $spermCryo->toArray()['verified_by'];
        if ($vf) {
            $verifyUser = $this->SpermCryos->Users->find('All')->where(['id' => $vf])->first()->toArray();
            $userName = $verifyUser['name'];            
        } else {
            $userName = Null;
        }

        /* Get all vials for a given SC id and patch it with Container/Box hierarchy */
        if ( $allVials = $this->Helper->getAllVials($spermCryo->id, null) ) {
            //First reindex so that array index = container id
            $inventoryContainers = [];
            foreach ($this->SpermCryos->InventoryVials->InventoryLocations->InventoryBoxes->InventoryContainers->find('all')->toArray() as $container) {
                $inventoryContainers[$container->id] = $container;
            }
            //Then prepare an array of all containers and the box
            foreach ($allVials as &$vial) {
                if ($vial->ship_thaw_date || $vial->ship_thaw_reason || !isset($vial->inventory_location_id)) { continue; } // skip hierarchy for shipped vials and vials without location
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
        $parentModel = ['tableName' => 'SpermCryos', 'id' => $id];
        $children = ['fk' => 'sperm_cryo_id', 'tables' => ['InventoryVials']];
        $changes = $this->ChangeLog->getAssocChangeLog($parentModel, $children);
        
        if ($spermCryo['job_id']) {
            $spermCryo['pi'] = $this->SpermCryos->Jobs->getInvestigatorName($spermCryo['job_id']);
        } else {
            $spermCryo['pi'] = Null;
            // $spermCryo['pi'] = $spermCryo['pi_first_name'].' '.$spermCryo['pi_last_name'];
        }

        $this->set('changes', $changes);
        $this->set(compact('spermCryo', 'allVials', 'userName'));
        $this->set('_serialize', ['spermCryo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($job_id=null)
    {
        $spermCryo = $this->SpermCryos->newEntity();
        if ($this->request->is('post')) {
            $spermCryo = $this->SpermCryos->patchEntity($spermCryo, $this->request->data);
            if ($this->SpermCryos->save($spermCryo)) {
                $this->Flash->success(__('The sperm cryo has been saved.'));
                return $this->redirect(['controller'=>'SpermCryos', 'action' => 'view', $spermCryo->id]);
            } else {
                $this->Flash->error(__('The sperm cryo could not be saved. Please, try again.'));
            }
        }
        $users = $this->SpermCryos->Users->find('list');
        $jobs = $this->SpermCryos->Jobs->find('list');
        $this->set(compact('spermCryo', 'users', 'jobs', 'job_id'));
        $this->set('_serialize', ['spermCryo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sperm Cryo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $spermCryo = $this->SpermCryos->get($id, [
            'contain' => ['Jobs']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $spermCryo = $this->SpermCryos->patchEntity($spermCryo, $this->request->data);
            if ($this->SpermCryos->save($spermCryo)) {
                $this->Flash->success(__('The sperm cryo has been saved.'));
                return $this->redirect(['controller'=>'SpermCryos', 'action' => 'view', $spermCryo->id]);
            } else {
                $this->Flash->error(__('The sperm cryo could not be saved. Please, try again.'));
            }
        }
        $users = $this->SpermCryos->Users->find('list');
        $jobs = $this->SpermCryos->Jobs->find('list');
        $this->set(compact('spermCryo', 'users', 'jobs'));
        $this->set('_serialize', ['spermCryo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sperm Cryo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $spermCryo = $this->SpermCryos->get($id);
        if ($this->SpermCryos->delete($spermCryo)) {
            $this->Flash->success(__('The sperm cryo has been deleted.'));
        } else {
            $this->Flash->error(__('The sperm cryo could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'view', 'controller' => 'jobs', $spermCryo->job_id, '#' => 'related-data']);
    }

    public function pickList()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $conn = ConnectionManager::get('default');
            $strainName = $this->request->data['strain_name'];
            $stockNumber = $this->request->data['stock_number'];
            //fetch all associated SC with that strain name, and count number of vials associated with it. 
            if ($strainName != ''){
                $strains = $conn->execute('SELECT sc.id, sc.job_id, jobs.strain_name, sc.cryo_sperm_conc, sc.cryo_total_motility, sc.cryo_prog_motility, sc.cryo_rapid_motility, sc.cryo_abnormal_heads, sc.cryo_abnormal_tails, (SELECT COUNT(*) FROM sperm_cryos JOIN jobs AS j ON sperm_cryos.job_id = j.id JOIN inventory_vials AS vial ON vial.sperm_cryo_id = sperm_cryos.id WHERE sc.id = vial.sperm_cryo_id AND j.strain_name LIKE :strainName AND (vial.tissue = 0 OR vial.tissue IS NULL)) FROM sperm_cryos AS sc JOIN jobs ON sc.job_id = jobs.id WHERE jobs.strain_name LIKE :strainName', ['strainName' => '%'.$strainName.'%'])->fetchAll();
            } else {
                $strains = null;
            }
            //fetch all associated SC with that stock number, and count number of vials associated with it. 
            if ($stockNumber != ''){
                $stocks = $conn->execute('SELECT sc.id, sc.job_id, jobs.strain_name, sc.cryo_sperm_conc, sc.cryo_total_motility, sc.cryo_prog_motility, sc.cryo_rapid_motility, sc.cryo_abnormal_heads, sc.cryo_abnormal_tails, (SELECT COUNT(*) FROM sperm_cryos JOIN jobs AS j ON sperm_cryos.job_id = j.id JOIN inventory_vials AS vial ON vial.sperm_cryo_id = sperm_cryos.id WHERE sc.id = vial.sperm_cryo_id AND jobs.mmrrc_no = :stockNumber AND (vial.tissue = 0 OR vial.tissue iS NULL)) as straw_count FROM sperm_cryos AS sc JOIN jobs ON sc.job_id = jobs.id WHERE jobs.mmrrc_no = :stockNumber', ['stockNumber' => $stockNumber])->fetchAll(); 
            } else {
                $stocks = null;
            }
        }
        // $users = $this->SpermCryos->Users->find('list');
        $spermCryo = $this->SpermCryos->find('list');
        $this->set(compact('strains', 'stocks'));
        $this->set('_serialize', ['spermCryo']);
    }

    public function verify($id, $user)
    {
        $spermCryo = $this->SpermCryos->get($id, [
            'contain' => ['Users']
        ]);

        $conn = ConnectionManager::get('default');
        $verify = $conn->execute('UPDATE sperm_cryos SET verified = 1, verified_by = :user, verified_time = NOW() where id = :id', ['user' => $user, 'id' =>$id]);

        if ($verify) {
            $this->Flash->success(__('The sperm cryo inventory has been verified'));
            return $this->redirect(['controller'=>'SpermCryos', 'action' => 'view', $spermCryo->id]);
        } else {
            $this->Flash->error(__('The sperm cryo inventory was not verified. Please try again.'));
        }            

        $spermCryo = $this->SpermCryos->find('list');
        $this->set(compact('spermCryo', 'users'));
        $this->set('_serialize', ['spermCryo']);
    }
}