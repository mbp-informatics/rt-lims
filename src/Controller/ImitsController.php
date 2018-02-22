<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Network\Http\Client;
require_once(($_SERVER['DOCUMENT_ROOT'].'/vendor/mbp/custom/imits.php'));

/**
 * iMits API Controller
 */
class ImitsController extends AppController
{   
    public $components = array('Project', 'Imit'); //load 'Project', 'Imit' component to access its custom getName($pid), used to get project name
    public $production_center = "UCD";
    public $consortium = "DTCC";

    //Gets Crispr sequence based on gRNA sequence
    public function getSeq($seq = null){
        $this->autoRender = false;
        $ret = $this->Imit->getSeq($seq); //call ImitComponent method
        $this->set('value', json_encode($ret));
        $this->render('/Imits/dumpvalues'); //to be able to catch json return values in other controller they MUST go through a view, echoing them directly makes them "invisisble" to Cake
    }

    public function getMiPlanId($geneSymbol) {
        $this->autoRender = false;
        $request = "marker_symbol_eq=".$geneSymbol;
        $apiRequest = new \imits("GET", "mi_plans", $request);
        $response = $apiRequest->getReturnValues();
        if (!empty($response)) {
            $resp = $response[0]["id"];
        } else {
            $resp = "null";
        }
        $this->set('value', json_encode($resp));
        $this->render('/Imits/dumpvalues');
    }

    public function getMiPlan($id) {
        $this->autoRender = false;
        $apiRequest = new \imits("GET", "mi_plans", "production_centre_name_eq={$this->production_center}&consortium_name_eq={$this->consortium}&id_eq=" . $id);
        $this->set('value', json_encode($apiRequest->getReturnValues()));
        $this->render('/Imits/dumpvalues');
    }

    public function setMiPlan($geneSymbol, $priorityName) {
        $this->autoRender = false;
        $json = '{
            "mi_plan": {
            "marker_symbol": "'. $geneSymbol .'",
            "priority_name": "'. $priorityName .'",
            "consortium_name": "{$this->consortium}",
            "production_centre_name" : "{$this->production_center}",
            "mutagenesis_via_crispr_cas9" : "1"
        }}';
        $apiRequest = new \imits("POST", "mi_plans", $json);
        $this->set('value', json_encode($apiRequest->getReturnValues()));
        $this->render('/Imits/dumpvalues');
    }
   
    public function getMiAttemptId($colonyName) {
        $this->autoRender = false;
        $apiRequest = new \imits("GET", "mi_attempts", "production_centre_name_eq={$this->production_center}&consortium_name_eq={$this->consortium}&external_ref_eq=" . $colonyName);
        $response = $apiRequest->getReturnValues();
        if (!empty($response)) {
            $this->set('value', $response[0]["id"]);
        
        } else {
            $this->set('value', "null");
        }
        $this->render('/Imits/dumpvalues');
    }

    public function getMiAttempt($id) {
        $this->autoRender = false;
        $apiRequest = new \imits("GET", "mi_attempts", "production_centre_name_eq={$this->production_center}&consortium_name_eq={$this->consortium}&id_eq=" . $id);
        $this->set('value', json_encode($apiRequest->getReturnValues()));
        $this->render('/Imits/dumpvalues');
    }
    
    public function setMiAttempt() {
        $this->autoRender = false;
        if (!$this->request->is('post')) { exit("No POST data found. Exiting..." ); }
            
        $colony = unserialize($this->request->data['colony']);
        $crisprDesign = unserialize($this->request->data['crispr']);
        $injection = unserialize($this->request->data['injection']);
        $projectName = $this->Project->getName($crisprDesign->project_id);

        $json_attributes = "";
        foreach ($crisprDesign->crispr_attributes as $attr) {
            $json_attributes .= '    
                {
                    "sequence": "' . $attr->sequence . '",
                    "chr": "' . $attr->chromosome . '",
                    "start": "' . $attr->chr_start . '",
                    "end": "' . $attr->chr_end . '"
                }, ';
        }
        $json_attributes = chop($json_attributes, ", ");
        $injectionDate = new \DateTime($injection->injection_date->date);

        $json = '{
            "mi_attempt": {
            "consortium_name": "' . $this->consortium . '",
            "production_centre_name": "' . $this->production_center . '",
            "mi_plan_id": "' . $crisprDesign->project->gene->mi_plan_id . '",
            "mi_date": "' . $injectionDate->format('d/m/Y') . '",
            "colony_name": "'. $colony['denotation'] . $injection->colony_id .'",
            "comments": "' . $injection->comments . '",
            "mutagenesis_factor_attributes": {
                "external_ref": "' . $projectName . '", 
                "vector_name": "' . $crisprDesign->vector_name . '",
                "nuclease": "' . $crisprDesign->nuclease . '",
                "crisprs_attributes": [' . $json_attributes . ']
            },
            "crsp_total_embryos_injected": "' . $injection->number_injected . '", 
            "crsp_total_embryos_survived": "' . $injection->number_survived . '", 
            "crsp_total_transfered": "' . $injection->number_transferred . '", 
            "crsp_no_founder_pups": "1",
            "experimental": "0",
            "report_to_public": "1",
            "is_active": "1"
        }}';
        
            // Genotyping?
            // "assay_type": "",
            // "founder_num_assays": "",
            // "founder_num_positive_results": "",
            // "crsp_total_num_mutant_founders": "",
            // "crsp_num_founders_selected_for_breading": ""

        $apiRequest = new \imits("POST", "mi_attempts", $json);
        $this->set('value', json_encode($this->parseImitsErrors($apiRequest->getReturnValues())));
        $this->render('/Imits/dumpvalues');
    }

    public function updateMiAttempt($id=null) {
        $this->autoRender = false;
        if (!isset($id)) { exit("Missing Mi Attempt ID. Exiting..." ); }
        if (!$this->request->is('PUT')) { exit("No PUT data found. Exiting..." ); }
    
        $crisprDesign = unserialize($this->request->data['crispr']);
        $injection = unserialize($this->request->data['injection']);
        
        $miAttempt = $this->requestAction( //get Mi Attempt associated with the injection
                    ['controller' => 'Imits', 'action' => 'getMiAttempt'],
                    ['pass' => [$injection->mi_attempt_id],
                        'post' => [
                        '_method' => "GET",
                ]]);
        $miAttempt = json_decode($miAttempt);
        $injectionDate = new \DateTime($injection->injection_date->date);
        $json = '{
            "mi_attempt": {
            "consortium_name": "' . $this->consortium . '",
            "production_centre_name": "' . $this->production_center . '",
            "mi_date": "' . $injectionDate->format('d/m/Y') . '",
            "comments": "' . $injection->comments . '",
            "crsp_total_embryos_injected": "' . $injection->number_injected . '", 
            "crsp_total_embryos_survived": "' . $injection->number_survived . '", 
            "crsp_total_transfered": "' . $injection->number_transferred . '", 
            "crsp_no_founder_pups": "1",
            "experimental": "0",
            "report_to_public": "1",
            "is_active": "1"
        }}';
        $apiRequest = new \imits("PUT", "mi_attempts", $json, $id);
        $this->set('value', json_encode($this->parseImitsErrors($apiRequest->getReturnValues())));
        $this->render('/Imits/dumpvalues');
    }

