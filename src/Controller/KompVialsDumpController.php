<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager; //for truncate() method

/**
 * KompVialsDump Controller
 *
 * @property \App\Model\Table\KompVialsDumpTable $KompVialsDump
 */
class KompVialsDumpController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($ajax = null)
    {

        if ($ajax) { //dump data in JSON format
            $kompVialsDumps = $this->KompVialsDump->find('all');
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', json_encode($kompVialsDumps));
            $this->render('/Imits/dumpvalues');
        }

        //Prepare DataTables.js view
        if ($this->request->is('json') && !$ajax) {
            // Notices from time parser break json view, so let's mute them (yikes!);
            @$resp = $this->Search->getDataTablesResultSet($this->request, 'KompVialsDump');
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
                        if ($field == 'mgi_accession_id' || $field == 'komp_vial_id') { //skip highlighting for mgi_accession_id field, because it contains a hyperlink
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
    
    public function truncate()
    {
        $conn = ConnectionManager::get('default');
        $conn->execute('TRUNCATE komp_vials_dump');
    }

    /**
     * View method
     *
     * @param string|null $id Komp Vials Dump id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kompVialsDump = $this->KompVialsDump->get($id, [
            'contain' => ['KompvialsJobs' => ['Jobs']]
        ]);

        $this->set('kompVialsDump', $kompVialsDump);
        $this->set('_serialize', ['kompVialsDump']);
    }

    /**
     * Find Vial Method method
     *
     * @param string|null $id Komp Vials Dump id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function findVial($markerSymbol=null) {
        if ($markerSymbol) {
            $kompVialsDump = $this->KompVialsDump->find('all')->where(['gene LIKE' => "%{$markerSymbol}%"]);

            $this->set(compact('kompVialsDump'));
            $this->set('_serialize', ['kompVialsDump']);
        }
     }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kompVialsDump = $this->KompVialsDump->newEntity();
        if ($this->request->is('post')) {
            $kompVialsDump = $this->KompVialsDump->patchEntity($kompVialsDump, $this->request->data);
            if ($this->KompVialsDump->save($kompVialsDump)) {
                $this->Flash->success(__('The komp vials dump has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The komp vials dump could not be saved. Please, try again.'));
        }
        $this->set(compact('kompVialsDump'));
        $this->set('_serialize', ['kompVialsDump']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Komp Vials Dump id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kompVialsDump = $this->KompVialsDump->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kompVialsDump = $this->KompVialsDump->patchEntity($kompVialsDump, $this->request->data);
            if ($this->KompVialsDump->save($kompVialsDump)) {
                $this->Flash->success(__('The komp vials dump has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The komp vials dump could not be saved. Please, try again.'));
        }
        $this->set(compact('kompVialsDump'));
        $this->set('_serialize', ['kompVialsDump']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Komp Vials Dump id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kompVialsDump = $this->KompVialsDump->get($id);
        if ($this->KompVialsDump->delete($kompVialsDump)) {
            $this->Flash->success(__('The komp vials dump has been deleted.'));
        } else {
            $this->Flash->error(__('The komp vials dump could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
