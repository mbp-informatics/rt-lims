<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * QualityControls Controller
 *
 * @property \App\Model\Table\QualityControlsTable $QualityControls
 */
class QualityControlsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $this->set('qualityControls', $this->paginate($this->QualityControls));
        $this->set('_serialize', ['qualityControls']);
    }

    /**
     * View method
     *
     * @param string|null $id Quality Control id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qualityControlId = $id;

        $qualityControl = $this->QualityControls->get($id, [
            'contain' => ['Users', 'EsCells', 'QcKaryotypes', 'QcGermlines', 'QcGrowths', 'QcMicroinjections', 'QcPathogens',
            'QcCustomerInvivos', 'QcResequencings', 'QcTmks', 'QcCreflips', 'QcGenotypes']
        ]);
        $users = $this->QualityControls->Users->find('list');
        $this->set(compact('qualityControl', 'users', 'qualityControlId'));
        // $this->set('qualityControl', $qualityControl);
        $this->set('_serialize', ['qualityControl']);
    }

    /**
     * Add various QC tests to this Quality Control. 
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function requestTests()
    {
        if ($this->request->is('post')) {
            $makeQC = $this->request->data;
            unset($this->request->data['qcGeno']);
            unset($this->request->data['qcKaryo']);
            unset($this->request->data['qcGerm']);
            unset($this->request->data['qcGrowth']);
            unset($this->request->data['qcMicro']);
            unset($this->request->data['qcPath']);
            unset($this->request->data['qcInVivo']);
            unset($this->request->data['qcReseq']);
            unset($this->request->data['qcTmk']);
            unset($this->request->data['qcCre']);
            if (isset($makeQC['qcGeno'])) {
                $qcGenotypes = TableRegistry::get('QcGenotypes');
                $qcGeno = $this->QualityControls->QcGenotypes->newEntity();
                $qcGeno = $this->QualityControls->QcGenotypes->patchEntity($qcGeno, $this->request->data);
                $res = $qcGenotypes->save($qcGeno);
            }        
            if (isset($makeQC['qcKaryo'])) {
                $qcKaryotypes = TableRegistry::get('QcKaryotypes');
                $qcKaryo = $this->QualityControls->QcKaryotypes->newEntity();
                $qcKaryo = $this->QualityControls->QcKaryotypes->patchEntity($qcKaryo, $this->request->data);
                $res = $qcKaryotypes->save($qcKaryo);
            }    
            if (isset($makeQC['qcGerm'])) {
                $qcGermlines = TableRegistry::get('QcGermlines');
                $qcGerm = $this->QualityControls->QcGermlines->newEntity();
                $qcGerm = $this->QualityControls->QcGermlines->patchEntity($qcGerm, $this->request->data);
                $res = $qcGermlines->save($qcGerm);
            }  
            if (isset($makeQC['qcGrowth'])) {
                $qcGrowths = TableRegistry::get('QcGrowths');
                $qcGrowth = $this->QualityControls->QcGrowths->newEntity();
                $qcGrowth = $this->QualityControls->QcGrowths->patchEntity($qcGrowth, $this->request->data);
                $res = $qcGrowths->save($qcGrowth);
            }  
            if (isset($makeQC['qcMicro'])) {
                $qcMicroinjections = TableRegistry::get('QcMicroinjections');
                $qcMicro = $this->QualityControls->QcMicroinjections->newEntity();
                $qcMicro = $this->QualityControls->QcMicroinjections->patchEntity($qcMicro, $this->request->data);
                $res = $qcMicroinjections->save($qcMicro);
            }  
            if (isset($makeQC['qcPath'])) {
                $qcPathogens = TableRegistry::get('QcPathogens');
                $qcPath = $this->QualityControls->QcPathogens->newEntity();
                $qcPath = $this->QualityControls->QcPathogens->patchEntity($qcPath, $this->request->data);
                $res = $qcPathogens->save($qcPath);
            }  
            if (isset($makeQC['qcInVivo'])) {
                $qcCustomerInvivos = TableRegistry::get('QcCustomerInvivos');
                $qcInVivo = $this->QualityControls->QcCustomerInvivos->newEntity();
                $qcInVivo = $this->QualityControls->QcCustomerInvivos->patchEntity($qcInVivo, $this->request->data);
                $res = $qcCustomerInvivos->save($qcInVivo);
            }  
            if (isset($makeQC['qcReseq'])) {
                $qcResequencings = TableRegistry::get('QcResequencings');
                $qcReseq = $this->QualityControls->QcResequencings->newEntity();
                $qcReseq = $this->QualityControls->QcResequencings->patchEntity($qcReseq, $this->request->data);
                $res = $qcResequencings->save($qcReseq);
            } 
            if (isset($makeQC['qcTmk'])) {
                $qcTmks = TableRegistry::get('QcTmks');
                $qcTmk = $this->QualityControls->QcTmks->newEntity();
                $qcTmk = $this->QualityControls->QcTmks->patchEntity($qcTmk, $this->request->data);
                $res = $qcTmks->save($qcTmk);
            } 
            if (isset($makeQC['qcCre'])) {
                $qcCreflips = TableRegistry::get('QcCreflips');
                $qcCre = $this->QualityControls->QcCreflips->newEntity();
                $qcCre = $this->QualityControls->QcCreflips->patchEntity($qcCre, $this->request->data);
                $res = $qcCreflips->save($qcCre);
            } 
        return $this->redirect(['controller' => 'QualityControls', 'action' => 'view', $makeQC['quality_control_id']]);
        }
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($esId = Null)
    {
        $qualityControl = $this->QualityControls->newEntity();
        if ($this->request->is('post')) {
            $qualityControl = $this->QualityControls->patchEntity($qualityControl, $this->request->data);
            if ($this->QualityControls->save($qualityControl)) {
                $this->Flash->success(__('The quality control has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The quality control could not be saved. Please, try again.'));
            }
        }
        $esCells = $this->QualityControls->EsCells->find('list');
        $users = $this->QualityControls->Users->find('list');
        $this->set(compact('qualityControl', 'esCells', 'users', 'esId'));
        $this->set('_serialize', ['qualityControl']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Quality Control id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qualityControl = $this->QualityControls->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qualityControl = $this->QualityControls->patchEntity($qualityControl, $this->request->data);
            if ($this->QualityControls->save($qualityControl)) {
                $this->Flash->success(__('The quality control has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The quality control could not be saved. Please, try again.'));
            }
        }
        $esCells = $this->QualityControls->EsCells->find('list');
        $users = $this->QualityControls->Users->find('list', ['limit' => 200]);
        $this->set(compact('qualityControl', 'esCells', 'users'));
        $this->set('_serialize', ['qualityControl']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Quality Control id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qualityControl = $this->QualityControls->get($id);
        if ($this->QualityControls->delete($qualityControl)) {
            $this->Flash->success(__('The quality control has been deleted.'));
        } else {
            $this->Flash->error(__('The quality control could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