public function parseImitsErrors($imitsResp) {
        if (isset($imitsResp['id'])) {
            $success = array();
            $success['success'] = array("id" => $imitsResp['id']);
            return $success;
        } elseif (isset($imitsResp['errors'])) {
            $errors = array();
            foreach ($imitsResp['errors'] as $key => $err) {
                if (!empty($err)) {
                    $errors['errors'] = [$key . " " . $err[0]];
                }
            }
            return $errors;
        } else {
            $str = implode(" ", $imitsResp);
            return "Unknown error:" . $str;
        }
}

    public function getMiPlans(){
        $this->autoRender = false;
        $geneSymbols = [
                'Ap4e1',
                'Asic4',
                'Nxn',
                'Ano3',
                'Ces1d',
                'Rnf10',
                'Kcna10 ',
                'Nalcn',
                'Satb2',
                'Tox3',
                'Nhlh2',
                'GalR3',
                'Gja10',
                'Snrk',
                'Gjc3',
                'Gpr39',
                'Npbwr1',
                'Vrk1',
                'Prkab1',
                'Nr1d2',
                'Sik2',
                'Aoah',
                'Gabpa',
                'Pde6a',
                'Col26a1TCP',
                'Col26a1UCD',
                'Scn2a1*',
                'Ces1d.rna',
                'Ces1d.protein',
                'Dnase1/2.del',
                'Dbn1',
                'Kcna10.del',
                'Nalcn.del',
                'Dnase1l2.DEL',
                'DNAse112',
                'Il20rb_LZ',
                '2700054A10Rik',
                'Abhd11',
                'Chsy3',
                'Clca1',
                'Gm14496',
                'Bpifa2',
                'Il18r1',
                'Pde6a',
                'Mctp1',
                'Olfr376',
                'Olfr380',
                'Sgtb',
                'Vwa2_LZ',
                'Catsper3_LZ',
                'Cwc22',
                'Dpy19l1',
                'Dsg1c',
                '1700015E13Rik',
                'Caskin1',
                'Sec61b',
                'Caskin1',
                '5430419D17Rik',
                'Lrrc8c',
                'Olfr392',
                'Rps12',
                'Rps4x',
                'Nuak2_LZ',
                'Fam135a',
                'Snx10',
                'Nuak2',
                'Olfr1098',
                'Olfr376',
                'Catsper3',
                'Cpne7',
                'Phactr1',
                'Vrk3',
                'Camkv',
                'Sgk2',
                'Mark4',
                'Rbm22',
                'Sh3rf2',
                'Tuba1a',
                'Speer4f1',
                'Slc25a14',
                'Tas2r139',
                'Ticrr',
                'Upf3a',
                'Pdik1l',
                'Agbl4',
                'Arhgef16',
                'Atxn7l2',
                'Faf1',
                'Gm15217',
                'Haus7',
                'Hhatl',
                'Hs3st3b1',
                'Hspa8',
                'Klhdc4',
                'Lgsn',
                'Lrch2',
                'Spag11a',
                'Utp18',
                'Zbtb48',
                'Zfp81',
                'Phactr1',
                'Vrk3',
                'Nmt1',
                'Rbm22',
                'Pdik1l',
                'Hs3st3b1',
                'Tulp4',
                'Aadac',
                'Crisp2',
                '1700069L16Rik_LZ',
                'Antxrl_LZ',
                'Tcf25_LZ',
                'Tctn1_LZ',
                'Zc3h4_LZ',
                'Lztfl1',
                'Zbtb48',
                'Abhd10',
                'Acsl6',
                'Adgb',
                'Ano5',
                'Carns1',
                'Unc80',
                'Eif3i',
                'Ddx6',
                'Fmo3',
                'Tmem194',
                'Xpo1',
                'Mical2',
                'B3glct',
                'Ufsp2',
                'Opn3',
                'Rgag4',
                'Rhoq',
                'Rnase4',
                'Rbbp4',
                'Ccdc65',
                'Cntd1',
                'Nnmt',
                'Cdhr2',
                'Clcnkb',
                'Ccz1',
                'Fubp1',
                'Cndp2',
                'Myct1',
                'Erich3',
                'Fam19a3',
                'Mfsd5',
                'Myadm',
                'Tmc7',
                'Pi15',
                'Ptchd2',
                'Pydc3',
                'Gin1',
                'Mb21d2',
                'Lmod3',
                'Maats1',
                'Rasal1',
                'Rgs21',
                'Rpl17',
                'Slc28a2',
                'Smg5',
                'Sptlc3',
                'Suclg2',
                'Zc3h11a',
                'Chchd10',
                'Cldn17',
                'Gabrg1',
                'Svip',
                'Ubqln3',
                '4930524B15Rik',
                'Abhd6',
                'Copa',
                'MIXED EMBRYOS',
                'Eif4a3',
                'Fkbp2',
                'Hnrnpul1',
                'Pdp1',
                'Rad51ap2',
                'Rassf6',
                'Rnd2',
                'Rnf19a',
                'Shisa8',
                'Unc5cl',
                'Bbs9',
                'Copb1',
                'Efr3b',
                'Hic2',
                'Kpna2',
                'Ocel1',
                'Slc25a18',
                'Ipo7',
                'Xpo5',
                'Mcts1',
                'Wdr82',
                'Cyp4v3',
                'Cand1',
                'Slc22a16',
                'Ubac2',
                'Gsg1l',
                'Igf2bp2',
                'Fbxl4',
                'Map3k13',
                'Slitrk2',
                'Csmd3',
                'Fam132a',
                'Maged2',
                'Marveld3',
                'Naa10',
                'Serhl',
                'Sfmbt2',
                'Tlk2',
                'Cdc42ep3',
                'Magohb',
                'Mapre1',
                'Paqr8',
                'Pja1',
                'Pyhin1',
                '1700025G04Rik',
                'Abhd13',
                'Arl13a',
                'Btbd17',
                'Btg1',
                'Camk1d',
                'Dhx15',
                'Dnaja2',
                'Dok5',
                'Enkur',
                'Med8',
                'Mxra8',
                'Mybpc1',
                'Paics',
                'Sugp1',
                'Tle4',
                'Trabd',
                'Ube2f',
                'Wdr11',
                'Zbed3',
                'Zcchc18',
                'Zfand6',
                'Zfp398',
                'Baat',
                'Clasp1',
                'Cpa6',
                'Gsg1l',
                'Exosc5',
                'Ism1',
                'Mpp7',
                'Myo19',
                'Nufip1',
                'Pdss1',
                '1700034E13Rik',
                '2810474O19Rik',
                '4833420G17Rik',
                '8030462N17Rik',
                'Actr2',
                'Ankrd42',
                'Awat2',
                'Blvra',
                'Car10',
                'Ccdc73',
                'Ccl12',
                'Cfap20',
                'Ppfibp1',
                'Cfap54',
                'Cfap57',
                'Cgnl1',
                'Stau2',
                'Ubtf',
                'Zfp236',
                'Zfp558'

        ];
        foreach($geneSymbols as $s){
            $request = "marker_symbol_eq=".$s."production_centre_name_eq={$this->production_center}&consortium_name_eq={$this->consortium}&&mutagenesis_via_crispr_cas9_eq=true";
            $apiRequest = new \imits("GET", "mi_plans", $request);
            $response = $apiRequest->getReturnValues();
            echo $s."\t".$response[0]["id"]."\t".$response[0]["mgi_accession_id"]."<br>";
        }
    }
    
} //class ends