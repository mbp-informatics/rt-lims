<?php
namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use App\Controller\AppController;

/**
 * Ivfs Controller
 *
 * @property \App\Model\Table\IvfsTable $Ivfs
 */
class IvfsController extends AppController
{
 
    public $components = ['ChangeLog'];

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ($this->request->is('json')) {

            $contain = ['Jobs', 'IvfDishes'];
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'Ivfs', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'Ivfs', $contain);
            }

            // process the result set
            foreach ($resp['data'] as $k=>$ivf) {
                //Calculate IVF rate
                $resp['data'][$k]['fert_rate'] = '';
                if (!empty($resp['data'][$k]['ivf_dishes'])) {
                    $fertRate = 0; $two_cell_sum = 0; $one_cell_sum = 0;
                    foreach ($resp['data'][$k]['ivf_dishes'] as $dish) {
                        $two_cell_sum += $dish->two_cell_no;
                        $one_cell_sum += $dish->one_cell_no;
                    }
                    if ($two_cell_sum+$one_cell_sum !== 0) {
                        $fertRate = ($two_cell_sum/($two_cell_sum+$one_cell_sum))*100;
                    }
                    $resp['data'][$k]['fert_rate'] = ($fertRate !== 0) ? number_format($fertRate, 2).'%' : '';
                }

                $resp['data'][$k]['id_action'] = $ivf->id;
                $resp['data'][$k]['id'] = "<a href='/ivfs/view/{$ivf->id}' target='_blank'>{$ivf->id}</a>";
                if ($ivf->job) {
                    $resp['data'][$k]['stock_number'] = $ivf->job->mmrrc_no;
                } else {
                    $resp['data'][$k]['stock_number'] = '';
                }
                if ($ivf->job) {
                    $resp['data'][$k]['strain_name'] = $ivf->job->strain_name;
                } else {
                    $resp['data'][$k]['strain_name'] = '';
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
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Ivf id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null, $ajax=null)
    {
        $ivf = $this->Ivfs->get($id, [
            'contain' => ['Jobs', 'EmbryoCryos', 'IvfDishes', 'SpermCryos']
        ]);

        /* Get change log for this and associated tables */
        $parentModel = ['tableName' => 'Ivfs', 'id' => $id];
        $children = ['fk' => 'ivf_id', 'tables' => ['IvfDishes']];
        $changes = $this->ChangeLog->getAssocChangeLog($parentModel, $children);

        if ($ivf['job_id']) {
            $ivf['pi'] = $this->Ivfs->Jobs->getInvestigatorName($ivf['job_id']);
        }
        
        if ($ajax) { //dump data in JSON format
            $this->viewBuilder()->layout(''); //get rid of the layout (skip header, footer, navbar)
            $this->set('value', $ivf);
            $this->render('/Imits/dumpvalues');
        } else {
            $this->set('ivf', $ivf);
            $this->set('changes', $changes);
            $this->set('_serialize', ['ivf']);
        }
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($job_id=null)
    {
        $conn = ConnectionManager::get('default');
        $conn->transactional(function ($conn) use ($job_id) { //let's do all this as one transaction

        $ivf = $this->Ivfs->newEntity();
        if ($this->request->is('post')) {
            $ivf = $this->Ivfs->patchEntity($ivf, $this->request->data);
            if ($savedIvf = $this->Ivfs->save($ivf)) {

                /* Now let's save IVF Dishes... */
                //Prepare request object to use when saving entities
                $requestData = [];
                $i = 0;
                for($i; $i < 1; $i++ ) {
                    $requestData[] = [
                        // 'dish_no' => $i+1,
                        'ivf_id' => $savedIvf->id
                    ];
                }


                //Now save entities
                $ivfDishes = $this->loadModel('IvfDishes');
                $entities = $this->IvfDishes->newEntities($requestData);

                $ivfDishes->connection()->transactional(function () use ($ivfDishes, $entities) { //Treat saving all entities as single transaction
                    foreach ($entities as $ent) {
                        if(!$ivfDishes->save($ent) ) {
                             $this->Flash->error(__('IVF Dishes could not be saved. Please add them manually.'));
                        }
                    }
                });  

                $this->Flash->success(__('The IVF has been saved.'));
                return $this->redirect(['controller'=>'Ivfs', 'action' => 'view', $ivf->id]);
                // return $this->redirect(['action' => 'view', 'controller' => 'jobs', $job_id, '#' => 'related-data']);
            } else {
                $this->Flash->error(__('The IVF could not be saved. Please, try again.'));
            }
        }
        $jobs = $this->Ivfs->Jobs->find('list');
        $spermCryos = $this->Ivfs->SpermCryos->find('list');
        $this->set(compact('ivf', 'jobs', 'spermCryos', 'job_id'));
        $this->set('_serialize', ['ivf']);

        }); //end transactional closure
    }

    /**
     * Edit method
     *
     * @param string|null $id Ivf id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ivf = $this->Ivfs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ivf = $this->Ivfs->patchEntity($ivf, $this->request->data);
            if ($this->Ivfs->save($ivf)) {
                $this->Flash->success(__('The ivf has been saved.'));
                return $this->redirect(['action' => 'view', 'controller' => 'ivfs', '#' => 'related-data', $ivf->id]);
            } else {
                $this->Flash->error(__('The ivf could not be saved. Please, try again.'));
            }
        }
		$spermCryos = $this->Ivfs->SpermCryos->find('list');
        $jobs = $this->Ivfs->Jobs->find('list');
        $this->set(compact('ivf', 'jobs', 'spermCryos'));
        $this->set('_serialize', ['ivf']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ivf id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ivf = $this->Ivfs->get($id);
        if ($this->Ivfs->delete($ivf)) {
            $this->Flash->success(__('The ivf has been deleted.'));
        } else {
            $this->Flash->error(__('The ivf could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller'=> 'Jobs', 'action' => 'view', '#' => 'related-data', $ivf->job_id]);
    }
}
