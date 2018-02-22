<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * GenesStatuses Controller
 *
 * @property \App\Model\Table\GenesStatusesTable $GenesStatuses
 */
class GenesStatusesController extends AppController
{

    public $projectTypes = [2 =>'MBP', 6 => 'KOMP2' ];   

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($mgiAccessionId=null)
    {
        $genesStatuses = $this->GenesStatuses->find('all')->contain(['MgiGenesDump', 'Users', 'GeneStatuses']);
        
        if (isset($mgiAccessionId)) {
            $genesStatuses->where(['GenesStatuses.mgi_accession_id = ' => $mgiAccessionId]);
        }

        $this->set(compact('genesStatuses', 'mgiAccessionId'));
        $this->set('_serialize', ['genesStatuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Genes Status id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $genesStatus = $this->GenesStatuses->get($id, [
            'contain' => []
        ]);

        $this->set('genesStatus', $genesStatus);
        $this->set('_serialize', ['genesStatus']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($mgiAccessionId=null)
    {
        $genesStatus = $this->GenesStatuses->newEntity();
        if ($this->request->is('post')) {
            $conn = ConnectionManager::get('default');
            $conn->transactional(function ($conn) use ($genesStatus) {
                $genesStatus = $this->GenesStatuses->patchEntity($genesStatus, $this->request->data);
                if ($this->GenesStatuses->save($genesStatus)) {
                    if ($this->request->data['gene_status_id'] == '2') { //"selected" status
                        $this->loadModel('ProjectTypesGenes');
                        foreach ($this->projectTypes as $projectTypeId => $projName) {
                            $projectTypeGene = $this->ProjectTypesGenes->newEntity();
                            $projectTypeGene = $this->ProjectTypesGenes->patchEntity($projectTypeGene, [
                                    'mgi_accession_id' => $this->request->data['mgi_accession_id'],
                                    'project_type_id' => $projectTypeId
                            ]);
                            if (!$this->ProjectTypesGenes->save($projectTypeGene)) {
                                throw new \Exception("Rolling back the transaction. The genes status could not be saved. Please, try again.");                
                            }
                        }
                    }
                    $this->Flash->success(__('The genes status has been saved.'));
                    if (isset($_GET['redir'])) {
                        return $this->redirect(['controller' => $_GET['redir'], 'action' => 'index']);    
                    }
                    return $this->redirect(['action' => 'index']);
                }
                throw new \Exception("Rolling back the transaction. The genes status could not be saved. Please, try again.");
                $this->Flash->error(__('The genes status could not be saved. Please, try again.'));
            });
        }
        $geneStatuses = $this->GenesStatuses->GeneStatuses->find('list');
        $mgiAccessionId = isset($mgiAccessionId) ? $mgiAccessionId : null;
        $this->set(compact('genesStatuses', 'geneStatuses', 'genesStatus', 'mgiAccessionId'));
        $this->set('_serialize', ['genesStatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Genes Status id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $genesStatus = $this->GenesStatuses->get($id, [
            'contain' => ['MgiGenesDump']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $conn = ConnectionManager::get('default');
            $conn->transactional(function ($conn) use ($genesStatus) {
                $genesStatus = $this->GenesStatuses->patchEntity($genesStatus, $this->request->data);
                $mgiAccessionId = $this->request->data['mgi_accession_id'];
                if ($this->GenesStatuses->save($genesStatus)) {
                        $geneStatusId = $this->request->data['gene_status_id'];
                        $this->loadModel('ProjectTypesGenes');
                        if ($geneStatusId == '2') { //"selected" status
                            foreach ($this->projectTypes as $projectTypeId => $projName) {
                                $projectTypeGene = $this->ProjectTypesGenes->newEntity();
                                $projectTypeGene = $this->ProjectTypesGenes->patchEntity($projectTypeGene, [
                                        'mgi_accession_id' => $mgiAccessionId,
                                        'project_type_id' => $projectTypeId
                                ]);
                                if (!$this->ProjectTypesGenes->save($projectTypeGene)) {
                                    throw new \Exception("Rolling back the transaction. The genes status could not be saved. Please, try again.");                
                                }
                            }
                        } else {
                            $this->ProjectTypesGenes->deleteAll(['mgi_accession_id = ' => $mgiAccessionId]);
                        }
                    $this->Flash->success(__('The genes status has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                throw new \Exception("Rolling back the transaction. The genes status could not be saved. Please, try again.");
                $this->Flash->error(__('The genes status could not be saved. Please, try again.'));
            });
        }
        $geneStatuses = $this->GenesStatuses->GeneStatuses->find('list');
        $this->set(compact('genesStatuses', 'geneStatuses', 'genesStatus'));
        $this->set('_serialize', ['genesStatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Genes Status id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $genesStatus = $this->GenesStatuses->get($id);
        if ($this->GenesStatuses->delete($genesStatus)) {
            $this->Flash->success(__('The genes status has been deleted.'));
        } else {
            $this->Flash->error(__('The genes status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
