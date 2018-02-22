<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MgiGenesDump Controller
 *
 * @property \App\Model\Table\MgiGenesDumpTable $MgiGenesDump
 */
class MgiGenesDumpController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($ajax=null)
    {
        if ($ajax) {
            $param = isset($this->request->query['s']) ? $this->request->query['s'] : null ;
            $mgiGenesDump = $this->MgiGenesDump->find('all')->where(['marker_symbol LIKE' => "%{$param}%"]);
            $this->set(compact('mgiGenesDump'));
            $this->set('searchPhrase', $param);
            $this->set('_serialize', ['mgiGenesDump']);
        } 

        //Prepare DataTables.js view
        if ($this->request->is('json') && !$ajax) {
            // Notices from time parser break json view, so let's mute them (yikes!);
            @$resp = $this->Search->getDataTablesResultSet($this->request, 'MgiGenesDump');
            //Highlight the search phrase
            if (!empty($this->request->query['search']['value'])) {
                $searchPhrase = $this->request->query['search']['value'];
            } elseif(!empty($this->request->data['search']['value'])) {
                $searchPhrase = $this->request->data['search']['value'];
            } else {
                $searchPhrase = null;
            }
            if (!empty($searchPhrase)) {
                $hlRow = [];
                foreach ( $resp['data'] as $k=>$row) {
                    foreach ($row->toArray() as $field=>$val) {
                        if ($field == 'mgi_accession_id') { //skip highlighting for mgi_accession_id field, because it contains a hyperlink
                            $resp['data'][$k][$field] = $val;
                            continue;
                        }
                        $resp['data'][$k][$field] = str_replace($searchPhrase, "<span class='hl'>{$searchPhrase}</span>", $val);
                    }
                }
            $row = (object) $hlRow;
            }

            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Mgi Genes Dump id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mgiGenesDump = $this->MgiGenesDump->get($id, [
            'contain' => ['Colonies', 'Projects'=>['Mutations', 'Phenotypes', 'ProjectStatuses', 'ProjectTypes'], 'ImitsDumpMiAttempts', 'ImitsDumpMiPlans', 'ImitsDumpPhenotypeAttempts', 'KompProjectsDump', 'GenesStatuses'=> ['GeneStatuses', 'Users']]
        ]);

        $this->set('mgiGenesDump', $mgiGenesDump);
        $this->set('_serialize', ['mgiGenesDump']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mgiGenesDump = $this->MgiGenesDump->newEntity();
        if ($this->request->is('post')) {
            $mgiGenesDump = $this->MgiGenesDump->patchEntity($mgiGenesDump, $this->request->data);
            if ($this->MgiGenesDump->save($mgiGenesDump)) {
                $this->Flash->success(__('The mgi genes dump has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mgi genes dump could not be saved. Please, try again.'));
        }
        $this->set(compact('mgiGenesDump'));
        $this->set('_serialize', ['mgiGenesDump']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Mgi Genes Dump id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mgiGenesDump = $this->MgiGenesDump->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mgiGenesDump = $this->MgiGenesDump->patchEntity($mgiGenesDump, $this->request->data);
            if ($this->MgiGenesDump->save($mgiGenesDump)) {
                $this->Flash->success(__('The mgi genes dump has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mgi genes dump could not be saved. Please, try again.'));
        }
        $this->set(compact('mgiGenesDump'));
        $this->set('_serialize', ['mgiGenesDump']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Mgi Genes Dump id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mgiGenesDump = $this->MgiGenesDump->get($id);
        if ($this->MgiGenesDump->delete($mgiGenesDump)) {
            $this->Flash->success(__('The mgi genes dump has been deleted.'));
        } else {
            $this->Flash->error(__('The mgi genes dump could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
