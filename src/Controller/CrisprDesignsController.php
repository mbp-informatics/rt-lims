<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
require_once(($_SERVER['DOCUMENT_ROOT'].'/vendor/PHPExcel/Classes/PHPExcel/IOFactory.php'));

/**
 * CrisprDesigns Controller
 *
 * @property \App\Model\Table\CrisprDesignsTable $CrisprDesigns
 */
class CrisprDesignsController extends AppController
{
    public $components = ['Project','Milestones', 'Helper', 'Imit']; 
    
    protected $errors = [];
    protected $batchUploadId;
    protected $filePath;
    protected $fileName;
    protected $parsedSheet;
    protected $requiredHeaders = [
                "gene_name",
                "mutation",
                "phenotype_plan",
                "nuclease",
                "vector_name",
                "gRNA_1",
                "gRNA_2",
                "gRNA_3",
                "gRNA_4",
                "project_comments",
                "crispr_design_comments"
                ];
    protected $project_status_id = 3; //Designed
    protected $project_type_id = 6; //KOMP2


    public function initialize() {
        parent::initialize();
        
        $this->loadModel('CrisprAttributes');
        $this->loadModel('MgiGenesDump');
        $this->loadModel('Mutations');
        $this->loadModel('Phenotypes');
        $this->mutations = $this->Mutations->find('all')->toArray();
        $this->phenotypes = $this->Phenotypes->find('all')->toArray();

        ini_set("auto_detect_line_endings", true); //to parse csv correctly 
        if (!Configure::read('debug')) {
            error_reporting(0);
        }
        set_time_limit(0); //set script execution timeout to infinite
    }


    public function bulkUpload(){} //just go to bulk_upload.ctp, will add flash debug messages
    
    public function parseBulkUpload() {
        $this->autoRender = false;
        session_write_close(); //close session, because it will freeze all other requests from the same client, unless the session file is closed

        /*** Script logic starts ***/
        $this->saveFile(); // saves file in webroot/uploads/crispr-design-bulk-upload/ with unique id(batch name) appended to file name

        switch (pathinfo($this->filePath, PATHINFO_EXTENSION)) {
            case "xlsx":
            $this->parseXLS();
            break;
            case "csv":
            $this->parseCSV();
            break;
            case "tsv":
            $this->parseCSV("tsv");
            break;
            default:
            $this->showErr("Wrong filetype. Accepted filetypes: XLSX, CSV, TSV. Upload aborted.");
        }
        $this
            ->checkStructure() //check the structure of XLS file headers and number of rows
            ->getAttr() //hit Sanger API to get CRISPR sequences and populate $this->parsedSheet
            ->saveCrisprDesignAndProject();
        echo json_encode(["success" => 1]); //all OK!
    }

    public function showErr($msg) {
        $this->autoRender = false;
        $this->errors['errors'][] = $msg;
        echo json_encode($this->errors);
        exit;
    }

    private function searchObjectKey($needle, $fieldName, $object) {
        foreach ($object as $row) {
            if ($row->$fieldName == $needle) {
                return $row->id;
            }
        }
        return false;
    }

    public function saveFile() {   
        $this->batchUploadId = uniqid();
        $this->fileName = $this->batchUploadId . "+" . $this->request->data['file']['name'];
        $this->filePath = $_SERVER['DOCUMENT_ROOT'] . '/webroot/uploads/crispr-design-bulk-upload/' . $this->fileName;
        if (@move_uploaded_file($this->request->data['file']['tmp_name'], $this->filePath) === false) {
            $this->showErr("The file <em><strong>{$this->fileName}</strong></em> could not be uploaded to the server. Upload aborted.");
        }
        return $this;
    }

    public function parseCSV($tsv=null) {
        if ($tsv == "tsv") {
            $arr = array_map(function($v){return str_getcsv($v, "\t");}, file($this->filePath));
        } else {
            $arr = array_map(function($v){return str_getcsv($v, ",");}, file($this->filePath));
        }
        $this->parsedSheet = $arr;
        return $this;
    }

    public function parseXLS() {
        $inputFileType = \PHPExcel_IOFactory::identify($this->filePath);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($this->filePath);
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn(); 
        $this->parsedSheet = $sheet->rangeToArray('A1:'.$highestColumn.$highestRow);
        return $this;
    }

