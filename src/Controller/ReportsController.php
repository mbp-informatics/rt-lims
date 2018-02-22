<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Injections Controller
 *
 * @property \App\Model\Table\InjectionsTable $Injections
 */
class ReportsController extends AppController
{
    public $components = array('Project', 'Milestones', 'AppErrors', 'Injection', 'Colony');
    
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Projects');
        $this->loadModel('Injections');
        $this->loadModel('ProjectsInjections');
        $this->loadModel('Colonies');
        $this->loadModel('Jobs');
    }

    /**
     * MSCL Report method -it's just a view. JSON report data is grabbed from api-ns
     *
     * @return void
     */
    public function msclReport() { }

    /**
     * MICL Project Report method
     *
     * @return void
     */
    public function miclProjectReport()
    {
        $contain = [
            'JobTypes.JobTypeNames',
            'JobAstatuses',
            'JobBstatuses',
            'SpermCryos.InventoryVials',
            'EmbryoCryos.InventoryVials'
        ];
        if ($this->request->is('json')) {
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                //Case: Advanced search
                @$resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'Jobs', $contain);
            } else {
                //Case: Display all jobs
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'Jobs', $contain);            
            }

            //Injects some extra fields into the dataset
            foreach ($resp['data'] as $k=>$job) {
                $resp['data'][$k]['id_action'] = $job->id;
                $resp['data'][$k]['id'] = "<a href='/jobs/view/{$job->id}' target='_blank' >{$job->id}</a>";
                if ($job->sperm_cryos){
                    $samplesCount = 0;
                    foreach ($job->sperm_cryos as $sc) {
                        foreach ($sc->inventory_vials as $vial) {
                            if ($vial->tissue != 1 && $vial->do_not_distribute != 1) {
                                $samplesCount += 1;
                            }
                        }
                    }
                    $resp['data'][$k]['sc_count'] = $samplesCount;
                } else {
                    $resp['data'][$k]['sc_count'] = '';
                } 
                if ($job->embryo_cryos){
                    $embryoCount = 0;
                    foreach ($job->embryo_cryos as $ec) {
                        if ($ec->inventory_vials){
                            foreach ($ec->inventory_vials as $vial) {
                                if ($vial->volume && $vial->do_not_distribute != 1) {
                                    $embryoCount += $vial->volume;
                                }
                            }
                        }
                    }
                    $resp['data'][$k]['ec_count'] = $embryoCount;
                } else {
                    $resp['data'][$k]['ec_count'] = '';
                } 
                if ($job->job_types){
                    $typeArray = [];
                    foreach ($job->job_types as $type) {
                        array_push($typeArray, $type->job_type_name->name);
                        } 
                    
                    $types = implode(', ', $typeArray);
                    $resp['data'][$k]['job_types'] = $types;
                } else {
                    $resp['data'][$k]['job_types'] = '';
                } 
                if ($job->job_astatus_id){
                    $resp['data'][$k]['job_astatus'] = $job->job_astatus->name;
                } else {
                    $resp['data'][$k]['job_astatus'] = '';
                }
                if ($job->job_bstatus_id){
                    $resp['data'][$k]['job_bstatus'] = $job->job_bstatus->name;
                } else {
                    $resp['data'][$k]['job_bstatus'] = '';
                } 
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');    
        }
    }

    /**
     * MICL IVF Report method
     *
     * @return void
     */
    public function miclIvfReport()
    {
        $contain = ['Jobs'];

        if ($this->request->is('json')) {

            $contain = ['Jobs', 'IvfDishes', 'Users'];
            $request = !empty($this->request->query) ? $this->request->query : $this->request->data; //GET vs POST request
            if (isset($request['search']['value']) && strstr($request['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'Ivfs', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'Ivfs', $contain);
            }

            // process the result set
            foreach ($resp['data'] as $k=>$ivf) {
                $resp['data'][$k]['id'] = "<a href='/ivfs/view/{$ivf->id}' target='_blank'>{$ivf->id}</a>";
                $resp['data'][$k]['sperm_conc'] = isset($ivf->cpa_fresh_sperm_conc) ? $ivf->cpa_fresh_sperm_conc.' M/ml' : '';
                $resp['data'][$k]['sperm_total_mot'] = isset($ivf->cpa_fresh_total_motility) ? $ivf->cpa_fresh_total_motility.'%' : '';
                $resp['data'][$k]['sperm_prog_mot'] = isset($ivf->cpa_fresh_prog_motality) ? $ivf->cpa_fresh_prog_motality.'%' : '';

                if ($ivf->job) {
                    $resp['data'][$k]['job_id'] = "<a href='/jobs/view/{$ivf->job->id}' target='_blank'>{$ivf->job->id}</a>";
                    $resp['data'][$k]['mmrrc_no'] = $ivf->job->mmrrc_no;
                    $resp['data'][$k]['strain_name'] = $ivf->job->strain_name;
                    $resp['data'][$k]['membership'] = $ivf->job->membership;
                    $resp['data'][$k]['esc_clone_id_no'] = $ivf->job->esc_clone_id_no;
                } else {
                    $resp['data'][$k]['strain_name'] = '';
                    $resp['data'][$k]['mmrrc_no'] = '';
                    $resp['data'][$k]['job_id'] = '';
                    $resp['data'][$k]['esc_clone_id_no'] = '';
                }
                if ($ivf->females_out_no-$ivf->unsuperovulated_no != 0) {
                    $one_cell_sum = $two_cell_sum = 0;
                    foreach($ivf->ivf_dishes as $dish){
                        $one_cell_sum += $dish->one_cell_no;
                        $two_cell_sum += $dish->two_cell_no;
                    }
                    $averageEggs = ($two_cell_sum+$one_cell_sum)/($ivf->females_out_no-$ivf->unsuperovulated_no);
                    $averageEggs = number_format((float)$averageEggs, 2, '.', '');
                    $resp['data'][$k]['average_eggs'] = $averageEggs;
                } else {
                    $resp['data'][$k]['average_eggs'] = '';
                }

                //Calculate Egg Yield and IVF rate
                if (!empty($resp['data'][$k]['ivf_dishes'])) {
                    $fertRate = 0; $two_cell_sum = 0; $one_cell_sum = 0;
                    foreach ($resp['data'][$k]['ivf_dishes'] as $dish){
                        $resp['data'][$k]['egg_yield'] += $dish->two_cell_no;
                        $two_cell_sum += $dish->two_cell_no;
                        $one_cell_sum += $dish->one_cell_no;
                    }
                    if ($two_cell_sum+$one_cell_sum !== 0) {
                        $fertRate = ($two_cell_sum/($two_cell_sum+$one_cell_sum))*100;
                    }
                    $resp['data'][$k]['fert_rate'] = ($fertRate !== 0) ? number_format($fertRate, 2).'%' : '';
                } else {
                    $resp['data'][$k]['fert_rate'] = '';
                    $resp['data'][$k]['egg_yield'] = '';
                }
                $resp['data'][$k]['ivf_icsi_by'] = !empty($resp['data'][$k]['ivf_icsi_by']) ? $resp['data'][$k]['ivf_icsi_by'] : $resp['data'][$k]['user']['name'];
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * MICL Project Report method
     *
     * @return void
     */
    public function miclEtReport()
    {
        $contain = ['Jobs'];

        if ($this->request->is('json')) {

            $contain = ['Jobs', 'Recipients', 'Injections.Colonies', 'Users'];
            $request = !empty($this->request->query) ? $this->request->query : $this->request->data; //GET vs POST request
            if (isset($request['search']['value']) && strstr($request['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'EmbryoTransfers', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'EmbryoTransfers', $contain);
            }

            // process the result set 
            foreach ($resp['data'] as $k=>$et) {
                $resp['data'][$k]['id'] = "<a href='/embryo-transfers/view/{$et->id}' target='_blank'>{$et->id}</a>";
                $resp['data'][$k]['job_id'] = "<a href='/jobs/view/{$et->job_id}' target='_blank'>{$et->job_id}</a>";
                
                $embryosCount = '';
                $malePups = '';
                $femalePups = '';
                $totalPups = '';
                $mutMales = '';
                $mutFemales = '';
                $totalMuts = '';
                $litterCount = '';
                $litterRate = '';
                $birthRate = '';
                $recipientCount = '';

                if ($et->recipients) {                
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
                $resp['data'][$k]['no_recipients'] =  $recipientCount;
                $resp['data'][$k]['total_male_pups'] =  $malePups;
                $resp['data'][$k]['total_mut_males'] =  $mutMales;
                $resp['data'][$k]['total_mut_females'] =  $mutFemales;
                
                $resp['data'][$k]['pups_equation'] = $totalMuts . "/" . $totalPups;
                $resp['data'][$k]['total_pups_born'] = $totalPups;
                $resp['data'][$k]['total_embryos_tx'] = $embryosCount;
                
                $resp['data'][$k]['birth_rate'] = '';
                $resp['data'][$k]['litter_rate'] = '';
                if (!empty($et->recipients)) {
                    $resp['data'][$k]['birth_rate'] = round($birthRate, 2).'%';
                    $resp['data'][$k]['litter_rate'] = round($litterRate, 2).'%';    
                }
                
                $resp['data'][$k]['strain_name'] = '';
                $resp['data'][$k]['membership'] = '';
                $resp['data'][$k]['mmrrc_no'] = '';
                $resp['data'][$k]['esc_clone_id_no'] = '';
                if ($et->job) {
                    $resp['data'][$k]['strain_name'] = $et->job->strain_name;
                    $resp['data'][$k]['membership'] = $et->job->membership;
                    $resp['data'][$k]['mmrrc_no'] = $et->job->mmrrc_no;
                    $resp['data'][$k]['esc_clone_id_no'] = $et->job->esc_clone_id_no;    
                }
                $resp['data'][$k]['et_by'] = !empty($resp['data'][$k]['et_by']) ? $resp['data'][$k]['et_by'] : $resp['data'][$k]['user']['name'];
                
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * iMits microinjection report method
     *
     * @return void
     */
    public function imitsReport($action=null)
    {
        /* Don't show notices and errors, 'cause they break the file output */            
        if ($action == 'download') {
            error_reporting(0);
            ini_set('display_errors', 0);
        }

        if ($action == 'get-data' || $action == 'download') {
            $headers = [
                'Inj',
                'Colony',
                'Project',
                'Mi Date',
                'iMits',
                'iMits Intern.',
                // 'iMits External Ref',
                'Inj Comments',
                'Method',
                'Voltage',
                '#Pulses',
                'Blast Strain Name',
                'MRNA',
                'MRNA Conc.',
                'Protein',
                'Protein Conc.',
                'Embryos Inj',
                'Embryos Survived',
                'Transfer Day',
                'Total transfered'
            ];
            $data = $this->Injections
                ->find('all')
                ->where(['injection_type =' => 'CR'])
                ->contain([
                    'Projects'=>
                        ['MgiGenesDump' => [
                                'ImitsDumpMiAttempts',
                                'ImitsDumpMiPlans',
                                'ImitsDumpPhenotypeAttempts'
                                ],
                        'CrisprDesigns.CrisprAttributes'],
                    'EmbryoTransfers',
                    'Colonies'
                ]);
            // Prepare a list of project names
            $injections = $data;
            $projectNames = [];
            foreach ($injections as $inj) {
                foreach ($inj->projects as $proj) {
                    $projectNames[$proj->id] = $this->Project->getName($proj->id);
                }
            }

            //Prepare an output data set
            $dataSet = [];
            foreach ($injections as $k=>$inj) {
                $projNames = [];
                foreach ($inj->projects as $p) {
                    $projNames[$p->id] = $this->Project->getName($p->id);
                    $miPlans = [];
                    foreach ($p->mgi_genes_dump as $g) {
                        if (isset($g->imits_dump_mi_plan->imits_mi_plan_id)) {
                            $miPlans[$g->imits_dump_mi_plan->imits_mi_plan_id] = $g->imits_dump_mi_plan->imits_mi_plan_id;
                        }
                        $miAttempts = [];
                        $externalRefs = [];
                        foreach ($g->imits_dump_mi_attempts as $ma) {
                            $miAttempts[$ma->imits_mi_attempt_id] = $ma->imits_mi_attempt_id;
                            $externalRefs[json_decode($ma->mi_attempt_json)->external_ref] = json_decode($ma->mi_attempt_json)->external_ref;
                        }
                    }
                }
                $colonies = [];
                foreach ($inj->colonies as $c) {
                    $colonies[$c->id] = $c->name;
                }
                
                $iMits = [
                    'mi_plans' => isset($miPlans) ? $miPlans : null,
                    'mi_attempts' => isset($miAttempts) ? $miAttempts : null,
                    'pheno_attempts' => isset($miAttempts) ? $miAttempts : null,
                ];

                $dataSet[$k][0] = $inj->id;
                $dataSet[$k][1] = $colonies;
                $dataSet[$k][2] = $projNames;
                $dataSet[$k][3] = $inj->injection_date;
                $dataSet[$k][4] = $iMits;
                // $dataSet[$k][5] = isset($externalRefs) ? $externalRefs : null;
                $dataSet[$k][5] = $iMits;
                $dataSet[$k][6] = $inj->comments;
                $dataSet[$k][7] = $inj->cr_electroporation === True ? 'Electroporation' : 'Pronuclear Injection';
                $dataSet[$k][8] = isset($inj->voltage) ? $inj->voltage : $inj->ravata_voltage;
                $dataSet[$k][9] = isset($inj->number_of_pulses) ? $inj->number_of_pulses : $inj->ravata_number_of_pulses;
                $dataSet[$k][10] = $inj->donor_strain;
                $dataSet[$k][11] = $inj->mrna_nuclease;
                $dataSet[$k][12] = $inj->mrna_nuclease_concentration;
                $dataSet[$k][13] = $inj->protein_nuclease;
                $dataSet[$k][14] = $inj->protein_nuclease_concentration;
                $dataSet[$k][15] = isset($inj->number_zygotes_injected) ? $inj->number_zygotes_injected : $inj->number_injected;
                $dataSet[$k][16] = $inj->number_survived;
                $dataSet[$k][17] = isset($inj->embryo_transfers[0]) ? $inj->embryo_transfers[0]->embryo_transfer_day : null;
                $dataSet[$k][18] = $inj->number_transferred;

                //convert emptiness to null
                foreach ($dataSet[$k] as &$fieldVal) {
                    $fieldVal  = !empty($fieldVal) ? $fieldVal : null;
                }
                unset($fieldVal);
            }

            $this->set('headers', $headers);
            $this->set('projectNames', $projectNames);
            $this->set('dataSet', $dataSet);
            $this->set('_serialize', ['injections', 'dataSet']);
        }

        /* CSV export */
        if ($action == 'download') {

            unset($headers[5]); //skip internal iMits
            //convert arrays and time objects to strings
            foreach ($dataSet as &$row) {
                unset($row[5]); //skip internal iMits
                foreach ($row as $k=>&$val) {
                    if ($k == 4){ //special case - iMits
                        $tempVal = '';
                        if (!empty($val['mi_plans'])) {
                            $tempVal .= 'Plan:' . implode('|', $val['mi_plans']);
                        }
                        if (!empty($val['mi_attempts'])) {
                            $tempVal .= ', MA:' . implode('|', $val['mi_attempts']);
                        }
                        if (!empty($val['pheno_attempts'])) {
                            $tempVal .= ', PA:' . implode('|', $val['pheno_attempts']);
                        }
                        $val = $tempVal;
                    } else {
                        if (is_array($val)) {
                            $val = implode('|', $val);
                        }
                        if ($val instanceof \Cake\I18n\Date) {
                            $val = $val->format('Y-m-d');
                        }
                    }
                }
                unset($val);
            }
            unset($row);
            //dump to browser as file
            $d = date('Y-m-d');
            header("Content-Disposition: attachment; filename=iMitsTracker_{$d}.csv");
            header("ContentType = 'application/CSV'");
            $h = fopen('php://output', 'w');
            fputcsv($h, $headers);
            foreach ($dataSet as $line) {
                fputcsv($h, $line);
            }
            fclose($h);
            exit;
        }
        $this->set('action', $action);
    }


}


