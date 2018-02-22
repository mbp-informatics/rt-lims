<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager; //for truncate() method

/**
 * ImitsDumpMiPlans Controller
 *
 * @property \App\Model\Table\ImitsDumpMiPlansTable $ImitsDumpMiPlans
 */
class ImitsDumpMiPlansController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $imitsDumpMiPlans = $this->ImitsDumpMiPlans->find('all');
        $this->set('imitsDumpMiPlans', $imitsDumpMiPlans);
        $this->set('_serialize', ['imitsDumpMiPlans']);
    }

    public function truncate()
    {
        $conn = ConnectionManager::get('default');
        $conn->execute('TRUNCATE imits_dump_mi_plans');
    }

    /**
     * View method
     *
     * @param string|null $id Imits Dump Mi Plan id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $imitsDumpMiPlan = $this->ImitsDumpMiPlans->get($id, [
            'contain' => []
        ]);

        $this->set('imitsDumpMiPlan', $imitsDumpMiPlan);
        $this->set('_serialize', ['imitsDumpMiPlan']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $imitsDumpMiPlan = $this->ImitsDumpMiPlans->newEntity();
        if ($this->request->is('post')) {
            $imitsDumpMiPlan = $this->ImitsDumpMiPlans->patchEntity($imitsDumpMiPlan, $this->request->data);
            if ($this->ImitsDumpMiPlans->save($imitsDumpMiPlan)) {
                $this->Flash->success(__('The imits dump mi plan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The imits dump mi plan could not be saved. Please, try again.'));
        }
        $this->set(compact('imitsDumpMiPlan'));
        $this->set('_serialize', ['imitsDumpMiPlan']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Imits Dump Mi Plan id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $imitsDumpMiPlan = $this->ImitsDumpMiPlans->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $imitsDumpMiPlan = $this->ImitsDumpMiPlans->patchEntity($imitsDumpMiPlan, $this->request->data);
            if ($this->ImitsDumpMiPlans->save($imitsDumpMiPlan)) {
                $this->Flash->success(__('The imits dump mi plan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The imits dump mi plan could not be saved. Please, try again.'));
        }
        $this->set(compact('imitsDumpMiPlan'));
        $this->set('_serialize', ['imitsDumpMiPlan']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Imits Dump Mi Plan id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $imitsDumpMiPlan = $this->ImitsDumpMiPlans->get($id);
        if ($this->ImitsDumpMiPlans->delete($imitsDumpMiPlan)) {
            $this->Flash->success(__('The imits dump mi plan has been deleted.'));
        } else {
            $this->Flash->error(__('The imits dump mi plan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