      public function checkStructure() {   
        if (count($this->parsedSheet) > 100){
            $this->showErr("The input file cannot contain more than 100 rows. Upload aborted.");
        }
        foreach ($this->parsedSheet[0] as $i=>$header) {
            if (count($this->parsedSheet[0]) != count($this->requiredHeaders)) {
                $isErr = true;
            }
            if (strtolower($header) !== strtolower($this->requiredHeaders[$i])) {
                $isErr = true;
            }
            if (isset($isErr)) {
                $this->showErr("The file <em><strong>{$this->fileName}</strong></em> contains incorrect column headers. Upload aborted.");
            }
        }
        foreach ($this->parsedSheet as $row_no=>&$row) {
            if ($row_no === 0) { continue; }
            if (!$this->searchObjectKey($row[1], 'type', $this->mutations)) {
                $this->showErr("Mutation type '{$row[1]}'' is not defined in RT-LIMS. Make sure your're specifying the correct mutation in the XLS sheet. You can define mutations here: <a href='/mutations'>/mutations</a>");
            }
            if (!$this->searchObjectKey($row[2], 'type', $this->phenotypes)) {
                $this->showErr("Phenotype '{$row[2]}'' is not defined in RT-LIMS. Make sure your're specifying the correct phenotype plan in the XLS sheet. Yuo can define phenotype plans here: <a href='/phenotypes'>/phenotypes</a>");
            }

            //Get Mgi Accession Id for a given gene symbol            
            $mgi_id = $this->MgiGenesDump
                ->find('all')
                ->where(['marker_symbol =' => $row[0]])
                ->first()['mgi_accession_id'];
            if (!$mgi_id) {
                $this->showErr("Can't find matching MGI Accession ID for gene name {$row[0]}. Upload aborted.");
            }
            $row[] = $mgi_id; //add mgi ID as the last column of to the current row
        }
        unset($row);
        return $this;
    }

    public function getAttr() {
        foreach ($this->parsedSheet as $row_no => &$row) {
            if ($row_no == 0) {continue; } //skip first row (headers)
            $seqArr = [];
            $seqArr[] = $row[5];
            $seqArr[] = $row[6];
            $seqArr[] = $row[7];
            $seqArr[] = $row[8];
            $ii = 0;
            $attr = [];
            foreach ($seqArr as $seq) {
                if (empty($seq)) { $ii++; continue; }
                $sangerArr = $this->Imit->getSeq($seq); //Imit Component
                if ($sangerArr === NULL) {
                    $sangerArr = (object)['error' => "Can't match corresponding crispr sequence"]; //cast to object to maintain the same type as json_decode() returns objects
                }
                if (isset($sangerArr['error'])) {
                    $this->showErr("gRNA sequence <em>" .$seq . "</em>: " . $sangerArr['error'] . ". Upload aborted.");
                }

                $crisprString = '';
                foreach ($sangerArr as $crisprSeq) { //there can be multiple CRISPRs for a single gRNA sequence
                    $attr[$ii++] = [
                    "seq" => $crisprSeq['seq'],
                    "chr" => $crisprSeq['chr_name'],
                    "chr_start" => $crisprSeq['chr_start'],
                    "chr_end" => $crisprSeq['chr_end']
                    ];
                    $crisprString .= $crisprSeq['seq'].', ';
                }
                
                if (count($sangerArr) > 1) { // if more than one CRISPR per sequence, add an automatic CRISPR Design comment
                    $crisprString = rtrim($crisprString, ', ');
                    $row[10] .= "\n\nAutoComment: gRNA sequence {$seq} yielded multiple CRISPRs: {$crisprString}.";
                }
            }
            $row[] = $attr; //add attr info as the last column of to the current row
        }
        unset($row);
        return $this;
    }

    public function saveCrisprDesignAndProject() {
        $this->autoRender = false;
        $conn = ConnectionManager::get('default');
        $conn->transactional(function ($conn) {
            foreach ($this->parsedSheet as $row_no => $row) {
                if ($row_no == 0) { continue; } //skip first row (headers)

                // Save Project
                $projResult = $this->Project->saveProject([
                    'project_type_id' => $this->project_type_id,
                    'project_status_id' => $this->project_status_id,
                    'mutation_id' => $this->searchObjectKey($row[1], 'type', $this->mutations),
                    'phenotype_id' => $this->searchObjectKey($row[2], 'type', $this->phenotypes),
                    'comments' => $row[9],
                    "mgi_accession_ids" => [$row[11]  => $row[11]],
                    'batch_upload_uid' => $this->batchUploadId
                ]);
                if (!isset($projResult->id)) {
                    $this->showErr("Project for Gene name <em>{$row[0]}</em> could not be saved. Upload aborted.");
                }

                //Save a CRISPR Design
                $res = $this->add([
                    'project_id' => $projResult->id,
                    'nuclease' => $row[3],
                    'vector_name' => $row[4],
                    'comments' => $row[10],
                    'batch_upload_uid' => $this->batchUploadId
                ]);
                if (!isset($res->id)) {
                    $this->showErr("CRISPR Design for Gene name <em>{$row[0]}</em> could not be saved. Upload aborted.");
                }
                $crisprId = $res->id;
                
                //Save CRISPR Deisgn attributes
                $attributes = $row[12];
                foreach ($attributes as $attr) {
                    $crisprAttribute = $this->CrisprAttributes->newEntity();   
                    $crisprAttribute = $this->CrisprAttributes->patchEntity($crisprAttribute, [
                            'chr_end' => $attr['chr_end'],
                            'chr_start' => $attr['chr_start'],
                            'chromosome' => $attr['chr'],
                            'sequence' => $attr['seq'],
                            'crispr_design_id' => $crisprId,
                            'batch_upload_uid' => $this->batchUploadId
                    ]);
                    $res = $this->CrisprAttributes->save($crisprAttribute);
                    if (!isset($res->id)) {
                       $this->showErr("CRISPR Design Attributes for Gene name <em>{$row[0]}</em> could not be saved. Upload aborted.");
                    }
                }//end foreach attributes

            }//end foreach save
        }); //end transactional
        return $this;
    }

/* ************************************************************************ */

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if(!is_null($this->request->query("bulk_upload"))){
            $this->Flash->success("Bulk upload completed successfully!");   
        }
        $crisprDesigns = $this->CrisprDesigns->find('all')->contain(
            [
            'CrisprAttributes',
            'Projects'=>[
                'MgiGenesDump' => ['ImitsDumpMiPlans']
               ],
            ]
        )->toArray();

        //Inject project name into the array
        foreach ($crisprDesigns as &$cd) {
            $cd['project_name'] = $this->Project->getName($cd->project_id);
        }
        unset($cd);

        $this->set('crisprDesigns', $crisprDesigns);
        $this->set('_serialize', ['crisprDesigns']);
    }

    /**
     * View method
     *
     * @param string|null $id Crispr Design id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $crisprDesign = $this->CrisprDesigns->get($id, [
            'contain' => [
                'CrisprAttributes',
                'Projects'=>[
                    'MgiGenesDump' => ['ImitsDumpMiPlans']
                    ],
            ]]);
        $crisprDesign->project_name = $this->Project->getName($crisprDesign->project_id);
        $this->set('crisprDesign', $crisprDesign);
        $this->set('_serialize', ['crisprDesign']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($designData=null)
    {
        $crisprDesign = $this->CrisprDesigns->newEntity();
        if ($this->request->is('post') || $designData) {
            if ($designData) {
                $data = $designData;
            } else {
                $data = $this->request->data;
            }   
            
            $crisprDesign = $this->CrisprDesigns->patchEntity($crisprDesign, $data);
            if ($res = $this->CrisprDesigns->save($crisprDesign)) {
                if ($res->id) { //Save milestone for a project associated with that CRISPR Design
                    $this->Milestones->saveMilestone($data['project_id'], $this->project_status_id);
                }
                if ($designData) { //don't redirect if method was called directly
                    return $res;
                }                
                $this->Flash->warning(__('Your Crispr design is NOT READY yet. Scroll down the page and add attributes to your Crispr.'));
                return $this->redirect(['action' => 'view', $crisprDesign['id']]);
            } 
            else {
                $this->Flash->error(__('The crispr design could not be saved. Please, try again.'));
            }
        } //end if _POST
        
        //Prepare a list of projects with names to use in a dropdown
        $projects = [];
        foreach($this->CrisprDesigns->Projects->find('list') as $projectId=>$displayField) {
            $projects[$projectId] = $this->Project->getName($projectId);
        }
        $this->set(compact('crisprDesign', 'crisprAttributes', 'projects'));
        $this->set('_serialize', ['crisprDesign']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Crispr Design id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $crisprDesign = $this->CrisprDesigns->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $crisprDesign = $this->CrisprDesigns->patchEntity($crisprDesign, $this->request->data);
            if ($this->CrisprDesigns->save($crisprDesign)) {
                $this->Flash->success(__('The crispr design has been saved.'));
                return $this->redirect(['action' => 'view', $id]);
            } else {
                $this->Flash->error(__('The Crispr design could not be saved. Please, try again.'));
            }
        }
        //Prepare a list of projects with names to use in a dropdown
        $projects = [];
        foreach($this->CrisprDesigns->Projects->find('list') as $projectId=>$displayField) {
            $projects[$projectId] = $this->Project->getName($projectId);
        }
        $this->set(compact('crisprDesign', 'projects'));
        $this->set('_serialize', ['crisprDesign']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Crispr Design id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $crisprDesign = $this->CrisprDesigns->get($id);
        if ($this->CrisprDesigns->delete($crisprDesign)) {
            $this->Flash->success(__('The crispr design has been deleted.'));
        } else {
            $this->Flash->error(__('The crispr design could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



}